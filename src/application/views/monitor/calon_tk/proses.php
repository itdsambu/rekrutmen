<table id="dataTables-proses" class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Pemborong</th>
            <th>Tangga Lahir</th>                                    
            <th>Jenis Kelamin</th>
            <th>
                Record Interview
            </th>
            <th>
                <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Registered Date
            </th>
            <th>Opsi</th>
        </tr>
    </thead>

    <tbody>
    <?php
    foreach ($_getTenaker as $set):
        ?>
            <?php
            if ($set->InputOnline === 1){
                    echo '<tr data-id="'.$set->HeaderID.'" class="rowdetail success" >';
            }else{
                    echo '<tr data-id="'.$set->HeaderID.'" class="rowdetail" >';
            }
        ?>
            <td><?php echo $set->HdrID;?></td>
            <td><?php echo $set->Nama;?></td>
            <td><?php echo $set->Pemborong;?></td>
            <td class="text-right col-md-1" ><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir));?></td>
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
            <td class="text-center">
                <?php
                    if($set->WawancaraKe == NULL){
                        echo 'Belum Pernah';
                    }else{
                ?>
                    <a title="View Detail" data-rel="tooltip" href="#" class="detailInterview btn btn-minier btn-white btn-block">
                        <i class="ace-icon fa fa-files-o bigger-100"></i> <?php echo $set->WawancaraKe.' kali';?>
                    </a>
                <?php
                    }
                ?>
            </td>
            <td>
                <div class="text-left"><?php echo ucwords(strtolower($set->CreatedBy));?></div>
                <div class="text-right smaller-90"><?php echo $set->RegisteredDate;?></div>
            </td>
            <td class="text-center">
                <div class="btn-group">
                    <button data-toggle="dropdown" class="btn btn-mini btn-round btn-purple dropdown-toggle">
                        Berkas
                        <span class="ace-icon fa fa-caret-down icon-on-right"></span>
                    </button>
                    <ul class="dropdown-menu dropdown-default">
                        <li>
                            <?php if ($set->KTP != NULL){?>
                            <a title="show detail" href="#" class="detail" data-name="KTP" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">KTP</a>
                            <?php }else{ echo "<a><small><i>KTP is NULL</i></small></a>"; }?>
                        </li>
                        <li>
                            <?php if ($set->Lamaran != NULL){?>
                            <a title="show detail" href="#" class="detail" data-name="Lamaran" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Lamaran</a>
                            <?php }else{ echo "<a><small><i>Lamaran is NULL</i></small></a>"; }?>
                        </li>
                        <li>
                            <?php if ($set->CV != NULL){?>
                            <a title="show detail" href="#" class="detail" data-name="CV" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Curiculum Vitae</a>
                            <?php }else{ echo "<a><small><i>Curiculum Vitae is NULL</i></small></a>"; }?>
                        </li>
                        <li>
                            <?php if ($set->Ijazah != NULL){?>
                            <a title="show detail" href="#" class="detail" data-name="Ijazah" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Ijazah</a>
                            <?php }else{ echo "<a><small><i>Ijazah is NULL</i></small></a>"; }?>
                        </li>
                        <li>
                            <?php if ($set->Transkrip != NULL){?>
                            <a title="show detail" href="#" class="detail" data-name="Transkrip" data-tk="<?php echo ucwords(strtolower($set->Nama));?>">Transkrip Niali</a>
                            <?php }else{ echo "<a><small><i>Transkrip is NULL</i></small></a>"; }?>
                        </li>
                    </ul>
                </div>
                <a title="View Detail" data-rel="tooltip" href="#" class="detailInfo btn btn-minier btn-round btn-primary">
                    <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-proses').dataTable();
        
        $("#dataTables-proses").on("click", ".detail", function() {
                var id = $(this).closest('tr').data('id');
                var name = $(this).data('name');
                var tk = $(this).data('tk');
                
                document.getElementById('titleModal').innerHTML = "Berkas "+name+" dari saudara, <strong class='green'>"+tk+" </strong>";
                $.ajax({
                    url:"<?php echo site_url('monitor/viewDocs');?>",
                    type:"POST",
                    data:"kode="+id+"&nama="+name,
                    datatype:"json",
                    cache:false,
                    success:function(msg){
                        $("#detail").html(msg);
                    }				
                });
            $("#viewModal").modal("show");
        });
        
        $("#dataTables-proses").on("click", ".detailInfo", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('uploadBerkas/detailtk');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#detailInfo").html(msg);
                }				
            });
            $("#viewModalInfo").modal("show");
        });
        
        $("#dataTables-proses").on("click", ".detailInterview", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('wawancaraTujuan/cekRecordInterview');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#detailInterview").html(msg);
                }				
            });
            $("#viewModalInterview").modal("show");
        });
    });
</script>