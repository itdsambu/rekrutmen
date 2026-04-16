<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Verifikasi extends CI_Controller
{

    public function __construct()
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

        $this->load->model(array('M_verifikasi'));
    }

    // function _index()
    // {
    //     $data['selDataFilter'] = $this->input->post('selDataFilter') ?? 0;
    //     $data['page_aktif']    = $this->input->post('page_aktif') ?? 1;

    //     if (!empty($this->input->post('end_date')) && date('Y-m-d', strtotime($this->input->post('end_date'))) >= '2021-01-01') {
    //         $data['end_date'] = date('Y-m-d', strtotime($this->input->post('end_date')));
    //     } else {
    //         $data['end_date'] = date('Y-m-t');
    //     }

    //     if (!empty($this->input->post('start_date')) && date('Y-m-d', strtotime($this->input->post('start_date'))) <= $data['end_date']) {
    //         $data['start_date'] = date('Y-m-d', strtotime($this->input->post('start_date')));
    //     } else {
    //         $data['start_date'] = date('Y-m-d', strtotime($data['end_date'] . ' -3 months'));
    //     }

    //     $data['pemborong'] = !empty($this->input->post('txtPemborong')) ? $this->input->post('txtPemborong') : '';
    //     $data['nama']      = !empty($this->input->post('txtNama')) ? $this->input->post('txtNama') : '';
    //     $data['noreg']     = !empty($this->input->post('txtNoreg')) ? $this->input->post('txtNoreg') : '';

    //     $nums_tart    = $data['page_aktif'] - 1;
    //     $start        = 1;
    //     $end          = 0;
    //     $start_paging = (int)$nums_tart . $start;
    //     $end_paging   = (int)$data['page_aktif'] . $end;

    //     $list_tk = $this->M_verifikasi->list_calon_tk($data['selDataFilter'], $data['start_date'], $data['end_date'], $data['pemborong'], $data['nama'], $data['noreg'], $start_paging, $end_paging);

    //     $data['_selectWhere']   = $list_tk['list_per_page'];
    //     $data['_peganation']    = $this->pagination($page = $data['page_aktif'], 10, $list_tk['jumlah_row']);
    //     // print_r($this->session->userdata('userid'));
    //     // exit;

    //     if ($this->session->userdata('userid') == 'KIKI' || $this->session->userdata('userid') == 'kiki') {

    //         $this->template->display('registrasi/verifikasi/index_dev', $data);
    //     } else {
    //         $this->template->display('registrasi/verifikasi/index', $data);
    //     }
    // }

    function index()
    {
        $this->template->display('registrasi/verifikasi/index');
    }

    function simpan()
    {
        $data = array(
            'HeaderID'      => $this->input->post('txtHeaderID'),
            'Dept'          => $this->input->post('txtDept'),
            'VirifiedBy'    => $this->input->post('txtName'),
            'VirifiedDate'  => date('Y-m-d H:m:i'),
            'VirifiedKet'   => $this->input->post('txtKeterangan')
        );

        $this->M_verifikasi->simpanVerifikasiTim($data);

        redirect('verifikasi/index?msg=success_add_komentar');
    }

    function verifiAksi()
    {
        if (isset($_POST['Verifi'])) {
            $checked = $this->input->post('checkVerifi');
            $itung = count($checked);
            for ($i = 0; $i < $itung; $i++) {
                $this->M_verifikasi->updateVerified($checked[$i]);
            }
            redirect(site_url('verifikasi/index'));
        } elseif (isset($_POST['Cancel'])) {
            $checked = $this->input->post('checkVerifi');
            $itung = count($checked);
            for ($i = 0; $i < $itung; $i++) {
                $this->M_verifikasi->batalVerified($checked[$i]);
            }
            redirect(site_url('verifikasi/index'));
        }
    }

    function detailtk()
    {
        if ('IS_AJAX') {
            $kode = $this->input->post('kode');
            $data['datatk'] = $this->M_verifikasi->get_detailtk($kode)->result();
            foreach ($this->M_verifikasi->get_detailtk($kode)->result() as $row) :
                $tglLahir   = $row->Tgl_Lahir;
            endforeach;
            $data['_umur']  = $this->hitungUmur(date('Y-m-d', strtotime($tglLahir)));
            $data['resultScreen'] = $this->M_verifikasi->resultScreen($kode)->result();
            $this->load->view('registrasi/verifikasi/detail', $data);
        }
    }

    function closeTenaker()
    {
        $hdrID = $this->input->post('txtHeaderID');
        $remark = $this->input->post('txtRemarkClose');
        $this->M_verifikasi->closeTenaker($hdrID, $remark);
        redirect(site_url('verifikasi/index'));
    }

    function hitungUmur($tglLahir = "1991-02-01")
    {
        $thn    = substr($tglLahir, 0, 4);
        $bln    = substr($tglLahir, 5, 2);
        $day    = substr($tglLahir, 8, 2);

        $nowY   = date("Y");
        $nowM   = date("m");
        $nowD   = date("d");

        $hariLahir  = gregoriantojd($bln, $day, $thn);
        $today      = gregoriantojd($nowM, $nowD, $nowY);

        $umur   = $today - $hariLahir;
        $tahun  = substr($umur / 365, 0, 2);

        return $tahun;
    }

    function pagination($page = 1, $per_page = 10, $row = 0)
    {
        $total = $row;
        $adjacents = "2";

        $page = ($page == 0 ? 1 : $page);
        $start = ($page - 1) * $per_page;

        $prev = $page - 1;
        $next = $page + 1;
        $lastpage = ceil($total / $per_page);
        $lpm1 = $lastpage - 1;

        $pagination = "";
        if ($lastpage > 1) {
            $pagination .= "<ul class='pagination'>";
            $pagination .= "<li><a>Page $page of $lastpage</a></li>";
            if ($lastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $page) {
                        $pagination .= "<li class='active'><a>$counter</a></li>";
                    } else {
                        $pagination .= "<li class='ke_page'><a>$counter</a></li>";
                    }
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page) {
                            $pagination .= "<li class='active'><a class='active'>$counter</a></li>";
                        } else {
                            $pagination .= "<li class='ke_page'><a>$counter</a></li>";
                        }
                    }
                    $pagination .= "<li class='dot'><a>...</a></li>";
                    $pagination .= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination .= "<li><a href='$lastpage'>$lastpage</a></li>";
                } elseif ($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination .= "<li><a href='1'>1</a></li>";
                    $pagination .= "<li><a href='2'>2</a></li>";
                    $pagination .= "<li class='dot'><a>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination .= "<li class='ke_page'><a>$counter</a></li>";
                    }
                    $pagination .= "<li class='dot'><a>...</a></li>";
                    $pagination .= "<li><a href='$lpm1'>$lpm1</a></li>";
                    $pagination .= "<li><a href='$lastpage'>$lastpage</a></li>";
                } else {
                    $pagination .= "<li><a href='1'>1</a></li>";
                    $pagination .= "<li><a href='2'>2</a></li>";
                    $pagination .= "<li class='dot'><a>...</a></li>";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='active'><a class='active'>$counter</a></li>";
                        else
                            $pagination .= "<li class='ke_page'><a>$counter</a></li>";
                    }
                }
            }

            if ($page < $counter - 1) {
                $pagination .= "<li><a href='$next'>Next</a></li>";
                $pagination .= "<li><a href='$lastpage'>Last</a></li>";
            } else {
                $pagination .= "<li><a class='current'>Next</a></li>";
                $pagination .= "<li><a class='current'>Last</a></li>";
            }
            $pagination .= "</ul>\n";
        }
        return $pagination;
    }


    public function show()
    {

        if ($this->input->is_ajax_request()) {
            $list = $this->M_verifikasi->get_datatables();

            $data = array();
            $no   = $_POST['start'];
            foreach ($list as $field) {



                $berkas = '<div class="btn-group">
                            <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                                Berkas
                                <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                            </button>
                            <ul class="dropdown-menu dropdown-default">
                                ';

                if (isset($_POST['selDataFilter']) && $_POST['selDataFilter'] == '3') {
                    $table = 'vwTrnReportPosted';
                } else {
                    $table = 'vwListBerkas';
                }
                if ($this->M_verifikasi->column_exists($table, 'KK')) {



                    if ($field->KTP != NULL) {
                        $berkas .= '<li><a title="show detail" href="javascript:;" class="berkas" data-id="' . $field->HdrID . '" data-name="KTP" data-tk="' . ucwords(strtolower($field->Nama)) . '">KTP</a></li>';
                    } else {
                        $berkas .= '<li><a><small><i>KTP is NULL</i></small></a></li>';
                    }
                    if ($field->KK != NULL) {
                        $berkas .= '<li><a title="show detail" href="javascript:;" class="berkas" data-id="' . $field->HdrID . '" data-name="KK" data-tk="' . ucwords(strtolower($field->Nama)) . '">KK</a></li>';
                    } else {
                        $berkas .= '<li><a><small><i>KK is NULL</i></small></a></li>';
                    }
                    if ($field->SKCK != NULL) {
                        $berkas .= '<li><a title="show detail" href="javascript:;" class="berkas" data-id="' . $field->HdrID . '" data-name="SKCK" data-tk="' . ucwords(strtolower($field->Nama)) . '">SKCK</a></li>';
                    } else {
                        $berkas .= '<li><a><small><i>SKCK is NULL</i></small></a></li>';
                    }
                    if ($field->Lamaran != NULL) {
                        $berkas .= '<li><a title="show detail" href="javascript:;" class="berkas" data-id="' . $field->HdrID . '" data-name="Lamaran" data-tk="' . ucwords(strtolower($field->Nama)) . '">Lamaran</a></li>';
                    } else {
                        $berkas .= '<li><a><small><i>Lamaran is NULL</i></small></a></li>';
                    }
                    if ($field->CV != NULL) {
                        $berkas .= '<li><a title="show detail" href="javascript:;" class="berkas" data-id="' . $field->HdrID . '" data-name="CV" data-tk="' . ucwords(strtolower($field->Nama)) . '">CV</a></li>';
                    } else {
                        $berkas .= '<li><a><small><i>CV is NULL</i></small></a></li>';
                    }
                    if ($field->Ijazah != NULL) {
                        $berkas .= '<li><a title="show detail" href="javascript:;" class="berkas" data-id="' . $field->HdrID . '" data-name="Ijazah" data-tk="' . ucwords(strtolower($field->Nama)) . '">Ijazah</a></li>';
                    } else {
                        $berkas .= '<li><a><small><i>Ijazah is NULL</i></small></a></li>';
                    }
                    if ($field->Transkrip != NULL) {
                        $berkas .= '<li><a title="show detail" href="javascript:;" class="berkas" data-id="' . $field->HdrID . '" data-name="Transkrip" data-tk="' . ucwords(strtolower($field->Nama)) . '">Transkip</a></li>';
                    } else {
                        $berkas .= '<li><a><small><i>Transkrip is NULL</i></small></a></li>';
                    }
                    if ($field->Vaksin1 != NULL) {
                        $berkas .= '<li><a title="show detail" href="javascript:;" class="berkas" data-id="' . $field->HdrID . '" data-name="Vaksin1" data-tk="' . ucwords(strtolower($field->Nama)) . '">Berkas Pendukung</a></li>';
                    } else {
                        $berkas .= '<li><a><small><i>Berkas Pendukung is NULL</i></small></a></li>';
                    }
                    if ($field->Vaksin2 != NULL) {
                        $berkas .= '<li><a title="show detail" href="javascript:;" class="berkas" data-id="' . $field->HdrID . '" data-name="Vaksin2" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 2</a></li>';
                    } else {
                        $berkas .= '<li><a><small><i>Vaksin2 is NULL</i></small></a></li>';
                    }

                    if ($field->Vaksin3 != NULL) {
                        $berkas .= '<li><a title="show detail" href="javascript:;" class="berkas" data-id="' . $field->HdrID . '" data-name="Vaksin3" data-tk="' . ucwords(strtolower($field->Nama)) . '">Vaksin 3</a></li>';
                    } else {
                        $berkas .= '<li><a><small><i>Vaksin3 is NULL</i></small></a></li>';
                    }
                    $berkas .= '</ul>
                            </div>
                            <a title="View Detail" data-rel="tooltip" href="javascript:;" class="detailInfo detail btn btn-minier btn-round btn-primary" value="' . $field->HdrID . '">
                                <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                            </a>                           
                            ';
                } else {
                    $berkas = '';
                }


                $check = ' <div class="checkbox">
                                <label class="pos-rel">
                                    <input type="checkbox" name="checkVerifi[]" class="ace" value="' . $field->HdrID . '">
                                    <span class="lbl"></span>
                                </label>
                            </div>';

                $status = '';
                if ($field->Verified == 1) {
                    $status .= '<span class="label label-sm label-info arrowed-right arrowed-in">Telah Verifikasi</span>';
                } else {
                    $status .= '<span class="label label-sm label-danger arrowed-right arrowed-in">Belum Verifikasi</span>';
                }

                $minimalberkas = '';
                if ($field->KTP != NULL && $field->Lamaran != NULL && $field->CV != NULL && $field->Ijazah != NULL && $field->Transkrip != NULL) {
                    $minimalberkas .= '<span class="label label-sm label-success arrowed">Berkas Lengkap</span>';
                } elseif ($field->KTP != NULL) {
                    $minimalberkas .= '<span class="label label-sm label-info arrowed">Minimal Berkas</span>';
                } else {
                    $minimalberkas .= '<span class="label label-sm label-danger arrowed">Tidak Lengkap</span>';
                }

                $registeredBy = ' <div class="text-left">' . $field->RegisteredBy . '</div>
                                 <div class="text-right smaller-80">' . date('d-m-Y', strtotime($field->RegisteredDate)) . '</div>';






                $no++;
                $row   = array();
                $row[] =  $check;
                $row[] = $field->HdrID  . '<input class="info data-id" id="data-id" value="' . $field->HdrID . '" type="hidden" data-id="' . $field->HdrID . '">';
                $row[] = $field->Nama;
                $row[] = $field->Pemborong;
                $row[] = date('d-m-Y', strtotime($field->Tgl_Lahir));
                $row[] = ucwords(strtolower($field->Jenis_Kelamin));
                $row[] = $field->Pendidikan == 'NaN' || $field->Pendidikan == 'NAN' ? 'Tidak Sekolah' : $field->Pendidikan;
                $row[] = $status;
                $row[] = $minimalberkas;
                $row[] = $registeredBy;
                $row[] = $berkas;

                $data[] = $row;
            }

            $output = array(
                "draw"            => $_POST['draw'],
                "recordsTotal"    => $this->M_verifikasi->count_all(),
                "recordsFiltered" => $this->M_verifikasi->count_filtered(),
                "data"            => $data,
            );
            //output dalam format JSON
            echo json_encode($output);
        }
    }
}

/* End of file verifikasi.php */
/* Location: ./application/controllers/verifikasi.php */