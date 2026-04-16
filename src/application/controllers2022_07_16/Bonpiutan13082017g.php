<?php

class BonPiutang extends CI_Controller {
	
	public function __construct() {
	   parent::__construct();
	   if(!$this->session->userdata('userid')){
            redirect('login');
       }
	   $this->load->model('m_bonpiutang');
	   $this->load->library('template2');
	   
	   date_default_timezone_set("Asia/Jakarta");
	}
	
	private function cekproperty($propdata){
		if( !isset($propdata) )
			return false;
		else
			return true;
	}
	
	//DATATABLE REQUESTED SERVER SIDE
    private function GetRequestFromDataTable(){
      $param = array();
      $startrec = $this->input->post('start');
      $length = $this->input->post('length');
      $column = $this->input->post('columns');
      $draw = $this->input->post('draw');
      $search=$this->input->post('search');
      $orders=$this->input->post('order');
      $extradata=$this->input->post('extradata');
      $columnorder = $this->input->post('columnorder');

      $js = $this->input->post('extradata');
	  
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
      
      return $param;
    }
    //---------------END OF DATATABLE REQUESTED SERVER SIDE
	
	
	//--------------get url
	//TRANSAKSI - UPDATE BON TK (UTANG TK)	
	public function utangtk() //url request
	{
		$jsadd = array('jsadd/sweetalert.min.js','jsadd/bootstrap-select.min.js','jsadd/underscore-min.js','jsadd/backbone-min.js','jsadd/backdatatableserver.js',
		               'jsadd/bonutang.js');
        $cssadd = array('sweetalert.css','bootstrap-select.min.css','addcss/buttons.bootstrap.min.css','bontk.css');					   
					   
		$periode = $this->m_bonpiutang->get_periodebon();			   
		$rowbon = $periode->row();
		$param = array($rowbon->currperiode,'0');
		$islock = $this->m_bonpiutang->islock($param);
        $perusahaan = $this->m_bonpiutang->getallperusahaan();		
		$this->template2->display('transaksi/bonpiutang/vbonpiutang',array('islock'=>$islock,'jsadd'=>$jsadd,'cssadd'=>$cssadd,'periode'=>$rowbon,'data'=>$perusahaan));
	}
	
	public function notbontk() //request from 
	{
		$param = $this->GetRequestFromDataTable();

		$param['coresearch']='k.nik like @1 or k.nama like @1 or convert(varchar,k.FixNo) like @1 or d.DeptAbbr like @1 or pek.Pekerjaan like @1';
		$param['coreorder'] = array('d.DeptAbbr','pek.Pekerjaan','k.FixNo','k.Nik','k.Nama','a.Bon');
		$param['realfield']=' * ';		
		$param['extradata']['bontk'] = 0;
		
		$query = $this->m_bonpiutang->get_tkbonprocess($param);
		echo json_encode($query);
	}	
	
	//make bon tk
	public function storebon(){
		//detect is lock			
		$data = json_decode($this->input->post('model'));
		if(count($data)==0)
		{
			echo json_encode(array('error'=>1));
			return;
		}
		$firstitem = $data[0];
		$isexists = $this->ispropertyexists($firstitem,array('idperusahaan','periode'));
		if($isexists){
			$param = array($firstitem->periode,$firstitem->idperusahaan);
			$islock = $this->m_bonpiutang->islock($param);
		}else{
			$islock=1;
		}
		
		if($islock==1){
			echo json_encode(array('error'=>1));
			return;
		};
	    foreach( $data as $itemmodel ){
			$isexists = $this->ispropertyexists($itemmodel,array('bon','fixno','lcid','periode'));
			if($isexists){
				$param = array('fixno'=>$itemmodel->fixno,'bon'=>$itemmodel->bon,'periode'=>$itemmodel->periode,
				                'user'=>$this->session->userdata('userid'));
				if( is_numeric($param['bon']) )	
                    if($param['bon']>0)					
		               $query = $this->m_bonpiutang->update_bon($param);
			}
		}
		echo json_encode(array('error'=>0,'data'=>$data));
	}	
	
