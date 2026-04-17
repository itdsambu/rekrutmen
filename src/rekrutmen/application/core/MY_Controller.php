<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	
	protected $defaultredirecturl;//'Welcome/index';
	protected $sessname;// ='u_user';
	protected $loaddatatable=false;
	
	public function __construct(){
	     parent::__construct();
		 date_default_timezone_set("Asia/Jakarta");
		 if(!$this->session->userdata('userid')){
			redirect('login');			
         }else{
			$this->load->library('template2');
			$this->load->library('datatablesql2');
			$this->loadinglibrary();
			$this->loadingmodel();
		 }		 
	}	
	
	protected function loadinglibrary(){
		
	}
	
	protected function loadingmodel(){
		
	}
	

	protected function getpost($postname){
		$result = $this->input->post($postname);
		return $result;
	}
	
	protected function getget($getname){
		$result = $this->input->get($getname);
		return $result;
	}

	//-----------DATATABLE REQUESTED SERVER SIDE
    protected function GetRequestFromDataTable(){
      $param = array();
      $startrec = $this->input->post('start');
      $length = $this->input->post('length');
      $column = $this->input->post('columns');
      $draw = $this->input->post('draw');
      $search=$this->input->post('search');
      $orders=$this->input->post('order');
      $extradata=$this->input->post('extraData');
      $columnorder = $this->input->post('columnorder');

      $js = $this->input->post('extraData');
	  $colorder = array();
	  
	  foreach ($column as $item){
		   if($item['orderable']=='true'){
			  $colorder[] = $item['data'];
		  } 
	  }
	  
      if(is_array($js)){
      	$param['extradata']=$js;
      }else{
         $param['extradata']=$extradata;
      }
      $param['start']=$startrec;
      $param['length']=$length;
      $param['column']=$column;
      $param['draw']=$draw;
      $param['search']=$search;
      $param['order']=$orders;
      $param['columnorder']=$columnorder;
	  $param['coreorder']=$colorder;
      
      return $param;
    }
    //---------------END OF DATATABLE REQUESTED SERVER SIDE
	

	
	//-----------------------------------------
	//              to excell	
	
	public function exporttoExcell($data,$writeheader,$writedetail,$getfilenames){
		
		$spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
		$sheet =  $spreadsheet->getActiveSheet();
		
		$writeheader($sheet);
		$writedetail($sheet,$data);
		$filename = $getfilenames();
		
		header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'. $filename . '"');
        header('Cache-Control: max-age=0');
		
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
		
		$writer->save('php://output');
	}
	
	public function serMessage($caps,$errmsg,$errno='error'){
		$this->session->set_flashdata('caps',$caps);
		$this->session->set_flashdata('msg',$errmsg);
		$this->session->set_flashdata('status',$errno);
	}

	public function SetError($Error=1,$ErrCode=0,$ErrMsg='',$param=null){
		$this->session->set_flashdata('Err',$Error);
		$this->session->set_flashdata('ErrCode',$ErrCode);
		$this->session->set_flashdata('ErrMsg',$ErrMsg);
		$this->session->set_flashdata('Param',$param);
	}
	
	public function SetErrorAjax($Error,$Msg){
		$ar = array('Err'=>$Error,'Msg'=>$Msg);
		return $ar;
	}
	
	//--------------utility
	protected function isFoundEmpty($param){
		$foundisempty = false;
		foreach($param as $var){
			if($var==''){
				$foundisempty = true;
			}
		}
		return $foundisempty;
	}
	
	
	protected function isDateValid($tgl){
		if( !date_create_from_format('d-m-Y',$tgl) )
		{
			$tgls= date_create_from_format('d-m-Y',$tgl);
			return $tgls;
		}else{
			return false;
		}
	}
	
	protected function formatdatetime($nilai,$formatawal,$formatakhir)
	{
		$tgl = date_create_from_format($formatawal,$nilai);
		$hasil = $tgl->format($formatakhir);
		return $hasil;
	}

	protected function UpLoadFile($tagname,$pathfile,$exts=null){
		$error='';
		$namafile='';
		
		$config['upload_path'] = $pathfile;
		$config['allowed_types'] = '*';
        $config['max_filename'] = '255';
        $config['encrypt_name'] = TRUE;
        $config['max_size'] = '1024'; //1 MB

		if ( isset($_FILES[$tagname]['name'] )){
			if ( 0 < $_FILES[$tagname]['error']){
				$error = 'Error saat upload file. Error no. ' . $_FILES[$tagname]['error'];
			}else{
				//cek extension
				if(null!=$exts){					
					$nfile = $_FILES[$tagname]['name'];
					$ext = pathinfo($nfile);
					if(strtoupper($ext['extension'])!=strtoupper($exts)){
						$error='File upload harus format  ' .  $exts;
						$returndata= array('Err'=>$error,'filename'=>'');
						return $returndata;
					}
				}
				$this->load->library('upload',$config);
				if ( !$this->upload->do_upload($tagname) ){
					$error = $this->upload->display_errors();
				}else{
					$upload_data = $this->upload->data();
					$namafile = $upload_data['file_name'];
				}
			}
		}else{
			$error = 'Select file to upload';
		}
		$returndata= array('Err'=>$error,'filename'=>$namafile);
		return $returndata;
	}
	
	
}