<?php defined('BASEPATH') OR exit('No direct script access allowed');


require_once APPPATH . 'core/BaseController.php';

class Cuti extends BaseController{

    
	protected function loadingmodel(){
        $this->load->model('Mdl_CutiIjin');
		$this->load->model('Mdl_Utility');
    }
	
	public function index(){
		redirect('cuti/inputcuti');
	}

    public function inputcuti(){

		//is edit ??
        $rifd = $this->session->flashdata('rifid');	
		if(isset($rifd)){
			$data['_rifid'] = $rifd;
			$ndata = decode_str($rifd);
			$query = $this->Mdl_CutiIjin->getcutifromIdRef($ndata);
			if($query->num_rows()>0){
				$row = $query->row();
				$row->TglAwalCuti = $this->formatdatetime($row->TglAwalCuti,'Y-m-d H:s:00.000','d-m-Y');
				$row->TglAkhirCuti = $this->formatdatetime($row->TglAkhirCuti,'Y-m-d H:s:00.000','d-m-Y');
				$row->TglKembaliKerja = $this->formatdatetime($row->TglKembaliKerja,'Y-m-d H:s:00.000','d-m-Y');
				$row->foridkry = encode_str($row->NIK);
				$data['_getcuti'] = $row;
				//$approvallist = $this->Mdl_CutiIjin->getListApprovalDept($row->DeptID);
				//$data['_getapproval'] = $approvallist->result();			
			}
		}elseif($this->session->userdata('u_dept')!=''){
			$this->Mdl_Utility->setSessionNikDept();
			//$approvallist = $this->Mdl_CutiIjin->getListApprovalDept($this->session->userdata('u_dept'));
			//$data['_getapproval'] = $approvallist->result();
		}
		
		if(null!=$this->session->flashdata('Err')){
			$data['_geterror'] = array('ErrMsg'=>$this->session->flashdata('ErrMsg'));
		}
		
		//css load
        $data['_addcss']= array('css/cuti.css',
		                        'css/bootstrap-select.min.css',
								'css/sweetalert2.min.css',
								'plugins//bootstrap-datepicker/bootstrap-datetimepicker.min.css');

		//get deptID yang dapat diakses
		$query = $this->Mdl_Utility->getDeptAccSecure($this->session->userdata('u_group'),1400);
		if(count($query)>0)
			$dept = $this->Mdl_Utility->LoadDeptFromDeptID($query);
		else{
			$dept = $this->Mdl_Utility->LoadDeptFromDeptID(array($this->session->userdata('u_dept')));
		}
		$data['_deptname'] = $dept;

		//get dispensasi
		$query = $this->Mdl_CutiIjin->getDataListDispensasi();
		$data['_dispensasi']=$query->result();
		
		//get datatable server side setting
		$tblparam = $this->datatablesql->data_html('tblmonkary','tblkry','./getdatakary','karydata'
		        ,function(){
					$rowhead = array('NIK','Nama','Dept','Jabatan');
					return $rowhead;
				}				
				,function(){
					$arcol = array(
					              array('data'=>'NIK','defaultContent'=>'','width'=>50,'hidden'=>0),	
								  array('data'=>'NAMA','defaultContent'=>'','className'=>'textkkm'),
								  array('data'=>'DeptAbbr','className'=>'text-center'),
								  array('data'=>'JabatanName')								  							  
					          );
					return $arcol;
				});
		$data['_dbtable'] = $tblparam;	
		$harilibur = $this->Mdl_CutiIjin->gethariliburnasional();
		$data['_harilibur'] = $harilibur->result();
        $this->template->display('karyawan/cuti_izin/inputcuti',$data);
	}
	
	public function getdatakary(){
		$param = $this->GetRequestFromDataTable();
		$param['coresearch']='NIK like @1 OR NAMA LIKE @1';
		$query = $this->Mdl_CutiIjin->datatableKaryawan($param);
		echo json_encode($query);
	}
	
