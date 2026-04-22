<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class Approval_mpp extends CI_Controller
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

        $this->load->model(array('m_approval', 'm_issue', 'm_approval_mpp', 'M_perubahanmpp'));
    }

    // ======================== Approval Dept ============================
    function dept()
    {
        $cssadd = array(
            'sweetalert.css',
            'bootstrap-select.min.css',
            'addcss/buttons.bootstrap.min.css',
            'addcss/fixdb.css'
        );
        $data['cssadd'] = $cssadd;
        $this->template->display('transaksi/approval_mpp/dept/index', $data);
    }

    function viewApprovalDept()
    {
        if ('IS_AJAX') {

            $id = $this->input->post('kode');

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

            $this->load->view('transaksi/approval_mpp/dept/approval', $data);
        }
    }

    function approve_dept()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('txtId');
            $hasil = $this->input->post('txtHasil');
            $keterangan = $this->input->post('txtKeterangan');

            if ($id == null) {
                echo json_encode(array('status' => false, 'message' => 'ID tidak ditemukan'));
                return;
            }

            if ($hasil == 1) {
                $data = array(
                    'Status'       => 2, // Approve by Dept
                    'ApprovedBy'   => $this->session->userdata('username'),
                    'ApprovedDate' => date('Y-m-d H:i:s'),
                    'AppStatus'    => 1,
                );
            } else {
                $data = array(
                    'Status'          => 5, // Rejected / Disapprove
                    'RejectedBy'      => $this->session->userdata('username'),
                    'RejectedDate'    => date('Y-m-d H:i:s'),
                    'RejectionReason' => $keterangan,
                    'ApprovedBy'      => NULL,
                    'ApprovedDate'    => NULL,
                    'AppStatus'       => 2, // Rejected / Disapprove
                    'Approved2By'     => NULL,
                    'Approved2Date'   => NULL,
                    'AppStatus2'      => NULL,
                    'Approved3By'     => NULL,
                    'Approved3Date'   => NULL,
                    'AppStatus3'      => NULL,
                );
            }


            // Proses approval
            $result = $this->m_approval_mpp->approve($id, $data);

            if ($result) {
                echo json_encode(array('status' => true, 'message' => 'Approval berhasil'));
            } else {
                echo json_encode(array('status' => false, 'message' => 'Approval gagal'));
            }
        }
    }

    function approve_all_dept()
    {
        if ($this->input->is_ajax_request()) {

            $ids = $this->input->post('ids');

            if (empty($ids)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'ID tidak ditemukan'
                ]);
                return;
            }

            $data = [
                'Status'       => 2, // Approve by Dept
                'ApprovedBy'   => $this->session->userdata('username'),
                'ApprovedDate' => date('Y-m-d H:i:s'),
                'AppStatus'    => 1,
            ];

            $result = $this->m_approval_mpp->approve_batch($ids, $data);

            echo json_encode([
                'status'  => $result,
                'message' => $result ? 'Approval berhasil' : 'Approval gagal'
            ]);
        }
    }

    function disapprove_all_dept()
    {
        if ($this->input->is_ajax_request()) {

            $ids = $this->input->post('ids');

            if (empty($ids)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'ID tidak ditemukan'
                ]);
                return;
            }

            $data = [
                'Status'          => 5, // Rejected / Disapprove
                'RejectedBy'      => $this->session->userdata('username'),
                'RejectedDate'    => date('Y-m-d H:i:s'),
                'RejectionReason' => 'Rejected by Dept',
                'ApprovedBy'      => NULL,
                'ApprovedDate'    => NULL,
                'AppStatus'       => 2, // Rejected / Disapprove
                'Approved2By'     => NULL,
                'Approved2Date'   => NULL,
                'AppStatus2'      => NULL,
                'Approved3By'     => NULL,
                'Approved3Date'   => NULL,
                'AppStatus3'      => NULL,
            ];

            $result = $this->m_approval_mpp->approve_batch($ids, $data);

            echo json_encode([
                'status'  => $result,
                'message' => $result ? 'Approval berhasil' : 'Approval gagal'
            ]);
        }
    }




    // ======================== End Of Approval Dept ============================

    // ======================== Approval Divisi ============================
    function divisi()
    {
        $cssadd = array(
            'sweetalert.css',
            'bootstrap-select.min.css',
            'addcss/buttons.bootstrap.min.css',
            'addcss/fixdb.css'
        );
        $data['cssadd'] = $cssadd;
        $this->template->display('transaksi/approval_mpp/divisi/index', $data);
    }

    function viewApprovalDivisi()
    {
        if ('IS_AJAX') {

            $id = $this->input->post('kode');

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

            $this->load->view('transaksi/approval_mpp/divisi/approval', $data);
        }
    }

    function approve_divisi()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('txtId');
            $hasil = $this->input->post('txtHasil');
            $keterangan = $this->input->post('txtKeterangan');

            if ($id == null) {
                echo json_encode(array('status' => false, 'message' => 'ID tidak ditemukan'));
                return;
            }

            if ($hasil == 1) {
                $data = array(
                    'Status'       => 3,
                    'Approved2By'   => $this->session->userdata('username'),
                    'Approved2Date' => date('Y-m-d H:i:s'),
                    'AppStatus2'    => 1,
                );
            } else {
                $data = array(
                    'Status'          => 5, // Rejected / Disapprove
                    'RejectedBy'      => $this->session->userdata('username'),
                    'RejectedDate'    => date('Y-m-d H:i:s'),
                    'RejectionReason' => $keterangan,
                    'ApprovedBy'      => NULL,
                    'ApprovedDate'    => NULL,
                    'AppStatus'       => NULL,
                    'Approved2By'     => NULL,
                    'Approved2Date'   => NULL,
                    'AppStatus2'      => 2, // Rejected / Disapprove
                    'Approved3By'     => NULL,
                    'Approved3Date'   => NULL,
                    'AppStatus3'      => NULL,
                );
            }


            // Proses approval
            $result = $this->m_approval_mpp->approve($id, $data);

            if ($result) {
                echo json_encode(array('status' => true, 'message' => 'Approval berhasil'));
            } else {
                echo json_encode(array('status' => false, 'message' => 'Approval gagal'));
            }
        }
    }

    function approve_all_divisi()
    {
        if ($this->input->is_ajax_request()) {

            $ids = $this->input->post('ids');

            if (empty($ids)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'ID tidak ditemukan'
                ]);
                return;
            }

            $data = [
                'Status'       => 3,
                'Approved2By'   => $this->session->userdata('username'),
                'Approved2Date' => date('Y-m-d H:i:s'),
                'AppStatus2'    => 1,
            ];

            $result = $this->m_approval_mpp->approve_batch($ids, $data);

            echo json_encode([
                'status'  => $result,
                'message' => $result ? 'Approval berhasil' : 'Approval gagal'
            ]);
        }
    }

    function disapprove_all_divisi()
    {
        if ($this->input->is_ajax_request()) {

            $ids = $this->input->post('ids');

            if (empty($ids)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'ID tidak ditemukan'
                ]);
                return;
            }

            $data = [
                'Status'          => 5, // Rejected / Disapprove
                'RejectedBy'      => $this->session->userdata('username'),
                'RejectedDate'    => date('Y-m-d H:i:s'),
                'RejectionReason' => 'Rejected by Divisi',
                'ApprovedBy'      => NULL,
                'ApprovedDate'    => NULL,
                'AppStatus'       => NULL,
                'Approved2By'     => NULL,
                'Approved2Date'   => NULL,
                'AppStatus2'      => 2, // Rejected / Disapprove
                'Approved3By'     => NULL,
                'Approved3Date'   => NULL,
                'AppStatus3'      => NULL,
            ];

            $result = $this->m_approval_mpp->approve_batch($ids, $data);

            echo json_encode([
                'status'  => $result,
                'message' => $result ? 'Approval berhasil' : 'Approval gagal'
            ]);
        }
    }


    // ======================== End Of Approval Divisi ============================
    // ======================== Approval HRD ============================
    function hrd()
    {
        $cssadd = array(
            'sweetalert.css',
            'bootstrap-select.min.css',
            'addcss/buttons.bootstrap.min.css',
            'addcss/fixdb.css'
        );
        $data['cssadd'] = $cssadd;
        $this->template->display('transaksi/approval_mpp/hrd/index', $data);
    }

    function viewApprovalHrd()
    {
        if ('IS_AJAX') {

            $id = $this->input->post('kode');

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

            $this->load->view('transaksi/approval_mpp/hrd/approval', $data);
        }
    }

    function approve_hrd()
    {
        if ($this->input->is_ajax_request()) {
            $id = $this->input->post('txtId');
            $hasil = $this->input->post('txtHasil');
            $keterangan = $this->input->post('txtKeterangan');

            if ($id == null) {
                echo json_encode(array('status' => false, 'message' => 'ID tidak ditemukan'));
                return;
            }

            if ($hasil == 1) {
                $data = array(
                    'Status'       => 4,
                    'Approved3By'   => $this->session->userdata('username'),
                    'Approved3Date' => date('Y-m-d H:i:s'),
                    'AppStatus3'    => 1,
                );
            } else {
                $data = array(
                    'Status'          => 5, // Rejected / Disapprove
                    'RejectedBy'      => $this->session->userdata('username'),
                    'RejectedDate'    => date('Y-m-d H:i:s'),
                    'RejectionReason' => $keterangan,
                    'ApprovedBy'      => NULL,
                    'ApprovedDate'    => NULL,
                    'AppStatus'       => NULL,
                    'Approved2By'     => NULL,
                    'Approved2Date'   => NULL,
                    'AppStatus2'      => NULL,
                    'Approved3By'     => NULL,
                    'Approved3Date'   => NULL,
                    'AppStatus3'      => 2, // Rejected / Disapprove
                );
            }


            // Proses approval
            $result = $this->m_approval_mpp->approve($id, $data);

            if ($result) {
                echo json_encode(array('status' => true, 'message' => 'Approval berhasil'));
            } else {
                echo json_encode(array('status' => false, 'message' => 'Approval gagal'));
            }
        }
    }

    function approve_all_hrd()
    {
        if ($this->input->is_ajax_request()) {

            $ids = $this->input->post('ids');

            if (empty($ids)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'ID tidak ditemukan'
                ]);
                return;
            }

            $data = [
                'Status'       => 5, // Rejected / Disapprove,
                'Approved3By'   => $this->session->userdata('username'),
                'Approved3Date' => date('Y-m-d H:i:s'),
                'AppStatus3'    => 1,
            ];

            $result = $this->m_approval_mpp->approve_batch($ids, $data);

            echo json_encode([
                'status'  => $result,
                'message' => $result ? 'Approval berhasil' : 'Approval gagal'
            ]);
        }
    }

    function disapprove_all_hrd()
    {
        if ($this->input->is_ajax_request()) {

            $ids = $this->input->post('ids');

            if (empty($ids)) {
                echo json_encode([
                    'status' => false,
                    'message' => 'ID tidak ditemukan'
                ]);
                return;
            }

            $data = [
                'Status'          => 5, // Rejected / Disapprove
                'RejectedBy'      => $this->session->userdata('username'),
                'RejectedDate'    => date('Y-m-d H:i:s'),
                'RejectionReason' => 'Rejected by HRD',
                'ApprovedBy'      => NULL,
                'ApprovedDate'    => NULL,
                'AppStatus'       => NULL,
                'Approved2By'     => NULL,
                'Approved2Date'   => NULL,
                'AppStatus2'      => NULL,
                'Approved3By'     => NULL,
                'Approved3Date'   => NULL,
                'AppStatus3'      => 2, // Rejected / Disapprove
            ];

            $result = $this->m_approval_mpp->approve_batch($ids, $data);

            echo json_encode([
                'status'  => $result,
                'message' => $result ? 'Approval berhasil' : 'Approval gagal'
            ]);
        }
    }




    // ======================== End Of Approval HRD ============================


    /**
     * DataTables server-side
     */
    public function show_app_hrd()
    {
        if ($this->input->is_ajax_request()) {
            $list = $this->m_approval_mpp->get_datatables('hrd');
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $field) {
                $no++;

                $checkbox = '';
                $checkbox = '<div class="checkbox">
                                <label class="pos-rel">
                                    <input name="ckDetailID[]" type="checkbox" class="ace checkRow" value="' . $field->ID . '">
                                    <span class="lbl"></span>
                                </label>
                            </div>';

                $statusBadge = '';
                switch ($field->Status) {
                    case 0:
                        $statusBadge = '<span class="label label-default">Draft</span>';
                        break;
                    case 1:
                        $statusBadge = '<span class="label label-success">Submitted</span>';
                        break;
                    case 2:
                        $statusBadge = '<span class="label label-danger">Rejected</span>';
                        break;
                    case 3:
                        $statusBadge = '<span class="label label-danger">Rejected</span>';
                        break;
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

                $badgeApp1 = '';
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
                $opsi .= '<a href="' . base_url('perubahanmpp/detail/' . encode_str($field->ID)) . '" class="btn btn-warning btn-xs" title="Detail"><i class="fa fa-eye"> Detail</i></a>';
                $opsi .= '<button class="btn btn-info btn-xs approval-btn" data-id="' . encode_str($field->ID) . '"><i class="fa fa-file"></i> Approval</button>';
                $opsi .= '</div>';

                $row = array();
                $row[] = $checkbox;
                $row[] = $field->NoPengajuan;
                $row[] = $field->Divisi;
                $row[] = $field->Departemen;
                $row[] = $field->Jabatan;
                $row[] = $tipeLabel;
                $row[] = $field->SifatPerubahan;
                // $row[] = $statusBadge;
                $row[] = $badgeApp1;
                $row[] = $badgeApp2;
                $row[] = $badgeApp3;
                $row[] = date('d-m-Y', strtotime($field->CreatedDate));
                $row[] = $field->CreatedBy;
                $row[] = $opsi;

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->m_approval_mpp->count_all(),
                "recordsFiltered" => $this->m_approval_mpp->count_filtered(),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    public function show_app_divisi()
    {
        if ($this->input->is_ajax_request()) {
            $list = $this->m_approval_mpp->get_datatables('divisi');
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $field) {
                $no++;

                $checkbox = '';
                $checkbox = '<div class="checkbox">
                                <label class="pos-rel">
                                    <input name="ckDetailID[]" type="checkbox" class="ace checkRow" value="' . $field->ID . '">
                                    <span class="lbl"></span>
                                </label>
                            </div>';

                $statusBadge = '';
                switch ($field->Status) {
                    case 0:
                        $statusBadge = '<span class="label label-default">Draft</span>';
                        break;
                    case 1:
                        $statusBadge = '<span class="label label-success">Submitted</span>';
                        break;
                    case 2:
                        $statusBadge = '<span class="label label-danger">Rejected</span>';
                        break;
                    case 3:
                        $statusBadge = '<span class="label label-danger">Rejected</span>';
                        break;
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

                $badgeApp1 = '';
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
                $opsi .= '<a href="' . base_url('perubahanmpp/detail/' . encode_str($field->ID)) . '" class="btn btn-warning btn-xs" title="Detail"><i class="fa fa-eye"> Detail</i></a>';
                $opsi .= '<button class="btn btn-info btn-xs approval-btn" data-id="' . encode_str($field->ID) . '"><i class="fa fa-file"></i> Approval</button>';
                $opsi .= '</div>';

                $row = array();
                $row[] = $checkbox;
                $row[] = $field->NoPengajuan;
                $row[] = $field->Divisi;
                $row[] = $field->Departemen;
                $row[] = $field->Jabatan;
                $row[] = $tipeLabel;
                $row[] = $field->SifatPerubahan;
                // $row[] = $statusBadge;
                $row[] = $badgeApp1;
                $row[] = $badgeApp2;
                $row[] = $badgeApp3;
                $row[] = date('d-m-Y', strtotime($field->CreatedDate));
                $row[] = $field->CreatedBy;
                $row[] = $opsi;

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->m_approval_mpp->count_all(),
                "recordsFiltered" => $this->m_approval_mpp->count_filtered(),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }

    public function show_app_dept()
    {
        if ($this->input->is_ajax_request()) {
            $list = $this->m_approval_mpp->get_datatables('dept');
            $data = array();
            $no = $_POST['start'];

            foreach ($list as $field) {
                $no++;

                $checkbox = '';
                $checkbox = '<div class="checkbox">
                                <label class="pos-rel">
                                    <input name="ckDetailID[]" type="checkbox" class="ace checkRow" value="' . $field->ID . '">
                                    <span class="lbl"></span>
                                </label>
                            </div>';

                $statusBadge = '';
                switch ($field->Status) {
                    case 0:
                        $statusBadge = '<span class="label label-default">Draft</span>';
                        break;
                    case 1:
                        $statusBadge = '<span class="label label-success">Submitted</span>';
                        break;
                    case 2:
                        $statusBadge = '<span class="label label-danger">Rejected</span>';
                        break;
                    case 3:
                        $statusBadge = '<span class="label label-danger">Rejected</span>';
                        break;
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

                $badgeApp1 = '';
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
                $opsi .= '<a href="' . base_url('perubahanmpp/detail/' . encode_str($field->ID)) . '" class="btn btn-warning btn-xs" title="Detail"><i class="fa fa-eye"> Detail</i></a>';
                $opsi .= '<button class="btn btn-info btn-xs approval-btn" data-id="' . encode_str($field->ID) . '"><i class="fa fa-file"></i> Approval</button>';
                $opsi .= '</div>';

                $row = array();
                $row[] = $checkbox;
                $row[] = $field->NoPengajuan;
                $row[] = $field->Divisi;
                $row[] = $field->Departemen;
                $row[] = $field->Jabatan;
                $row[] = $tipeLabel;
                $row[] = $field->SifatPerubahan;
                // $row[] = $statusBadge;
                $row[] = $badgeApp1;
                $row[] = $badgeApp2;
                $row[] = $badgeApp3;
                $row[] = date('d-m-Y', strtotime($field->CreatedDate));
                $row[] = $field->CreatedBy;
                $row[] = $opsi;

                $data[] = $row;
            }

            $output = array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->m_approval_mpp->count_all(),
                "recordsFiltered" => $this->m_approval_mpp->count_filtered(),
                "data" => $data,
            );

            echo json_encode($output);
        }
    }
}
