<div class="page-header">
    <h1>
        SCREENING
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Screening Oleh Tim Screening
        </small>
    </h1>
</div><!-- /.page-header -->
<?= $this->session->userdata('dept') ?>
<?= $this->session->userdata('username')?>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">List Tenaga Kerja Baru </h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <?php
                        if($this->input->get('msg') == 'Success'){
                            echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                    <i class='ace-icon fa fa-times'></i></button>Screening by TEAM Success!</p>";
                        }
                    ?>
                    <div class="table-responsive">
                    <table id="dataTables-listTK" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Tujuan Lamaran</th>
                            <th>Pemborong</th>
                            <th>Tangga Lahir</th>                                    
                            <th>Jenis Kelamin</th>
                            <th>Status</th>
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
                        foreach ($_getTK as $set):
                            ?>
                            <?php
                                echo '<tr data-id="'.$set->HeaderID.'" class="rowdetail info" >';
                            ?>
                                <td style="width: 50px " class="text-right"><?php echo $set->HeaderID;?></td>
                                <td><?php echo $set->Nama;?></td>
                                <td><?php echo $set->CVNama;?></td>
                                <td><?php echo $set->Pemborong;?></td>
                                <td class="text-right" ><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir));?></td>
                                <td><?php 
                                $jekel = $set->Jenis_Kelamin;
                                    if($jekel == 'M' || $jekel == 'LAKI-LAKI'){
                                        echo 'Laki-laki';
                                    }elseif ($jekel == 'F' || $jekel == 'PEREMPUAN') {
                                        echo 'Perempuan';
                                    }  else {
                                        echo 'Gx Jelas';
                                    }
                                ?></td>
                                <td><?php 
                                $Gs= $set->ScreeningComplete;
                                    if($Gs == 1){
                                        echo "<span class='label label-sm label-info'>Done</span>";
                                    }else{
                                        echo "<span class='label label-sm label-warning'>On Progress</span>";
                                    }
                                ?></td>
                                <td><?php echo $set->RegisteredBy;?></td>
                                <td class="text-right"><?php echo $set->RegisteredDate;?></td>
                                <td class="text-center">
                                    <a title="do Screening" href="#" class="screening">
                                        <button class="btn btn-minier btn-primary">
                                            <i class="ace-icon fa fa-files-o bigger-100"></i> Screening</button>
                                    </a>
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

<!-- Modal View Detail-->
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

<!-- Modal View Screening-->

<div class="modal fade" id="viewModalScreening" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->				
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Screening Tim by <strong class="green"><?php echo $this->session->userdata('username');?></strong></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="screening" class="well">
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
        
        $("#dataTables-listTK").on("click", ".detail", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('screeningByTim/detailtk');?>",
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
        
        $("#dataTables-listTK").on("click", ".screening", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('screeningByTim/screenTim');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#screening").html(msg);
                }				
            });
            $("#viewModalScreening").modal("show");
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