	public function findnikpelimpahan(){
		$nik = $this->input->get('nik');
		$nikcuti = $this->input->get('nikcuti');
		if(null==$nikcuti){
			$data = $this->SetErrorAjax(1,'Karyawan cuti harus di isi lebih dulu');
			echo json_encode($data);
			return;
		}
		
		if(is_numeric($nik)==false || !null!=$this->session->userdata('u_dept')){
			$data = $this->SetErrorAjax(1,'NIK harus dalam format angka (0..9)! ' );
			echo json_encode($data);
			return;
		}
		
		$nik = $this->db->escape($nik);
		$krycuti = $this->Mdl_CutiIjin->find_kry($nik);
		$krypelimpahan = $this->Mdl_CutiIjin->find_krypelimpahan($nik);
		if($krycuti->num_rows()>0 && $krypelimpahan->num_rows()>0){
			$row=$krycuti->row();
			$rowpe = $krypelimpahan->row();
			if($row->DeptID == $rowpe->DeptID){
				$data = $krypelimpahan->result_array();			
				echo json_encode(array('Err'=>0,'data'=>$data));
				return;
			}else{
				$data=$this->SetErrorAjax(1,'Kry untuk pelimpahan tugas harus berasal dari dept yang sama');
				echo json_encode($data);
				return;
			}			
		}else{
			if($krycuti->num_rows()==0)
			{				
				$data = $this->SetErrorAjax(1,'Karyawan cuti tidak ditemukan');
			    echo json_encode($data);
			    return;
			};
			if($krypelimpahan->num_rows()==0)
			{
				$data= $this->SetErrorAjax(1,'Karyawan pelimpahan tugas tidak ditemukan!');
				echo json_encode($data);
				return;
			}
		};				
		
		$querydept = $this->Mdl_Utility->getDetKaryByGroupIdArray($this->session->userdata('u_group'));
		$indept = implode(',',$querydept);
		$query = $this->Mdl_CutiIjin->find_krypelimpahan($nik,$indept);
		if($query->num_rows()>0){
			$hasil= $query->result_array();
			$data = array('Err'=>0,'data'=>$hasil);
		}else{
			$data = array('Err'=>1,'Msg'=>'Data Karyawan tidak ditemukan');			
		}
		echo json_encode($data);
	}


    public function findnik(){  
	
	    $nik = $this->input->get('nik');
		if(is_numeric($nik)==false){
			$data = array('Err'=>1,'Msg'=>'NIK harus dalam format numerik ' . $nik);
			echo json_encode($data);
			return;
		}		
		
		$nik = $this->db->escape($nik);		
		if($this->session->userdata('u_nik')==''){
			$data = array('Err'=>1,'Msg'=>'User login anda belum diset dengan nik');
			echo json_encode($data);
			return;
		}
		
		
		//set seesion dept
		$this->Mdl_Utility->setSessionNikDept();
		if($this->session->userdata('u_dept')==''){
			$data = array('Err'=>1,'Msg'=>'Nik anda anda belum di set / tidak ditemukan!');
			echo json_encode($data);
			return;
		}		
	
				
		//cek apakah group anda bisa mengakses semua dept -- 1400 adalah kode untuk cuti-ijin
	    $query = $this->Mdl_Utility->getDeptAccSecure($this->session->userdata('u_group'),1400);
        if(count($query)==0){
			$query =array($this->session->userdata('u_dept'));
			$argroup = $this->Mdl_Utility->getGroupKrySecurity(1000,1400); //1000  adalah admin dept
		}else{
			$argroup = $this->Mdl_Utility->getGroupKrySecurity($this->session->userdata('u_group'),1400); //psn
		}
		
		if(count($argroup)==0){
			$data = array('Err'=>1,'Msg'=>'Anda tidak dapat mengakses data Dept (user anda belum di set untuk akses cuti');
			echo json_encode($data);
			return;
		}
		
		$ingroup = implode(',',$argroup);
		$indept = implode(',',$query);
		
		$findnik = $this->Mdl_CutiIjin->find_kry($nik,$indept,$ingroup);
		if($findnik->num_rows()>0){
		  $hasil = $findnik->result_array();
		  $hasil[0]['idkry'] = encode_str($hasil[0]['NIK']);
		  $data = array('Err'=>0,'data'=>$hasil);				
		  echo json_encode($data);
		}else{
		  $data = array('Err'=>1,'Msg'=>'Data Karyawan tidak ditemukan');
		  echo json_encode($data);	
		}
		
	}
	
