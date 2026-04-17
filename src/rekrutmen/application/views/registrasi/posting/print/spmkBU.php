<style type="text/Css">
tbody{
    font-size: 14px;
}
.kop{
    font-size: 12px;
}
.judul{
    font-size: 18px;
    font-weight: bold;
}
.id{
    text-align: right;
}
p{
    margin-left: 20px;
}
.margin10{
    margin-left: 10px;
    margin-right: 10px;
}
</style>

<?php
    foreach ($_getDetail as $row):
?>

<page style="font-size: 13px; font-family: freeserif;" backtop="5mm" backbottom="5mm" backleft="5mm" backright="5mm">
<div class="id">ID : <?php echo $row->HeaderID;?></div>
<table border="1" style="width: 100%;">
    <tr>
        <td>
            <table style="width: 100%;">
                <tr>
                    <td rowspan="3" style="width: 15%; text-align: center;"> 
                        <img src="<?php echo base_url();?>assets/img/rsup-logo.png" width="70" height="70" alt="rsup-logo"/>
                    </td>
                    <td style="text-align: center; width: 55%;" class="kop">PT. RIAU SAKTI UNITED PLANTATIONS - INDUSTRY</td>
                    <td style="width: 15%;">Bagian</td>
                    <td style="width: 1%;">:</td>
                    <td style="width: 14%;"> <?php echo $row->DeptTujuan;?> </td>
                </tr>
                <tr>
                    <td style="text-align: center; width: 55%;" class="judul">SURAT PENGANTAR MASUK KERJA</td>
                    <td style="width: 15%;">Pemborong</td>
                    <td style="width: 1%;">:</td>
                    <td style="width: 14%;"> <?php echo $row->Pemborong;?> </td>
                </tr>
                <tr>
                    <td style="text-align: center; width: 55%;" class="judul">(HARI KERJA PERTAMA)</td>
                    <td style="width: 15%;">Tanggal</td>
                    <td style="width: 1%;">:</td>
                    <td style="width: 14%;"><?php foreach ($_getInterV as $set){    echo date("d M Y", strtotime($set->Tanggal));}?></td>
                </tr>
            </table>
            <p>Disampaikan kepada PENGAWAS, agar dapat diterima masuk kerja, TENAGA KERJA BARU dibawah ini :
            <table style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 15%;">Nama</td>
                        <td style="width: 5%;">:</td>
                        <td style="width: 60%; font-weight: bold;"><?php echo $row->Nama;?></td>
                        <td style="width: 10%; text-align: center;" rowspan="3"  border='1'>
                            Photo
                        </td>
                    </tr>
                    <tr>
                        <td>NIK</td>
                        <td>:</td>
                        <td>............................................</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td>
                            <?php foreach ($_getInterV as $set){    
                                if($set->JenisKerja == NULL){
                                    echo '............................................';
                                }else{
                                    echo $set->JenisKerja;
                                }  
                            }
                            ?>
                        </td>
                    </tr>
                </tbody>
            </table>
            Dan perlu kami beritahukan bahwa seluruh persyaratan proses administrsi menyangkut :
            <table>
                <tbody>
                    <tr>
                        <td style="width: 50px; text-align: center;">
                            <img src="<?php echo base_url();?>assets/img/Checked.PNG" width="16" height="16" alt="Checked"/>
                        </td>
                        <td>Aplikasi/Blangko-blangko TK Kontrak</td>
                    </tr>
                    <tr>
                        <td style="width: 50px; text-align: center;">
                            <img src="<?php echo base_url();?>assets/img/Checked.PNG" width="16" height="16" alt="Checked"/>
                        </td>
                        <td>Kualifakasi calon tenaga kerja Kontrak</td>
                    </tr>
                    <tr>
                        <td style="width: 50px; text-align: center;">
                            <img src="<?php echo base_url();?>assets/img/UnChecked.PNG" width="16" height="16" alt="UnChecked"/>
                        </td>
                        <td>Kelengkapan Surat-surat Mutasi(Jika yang Bersangkutan sebagai TK Mutasian)</td>
                    </tr>
                </tbody>
            </table>
            Telah SELESAI dan LENGKAP.<br/>
            Blangko diterima pengawas tanggal : ........................... (diisi oleh Pengawas)</p>
            <table style="width: 100%;" class="margin10">
                <tbody>
                    <tr>
                        <td colspan="2" style="text-align: center; width: 25%;">Dibuat Oleh</td>
                        <td colspan="2" style="text-align: center; width: 25%;">Disetujui Oleh</td>
                        <td colspan="2" style="text-align: center; width: 25%;">Diserahkan Oleh</td>
                        <td colspan="2" style="text-align: center; width: 25%;">Diterima Oleh</td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: <?php echo $adm;?> </td>
                        <td>Nama</td>
                        <td>: __________</td>
                        <td>Nama</td>
                        <td>: <?php 
                            foreach ($_getInterV as $set){
                                if($set->KepalaShift == NULL){
                                    echo '__________';
                                }else{
                                    echo $set->KepalaShift;
                                }
                            }?> 
                        </td>
                        <td>Nama</td>
                        <td>: __________</td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>: ADM </td>
                        <td>Jabatan</td>
                        <td>: __________</td>
                        <td>Jabatan</td>
                        <td>: KASHIFT</td>
                        <td>Jabatan</td>
                        <td>: PENGAWAS</td>
                    </tr>
                    <tr>
                        <td>Tanggal</td>
                        <td>: <?php echo $tglPrint;?> </td>
                        <td>Tanggal</td>
                        <td>: __________</td>
                        <td>Tanggal</td>
                        <td>: __________</td>
                        <td>Tanggal</td>
                        <td>: __________</td>
                    </tr>
                </tbody>
            </table>
            <hr/>
            Catatan :<br/>
            <table style="width: 100%;">
                <tr>
                    <td style="width: 5%; text-align: center;" >1.</td>
                    <td style="width: 95%;">
                        Tenaga kerja baru/ Mutasian yang pada hari pertama masuk kerja tidak membawa 
                        Surat Pengantar maka tidak ada pembayaran gajinya, dan penga yang mengijinkan masuk akan diberikan sanksi.
                    </td>
                </tr>
                <tr>
                    <td style="width: 5%; text-align: center;">2.</td>
                    <td style="width: 95%;">
                        ADM, memberikan tanda Conteng pada kotak setiap item apabila sudah lengkap, jika belum ADM tidak
                        diperbolehkan membuat surat pengantar ini.
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
            
</page>

<?php
    endforeach;