<div class="page-header">
    <h1>
        BLACKLIST
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Personil Profile
        </small>
    </h1>
</div>
<?php 
	foreach ($getUserTK as $row): 
		$nik = $row->NIK;
	endforeach;
	$namafotoTK = 'dataupload/Blacklist/BORONGAN/'.trim($nik).'.jpg';
?>
<div class="row">
    <?php foreach ($getUserTK as $row): ?>
        <!-- <pre>
            <?php print_r($row);?>
        </pre> -->
    <div class="tabbable">
        <ul class="nav nav-tabs padding-18">
            <li class="active">
                <a data-toggle="tab" href="#home" aria-expanded="true">
                    <i class="green ace-icon fa fa-user bigger-120"></i> Profile
                </a>
            </li>
        </ul>
        <div class="tab-content no-border padding-24">
            <div id="home" class="tab-pane active">
                <div class="col-xs-12">
                    <div class="col-xs-12 col-sm-5 center">
                        <div>
                            <span class="profile-picture">
                                <ul class="ace-thumbnails clearfix">
                                    <li>
                                    <!-- <img id="avatar" width="150" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url($namafotoK) ;?>" alt=""></img>
                                    <img id="avatar" width="150" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url($namafotoTK) ;?>" alt=""></img> -->

                                    <img id="avatar" width="150" class="editable img-responsive editable-click editable-empty" src="
                                    <?php
                                        if($row->CVNama == 'PT. PULAU SAMBU GUNTUNG'){
                                            echo base_url($namafotoK);
                                        }else{
                                            echo base_url($namafotoTK);
                                        }
                                    ?>" alt=""></img>

                                    </li>
                                </ul>
                            </span>
                            <div class="space-4"></div>

                            <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                <div class="inline position-relative">
                                    <div class="user-title-label dropdown-toggle">
                                            <i class="ace-icon fa fa-circle light-green"></i>
                                            &nbsp;
                                            <span class="white"><?php echo $row->NIK;?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-7">
                        <div class="space-12"></div>
                        <!-- #section:pages/profile.info -->
                        <div class="profile-user-info profile-user-info-striped">
                            <div class="profile-info-row">
                                <div class="profile-info-name"> NIK </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="username"><?php echo $row->NIK;?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> NAMA </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="username"><?php echo $row->Nama;?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Perusahaan/ CV </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="username"><?php echo $row->CVNama;?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Pemborong </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="username"><?php echo $row->Pemborong;?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Departemen </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="username"><?php echo strtoupper($row->DeptAbbr);?></span>
                                </div>
                            </div>
							<div class="profile-info-row">
                                <div class="profile-info-name"> Tangal Lahir </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="age"><?php echo date('d-M-Y', strtotime($row->TglLahir));?></span>
                                </div>
                            </div>
							<div class="profile-info-row">
                                <div class="profile-info-name"> Daerah Asal </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="signup"><?php echo $row->DaerahAsal;?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Tangal Masuk </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="age"><?php echo date('d-M-Y', strtotime($row->TglMasuk));?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Tangal Keluar </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="signup"><?php echo date('d-M-Y', strtotime($row->TglKeluar));?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Nama Ibu Kandung </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="signup"><?php echo $row->NamaIbuKandung;?></span>
                                </div>
                            </div>
                            <div class="profile-info-row">
                                <div class="profile-info-name"> Keterangan </div>
                                <div class="profile-info-value">
                                    <span class="editable editable-click" id="signup"><?php echo $row->Remark;?></span>
                                </div>
                            </div>
                        </div>
                        <!-- /section:pages/profile.info -->
                        <div class="space-20"></div>
                    </div>
                </div>
            </div>
            <div id="agenda" class="tab-pane">
                <?php
                    if($_isMobile == 1){
                        $display    = 'none';
                    }else{
                        $display    = 'block';
                    }
                ?>
                <div class="col-xs-12" style="display: <?php echo $display;?>; border: none;">
                    <iframe class="col-xs-12" height="500" src="<?php echo site_url('mynotes');?>"></iframe>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<div class="clearfix form-actions">
    <div class="col-md-offset-5 col-md-7">
        <div class="btn-group">
            <a id="table_flow_new" class="btn btn-circle btn-danger" href='<?php echo base_url("blacklist/listBlacklist"); ?>'>
                <i class="fa fa-undo"></i> Kembali 
            </a>
        </div>
    </div>
</div>


<div class="modal fade" id="viewChagePhoto" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Change Photo, <strong class="green"><?php echo $this->session->userdata('username');?></strong></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="formUpload" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script type="text/javascript">
    jQuery(function($) {
        $('a[ data-original-title]').tooltip();
        
        $("#photo").on("click", ".changePhoto", function() {
            var id = $(this).data('id');
            $.ajax({
                url:"<?php echo site_url('blacklist/photo');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#formUpload").html(msg);
                }				
            });
            $("#viewChagePhoto").modal("show");
        });
    });
</script>		 -->