	public function showrekap(){
		$idkry = $this->input->get('idkry');
		$periode = $this->input->get('periode');
		$nik = decode_str($idkry);
		if(!is_numeric($nik) || !is_numeric($periode)){
			echo json_encode(array('Err'=>1,'Msg'=>'Format data tidak benar, pastikan NIK karyawan sudah benar'));
		}else{
			$query = $this->Mdl_CutiIjin->getDataRekapCuti(array($nik,$periode));
			$nquery = $query->result();
			$arfield = array();
			foreach ($nquery as $d){
				if($d->SC>0)
					$arfield[] = array($d->PERIODE,$d->TglMasukStr,$d->JC,$d->SC);
			}			
			echo json_encode(array('Err'=>0,'data'=>$arfield));
		}
	}
	
	//edit
	public function edit(){
		$rifd = $this->input->post('rifd');
		$this->session->set_flashdata('rifid',$rifd);
		redirect('cuti/inputcuti');
	}

	//hapus
	public function hapusdatacuti(){
		$id = $this->input->post('ref');
		$idref = decode_str($id);
		if(!is_numeric($idref)){
			echo json_encode(array('Err'=>1,'Msg'=>'Data ID Cuti tidak benar !' . $idref));
		}else{
			$param = array($idref,$this->session->userdata('u_user'));
			$this->Mdl_CutiIjin->deletecuti($param);
			echo json_encode(array('Err'=>0,'Msg'=>'Done, data cuti berhasil dihapus !'));
		}
	}
	
	//chek cuti 
	public function cek_cuti(){
		$txtnik = $this->input->get('txtnik');
		$tglawal = $this->input->get('tglawal');
		$tglakhir = $this->input->get('tglakhir');

		
		$ta = date_create_from_format('d-m-Y',$tglawal);
		$tak = date_create_from_format('d-m-Y',$tglakhir);
		
		$tglawal = $ta->format('Y-m-d');
		$tglakhir = $tak->format('Y-m-d');

		
		$param = array($txtnik,$tglawal,$tglakhir);
		$query = $this->Mdl_CutiIjin->iscutivalid($param);
		if($query['Err']==1){
			echo json_encode(array('Err'=>1,'Msg'=>$query['Msg']));
		}else{
			echo json_encode(array('Err'=>0));
		}
	}

	
	//approve cuti by dept
	public function cutiapprove(){		
		$data = json_decode($this->input->post('model'));
		
		$ref = decode_str($data->ref);
		$nik = $this->session->userdata('u_nik');
		if($nik==''){
			echo json_encode(array('Err'=>1,'Msg'=>'Nik anda belum diset!'));
			return;
		}
		$status = $data->status;		
		$param = array($ref,$nik,$status);
		
		$query = $this->Mdl_CutiIjin->approvecuti($param);
		$row = $query->result_array();
		echo json_encode($row[0]);
	}
	
	//approve cuti by psn
	public function cutiapprovepsn(){
		$data = json_decode($this->input->post('model'));
		
		$ref = decode_str($data->ref);
		$nik = $this->session->userdata('u_nik');

		if($nik==''){
			echo json_encode(array('Err'=>1,'Msg'=>'Nik anda belum diset!'));
			return;
		}
		$status = $data->status;		
		$param = array($ref,$nik,$status,1);
		
		$query = $this->Mdl_CutiIjin->approvecuti($param);
		$row = $query->result_array();
		echo json_encode($row[0]);
	}
	