	//END TRANSAKSI BON TK
	
	//setting group tk
	public function grouptk(){
		$jsadd = array('jsadd/bootstrap-select.min.js','jsadd/underscore-min.js','jsadd/backbone-min.js','jsadd/backdatatableserver.js',
		               'jsadd/groupperusahaan.js');
	    $cssadd = array('bootstrap-select.min.css');
		$data = $this->m_bonpiutang->getallperusahaan();
		$this->template->display('utility/menu_akses/vgroupperusahaan',array('jsadd'=>$jsadd,'cssadd'=>$cssadd,'data'=>$data));
	}
	
	
	
	//MONITOR -- LIST BON TK
	public function monitorbontkview(){
		$jsadd = array('jsadd/bootstrap-select.min.js','jsadd/underscore-min.js','jsadd/backbone-min.js','jsadd/format.min.js','jsadd/backdatatableserver.min.js',
		               'jsadd/monitoringbontk.js');
        $cssadd = array('bootstrap-select.min.css');
		$periode = $this->m_bonpiutang->get_periodebon();
        $rowbon = $periode->row();
        $perusahaan = $this->m_bonpiutang->getallperusahaan();	
		$allperiode = $this->m_bonpiutang->getperiode_all();
		$this->template2->display('monitor/bontk/vbontk',array('jsadd'=>$jsadd,'cssadd'=>$cssadd,'periode'=>$rowbon,'data'=>$perusahaan,'allperiode'=>$allperiode->result_array()));
	}
	
	public function havebontk(){
		$param = $this->GetRequestFromDataTable();

		$param['coresearch']='k.nik like @1 or k.nama like @1 or convert(varchar,k.FixNo) like @1 or d.DeptAbbr like @1 or pek.Pekerjaan like @1';
		$param['coreorder'] = array('d.DeptAbbr','pek.Pekerjaan','k.FixNo','k.Nik','k.Nama','a.Bon');
		$param['realfield']=' * ';
		
		$param['extradata']['bontk'] = 1;
		$query = $this->m_bonpiutang->get_tkmonitor($param);
		echo json_encode($query);
	}
	//END OF MONITOR LIST BON TK
	
	//MONITOR COUNT OF TENAGA KERJA
	public function monitorcounttk(){
		$jsadd = array('jsadd/bootstrap-select.min.js','jsadd/underscore-min.js','jsadd/backbone-min.js','jsadd/format.min.js','jsadd/backdatatableserver.min.js',
		               'jsadd/monitorcounttk.js');
        $cssadd = array('bootstrap-select.min.css','bontk.css');
		$periode = $this->m_bonpiutang->get_periodebon();
		$rowbon = $periode->row();
		$perusahaan = $this->m_bonpiutang->getallperusahaan();
		$allperiode = $this->m_bonpiutang->getperiode_all();
		$this->template2->display('monitor/bontk/monitorcounttk',array('jsadd'=>$jsadd,'cssadd'=>$cssadd,'periode'=>$rowbon,'data'=>$perusahaan,'allperiode'=>$allperiode->result_array()));
	}
	
	public function bonptmonitor(){
		$param = $this->GetRequestFromDataTable();
		
		$id = $this->session->userdata('groupuser');
		$tgl = date_create_from_format('d-m-Y',$param['extradata']['periode']);
		
		if($id==44 || $id==79 || $id==93 || $id==1)
			$params = array($tgl->format('Y-m-d'));
		else
			$params = array($tgl->format('Y-m-d'),$param['extradata']['perusahaan']);
		
		$query = $this->m_bonpiutang->getbontkcountmonitor($param,$params);		
		echo json_encode($query);
	}
	//end if monitor count tk
	

