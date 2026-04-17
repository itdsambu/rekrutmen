<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Controller untuk Form Pengajuan Perubahan MPP
 * URL: /perubahanmpp
 */

require_once APPPATH . 'core/BaseController.php';

class Perubahanmpp extends BaseController
{
    protected function loadingmodel()
    {
        $this->load->model('M_perubahanmpp');
        $this->load->model('M_grupDept');
        $this->load->model('M_user_login');
        $this->load->model('M_user_login');
    }

    /**
     * Halaman utama - List semua pengajuan
     */
    public function index()
    {
        $cssadd = array(
            'sweetalert.css',
            'bootstrap-select.min.css',
            'addcss/buttons.bootstrap.min.css',
            'addcss/fixdb.css'
        );

        // print_r($this->session->userdata());
        // die;

        $data['cssadd'] = $cssadd;
        $data['getDivisi'] = $this->M_perubahanmpp->getDivisi();
        $data['getDept'] = $this->M_perubahanmpp->getDept();

        // print_r($this->session->userdata());
        // die;

        $this->template->display('transaksi/perubahanmpp/index', $data);
    }

    /**
     * Form input pengajuan baru
     */
    public function create()
    {
        $cssadd = array(
            'sweetalert.css',
            'bootstrap-select.min.css',
            'addcss/buttons.bootstrap.min.css',
            'addcss/fixdb.css'
        );
        $data['dept'] = $this->session->userdata('dept');

        $data['cssadd']        = $cssadd;
        $data['getDivisi']     = $this->M_perubahanmpp->getDivisi($data['dept']);
        $data['getDept']       = $this->M_user_login->getDept();
        $data['getSubDept']    = $this->M_perubahanmpp->getSubDept();
        $data['getJabatan']    = $this->M_perubahanmpp->getJabatan();
        $data['getSubJabatan'] = $this->M_perubahanmpp->getSubJabatan();
        // $data['getLevelJabatan'] = $this->M_perubahanmpp->getLevelJabatan();
        // print_r($data['getSubDept']);
        // exit;

        $this->template->display('transaksi/perubahanmpp/create', $data);
    }