	public function updatecuti(){
		$data = $this->input->post(null,true);
		$idref =$data['idref'];
		if($idref!='')
		   $data['idref']= decode_str($idref);		
		$iserror = 0;		
		$tglawal = $this->converttodate($data['tglawal']);
		$tglakhir= $this->converttodate($data['tglakhir']);		
		//---------------tgl validate
		if( !$tglawal || !$tglakhir ){
			echo json_encode(array('Err'=>1,'Msg'=>'Format Tgl awal atau akhir cuti tidak benar ' . $data['tglawal'] . ' ' . $tglakhir));
			return;
		}
		if($data['tglawalizin']!=''){
			$tglawalijin = $this->converttodate($data['tglawalizin']);
			if(!$tglawalijin){
				echo json_encode(array('Err'=>1,'Msg'=>'Format Tgl awal ijin tidak benar'));
				return;
			}else
				$data['tglawalizin']=$tglawalijin;
		}

		if($data['tglakhirizin']!=''){
			$tglakhirizin = $this->converttodate($data['tglakhirizin']);
			if(!$tglakhirizin){
				echo json_encode(array('Err'=>1,'Msg'=>'Format Tgl akhir ijin tidak benar'));
				return;
			}else
			  $data['tglakhirizin']=$tglakhirizin;
		}
		//------------------------end validate tgl
		$data['tglawal'] = $tglawal;
		$data['tglakhir'] = $tglakhir;
		$data['tglkembalikerja']=$tglakhir;
		$data['txtdurasi']='0';
		$data['user']=$this->session->userdata('u_user');
		$data['dept']=$this->session->userdata('u_dept');
		$data['txtdiketahui']='';
		$data['txtdisetujui']='';
		
		$keyvalue = array('idref',
						  'txtnik',
						  'txtnikpelimpahan',
						  'tglawal',
						  'tglakhir',
						  'tglkembalikerja',
						  'txtdurasi',
						  'txtketerangan',
						  'txttujuancuti',
						  'txtperiode',
						  'user',
						  'txtdiketahui',
						  'txtdisetujui',
						  'dept'
					);
		$param = $this->collectdatafromarray($data,$keyvalue);
		$query = $this->Mdl_CutiIjin->addcuti($param);
		$row = $query->row();		
		if($row->Err==0){
			echo json_encode(array('Err'=>0,'Msg'=>'Data cuti berhasil ditambahkan','rifid'=>encode_str($row->Ref)));			
		}
		else
		    echo json_encode(array('Err'=>1,'Msg'=>$row->Msg,'rifid'=>encode_str($row->Ref)));	
		
	}
	
	
	//-------------------->>>MONITORING
	
    //cuti 
	public function monitorcuti(){
		$data['_addcss'] =array('css/sweetalert2.min.css','css/datatables.min.css','css/cuti.css');
		
		$tblparam = $this->datatablesql->data_html('tblmonitorcuti','tblcuti','./getmonitorcuti','cuticol'
		        ,function(){
					$rowhead = array('Opsi','Status','NIK','Nama','Dept','Jabatan','Tgl.Awal Cuti','Tgl.Akhir Cuti','Tgl Kembali Kerja','Pelimpahan Tugas');
					return $rowhead;
				}				
				,function(){
					$arcol = array(
					              array('data'=>'Opsi','defaultContent'=>'','width'=>'100px','hidden'=>0),	
								  array('data'=>'Status','defaultContent'=>'','className'=>'textkkm'),
								  array('data'=>'NIK','className'=>'text-center'),
								  array('data'=>'Nama'),
								  array('data'=>'DeptName','className'=>'text-center'),
								  array('data'=>'Jabatan','className'=>'text-center'),
								  array('data'=>'TglAwalCutistr','className'=>'text-center'),
								  array('data'=>'TglAkhirCutistr','className'=>'text-center'),
								  array('data'=>'TglKembaliKerjastr','className'=>'text-center'),
								  array('data'=>'NIKP','className'=>'text-center')								  
					          );
					return $arcol;
				});
		$data['_dbtable'] = $tblparam;		
		$this->template->display('karyawan/cuti_izin/monitorcuti',$data);
	}
	
	public function getmonitorcuti(){
		$param = $this->GetRequestFromDataTable();
		array_unshift($param['coreorder'],'Ref');
		$query = $this->Mdl_CutiIjin->getDatatableCutiKry($param);
		echo json_encode($query);
	}
	
