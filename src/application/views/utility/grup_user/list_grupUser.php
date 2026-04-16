<div class="page-header">
    <h1>
        MANAGEMENT USER
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Input Grup User
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
                        <h4 class="widget-title">List Grup User</h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="widget-body">
                        <div class="widget-main">
                            <?php
                            if($this->input->get('msg') == 'success_edit'){
                                echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                        <i class='ace-icon fa fa-times'></i></button>Edit data berhasil..</p>";
                            }elseif ($this->input->get('msg') == 'failed_edit') {
                                echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
                                        <i class='ace-icon fa fa-times'></i></button>Edit data tidak berhasil..</p>";
                            }elseif ($this->input->get('msg') == 'success_delete') {
                                echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                        <i class='ace-icon fa fa-times'></i></button>Data behasil dihapus..</p>";
                            }elseif ($this->input->get('msg') == 'failed_delete') {
                                echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
                                        <i class='ace-icon fa fa-times'></i></button>Data tidak behasil dihapus..</p>";
                            }
                            ?>
                            <div class="table-responsive">
                                <table id="dataTables-grupUser" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>GrupID</th>
                                        <th>Nama Grup</th>
                                        <th>Status</th>
                                        <th>
                                            <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Created Date
                                        </th>
                                        <th>
                                            <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Updated Date
                                        </th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?php
                                    foreach ($getGrupUser as $set):
                                        ?>
                                        <tr>
                                            <td><?php echo $set->GroupName;?></td>
                                            <td><?php echo $set->GroupDescription;?></td>
                                            <td><?php if($set->NotActive === 0){
                                                    echo "<span class='label label-sm label-primary'>Active</span>";
                                                }else{
                                                    echo "<span class='label label-sm label-warning'>Not Active</span>";
                                                } ?>
                                            </td>
                                            <td><?php echo $set->CreatedDate;?></td>
                                            <td><?php if($set->UpdatedDate===NULL){echo "Belum Terupdate"; }else{echo
                                                $set->UpdatedDate; }?></td>
                                            <td>
                                                <a class="green tooltip-success" title="Edit GrupUser!" data-rel="tooltip" href="<?php echo site_url
                                                ('grup_user/editGrupUser')."?id=".$set->GroupID; ?>">
                                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                </a>
                                                <a href="#" class="delete red bootbox-delete tooltip-error" data-id="<?php echo $set->GroupID;?>" data-name="<?php echo $set->GroupName;?>"
                                                   title="Delete Grup User!" data-rel="tooltip">
                                                    <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            

                        </div>
                        <div class="widget-toolbox padding-8 clearfix">
                            <a href="<?php echo base_url("grup_user/index");?>" class="btn btn-xs btn-primary btn-bold pull-left">
                                <i class="ace-icon fa fa-floppy-o bigger-120"></i>
                                Tambah Grup User
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-grupUser').dataTable();
    
        $('[data-rel=tooltip]').tooltip();
    });
</script>
<script src="<?php echo base_url();?>assets/js/bootbox.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $("#dataTables-grupUser").on("click", ".delete", function() {
            var id = $(this).data('id');
            bootbox.confirm("Apakah anda yakin untuk menghapus User Login dengan UserID =  "+id+" ?", function(result) {
                if(result) {
                    window.location='deleteGrupUser?id='+id;
                }
            });
        });
    });
</script>
