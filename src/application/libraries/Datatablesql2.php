<?php defined('BASEPATH') or exit('No direct script access allowed');

/*
 * Author : Heriyanto
 */

class Datatablesql2
{

    protected $_CI;
    private $db;

    private $sql_total;

    public function __construct()
    {
        $this->_CI = &get_instance();
        $this->db = $this->_CI->load->database('default', TRUE);
    }

    public function changedb($dbused)
    {
        $this->db = $dbused;
    }

    //SERVER SIDE
    private function get_fromtable($draw, $sqltotal, $sqldata, $encodestr = null, $idtoenc = null)
    {
        $ardata = array();
        $ardata['draw'] = $draw;
        //record total
        $query = $this->db->query($sqltotal);
        $row = $query->row();
        $ardata['recordsTotal'] = $row->total;
        $ardata['recordsFiltered'] = $row->total;
        $query = $this->db->query($sqldata);
        if (null != $encodestr) {
            $res = $query->result();
            foreach ($res as $row) {
                $idtoenc($row);
            }
            $ardata['data'] = $res;
        } else
            $ardata['data'] = $query->result();
        return $ardata;
    }

    //tool
    public function securevar_str($variabel)
    {
        $var =  str_replace('\'', '', $variabel);
        $var = $this->db->escape_str(trim($var));
        if ($var == '') $var = ' ';
        return $var;
    }
    //------------

    public function sql_select($param, $sqlfunctfrom, $sqlcorefield, $sqlwhereaddon = null, $encodestr = null, $idtoenc = null)
    {
        $usingwhere = '';

        //get column order datatable
        if (!isset($param['realfield']))
            $param['realfield'] = " * ";
        if (isset($param['order']))
            $i = $param['order'][0]['column'];
        else
            $i = 0;

        if (is_array($param['columnorder'])) {
            $orders = $param['columnorder'][$i]['fieldname'];
            $orders .= ' ' . $param['order'][0]['dir'];

            //  $orders = $param['columnorder'][$i]['fieldname'];
            //  $orders .= ' ' . $param['order'][0]['dir'];
        } else {
            //  $orders = $param['coreorder'][$i];
            //  $orders .= ' ' . $param['order'][0]['dir'];

            $orders = 'periode DESC'; // Menyaring berdasarkan periode dan urutkan DESC
        }

        $corefield = $sqlcorefield($param);

        if (!isset($param['prefix']))
            // $fromsql = "SELECT ID = ROW_NUMBER() OVER (ORDER BY " . $orders . ")," .
            // $fromsql = "SELECT TOP 100 ID = ROW_NUMBER() OVER (ORDER BY " . $orders . ")," .
            // $fromsql = "SELECT " .

            // $fromsql = "SELECT " .
            $fromsql = "SELECT rn = ROW_NUMBER ( ) OVER ( PARTITION BY DeptAbbr ORDER BY CreatedDate DESC ), " .
                $corefield . " FROM " . $sqlfunctfrom($param);
        else
            // $fromsql = "SELECT ID = ROW_NUMBER() OVER (ORDER BY " . $orders . "), * " .
            // $fromsql = "SELECT TOP 100 ID = ROW_NUMBER() OVER (ORDER BY " . $orders . "), * " .
            // $fromsql = "SELECT " .
            $fromsql = "SELECT rn = ROW_NUMBER ( ) OVER ( PARTITION BY DeptAbbr ORDER BY CreatedDate DESC ), " .
                " FROM ( SELECT " . $param['prefix'] . " " . $corefield . " FROM "  . $sqlfunctfrom($param);

        //getsearch
        if ($param['search']['value'] != '') {
            if (isset($param['coresearch'])) {
                $textsearch = $param['coresearch'];
                $textsearch = str_replace("@1", "'%" . $param['search']['value'] . "%'", $textsearch);
                $usingwhere = "(" . $textsearch . ")";
            };
        }

        //sqlwhere custom
        if ($sqlwhereaddon != null) {
            $whereaddon = $sqlwhereaddon($param);
            if ($usingwhere != '')
                $usingwhere = $usingwhere . " AND " . $whereaddon;
            else
                $usingwhere = $whereaddon;
        }
        //sqlcomplete
        if ($usingwhere != '')
            $fromsql = $fromsql . " WHERE " . $usingwhere;
        if (isset($param['prefix']))
            $fromsql = $fromsql .  ") B";
        //sqlreal
        // $sqlcount = "SELECT total=COUNT(*) FROM (" . $fromsql . ") A";
        $sqlcount = "WITH FilteredData AS (
                    SELECT DISTINCT bperiode FROM (" . $fromsql . ") A 
                  ) SELECT total = COUNT(*) FROM FilteredData";
        // $sqlselect = "SELECT " . $param['realfield'] . " FROM (" . $fromsql . ") A " .
        //    "WHERE ID BETWEEN " . ($param['start'] + 1) . " AND " . ($param['length'] + $param['start']);

