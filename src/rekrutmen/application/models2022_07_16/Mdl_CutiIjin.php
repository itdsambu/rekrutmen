<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_CutiIjin extends MY_Model {
	
	
	public function find_kry($nik,$DeptID=null,$groupID=null){
		$sql = "select K.NIK,K.NAMA,D.DeptAbbr,D.DeptName,J.JabatanName,K.DeptID,LiburMingguan=ISNULL(k.LiburMingguan,0) " .
		       "from PSGPayroll..KARYAWAN k " .
			   "LEFT JOIN PSGPayroll..tblMstDepartemen D ON D.DeptID = K.DeptID " .
			   "LEFT JOIN PSGPayroll..tblMstJabatan J ON J.JabatanID = K.JabatanID " .
			   "where k.TGLKELUAR is null and k.NIK = " . $nik;
	    if(null!=$DeptID){
			$sql = $sql .   " and D.DeptID in (" . $DeptID . ") " .
			                "and k.GroupID in (" . $groupID . ") ";
		}
		$query = $this->db->query($sql);
		return $query;
	}
	
	public function find_krypelimpahan($nik){
		$sql = "select K.NIK,K.NAMA,D.DeptAbbr,D.DeptName,J.JabatanName,K.DeptID,LiburMingguan=ISNULL(k.LiburMingguan,0) " .
		       "from PSGPayroll..KARYAWAN k " .
			   "LEFT JOIN PSGPayroll..tblMstDepartemen D ON D.DeptID = K.DeptID " .
			   "LEFT JOIN PSGPayroll..tblMstJabatan J ON J.JabatanID = K.JabatanID " .
			   "where k.NIK = " . $nik . " " .			
			   "and k.TGLKELUAR is null";
		$query = $this->db->query($sql);
		return $query;
	}
	
	public function datadispensasi(){
		$this->db->where('isnull(NotActive,0)',0);
		$this->db->from('tblMstDispensasi');
		$this->db->order_by('ordernum','asc');
		$query = $this->db->get();
		return $query;
	}
	
	//VALIDITY
	public function iscutivalid($param){
		$query = $this->exec_sql('CekValidityCuti',$param);
		$row = $query->row();
		if($row->Err==1){
			return array('Err'=>1,'Msg'=>$row->Msg);
		}else{
			return array('Err'=>0);
		}
	}
	
	//CRUD
	public function addcuti($param){		
		$query = $this->exec_sql('Cuti_UpdateCuti',$param);
		return $query;		
	}		
	
	public function deletecuti($param){
		$query = $this->exec_sql('Cuti_DeleteCuti',$param);
		return $query;
	}

	public function approvecuti($param){
		$query = $this->exec_sql('ApproveCutiKry',$param);
		return $query;
	}
	
	public function approveijin($param){
		$query = $this->exec_sql('approveIjin',$param);
		return $query;
	}
	
	public function addijin($param){		
		$query = $this->exec_sql('Ijin_UpdateIjin',$param);
		return $query;		
	}
	
	//MONITORING 
	
	public function getcutifromIdRef($idref){
		$this->db->where('Ref',$idref);
		$query = $this->db->get('vwTrn_CutiKaryawan');
		return $query;
	}
	
	public function getijinfromIdRef($idref){
		$this->db->where('Ref',$idref);
		$query = $this->db->get('vwTrn_IjinKaryawan');
		return $query;
	}
	
	//cuti
	public function getDatatableCutiKry($param){
		$Query = $this->datatablesql->sql_select($param,
		   function($param){
			   $table = 'vwTrn_CutiKaryawan';
			   return $table;
		   },function($param){
			   $field = ' Ref,NIK,Nama,DeptName,DeptID,Jabatan,TglAwalCuti,TglAkhirCuti,TglKembaliKerja,NIKP,TglAwalCutistr,TglAkhirCutistr,TglKembaliKerjastr' . 
			            ',Tujuan,Keterangan,Periode,JumlahCuti,NamaP,DeptNameP,JabatanNameP,approve2,approve2name,approve3,approve3name,' . 
						 "approve4,approve4name,complete,".
						 "approve4date=CONVERT(varchar,approve4date,105)+' ' +CONVERT(varchar(5),approve4date,8)," .
						 "approve2date=ISNULL(CONVERT(varchar,approve2date,105)+' ' +CONVERT(varchar(5),approve2date,8),'')," .
						 "approve3date=ISNULL(CONVERT(varchar,approve3date,105)+' ' +CONVERT(varchar(5),approve3date,8),'')";
			   return $field;
		   },
		   null,
		   true,
		   function($row){
			   $row->Ref = encode_str($row->Ref);
			   $row->currentdept = $this->session->userdata('u_dept');			   			   
			   if($row->complete<0)
				   $row->isdifferent=1;
			   else
				   $row->isdifferent = $this->session->userdata('u_dept')==$row->DeptID ? (null==$row->approve2date || null==$row->approve3date) ? 0 : 1 : 1;
		   });
		return $Query;
	}
	
	//print cuti
	public function getdatacuti($refid){
		$sql = 	'SELECT A.Ref,A.Nama,A.NIK,A.DeptAbbr,A.Jabatan, ' .
				'TglAwalCuti=CONVERT(VARCHAR, A.TglAwalCuti,105), '.
				'TglAkhirCuti=CONVERT(VARCHAR, A.TglAkhirCuti,105), '.
				'TglKembaliKerja=CONVERT(VARCHAR, A.TglKembaliKerja,105), '.
				"TglAwalIjin='',TglAkhirIjin='', " .
				'A.Tujuan, '.
				'A.NIKP, '.
				'A.NamaP, '.
				'A.JabatanNameP, '.
				'A.TglMasuk, '.
				'A.Periode,a.JumlahCuti '.
				',TglMasuk = CONVERT(VARCHAR, A.TglMasuk,105) '.
				',HakCuti= 1 '.
				',A.approve2name'.
                ',A.approve3name'.
                ',A.approve4name ' .
				',shortjab2,shortjab3, shortjab4 '.
				',app1date = CONVERT(VARCHAR, approve1date,105) '.
				',app2date = CONVERT(VARCHAR, approve2date,105) ' .
				',app3date = CONVERT(VARCHAR, approve3date,105) ' .
				',app4date = CONVERT(VARCHAR, approve4date,105) ' .
				'FROM vwTrn_CutiKaryawan A '.
				'WHERE Ref='.$refid;
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	//print ijn
	public function getdataijin($refid){
		$sql = 	'SELECT A.Ref,A.Nama,A.NIK,A.DeptAbbr,A.Jabatan, ' .
				'TglAwalIjin=CONVERT(VARCHAR, A.TglAwalIjin,105),  '.
				'TglAkhirIjin=CONVERT(VARCHAR, A.TglAkhirIjin,105), '.
				'TglKembaliKerja=CONVERT(VARCHAR, A.TglKembaliKerja,105),'.
				'A.Tujuan, '.
				'A.NIKP, '.
				'A.NamaP, '.
				'A.JabatanNameP, '.
				'A.TglMasuk, '.
				'A.Periode,a.JumlahHK '.
				',TglMasuk = CONVERT(VARCHAR, A.TglMasuk,105) '.
				',HakCuti= 1 '.
				',A.approve2name'.
                ',A.approve3name'.
                ',A.approve4name ' .
				',shortjab2,shortjab3, shortjab4 '.
				',app1date = CONVERT(VARCHAR, approve1date,105) '.
				',app2date = CONVERT(VARCHAR, approve2date,105) ' .
				',app3date = CONVERT(VARCHAR, approve3date,105) ' .
				',app4date = CONVERT(VARCHAR, approve4date,105) ' .
				',dispensasi,Keterangan,lain2 '.
				'FROM vwTrn_IjinKaryawan A '.
				'WHERE Ref='.$refid;
		$query = $this->db->query($sql);
		return $query->row();
	}
	
	//ijin
	public function getDatatableIjinKry($param){
		$Query = $this->datatablesql->sql_select($param,
		   function($param){
			   $table = 'vwTrn_IjinKaryawan';
			   return $table;
		   },function($param){
			   $field = ' Ref,NIK,Nama,DeptName,DeptID,Jabatan,TglAwalIjin,TglAkhirIjin,TglKembaliKerja,NIKP,TglAwalIjinstr,TglAkhirIjinstr,TglKembaliKerjastr' . 
			            ',Tujuan,Keterangan,Periode,JumlahHK,NamaP,DeptNameP,JabatanNameP,approve2,approve2name,approve3,approve3name,' . 
						 "approve4,approve4name,complete,dispensasi,".
						 "approve4date=CONVERT(varchar,approve4date,105)+' ' +CONVERT(varchar(5),approve4date,8)," .
						 "approve2date=ISNULL(CONVERT(varchar,approve2date,105)+' ' +CONVERT(varchar(5),approve2date,8),'')," .
						 "approve3date=ISNULL(CONVERT(varchar,approve3date,105)+' ' +CONVERT(varchar(5),approve3date,8),'')";
			   return $field;
		   },
		   null,
		   true,
		   function($row){
			   $row->Ref = encode_str($row->Ref);
			   $row->currentdept = $this->session->userdata('u_dept');			   			   
			   if($row->complete<0)
				   $row->isdifferent=1;
			   else
				   $row->isdifferent = $this->session->userdata('u_dept')==$row->DeptID ? (null==$row->approve2date || null==$row->approve3date) ? 0 : 1 : 1;
		   });
		return $Query;
	}
	
	
	//dept
	public function getMonApprovalCuti($param){
		$Query = $this->datatablesql->sql_select($param,
		   function($param){
			   $table = 'vwTrn_CutiKaryawan';
			   return $table;
		   },function($param){
			   $field = ' Ref,NIK,Nama,DeptName,Jabatan,TglAwalCuti,TglAkhirCuti,TglKembaliKerja,NIKP,TglAwalCutistr,TglAkhirCutistr,TglKembaliKerjastr' . 
			            ',Tujuan,Keterangan,Periode,JumlahCuti,NamaP,DeptNameP,JabatanNameP,approve2,approve2name,approve3,approve3name,' .
						"approve2date=CONVERT(varchar,approve2date,105)+' ' +CONVERT(varchar(5),approve2date,8)," .
						"approve3date=CONVERT(varchar,approve3date,105)+' ' +CONVERT(varchar(5),approve3date,8)";
			   return $field;
		   },
		   function($param){
			   $where = '((approve2 =' . $this->db->escape($param['nik'])  . ' and approve2date is null) or ' .
			            '(approve3 =' . $this->db->escape($param['nik']) . ' and approve3date is null)) ' .
						' and approve4 is null and isnull(statuscuti,0)>=0';
				return $where;
		   },
		   true,
		   function($row){
			   $row->Ref = encode_str($row->Ref);			   
		   });
		return $Query;
	}
	
	public function getMonApprovalIjin($param){
		$Query = $this->datatablesql->sql_select($param,
		   function($param){
			   $table = 'vwTrn_IjinKaryawan';
			   return $table;
		   },function($param){
			   $field = ' Ref,NIK,Nama,DeptName,Jabatan,TglAwalIjin,TglAkhirIjin,TglKembaliKerja,NIKP,TglAwalIjinstr,TglAkhirIjinstr,TglKembaliKerjastr' . 
			            ',Tujuan,Keterangan,Periode,JumlahHK,NamaP,DeptNameP,JabatanNameP,approve2,approve2name,approve3,approve3name,' .
						"approve2date=CONVERT(varchar,approve2date,105)+' ' +CONVERT(varchar(5),approve2date,8)," .
						"approve3date=CONVERT(varchar,approve3date,105)+' ' +CONVERT(varchar(5),approve3date,8)";
			   return $field;
		   },
		   function($param){
			   $where = '((approve2 =' . $this->db->escape($param['nik'])  . ' and approve2date is null) or ' .
			            '(approve3 =' . $this->db->escape($param['nik']) . ' and approve3date is null)) ' .
						' and approve4 is null and isnull(statuscuti,0)>=0';
				return $where;
		   },
		   true,
		   function($row){
			   $row->Ref = encode_str($row->Ref);			   
		   });
		return $Query;
	}
	
	//psn approval cuti
	public function getMonApprovalCutiPsn($param){
		$Query = $this->datatablesql->sql_select($param,
		   function($param){
			   $table = 'vwTrn_CutiKaryawan';
			   return $table;
		   },function($param){
			   $field = ' Ref,NIK,Nama,DeptName,Jabatan,TglAwalCuti,TglAkhirCuti,TglKembaliKerja,NIKP,TglAwalCutistr,TglAkhirCutistr,TglKembaliKerjastr' . 
			            ',Tujuan,Keterangan,Periode,JumlahCuti,NamaP,DeptNameP,JabatanNameP,approve2,approve2name,approve3,approve3name,' .
						"approve2date=CONVERT(varchar,approve2date,105)+' ' +CONVERT(varchar(5),approve2date,8)," .
						"approve3date=CONVERT(varchar,approve3date,105)+' ' +CONVERT(varchar(5),approve3date,8)";
			   return $field;
		   },
		   function($param){
			   $where = ' approve2date is not null and approve3date is not null' .
						' and approve4 is null and isnull(statuscuti,0)>=0';
				return $where;
		   },
		   true,
		   function($row){
			   $row->Ref = encode_str($row->Ref);			   
		   });
		return $Query;
	}
	
	//psn approvel ijin
	public function getMonApprovalIjinPsn($param){
		$Query = $this->datatablesql->sql_select($param,
		   function($param){
			   $table = 'vwTrn_IjinKaryawan';
			   return $table;
		   },function($param){
			   $field = ' Ref,NIK,Nama,DeptName,Jabatan,TglAwalIjin,TglAkhirIjin,TglKembaliKerja,NIKP,TglAwalIjinstr,TglAkhirIjinstr,TglKembaliKerjastr' . 
			            ',Tujuan,Keterangan,Periode,JumlahHK,NamaP,DeptNameP,JabatanNameP,approve2,approve2name,approve3,approve3name,' .
						'dispensasi,' .
						"approve2date=CONVERT(varchar,approve2date,105)+' ' +CONVERT(varchar(5),approve2date,8)," .
						"approve3date=CONVERT(varchar,approve3date,105)+' ' +CONVERT(varchar(5),approve3date,8)";
			   return $field;
		   },
		   function($param){
			   $where = ' approve2date is not null and approve3date is not null' .
						' and approve4 is null and isnull(statuscuti,0)>=0';
				return $where;
		   },
		   true,
		   function($row){
			   $row->Ref = encode_str($row->Ref);			   
		   });
		return $Query;
	}
	
	//DAFTAR LIST
	//---list approval
	public function getListApprovalDept($dept){
		$sql = 'select a.NIK,b.NAMA,a.LevelNo from tblMstApproval a ' .
               'left join PSGPayroll..KARYAWAN b on a.NIK=b.NIK  ' .
               'where a.DeptID= ' . $dept .
               'order by LevelNo';
		$query = $this->db->query($sql);
		return $query;
	}

	//--LIST KARYAWAN
	public function datatableKaryawan($param){
		$query = $this->datatablesql->sql_select($param,
					function($param){
						$table = 'vwMstKaryawanAktif';
						return $table;
					},
					function($param){
					   $field = 'RegNo, NIK,NAMA,DeptAbbr,Jabatan,JabatanName,KontrakKe,TglKontrak,LiburMingguan,DeptName';
					   return $field;
					},
					function($param){
						$where = ' groupkry=' . "'NK'";
						if(isset($param['extradata']['deptid'])){
							$where =$where . ' and DeptID=' . $param['extradata']['deptid'];
						}
						return $where;
					},
					true,
					function($row){
						$row->idrow = encode_str($row->NIK);
					}
				);
		return $query;
	}
	
	//list jatah cuti dan sisa cuti pernik
	public function getDataRekapCuti($param){
		$query = $this->exec_sql('GetUpdateDataCuti',$param);
		return $query;
	}

	//LIST DISPENSASI
	public function getDataListDispensasi(){
		$sql = "select * from tblMstDispensasi";
		$query = $this->db->query($sql);
		return $query;
	}



	//validasai cuti-ijin
	public function getDurasiCuti($param){
		$query = $this->exec_sql('GetDurasiCuti',$param);
		return $query;
	}

	public function gethariliburnasional(){
		$sql = "select hl= replace(convert(varchar(10),HariLibur,103),'/','-') from PSGPayroll..tblMstHariLiburNasional " .
			   "where YEAR(HariLibur) between YEAR(GETDATE())-1 and YEAR(getdate())+1";
		$query = $this->db->query($sql);
		return $query;
	}
	
    
}