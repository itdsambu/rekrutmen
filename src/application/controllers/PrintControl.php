<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class PrintControl extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('darurat');
        //        $status = 1;
        $status = $this->darurat->getStatus();
        if ($status === 1 && $this->session->userdata('userid') !== 'ismo_adm') {
            redirect(site_url('maintenanceControl'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if (!$this->session->userdata('userid')) {
            redirect('login');
        }

        $this->load->model(array('m_posting_tenaker', 'm_print_berkas', 'm_form_interview'));
    }

    function index()
    {
        $start  = date('Y-m-d', strtotime($this->input->post('startDate')));
        $end    = date('Y-m-d', strtotime($this->input->post('endDate')));

        if ($this->input->post('startDate')) {
            $data['_listTenaker']    = $this->m_print_berkas->getTenakerPostedWhere($start, $end);
        } else {
            $data['_listTenaker']    = $this->m_print_berkas->getTenakerPosted();
        }

        $this->template->display('registrasi/print_berkas/index', $data);
    }

    function newPaging($dataSelect = '0', $num = '1')
    {
        $this->template->display('registrasi/print_berkas/new_paging');
    }
    function newPaging_($dataSelect = '0', $num = '1')
    {
        if ($this->session->userdata('userid') == "KIKI") {
            $this->template->display('registrasi/print_berkas/new_paging_');
            return;
        }
        /*
         * -- dataSelect -- 
         * 0 => Telah Posting
         * 1 => Lulus Wawancara
         * 1 => Telah Discreening HRD
         */

        if ($num != '1') {
            $num                    = $this->uri->segment(4);
        }


        // $dataSelect             = $this->uri->segment(3);
        // $num                    = $this->uri->segment(4);




        // if (!isset($num) && !isset($dataSelect)) {
        //     redirect('PrintControl/newPaging/0/1');
        // } elseif ($num === FALSE) {
        //     redirect('PrintControl/newPaging/' . $dataSelect . '/1');
        // } elseif ($dataSelect == 2) {
        //     redirect('PrintControl/newPaging/' . $dataSelect . '/' . $num);
        // }


        $numStart               = $num - 1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = (int)$numStart . $start;
        $endPaging              = (int)$num . $end;

        if ($dataSelect == 0) {
            $total                  = $this->m_print_berkas->countTenakerPostedPrintPaging();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_print_berkas->selectTenakerPostedPrintPaging($startPaging, $endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } elseif ($dataSelect == 1) {
            $total                  = $this->m_print_berkas->countTenakerInterviewedPrintPaging();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_print_berkas->selectTenakerInterviewedPrintPaging($startPaging, $endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } elseif ($dataSelect == 2) {
            $total                  = $this->m_print_berkas->countGetTenakerOK();
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_print_berkas->getTenakerOK($startPaging, $endPaging);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_pagination']    = NULL;
        }



        $this->template->display('registrasi/print_berkas/new_paging', $data);
    }
    function filterData()
    {
        $dataFilter = $this->input->post('selDataFilter');

        $this->session->unset_userdata('w_pemborong');
        $this->session->unset_userdata('w_noreg');
        $this->session->unset_userdata('w_nama');
        // print_r([$this->input->post('txtDateA'), $this->input->post('txtDateZ')]);
        // die;

        if ($dataFilter == 0 || $dataFilter == 2) {
            if ($this->input->post('txtNama') == NULL && $this->input->post('txtNoreg') == NULL && $this->input->post('txtPemborong') == NULL && $this->input->post('txtDateA') == NULL && $this->input->post('txtDateZ') == NULL) {
                redirect('PrintControl/newPaging/' . $dataFilter);
            }
        } else {
            if ($this->input->post('txtNama') == NULL && $this->input->post('txtNoreg') == NULL && $this->input->post('txtPemborong') == NULL) {
                redirect('PrintControl/newPaging/' . $dataFilter);
            }
        }

        $this->session->set_userdata('w_pemborong', $this->input->post('txtPemborong'));
        $this->session->set_userdata('w_noreg', $this->input->post('txtNoreg'));
        $this->session->set_userdata('w_nama', $this->input->post('txtNama'));
        $this->session->set_userdata('w_datea', $this->input->post('txtDateA'));
        $this->session->set_userdata('w_datez', $this->input->post('txtDateZ'));

        redirect('PrintControl/dataFilter/' . $dataFilter . '/');
    }
    function dataFilter()
    {
        $dataSelect             = $this->uri->segment(3);
        $num                    = $this->uri->segment(4);

        $pemborong      = $this->session->userdata('w_pemborong');
        $noreg          = $this->session->userdata('w_noreg');
        $nama           = $this->session->userdata('w_nama');
        $tglA           = date('Y-m-d', strtotime($this->session->userdata('w_datea')));
        $tglZ           = date('Y-m-d', strtotime($this->session->userdata('w_datez')));
        $data['tglA']           = date('d-m-Y', strtotime($this->session->userdata('w_datea')));
        $data['tglZ']           = date('d-m-Y', strtotime($this->session->userdata('w_datez')));

        // print_r($noreg);
        // die;

        $numStart               = $num - 1;
        $start                  = 1;
        $end                    = 0;
        $startPaging            = (int)$numStart . $start;
        $endPaging              = (int)$num . $end;


        if ($dataSelect == 0) {
            $total                  = $this->m_print_berkas->countTenakerPostedPrintPagingWhere($pemborong, $noreg, $nama, $tglA, $tglZ);
            $data['_selected']      = $dataSelect;
            $data['_selectWhere']   = $this->m_print_berkas->selectTenakerPostedPrintPagingWhere($pemborong, $noreg, $nama, $tglA, $tglZ);
            $data['_pagination']    = $this->pagination($page = $num, 10, $total);
            $data['_noreg']       = $noreg;
            $data['_pemborong']   = $pemborong;
            $data['_nama']        = $nama;
        } elseif ($dataSelect == 1) {
            $total                = $this->m_print_berkas->countTenakerInterviewedPrintPagingWhere($pemborong, $noreg, $nama);
            $data['_selected']    = $dataSelect;
            $data['_selectWhere'] = $this->m_print_berkas->selectTenakerInterviewedPrintPagingWhere($startPaging, $endPaging, $pemborong, $noreg, $nama);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
            $data['_noreg']       = $noreg;
            $data['_pemborong']   = $pemborong;
            $data['_nama']        = $nama;
        } elseif ($dataSelect == 2) {
            // die;
            $total                = $this->m_print_berkas->countgetTenakerOKWhere($pemborong, $noreg, $nama);
            $data['_selected']    = $dataSelect;
            $data['_selectWhere'] = $this->m_print_berkas->getTenakerOKWhere($pemborong, $noreg, $nama, $tglA, $tglZ);
            $data['_pagination']  = $this->pagination($page = $num, 10, $total);
            $data['_noreg']       = $noreg;
            $data['_pemborong']   = $pemborong;
            $data['_nama']        = $nama;
            // print_r($data['_selectWhere']);
            // die;
        } else {
            $total                  = NULL;
            $data['_selected']      = NULL;
            $data['_selectWhere']   = NULL;
            $data['_pagination']    = NULL;
        }
        // print_r($this->session->userdata('username'));
        // die;

        $this->template->display('registrasi/print_berkas/new_paging', $data);
    }

    function viewBNI()
    {
        ob_start();
        $hdrid = $this->uri->segment(3);
        $data['getDetail'] = $this->m_posting_tenaker->getResult($hdrid);
        $data['tglPrint']   = date("d M Y");

        $this->load->view('monitor/interview/print/SuratBNI', $data);
        $html    = ob_get_contents();
        ob_end_clean();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html);
        $pdf->Output('Surat Pernyataan BNI.pdf');
    }

    function viewMandiri()
    {
        ob_start();
        $hdrid = $this->uri->segment(3);
        $data['getDetail'] = $this->m_posting_tenaker->getResult($hdrid);
        $data['tglPrint']   = date("d M Y");

        $this->load->view('monitor/interview/print/SuratMandiri', $data);
        $html    = ob_get_contents();
        ob_end_clean();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html);
        $pdf->Output('Surat Pernyataan BNI.pdf');
    }

    // function viewMandiriChecked($data)
    // {
    //     ob_start();
    //     $data = urldecode($data);
    //     $data = json_decode($data);
    //     $data['getDetail'] = $this->m_posting_tenaker->getResultChecked($data);
    //     $data['tglPrint']   = date("d M Y");

    //     $this->load->view('monitor/interview/print/SuratMandiri', $data);
    //     $html    = ob_get_contents();
    //     ob_end_clean();

    //     require_once('./assets/html2pdf/html2pdf.class.php');
    //     $pdf    = new HTML2PDF('P', 'A4', 'en');
    //     $pdf->writeHTML($html);
    //     $pdf->Output('Surat Pengajuan Mandiri.pdf');
    // }

    function viewMandiriChecked($data)
    {
        $data = urldecode($data);
        $data = json_decode($data);
        $data['getDetail'] = $this->m_posting_tenaker->getResultChecked($data);
        $data['tglPrint']  = date('d M Y');

        ob_start();
        $this->load->view('monitor/interview/print/SuratMandiri', $data);
        $html = ob_get_clean();

        require_once FCPATH . 'vendor/autoload.php';

        $tempDir = APPPATH . 'cache/mpdf/';
        if (!is_dir($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $mpdf = new \Mpdf\Mpdf([
            'mode'              => 'utf-8',
            'format'            => 'A4',
            'orientation'       => 'P',
            'margin_top'        => 15,
            'margin_bottom'     => 15,
            'margin_left'       => 20,
            'margin_right'      => 20,
            'margin_header'     => 0,
            'margin_footer'     => 0,
            'default_font'      => 'arial',
            'default_font_size' => 12,
            'tempDir'           => $tempDir,
        ]);

        $mpdf->WriteHTML($html);
        $mpdf->Output('Surat Pengajuan Mandiri.pdf', \Mpdf\Output\Destination::INLINE);
        exit;
    }

    function viewSPMK()
    {
        // require_once FCPATH . 'vendor/autoload.php';
        ob_start();
        $hdrID  = $this->uri->segment(3);
        $data['_getDetail'] = $this->m_posting_tenaker->getResult($hdrID);
        $data['_getInterV'] = $this->m_posting_tenaker->getInterV($hdrID);
        $data['adm']        = $this->session->userdata('username');
        $data['tglPrint']   = date("d M Y");

        $this->load->view("registrasi/posting/print/spmk", $data);
        $html   = ob_get_contents();
        ob_end_clean();

        // require_once('./assets/html2pdf/html2pdf.class.php');
        // $pdf    = new HTML2PDF('P', 'A4', 'en');
        // $pdf->writeHTML($html);
        // $pdf->Output('SPMK-' . $hdrID . '.pdf');

        require_once FCPATH . 'vendor/autoload.php';

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetAutoPageBreak(TRUE, 5);
        $pdf->AddPage();
        $pdf->SetFont('freeserif', '', 10);

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('SPMK-' . $hdrID . '.pdf');
    }
    function viewFormMCU()
    {
        ob_start();
        $hdrID  = $this->uri->segment(3);
        foreach ($this->m_posting_tenaker->getResult($hdrID) as $row) :
            $tglLahir   = $row->Tgl_Lahir;
        endforeach;
        $data['_umur'] = $this->hitungUmur(date('Y-m-d', strtotime($tglLahir)));
        $data['_getDetail'] = $this->m_posting_tenaker->getResult($hdrID);

        $this->load->view("registrasi/posting/print/mcu_form", $data);
        $html   = ob_get_contents();
        ob_end_clean();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html, isset($_GET['vuehtml']));
        $pdf->Output('MCU Form - ' . $hdrID . '.pdf');
    }
    function viewCardMCU()
    {
        ob_start();
        $hdrID  = $this->uri->segment(3);
        $data['_getDetail'] = $this->m_posting_tenaker->getResult($hdrID);

        $this->load->view("registrasi/posting/print/mcu_card", $data);
        $html   = ob_get_contents();
        ob_end_clean();

        // require_once('./assets/html2pdf/html2pdf.class.php');
        // $pdf    = new HTML2PDF('P', 'A4', 'en');
        // $pdf->writeHTML($html, isset($_GET['vuehtml']));
        // $pdf->Output('MCU Card - ' . $hdrID . '.pdf');
        require_once FCPATH . 'vendor/autoload.php';

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetAutoPageBreak(TRUE, 5);
        $pdf->AddPage();
        $pdf->SetFont('freeserif', '', 10);

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('SPMK-' . $hdrID . '.pdf');
    }
    function viewKPB()
    {
        ob_start();
        $hdrID  = $this->uri->segment(3);
        $data['_getDetail'] = $this->m_posting_tenaker->getResult($hdrID);
        $data['_getAnak']   = $this->m_posting_tenaker->getAnak($hdrID);

        $this->load->view("registrasi/posting/print/kpb", $data);
        $html   = ob_get_contents();
        ob_end_clean();

        // require_once('./assets/html2pdf/html2pdf.class.php');
        // $pdf    = new HTML2PDF('P', 'A4', 'en');
        // $pdf->writeHTML($html, isset($_GET['vuehtml']));
        // $pdf->Output('KPB-' . $hdrID . '.pdf');

        require_once FCPATH . 'vendor/autoload.php';

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetAutoPageBreak(TRUE, 5);
        $pdf->AddPage();
        $pdf->SetFont('freeserif', '', 10);

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('SPMK-' . $hdrID . '.pdf');
    }
    function viewIntervewResultSMA()
    {
        ob_start();
        $hdrID  = $this->uri->segment(3);
        $data['_getDetail'] = $this->m_posting_tenaker->getResult($hdrID);
        $data['_getAnak']   = $this->m_posting_tenaker->getAnak($hdrID);

        $this->load->view("registrasi/posting/print/interviewSMU");
        $html   = ob_get_contents();
        ob_end_clean();

        // require_once('./assets/html2pdf/html2pdf.class.php');
        // $pdf    = new HTML2PDF('P', 'A4', 'en');
        // $pdf->writeHTML($html, isset($_GET['vuehtml']));
        // $pdf->Output('Interview Result-.pdf');

        require_once FCPATH . 'vendor/autoload.php';

        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetMargins(5, 5, 5);
        $pdf->SetAutoPageBreak(TRUE, 5);
        $pdf->AddPage();
        $pdf->SetFont('freeserif', '', 10);

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('SPMK-' . $hdrID . '.pdf');
    }
    function viewIntervewResultStrata()
    {
        ob_start();
        //        $hdrID  = $this->uri->segment(3);
        //        $data['_getDetail'] = $this->m_posting_tenaker->getResult($hdrID);
        //        $data['_getAnak']   = $this->m_posting_tenaker->getAnak($hdrID);

        $this->load->view("registrasi/posting/print/interviewStrata");
        $html   = ob_get_contents();
        ob_end_clean();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html, isset($_GET['vuehtml']));
        $pdf->Output('Interview Result-.pdf');
    }
    function viewDaftarCekOrientasi()
    {
        ob_start();
        $this->load->view("registrasi/posting/print/cekOrientasi");
        $html   = ob_get_contents();
        ob_end_clean();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html, isset($_GET['vuehtml']));
        $pdf->Output('Interview Result-.pdf');
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
        $tahun  = substr($umur / 365, 0, 3);

        return $tahun;
    }
    //Paging
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
                        $pagination .= "<li><a href='$counter'>$counter</a></li>";
                    }
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page) {
                            $pagination .= "<li class='active'><a class='active'>$counter</a></li>";
                        } else {
                            $pagination .= "<li><a href='$counter'>$counter</a></li>";
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
                            $pagination .= "<li><a href='$counter'>$counter</a></li>";
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
                            $pagination .= "<li><a href='$counter'>$counter</a></li>";
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
    function viewPF_INTERVIEW()
    {
        ob_start();
        $hdrID  = $this->uri->segment(3);
        $data['_getDetail'] = $this->m_form_interview->getResult($hdrID);

        $this->load->view("registrasi/form_interview/print/pf_interview", $data);
        $html   = ob_get_contents();
        ob_end_clean();

        require_once('./assets/html2pdf/html2pdf.class.php');
        $pdf    = new HTML2PDF('P', 'A4', 'en');
        $pdf->writeHTML($html, isset($_GET['vuehtml']));
        $pdf->Output('Form Interview-' . $hdrID . '.pdf');
    }


    function EksportExcel($data)
    {
        $this->load->library("Excel/PHPExcel");
        $data = urldecode($data);
        $data = json_decode($data);
        // $data['param'] = json_decode($data);
        $data['getDetail'] = $this->m_posting_tenaker->getResultData($data);
        // print_r($data['getDetail']);
        // die;
        // print_r($data['getDetail']);
        // die;
        $this->load->view('registrasi/form_interview/print/ExcelPostTK_', $data);
    }

    public function show()
    {

        // if ($this->input->is_ajax_request()) {
        // print_r($_POST);
        // die;
        $list = $this->m_print_berkas->get_datatables();
        $data = array();
        $no   = $_POST['start'];
        $i = 0;
        foreach ($list as $field) {

            $checkBox = ' <div class="checkbox" data-id="' . $field->HeaderID . '">
                            <label class="pos-rel">
                                <input name="checkVerifi[' . $i++ . ']" type="checkbox" class="ace chkBox" value="' . $field->HeaderID . '"/>
                                <span class="lbl"></span>
                            </label>
                        </div>';
            // print_r($_POST['selDataFilter']);
            // die;

            $tipeKaryawan = isset($_POST['selDataFilter']) && $_POST['selDataFilter'] == 0 ? ($field->TipeKaryawan == 1 ? 'Karyawan' : 'Borongan/Harian') : ($field->Pemborong == 1 ? 'YAO HSING' : 'Borongan/Harian');
            $tglLahir = date('d-M-Y', strtotime($field->Tgl_Lahir));
            $jenisKelamin = $field->Jenis_Kelamin == 'L' || $field->Jenis_Kelamin == 'LAKI-LAKI' ? 'Laki-laki' : 'Perempuan';
            $berkasLengkap = '';
            if ($field->KTP != NULL && $field->Lamaran != NULL && $field->CV != NULL && $field->Ijazah != NULL && $field->Transkrip != NULL) {
                $berkasLengkap = '<span class="label label-sm label-success">Lengkap</span>';
            } elseif ($field->KTP != NULL) {
                $berkasLengkap = '<span class="label label-sm label-indo">Minimal Berkas</span>';
            } else {
                $berkasLengkap = '<span class="label label-sm label-danger">Tidak Lengkap</span>';
            }

            $tanggal = (isset($_POST['selDataFilter']) && $_POST['selDataFilter'] == 0)
                ? $field->CreatedDate
                : $field->RegisteredDate;

            $createBy = "
                    <div class='text-left'>{$field->CreatedBy}</div>
                    <div class='text-right smaller-90'>
                        " . date('F, d Y H:i:s', strtotime($tanggal)) . "
                    </div>
                ";
            $tgl = !empty($field->SpecialScreeningDate)
                ? date('F, d Y H:i:s', strtotime($field->SpecialScreeningDate))
                : '-';

            $specialScreening = "
                    <div class='text-left'>{$field->SpecialScreeningBy}</div>
                    <div class='text-right smaller-90'>{$tgl}</div>
                ";
            $wawancara = ($field->WawancaraKe == NULL)
                ? 'Belum Pernah'
                : "
                    <a title='View Detail' data-rel='tooltip' href='#'
                    class='detailInterview btn btn-minier btn-white btn-block'>
                        <i class='ace-icon fa fa-files-o bigger-100'></i>
                        {$field->WawancaraKe} kali
                    </a>
                ";

            $namaTk = ucwords(strtolower($field->Nama));

            $action = "
                    <div class='btn-group'>
                        <button data-toggle='dropdown' class='btn btn-mini btn-round btn-success dropdown-toggle'>
                            Print
                            <span class='ace-icon fa fa-caret-down icon-on-right'></span>
                        </button>
                        <ul class='dropdown-menu dropdown-default'>
                            <li>
                                <a title='print Surat Pengantar Masuk Kerja' data-rel='tooltip'
                                href='" . site_url('printControl/viewSPMK/' . $field->HeaderID) . "' target='_blank'>SPMK</a>
                            </li>
                            <li>
                                <a title='print Formulir Medical Check Up' data-rel='tooltip'
                                href='" . site_url('printControl/viewFormMCU/' . $field->HeaderID) . "' target='_blank'>MCU Form</a>
                            </li>
                            <li>
                                <a title='print Kartu Medical Check Up' data-rel='tooltip'
                                href='" . site_url('printControl/viewCardMCU/' . $field->HeaderID) . "' target='_blank'>MCU Card</a>
                            </li>
                            <li>
                                <a title='print Kartu Pengantar Berobat' data-rel='tooltip'
                                href='" . site_url('printControl/viewKPB/' . $field->HeaderID) . "' target='_blank'>KPB Card</a>
                            </li>
                            <li>
                                <a href='" . site_url('printControl/viewBNI/' . $field->HeaderID) . "'
                                data-rel='tooltip' target='_blank'><small>Surat Pernyataan BNI</small></a>
                            </li>
                            <li>
                                <a href='" . site_url('printControl/viewMandiri/' . $field->HeaderID) . "'
                                data-rel='tooltip' target='_blank'>Print Mandiri</a>
                            </li>
                        </ul>
                    </div>

                    <div class='btn-group'>
                        <button data-toggle='dropdown' class='btn btn-mini btn-round btn-purple dropdown-toggle'>
                            Berkas
                            <span class='ace-icon fa fa-caret-down icon-on-right'></span>
                        </button>
                        <ul class='dropdown-menu dropdown-default'>
                            <li>" . ($field->KTP != NULL
                ? "<a title='show KTP' data-rel='tooltip' href='#' class='berkas' data-name='KTP' data-tk='{$namaTk}'>KTP</a>"
                : "<a><small><i>KTP is NULL</i></small></a>") . "</li>

                            <li>" . ($field->Lamaran != NULL
                ? "<a title='show Lamaran' data-rel='tooltip' href='#' class='berkas' data-name='Lamaran' data-tk='{$namaTk}'>Lamaran</a>"
                : "<a><small><i>Lamaran is NULL</i></small></a>") . "</li>

                            <li>" . ($field->CV != NULL
                ? "<a title='show CV' data-rel='tooltip' href='#' class='berkas' data-name='CV' data-tk='{$namaTk}'>Curriculum Vitae</a>"
                : "<a><small><i>Curriculum Vitae is NULL</i></small></a>") . "</li>

                            <li>" . ($field->Ijazah != NULL
                ? "<a title='show Ijazah' data-rel='tooltip' href='#' class='berkas' data-name='Ijazah' data-tk='{$namaTk}'>Ijazah</a>"
                : "<a><small><i>Ijazah is NULL</i></small></a>") . "</li>

                            <li>" . ($field->Transkrip != NULL
                ? "<a title='show Transkrip' data-rel='tooltip' href='#' class='berkas' data-name='Transkrip' data-tk='{$namaTk}'>Transkrip Nilai</a>"
                : "<a><small><i>Transkrip is NULL</i></small></a>") . "</li>

                            <li>" . (isset($field->SuratKontrak) && $field->SuratKontrak != NULL
                ? "<a title='show Surat Kontrak' data-rel='tooltip' href='#' class='berkas' data-name='SuratKontrak' data-tk='{$namaTk}'>Surat Kontrak</a>"
                : "<a><small><i>Surat Kontrak is NULL</i></small></a>") . "</li>
                        </ul>
                    </div>

                    <a title='View Detail' data-rel='tooltip' href='#'
                    class='detail btn btn-minier btn-round btn-primary'>
                        <i class='ace-icon fa fa-files-o bigger-100'></i> Detail
                    </a>
                    ";







            $no++;
            $row   = array();

            $row[] = $checkBox;
            $row[] = $field->HeaderID;
            $row[] = $field->Nama;
            $row[] = $field->DeptTujuan;
            $row[] = $tipeKaryawan;
            $row[] = $tglLahir;
            $row[] = $jenisKelamin;
            $row[] = $berkasLengkap;
            $row[] = $createBy;
            $row[] = $specialScreening;
            $row[] = $wawancara;
            $row[] = $action;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->m_print_berkas->count_all(),
            "recordsFiltered" => $this->m_print_berkas->count_filtered(),
            "data"            => $data,
        );
        //output dalam format JSON
        echo json_encode($output);
        // }
    }
}
