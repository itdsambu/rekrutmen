<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Verifikasi Calon Tenaga Kerja
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
                        <h4 class="widget-title">List Tenaga Kerja Baru </h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <?php $att = array('class'=>'form-horizontal', 'role'=>'form');
                        echo form_open('panggilan/panggilAksi', $att);
                    ?>
                    <div class="widget-body">
                        <div class="widget-main">
                            <div class="table-responsive">
                            <table id="dataTables-listTK" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="text-center">
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace">
                                            <span class="lbl"></span>
                                        </label>
                                    </th>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Pemborong</th>
                                    <th>Tangga Lahir</th>                                    
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                    <th>Berkas</th>
                                    <th>
                                        <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                    </th>
                                    <th>
                                        <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Registered Date
                                    </th>
                                    <th>Opsi</th>
                                </tr>
                                </thead>

                                <tbody>
                                <?php
                                foreach ($getListTK as $set):
                                    ?>
                                    <?php
					echo '<tr data-id="'.$set->HeaderID.'" class="rowdetail info" >';
                                    ?>
                                        <td class="text-center">
                                            <div class="checkbox">
                                            <label class="pos-rel">
                                                <input name="checkPanggil[]" type="checkbox" class="ace" value="<?php echo $set->HeaderID;?>">
                                                <span class="lbl"></span>
                                            </label>
                                            </div>
                                        </td>
                                        <td style="width: 50px " class="text-right"><?php echo $set->HeaderID;?></td>
                                        <td><?php echo $set->Nama;?></td>
                                        <td><?php echo $set->Pemborong;?></td>
                                        <td class="text-right" ><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir));?></td>
                                        <td><?php 
                                        $jekel = $set->Jenis_Kelamin;
                                            if($jekel == 'M'){
                                                echo 'Laki-laki';
                                            }elseif ($jekel == 'F') {
                                                echo 'Perempuan';
                                            }  else {
                                                echo 'Gx Jelas';
                                            }
                                        ?></td>
                                        <td><?php 
                                        $Gs= $set->Panggil;
                                            if($Gs == 1){
                                                echo "<span class='label label-sm label-info arrowed-right arrowed-in'>Telah Verifikasi</span>";
                                            }else{
                                                echo "<span class='label label-sm label-danger arrowed-right arrowed-in'>Belum Verifikasi</span>";
                                            }
                                        ?></td>
                                        <td>
                                            <?php
                                                if ($set->KTP != NULL && $set->Lamaran != NULL && $set->CV != NULL && $set->Ijazah != NULL && $set->Transkrip != NULL) {   
                                                    echo "<span class='label label-sm label-success arrowed'>Berkas Lengkap</span>";
                                                }elseif($set->KTP != NULL && $set->Lamaran != NULL){
                                                    echo "<span class='label label-sm label-info arrowed'>Minimal Berkas</span>";
                                                }  else {
                                                    echo "<span class='label label-sm label-danger arrowed'>Tidak Lengkap </span>";
                                                }
                                            ?>
                                        </td>
                                        <td><?php echo $set->RegisteredBy;?></td>
                                        <td class="text-right"><?php echo $set->RegisteredDate;?></td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                                                    Berkas
                                                    <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                                                </button>
                                                <ul class="dropdown-menu dropdown-default">
                                                    <li>
                                                        <?php if ($set->KTP != NULL){?>
                                                        <a title="show KTP" data-rel="tooltip" href="#" class="berkas" data-name="KTP" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">KTP</a>
                                                        <?php }else{ echo "<a><small><i>KTP is NULL</i></small></a>"; }?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Lamaran != NULL){?>
                                                        <a title="show Lamaran" data-rel="tooltip" href="#" class="berkas" data-name="Lamaran" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Lamaran</a>
                                                        <?php }else{ echo "<a><small><i>Lamaran is NULL</i></small></a>"; }?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->CV != NULL){?>
                                                        <a title="show CV" data-rel="tooltip" href="#" class="berkas" data-name="CV" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Curiculum Vitae</a>
                                                        <?php }else{ echo "<a><small><i>Curiculum Vitae is NULL</i></small></a>"; }?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Ijazah != NULL){?>
                                                        <a title="show Ijazah" data-rel="tooltip" href="#" class="berkas" data-name="Ijazah" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Ijazah</a>
                                                        <?php }else{ echo "<a><small><i>Ijazah is NULL</i></small></a>"; }?>
                                                    </li>
                                                    <li>
                                                        <?php if ($set->Transkrip != NULL){?>
                                                        <a title="show Transkrip" data-rel="tooltip" href="#" class="berkas" data-name="Transkrip" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Transkrip Niali</a>
                                                        <?php }else{ echo "<a><small><i>Transkrip is NULL</i></small></a>"; }?>
                                                    </li>
                                                </ul>
                                            </div>
                                            <a title="View Detail" data-rel="tooltip" href="#" class="detail btn btn-minier btn-round btn-primary">
                                                <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <div class="widget-toolbox padding-8 clearfix">
                        <div class="well text-center">
                            <input type="submit" value="Submit" name="Panggil" class="btn btn-success" >
                            <input type="submit" value="Cancel" name="Cancel" class="btn btn-danger" >
                        </div>
                    </div>
                    </form>
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
        $('#dataTables-listTK').dataTable();
        $('[data-rel=tooltip]').tooltip();
        
        $("#dataTables-listTK").on("click", ".detail", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('panggilan/detailtk');?>",
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
                var id = $(this).closest('tr').data('id');
                var name = $(this).data('name');
                var tk = $(this).data('tk');
                
                document.getElementById('titleModal').innerHTML = "Berkas "+name+" dari saudara, <strong class='green'>"+tk+"</strong>";
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
        
        var active_class = 'active';
        $('#dataTables-listTK > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
            var th_checked = this.checked;//checkbox inside "TH" table header
            $(this).closest('table').find('tbody > tr').each(function(){
                var row = this;
                if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
            });
        });
    });
</script>
