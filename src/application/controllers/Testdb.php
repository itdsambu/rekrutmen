<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Testdb extends CI_Controller
{

    // public function index()
    // {
    //     die("TEST DB CONNECTION");
    //     $server = "192.168.2.3,1433";
    //     $database = "NAMA_DB";
    //     $username = "appkoneksi";
    //     $password = "app@1psg";

    //     try {
    //         // TEST PDO SQLSRV (INI YANG PALING STABIL DI DOCKER)
    //         $conn = new PDO(
    //             "sqlsrv:Server=$server;Database=$database",
    //             $username,
    //             $password
    //         );

    //         $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //         echo "✅ CONNECTION SUCCESS<br>";

    //         $stmt = $conn->query("SELECT TOP 1 name FROM sys.databases");
    //         $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //         echo "<pre>";
    //         print_r($row);
    //         echo "</pre>";
    //     } catch (Exception $e) {
    //         echo "❌ CONNECTION FAILED<br>";
    //         echo $e->getMessage();
    //     }
    // }

    public function index()
    {
        echo "TEST START<br>";

        $this->load->database();

        echo "AFTER DB LOAD<br>";

        $query = $this->db->query("SELECT 1 AS test");
        print_r($query->row());

        echo "SUCCESS";
    }
}
