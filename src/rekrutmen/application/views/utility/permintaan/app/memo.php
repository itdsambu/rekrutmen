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
	text-align: justify;
}
.margin10{
    margin-left: 20px;
    margin-right: 10px;
}

hr.onepixel{
	border-top : 1px solid #000000;
	border-bottom : 1px solid #000000;
	height : 0px;
	margin-top : 20px;
}
</style>

<?php
    foreach ($_data as $row):
?>
<table style="width: 100%;">
    <tr>
        <td>
            <table style="width: 100%; margin-top:30px;" >
                <tr>
                    <td style="text-align: left; font-size:25px; width: 10%; border: 1px;" class="kop">
						<img src="<?php echo base_url();?>assets/img/psg-logo.png" width="100px"/>
					</td>
					<td style="text-align: center; font-size:20px; width: 90%; border: 1px;" class="kop">
						PT. PULAU SAMBU<br>
						<h3 style="font-size:35px;"><u>INTERNAL MEMO</u></h3><p>
						<h6 style="margin-top: 1px;"><?php echo $row->Doc;?></h6>
					</td>
                </tr>
				<tr>
                    <td>&nbsp;</td>
                </tr>
				<tr>
                    <td>&nbsp;</td>
                </tr>
			</table>
			<table style="width: 100%;" class="margin10">
				<tr>
                    <td style="text-align: right; width:45%;" class="kop">Kepada</td>
					<td style="text-align: center;" class="kop">:</td>
					<td style="text-align: left;" class="kop">MGT</td>
                </tr>
				<tr>
                    <td style="text-align: right; width:45%;" class="kop">CC</td>
					<td style="text-align: center;" class="kop">:</td>
					<td style="text-align: left;" class="kop">PSN</td>
                </tr>
				<tr>
                    <td style="text-align: right; width:45%;" class="kop">Dari</td>
					<td style="text-align: center;" class="kop">:</td>
					<td style="text-align: left;" class="kop">Dept. <?php echo $row->DeptAbbr;?></td>
                </tr>
				<tr>
                    <td style="text-align: right; width:45%;" class="kop">Hari / Tanggal</td>
					<td style="text-align: center;" class="kop">:</td>
					<td style="text-align: left;" class="kop">
						<?php
							if($row->CreatedDate == 'Sun'){echo 'Minggu';}
							elseif($row->CreatedDate == 'Mon'){echo 'Senin';}
							elseif($row->CreatedDate == 'Tue'){echo 'Selasa';}
							elseif($row->CreatedDate == 'Wed'){echo 'Rabu';}
							elseif($row->CreatedDate == 'Thu'){echo 'Kamis';}
							elseif($row->CreatedDate == 'Fri'){echo 'Jumat';}
							else{echo 'Sabtu';}
						?> / <?php echo date('d-m-Y',strtotime($row->CreatedDate))?>
					</td>
                </tr>
				<tr>
                    <td style="text-align: right; width:45%;" class="kop">Perihal</td>
					<td style="text-align: center;" class="kop">:</td>
					<td style="text-align: left;" class="kop"><u>Permohonan Penambahan Jumlah <?php if($row->IsKry == 1){echo 'Karyawan';}else{echo 'TK';}?> Ideal Dept</u></td>
                </tr>
			</table>
			<hr class="onepixel">
			<table style="width: 100%;" class="margin10">
				<tr>
                    <td style="text-align: left;" class="kop">Dengan hormat,</td>
                </tr>
			</table>
			<br/>
			<table style="width: 100%;" class="margin10">
				<tr>
                    <td style="text-align: left;" class="kop">Melalui internal memo ini kami mohon untuk penambahan <?php if($row->IsKry == 1){echo 'Karyawan';}else{echo 'TK';}?> Ideal diprogram rekrutmen :</td>
                </tr>
			</table>
			<br/>
			<table style="width: 100%;" class="margin10">
				<tr>
                    <td style="text-align: left; width:25%;" class="kop">Jumlah ideal sekarang</td>
					<td style="text-align: left;" class="kop">:</td>
					<td style="text-align: left;" class="kop">
						<?php
							if($row->IsKry == 1){
								echo $row->IKry;
							}else{
								echo $row->IBor;
							}
						?>
					</td>
                </tr>
				<tr>
                    <td style="text-align: left; width:25%;" class="kop">Jumlah ideal tambahan</td>
					<td style="text-align: left;" class="kop">:</td>
					<td style="text-align: left;" class="kop">
						<?php
							if($row->IsKry == 1){
								echo $row->Jumlah - $row->IKry;
							}else{
								echo $row->Jumlah - $row->IBor;
							}
						?>
					</td>
                </tr>
				<tr>
                    <td style="text-align: left; width:25%;" class="kop">Total</td>
					<td style="text-align: left;" class="kop">:</td>
					<td style="text-align: left;" class="kop">
						<?php
							if($row->IsKry == 1){
								echo $row->Jumlah;
							}else{
								echo $row->Jumlah;
							}
						?>
					</td>
                </tr>
			</table>
			<br/>
			<table style="width: 100%;" class="margin10">
				<tr>
                    <td style="text-align: left;" class="kop">Alasan penambahan <?php if($row->IsKry == 1){echo 'Karyawan';}else{echo 'TK';}?> Ideal sebagai berikut :</td>
                </tr>
				<tr>
                    <td style="text-align: left;" class="kop">
						<?php echo $row->Alasan;?>
					</td>
                </tr>
			</table>
			<br/>
			<table style="width: 100%;" class="margin10">
				<tr>
                    <td style="text-align: left;" class="kop">Demikian kami sampaikan, atas kerjasamanya kami ucapkan terimakasih.</td>
                </tr>
			</table>
			<br/>
			<br/>
			<br/>
			<table style="width: 100%;" class="margin10">
				<tr>
                    <td style="text-align: left; width:35%" class="kop">Dibuat oleh,</td>
					<td style="text-align: left; width:35%" class="kop">Diketahui oleh,</td>
					<td style="text-align: left; width:35%" class="kop">Disetujui oleh,</td>
                </tr>
			</table>
			<table style="width: 100%;" class="margin10">
				<tr>
                    <td style="text-align: left; width:35%" class="kop">
					<?php if($row->Approved1Sts == '1'){?>
						<img id="avatar" src="<?php echo base_url();?>assets/tanda_tangan/"<?php echo $row->Approved1By;?>".png" width="100px;"/>
					<?php }else{ ?>
						<img id="avatar" width="100px" class="img-responsive" src="<?php echo base_url();?>dataupload/ttdpgd/nottd.png"></img>
					<?php } ?>
					</td>
					<td style="text-align: left; width:35%" class="kop">
					<?php if($row->Approved2Sts == '1'){?>
						<img id="avatar" src="<?php echo base_url();?>assets/tanda_tangan/"<?php echo $row->Approved2By;?>".png" width="100px;"/>
					<?php }else{ ?>
						<img id="avatar" width="100px" class="img-responsive" src="<?php echo base_url();?>dataupload/ttdpgd/nottd.png"></img>
					<?php } ?>
					</td>
					<td style="text-align: left; width:35%" class="kop">
					<?php if($row->Approved3Sts == '1'){?>
						<img id="avatar" src="<?php echo base_url();?>assets/tanda_tangan/"<?php echo $row->Approved3By;?>".png" width="100px;"/>
					<?php }else{ ?>
						<img id="avatar" width="100px" class="img-responsive" src="<?php echo base_url();?>dataupload/ttdpgd/nottd.png"></img>
					<?php } ?>
					</td>
                </tr>
			</table>
			<table style="width: 100%;" class="margin10">
				<tr>
                    <td style="text-align: left; width:35%" class="kop"><u><?php echo $row->Approved1By;?></u></td>
					<td style="text-align: left; width:35%" class="kop"><u><?php echo $row->Approved2By;?></u></td>
					<td style="text-align: left; width:35%" class="kop"><u><?php echo $row->Approved3By;?></u></td>
                </tr>
				<tr>
                    <td style="text-align: left; width:35%" class="kop">Pimpinan Dept</td>
					<td style="text-align: left; width:35%" class="kop">Mgr Divisi</td>
					<td style="text-align: left; width:35%" class="kop">Management</td>
                </tr>
			</table>
		</td>
	</tr>
</table>
<?php endforeach;?>