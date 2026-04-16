<?php

class M_Bonpiutang extends CI_Model {
	
	protected $tblbonawal = 'psgborongan..tblTrnBonAwal';
	

	
	protected $keys = 'key';
	
	public function __construct(){
		parent::__construct();
		$this->load->library('datatablesql');
	}
	
	//util exec stroproc
    public function exec_sql($storeprocname,$arparam){
      $param = 'PARAM_';
      $strparam = $storeprocname;
      $i=0;
      $arr = array();
      foreach ($arparam as  $value) {
        if($i==0)
           $strparam .= ' ?';
        else
           $strparam .=',?';
        $i = $i +  1;
        $param = 'PARAM_' . $i;
        $arr[$param]=$value;
      }
	  if( count($arr) > 0 )
         $query = $this->db->query($strparam,$arr);
	  else
		 $query = $this->db->query($strparam);
      return $query;
    }
	
	
	//------------------select from database
	
	//get all cv
	public function getallperusahaan(){
		$id=$this->session->userdata('idpemborong');
		if($id==0){
			$id = $this->session->userdata('groupuser');
			if($id==44 || $id==79 || $id==93 || $id==1){
				$sql = "select cperusahaan=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,idperusahaan)),2), idperusahaan,perusahaan from psgborongan..tblmstperusahaan where perusahaan is not null order by perusahaan";
			}else{
				$sql = "select cperusahaan=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,idperusahaan)),2), idperusahaan,perusahaan from psgborongan..tblmstperusahaan where perusahaan is not null and idperusahaan=0 order by perusahaan";	
			}
		}else{
		   $sql = "select cperusahaan=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,idperusahaan)),2), idperusahaan,perusahaan from psgborongan..tblmstperusahaan where perusahaan is not null and idperusahaan=" . $id . " order by perusahaan";	
		}		
		$result =  $this->db->query($sql);
		return $result->result_array();
	}
	
	
	
	//get datatabel on menu utility - utility bon tk - lock / unlock ------------- 
	public function getallperusahaanlockunlock($param) //request from datatable
	{
		
		$query = $this->datatablesql->sql_select($param,
		
		    function($param){
				$tablefrom = 'PSGBorongan..tblMstPerusahaan p ' .
			                 " left join PSGBorongan..tblTrnBonAwalPTK k on k.idbonperusahaan = p.IDPerusahaan and k.periode='2017-08-01' ";
				return $tablefrom;			 
			},
			
			function($param){
				$fieldshow = "ids= CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,p.IDPerusahaan)),2),pcv=p.Perusahaan,islock=isnull(k.flaglock1,0)";
				return $fieldshow;
			},
			
			function($param){
				$where  = 'Perusahaan is not null';
				return $where;
			}
						
		      
		);
		return $query;			   
	}
	
	
	public function setlockperusahaan($param) //update-save from model
	{
		$query = $this->exec_sql('PSGBorongan..BonTKUnLockPT',$param);
		return $query;
	}
	
	//------end of menu utility - utility bon tk - lock / unlock
	
	
	//get data group 
	public function get_datagroupperusahaan($param){
		$query = $this->datatablesql->sql_select($param,
		
		   function($param){
			   $str = 'dbo.tblUtlGroupUser a left join dbo.tblUserGroupPerusahaan b on a.groupid=b.groupid '.
                      'left join psgborongan..tblmstperusahaan c on c.idperusahaan=b.idperusahaan';
			   return $str;
		   },
		   function($param){
			   $str = 'a.groupid,a.groupname,b.idperusahaan,c.perusahaan';
			   return $str;
		   }		 
		);
		return $query;
	}
	
    //get periode	
	public function get_periodebon(){
		$query = $this->exec_sql('psgborongan..getperiode',array());
		return $query;
	}
	
	//get islock
	public function islock($param){
		$query = $this->exec_sql('psgborongan..isLock',$param);
		$row = $query->row();	   
		return $row->isLock;
	}
	
