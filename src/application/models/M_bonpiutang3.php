<?php

class M_Bonpiutang extends CI_Model {
	
	protected $tblTrnPotonganBONPemborong = 'RSUPBorongan2010..tblTrnPotonganBONPemborong';
	

	
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
			
			$sql = "select r.IDPemborong as cperusahaan,r.Pemborong,sanksi=isnull(p.Status,0) " .
				   "from RSUPBorongan2010..tblmstpemborong r " .
				   "left join [RSUPTKRequest].[dbo].[tblMstPemborong] p on r.IDPemborong = p.IDPemborong " .
				   "where r.Pemborong is not null order by r.Pemborong";
		}
		else{
		$sql = "select r.IDPemborong as cperusahaan,r.Pemborong,sanksi=isnull(p.Status,0) " .
			"from RSUPBorongan2010..tblmstpemborong r ".
			"left join [RSUPTKRequest].[dbo].[tblMstPemborong] p on r.IDPemborong = p.IDPemborong " .
			"where r.Pemborong is not null and r.IDPemborong=" . $id . " order by r.Pemborong";
			
		   //$sql = "select IDPemborong as cperusahaan,Pemborong " .
		   //       " from RSUPBorongan2010..tblmstpemborong where Pemborong is not null and IDPemborong=" . $id . " order by Pemborong";	
		}		
		$result =  $this->db->query($sql);
		return $result->result_array();
	}
	
	//get all cv
	// public function getallperusahaan(){
	// 	$id=$this->session->userdata('idpemborong');
	// 	if($id==0){
	// 		$id = $this->session->userdata('groupuser');
	// 		if($id==44 || $id==79 || $id==93 || $id==1){
	// 			$sql = "select cperusahaan=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,idperusahaan)),2), idperusahaan,perusahaan from psgborongan..tblmstperusahaan where perusahaan is not null order by perusahaan";
	// 		}else{
	// 			$sql = "select cperusahaan=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,idperusahaan)),2), idperusahaan,perusahaan from psgborongan..tblmstperusahaan where perusahaan is not null and idperusahaan=0 order by perusahaan";	
	// 		}
	// 	}else{
	// 	   $sql = "select cperusahaan=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,idperusahaan)),2), idperusahaan,perusahaan from psgborongan..tblmstperusahaan where perusahaan is not null and idperusahaan=" . $id . " order by perusahaan";	
	// 	}		
	// 	$result =  $this->db->query($sql);
	// 	return $result->result_array();
	// }
	
	
	//get datatabel on menu utility - utility bon tk - lock / unlock ------------- 
	public function getallperusahaanlockunlock($param) //request from datatable
	{
		
		$query = $this->datatablesql->sql_select($param,
		
		    function($param){																				
				$tablefrom = 'RSUPBorongan2010..tblMstPemborong p ' .
			                 " left join RSUPBorongan2010..tblTrnBonAwalPTK k on k.idperusahaan = p.IDPemborong and k.periode='" . $param['curentperiode'] . "' ";
				return $tablefrom;			 
			},
			
			function($param){
				$fieldshow = "ids=p.IDPemborong,pcv=p.pemborong,islock=isnull(k.flaglock1,0)";
				return $fieldshow;
			},
			
			function($param){
				$where  = 'Pemborong is not null';
				return $where;
			}
						
		      
		);
		return $query;			   
	}
	
	
	public function setlockperusahaan($param) //update-save from model
	{
		$query = $this->exec_sql('RSUPBorongan2010..BonTKUnLockPT',$param);
		return $query;
	}
	
	//------end of menu utility - utility bon tk - lock / unlock
	
	
	//get data group 
	public function get_datagroupperusahaan($param){
		$query = $this->datatablesql->sql_select($param,
		
		   function($param){
			   $str = 'dbo.tblUtlGroupUser a left join dbo.tblUserGroupPerusahaan b on a.groupid=b.groupid '.
                      'left join RSUPBorongan2010..tblmstperusahaan c on c.idperusahaan=b.idperusahaan';
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
		$query = $this->exec_sql('RSUPBorongan2010..getperiode',array());
		return $query;
	}
	
	//get islock
	public function islock($param){
		$query = $this->exec_sql('RSUPBorongan2010..isLock',$param);
		$row = $query->row();	   
		return $row->isLock;
	}

	//====================== Export To Excel Monitor =================================

	public function getPemborong_Bon($pemborong_bon){
        $this->db->where('IDPemborong', $pemborong_bon);
        return $this->db->get('RSUPBorongan2010..tblMstPemborong')->row();
    }

	// function laporan_ExceltoBon($periode_bon, $pemborong_bon){
	// $query = $this->db->query("select d.BagianAbbr,k.Nofix,k.Nik,k.Nama,j.Jabatan,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDBagian,k.IDPemborong 
	// 	from RSUPBorongan2010..tblMstTenagaKerja as k 
	//         inner join RSUPBorongan2010..tblMstPemborong as p on k.IDPemborong = p.IDPemborong  
	// 		inner join RSUPBorongan2010..tblMstPerusahaan as pe on pe.IDPerusahaan = p.IDPerusahaan  
	// 		inner join RSUPBorongan2010..tblMstBagian as d on d.BagianID = k.IDBagian 
	// 		inner join RSUPBorongan2010..tblMstJabatan as j on j.IDJabatan = k.IDJabatan 
	// 		inner join RSUPBorongan2010..tblMstPekerjaan as pek on pek.IDPekerjaan = k.IDPekerjaan 
  		
 //  			WHERE p.IDPemborong = '".$pemborong_bon."' AND (k.TanggalKeluar is Null and k.TanggalKeluarTemporary is null) order by d.BagianAbbr ");
 //    return $query->result();
	// }

	function laporan_ExceltoBon($periode_bon, $pemborong_bon){
	$query = $this->db->query("select d.BagianAbbr,k.Nofix,k.Nik,k.Nama,j.Jabatan,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDBagian,k.IDPemborong 
		from RSUPBorongan2010..tblMstTenagaKerja as k 
	        inner join RSUPBorongan2010..tblMstPemborong as p on k.IDPemborong = p.IDPemborong  
			inner join RSUPBorongan2010..tblMstPerusahaan as pe on pe.IDPerusahaan = p.IDPerusahaan  
			inner join RSUPBorongan2010..tblMstBagian as d on d.BagianID = k.IDBagian 
			inner join RSUPBorongan2010..tblMstJabatan as j on j.IDJabatan = k.IDJabatan 
			inner join RSUPBorongan2010..tblMstPekerjaan as pek on pek.IDPekerjaan = k.IDPekerjaan 
  		
  			WHERE p.IDPemborong = '".$pemborong_bon."' AND (k.TanggalKeluar is Null or k.TanggalKeluarTemporary IS NOT NULL) order by d.BagianAbbr ");
    return $query->result();
	}

    //==============================================================================================================================//
	

	//====================== Export To PDF Monitor =================================

	public function getPemborong($pemborong_bon){
        $this->db->where('IDPemborong', $pemborong_bon);
        return $this->db->get('RSUPBorongan2010..tblMstPemborong')->row();
    }

	// function laporan_default($periode_bon, $pemborong_bon){

	// $query = $this->db->query("select d.BagianAbbr,k.Nofix,k.Nik,k.Nama,j.Jabatan,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDBagian,k.IDPemborong,a.Potongan,a.PeriodeGajian from RSUPBorongan2010..tblMstTenagaKerja as k 
	//         inner join RSUPBorongan2010..tblMstPemborong as p on k.IDPemborong = p.IDPemborong  
	// 		inner join RSUPBorongan2010..tblMstPerusahaan as pe on pe.IDPerusahaan = p.IDPerusahaan  
	// 		inner join RSUPBorongan2010..tblMstBagian as d on d.BagianID = k.IDBagian 
	// 		inner join RSUPBorongan2010..tblMstJabatan as j on j.IDJabatan = k.IDJabatan 
	// 		inner join RSUPBorongan2010..tblMstPekerjaan as pek on pek.IDPekerjaan = k.IDPekerjaan 
	// 		left join RSUPBorongan2010..tblTrnPotonganBONPemborong as a on a.FixNo = k.Nofix 
  		
 //  			WHERE a.PeriodeGajian = '".date('Y-m-d', strtotime($periode_bon))."' AND FixNo Is Not NULL AND p.IDPemborong IN (SELECT DISTINCT IDPemborong FROM RSUPBorongan2010..tblMstPemborong as p WHERE p.IDPemborong = ".$pemborong_bon.") AND (k.TanggalKeluar is Null and k.TanggalKeluarTemporary is null) order by d.BagianAbbr ");
 //    return $query->result();
	// }

	function laporan_default($periode_bon, $pemborong_bon){

	$query = $this->db->query("select d.BagianAbbr,k.Nofix,k.Nik,k.Nama,j.Jabatan,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDBagian,k.IDPemborong,a.Potongan,a.PeriodeGajian from RSUPBorongan2010..tblMstTenagaKerja as k 
	        inner join RSUPBorongan2010..tblMstPemborong as p on k.IDPemborong = p.IDPemborong  
			inner join RSUPBorongan2010..tblMstPerusahaan as pe on pe.IDPerusahaan = p.IDPerusahaan  
			inner join RSUPBorongan2010..tblMstBagian as d on d.BagianID = k.IDBagian 
			inner join RSUPBorongan2010..tblMstJabatan as j on j.IDJabatan = k.IDJabatan 
			inner join RSUPBorongan2010..tblMstPekerjaan as pek on pek.IDPekerjaan = k.IDPekerjaan 
			left join RSUPBorongan2010..tblTrnPotonganBONPemborong as a on a.FixNo = k.Nofix 
  		
  			WHERE a.PeriodeGajian = '".date('Y-m-d', strtotime($periode_bon))."' AND FixNo Is Not NULL AND p.IDPemborong IN (SELECT DISTINCT IDPemborong FROM RSUPBorongan2010..tblMstPemborong as p WHERE p.IDPemborong = ".$pemborong_bon.") AND (k.TanggalKeluar is Null or k.TanggalKeluarTemporary IS NOT NULL) order by d.BagianAbbr ");
    return $query->result();
	}

    //==============================================================================================================================//
	
	//get list of tk bon pure datatable sqlserver
	private function get_tkbonprocess_notlocked($param){
		$query = $this->datatablesql->sql_select($param,
		     
			      //the table
			      function($param){
					  //$tgl = date_create_from_format('d-m-Y',$param['curperiode']); 
					  $str = 'RSUPBorongan2010..tblMstTenagaKerja k ' .
							 'join RSUPBorongan2010..tblMstPemborong p on p.IDPemborong = k.IDPemborong ' .
							 'left join RSUPTKRequest..tblMstPemborong sk on sk.IDPemborong=k.IDPemborong ' .
							 'join RSUPBorongan2010..tblMstPerusahaan pe on pe.IDPerusahaan = p.IDPerusahaan ' .
							 'join RSUPBorongan2010..tblMstBagian d on d.BagianID = k.IDBagian ' .
							 'join RSUPBorongan2010..tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
							 'join RSUPBorongan2010..tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
							 'left join ' . $param['tablebon'] . ' a on a.FixNo = k.Nofix '; 
					  $str .= " and a.PeriodeGajian='" . $param['extradata']['periode'] . "'";
					  return $str;
				  },
				  //the field
				  function($param){
					  $str = "d.BagianAbbr,k.Nofix,k.Nik,k.Nama,j.Jabatan,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDBagian,k.IDPemborong," .
					         "Potongan=convert(int,isnull(a.Potongan,0)) ," .
                              "ndata=k.Nofix,sanksi=isnull(sk.Status,0)," .
                              "islockcv=" . $param['islock'] . ",flag1=isnull(a.flagLock1,0),flag2=isnull(a.flagLock2,0)";
					  return $str;
				  },
				  //where conditiona
				  function($param){
					  //where mpd dan harian
					  $stat = $param['extradata']['bontk'];
					  if($param['islock']==0)
					  $str = "(k.TanggalKeluar is null and (k.TanggalKeluarTemporary is null or datediff(DAY,k.TanggalKeluarTemporary,getdate()) < 15) and p.IDPemborong='" . $param['extradata']['pemborong'] . "')";
					  else
					  $str = '(k.TanggalKeluar is null and (k.TanggalKeluarTemporary is null or datediff(DAY,k.TanggalKeluarTemporary,getdate()) < 15) and pe.IDPerusahaan=0)';
				      if($stat==0)
						  $str = $str . ' and isnull(a.Potongan,0)=0';
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
					  $str = 'RSUPBorongan2010..tblMstTenagaKerja k ' .
					         'join RSUPBorongan2010..tblMstPemborong p on p.IDPemborong = k.IDPemborong ' .
					         'left join RSUPTKRequest..tblMstPemborong sk on sk.IDPemborong=k.IDPemborong ' .
							 'join RSUPBorongan2010..tblMstPerusahaan pe on pe.IDPerusahaan = p.IDPerusahaan ' .
							 'join RSUPBorongan2010..tblMstBagian d on d.BagianID = k.IDBagian ' .
							 'join RSUPBorongan2010..tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
							 'join RSUPBorongan2010..tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
							 'join ' . $param['tablebon'] . ' a on a.FixNo =k.Nofix '; 
					  $str .= " and a.PeriodeGajian='" . $param['curperiode'] . "'";
					  return $str;
				  },
				  //the field
				  function($param){
					  $str = "d.BagianAbbr,k.Nofix,k.Nik,k.Nama,j.Jabatan,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDBagian,k.IDPemborong," .
					         "Bon=convert(int,isnull(a.BON,0)) ,sanksi=isnull(sk.Status,0),islockcv=" . $param['islock'] . " " .
                              ",ndata=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,k.Nofix)),2)"							 ;
					  return $str;
				  },
				  //where conditiona
				  function($param){
					  //where mpd dan harian
					  $tgl = date_create_from_format('d-m-Y',$param['curperiode']); 
					  $stat = $param['extradata']['bontk'];
					  if($param['islock']==1)
					     $str = "(k.TanggalKeluar is Null and (k.TanggalKeluarTemporary is null or datediff(DAY,k.TanggalKeluarTemporary,getdate()) < 15) and pe.IDPerusahaan='" . $param['extradata']['pemborong'] . "')";
					  else
					    $str = '(k.TanggalKeluar is Null and (k.TanggalKeluarTemporary is null or datediff(DAY,k.TanggalKeluarTemporary,getdate()) < 15) and pe.IDPerusahaan=0)'; 
                     // $str .= " and k.Nofix  in ( select Nofix from " . $param['tablebon'] . " where " .
					 //                         "convert(date,periode) = '" . $param['curperiode'] . "'" .
					 //						  " and (isnull(flaglock1,0)=1 or isnull(flaglock2,0)=1)" . 
					 //						  ")";
					  return $str;
				  }
		        );
	    return $query;			
	}
	
	public function gettotalsum($idpemborong,$idperiodegajian){
		$sql = "select total=sum(isnull(a.potongan,0))
                from RSUPBorongan2010..tblMstTenagaKerja as k 
			    join RSUPBorongan2010..tblMstPemborong as p on k.IDPemborong = p.IDPemborong  
				join RSUPBorongan2010..tblMstPerusahaan as pe on pe.IDPerusahaan = p.IDPerusahaan  
				join RSUPBorongan2010..tblMstBagian as d on d.BagianID = k.IDBagian 
				join RSUPBorongan2010..tblMstJabatan as j on j.IDJabatan = k.IDJabatan 
				join RSUPBorongan2010..tblMstPekerjaan as pek on pek.IDPekerjaan = k.IDPekerjaan
				join RSUPBorongan2010..tblTrnPotonganBONPemborong a on a.FixNo =k.Nofix
                where p.IDPemborong=" . $idpemborong .
                "and a.PeriodeGajian = '".date('Y-m-d', strtotime($idperiodegajian))."'";
		$query = $this->db->query($sql);
		$row = $query->row();
		$total = $row->total;
		return $total;
	}


	//get list of tk bon pure datatable sqlserver
	private function get_tkbonprocess_all($param){
		$query = $this->datatablesql->sql_select($param,
		     
			      //the table
			      function($param){
					  //$tgl = date_create_from_format('d-m-Y',$param['curperiode']); 
					  $str = 'RSUPBorongan2010..tblMstTenagaKerja k ' .
					         'join RSUPBorongan2010..tblMstPemborong p on p.IDPemborong = k.IDPemborong ' .
					         'left join RSUPTKRequest..tblMstPemborong sk on sk.IDPemborong=k.IDPemborong ' .
							 'join RSUPBorongan2010..tblMstPerusahaan pe on pe.IDPerusahaan = p.IDPerusahaan ' .
							 'join RSUPBorongan2010..tblMstBagian d on d.BagianID = k.IDBagian ' .
							 'join RSUPBorongan2010..tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
							 'join RSUPBorongan2010..tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
							 'join ' . $param['tablebon'] . ' a on a.FixNo =k.Nofix '; 
					  $str .= " and a.PeriodeGajian='" . $param['curperiode'] . "'";
					  return $str;
				  },
				  //the field
				  function($param){
				  	 // $total = $this->gettotalsum($param['extradata']['pemborong'],$param['curperiode']);
					  $str = "d.BagianAbbr,k.Nofix,k.Nik,k.Nama,j.Jabatan,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDBagian,k.IDPemborong," .
					         "Potongan=convert(int,isnull(a.Potongan,0)) ,sanksi=isnull(sk.Status,0),islockcv=" . $param['islock'] . " " .
							 ",PeriodeGajian='" . $param['curperiode'] . "'" .
                              ",flaglock1=isnull(a.flagLock1," . $param['islock'] ."),flagLock2=isnull(a.flagLock2,0),ndata=k.Nofix," .
							 "totalsum ='" . $param['totalsum'] ."'";
					  return $str;
				  },
				  //where conditiona
				  function($param){
					  //where mpd dan harian
					  $tgl = date_create_from_format('d-m-Y',$param['curperiode']); 
					  //$stat = $param['extradata']['bontk'];
					 // if($param['islock']==1)
					    // $str = "(k.TanggalKeluar is Null and k.TanggalKeluarTemporary is null and p.IDPemborong='" . $param['extradata']['pemborong'] . "')";
					  	$str = "(p.IDPemborong='" . $param['extradata']['pemborong'] . "')";
					 // else
					 //   $str = '(d.BagianID=17 or pek.idpekerjaan=1) and (k.TanggalKeluar is null and pe.IDPerusahaan=0)'; 
                     // $str .= " and k.Nofix  in ( select Nofix from " . $param['tablebon'] . " where " .
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
		$param['tablebon']= $this->tblTrnPotonganBONPemborong;
		$tgl = date_create_from_format('d-m-Y',$param['extradata']['periode']);
		$param['islock'] = $this->islock(array($tgl->format('Y-m-d'),$param['extradata']['pemborong']));
		$query = $this->get_tkbonprocess_all($param);
		return $query;
	}
	
	//get data bontk were processed
	public function get_tkbonprocesshavelock($param){
		$periode = $this->get_periodebon();
		$rowperiode = $periode->row();
		$param['curperiode'] = $rowperiode->curperiode;
		$param['tablebon']= $this->tblTrnPotonganBONPemborong;
		$param['islock'] = $this->islock(array('islock'));
		$query = $this->get_tkbonprocess_locked($param);
		return $query;
	}
	
	//get data bontk has not been process
	public function get_tkbonprocess($param){		
	    $param['tablebon'] = $this->tblTrnPotonganBONPemborong; //table		
		$periode = $this->get_periodebon();
		$rowperiode = $periode->row();
		$param['islock'] = $this->isLock(
				array(
					$param['extradata']['periode'],
					$param['extradata']['pemborong']
				)
		);		
		$query = $this->get_tkbonprocess_notlocked($param);
		return $query;	
	}
	
	//get data bontk monitor - 
	public function get_tkmonitor($param){		
		$param['tablebon'] = $this->tblTrnPotonganBONPemborong;
		$tgl = date_create_from_format('d-m-Y',$param['extradata']['periode']);
		$param['islock'] = $this->isLock(array($tgl->format('Y-m-d'),$param['extradata']['pemborong']));
		$param['curperiode'] = $tgl->format('Y-m-d');
		//$query = $this->get_tkbonprocess_locked($param);
		$total = $this->m_bonpiutang->gettotalsum($param['extradata']['pemborong'],$param['curperiode']);
		$param['totalsum']=$total;
		$query = $this->get_tkbonprocess_all($param);
		return $query;	
	}
	
	
	//------------------------------ update insert to database -------------------------------------------
	
	public function updategrouppt($params){
		$query = $this->exec_sql('updategrouppt',$params);
		return $query;
	}
	
	//save bon tk
	public function update_bon($param){
		
		$params = array($param['Nofix'],$param['periode'],$param['potongan'],$param['user']);
	    $query = $this->exec_sql('RSUPBorongan2010..BonTkUpdate',$params);
		return $query;
	}
	//reset bon tk
	public function reset_bontk($param){
		//$tgl = date_create_from_format('d-m-Y',$param['periode']);
		//$params = array($param['Nofix'],$tgl->format('Y-m-d'),$param['user']);
		$query = $this->exec_sql('RSUPBorongan2010..BonTkUnlock',$param);
		return $query;
	}
	
	public function bontk_setting_getdata(){
		$query = $this->db->query('select top 1 h=bontklastday,bontkhour=CONVERT(varchar(5),bontkhour) from RSUPBorongan2010..tblbontk_setting order by id desc');
		return $query;
	}
	
	public function bontk_setting_getdata_save($param){
		$query = $this->exec_sql('RSUPBorongan2010..BonTkSetting',$param) ;
		$i = 1;
		return $i;
	}
	
	public function getperiode_all(){
		$query = "select * from ( " .
				 " select showperiode=convert(varchar(10),PeriodeGajian,105),vperiode = CONVERT(varchar(10),PeriodeGajian,121),mperiode=PeriodeGajian " .
				 " from " . $this->tblTrnPotonganBONPemborong . 
				 " where PeriodeGajian not in (select currperiode from RSUPBorongan2010..vwcurperiode) " .
				 " Group by PeriodeGajian  ) as a " .
				 " order by year(mperiode) desc, MONTH(mperiode) desc, DAY(mperiode) desc";
        $alldept = $this->db->query($query);
        return $alldept;		
	}
	
	//datatable from menu monitor - monitorcountbontik
	public function getbontkcountmonitor($paramdb,$param){
		$query = $this->exec_sql('RSUPBorongan2010..BonTKUCountMonitor',$param);
		$ar = $query->result_array();
		$ardata= array();
		if ( count($ar)>0 ){
			$total = $ar[0]['jumlah'];
		}else{
			$total = 1;
		}
        $ardata['draw'] = $paramdb['draw'];
		$ardata['recordsTotal']=$total;
		$ardata['recordsFiltered']=$total;
		$ardata['data'] = $ar;//query->result();
		return $ardata;
	}
	


	
}