<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class listpemborong extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('darurat');

        $status = $this->darurat->getStatus();
        if($status === 1 && $this->session->userdata('userid') !=='ismo_adm'){
            redirect(site_url('maintenanceControl'));
        }

        date_default_timezone_set("Asia/Jakarta");
        if(!$this->session->userdata('userid')){
            redirect('login');
        }
        $this->load->model('m_listpemborong');
        }

     function index(){
        $data['getData']    = $this->m_listpemborong->get_DataPemborong();
        $data['get_DataMst']    = $this->m_listpemborong->get_DataMst();
        $this->template->display('transaksi/list_pemborong/index',$data);
     }

    function simpan(){
        $idpemborong        = $this->input->post('idpemborong');
        $pemborong          = $this->input->post('pemborong');
        $status             = $this->input->post('status');

          $count = count($pemborong);
             for($i=0; $i<$count; $i++){
                    $data = array(
                        'IDPemborong'   => $idpemborong[$i],
                        'Pemborong'     => $pemborong[$i],
                        'Status'        => $status[$i],
                        'UpdateBy'      => $this->session->userdata('username'),
                        'UpdateDate'    => date('Y-m-d H:i:s')
                 );

                 // echo 'ha-';
                 // $this->m_listpemborong->simpanData($data);

              $this->m_listpemborong->update($idpemborong[$i],$data);
            }
            redirect('listpemborong');
             }
        }
?>