    /**
     * Simpan data pengajuan
     */
    public function store()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('Direct access not allowed', 403);
            return;
        }

        $tipePerubahan = $this->input->post('tipe_perubahan');
        $userId = $this->session->userdata('userid');

        if (empty($tipePerubahan)) {
            echo json_encode(['Err' => 1, 'Msg' => 'Tipe perubahan harus dipilih']);
            return;
        }

        // Data header form
        $dataHeader = array(
            'Divisi' => $this->input->post('divisi'),
            'Departemen' => $this->input->post('departemen'),
            'SubDepartemen' => $this->input->post('sub_departemen'),
            'Jabatan' => $this->input->post('jabatan'),
            'SubJabatan' => $this->input->post('sub_jabatan'),
            'TipePerubahan' => $tipePerubahan,
            'StatusJabatan' => $this->input->post('status_jabatan'),
            'JumlahSebelum' => $this->input->post('jumlah_sebelum'),
            'JumlahSesudah' => $this->input->post('jumlah_sesudah'),
            'SifatPerubahan' => $this->input->post('sifat_perubahan'),
            'LatarBelakang' => $this->input->post('latar_belakang'),
            'ProyeksiDampak' => $this->input->post('proyeksi_dampak'),
            'StrukturOrganisasi' => $this->input->post('struktur_organisasi'),
            'KualifikasiPendidikan' => $this->input->post('kualifikasi_pendidikan'),
            'KualifikasiPengalaman' => $this->input->post('kualifikasi_pengalaman'),
            'KualifikasiManajerial' => $this->input->post('kualifikasi_manajerial'),
            'KualifikasiKompetensi' => $this->input->post('kualifikasi_kompetensi'),
            'KualifikasiSertifikasi' => $this->input->post('kualifikasi_sertifikasi'),
            'KualifikasiLainnya' => $this->input->post('kualifikasi_lainnya'),
            'CreatedBy' => $userId,
            'CreatedDate' => date('Y-m-d H:i:s'),
            'Status' => 0
        );

        $this->db->trans_start();

        $headerId = $this->M_perubahanmpp->insertHeader($dataHeader);

        if (!$headerId) {
            $this->db->trans_rollback();
            echo json_encode(['Err' => 1, 'Msg' => 'Gagal menyimpan data header']);
            return;
        }

        // Insert Lampiran A jika tipe 1 atau 3
        if ($tipePerubahan == '1' || $tipePerubahan == '3') {
            $dataLampiranA = array(
                'HeaderID' => $headerId,
                'TipeLampiran' => 'A',
                'NamaSubJabatan' => $this->input->post('lampiran_a_nama_sub_jabatan'),
                'LevelJabatan' => $this->input->post('lampiran_a_level_jabatan'),
                'PengisiSubJabatan' => $this->input->post('lampiran_a_pengisi'),
                'Catatan' => $this->input->post('lampiran_a_catatan'),
                'TugasTanggungJawab' => $this->input->post('lampiran_a_tugas'),
                'Wewenang' => $this->input->post('lampiran_a_wewenang'),
                'TargetKerja' => $this->input->post('lampiran_a_target_kerja'),
                'HubunganAtasanBawahan' => $this->input->post('lampiran_a_hub_atasan_bawahan'),
                'HubunganInternal' => $this->input->post('lampiran_a_hub_internal'),
                'HubunganEksternal' => $this->input->post('lampiran_a_hub_eksternal'),
                'CreatedBy' => $userId,
                'CreatedDate' => date('Y-m-d H:i:s')
            );
            $this->M_perubahanmpp->insertDetail($dataLampiranA);
        }

        // Insert Lampiran B jika tipe 2 atau 3
        if ($tipePerubahan == '2' || $tipePerubahan == '3') {
            $dataLampiranB = array(
                'HeaderID' => $headerId,
                'TipeLampiran' => 'B',
                'NamaSubJabatan' => $this->input->post('lampiran_b_nama_sub_jabatan'),
                'LevelJabatan' => $this->input->post('lampiran_b_level_jabatan'),
                'PengisiSubJabatan' => $this->input->post('lampiran_b_pengisi'),
                'Catatan' => $this->input->post('lampiran_b_catatan'),
                'TugasTanggungJawab' => $this->input->post('lampiran_b_tugas'),
                'Wewenang' => $this->input->post('lampiran_b_wewenang'),
                'Koordinasi' => $this->input->post('lampiran_b_koordinasi'),
                'Pelaporan' => $this->input->post('lampiran_b_pelaporan'),
                'CreatedBy' => $userId,
                'CreatedDate' => date('Y-m-d H:i:s')
            );
            $this->M_perubahanmpp->insertDetail($dataLampiranB);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['Err' => 1, 'Msg' => 'Terjadi kesalahan saat menyimpan data']);
        } else {
            echo json_encode(['Err' => 0, 'Msg' => 'Data berhasil disimpan', 'ID' => $headerId]);
        }
    }

    /**
     * DataTables server-side
     */
    public function show()
    {
        if ($this->input->is_ajax_request()) {
            $list = $this->M_perubahanmpp->get_datatables();
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $field) {
                $no++;

                $statusBadge = '';
                switch ($field->Status) {
                    case 0:
                        $statusBadge = '<span class="label label-default">Draft</span>';
                        break;
                    case 1:
                        $statusBadge = '<span class="label label-success">Submitted</span>';
                        break;
                    case 2:
                        $statusBadge = '<span class="label label-success">Approved by Dept</span>';
                        break;
                    case 3:
                        $statusBadge = '<span class="label label-success">Approved by Divisi</span>';
                        break;
                    case 4:
                        $statusBadge = '<span class="label label-success">Approved by HRD</span>';
                        break;
                    case 5:
                        $statusBadge = '<span class="label label-danger">Rejected</span>';
                        break;
                    case 6:
                        $statusBadge = '<span class="label label-warning">Pending</span>';
                        break;
                }

                if ($this->input->post('filter_status') == '6') {
                    $statusBadge = '<span class="label label-warning">Pending</span>';
                }


                $tipeLabel = '';
                switch ($field->TipePerubahan) {
                    case 1:
                        $tipeLabel = 'Jabatan Baru';
                        break;
                    case 2:
                        $tipeLabel = 'Jabatan Lama';
                        break;
                    case 3:
                        $tipeLabel = 'Baru & Lama';
                        break;
                }

                $badgeApp1 = 'test';
                if ($field->AppStatus == '' || $field->AppStatus == null) {
                    $badgeApp1 = '<span class="label label-warning">Pending</span>';
                } elseif ($field->AppStatus == 1) {
                    $badgeApp1 = '<span class="label label-success">Approved</span>';
                } elseif ($field->AppStatus == 2) {
                    $badgeApp1 = '<span class="label label-danger">Disapprove</span>';
                }

                $badgeApp2 = '';
                if ($field->AppStatus2 == '' || $field->AppStatus2 == null) {
                    $badgeApp2 = '<span class="label label-warning">Pending</span>';
                } elseif ($field->AppStatus2 == 1) {
                    $badgeApp2 = '<span class="label label-success">Approved</span>';
                } elseif ($field->AppStatus2 == 2) {
                    $badgeApp2 = '<span class="label label-danger">Disapprove</span>';
                }

                $badgeApp3 = '';
                if ($field->AppStatus3 == '' || $field->AppStatus3 == null) {
                    $badgeApp3 = '<span class="label label-warning">Pending</span>';
                } elseif ($field->AppStatus3 == 1) {
                    $badgeApp3 = '<span class="label label-success">Approved</span>';
                } elseif ($field->AppStatus3 == 2) {
                    $badgeApp3 = '<span class="label label-danger">Disapprove</span>';
                }

                $opsi = '<div class="btn-group">';
                $opsi .= '<a href="' . base_url('perubahanmpp/detail/' . encode_str($field->ID)) . '" class="btn btn-info btn-xs" target="_blank"  title="Detail"><i class="fa fa-eye"></i></a>';

                $opsi .= '<a href="' . base_url('perubahanmpp/exporttoPdf/' . encode_str($field->ID)) . '" class="btn btn-danger btn-xs" target="_blank" title="Export"><i class="fa fa-file"></i></a>';

                if ($field->Status == 0) {
                    $opsi .= '<a href="' . base_url('perubahanmpp/edit/' . encode_str($field->ID)) . '" class="btn btn-warning btn-xs" title="Edit"><i class="fa fa-edit"></i></a>';
                    $opsi .= '<button type="button" onclick="deleteData(\'' . encode_str($field->ID) . '\')" class="btn btn-danger btn-xs" title="Hapus"><i class="fa fa-trash"></i></button>';
                }
                $opsi .= '</div>';

                $row = array();
                $row[] = $no;
                $row[] = $opsi;
                $row[] = $field->NoPengajuan;
                $row[] = $field->Divisi;
                $row[] = $field->Departemen;
                $row[] = $field->Jabatan;
                $row[] = $tipeLabel;
                $row[] = $field->SifatPerubahan;
                $row[] = $statusBadge;
                $row[] = $badgeApp1;
                $row[] = $badgeApp2;
                $row[] = $badgeApp3;
                $row[] = date('d-m-Y', strtotime($field->CreatedDate));
                $row[] = $field->CreatedBy;

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->M_perubahanmpp->count_all(),
                "recordsFiltered" => $this->M_perubahanmpp->count_filtered(),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    /**
     * Detail pengajuan
     */
    public function detail($id = null)
    {
        if ($id == null) {
            redirect('perubahanmpp');
            return;
        }

        $decodedId = decode_str($id);
        $header = $this->M_perubahanmpp->getHeaderById($decodedId);

        if (!$header) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('perubahanmpp');
            return;
        }

        $cssadd = array('sweetalert.css', 'addcss/fixdb.css');

        $data['cssadd'] = $cssadd;
        $data['header'] = $header;
        $data['lampiranA'] = $this->M_perubahanmpp->getDetailByHeaderId($decodedId, 'A');
        $data['lampiranB'] = $this->M_perubahanmpp->getDetailByHeaderId($decodedId, 'B');

        $this->template->display('transaksi/perubahanmpp/detail', $data);
    }

    /**
     * Edit pengajuan
     */
    public function edit($id = null)
    {
        if ($id == null) {
            redirect('perubahanmpp');
            return;
        }

        $decodedId = decode_str($id);
        $header = $this->M_perubahanmpp->getHeaderById($decodedId);

        if (!$header || $header->Status != 0) {
            $this->session->set_flashdata('error', 'Data tidak dapat diedit');
            redirect('perubahanmpp');
            return;
        }

        $cssadd = array('sweetalert.css', 'bootstrap-select.min.css', 'addcss/fixdb.css');

        $data['cssadd'] = $cssadd;
        $data['header'] = $header;
        $data['lampiranA'] = $this->M_perubahanmpp->getDetailByHeaderId($decodedId, 'A');
        $data['lampiranB'] = $this->M_perubahanmpp->getDetailByHeaderId($decodedId, 'B');
        $data['getDivisi'] = $this->M_perubahanmpp->getDivisi();
        $data['getDept'] = $this->M_perubahanmpp->getDept();
        $data['getSubDept']    = $this->M_perubahanmpp->getSubDept();
        // $data['getLevelJabatan'] = $this->M_perubahanmpp->getLevelJabatan();

        $this->template->display('transaksi/perubahanmpp/edit', $data);
    }

    /**
     * Update data
     */
    public function update()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('Direct access not allowed', 403);
            return;
        }

        $id = $this->input->post('id');
        $tipePerubahan = $this->input->post('tipe_perubahan');
        $userId = $this->session->userdata('userid');

        if (empty($id) || empty($tipePerubahan)) {
            echo json_encode(['Err' => 1, 'Msg' => 'Data tidak valid']);
            return;
        }

        $dataHeader = array(
            'Divisi' => $this->input->post('divisi'),
            'Departemen' => $this->input->post('departemen'),
            'SubDepartemen' => $this->input->post('sub_departemen'),
            'Jabatan' => $this->input->post('jabatan'),
            'SubJabatan' => $this->input->post('sub_jabatan'),
            'TipePerubahan' => $tipePerubahan,
            'StatusJabatan' => $this->input->post('status_jabatan'),
            'JumlahSebelum' => $this->input->post('jumlah_sebelum'),
            'JumlahSesudah' => $this->input->post('jumlah_sesudah'),
            'SifatPerubahan' => $this->input->post('sifat_perubahan'),
            'LatarBelakang' => $this->input->post('latar_belakang'),
            'ProyeksiDampak' => $this->input->post('proyeksi_dampak'),
            'StrukturOrganisasi' => $this->input->post('struktur_organisasi'),
            'KualifikasiPendidikan' => $this->input->post('kualifikasi_pendidikan'),
            'KualifikasiPengalaman' => $this->input->post('kualifikasi_pengalaman'),
            'KualifikasiManajerial' => $this->input->post('kualifikasi_manajerial'),
            'KualifikasiKompetensi' => $this->input->post('kualifikasi_kompetensi'),
            'KualifikasiSertifikasi' => $this->input->post('kualifikasi_sertifikasi'),
            'KualifikasiLainnya' => $this->input->post('kualifikasi_lainnya'),
            'UpdatedBy' => $userId,
            'UpdatedDate' => date('Y-m-d H:i:s')
        );

        $this->db->trans_start();
        $this->M_perubahanmpp->updateHeader($id, $dataHeader);
        $this->M_perubahanmpp->deleteDetailByHeaderId($id);

        if ($tipePerubahan == '1' || $tipePerubahan == '3') {
            $dataLampiranA = array(
                'HeaderID' => $id,
                'TipeLampiran' => 'A',
                'NamaSubJabatan' => $this->input->post('lampiran_a_nama_sub_jabatan'),
                'LevelJabatan' => $this->input->post('lampiran_a_level_jabatan'),
                'PengisiSubJabatan' => $this->input->post('lampiran_a_pengisi'),
                'Catatan' => $this->input->post('lampiran_a_catatan'),
                'TugasTanggungJawab' => $this->input->post('lampiran_a_tugas'),
                'Wewenang' => $this->input->post('lampiran_a_wewenang'),
                'TargetKerja' => $this->input->post('lampiran_a_target_kerja'),
                'HubunganAtasanBawahan' => $this->input->post('lampiran_a_hub_atasan_bawahan'),
                'HubunganInternal' => $this->input->post('lampiran_a_hub_internal'),
                'HubunganEksternal' => $this->input->post('lampiran_a_hub_eksternal'),
                'CreatedBy' => $userId,
                'CreatedDate' => date('Y-m-d H:i:s')
            );
            $this->M_perubahanmpp->insertDetail($dataLampiranA);
        }

        if ($tipePerubahan == '2' || $tipePerubahan == '3') {
            $dataLampiranB = array(
                'HeaderID' => $id,
                'TipeLampiran' => 'B',
                'NamaSubJabatan' => $this->input->post('lampiran_b_nama_sub_jabatan'),
                'LevelJabatan' => $this->input->post('lampiran_b_level_jabatan'),
                'PengisiSubJabatan' => $this->input->post('lampiran_b_pengisi'),
                'Catatan' => $this->input->post('lampiran_b_catatan'),
                'TugasTanggungJawab' => $this->input->post('lampiran_b_tugas'),
                'Wewenang' => $this->input->post('lampiran_b_wewenang'),
                'Koordinasi' => $this->input->post('lampiran_b_koordinasi'),
                'Pelaporan' => $this->input->post('lampiran_b_pelaporan'),
                'CreatedBy' => $userId,
                'CreatedDate' => date('Y-m-d H:i:s')
            );
            $this->M_perubahanmpp->insertDetail($dataLampiranB);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['Err' => 1, 'Msg' => 'Terjadi kesalahan saat update data']);
        } else {
            echo json_encode(['Err' => 0, 'Msg' => 'Data berhasil diupdate']);
        }
    }

    /**
     * Hapus pengajuan
     */
    public function delete()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('Direct access not allowed', 403);
            return;
        }

        $id = decode_str($this->input->post('id'));
        $header = $this->M_perubahanmpp->getHeaderById($id);

        if (!$header || $header->Status != 0) {
            echo json_encode(['Err' => 1, 'Msg' => 'Data tidak dapat dihapus']);
            return;
        }

        $this->db->trans_start();
        $this->M_perubahanmpp->deleteDetailByHeaderId($id);
        $this->M_perubahanmpp->deleteHeader($id);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['Err' => 1, 'Msg' => 'Gagal menghapus data']);
        } else {
            echo json_encode(['Err' => 0, 'Msg' => 'Data berhasil dihapus']);
        }
    }

    /**
     * Submit untuk approval
     */
    public function submit()
    {
        if (!$this->input->is_ajax_request()) {
            show_error('Direct access not allowed', 403);
            return;
        }

        $id = decode_str($this->input->post('id'));
        $userId = $this->session->userdata('userid');

        $header = $this->M_perubahanmpp->getHeaderById($id);
        if (!$header || $header->Status != 0) {
            echo json_encode(['Err' => 1, 'Msg' => 'Data tidak dapat disubmit']);
            return;
        }

        $result = $this->M_perubahanmpp->updateStatus($id, 1, $userId);

        if ($result) {
            echo json_encode(['Err' => 0, 'Msg' => 'Data berhasil disubmit']);
        } else {
            echo json_encode(['Err' => 1, 'Msg' => 'Gagal submit data']);
        }
    }

    // function exporttoPdf($id)
    // {
    //     ob_start();
    //     if ($id == null) {
    //         redirect('perubahanmpp');
    //         return;
    //     }

    //     $decodedId = decode_str($id);
    //     $header = $this->M_perubahanmpp->getHeaderById($decodedId);

    //     if (!$header) {
    //         $this->session->set_flashdata('error', 'Data tidak ditemukan');
    //         redirect('perubahanmpp');
    //         return;
    //     }

    //     $cssadd = array('sweetalert.css', 'addcss/fixdb.css');

    //     $data['cssadd'] = $cssadd;
    //     $data['header'] = $header;
    //     $data['lampiranA'] = $this->M_perubahanmpp->getDetailByHeaderId($decodedId, 'A');
    //     $data['lampiranB'] = $this->M_perubahanmpp->getDetailByHeaderId($decodedId, 'B');

    //     // $this->load->view('monitor/interview/print/SuratMandiri', $data);
    //     $this->load->view('transaksi/perubahanmpp/exportpdf', $data);
    //     $html    = ob_get_contents();
    //     ob_end_clean();

    //     require_once('./assets/html2pdf/html2pdf.class.php'); // ini dimatikan 
    //     // require_once FCPATH . 'vendor/autoload.php';
    //     // require_once FCPATH . 'vendor/autoload.php';
    //     $pdf    = new HTML2PDF('P', 'A4', 'en');
    //     // $pdf = new TCPDF('P', 'mm', 'A4'); // FIX DI SINI
    //     $pdf->writeHTML($html);

    //     $pdf->Output('Perubahan MPP.pdf');

    //     // require_once FCPATH . 'vendor/autoload.php';

    //     // $pdf = new TCPDF('P', 'mm', 'A4'); // FIX DI SINI

    //     // $pdf->AddPage();
    //     // $pdf->writeHTML($html);
    //     // $pdf->Output('Perubahan MPP.pdf');
    // }



    // function exporttoPdf($id)
    // {
    //     if ($id == null) {
    //         redirect('perubahanmpp');
    //         return;
    //     }

    //     $decodedId = decode_str($id);
    //     $header    = $this->M_perubahanmpp->getHeaderById($decodedId);

    //     if (!$header) {
    //         $this->session->set_flashdata('error', 'Data tidak ditemukan');
    //         redirect('perubahanmpp');
    //         return;
    //     }

    //     $data['header']    = $header;
    //     $data['lampiranA'] = $this->M_perubahanmpp->getDetailByHeaderId($decodedId, 'A');
    //     $data['lampiranB'] = $this->M_perubahanmpp->getDetailByHeaderId($decodedId, 'B');

    //     // ---------------------------------------------------------------
    //     // Render HTML tiap halaman secara terpisah
    //     // ---------------------------------------------------------------

    //     // Halaman Utama
    //     ob_start();
    //     $this->load->view('transaksi/perubahanmpp/exportpdf_main', $data);
    //     $htmlMain = ob_get_clean();

    //     // Lampiran A
    //     $htmlLampiranA = null;
    //     if ($data['lampiranA']) {
    //         ob_start();
    //         $this->load->view('transaksi/perubahanmpp/exportpdf_lampiran_a', $data);
    //         $htmlLampiranA = ob_get_clean();
    //     }

    //     // Lampiran B
    //     $htmlLampiranB = null;
    //     if ($data['lampiranB']) {
    //         ob_start();
    //         $this->load->view('transaksi/perubahanmpp/exportpdf_lampiran_b', $data);
    //         $htmlLampiranB = ob_get_clean();
    //     }

    //     // ---------------------------------------------------------------
    //     // Generate PDF dengan TCPDF
    //     // ---------------------------------------------------------------
    //     require_once FCPATH . 'vendor/autoload.php';

    //     // Inisialisasi TCPDF
    //     $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

    //     // Matikan header & footer default bawaan TCPDF
    //     $pdf->setPrintHeader(false);
    //     $pdf->setPrintFooter(false);

    //     // Setting margin: top, right, bottom, left (dalam mm)
    //     $pdf->SetMargins(10, 8, 10);
    //     $pdf->SetAutoPageBreak(true, 12);

    //     // Font default
    //     $pdf->SetFont('helvetica', '', 9);

    //     // -------
    //     // Halaman 1: Form Utama
    //     // -------
    //     $pdf->AddPage();
    //     $pdf->writeHTML($htmlMain, true, false, true, false, '');

    //     // -------
    //     // Halaman 2: Lampiran A (jika ada)
    //     // -------
    //     if ($htmlLampiranA) {
    //         $pdf->AddPage();
    //         $pdf->writeHTML($htmlLampiranA, true, false, true, false, '');
    //     }

    //     // -------
    //     // Halaman 3: Lampiran B (jika ada)
    //     // -------
    //     if ($htmlLampiranB) {
    //         $pdf->AddPage();
    //         $pdf->writeHTML($htmlLampiranB, true, false, true, false, '');
    //     }

    //     // Output PDF ke browser (inline preview)
    //     // Ganti 'I' ke 'D' jika ingin langsung download
    //     $pdf->Output('Perubahan_MPP.pdf', 'I');
    //     exit;
    // }



    function exporttoPdf($id)
    {
        if ($id == null) {
            redirect('perubahanmpp');
            return;
        }

        $decodedId = decode_str($id);
        $header    = $this->M_perubahanmpp->getHeaderById($decodedId);

        if (!$header) {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect('perubahanmpp');
            return;
        }

        $data['header']    = $header;
        $data['lampiranA'] = $this->M_perubahanmpp->getDetailByHeaderId($decodedId, 'A');
        $data['lampiranB'] = $this->M_perubahanmpp->getDetailByHeaderId($decodedId, 'B');

        // Render HTML dari view
        ob_start();
        $this->load->view('transaksi/perubahanmpp/exportpdf', $data);
        $html = ob_get_clean();

        // Generate PDF dengan mPDF
        require_once FCPATH . 'vendor/autoload.php';

        // Tentukan folder temp yang bisa ditulis
        // Opsi 1: pakai folder writable CodeIgniter (paling aman)
        $tempDir = APPPATH . 'cache/mpdf/';

        // Buat folder jika belum ada
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode'              => 'utf-8',
            'format'            => 'A4',
            'orientation'       => 'P',
            'margin_top'        => 8,
            'margin_bottom'     => 12,
            'margin_left'       => 10,
            'margin_right'      => 10,
            'margin_header'     => 0,
            'margin_footer'     => 0,
            'default_font'      => 'arial',
            'default_font_size' => 9,
            // Arahkan semua folder temp ke sini
            'tempDir'           => $tempDir,
        ]);

        $mpdf->WriteHTML($html);

        // Output ke browser (inline preview)
        // Ganti 'inline' ke 'attachment' jika ingin langsung download
        $mpdf->Output('Perubahan_MPP.pdf', \Mpdf\Output\Destination::INLINE);
        exit;
    }
}