	//get list of tk bon pure datatable sqlserver
	private function get_tkbonprocess_notlocked($param){
		$query = $this->datatablesql->sql_select($param,
		     
			      //the table
			      function($param){
					  //$tgl = date_create_from_format('d-m-Y',$param['curperiode']); 
					  $str = 'PSGBorongan..tblMstTenagaKerja k ' .
					         'join PSGBorongan..tblMstPemborong p on p.IDPemborong = k.IDPemborong ' .
							 'join PSGBorongan..tblMstPerusahaan pe on pe.IDPerusahaan = p.IDPerusahaan ' .
							 'join PSGBorongan..tblMstDepartemen d on d.IDDept = k.IDDepartemen ' .
							 'join PSGBorongan..tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
							 'join PSGBorongan..tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
							 'left join ' . $param['tablebon'] . ' a on a.FixNo =k.FixNo '; 
					  $str .= " and a.Periode='" . $param['extradata']['periode'] . "'";
					  return $str;
				  },
				  //the field
				  function($param){
					  $str = "d.DeptAbbr,k.FixNo,k.Nik,k.Nama,j.Jabatan,j.JabAbbr,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDDepartemen,k.IDPemborong," .
					         "Bon=convert(int,isnull(a.BON,0)) ," .
                              "ndata=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,k.FixNo)),2)," .
                              "islockcv=" . $param['islock'] . ",flag1=isnull(a.flagLock1,0),flag2=isnull(a.flagLock2,0)";
					  return $str;
				  },
				  //where conditiona
				  function($param){
					  //where mpd dan harian
					  $stat = $param['extradata']['bontk'];
					  if($param['islock']==0)
					   $str = "(d.iddept=17 or pek.idpekerjaan=1) and (k.TanggalKeluar is null and CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,pe.IDPerusahaan)),2)='" . $param['extradata']['perusahaan'] . "')";
					  else
					   $str = '(d.iddept=17 or pek.idpekerjaan=1) and (k.TanggalKeluar is null and pe.IDPerusahaan=0)';
					  $str = $str . ' and isnull(a.FlagLock1,0)=0 and ISNULL(a.FlagLock2,0)=0 ';
					  return $str;
				  }
		        );
	    return $query;			
	}
	
	//get list of tk bon pure datatable sqlserver
	private function get_tkbonprocess_locked($param){
		$query = $this->datatablesql->sql_select($param,
		     
			      //the table
			      function($param){
					 // $tgl = date_create_from_format('d-m-Y',$param['curperiode']); 
					  $str = 'PSGBorongan..tblMstTenagaKerja k ' .
					         'join PSGBorongan..tblMstPemborong p on p.IDPemborong = k.IDPemborong ' .
							 'join PSGBorongan..tblMstPerusahaan pe on pe.IDPerusahaan = p.IDPerusahaan ' .
							 'join PSGBorongan..tblMstDepartemen d on d.IDDept = k.IDDepartemen ' .
							 'join PSGBorongan..tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
							 'join PSGBorongan..tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
							 'join ' . $param['tablebon'] . ' a on a.FixNo =k.FixNo '; 
					  $str .= " and a.Periode='" . $param['curperiode'] . "'";
					  return $str;
				  },
				  //the field
				  function($param){
					  $str = "d.DeptAbbr,k.FixNo,k.Nik,k.Nama,j.Jabatan,j.JabAbbr,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDDepartemen,k.IDPemborong," .
					         "Bon=convert(int,isnull(a.BON,0)) ,islockcv=" . $param['islock'] . " " .
                              ",ndata=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,k.FixNo)),2)"							 ;
					  return $str;
				  },
				  //where conditiona
				  function($param){
					  //where mpd dan harian
					  $tgl = date_create_from_format('d-m-Y',$param['curperiode']); 
					  $stat = $param['extradata']['bontk'];
					  if($param['islock']==1)
					     $str = "(d.iddept=17 or pek.idpekerjaan=1) and (k.TanggalKeluar is null and CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,pe.IDPerusahaan)),2)='" . $param['extradata']['perusahaan'] . "')";
					  else
					    $str = '(d.iddept=17 or pek.idpekerjaan=1) and (k.TanggalKeluar is null and pe.IDPerusahaan=0)'; 
                     // $str .= " and k.FixNo  in ( select fixno from " . $param['tablebon'] . " where " .
					 //                         "convert(date,periode) = '" . $param['curperiode'] . "'" .
					 //						  " and (isnull(flaglock1,0)=1 or isnull(flaglock2,0)=1)" . 
					 //						  ")";
					  return $str;
				  }
		        );
	    return $query;			
	}
	
