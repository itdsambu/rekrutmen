<?php

class M_Bonpiutang extends MY_Model
{

	protected $tblbonawal = 'tblTrnBonAwal'; // '[192.168.3.32].psgborongan.dbo.tblTrnBonAwal';
	//protected $tblbonawal_bor = 'tblTrnBonAwal';


	protected $keys = 'key';
	private $dbpsgbor;

	public function __construct()
	{
		parent::__construct();
		$this->load->library('datatablesql');
		$this->dbpsgbor = $this->load->database('PSGBOR', TRUE);
	}

	//util exec stroproc
	/*  public function exec_sql($storeprocname,$arparam){
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
	} */

	//update max min bon
	public function updatebonminmax($param)
	{
		$query = $this->exec_sql_db('UpdateMaxMinBonNew', $param, $this->dbpsgbor);
		return $query;
	}


	//------------------select from database

	//get all cv
	public function getallperusahaan()
	{
		$id = $this->session->userdata('idpemborong');
		if ($id == 0) {
			$id = $this->session->userdata('groupuser');
			if ($id == 44 || $id == 79 || $id == 93 || $id == 1) {
				$sql = "select cperusahaan=idperusahaan, idperusahaan,perusahaan from tblmstperusahaan where perusahaan is not null order by perusahaan";
			} else {
				$sql = "select cperusahaan=idperusahaan, idperusahaan,perusahaan from tblmstperusahaan where perusahaan is not null and idperusahaan=0 order by perusahaan";
			}
		} else {
			$sql = "select cperusahaan=idperusahaan, idperusahaan,perusahaan from tblmstperusahaan where perusahaan is not null and idperusahaan=" . $id . " order by perusahaan";
		}
		$result =  $this->dbpsgbor->query($sql);
		return $result->result_array();
	}



	//get datatabel on menu utility - utility bon tk - lock / unlock ------------- 
	public function getallperusahaanlockunlock($param) //request from datatable
	{
		$this->datatablesql->changedb($this->dbpsgbor);
		$query = $this->datatablesql->sql_select(
			$param,

			function ($param) {
				$tablefrom = 'tblMstPerusahaan p ' .
					" left join tblTrnBonAwalPTK k on k.idperusahaan = p.IDPerusahaan and k.periode='" . $param['currperiode'] . "' ";
				return $tablefrom;
			},

			function ($param) {
				//$fieldshow = "ids= CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,p.IDPerusahaan)),2),pcv=p.Perusahaan,islock=isnull(k.flaglock1,0)";
				$fieldshow = "ids= p.IDPerusahaan,pcv=p.Perusahaan,islock=isnull(k.flaglock1,0)";
				return $fieldshow;
			},

			function ($param) {
				$where  = 'Perusahaan is not null';
				return $where;
			},

			function ($erow) {
				$erow->ids = encode_str($erow->ids);
			}


		);
		return $query;
	}


	public function setlockperusahaan($param) //update-save from model
	{
		$query = $this->exec_sql('[192.168.3.32].PSGBorongan.dbo.BonTKUnLockPTNew', $param);
		return $query;
	}

	//------end of menu utility - utility bon tk - lock / unlock


	//get data group 
	public function get_datagroupperusahaan($param)
	{
		$query = $this->datatablesql->sql_select(
			$param,

			function ($param) {
				$str = 'dbo.tblUtlGroupUser a left join dbo.tblUserGroupPerusahaan b on a.groupid=b.groupid ' .
					'left join [192.168.3.32].PSGBorongan.dbo.tblmstperusahaan c on c.idperusahaan=b.idperusahaan';
				return $str;
			},
			function ($param) {
				$str = 'a.groupid,a.groupname,b.idperusahaan,c.perusahaan';
				return $str;
			}
		);
		return $query;
	}

	//get periode	
	public function get_periodebon()
	{
		$query = $this->exec_sql_db('getperiode', array(), $this->dbpsgbor);
		return $query;
	}

	//get islock
	public function islock($param)
	{
		$query = $this->exec_sql_db('isLockNew', $param, $this->dbpsgbor);
		$row = $query->row();
		return $row->isLock;
	}

