<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by Heriyanto
 */

class M_configpermintaan extends My_Model{

    public function getdatavwkaryawan($param){
        $query = $this->datatablesql2->sql_select($param,
           function($param){
               $vw = 'vwKuotaKryTK';
               return $vw;
           },
           function($param){
               $field = ' * ';
               return $field;
           },
           function($param){
               $where = 'krydept > 0';
               return $where;
           },
           true,
           function($row){
               $row->krydept=encode_str($row->krydept);
               $row->krybor=encode_str($row->krybor);
           });
        return $query;
    }

    public function gettotalall($param=null){
        if(null==$param){
            $sql = "SELECT Ideal_Kry = SUM(IKry),Real_Kry=SUM(RKry),Ideal_Bor=SUM(IBOR),Real_Bor=SUM(RBOR)    FROM vwKuotaKryTK";
            $query = $this->db->query($sql);
            return $query;
        }else{
            $sql = "SELECT Ideal_Kry = SUM(IKry),Real_Kry=SUM(RKry),Ideal_Bor=SUM(IBOR),Real_Bor=SUM(RBOR)    FROM vwKuotaKryTK " .
                  " where krydeptname in ('" . $param['dept'] . "')";
            $query = $this->db->query($sql);
            return $query;
        }
    }

    public function getdatavwkaryawandept($param){
        $query = $this->datatablesql2->sql_select($param,
           function($param){
               $vw = 'vwKuotaKryTK';
               return $vw;
           },
           function($param){
               $field = ' * ';
               return $field;
           },
           function($param){
               $where = "krydeptname in ('" . $param['dept'] . "')";
               return $where;
           },
           true,
           function($row){
               $row->krydept=encode_str($row->krydept);
               $row->krybor=encode_str($row->krybor);
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
                 $field = "Opsi='',IDMemo,DeptAbbr,IsComplete,IsKry,Jumlah,FileLocation='',UploadDate=CONVERT(varchar(10),UploadDate,103)";
                 return $field;
             },
             function($param){
                $where = "DeptAbbr in ('" . $param['deptlist'] . "')";
                return $where;
             }
             ,true
             ,function($row){                 
                 $row->FileLocation = encode_str($row->IDMemo);
                 $row->opsi='';
                 if($row->IsComplete==0){
                    $row->IsComplete = 'Belum Complete';
                    //if($this->session->userdata('dept')=='PSN'){
                        $row->opsi = '<a href="' . base_url() . "/configpermintaan/updatememo?noref="
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
        $sql = 'select FileLocation  from tblMstKuotaPermintaanMemo where IDMemo=' . $id;
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            $row = $query->row();
            $filelocation = substr($row->FileLocation,2);
            return $filelocation;
        }else{
            return '';
        }
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

}