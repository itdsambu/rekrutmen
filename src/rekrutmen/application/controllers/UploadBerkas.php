<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : Ismo
 */

class UploadBerkas extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('darurat');
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }
        $this->load->helper(array('url', 'form'));
        $this->load->model(array('m_register', 'm_upload_berkas', 'm_screening'));
        $this->load->library(array('template', 'form_validation'));
    }

    function index()
    {
        $hdrid                = $this->session->flashdata("regid");
        //redirect("uploadBerkas/listTKforUploadDoc");; 
        $hdrid                = $this->session->flashdata("regid");
        $nama                 = $this->session->flashdata("regnama");
        $this->session->keep_flashdata("regid");
        $this->session->keep_flashdata("regnama");
        $data['groupuser']    = $this->session->userdata('groupuser');

        $data['hdrid'] = $hdrid;
        $data['namapelamar'] = $nama;
        $data['errormsg'] = "";

        $data['databerkas'] = $this->m_upload_berkas->get_db_berkas($hdrid)->result();
        $data['minimalberkas'] = $this->m_upload_berkas->minimal_berkas($hdrid);

        $this->template->display('registrasi/upload_berkas/index', $data);
    }

    function uploadarea()
    {
        $tipe                   = $this->input->post("tipe");
        $data["hdrid"]          = $this->input->post("hdrid");
        $data["namapelamar"]    = $this->input->post("nama");
        $data['errormsg']       = "";

        switch ($tipe) {
            case 'ktp':
                $namaberkas = "KTP";
                break;
            case 'cv':
                $namaberkas = "Daftar Riwayat Hidup";
                break;
            case 'lamaran':
                $namaberkas = "Surat Lamaran";
                break;
            case 'ijazah':
                $namaberkas = "Ijazah";
                break;
            case 'transkrip':
                $namaberkas = "Transkrip Nilai";
                break;
            case 'SuratKontrak':
                $namaberkas = "Surat Perjanjian Kontrak";
                break;
            case 'Vaksin1':
                // $namaberkas = "Sertifikat Vaksin 1";
                $namaberkas = "Berkas Pendukung";
                break;
            case 'Vaksin2':
                $namaberkas = "Sertifikat Vaksin 2";
                break;
            case 'Vaksin3':
                $namaberkas = "Sertifikat Vaksin 3";
                break;
            case 'KK':
                $namaberkas = "Kartu Keluarga";
                break;
            case 'SKCK':
                $namaberkas = "Surat Keterangan Catatan Kepolisian";
                break;

            default:
                $this->template->display('registrasi/upload_berkas/index', $data);
                break;
        }

        $data['jenisberkas']    = $tipe;
        $data['namaberkas']     = $namaberkas;
        if ($tipe === "ktp") {
            $this->load->view('registrasi/upload_berkas/formKTP', $data);
        } else {
            $this->load->view('registrasi/upload_berkas/formUpload', $data);
        }
    }

    function do_upload($berkas)
    {
        switch ($berkas) {
            case "ktp":
                $url = './dataupload/berkas/ktp';
                $namaberkas = "KTP";
                break;
            case "cv":
                $url = './dataupload/berkas/cv';
                $namaberkas = "Daftar Riwayat Hidup";
                break;
            case "lamaran":
                $url = './dataupload/berkas/lamaran';
                $namaberkas = "Surat Lamaran";
                break;
            case "ijazah":
                $url = './dataupload/berkas/ijazah';
                $namaberkas = "Ijazah";
                break;
            case "transkrip":
                $url = './dataupload/berkas/transkrip';
                $namaberkas = "Transkrip Nilai";
                break;
            case "SuratKontrak":
                $url = './dataupload/berkas/spk';
                $namaberkas = "Surat Perjanjian Kontrak";
                break;
            case "Vaksin1":
                $url = './dataupload/berkas';
                // $namaberkas = "Sertifikat Vaksin 1";
                $namaberkas = "Berkas Pendukung";
                $renamedBerkas = "berkas_pendukung";
                break;
            case "Vaksin2":
                $url = './dataupload/berkas';
                $namaberkas = "Sertifikat Vaksin 2";
                break;
            case "Vaksin3":
                $url = './dataupload/berkas';
                $namaberkas = "Sertifikat Vaksin 3";
                break;
            case "KK":
                $url = './dataupload/berkas';
                $namaberkas = "KK";
                break;
            case "SKCK":
                $url = './dataupload/berkas';
                $namaberkas = "SKCK";
                break;
            default:
                $url = './dataupload/berkas';
                $namaberkas = "Lain-Lain";
                break;
        }

        $hdrid = $this->input->post("txthdrid");
        $namapelamar = $this->input->post("txtnamapelamar");
        $namafile = $hdrid . '_' . ($berkas == 'Vaksin1' ? $renamedBerkas : $berkas);

        $data['namapelamar']        = $namapelamar;
        $config['upload_path']      = $url;
        $config['allowed_types']    = 'pdf';
        $config['allow_scale_up']   = true;
        $config['overwrite']        = true;
        $config['file_name']        = $namafile;
        $config['max_size']         = '10240';

        $this->load->library('upload');
        // echo "URL: $url<br>";
        // echo "Realpath: " . realpath($url) . "<br>";
        // echo "Is dir: " . (is_dir($url) ? 'YES' : 'NO') . "<br>";
        // echo "Writable: " . (is_writable($url) ? 'YES' : 'NO') . "<br>";
        // exit;
        $this->upload->initialize($config);

        if ($this->upload->do_upload('txtfile')) {
            $this->upload->data();
            $data['errormsg'] = "<div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Berhasil</strong></div>";
            $this->m_upload_berkas->update_db_berkas($hdrid, $berkas, $url . '/' . $namafile . '.pdf');
        } else {
            $error = $this->upload->display_errors();
            $data['errormsg'] = "<div class='alert alert-danger'><a class='close' data-dismiss='alert'><i class='fa fa-times'>&nbsp;</i></a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Berkas $namaberkas Gagal</strong><br/>$error</div>";
        }

        $data['databerkas']     = $this->m_upload_berkas->get_db_berkas($hdrid)->result();
        $data['minimalberkas']  = $this->m_upload_berkas->minimal_berkas($hdrid);
        $data['hdrid']  = $hdrid;
        if ($berkas == 'SuratKontrak') {
            $this->template->display('registrasi/upload_berkas/uploadSPK', $data);
        } else {
            $this->template->display('registrasi/upload_berkas/index', $data);
        }
    }

    function selesai($hdrid)
    {
        $data['message'] = "<div class='alert alert-success'><a class='close' data-dismiss='alert'>×</a><i class='fa fa-info-circle'>&nbsp;</i><strong>Simpan Data dan Foto Berhasil</strong></div>";
        $data['hdrid'] = $hdrid;
        $data['filefoto'] = "foto/" . $hdrid;
        $data['datatk'] = $this->m_register->get_tenagakerja($hdrid)->result();

        $this->template->display('registrasi/register/hasil', $data);
    }

    function listTKforUploadDoc__()
    {
        $dept           = $this->session->userdata("groupuser");
        $segment        = $this->uri->segment(3);
        $filter_status  = $this->uri->segment(4);
        $idpemborong    = $this->session->userdata('idpemborong');
        // var_dump($idpemborong); die;
        if ($segment == 1) {
            $data['_selected']  = 1;
            $data['_filter_selected']  = $filter_status;
            $data['hidden_pemborong'] = $idpemborong;
            $data['getListTK'] = $this->m_upload_berkas->getTenakerUploadSPK($idpemborong, $filter_status);
            // die;
        } else {
            $data['_selected']  = 0;
            $data['_filter_selected']  = $filter_status;
            $data['hidden_pemborong'] = $idpemborong;
            $data['getListTK'] = $this->m_upload_berkas->getListTK($idpemborong, $filter_status);
            // die;
        }

        if ($this->session->userdata('userid') == 'kiki' || $this->session->userdata('userid') == 'KIKI') {

            $this->template->display('registrasi/upload_berkas/uploadBerkas_dev', $data);
        } else {
            $this->template->display('registrasi/upload_berkas/uploadBerkas', $data);
        }
    }

    function listTKforUploadDoc()
    {
        $idpemborong    = $this->session->userdata('idpemborong');
        $data['hidden_pemborong'] = $idpemborong;
        $this->template->display('registrasi/upload_berkas/uploadBerkas', $data);
    }

    function doEditBerkas()
    {
        $hdrid  = $this->input->get('id');
        $nama   = $this->input->get('nama');
        $this->session->set_flashdata("regid", $hdrid);
        $this->session->set_flashdata("regnama", $nama);

        redirect('UploadBerkas/index');
    }

    function doUploadSPK()
    {
        $hdrid  = $this->input->get('id');
        $nama   = $this->input->get('nama');
        $this->session->set_flashdata("regid", $hdrid);
        $this->session->set_flashdata("regnama", $nama);

        redirect('UploadBerkas/viewUploadSPK');
    }
    function viewUploadSPK()
    {
        $hdrid    = $this->session->flashdata("regid");
        $nama     = $this->session->flashdata("regnama");
        $this->session->keep_flashdata("regid");
        $this->session->keep_flashdata("regnama");

        $data['hdrid'] = $hdrid;
        $data['namapelamar'] = $nama;
        $data['errormsg'] = "";
        $data['databerkas'] = $this->m_upload_berkas->get_db_berkas($hdrid)->result();
        $data['minimalberkas'] = $this->m_upload_berkas->minimal_berkas($hdrid);

        $this->template->display('registrasi/upload_berkas/uploadSPK', $data);
    }

    function doEditFoto()
    {
        $hdrid  = $this->input->get('id');
        $nama   = $this->input->get('nama');
        $this->session->set_flashdata("regid", $hdrid);
        $this->session->set_flashdata("regnama", $nama);

        redirect('registrasi/uploadFoto');
    }


    // ========= List Tenaga KErja
    function detailtk()
    {
        if ('IS_AJAX') {
            $kode = $this->input->post('kode');
            $data['datatk'] = $this->m_upload_berkas->get_detailtk($kode)->result();
            $data['resultScreen'] = $this->m_screening->resultScreen($kode)->result();
            $this->load->view('registrasi/upload_berkas/detail', $data);
        }
    }


    public function show_upload_berkas()
    {

        if ($this->input->is_ajax_request()) {
            $idpemborong = $this->session->userdata('idpemborong');
            // $idpemborong = 13;
            $list = $this->m_upload_berkas->get_datatables_upload_berkas();
            $data = array();
            $no   = $_POST['start'];
            foreach ($list as $field) {

                if ($field->Jenis_Kelamin == 'M' || $field->Jenis_Kelamin == 'LAKI-LAKI') {
                    $gender = 'Laki-laki';
                } elseif ($field->Jenis_Kelamin == 'F' || $field->Jenis_Kelamin == 'PEREMPUAN') {
                    $gender = 'Perempuan';
                } else {
                    $gender = '';
                }

                // $wawancara = '';
                // if ($field->WawancaraKe == NULL) {
                //     $wawancara .= 'Belum Pernah';
                // } else {
                //     if ($idpemborong > 0) {
                //         $wawancara .= $field->WawancaraKe . ' kali';
                //     } else {
                //         $wawancara .= '<a title="View Detail" data-rel="tooltip" href="#" class="detailInterview btn btn-minier btn-white btn-block">
                //                             <i class="ace-icon fa fa-files-o bigger-100"></i>' . $field->WawancaraKe . ' kali
                //                       </a>';
                //     }
                // }

                $status = '';
                if ($field->KTP != NULL && $field->Lamaran != NULL && $field->CV != NULL && $field->Ijazah != NULL && $field->Transkrip != NULL) {
                    $status .= "<span class='label label-sm label-success'>Berkas Lengkap</span>";
                } elseif ($field->KTP != NULL) {
                    $status .= "<span class='label label-sm label-info'>Minimal Berkas</span>";
                } else {
                    $status .= "<span class='label label-sm label-danger'>Tidak Lengkap</span>";
                }

                $berkas = '';
                if (isset($_POST['selList']) && $_POST['selList'] == '1') {
                    $berkas .= '<a title="Upload Surat Perjanjian Kontrak" class="btn btn-minier btn-round btn-success" href="' . site_url('UploadBerkas/doUploadSPK') . "?id=" . $field->HdrID . "&nama=" . $field->Nama . '" target="_blank"> Upload </a>';
                } else {
                    $berkas .= '<a title="Upload foto" class="btn btn-minier btn-round btn-primary" href="' . site_url('UploadBerkas/doEditFoto') . "?id=" . $field->HdrID . "&nama=" . $field->Nama . '" target="_blank"> Edit Foto </a>';
                    $berkas .= ' <a title="Upload berkas" class="btn btn-minier btn-round btn-success" href="' . site_url('UploadBerkas/doEditBerkas') . "?id=" . $field->HdrID . "&nama=" . $field->Nama . '" target="_blank"> Upload </a>';
                }

                $berkas .= '<div class="btn-group">
                <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                    Berkas
                    <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                </button>
                <ul class="dropdown-menu dropdown-default">';
                if ($field->KTP != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KTP" data-tk="' . ucwords(strtolower($field->Nama)) . '">KTP</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>KTP is NULL</i></small></a></li>';
                }
                if ($field->KK != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="KK" data-tk="' . ucwords(strtolower($field->Nama)) . '">KK</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>KK is NULL</i></small></a></li>';
                }
                if (isset($_POST['selList']) && $_POST['selList'] == '0') {
                    if ($field->SKCK != NULL) {
                        $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="SKCK" data-tk="' . ucwords(strtolower($field->Nama)) . '">SKCK</a></li>';
                    } else {
                        $berkas .= '<li><a><small><i>SKCK is NULL</i></small></a></li>';
                    }
                }
                if ($field->Lamaran != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Lamaran" data-tk="' . ucwords(strtolower($field->Nama)) . '">Lamaran</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Lamaran is NULL</i></small></a></li>';
                }
                if ($field->CV != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="CV" data-tk="' . ucwords(strtolower($field->Nama)) . '">CV</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>CV is NULL</i></small></a></li>';
                }
                if ($field->Ijazah != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Ijazah" data-tk="' . ucwords(strtolower($field->Nama)) . '">Ijazah</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Ijazah is NULL</i></small></a></li>';
                }
                if ($field->Transkrip != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Transkrip" data-tk="' . ucwords(strtolower($field->Nama)) . '">Transkip</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Transkrip is NULL</i></small></a></li>';
                }
                if ($field->Vaksin1 != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin1" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 1</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Vaksin1 is NULL</i></small></a></li>';
                }
                if ($field->Vaksin2 != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin2" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 2</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Vaksin2 is NULL</i></small></a></li>';
                }

                if ($field->Vaksin3 != NULL) {
                    $berkas .= '<li><a title="show detail" href="javascript:;" class="detail" data-name="Vaksin3" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 3</a></li>';
                } else {
                    $berkas .= '<li><a><small><i>Vaksin3 is NULL</i></small></a></li>';
                }
                $berkas .= '</ul>
                  </div>
                  <a title="View Detail" data-rel="tooltip" href="javascript:;" class="detailInfo btn btn-minier btn-round btn-primary">
                      <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                  </a>';




                $no++;
                $row   = array();

                // $row[] = $field->HdrID . '<input type="hidden" id="headerID" value="' . $field->HdrID . '"/>';
                // $row[] = $field->Nama;
                // $row[] = $field->Pemborong;
                // $row[] = date('d-m-Y', strtotime($field->Tgl_Lahir));
                // $row[] = $gender;
                // $row[] = $status;
                // $row[] = $field->RegisteredBy;
                // $row[] = date('d-m-Y', strtotime($field->RegisteredDate));
                // $row[] = $berkas;

                $row['HdrID'] = $field->HdrID . '<input type="hidden" id="headerID" value="' . $field->HdrID . '"/>';
                $row['Nama'] = $field->Nama;
                $row['Pemborong'] = $field->Pemborong;
                $row['Tgl_Lahir'] = date('Y-m-d', strtotime($field->Tgl_Lahir));
                $row['Tgl_Lahir_b'] = date('d-M-Y', strtotime($field->Tgl_Lahir)); // Format d-M-Y untuk display
                $row['Jenis_Kelamin'] = $field->Jenis_Kelamin;
                $row['status'] = $status;
                $row['RegisteredBy'] = $field->RegisteredBy;
                $row['RegisteredDate'] = date('Y-m-d', strtotime($field->RegisteredDate));
                $row['RegisteredDate_b'] = date('d-M-Y', strtotime($field->RegisteredDate));
                $row['berkas'] = $berkas;
                $row['inputonline'] = $field->InputOnline;
                $data[] = $row;
            }

            $output = array(
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->m_upload_berkas->count_all_upload_berkas('vwListTenakerForPemborong'),
                "recordsFiltered" => $this->m_upload_berkas->count_filtered_upload_berkas('vwListTenakerForPemborong'),
                "data"            => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }
}

/* End of file uploadBerkas.php */
/* Location: ./application/controllers/uploadBerkas.php */