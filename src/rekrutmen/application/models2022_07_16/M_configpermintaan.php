<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by Heriyanto
 */

class M_configpermintaan extends My_Model{

    public function getdatavwkaryawan($param){
        $query = $this->datatablesql2->sql_select($param,
           function($param){
               $vw = "vwIdealKryTk";
               return $vw;
           },
           function($param){
               $field = ' * ';
               return $field;
           });
        return $query;
    }

    public function gettotalall($param=null){
        if(null==$param){
            $sql = "SELECT Ideal_Kry = SUM(IKry),Real_Kry=SUM(RKry),Ideal_Bor=SUM(IBOR),Real_Bor=SUM(RBOR),ReqB=SUM(PERMINTAANBORApp),ReqK=SUM(PERMINTAANKARApp),ReqKP=SUM(PERMINTAANKARPending),ReqBP=SUM(PERMINTAANBORPending)    FROM vwKuotaKryTKinReq";
            $query = $this->db->query($sql);
            return $query;
        }else{
            $sql = "SELECT Ideal_Kry = SUM(IKry),Real_Kry=SUM(RKry),Ideal_Bor=SUM(IBOR),Real_Bor=SUM(RBOR),ReqB=SUM(PERMINTAANBORApp),ReqK=SUM(PERMINTAANKARApp),ReqKP=SUM(PERMINTAANKARPending),ReqBP=SUM(PERMINTAANBORPending)    FROM vwKuotaKryTKinReq " .
                  " where krydeptname in ('" . $param['dept'] . "')";
            $query = $this->db->query($sql);
            return $query;
        }
    }

    public function getdatavwkaryawandept($param){
        $query = $this->datatablesql2->sql_select($param,
           function($param){
               $vw = 'vwIdealKryTk ';
               return $vw;
           },
           function($param){
               $field = ' * ';
               return $field;
           },
           function($param){
               $where = "DeptKry in ('" . $param['dept'] . "')";
               return $where;
           });
        return $query;
    }

    public function UpdateIdealKaryawan($param){
        $query = $this->exec_sql('UpdataIdealKry',$param);
        return $query;
    }

    public function UpdateMemo($param){
        $query = $this->exec_sql('Trans_MemoIdealDept',$param);
        return $query;
    }

    public function getMonitoringMemos($param){
        $query = $this->datatablesql2->sql_select($param,
             function($param){
                 return 'vwPermintaanKryTKMemo';
             },
             function($param){
                 $field = "Opsi='',IDMemo,Doc,DeptAbbr,IsKry,Jumlah,IsComplete";
                 return $field;
             },
             function($param){
                $where = "DeptAbbr in ('" . $param['deptlist'] . "')";
                return $where;
             }
             ,true
             ,function($row){
                 $row->opsi='';
                 if($row->IsComplete==0){
                    $row->IsComplete = 'Belum Complete';
                    //if($this->session->userdata('dept')=='PSN'){
                        $row->opsi = '<a href="' . base_url() . "configpermintaan/updatememo?noref="
                                                . encode_str($row->IDMemo) . '" class="btn btn-primary btn-sm btn-icon">Edit</a>';
                    //}
                 }
                 else{
                    $row->IsComplete = 'Sudah Complete';
                 }
             }
        );
        return $query;
    }
	
	public function getfilememo($id){
        $query = $this->exec_sql('getPrintMemo',$id);
        return $query;
    }

    public function getmstkuotapermintaan($noref){
        $this->db->where('idmemo',$noref);
        $query = $this->db->get('tblMstKuotaPermintaanMemo');
        return $query->row();
    }

    public function getkuotapermintaanbydept($deptabbr,$iskry){
        $sql = "select * from vwKuotaKryTK " . 
               " where ";
        if($iskry)
           $sql = $sql . " krydeptname='" . $deptabbr . "'";
        else
           $sql = $sql . " bordeptname='" . $deptabbr . "'";
        $query = $this->db->query($sql);
        return $query;               
    }
	
	function getdataIdeal($dept){
    $this->db->where('krydeptname',$dept);
    $this->db->where('bordeptname',$dept);
      $data = $this->db->get('vwKuotaKryTK');
      if ($data->num_rows() > 0){
        return $data->result_array();
      }
  }

}