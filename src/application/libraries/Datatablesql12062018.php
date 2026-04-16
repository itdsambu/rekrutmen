<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Author : Heriyanto
 */

 class Datatablesql{

      protected $_CI;
      private $db;

      private $sql_total;

      public function __construct() {
        $this->_CI = &get_instance();
        $this->db = $this->_CI->load->database('default', TRUE);
      }

      public function changedb($dbused){
          $this->db = $dbused;
      }

    //SERVER SIDE
    private function get_fromtable($draw,$sqltotal,$sqldata)
    {
      $ardata = array();
      $ardata['draw']=$draw;
      //record total
      $query = $this->db->query($sqltotal);
      $row = $query->row();
      $ardata['recordsTotal']=$row->total;
      $ardata['recordsFiltered']=$row->total;
      $query = $this->db->query($sqldata);
      $ardata['data']=$query->result();
      return $ardata;
     }

     //tool
     public function securevar_str($variabel){
         $var =  str_replace('\'','',$variabel);
         $var = $this->db->escape_str(trim($var));
         if($var=='') $var=' ';
         return $var;
     }
     //------------
	 

      public function sql_select($param,$sqlfunctfrom,$sqlcorefield,$sqlwhereaddon=null){
          $usingwhere = '';

          //get column order datatable
          if(isset($param['order']))
             $i = $param['order'][0]['column'];
          else
             $i = 0;
          
          if(is_array($param['columnorder'])){
             $orders = $param['columnorder'][$i]['fieldname'];
             $orders .= ' ' . $param['order'][0]['dir'];
          }else{             
             $orders = $param['coreorder'][$i];
             $orders .= ' ' . $param['order'][0]['dir'];
          }


          $corefield = $sqlcorefield($param);

          //getcore 
          $fromsql ="SELECT ID = ROW_NUMBER() OVER (ORDER BY " . $orders . ")," .
                   $corefield . " FROM " . $sqlfunctfrom($param);

          //getsearch
          if($param['search']['value']!=''){
             $textsearch = $param['coresearch'];
             $textsearch = str_replace("@1","'%" . $param['search']['value'] . "%'",$textsearch);
             $usingwhere ="(" . $textsearch . ")";
          }

          //sqlwhere custom
          if($sqlwhereaddon!=null){
              $whereaddon = $sqlwhereaddon($param);
              if($usingwhere!='')
                 $usingwhere = $usingwhere . " AND " . $whereaddon;
              else
                 $usingwhere = $whereaddon;
          }
          //sqlcomplete
          if($usingwhere!='')
             $fromsql = $fromsql . " WHERE " . $usingwhere;
          //sqlreal
          $sqlcount = "SELECT total=COUNT(*) FROM (" . $fromsql . ") A";
          $sqlselect = "SELECT " . $param['realfield'] . " FROM (" . $fromsql . ") A " .
                       "WHERE ID BETWEEN " . ($param['start']+1) . " AND " . ($param['length']+$param['start']);
          $ar = $this->get_fromtable($param['draw'],$sqlcount,$sqlselect);
          return $ar;
      }
 }