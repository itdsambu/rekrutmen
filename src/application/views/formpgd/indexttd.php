<?php
/* 
 * Author : Sigit___
 */
?>

<?php
    $Dept = $this->session->userdata('dept');
   // echo $this->session->userdata('groupuser');
?>
<!-- <link href="<?php echo base_url();?>assets/css/bootstrap.css" rel="stylesheet" media="screen"> -->
<div class="page-header">
    <h1>
        TTD
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Daftar TTD Surat PGD
        </small>
    </h1>
</div><!-- /.page-header -->
<?php
    foreach($getdatapgd as $r):
        $nik = $r->NIK;
    endforeach;
    $nottd = 'dataupload/ttdpgd/nottd.PNG';
    $namafoto = 'dataupload/ttdpgd/'.trim($nik).'.png';
?>
<?php
if ($this->input->get('msg') == 'success_add') {
    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Data behasil ditambahkan..</p>";
}elseif ($this->input->get('msg') == 'failed_add') {
    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
    <i class='ace-icon fa fa-times'></i></button>Mohon Maaf NIK tersebut sudah ditambah  ..</p>";
}else{
    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
    </button><strong>Warning!!</strong> PERMOHONAN PENGUNDURAN DIRI TENAGA KERJA masih tahap pengembangan..<br>";
}
?>
<?php if (($this->session->userdata('dept') == 'PSN') OR ($this->session->userdata('dept') == 'ITD')):?>
<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><b> Daftar Tanda Tangan Surat PGD</b></div>
                    <div class="panel-body">
                        <table id="dataTables-listTK" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th> 
                                    <th>NAMA</th>    
                                    <th>DEPT/BAG</th>
                                    <th>JABATAN</th>
                                    <th>TTD</th>
                                    <th>Action</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($getdatapgd)){?>
                                <tr>
                                    <td class="text-center" colspan="7">Data Masih Kosong</td>
                                </tr>
                                <?php } else {
                                    $no=1;
                                    foreach ($getdatapgd as $r) {
                                ?>
                                <tr>
                                    <td><?php echo $no++;?></td>
                                    <td><?php echo trim($r->NIK);?></td>
                                    <td><?php echo $r->NAMA;?></td>
                                    <td><?php echo $r->DeptAbbr;?></td>
                                    <td><?php echo $r->Jabatan;?></td>
                                    <td style="width: 100px;">
                                        <?php if($r->PemohonStatus == '1'):?>
                                            <img id="avatar" width="150" class="img-responsive" src="<?php echo base_url();?>dataupload/ttdpgd/<?php echo trim($r->NIK);?>.png"></img>
                                        <?php elseif($r->PemohonStatus == '2'):?>
                                            <span>
                                                PENDING
                                            </span>
                                        <?php else:?>
                                            <span class="profil-picture">
                                                <img id="avatar" width="100" class="img-responsive" src="<?php echo base_url($nottd) ?>"></img>
                                            </span>
                                        <?php endif;?>
                                    </td>
                                    <td><a href="<?php echo site_url('Suratpgd/ttsuratpgd'); ?>/<?php echo $r->DetailID;?>/<?php echo $r->NIK;?>" target="_blank" class="btn btn-minier btn-round btn-danger"> Tanda tangan</a></td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php else:?>
<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><b> Daftar Tanda Tangan Surat PGD</b></div>
                    <div class="panel-body">
                        <table id="dataTables-listTK" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>NIK</th> 
                                    <th>NAMA</th>    
                                    <th>DEPT/BAG</th>
                                    <th>JABATAN</th>
                                    <th>TTD</th>
                                    <th>Action</th>                                   
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($getdatapgddept)){?>
                                <tr>
                                    <td class="text-center" colspan="7">Data Masih Kosong</td>
                                </tr>
                                <?php } else {
                                    $no=1;
                                    foreach ($getdatapgddept as $r) {
                                ?>
                                <tr>
                                    <td><?php echo $no++;?></td>
                                    <td><?php echo trim($r->NIK);?></td>
                                    <td><?php echo $r->NAMA;?></td>
                                    <td><?php echo $r->DeptAbbr;?></td>
                                    <td><?php echo $r->Jabatan;?></td>
                                    <td style="width: 100px;">
                                        <?php if($r->PemohonStatus == '1'):?>
                                            <img id="avatar" width="150" class="img-responsive" src="<?php echo base_url();?>dataupload/ttdpgd/<?php echo trim($r->NIK);?>.png"></img>
                                        <?php elseif($r->PemohonStatus == '2'):?>
                                            <span>
                                                PENDING
                                            </span>
                                        <?php else:?>
                                            <span class="profil-picture">
                                                <img id="avatar" width="100" class="img-responsive" src="<?php echo base_url($nottd) ?>"></img>
                                            </span>
                                        <?php endif;?>
                                    </td>
                                    <td><a href="<?php echo site_url('Suratpgd/ttsuratpgd'); ?>/<?php echo $r->DetailID;?>/<?php echo $r->NIK;?>" target="_blank" class="btn btn-minier btn-round btn-danger"> Tanda tangan</a></td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
