<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Mdl_Monitorcuti extends MY_Model {


     public function getmonitorsisacuti($param){
        
         $query = $this->datatablesql->sql_select($param,
                   function($param){
                       $tablename = 'vwSisaCuti';
                       return $tablename;
                   },
                   function($param){
                       $field = "RegNo,NIK,NAMA,DeptName,JabatanName,TGLMASUK=REPLACE(convert(varchar(10),TGLMASUK,103),'/','-'),CurrentPeriode,JC,SISACUTI";
                       return $field;
                   }
               );
        return $query;
        
     }

}