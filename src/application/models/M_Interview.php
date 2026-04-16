<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * Author : ITD15
 */

class M_Interview extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function countAllInterviewTenaker()
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerInterview ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    function selectAllInterviewTenaker($start, $end)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTenakerInterview AS tbl) vwTenakerInterview WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }

    function countGagalInterviewTenaker()
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerInterview WHERE HasilWawancara='0' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    function selectGagalInterviewTenaker($start, $end)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTenakerInterview AS tbl WHERE HasilWawancara='0') vwTenakerInterview WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }

    function countLulusInterviewTenaker()
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerInterview WHERE HasilWawancara='1' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    function selectLulusInterviewTenaker($start, $end)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTenakerInterview AS tbl WHERE HasilWawancara='1') vwTenakerInterview WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }


    function countAllInterviewTenakerWhere($noreg, $nama, $dept, $tanggal)
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerInterview WHERE HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND Departemen LIKE '%" . $dept . "%' AND CONVERT(DATE, Tanggal,103) LIKE '%" . $tanggal . "%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    function selectAllInterviewTenakerWhere($start, $end, $noreg, $nama, $dept, $tanggal)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTenakerInterview AS tbl WHERE HeaderID LIKE '%" . $noreg . "%' AND  Nama LIKE '%" . $nama . "%' AND Departemen LIKE '%" . $dept . "%' AND CONVERT(DATE, Tanggal,103) LIKE '%" . $tanggal . "%') vwTenakerInterview WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }

    function countGagalInterviewTenakerWhere($noreg, $nama, $dept, $tanggal)
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerInterview WHERE HasilWawancara='0' AND HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND Departemen LIKE '%" . $dept . "%' AND CONVERT(DATE, Tanggal,103) LIKE '%" . $tanggal . "%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    function selectGagalInterviewTenakerWhere($start, $end, $noreg, $nama, $dept, $tanggal)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTenakerInterview AS tbl WHERE HasilWawancara='0' AND HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND Departemen LIKE '%" . $dept . "%' AND CONVERT(DATE, Tanggal,103) LIKE '%" . $tanggal . "%') vwTenakerInterview WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }

    function countLulusInterviewTenakerWhere($noreg, $nama, $dept, $tanggal)
    {
        $query = $this->db->query("SELECT HeaderID FROM vwTenakerInterview WHERE HasilWawancara='1' AND HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND Departemen LIKE '%" . $dept . "%' AND CONVERT(DATE, Tanggal,103) LIKE '%" . $tanggal . "%' ORDER BY HeaderID DESC");
        return $query->num_rows();
    }

    function selectLulusInterviewTenakerWhere($start, $end, $noreg, $nama, $dept, $tanggal)
    {
        $query = $this->db->query("SELECT * FROM (SELECT  ROW_NUMBER() OVER(ORDER BY HeaderID DESC) AS Row, "
            . "* FROM vwTenakerInterview AS tbl WHERE HasilWawancara='1' AND HeaderID LIKE '%" . $noreg . "%' AND Nama LIKE '%" . $nama . "%' AND Departemen LIKE '%" . $dept . "%' AND CONVERT(DATE, Tanggal,103) LIKE '%" . $tanggal . "%') vwTenakerInterview WHERE Row >= " . $start . " AND Row <= " . $end . " ");
        return $query->result();
    }

    function toExcelSemuainterviewTK($periode)
    {
        $query = $this->db->query("SELECT * FROM vwTenakerInterview WHERE CONVERT(DATE, Tanggal,103) = '" . $periode . "' ORDER BY HeaderID ASC");
        return $query->result();
    }

    function toExcellulusinterviewTK($periode)
    {
        $query = $this->db->query("SELECT * FROM vwTenakerInterview WHERE CONVERT(DATE, Tanggal,103) = '" . $periode . "' AND HasilWawancara='1' ORDER BY HeaderID ASC");
        return $query->result();
    }

    function toExcelgagalinterviewTK($periode)
    {
        $query = $this->db->query("SELECT * FROM vwTenakerInterview WHERE CONVERT(DATE, Tanggal,103) = '" . $periode . "' AND HasilWawancara='0' ORDER BY HeaderID ASC");
        return $query->result();
    }

    function getResult($hdrid)
    {
        $query = $this->db->query("SELECT * FROM vwTenakerInterview WHERE HeaderID='" . $hdrid . "'");
        return $query->result();
    }

    function updatedata($id, $data)
    {
        $this->db->where('HeaderID', $id);
        $this->db->update('tblTrnWawancara', $data);
    }
}
