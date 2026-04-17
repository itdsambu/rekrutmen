<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            List Tenaga Kerja Baru
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">List Tenaga Kerja Baru untuk Upload Document/ Berkas</h4>

                        <div class="widget-toolbar">
                            <select id="filter_status">
                                <option value="tidak_lengkap" <?php if($_filter_selected == 'tidak_lengkap'){ echo 'selected'; }?>>Tidak Lengkap</option>
                                <option value="minimal" <?php if($_filter_selected == 'minimal'){ echo 'selected'; }?>>Minimal Berkas</option>
                                <option value="lengkap" <?php if($_filter_selected == 'lengkap'){ echo 'selected'; }?>>Berkas Lengkap</option>
                            </select>
                            <script>
                                $("#filter_status").change(function(){
                                    let filter_selected = $("#filter_status").val();
                                    let selected = $("#selList").val();
                                    
                                    if(selected != ''){
                                        window.location = '<?php echo site_url(); ?>UploadBerkas/listTKforUploadDoc/' + selected + '/' + filter_selected;
                                    }else{
                                        window.location = '<?php echo site_url(); ?>UploadBerkas/listTKforUploadDoc/' + filter_selected;
                                    }
                                });
                            </script>
                        </div>
                        <div class="widget-toolbar">
                            <select id="selList">
                                <option value="0">Default</option>
                                <option value="1" <?php if($_selected == 1){ echo 'selected'; }?> >Surat Kontrak</option>
                            </select>
                            <script>
                                $("#selList").change(function(){
                                    let selected = $("#selList").val();
                                    
                                    if(selected === '1'){
                                        window.location = '<?php echo site_url(); ?>UploadBerkas/listTKforUploadDoc/' + selected;
                                    }else{
                                        window.location = '<?php echo site_url(); ?>UploadBerkas/listTKforUploadDoc/';
                                    }
                                });
                            </script>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main"> 
                            <?php if($this->input->get('msg') == 'success_edit'){
                                echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Edit data berhasil..</p>";
                            }elseif ($this->input->get('msg') == 'failed_edit') {
                                echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Edit data tidak berhasil..</p>";
                            }elseif ($this->input->get('msg') == 'success_delete') {
                                echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Data behasil dihapus..</p>";
                            }elseif ($this->input->get('msg') == 'failed_delete') {
                                echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'> <i class='ace-icon fa fa-times'></i></button>Data tidak behasil dihapus..</p>";
                            } ?>
                            <div class="table-responsive">
                                <table id="dataTables-listTK" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Pemborong</th>
                                        <th>Tangga Lahir</th>                                    
                                        <th>Jenis Kelamin</th>
                                        <th>Status</th>
                                        <th> <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By </th>
                                        <th> <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Registered Date </th>
                                        <th>do Upload</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($getListTK as $set): ?>
                                            <?php if ($set->InputOnline === 1){
                                                echo '<tr data-id="'.$set->HeaderID.'" class="rowdetail success" >';
                                            }else{
                                                echo '<tr data-id="'.$set->HeaderID.'" class="rowdetail" >';
                                            } ?>
                                            <td><?php echo $set->HdrID;?></td>
                                            <td><?php echo $set->Nama;?></td>
                                            <td><?php echo $set->Pemborong;?></td>
                                            <td class="text-right col-md-1" ><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir));?></td>
                                            <td>
                                                <?php 
                                                    $jekel = $set->Jenis_Kelamin;
                                                    if($jekel == 'M' || $jekel == 'LAKI-LAKI'){
                                                        echo 'Laki-laki';
                                                    }elseif ($jekel == 'F' || $jekel == 'PEREMPUAN') {
                                                        echo 'Perempuan';
                                                    }  else {
                                                        echo 'Gx Jelas';
                                                    }
                                                ?>
                                            </td>
                                            <td class="text-center col-md-1">
                                                <?php if ($set->KTP != NULL && $set->Lamaran != NULL && $set->CV != NULL && $set->Ijazah != NULL && $set->Transkrip != NULL) {   
                                                    echo "<span class='label label-sm label-success'>Berkas Lengkap</span>";
                                                }elseif($set->KTP != NULL){
                                                    echo "<span class='label label-sm label-info'>Minimal Berkas</span>";
                                                }  else {
                                                    echo "<span class='label label-sm label-danger'>Tidak Lengkap</span>";
                                                } ?>
                                            </td>
                                            <td><?php echo $set->RegisteredBy;?></td>
                                            <td class="text-right"><?php echo $set->RegisteredDate;?></td>
                                            <td class="text-center">
                                                <?php if($_selected == 1) : ?>
                                                    <a title="Upload Surat Perjanjian Kontrak" class="btn btn-minier btn-round btn-success" href="<?php echo site_url ('UploadBerkas/doUploadSPK')."?id=".$set->HdrID."&nama=".$set->Nama; ?>"> Upload </a>
                                                <?php else : ?>
                                                    <a title="Upload foto" class="btn btn-minier btn-round btn-primary" href="<?php echo site_url ('UploadBerkas/doEditFoto')."?id=".$set->HdrID."&nama=".$set->Nama; ?>"> Edit Foto </a>
                                                    <a title="Upload berkas" class="btn btn-minier btn-round btn-success" href="<?php echo site_url ('UploadBerkas/doEditBerkas')."?id=".$set->HdrID."&nama=".$set->Nama; ?>"> Upload </a>
                                                <?php endif; ?>
                                                    <div class="btn-group">
                                                        <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle"> Berkas <span class="ace-icon fa fa-caret-down icon-on-right"></span> </button>
                                                        <ul class="dropdown-menu dropdown-default">
                                                    <li>
                                                        <?php if ($set->KTP != NULL){?>
                                                            <a title="show KTP" data-rel="tooltip" href="#" class="berkas" data-name="KTP" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">KTP</a>
                                                            <?php 
                                                        } else { 
                                                            echo "<a><small><i>KTP is NULL</i></small></a>"; 
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->KK != NULL){?>
                                                            <a title="show KK" data-rel="tooltip" href="#" class="berkas" data-name="KK" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">KK</a>
                                                            <?php 
                                                        } else { 
                                                            echo "<a><small><i>KK is NULL</i></small></a>"; 
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->SKCK != NULL){?>
                                                            <a title="show SKCK" data-rel="tooltip" href="#" class="berkas" data-name="SKCK" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">SKCK</a>
                                                            <?php 
                                                        } else { 
                                                            echo "<a><small><i>SKCK is NULL</i></small></a>"; 
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Lamaran != NULL){?>
                                                            <a title="show Lamaran" data-rel="tooltip" href="#" class="berkas" data-name="Lamaran" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Lamaran</a>
                                                            <?php 
                                                        }else{ 
                                                            echo "<a><small><i>Lamaran is NULL</i></small></a>"; 
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->CV != NULL){?>
                                                            <a title="show CV" data-rel="tooltip" href="#" class="berkas" data-name="CV" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Curiculum Vitae</a>
                                                            <?php 
                                                        } else { 
                                                            echo "<a><small><i>Curiculum Vitae is NULL</i></small></a>"; 
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Ijazah != NULL){?>
                                                            <a title="show Ijazah" data-rel="tooltip" href="#" class="berkas" data-name="Ijazah" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Ijazah</a>
                                                            <?php 
                                                        } else { 
                                                            echo "<a><small><i>Ijazah is NULL</i></small></a>"; 
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Transkrip != NULL){?>
                                                            <a title="show Transkrip" data-rel="tooltip" href="#" class="berkas" data-name="Transkrip" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Transkrip Nilai</a>
                                                            <?php 
                                                        } else { 
                                                            echo "<a><small><i>Transkrip is NULL</i></small></a>"; 
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Vaksin1 != NULL){?>
                                                            <a title="show Vaksin1" data-rel="tooltip" href="#" class="berkas" data-name="Vaksin1" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Sertifikat Vaksin 1</a>
                                                            <?php 
                                                        } else { 
                                                            echo "<a><small><i>Sertifikat Vaksin 1 is NULL</i></small></a>"; 
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Vaksin2 != NULL){?>
                                                            <a title="show Vaksin2" data-rel="tooltip" href="#" class="berkas" data-name="Vaksin2" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Sertifikat Vaksin 2</a>
                                                            <?php 
                                                        } else { 
                                                            echo "<a><small><i>Sertifikat Vaksin 2 is NULL</i></small></a>"; 
                                                        } ?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Vaksin3 != NULL){?>
                                                            <a title="show Vaksin3" data-rel="tooltip" href="#" class="berkas" data-name="Vaksin3" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Sertifikat Vaksin 3</a>
                                                            <?php 
                                                        } else { 
                                                            echo "<a><small><i>Sertifikat Vaksin 3 is NULL</i></small></a>"; 
                                                        }?>
                                                    </li>
                                                    
                                                    <li>
                                                        <a title="print daftar riwayat hidup" href="<?= site_url('toExcel/printdrh')."?id=".$set->HdrID;?>" data-name="Daftar Riwayat Hidup" data-tk="<?php echo ucwords(strtolower($set->HeaderID));?>">
                                                            <small>Daftar Riwayat Hidup</small>
                                                        </a>
                                                    </li>
                                                        </ul>
                                                    </div>
                                                    <a data-rel="tooltip" title="View Detail" href="#" class="detail btn btn-minier btn-round btn-primary">Detail</a>
                                            </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal View -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Informasi Data Karyawan</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detail" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">				
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal View Berkas-->
<div class="modal fade" id="viewModalBerkas" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleModal"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="berkas" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">				
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        // hidden filter berkas untuk selain pemborong
        let hidden_pemborong = <?= $hidden_pemborong ?>;
        if (hidden_pemborong == '0') {
        $("#filter_status").prop("hidden", "true");        
        }


        $('#dataTables-listTK').dataTable();
        $('[data-rel=tooltip]').tooltip();
        
        $("#dataTables-listTK").on("click", ".detail", function() {
            let id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('UploadBerkas/detailtk');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#detail").html(msg);
                }				
            });
            $("#viewModal").modal("show");
        });
        
        $("#dataTables-listTK").on("click", ".berkas", function() {
            let id    = $(this).closest('tr').data('id');
            let name  = $(this).data('name');
            let tk    = $(this).data('tk');
                
            document.getElementById('titleModal').textContent = "Berkas "+name+" dari saudara, "+tk+"";
            $.ajax({
                url:"<?php echo site_url('monitor/viewDocs');?>",
                type:"POST",
                data:"kode="+id+"&nama="+name,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#berkas").html(msg);
                }				
            });
            $("#viewModalBerkas").modal("show");
        });
    });
</script>
