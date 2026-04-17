<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Author : Heriyanto
 * Description : Security Control to OneLogin Desktop app
 */
 
 class OneLogin {
 
       protected $_CI;
	   private $encryption;
	   
	   public $secuser;
	   public $secpass;
	   public $keys;
	   
	   public function __construct() {
           $this->_CI = &get_instance();
		   $this->_CI->load->library('encryption'); 
		   
		   $this->encryption= $this->_CI->encryption;
	   }
	   
	   public function getsecurecode($code){
		   $result = false;
		   $this->secuser=false;
		   $this->secpass=false;
		   $datas = $this->encryption->decrypt(
			      hex2bin($code),
				  array(
				      'cipher'=>'aes-256',
					  'mode'=>'cbc',
					  'key'=>$this->keys,
					  'hmac'=>FALSE
				  )
			);
			if($datas){
				$mdata = explode('|',$datas);
				if(count($mdata)==2){
					$this->secuser = $mdata[0];
					$this->secpass = $mdata[1];
					$result=true;
				}
			}
			return $result;
	   }
 
 }