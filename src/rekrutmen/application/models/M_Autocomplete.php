<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author by ITD15
 */

class M_Autocomplete extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function getPemborongFromDB($keyword)
    {
        $this->db->order_by('Pemborong', 'DESC');
        $this->db->like("Pemborong", $keyword);
        $this->db->group_start();
        $this->db->where('IDPerusahaan >', 21);
        $this->db->or_where('IDPerusahaan', 20);
        $this->db->group_end();

        return $this->db->get('vwMstPemborong')->result_array();
    }


    function getPendidikanFromDB($keyword)
    {
        $this->db->order_by('Pendidikan', 'DESC');
        $this->db->like("Pendidikan", $keyword);
        return $this->db->get('tblMstPendidikan')->result_array();
    }

    function getJurusanFromDB($keyword)
    {
        $this->db->order_by('Jurusan', 'DESC');
        $this->db->like("Jurusan", $keyword);
        return $this->db->get('tblMstJurusan')->result_array();
    }
}
