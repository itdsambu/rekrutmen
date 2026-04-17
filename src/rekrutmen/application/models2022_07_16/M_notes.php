<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author ITD15
 */

class M_Notes extends CI_Model{
    function getCalendar($year, $mon){
        $user = $this->session->userdata('userid');
        $year  = ($mon < 9 && strlen($mon) == 1) ? "$year-0$mon" : "$year-$mon";
        $this->db->where('UserID',$user);
        $query = $this->db->select('Tanggal, Notes')->from('tblUtlNotes')->like('Tanggal', $year, 'after')->get();
        if($query->num_rows() > 0){
            $data = array();
            foreach($query->result_array() as $row){
                $data[(int) end(explode('-',$row['Tanggal']))] = $row['Notes'];
            }
            return $data;
        }else{
            return false;
        }
    }

    function addNote($year, $mon, $day, $note){
        $user = $this->session->userdata('userid');
        $mon = (strlen($mon) == 2)? $mon : "0$mon";
        $day = (strlen($day) == 2)? $day : "0$day";
        $this->db->query("INSERT INTO tblUtlNotes (Tanggal, Notes, UserID) VALUES ('$year-$mon-$day', ?, ?)", array($note,$user));
    }

    function editNote($year, $mon, $day, $note){
        $user = $this->session->userdata('userid');
        $mon = (strlen($mon) == 2)? $mon : "0$mon";
        $day = (strlen($day) == 2)? $day : "0$day";
        $this->db->query("UPDATE tblUtlNotes SET Notes = ? WHERE Tanggal = '$year-$mon-$day' AND UserID = '$user'", array($note));
    }

    function deleteNote($year, $mon, $day){
        $user = $this->session->userdata('userid');
        $mon = (strlen($mon) == 2)? $mon : "0$mon";
        $day = (strlen($day) == 2)? $day : "0$day";
        $this->db->query("DELETE FROM tblUtlNotes WHERE Tanggal = '$year-$mon-$day' AND UserID = '$user'");
    }

    function getNote($year, $mon, $day){
        $user = $this->session->userdata('userid');
        $mon   = (strlen($mon) == 2)? $mon : "0$mon";
        $day   = (strlen($day) == 2)? $day : "0$day";
        $query = $this->db->query("SELECT Notes FROM tblUtlNotes WHERE Tanggal = '$year-$mon-$day' AND UserID = '$user'");
        if($query->num_rows() == 1){
            $query = $query->row_array();
            return $query['Notes'];
        }else{
            return false;
        }
    }
}