	public function getminmax($idperusahaan)
	{
		$sql = "select ismin=ISNULL(j.max3month,200000),ismax=isnull(j.maxgeneral,90000000) from tblMstPerusahaan p " .
			" left join tblMstMaxInputBon j on j.idborongan =p.IDPerusahaan " .
			" where IDPerusahaan='" . $idperusahaan . "'";
		$query =  $this->dbpsgbor->query($sql);
		return $query;
	}

	//get min max bon tk
	public function gettkminmaxbon($param)
	{
		$this->datatablesql->changedb($this->dbpsgbor);
		$query = $this->datatablesql->sql_select(
			$param,
			function ($param) {
				$str = "tblMstPerusahaan p " .
					"left join tblMstMaxInputBon j on j.idborongan =p.IDPerusahaan";
				return $str;
			},
			function ($param) {
				$str = "idperusahaan=p.IDPerusahaan, p.Perusahaan, ismin=ISNULL(j.max3month,200000),ismax=isnull(j.maxgeneral,90000000)";
				return $str;
			},
			function ($param) {
				$str = "IDPerusahaan in (select IDPerusahaan from tblMstPemborong)";
				return $str;
			},
			function ($row) {
				$row->ismin = number_format($row->ismin, 0, ",", ".");
				$row->ismax = number_format($row->ismax, 0, ",", ".");
				$row->idperusahaan = encode_str($row->idperusahaan);
			}
		);
		return $query;
	}

	//get list of tk bon pure datatable sqlserver
	private function get_tkbonprocess_notlocked($param)
	{
		//$psgbor = $this->load->database('PSGBOR', TRUE);
		$this->datatablesql->changedb($this->dbpsgbor);
		$query = $this->datatablesql->sql_select(
			$param,

			//the table
			function ($param) {
				//$tgl = date_create_from_format('d-m-Y',$param['curperiode']); 
				$str = 'vwMstTenagaKerjaWidprsh k ' .
					'join tblMstPerusahaan pe on pe.IDPerusahaan = K.IDPerusahaan ' .
					'join tblMstDepartemen d on d.IDDept = k.IDDepartemen ' .
					'join tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
					'join tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
					'left join tblMstMaxInputBon mb on mb.idborongan = pe.IDPerusahaan ' .
					'left join tbltrnBonAwal a on a.FixNo =k.FixNo ';

				//CLOSE 26/03/2020
				/* $str = 'tblMstTenagaKerja k ' .
					         'join tblMstPemborong p on p.IDPemborong = k.IDPemborong ' .
							 'join tblMstPerusahaan pe on pe.IDPerusahaan = p.IDPerusahaan ' .
							 'join tblMstDepartemen d on d.IDDept = k.IDDepartemen ' .
							 'join tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
							 'join tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
							 'left join tblMstMaxInputBon mb on mb.idborongan = pe.IDPerusahaan ' .
							 'left join tblTrnBonAwal a on a.FixNo =k.FixNo ';		 */

				/* $str = 'PSGBorongan.dbo.tblMstTenagaKerja k ' .
					         'join PSGBorongan.dbo.tblMstPemborong p on p.IDPemborong = k.IDPemborong ' .
							 'join PSGBorongan.dbo.tblMstPerusahaan pe on pe.IDPerusahaan = p.IDPerusahaan ' .
							 'join PSGBorongan.dbo.tblMstDepartemen d on d.IDDept = k.IDDepartemen ' .
							 'join PSGBorongan.dbo.tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
							 'join [192.168.3.32].PSGBorongan.dbo.tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
							 'left join PSGRekrutmen..tblMstMaxInputBon mb on mb.idborongan = pe.IDPerusahaan ' .
							 'left join ' . $param['tablebon'] . ' a on a.FixNo =k.FixNo ';							 
					*/
				$str .= " and a.Periode='" . $param['extradata']['periode'] . "'";
				return $str;
			},
			//the field
			function ($param) {
				$str = "d.DeptAbbr,k.FixNo,k.Nik,k.Nama,tglmasuk=convert(varchar(10),k.TanggalMasuk,105),j.Jabatan,j.JabAbbr,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDDepartemen,k.IDPemborong," .
					"isnull(NamaIbu,'') as namaibu,isnull(tgllahirstr,'') as tgllahirstr," .
					"Bon=convert(int,isnull(a.BON,0)) ," .
					"ndata=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,k.FixNo)),2)" .
					",ms=case when dateadd(day,-1,dateadd(month,3,k.TanggalMasuk)) >= '" . $param['onedaylock'] . "' then 1 " .
					" else 4 end " .
					",islockcv=" . $param['islock'] . ",flag1=isnull(a.flagLock1,0),flag2=isnull(a.flagLock2,0) " .
					",ismin = isnull(max3month,200000),ismax=isnull(maxgeneral,90000000)";
				return $str;
			},
			//where conditiona
			function ($param) {
				//where mpd dan harian
				$stat = $param['extradata']['bontk'];
				$ms = $param['extradata']['mskerja'];
				if ($param['islock'] == 0)
					$str = " (k.TanggalKeluar is null and pe.IDPerusahaan = " . $param['extradata']['perusahaan'] . ")"; // CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,pe.IDPerusahaan)),2)='" . $param['extradata']['perusahaan'] . "')";
				else
					$str = ' (k.TanggalKeluar is null and pe.IDPerusahaan=0)';
				if ($stat == 0)
					$str = $str . ' and isnull(a.BON,0)=0';
				if ($ms == 1) {
					$str = $str .
						" and dateadd(day,-1,dateadd(month,3,k.TanggalMasuk)) >= '" .  $param['onedaylock'] . "'";
				}
				$str = $str . ' and isnull(a.FlagLock1,0)=0 and ISNULL(a.FlagLock2,0)=0 ';
				return $str;
			},
			//loopop
			function ($erow) {
				$erow->ndata = encode_str($erow->FixNo);
			},
			$this->dbpsgbor
		);
		return $query;
	}

