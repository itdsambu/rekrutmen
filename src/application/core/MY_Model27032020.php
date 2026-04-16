<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {
	
	protected $dbname;
	
	public function __construct(){
		 parent::__construct();
		 $this->load_library();
		 $this->dbname = NULL;
	}
	
	protected function load_library(){
		}
	

	
	//util exec stroproc
    protected function exec_sql($storeprocname,$arparam=NULL){
      $param = 'PARAM_';
	  $strparam = '';
	  if($this->dbname!=NULL){
		  $strparam = $this->dbname . '..' . $storeprocname;
	  }else {
		  $strparam = $storeprocname;
	  }
      $i=0;
      $arr = array();
	  if($arparam!=NULL){
		foreach ($arparam as  $value) {
			if($i==0)
				$strparam .= ' ?';
			else
				$strparam .=',?';
			$i = $i +  1;
			$param = 'PARAM_' . $i;
			$arr[$param]=$value;
		}
	  }
	  if( count($arr) > 0 )
         $query = $this->db->query($strparam,$arr);
	  else
		 $query = $this->db->query($strparam);
      return $query;
    }
	
	public function encryptkeys($keyname,$query){
		$this->encryption->initialize(array('cipher'=>'rijndael-128',
		                               'mode'=>'cbc'));
		$chtext='';
		$ntext='';
		foreach ($query as &$row)
		{
			$ntext = $row[$keyname];
			$chtext = $this->encryption->encrypt($ntext);
			$row[$keyname] = $chtext;
		}
		return $query;
	}
	
	protected function securestr($strtext){
	   $varstr = str_replace("'","",$strtext);
	   $varstr = str_replace('"','',$varstr);
	   $varstr = str_replace(';','',$varstr);
	   return $varstr;
	}
	
	public function escapechar($str){
	   $strresult = $this->db->escape($str);
	   return $strresult;
	}
	
}