	//menu utility Utility Bon TK
	public function utilbontk(){
		
		$jsadd = array('jsadd/moment-with-locales.min.js','jsadd/bootstrap-datetimepicker.min.js','jsadd/bootstrap-select.min.js','jsadd/underscore-min.js','jsadd/backbone-min.js','jsadd/format.min.js','jsadd/backdatatableserver.min.js',
		               'jsadd/sweetalert.min.js','jsadd/utilitybontk.js');
        $cssadd = array('sweetalert.css','bootstrap-datetimepicker-standalone.css','bootstrap-select.min.css','bontk.css');	
		$bontksetting = $this->m_bonpiutang->bontk_setting_getdata();
		$row = $bontksetting->row();
		$this->template2->display('utility/bontk/vutilitybontk',array('jsadd'=>$jsadd,'cssadd'=>$cssadd,'databon'=>$row));

	}
	
	//menu utility UnLcok Bon TK
	public function unlockbontk(){
		$jsadd = array('jsadd/sweetalert.min.js','jsadd/bootstrap-select.min.js','jsadd/underscore-min.js','jsadd/backbone-min.js','jsadd/format.min.js','jsadd/backdatatableserver.js',
		               'jsadd/unlockbontk.js');
        $cssadd = array('sweetalert.css','bootstrap-select.min.css','bontk.css');
		
		$periode = $this->m_bonpiutang->get_periodebon();			   
		$rowbon = $periode->row();
		$param = array($rowbon->currperiode,'0');		
		$islock = $this->m_bonpiutang->islock($param);			   
	    $periode = $this->m_bonpiutang->get_periodebon();
        $rowbon = $periode->row();
        $perusahaan = $this->m_bonpiutang->getallperusahaan();
		$this->template2->display('utility/bontk/vunlockbontk',array('islock'=>$islock,'jsadd'=>$jsadd,'cssadd'=>$cssadd,'periode'=>$rowbon,'data'=>$perusahaan));
	}
	
	public function unlocknotbontk(){
		$param = $this->GetRequestFromDataTable();

		$param['coresearch']='k.nik like @1 or k.nama like @1 or convert(varchar,k.FixNo) like @1 or d.DeptAbbr like @1 or pek.Pekerjaan like @1';
		$param['coreorder'] = array('d.DeptAbbr','pek.Pekerjaan','k.FixNo','k.Nik','k.Nama','a.Bon');
		$param['realfield']=' * ';
		
		$param['curperiode']=date_create_from_format('d-m-Y',$param['extradata']['periode'])->format('Y-m-d');
		$query = $this->m_bonpiutang->get_tkbonprocessall($param);
		echo json_encode($query);
	}
	
	//menu utiliy Lock-unlock Bon TK
	public function lockunlockbontk(){
		$jsadd = array('jsadd/sweetalert.min.js','jsadd/bootstrap-select.min.js','jsadd/underscore-min.js','jsadd/backbone-min.js','jsadd/format.min.js','jsadd/backdatatableserver.js',
		               'jsadd/lockunlock.js');
        $cssadd = array('sweetalert.css','bootstrap-select.min.css','bontk.css');		   
		$param = array('islock');
		
		$periode = $this->m_bonpiutang->get_periodebon();			   
		$rowbon = $periode->row();
		$param = array($rowbon->currperiode,'0');
	
		$islock = $this->m_bonpiutang->islock($param);
		$periode = $this->m_bonpiutang->get_periodebon();
		$rowbon = $periode->row();
		$this->template2->display('utility/bontk/vlockunlockbontk',array('islock'=>$islock,'jsadd'=>$jsadd,'cssadd'=>$cssadd,'periode'=>$rowbon));
	}
	
	//-------------end menu utiliy Lock-unlock Bon TK
	
	//datatable request
	
	//lock - unlock perusahaan
	public function lockunlockperusahaan(){
		$param = $this->GetRequestFromDataTable();
		$param['coresearch']='p.perusahaan like @1';
		$param['coreorder']=array('p.IDPerusahaan');
		$param['realfield']=' * ';
		$query = $this->m_bonpiutang->getallperusahaanlockunlock($param);
		echo json_encode($query);
	}	
	