	//get list of tk bon pure datatable sqlserver
	private function get_tkbonprocess_locked($param)
	{
		$this->datatablesql->changedb($this->dbpsgbor);
		$query = $this->datatablesql->sql_select(
			$param,

			//the table
			function ($param) {
				// $tgl = date_create_from_format('d-m-Y',$param['curperiode']); 
				$str = 'vwMstTenagaKerjaWidprsh k ' .
					'join tblMstPerusahaan pe on pe.IDPerusahaan = k.IDPerusahaan ' .
					'join tblMstDepartemen d on d.IDDept = k.IDDepartemen ' .
					'join tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
					'join tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
					'join ' . $param['tablebon'] . ' a on a.FixNo =k.FixNo ';

				/* 					  $str = 'tblMstTenagaKerja k ' .
					         'join tblMstPemborong p on p.IDPemborong = k.IDPemborong ' .
							 'join tblMstPerusahaan pe on pe.IDPerusahaan = p.IDPerusahaan ' .
							 'join tblMstDepartemen d on d.IDDept = k.IDDepartemen ' .
							 'join tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
							 'join tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
							 'join ' . $param['tablebon'] . ' a on a.FixNo =k.FixNo ';  */
				$str .= " and a.Periode='" . $param['curperiode'] . "'";

				return $str;
			},
			//the field
			function ($param) {
				$str = "d.DeptAbbr,k.FixNo,k.Nik,k.Nama,j.Jabatan,j.JabAbbr,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDDepartemen,k.IDPemborong," .
					"Bon=convert(int,isnull(a.BON,0)) ,islockcv=" . $param['islock'] . " " .
					",ndata=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,k.FixNo)),2)";
				return $str;
			},
			//where conditiona
			function ($param) {
				//where mpd dan harian
				$tgl = date_create_from_format('d-m-Y', $param['curperiode']);
				$stat = $param['extradata']['bontk'];
				if ($param['islock'] == 1)
					$str = "(k.TanggalKeluar is null and CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,pe.IDPerusahaan)),2)='" . $param['extradata']['perusahaan'] . "')";
				else
					$str = '(k.TanggalKeluar is null and pe.IDPerusahaan=0)';
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
	private function get_tkbonprocess_all($param)
	{
		$this->datatablesql->changedb($this->dbpsgbor);
		$query = $this->datatablesql->sql_select(
			$param,

			//the table
			function ($param) {
				//$tgl = date_create_from_format('d-m-Y',$param['curperiode']); 
				$str = 'vwMstTenagaKerjaWidprsh k ' .
					'join tblMstPerusahaan pe on pe.IDPerusahaan = K.IDPerusahaan ' .
					'join tblMstDepartemen d on d.IDDept = k.IDDepartemen ' .
					'join tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
					'join tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
					'join ' . $param['tablebon'] . ' a on a.FixNo =k.FixNo ';
				//26032020		 
				/* $str = 'tblMstTenagaKerja k ' .
					         'join tblMstPemborong p on p.IDPemborong = k.IDPemborong ' .
							 'join tblMstPerusahaan pe on pe.IDPerusahaan = p.IDPerusahaan ' .
							 'join tblMstDepartemen d on d.IDDept = k.IDDepartemen ' .
							 'join tblMstJabatan j on j.IDJabatan = k.IDJabatan ' .
							 'join tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan ' .
							 'join ' . $param['tablebon'] . ' a on a.FixNo =k.FixNo '; */
				$str .= " and a.Periode='" . $param['curperiode'] . "'";


				return $str;
			},
			//the field
			function ($param) {
				$total = $this->gettotalbon($param);
				$param['totalbon'] = $total;
				$jumbon = 0;
				if ($param['totalbon'] != null || $param['totalbon'] != '') {
					$jumbon = $param['totalbon'];
				}
				$str = "totalbon=" . $jumbon . "," . " d.DeptAbbr,k.FixNo,tglmasuk=convert(varchar(10),k.TanggalMasuk,105),k.Nik,k.Nama,j.Jabatan,j.JabAbbr,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDDepartemen,k.IDPemborong," .
					"Bon=convert(int,isnull(a.BON,0)) ,islockcv=" . $param['islock'] . " " .
					",periode='" . $param['curperiode'] . "'" .
					",tglupdate=CONVERT(varchar,a.CreatedDate,103) +' ' +CONVERT(varchar,a.CreatedDate,108)" .
					",useroleh=a.CreatedBy" .
					",flaglock1=isnull(a.flagLock1," . $param['islock'] . "),flagLock2=isnull(a.flagLock2,0),ndata=CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,k.FixNo)),2)";
				return $str;
			},
			//where conditiona
			function ($param) {
				//where mpd dan harian
				$tgl = date_create_from_format('d-m-Y', $param['curperiode']);
				//$stat = $param['extradata']['bontk'];
				// if($param['islock']==1)
				//(d.iddept in (16,17,47,48) or pek.idpekerjaan=1)
				$str = "(pe.IDPerusahaan='" . $param['extradata']['perusahaan'] . "')";
				//$str = "(CONVERT(varchar(32),HASHBYTES('md5',CONVERT(varchar,pe.IDPerusahaan)),2)='" . $param['extradata']['perusahaan'] . "')";
				// else
				//   $str = '(d.iddept=17 or pek.idpekerjaan=1) and (k.TanggalKeluar is null and pe.IDPerusahaan=0)'; 
				// $str .= " and k.FixNo  in ( select fixno from " . $param['tablebon'] . " where " .
				//                         "convert(date,periode) = '" . $param['curperiode'] . "'" .
				//						  " and (isnull(flaglock1,0)=1 or isnull(flaglock2,0)=1)" . 
				//						  ")";
				if (isset($param['extradata']['mskerja'])) {
					$ms = $param['extradata']['mskerja'];
					if ($ms == 1) {
						$str = $str .
							" and CASE WHEN dateadd(MONTH, datediff (MONTH, k.TanggalMasuk, '" . $param['onedaylock'] . "'), k.TanggalMasuk) > '" . $param['onedaylock'] . "'" .
							" THEN datediff(MONTH, k.TanggalMasuk, '" . $param['onedaylock'] . "') - 1 " .
							" ELSE datediff(MONTH, k.TanggalMasuk, '" . $param['onedaylock'] . "') END <=3 ";
					}
				}
				return $str;
			}
		);
		return $query;
	}

	//all 
	public function get_tkbonprocessall($param)
	{
		$periode = $this->get_periodebon();
		$rowperiode = $periode->row();
		$param['tablebon'] = $this->tblbonawal;
		$tgl = date_create_from_format('d-m-Y', $param['extradata']['periode']);
		$param['islock'] = $this->islock(array($tgl->format('Y-m-d'), $param['extradata']['perusahaan']));
		$query = $this->get_tkbonprocess_all($param);
		return $query;
	}

	//get data bontk were processed
	public function get_tkbonprocesshavelock($param)
	{
		$periode = $this->get_periodebon();
		$rowperiode = $periode->row();
		$param['curperiode'] = $rowperiode->curperiode;
		$param['tablebon'] = $this->tblbonawal;
		$param['islock'] = $this->islock(array('islock'));
		$query = $this->get_tkbonprocess_locked($param);
		return $query;
	}

	//get data bontk has not been process
	public function get_tkbonprocess($param)
	{

		$param['tablebon'] = $this->tblbonawal; //table		
		$periode = $this->dbpsgbor->query('select addonedaylock=convert(varchar(10),DATEADD(DAY,1,lockperiode),126) from vwcurperiode');
		$rowperiode = $periode->row();
		$param['islock'] = $this->isLock(array($param['extradata']['periode'], $param['extradata']['perusahaan']));
		$param['onedaylock'] = $rowperiode->addonedaylock;
		$query = $this->get_tkbonprocess_notlocked($param);
		return $query;
	}

	//get data bontk monitor - 

	//total bon
	protected function gettotalbon($param)
	{
		$sql = "select total=ISNULL(sum(a.BON),0) from vwMstTenagaKerjaWidprsh k  " .
			"join tblMstPerusahaan pe on pe.IDPerusahaan = k.IDPerusahaan " .
			"join tblMstDepartemen d on d.IDDept = k.IDDepartemen " .
			"join tblMstJabatan j on j.IDJabatan = k.IDJabatan " .
			"join tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan " .
			"join tblTrnBonAwal a on a.FixNo =k.FixNo  and a.Periode='" . $param['curperiode'] . "'";

		//26-03-2020		  
		/*  $sql = "select total=ISNULL(sum(a.BON),0) from tblMstTenagaKerja k  " .
		          "join tblMstPemborong p on p.IDPemborong = k.IDPemborong  " .
				  "join tblMstPerusahaan pe on pe.IDPerusahaan = p.IDPerusahaan " .
				  "join tblMstDepartemen d on d.IDDept = k.IDDepartemen " .
				  "join tblMstJabatan j on j.IDJabatan = k.IDJabatan " .
				  "join tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan " .
				  "join tblTrnBonAwal a on a.FixNo =k.FixNo  and a.Periode='" . $param['curperiode'] . "'";	 */
		$sql = $sql . " WHERE pe.IDPerusahaan='" . $param['extradata']['perusahaan'] . "'";
		$query = $this->dbpsgbor->query($sql);
		$row = $query->row();
		$total = $row->total;
		return $total;
	}

	public function get_tkmonitor($param)
	{
		$param['tablebon'] = $this->tblbonawal;
		$tgl = date_create_from_format('d-m-Y', $param['extradata']['periode']);
		$param['islock'] = $this->isLock(array($tgl->format('Y-m-d'), $param['extradata']['perusahaan']));
		$param['curperiode'] = $tgl->format('Y-m-d');
		//$query = $this->get_tkbonprocess_locked($param);

		$total = $this->gettotalbon($param);
		$param['totalbon'] = $total;
		$query = $this->get_tkbonprocess_all($param);
		return $query;
	}


	//------------------------------ update insert to database

	public function updategrouppt($params)
	{
		$query = $this->exec_sql('updategrouppt', $params);
		return $query;
	}

	//save bon tk
	public function update_bon($param)
	{

		$params = array($param['fixno'], $param['periode'], $param['bon'], $param['user']);
		$query = $this->exec_sql_db('BonTkUpdateNew', $params, $this->dbpsgbor);
		return $query;
	}
	//reset bon tk
	public function reset_bontk($param)
	{
		//$tgl = date_create_from_format('d-m-Y',$param['periode']);
		//$params = array($param['fixno'],$tgl->format('Y-m-d'),$param['user']);
		$query = $this->exec_sql_db('BonTkUnlock', $param, $this->dbpsgbor);
		return $query;
	}

	public function bontk_setting_getdata()
	{
		$query = $this->dbpsgbor->query('select top 1 h=bontklastday,bontkhour=CONVERT(varchar(5),bontkhour) from tblbontk_setting order by id desc');
		return $query;
	}

	public function bontk_setting_getdata_save($param)
	{
		$query = $this->exec_sql_db('BonTkSetting', $param, $this->dbpsgbor);
		$i = 1;
		return $i;
	}

	public function getperiode_all()
	{
		$query = "select * from ( " .
			" select showperiode=convert(varchar(10),periode,105),vperiode = CONVERT(varchar(10),periode,121),mperiode=periode " .
			" from " . $this->tblbonawal .
			" where Periode not in (select currperiode from vwcurperiode) " .
			" Group by Periode  ) as a " .
			" order by year(mperiode) desc, MONTH(mperiode) desc, DAY(mperiode) desc";
		$alldept = $this->dbpsgbor->query($query);
		return $alldept;
	}

	//datatable from menu monitor - monitorcountbontik
	public function getbontkcountmonitor($paramdb, $param)
	{
		$query = $this->exec_sql_db('BonTKUCountMonitorNew', $param, $this->dbpsgbor);
		$ar = $query->result_array();
		$ardata = array();
		if (count($ar) > 0) {
			$total = $ar[0]['jumlah'];
		} else {
			$total = 1;
		}
		$ardata['draw'] = $paramdb['draw'];
		$ardata['recordsTotal'] = $total;
		$ardata['recordsFiltered'] = $total;
		$ardata['data'] = $ar; //query->result();
		return $ardata;
	}

	public function monitorexcellbontk($param)
	{
		$bonawal = $this->tblbonawal;
		//field
		//$str = "Select top 20 d.DeptAbbr,k.FixNo,tglmasuk=convert(varchar(10),k.TanggalMasuk,105),k.Nik,k.Nama,j.Jabatan,j.JabAbbr,pek.Pekerjaan,k.IDPekerjaan,k.IDJabatan,k.IDDepartemen,k.IDPemborong," .
		//			         "Bon=convert(int,isnull(a.BON,0))".
		//					 ",periode='" . $param['curperiode'] . "'";                          
		$strs = "Select pe.Perusahaan,d.DeptAbbr,j.Jabatan,pek.Pekerjaan,k.Nik,k.Nama," .
			"Bon=convert(int,isnull(a.BON,0))";
		//table
		$strs = $strs .  " from vwMstTenagaKerjaWidprsh k " .
			"join tblMstPerusahaan pe on pe.IDPerusahaan = k.IDPerusahaan " .
			"join tblMstDepartemen d on d.IDDept = k.IDDepartemen " .
			"join tblMstJabatan j on j.IDJabatan = k.IDJabatan " .
			"join tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan "
			. "join " . $bonawal . " a on a.FixNo =k.FixNo "
			. " and a.Periode='" . $param['curperiode'] . "'"
			. " where pe.IDPerusahaan='" . $param['perusahaan'] . "'"
			. " order by d.DeptAbbr,j.Jabatan,k.Nik,k.Nama";

		/* $strs = $strs .  " from tblMstTenagaKerja k " .
			  "join tblMstPemborong p on p.IDPemborong = k.IDPemborong " .
			  "join tblMstPerusahaan pe on pe.IDPerusahaan = p.IDPerusahaan " .
			  "join tblMstDepartemen d on d.IDDept = k.IDDepartemen " .
			  "join tblMstJabatan j on j.IDJabatan = k.IDJabatan " .
			  "join tblMstPekerjaan pek on pek.IDPekerjaan = k.IDPekerjaan "
			   ."join " . $bonawal . " a on a.FixNo =k.FixNo "
               . " and a.Periode='". $param['curperiode'] . "'" 			  
		       . " where pe.IDPerusahaan='" . $param['perusahaan'] . "'" 
			   . " order by d.DeptAbbr,j.Jabatan,k.Nik,k.Nama";		 */

		$query = $this->dbpsgbor->query($strs);
		return $query;
	}
}
