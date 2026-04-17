

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."/third_party/FPDF.php"; 
 
class PDF extends FPDF { 
    public function __construct() { 
        parent::__construct(); 
    } 
}
