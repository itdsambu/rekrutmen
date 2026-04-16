<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class Darurat extends CI_Model{
    
    public function __construct() {
        parent::__construct();
    }
    
    function getStatus(){
        $status = 0;
        $query = $this->db->query("SELECT * FROM darurat WHERE Detail = 1 ")->result();
        
        foreach ($query as $row):
            $status = $row->Status;
        endforeach;
        
        return $status;
    }
}