	//enddatatabel request
	
	//setting tk
	public function settingk(){
		$data = json_decode($this->input->post('model'));
		if($data===null){
			echo json_encode(array('error'=>1));
			return;
		};
		$isexists = $this->ispropertyexists($data,array('lastday','endtime'));
		if(!$isexists){
			echo json_encode(array('error'=>1));
			return;
		}
		if(!preg_match('/^[0-9]*$/',$data->lastday)){
			echo json_encode(array('error'=>1));
			return;
		}
		if(!preg_match('/^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/',$data->endtime)){
			echo json_encode(array('error'=>1));
			return;
		}
		$param = array($data->lastday,$data->endtime,$this->session->userdata('userid'));
		$query = $this->m_bonpiutang->bontk_setting_getdata_save($param);
        echo json_encode(array('error'=>0));		
	}
	//end setting tk
	
	public function getinfogrouptk(){
		$param = $this->GetRequestFromDataTable();
		$param['coresearch'] = 'a.groupname like @1 or c.perusahaan like @1';
		$param['coreorder'] = array('a.groupid','a.groupname','b.idperusahaan','c.perusahaan');
		$param['realfield'] = ' * ';
		$query = $this->m_bonpiutang->get_datagroupperusahaan($param);
		echo json_encode($query);
	}
	
	public function getgoruppt(){
	    $data = json_decode($this->input->post('model'));
		if($data===null){
			echo "error";
			return;
		}
		
		$groupid = $data->groupid;
		$pid = $data->idperusahaan;
		$query = $this->m_bonpiutang->updategrouppt(array($groupid,$pid));
		echo json_encode($query->result_array());
	}
	
	private function ispropertyexists($clsprop,$param){
		$isexists = true;
		foreach($param as $item){
			if( !property_exists($clsprop,$item) ){
				$isexists = false;
				break;
			}
		}
		return $isexists;
	}
	
	
	//unlock bon tk
	public function resetbontk(){
		$data = json_decode(file_get_contents('php://input'));		
		$proses = 0;
		$isexists = $this->ispropertyexists($data,array('bon','fixno','lcid','periode'));
		if($isexists){
			$param = array($data->fixno,$data->periode,$data->lcid,				    
			               $this->session->userdata('userid'));
			$query = $this->m_bonpiutang->reset_bontk($param);
			$proses = 1;
		}
		echo json_encode(array('error'=>0,'proses'=>$proses));
	}
	/*
	public function resetbontk(){
		$param=array('islock');
		$islock = $this->m_bonpiutang->islock($param);
		if($islock==1){
			echo json_encode(array('error'=>1));
			return;
		};
		$data = json_decode($this->input->post('model'));
		if(count($data)==0)
		{
			echo json_encode(array('error'=>1));
			return;
		}
		$query=array();
		$proses = 0;
		foreach( $data as $itemmodel ){
			$isexists = $this->ispropertyexists($itemmodel,array('bon','fixno','lcid','periode'));
			if($isexists){
				$param = array('fixno'=>$itemmodel->fixno,'periode'=>$itemmodel->periode,
				                'user'=>$this->session->userdata('userid'));
				$query = $this->m_bonpiutang->reset_bontk($param);
			    $proses++;				
			}
		}	
		echo json_encode(array('error'=>0,'proses'=>$proses));
	}
	*/
	
	//request form datatabel lockunlock for perusahaan
	public function lockpt(){
		$data = json_decode(file_get_contents('php://input'));
		$param = array($data->ids,$data->islock);
		$tgl = date_create_from_format('d-m-Y',$data->periode);
		$param[]=$tgl->format('Y-m-d');
		$param[]=$this->session->userdata('userid');
		$query = $this->m_bonpiutang->setlockperusahaan($param);
		$row = $query->row();
		echo json_encode($row);
	}
	
}