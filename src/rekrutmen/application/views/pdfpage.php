<style>

table
{
	width:100%;
	border: solid 1px;
}

h5
{
	padding:0;
	margin-bottom:5px;
	margin-top:0;
}

th 
{
   padding:5px;	
   margin:0;
}

td{
	border-top: 1px;
	margin:0;
	padding-top:2px;
	padding-bottom:2px;
}

.fill{
	border-right:1px;
}

.tcenter {
	text-align:center;
}
.tright{
	text-align:right;
}
.tleft{
	text-align:left;
}
.pleft {
	padding-left:5px;
}
.pright{
	padding-right:5px;
}

</style>
<page style="font-size: 10px" backtop="14mm" backbottom="14mm" backleft="8mm" backright="80mm">
<h3 style="text-align: center;">Data Bon TK</h3>

<h5>Perusahaan : <?php echo $Perusahaan; ?> </h5>
<h5>Periode : <?php echo $periode; ?></h5>

<table cellspacing="0" cellpadding:"0" align="center">
<thead>
<tr>
    <th style="width=40%">Dept</th>
    <th style="width=40%;">Bagian</th>
    <th style="width=30%;">Nik</th>
    <th style="width=50%;">Nama</th>
    <th style="width=40%;" class="tright pright">Bon (Rp.)</th>
</tr>
</thead>
<tbody>
    <?php
	   foreach($ndata as $idata){
		   echo '<tr>';
		      echo '<td class="fill tcenter">'.$idata['DeptAbbr'].'</td>';
			  echo '<td class="fill pleft">'.$idata['Jabatan'].'</td>';
			  echo '<td class="fill pleft">'.$idata['Nik'].'</td>';
			  echo '<td class="fill pleft">'.$idata['Nama'].'</td>';
			  echo '<td class="tright pright">'. number_format($idata['Bon'],0,',','.').'</td>';
		   echo '</tr>';
	   }
	?>
</tbody>
</table>	
</page>