        $sqlselect = "SELECT DISTINCT bperiode," . $param['realfield'] . " FROM (" . $fromsql . ") A " .
            "WHERE rn = 1 ORDER BY periode DESC OFFSET 0 ROWS FETCH NEXT 100 ROWS ONLY";
        $ar = $this->get_fromtable($param['draw'], $sqlcount, $sqlselect, $encodestr, $idtoenc);
        return $ar;
    }

    function sql_query($param, $fromtable, $fromfield, $fromwhere = null, $orderby = null, $groupby = null)
    {
        $querystr = "SELECT " . $fromfield($param) . " FROM " . $fromtable($param);
        if (null != $fromwhere) {
            $where = $fromwhere($param);
            if ($where != '') $querystr = $querystr . " where " . $where;
        }
        if ($groupby != null) $querystr = $querystr . " group by " . $groupby($param);
        if ($orderby != null) $querystr = $querystr . " order by " . $orderby($param);
        $ar = $this->db->query($querystr);
        return $ar;
    }

    function data_html($iddiv, $idtable, $urlajax, $arraycolname, $getrowhead, $getcolrow)
    {
        $params = array('id' => $iddiv, 'idtable' => $idtable, 'urlajax' => $urlajax);
        $params['rowhead'] = $getrowhead();
        $params['arcolname'] = $arraycolname;
        $params['arcol'] = $getcolrow();
        return $params;
    }

    public function sql_select2($param, $sqlfunctfrom, $sqlcorefield, $sqlwhereaddon = null, $encodestr = null, $idtoenc = null)
    {
        $usingwhere = '';

        //get column order datatable
        if (!isset($param['realfield']))
            $param['realfield'] = " * ";
        if (isset($param['order']))
            $i = $param['order'][0]['column'];
        else
            $i = 0;

        if (is_array($param['columnorder'])) {
            $orders = $param['columnorder'][$i]['fieldname'];
            $orders .= ' ' . $param['order'][0]['dir'];
        } else {
            $orders = $param['coreorder'][$i];
            $orders .= ' ' . $param['order'][0]['dir'];
        }

        $corefield = $sqlcorefield($param);

        if (!isset($param['prefix']))
            $fromsql = "SELECT ID = ROW_NUMBER() OVER (ORDER BY " . $orders . ")," .
                $corefield . " FROM " . $sqlfunctfrom($param);
        else
            $fromsql = "SELECT ID = ROW_NUMBER() OVER (ORDER BY " . $orders . "), * " .
                " FROM ( SELECT " . $param['prefix'] . " " . $corefield . " FROM "  . $sqlfunctfrom($param);

        //getsearch
        if ($param['search']['value'] != '') {
            if (isset($param['coresearch'])) {
                $textsearch = $param['coresearch'];
                $textsearch = str_replace("@1", "'%" . $param['search']['value'] . "%'", $textsearch);
                $usingwhere = "(" . $textsearch . ")";
            };
        }

        //sqlwhere custom
        if ($sqlwhereaddon != null) {
            $whereaddon = $sqlwhereaddon($param);
            if ($usingwhere != '')
                $usingwhere = $usingwhere . " AND " . $whereaddon;
            else
                $usingwhere = $whereaddon;
        }
        //sqlcomplete
        if ($usingwhere != '')
            $fromsql = $fromsql . " WHERE " . $usingwhere;
        if (isset($param['prefix']))
            $fromsql = $fromsql .  ") B";
        //sqlreal
        $sqlcount = "SELECT total=COUNT(*) FROM (" . $fromsql . ") A";
        $sqlselect = "SELECT " . $param['realfield'] . " FROM (" . $fromsql . ") A " .
            "WHERE ID BETWEEN " . ($param['start'] + 1) . " AND " . ($param['length'] + $param['start']);
        $ar = $this->get_fromtable($param['draw'], $sqlcount, $sqlselect, $encodestr, $idtoenc);
        return $ar;
    }
}
