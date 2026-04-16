<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_DB_sqlsrv_driver extends CI_DB_sqlsrv_driver
{

    protected function _execute($sql)
    {
        die('DRIVER OVERRIDE AKTIF');
        $options = array(
            "Scrollable" => SQLSRV_CURSOR_FORWARD
        );

        $stmt = sqlsrv_query($this->conn_id, $sql, array(), $options);

        if ($stmt === false) {
            log_message('error', print_r(sqlsrv_errors(), true));
        }

        return $stmt;
    }
}
