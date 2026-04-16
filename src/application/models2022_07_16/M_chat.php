<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class M_Chat extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    function selectChat(){
        $thisMonth	= date('m');
        $this->db->order_by('DetailID', 'ASC');
        $this->db->where('MONTH(Date) = '.$thisMonth);
        $get    = $this->db->get('vwUtlChat');
        return $get->result();
    }
    
    function insertChat($data){
        $this->db->insert('tblUtlChat', $data);
    }
}