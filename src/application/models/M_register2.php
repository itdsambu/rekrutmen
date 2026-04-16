<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* 
 * Author : ITD15
 */

class M_register2 extends CI_Model {

    function __construct() {
        parent:: __construct();
    }
        

    function insert_chapter($dataarray){
        for($i=1;$i<count($dataarray);$i++){
             $data = array(
                'CVNama'=> $dataarray[$i]['CVNama'],
                'Pemborong'=>$dataarray[$i]['Pemborong'],
                'Nama'=> strtoupper($dataarray[$i]['Nama']),
                'Tgl_Lahir' => date('Y-m-d',strtotime($dataarray[$i]['Tgl_Lahir'])),
                'Tempat_Lahir' => strtoupper($dataarray[$i]['Tempat_Lahir']),
                'NamaIbuKandung' => strtoupper($dataarray[$i]['NamaIbuKandung']),
                'BeratBadan' => $dataarray[$i]['BeratBadan'],
                'TinggiBadan' => $dataarray[$i]['TinggiBadan'],
                'Agama' => strtoupper($dataarray[$i]['Agama']),
                'Suku' => strtoupper($dataarray[$i]['Suku']),
                'Jenis_Kelamin' => strtoupper($dataarray[$i]['Jenis_Kelamin']),
                'Pendidikan' => strtoupper($dataarray[$i]['Pendidikan']),
                'Jurusan' => strtoupper($dataarray[$i]['Jurusan']),
                'Universitas' => $dataarray[$i]['Universitas'],
                'IPK' => $dataarray[$i]['IPK'],
                'Status_Personal' => strtoupper($dataarray[$i]['Status_Personal']),
                'No_Ktp' => $dataarray[$i]['No_Ktp'],
                'Alamat' =>  $dataarray[$i]['Alamat'],
                'RT' => $dataarray[$i]['RT'],
                'RW' => $dataarray[$i]['RW'],
                'TinggalDengan' => $dataarray[$i]['TinggalDengan'],
                'HubunganDenganTK' => $dataarray[$i]['HubunganDenganTK'],
                'NoHP' => $dataarray[$i]['NoHP'],
                'Daerah_Asal' => strtoupper($dataarray[$i]['Daerah_Asal']),
                'PernahKerja' => strtoupper($dataarray[$i]['PernahKerja']),
                'KerjaDi' => $dataarray[$i]['KerjaDi'],
                'Kriminal' => $dataarray[$i]['Kriminal'],
                'PerkaraApa' => $dataarray[$i]['PerkaraApa'],
                'JumlahAnak' => $dataarray[$i]['JumlahAnak'],
                'NamaSuamiIstri' => $dataarray[$i]['NamaSuamiIstri'],
                'TglLahirSuamiIstri' => date('Y-m-d',strtotime($dataarray[$i]['TglLahirSuamiIstri'])),
                'AlamatSuamiIstri' => $dataarray[$i]['AlamatSuamiIstri'],
                'NamaBapak' => $dataarray[$i]['NamaBapak'],
                'ProfesiOrangTua' => $dataarray[$i]['ProfesiOrangTua'],
                'JumlahSaudara' => $dataarray[$i]['JumlahSaudara'],
                'AnakKe' => $dataarray[$i]['AnakKe'],
                'BahasaDaerah' => $dataarray[$i]['BahasaDaerah'],
                'TahunMasuk' => $dataarray[$i]['TahunMasuk'],
                'TahunLulus' => $dataarray[$i]['TahunLulus'],
                'Hobby' => $dataarray[$i]['Hobby'],
                'KegiatanEkstra' => $dataarray[$i]['KegiatanEkstra'],
                'KegiatanOrganisasi' => $dataarray[$i]['KegiatanOrganisasi'],
                'KeadaanFisik' => $dataarray[$i]['KeadaanFisik'],
                'PernahIdapPenyakit' => $dataarray[$i]['PernahIdapPenyakit'],
                'PenyakitApa' => $dataarray[$i]['PenyakitApa'],
                'PengalamanKerja' => $dataarray[$i]['PengalamanKerja'],
                'Keahlian' => $dataarray[$i]['Keahlian'],
                'PernahKerjaDiSambu' => $dataarray[$i]['PernahKerjaDiSambu'],
                'KerjadiBagian' => $dataarray[$i]['KerjadiBagian'],
                'AccountFacebook' => $dataarray[$i]['AccountFacebook'],
                'AccountTwitter' => $dataarray[$i]['AccountTwitter'],
                'Bertato' => $dataarray[$i]['Bertato'],
                'Bertindik' => $dataarray[$i]['Bertindik'],
                'SediaPotongRambut' => $dataarray[$i]['SediaPotongRambut'],
                'Sediadiberhentikan' => $dataarray[$i]['Sediadiberhentikan'],
                'CreatedBy'                 => strtoupper($this->session->userdata('username')),
                'CreatedDate'               => date('Y-m-d H:i:s'),
                'InputOnline'               => 1,
                'RegisteredBy'              => strtoupper($this->session->userdata('userid')),
                'RegisteredDate'            => date('Y-m-d H:i:s')
             );

            $this->db->trans_start();
            $this->db->insert('tblTrnCalonTenagaKerja',$data);
            $hdrID = $this->db->insert_id();
            $this->db->trans_complete();

            $this->db->insert('tblTrnBerkas',array("HeaderID" => $hdrID));
        }
    }

}
?>