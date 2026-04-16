<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function tgl_eng($tgl) {
	$tanggal  = substr($tgl,0,2);
	$bulan	= substr($tgl,3,2);
	$tahun	= substr($tgl,6,4);
	return $tahun.'-'.$bulan.'-'.$tanggal;
}

function tgl_ind($tgl) {
	return date("d/m/Y",  strtotime($tgl));
}

function datetime_ind($datetime){	
	if (is_null($datetime)){
		$result = '';
	}else{
		$result = date("d/m/Y H:i:s", strtotime($datetime));
	}
	return $result;
}

