<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Blacklist extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('darurat', 'm_blacklist'));
        $this->load->helper('path');
        //        $status = 1;
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }
        $this->load->library(array('template', 'form_validation'));
    }

    //================= START KARYAWAN =================

    function saveK()
    {
        $cek = $this->db->query("SELECT * FROM tblTrnBlacklist WHERE Nama ='" . $this->input->post('txtnama') . "' AND NIK='" . $this->input->post('txtFindBynik') . "'")->num_rows();
        if ($cek <= 0) {
            $data = array(
                'Nama'  => $this->input->post('txtnama'),
                'NIK'            => strtolower($this->input->post('txtFindBynik')),
                'NoKTP'          => $this->input->post('txtnoktp'),
                'TglLahir'       => date('Y-m-d', strtotime($this->input->post('txttgllahir'))),
                'CVNama'         => $this->input->post('txtperusahaan'),
                'Pemborong'      => $this->input->post('txtpemborong'),
                'DeptAbbr'       => $this->input->post('txtdept'),
                'TglMasuk'       => date('Y-m-d', strtotime($this->input->post('txttglmasuk'))),
                'TglKeluar'      => date('Y-m-d', strtotime($this->input->post('txttglkeluar'))),
                'NamaIbuKandung' => $this->input->post('txtnmibukandung'),
                'Remark'         => $this->input->post('txtketerangan'),
                'created_by'     => strtoupper($this->session->userdata('username')),
                'created_date'   => date('Y-m-d H:i:s'),
                'status'         => 'Blacklist',
                'IDPT'           => 'P1'
            );
            $NIK = array('NIK' => strtolower($this->input->post('txtFindBynik')));
            $this->load->model('m_blacklist');
            // $this->m_blacklist->saveDetail($NIK);
            $result = $this->m_blacklist->save($data);

            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    Data Berhasil di Tambah...!!!
                </div>');
            redirect('blacklist/listkaryawan?msg=success_add', 'refresh');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Mohon Maaf NIK sudah Terdaftar...!!!
                    </div>');
            redirect('blacklist/listkaryawan?msg=failed_add', 'refresh');
        }
    }

    function ajaxblacklistK($nik)
    {
        $data['_getData']   = $this->m_blacklist->getDataBlacklistK($nik);
        $data['_cekData']   = $this->m_blacklist->getDataBlacklistK($nik);
        $this->load->view('registrasi/blacklist/ajaxblacklistK', $data);
    }

    function Karyawan()
    {
        // $this->db->model('m_blacklist');
        // $data['_getKaryawan'] = $this->m_blacklist->getkaryawan();
        $this->template->display('registrasi/blacklist/karyawan');
    }

    function listkaryawan()
    {
        $this->load->model('m_blacklist');
        $data['getBlacklistK'] = $this->m_blacklist->selectBlacklistK();
        $this->template->display('monitor/blacklist/karyawan/index', $data);
    }

    function detailK()
    {
        if ('IS_AJAX') {
            $kode = $this->input->post('kode');
            $data['data'] = $this->m_blacklist->get_karyawan($kode)->result();
            $this->load->view('monitor/blacklist/karyawan/detail', $data);
        }
    }


    //================= END KARYAWAN =================

    //================= START TENAGA KERJA =================

    function saveTK()
    {
        $cek = $this->db->query("SELECT * FROM tblTrnBlacklist WHERE NIK='" . $this->input->post('txtFindBynik') . "'")->num_rows();
        if ($cek <= 0) {
            $data = array(
                'Nama'  => $this->input->post('txtnama'),
                'NIK'            => strtolower($this->input->post('txtFindBynik')),
                'NoKTP'          => $this->input->post('txtnoktp'),
                'TglLahir'       => date('Y-m-d', strtotime($this->input->post('txttgllahir'))),
                'CVNama'         => $this->input->post('txtperusahaan'),
                'Pemborong'      => $this->input->post('txtpemborong'),
                'DeptAbbr'       => $this->input->post('txtdept'),
                'TglMasuk'       => date('Y-m-d', strtotime($this->input->post('txttglmasuk'))),
                'TglKeluar'      => date('Y-m-d', strtotime($this->input->post('txttglkeluar'))),
                'NamaIbuKandung' => $this->input->post('txtnmibukandung'),
                'Remark'         => $this->input->post('txtketerangan'),
                'created_by'     => strtoupper($this->session->userdata('username')),
                'created_date'   => date('Y-m-d H:i:s'),
                'status'         => 'Blacklist',
                'IDPT'           => 'P1'
            );
            $NIK = array('NIK' => strtolower($this->input->post('txtFindBynik')));
            $this->load->model('m_blacklist');
            // $this->m_blacklist->saveDetail($NIK);
            $result = $this->m_blacklist->save($data);

            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    Data Berhasil di Tambah...!!!
                </div>');
            redirect('blacklist/listtenaker?msg=success_add', 'refresh');
        } else {
            $this->session->set_flashdata(
                'message',
                '<div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                        Mohon Maaf NIK sudah Terdaftar...!!!
                    </div>'
            );
            redirect('blacklist/listtenaker?msg=failed_add', 'refresh');
        }
    }

    function ajaxblacklistTK($nik)
    {
        $data['_getData']   = $this->m_blacklist->getDataBlacklistTK($nik);
        $data['_cekData']   = $this->m_blacklist->getDataBlacklistTK($nik);
        $this->load->view('registrasi/blacklist/ajaxblacklistTK', $data);
    }

    function TenagaKerja()
    {
        // $this->db->model('m_blacklist');
        // $data['_getKaryawan'] = $this->m_blacklist->getkaryawan();
        $this->template->display('registrasi/blacklist/TenagaKerja');
    }

    function listtenaker()
    {
        $this->load->model('m_blacklist');
        $data['getBlacklistTK'] = $this->m_blacklist->selectBlacklistTK();
        $this->template->display('monitor/blacklist/tenaker/index', $data);
    }
    function listTenakerCancel()
    {
        // print_r($this->session->userdata());
        // die;
        $this->load->model('m_blacklist');
        $data['getBlacklistTK'] = $this->m_blacklist->selectBlacklistTenakerCancel();
        $this->template->display('monitor/blacklist/tenaker/listTenakerCancel', $data);
    }

    function detailTK()
    {
        if ('IS_AJAX') {
            $kode = $this->input->post('kode');
            $data['data'] = $this->m_blacklist->get_tenaker($kode)->result();
            $this->load->view('monitor/blacklist/tenaker/detail', $data);
        }
    }
    function detailTKCancel()
    {
        if ('IS_AJAX') {
            $kode = $this->input->post('kode');
            $data['data'] = $this->m_blacklist->get_tenaker_cancel($kode)->result();

            $this->load->view('monitor/blacklist/tenaker/detail_cancel', $data);
        }
    }

    //================= END TENAGA KERJA =================

    //================= START BY PASS =================

    function blacklistbypass()
    {
        $this->template->display('registrasi/blacklist/blacklistbypass');
    }

    function savebypass()
    {
        $data = array(
            'Nama'           => $this->input->post('txtnama'),
            'Tgl_Lahir'      => date('Y-m-d', strtotime($this->input->post('txttgllahir'))),
            'Daerah_Asal'    => $this->input->post('txtdaerahasal'),
            'Suku'           => $this->input->post('txtsuku'),
            'Nama_Ibu'       => $this->input->post('txtnmibukandung'),
            'Keterangan'     => $this->input->post('txtketerangan'),
            'Keterangan'     => $this->input->post('txtketerangan'),
            'created_By'     => strtoupper($this->session->userdata('username')),
            'created_Date'   => date('Y-m-d H:i:s'),
            'Status'         => 'BlacklistByPass',
            'IDPT'           => 'P1'
        );
        $this->load->model('m_blacklist');
        $result = $this->m_blacklist->savebypass($data);

        $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    Data Berhasil di Tambah...!!!
                </div>');
        redirect('blacklist/listBlacklistbypass?msg=success_add', 'refresh');
    }

    function listBlacklistByPass()
    {
        $this->load->model('m_blacklist');
        $data['getBlacklistByPass'] = $this->m_blacklist->selectBlacklistByPass();
        $this->template->display('monitor/blacklist/bypass/index', $data);
    }

    function detailByPass()
    {
        if ('IS_AJAX') {
            $kode = $this->input->post('kode');
            $data['data'] = $this->m_blacklist->get_detailbypass($kode)->result();
            $this->load->view('monitor/blacklist/bypass/detail', $data);
        }
    }

    //================= END BY PASS =================
    //================= START Upload Photo =================
    function doEditFoto()
    {
        $id = $this->input->get('id');
        $nama = $this->input->get('nama');
        $this->session->set_flashdata("id", $id);
        $this->session->set_flashdata("nama", $nama);

        redirect('blacklist/uploadPhoto');
    }

    function uploadPhoto()
    {
        $id     = $this->session->flashdata("id");
        $nama   = $this->session->flashdata("nama");

        $this->session->keep_flashdata("id");
        $this->session->keep_flashdata("nama");

        $data['id'] = $id;
        $data['nama'] = $nama;
        $data['errormsg'] = "";

        $this->template->display('monitor/blacklist/bypass/upload_foto', $data);
    }

    function uploadAksi()
    {
        $this->load->model('m_register');
        $this->load->library('image_moo');

        $url = './dataupload/bypass/';
        $id = $this->input->post("txtDetail");
        $nama = $this->input->post("txtNama");
        $filefoto = $id;

        $config['upload_path']      = $url;
        $config['allowed_types']    = 'jpeg|jpg|png|gif';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['max_size']         = '0';
        $config['file_name']        = $filefoto . '.jpg'; //Filename harus pakai headerID pelamar

        $this->load->library('upload');
        $this->upload->initialize($config);

        if ($this->upload->do_upload('fileFoto1') == "") {
            $file = $this->upload->do_upload('fileFoto2');
        } else {
            $file = $this->upload->do_upload('fileFoto1');
        }
        if ($file) {
            $files = $this->upload->data();
            $fileNameResize = $config['upload_path'] . $files['file_name'];

            $this->image_moo
                ->load($fileNameResize)
                ->resize(300, 300)
                ->round(10)
                ->save($fileNameResize, true);
            if ($this->image_moo->errors) {
                $error = $files['file_name'] . "<br/>" . $this->image_moo->display_errors();
                $data['errormsg'] = "<div class='alert alert-danger'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Image Moo Failed</strong><br/>$error</div>";
                $data['id'] = $id;
                $data['nama'] = $nama;

                $this->template->display('monitor/blacklist/bypass/upload_foto', $data);
            } else {
                $this->m_blacklist->update_status_foto($id);
                $this->image_moo->clear();
                $this->session->set_flashdata("id", $id);
                $this->session->set_flashdata("nama", $nama);

                //                redirect("registrasi/uploadFoto/success");
                //jika success, redirect ke Upload berkas
                redirect("blacklist/listBlacklistByPass");
            }
        } else {
            $error = $this->upload->display_errors();
            $data['errormsg'] = "<div class='alert alert-danger'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Unggah Foto Gagal</strong><br/>$error</div>";
            $data['id'] = $id;
            $data['nama'] = $nama;

            $this->template->display('monitor/blacklist/bypass/upload_foto', $data);
        }

        $this->image_moo->clear();
    }
    //================= END Upload Photo =================

    function listrsup()
    {
        $this->load->model('m_blacklist');
        $data['getBlacklistKRSUP'] = $this->m_blacklist->selectBlacklistKRSUP();
        $data['getBlacklistTKRSUP'] = $this->m_blacklist->selectBlacklistTKRSUP();
        $this->template->display('monitor/blacklist/rsup/index', $data);
    }

    function detailKRSUP()
    {
        if ('IS_AJAX') {
            $kode = $this->input->post('kode');
            $data['data'] = $this->m_blacklist->get_detailKRSUP($kode)->result();
            $this->load->view('monitor/blacklist/rsup/detailK', $data);
        }
    }

    function detailTKRSUP()
    {
        if ('IS_AJAX') {
            $kode = $this->input->post('kode');
            $data['data'] = $this->m_blacklist->get_detailTKRSUP($kode)->result();
            $this->load->view('monitor/blacklist/rsup/detailTK', $data);
        }
    }

    function duabulan()
    {
        $this->load->model('m_blacklist');
        $data['blok_dua_bulan'] = $this->m_blacklist->blok_dua_bulan();
        $this->template->display('monitor/blacklist/tenaker/blok-dua-bulan', $data);
    }

    //Filter Data
    function filterdatalistrsup()
    {
        $nama = $this->input->post('txtNama');
        $this->load->model('m_blacklist');

        $data['getBlacklistKRSUP'] = $this->m_blacklist->filterselectBlacklistKRSUP($nama);
        $data['getBlacklistTKRSUP'] = $this->m_blacklist->filterselectBlacklistTKRSUP($nama);

        $this->template->display('monitor/blacklist/rsup/index', $data);
    }

    function filterdatalistkaryawan()
    {
        $nama = $this->input->post('txtNama');
        $this->load->model('m_blacklist');

        $data['getBlacklistK'] = $this->m_blacklist->filterselectBlacklistK($nama);
        $this->template->display('monitor/blacklist/karyawan/index', $data);
    }

    function filterdatalisttenaker()
    {
        $nama = $this->input->post('txtNama');
        $this->load->model('m_blacklist');

        $data['getBlacklistTK'] = $this->m_blacklist->filterselectBlacklistTK($nama);
        $this->template->display('monitor/blacklist/tenaker/index', $data);
    }

    function filterdatalistBlacklistByPass()
    {
        $nama = $this->input->post('txtNama');
        $this->load->model('m_blacklist');

        $data['getBlacklistByPass'] = $this->m_blacklist->filterselectBlacklistByPass($nama);
        $this->template->display('monitor/blacklist/bypass/index', $data);
    }

    function updateStatusCancel()
    {
        // Start transaction
        $nik = $this->input->post('id');
        if ($this->m_blacklist->updateStatusCancel($nik) == 1) {
            $res = [
                'status' => 200
            ];
        } else {
            $res = [
                'status' => 400
            ];
        }

        echo json_encode($res);
    }

    /**
     *  ################################################################## Module Salmonella Carrier ##################################################################
     * 
     */

    function salmonella_carrier()
    {
        $this->template->display('monitor/blacklist/salmonella_carrier/index');
    }


    public function show()
    {

        if ($this->input->is_ajax_request()) {

            $list = $this->m_blacklist->get_datatables('tblTrnSalmonellaCarrier');
            $data = array();
            $no   = $_POST['start'];
            foreach ($list as $field) {



                if ($field->Jenis_kelamin == 'M' || $field->Jenis_kelamin == 'LAKI-LAKI') {
                    $gender = 'Laki-laki';
                } elseif ($field->Jenis_kelamin == 'F' || $field->Jenis_kelamin == 'PEREMPUAN') {
                    $gender = 'Perempuan';
                } else {
                    $gender = '';
                }

                $no++;
                $row   = array();

                $row[] = $field->HeaderID;
                $row[] = $field->Nama;
                $row[] = $field->No_Ktp;
                $row[] = date('d-m-Y', strtotime($field->Tgl_Lahir));
                $row[] = $gender;
                $row[] = $field->Nama_Ibu;
                $row[] = $field->CV_Nama;
                $row[] = $field->Pemborong;
                $row[] = $field->Sub_Pemborong;
                $row[] = $field->Keterangan;
                $row[] = '<button class="cancel btn btn-minier btn-round btn-warning" data-id="' . $field->HeaderID . '"><i class="ace-icon fa fa-sign-out bigger-100"></i>Keluarkan Dari Blacklist</button>';
                $data[] = $row;
            }

            $output = array(
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->m_blacklist->count_all('tblTrnSalmonellaCarrier'),
                "recordsFiltered" => $this->m_blacklist->count_filtered('tblTrnSalmonellaCarrier'),
                "data"            => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }

    function getTenaker()
    {
        $headerid = $this->input->post('id');
        $data = $this->m_blacklist->getTenaker($headerid);

        if ($data) {
            $res = [
                'status' => 200,
                'data' => $data
            ];
        } else {
            $res = [
                'status' => 400
            ];
        }

        echo json_encode($res);
    }

    function saveSalmonellaCarrier()
    {
        $HeaderID         = $this->input->post('iheaderid');
        $Nama             = $this->input->post('inama');
        $NoKtp            = $this->input->post('iktp');
        $Tgl_lahir        = $this->input->post('itgl_lahir');
        $CV_Nama          = $this->input->post('icv_nama');
        $Pemborong        = $this->input->post('ipemborong');
        $Sub_Pemborong    = $this->input->post('isub_pemborong');
        $Nama_Ibu         = $this->input->post('inama_ibu');
        $Daerah_Asal      = $this->input->post('idaerah_asal');
        $Suku             = $this->input->post('isuku');
        $ID_Pemborong     = $this->input->post('iid_pemborong');
        $ID_Sub_Pemborong = $this->input->post('iid_sub_pemborong');
        $keterangan       = $this->input->post('iketerangan');
        $jenis_kelamin    = $this->input->post('ijenis_kelamin');

        $checkNik = $this->m_blacklist->checkNik($HeaderID);

        if ($checkNik > 0) {

            $res = [
                'status' => 400,
                'message' => 'NIK sudah ada'
            ];
            echo json_encode($res);
            return;
        }

        $dataInsert = array(
            'HeaderID'         => $HeaderID,
            'Nama'             => $Nama,
            'No_Ktp'           => $NoKtp,
            'Tgl_Lahir'        => date('Y-m-d', strtotime($Tgl_lahir)),
            'CV_Nama'          => $CV_Nama,
            'Pemborong'        => $Pemborong,
            'Sub_Pemborong'    => $Sub_Pemborong,
            'Nama_Ibu'         => $Nama_Ibu,
            'Daerah_Asal'      => $Daerah_Asal,
            'Suku'             => $Suku,
            'Id_Pemborong'     => $ID_Pemborong,
            'Id_Sub_Pemborong' => $ID_Sub_Pemborong,
            'Id_Sub_Pemborong' => $ID_Sub_Pemborong,
            'Keterangan'       => $keterangan,
            'Jenis_kelamin'    => $jenis_kelamin,
            'Status_Blacklist' => 1,
            'Created_By'       => strtoupper($this->session->userdata('username')),
            'Created_Date'     => date('Y-m-d H: i: s'),
            'notif'            => 1,
        );

        $insertStatus = $this->m_blacklist->saveSalmonellaCarrier($dataInsert);

        $updateStatus = false;
        if ($insertStatus) {
            $updateData = array(
                'sCarrierStatus'      => 1,
                'sCarrierCreatedBy'   => strtoupper($this->session->userdata('username')),
                'sCarrierCreateAt' => date('Y-m-d H: i: s'),
                'sCarrierKet'         => $keterangan
            );

            $updateStatus = $this->m_blacklist->updateSalmonellaCarrier($HeaderID, $updateData);
        }

        if ($insertStatus && $updateStatus) {
            $res = [
                'status' => 200,
                'message' => 'Data berhasil disimpan'
            ];
        } else {
            $res = [
                'status' => 400,
                'message' => 'Data gagal disimpan'
            ];
        }

        echo json_encode($res);
    }

    function updateSalmonellaCarrier()
    {
        $HeaderID         = $this->input->post('id');

        $updateData = array(
            'Status_Blacklist' => 0,
            'Update_By'        => strtoupper($this->session->userdata('username')),
            'Update_Date'      => date('Y-m-d H: i: s')
        );

        $updateStatus = $this->m_blacklist->deleteSalmonellaCarrier($HeaderID, $updateData);
        if ($updateStatus) {
            $updateDataB = array(
                'sCarrierStatus'   => 0,
                'sCarrierUpdateBy' => strtoupper($this->session->userdata('username')),
                'sCarrierUpdateAt' => date('Y-m-d H: i: s')
            );

            $q =  $this->m_blacklist->deleteSalmonellaCarrier_b($HeaderID, $updateDataB);
        }

        if ($updateStatus && $q) {
            $res = [
                'status' => 200,
                'message' => 'Data berhasil dikeluarkan'
            ];
        } else {
            $res = [
                'status' => 400,
                'message' => 'Data gagal dikeluarkan'
            ];
        }

        echo json_encode($res);
    }

    function updateNotif()
    {
        $HeaderID = $this->input->post('id');

        $data = $this->m_blacklist->updateNotif($HeaderID);

        if ($data) {
            $res = [
                'status' => 200,
                'message' => 'Data berhasil dikeluarkan'
            ];
        } else {
            $res = [
                'status' => 400,
                'message' => 'Data gagal dikeluarkan'
            ];
        }

        echo json_encode($res);
    }

    public function search_nama()
    {
        $term = $this->input->post('term');
        $results = $this->m_blacklist->get_suggestions($term);


        $data = [];
        foreach ($results as $row) {
            $data[] = [
                'label'            => $row->Nama,
                'value'            => $row->Nama,
                'nama'             => $row->Nama,
                'headerid'         => $row->HeaderID,
                'tgl_lahir'        => date('d-m-Y', strtotime($row->Tgl_Lahir)),
                'pemborong'        => $row->Pemborong,
                'perusahaan'       => $row->CVNama,
                'nama_ibu'         => $row->NamaIbuKandung,
                'sub_pemborong'    => $row->SubPemborong,
                'no_ktp'           => $row->No_Ktp,
                'daerah_asal'      => $row->Daerah_Asal,
                'suku'             => $row->Suku,
                'id_pemborong'     => $row->IDPemborong,
                'id_sub_pemborong' => $row->IDSubPemborong,
                'jenis_kelamin'    => $row->Jenis_Kelamin,
            ];
        }

        echo json_encode($data);
    }
}