	//cuti approvallist
	public function monitorcutiapproval(){
		$data['_addcss'] =array('css/datatables.min.css','css/cuti.css','plugins/tooltipster/tooltipster.bundle.min.css',
		                        'css/sweetalert2.min.css');
		
		$tblparam = $this->datatablesql->data_html('tblmonitorcuti','tblcuti','./getmonitorapprovalcuti','cuticol'
		        ,function(){
					$rowhead = array('Opsi','NIK','Nama','Dept','Jabatan','Tgl.Awal Cuti','Tgl.Akhir Cuti','Tgl Kembali Kerja','Pelimpahan Tugas');
					return $rowhead;
				}				
				,function(){
					$arcol = array(
					              array('data'=>'Opsi','defaultContent'=>'','width'=>70,'hidden'=>0),					              
								  array('data'=>'NIK','className'=>'text-center'),
								  array('data'=>'Nama'),
								  array('data'=>'DeptName','className'=>'text-center'),
								  array('data'=>'Jabatan','className'=>'text-center'),
								  array('data'=>'TglAwalCutistr','className'=>'text-center'),
								  array('data'=>'TglAkhirCutistr','className'=>'text-center'),
								  array('data'=>'TglKembaliKerjastr','className'=>'text-center'),
								  array('data'=>'NIKP','className'=>'text-center')								  
					          );
					return $arcol;
				});
		$data['_dbtable'] = $tblparam;		
		$this->template->display('karyawan/cuti_izin/monitorcutiapproval',$data);
	}
	
	public function getmonitorapprovalcuti(){
		$param = $this->GetRequestFromDataTable();
		array_unshift($param['coreorder'],'Ref');
		$param['nik'] = $this->session->userdata('u_nik');
		$query = $this->Mdl_CutiIjin->getMonApprovalCuti($param);
		echo json_encode($query);
	}	
	
	//cuti approval psn
	public function monitorcutiapprovalpsn(){
		$data['_addcss'] =array('css/datatables.min.css','css/cuti.css','plugins/tooltipster/tooltipster.bundle.min.css',
		                        'css/sweetalert2.min.css');
		
		$tblparam = $this->datatablesql->data_html('tblmonitorcuti','tblcuti','./getmonitorapprovalcutipsn','cuticol'
		        ,function(){
					$rowhead = array('Opsi','NIK','Nama','Dept','Jabatan','Tgl.Awal Cuti','Tgl.Akhir Cuti','Tgl Kembali Kerja','Pelimpahan Tugas');
					return $rowhead;
				}				
				,function(){
					$arcol = array(
					              array('data'=>'Opsi','defaultContent'=>'','width'=>120,'hidden'=>0),					              
								  array('data'=>'NIK','className'=>'text-center'),
								  array('data'=>'Nama'),
								  array('data'=>'DeptName','className'=>'text-center'),
								  array('data'=>'Jabatan','className'=>'text-center'),
								  array('data'=>'TglAwalCutistr','className'=>'text-center'),
								  array('data'=>'TglAkhirCutistr','className'=>'text-center'),
								  array('data'=>'TglKembaliKerjastr','className'=>'text-center'),
								  array('data'=>'NIKP','className'=>'text-center')								  
					          );
					return $arcol;
				});
		$data['_dbtable'] = $tblparam;		
		$this->template->display('karyawan/cuti_izin/monitorcutipsn',$data);
	}
	
	public function getmonitorapprovalcutipsn(){
		$param = $this->GetRequestFromDataTable();
		array_unshift($param['coreorder'],'Ref');
		$param['nik'] = $this->session->userdata('u_nik');
		$query = $this->Mdl_CutiIjin->getMonApprovalCutiPsn($param);
		echo json_encode($query);
	}
	
	//---------PRINT
	public function printcuti(){
		$idcuti = $this->input->post('rifdcuti');
		if(null!=$idcuti){
			$idct = decode_str($idcuti);
			$data['_dataHeader']=$this->Mdl_CutiIjin->getdatacuti($idct);
			$data['_dataContent']='';
			$this->load->library(array('fpdf'));
			$this->load->view('karyawan/print/surat_cuti_ijin_pdf',$data);
		};
	}

	//tanggal  utility
	public function cektanggalcuti(){
		$nikcode = $this->input->get('idkry');
		$nik = decode_str($nikcode);

		$periode = $this->input->get('periode');
		$tglawalcuti = $this->input->get('tglawalcuti');
		$tglakhircuti = $this->input->get('tglakhircuti');
		$tglawalijin = $this->input->get('tglawalijin');
		$tglakhirijin = $this->input->get('tglakhirijin');
		$param = array(
			$nik,
			$periode,
			$tglawalcuti,
			$tglakhircuti,
			$tglawalijin,
			$tglakhirijin
		);
		$query = $this->Mdl_Cutiijin->getvalidasitglcutiijin($param);		
	}

}