	//get list of tk bon pure datatable sqlserver
	private function get_tkbonprocess_all($param){
		$query = $this->datatablesql->sql_select($param,
		     
			      //the table
			      function($param){
					  //$tgl = date_create_from_format('d-m-Y',$param['curperiode']); 
					  $str = 'PSGBorongan..tblMstTenagaKerja k ' .
					         'join PSGBorongan..tblMstPemborong p on p.IDPemborong = k.IDPemborong ' .
							 'join PSGBorongan..tblMstPerusahaan pe on pe.IDPerusahaan = p.IDPerusahaan ' .
							 'join PSGBorongan..tblMstDepartemen d on d.IDDept = k.IDDepartemen ' .
							 'join PSGBorongan..tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
							 'join PSGBorongan..tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
							 'join ' . $param['tablebon'] . ' a on a.FixNo =k.FixNo '; 
					  $str .= " and a.Periode='" . $param['curperiode'] . "'";
					  return $str;
				  },
				  //the field
				  function($param){
					  $str = "d.DeptAbbr,k.FixNo,k.Nik,k.Nama,j.Jabatan,j.JabAbbr,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDDepartemen,k.IDPemborong," .
					         "Bon=convert(int,isnull(a.BON,0)) ,islockcv=" . $param['islock'] . " " .
							 ",periode='" . $param['curperiode'] . "'" .
                              ",flaglock1=isnull(a.flagLock1," . $param['islock'] ."),flagLock2=isnull(a.flagLock2,0),ndata=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,k.FixNo)),2)"							 ;
					  return $str;
				  },
				  //where conditiona
				  function($param){
					  //where mpd dan harian
					  $tgl = date_create_from_format('d-m-Y',$param['curperiode']); 
					  //$stat = $param['extradata']['bontk'];
					 // if($param['islock']==1)
					     $str = "(d.iddept=17 or pek.idpekerjaan=1) and (k.TanggalKeluar is null and CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,pe.IDPerusahaan)),2)='" . $param['extradata']['perusahaan'] . "')";
					 // else
					 //   $str = '(d.iddept=17 or pek.idpekerjaan=1) and (k.TanggalKeluar is null and pe.IDPerusahaan=0)'; 
                     // $str .= " and k.FixNo  in ( select fixno from " . $param['tablebon'] . " where " .
					 //                         "convert(date,periode) = '" . $param['curperiode'] . "'" .
					 //						  " and (isnull(flaglock1,0)=1 or isnull(flaglock2,0)=1)" . 
					 //						  ")";
					  return $str;
				  }
		        );
	    return $query;			
	}
	
	//all 
	public function get_tkbonprocessall($param){
		$periode = $this->get_periodebon();
		$rowperiode = $periode->row();
		$param['tablebon']= $this->tblbonawal;
		$tgl = date_create_from_format('d-m-Y',$param['extradata']['periode']);
		$param['islock'] = $this->islock(array($tgl->format('Y-m-d'),$param['extradata']['perusahaan']));
		$query = $this->get_tkbonprocess_all($param);
		return $query;
	}
	
	//get data bontk were processed
	public function get_tkbonprocesshavelock($param){
		$periode = $this->get_periodebon();
		$rowperiode = $periode->row();
		$param['curperiode'] = $rowperiode->curperiode;
		$param['tablebon']= $this->tblbonawal;
		$param['islock'] = $this->islock(array('islock'));
		$query = $this->get_tkbonprocess_locked($param);
		return $query;
	}
	
	//get data bontk has not been process
	public function get_tkbonprocess($param){		
	    $param['tablebon'] = $this->tblbonawal; //table		
		$periode = $this->get_periodebon();
		$rowperiode = $periode->row();
		$param['islock'] = $this->isLock(array($param['extradata']['periode'],$param['extradata']['perusahaan']));		
		$query = $this->get_tkbonprocess_notlocked($param);
		return $query;	
	}
	
	//get data bontk monitor - 
	public function get_tkmonitor($param){		
		$param['tablebon'] = $this->tblbonawal;
		$tgl = date_create_from_format('d-m-Y',$param['extradata']['periode']);
		$param['islock'] = $this->isLock(array($tgl->format('Y-m-d'),$param['extradata']['perusahaan']));
		$param['curperiode'] = $tgl->format('Y-m-d');
		//$query = $this->get_tkbonprocess_locked($param);
		 $query = $this->get_tkbonprocess_all($param);
		return $query;	
	}
	
	
	//------------------------------ update insert to database
	
	public function updategrouppt($params){
		$query = $this->exec_sql('updategrouppt',$params);
		return $query;
	}
	
	//save bon tk
	public function update_bon($param){
		
		$params = array($param['fixno'],$param['periode'],$param['bon'],$param['user']);
	    $query = $this->exec_sql('psgborongan..BonTkUpdate',$params);
		return $query;
	}
	//reset bon tk
	public function reset_bontk($param){
		//$tgl = date_create_from_format('d-m-Y',$param['periode']);
		//$params = array($param['fixno'],$tgl->format('Y-m-d'),$param['user']);
		$query = $this->exec_sql('psgborongan..BonTkUnlock',$param);
		return $query;
	}
	
	public function bontk_setting_getdata(){
		$query = $this->db->query('select top 1 h=bontklastday,bontkhour=CONVERT(varchar(5),bontkhour) from psgborongan..tblbontk_setting order by id desc');
		return $query;
	}
	
	public function bontk_setting_getdata_save($param){
		$query = $this->exec_sql('psgborongan..BonTkSetting',$param) ;
		$i = 1;
		return $i;
	}
	
	public function getperiode_all(){
		$query = "select * from ( " .
				 " select showperiode=convert(varchar(10),periode,105),vperiode = CONVERT(varchar(10),periode,121),mperiode=periode " .
				 " from " . $this->tblbonawal . 
				 " where Periode not in (select currperiode from psgborongan..vwcurperiode) " .
				 " Group by Periode  ) as a " .
				 " order by year(mperiode) desc, MONTH(mperiode) desc, DAY(mperiode) desc";
        $alldept = $this->db->query($query);
        return $alldept;		
	}
	
	
	
	
}