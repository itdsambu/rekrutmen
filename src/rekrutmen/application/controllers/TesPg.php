// application/controllers/TestPg.php
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TestPg extends CI_Controller
{
    public function index()
    {
        $pg = $this->load->database('sambusehat', TRUE);

        $q1 = $pg->query("SELECT * FROM v_trx_mcu_no_widal LIMIT 5");
        echo "<h3>Sample data (5 row):</h3><pre>";
        print_r($q1->result());
        echo "</pre>";

        // Struktur kolom view
        $q2 = $pg->query("
            SELECT column_name, data_type 
            FROM information_schema.columns 
            WHERE table_name = 'v_trx_mcu_no_widal'
            ORDER BY ordinal_position
        ");
        echo "<h3>Struktur view:</h3><pre>";
        print_r($q2->result());
        echo "</pre>";
    }
}
