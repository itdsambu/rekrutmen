<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by Vscode.
 * User: itd35
 * Date: 22/09/2022
 * Time: 10:00
*/

class M_main_user extends CI_Model {

    private $primary_key    = 'IDPemborong';
    private $table_name     = 'tblUtlAksesSubPemborong';

    function __construct(){
        parent:: __construct();
    }

    public function selectMainUser(){
        $this->db->order_by('Perusahaan','ASC');
        $query = $this->db->get('vwMstPemborong');
        return $query->result();
    }

}

/* End of file M_main_user.php */
