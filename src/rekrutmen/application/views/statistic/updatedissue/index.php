<?php
    $this->load->view('template/sweetAlert');
    $this->load->view('template/formPicker');
    $this->load->view('template/formValidation');
?>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/toExcel/jquery.battatech.excelexport.js"></script>

<div class="page-header">
    <h1>
        Statistic 
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Update Issue Permintaan
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading"><b> Updated Issue Permintaan</b></div>
            	<div class="panel-body">
                    <?php
                    if ($this->input->get('msg') == 'failed') {
                        echo "<div class='alert alert-danger alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>Data Gagal Ditambah...!!!</div>";
                    }elseif ($this->input->get('msg') == 'success') {
                        echo "<div class='alert alert-info alert-dismissible' role='alert'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>Data Berhasil Ditambah...!!!</div>";
                    }else{
                        echo "";
                    }
                    ?>
                	<div class="form-group">
                        <form action="<?php echo site_url('statistic/UpdatedIssue');?>" method="POST" class="form-inline form-horizontal">
                            <div class="col-xs-12 col-sm-11">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label no-padding-right">Filter Data</label>
                                    <div class="col-sm-6">
                                        <select name="selDataFilter" id="inputDataFilter" class="form-control input-sm" >
                                            <option value="All" <?php if($_selected == 'All'){ echo 'selected';}?> >Semua</option>
                                            <option value="ALL PEMBORONG" <?php if($_selected == 'ALL PEMBORONG'){ echo 'selected';}?> >Harian/Borongan</option>
                                            <option value="PSG" <?php if($_selected == 'PSG'){ echo 'selected';}?> >Karyawan</option>
                                        </select>
                                    </div>
                                    <script>
                                        $('#inputDataFilter').change( function (){
                                            var val = this.value;
                                            window.location = '<?php echo site_url();?>statistic/UpdatedIssue?jenis='+val;
                                        });
                                    </script>
                                </div>
                            </div>
                        </form>
                        <form method="POST" class="form-inline form-horizontal" id="issue">
                            <div class="col-xs-12 col-sm-1">
                                <div class="form-group">
                                    <label class="col-sm-6 control-label no-padding-right"></label>
                                    <div class="col-sm-6">
                                        <button class="btn btn-xs btn-success" id="target" type="button"><i class="fa fa-file-excel-o"></i> Excel</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="clearfix"></div>
                    <div class="panel-body" id="ajaxFormHeader">
                    	<div class="table table-responsive">
	                        <table id="dataTables-Issue" class="table table table-hover table-striped table-colored">
	                            <thead style="font-size: 12px;"  class="bg-primary sticky-header">
	                                <tr>
	                                    <th style="vertical-align: middle; text-align: center;" rowspan="2">ID</th>
	                                    <th style="vertical-align: middle; text-align: center;" rowspan="2">Departemen</th>
                                        <th style="vertical-align: middle; text-align: center;" rowspan="2">Division</th>
	                                    <th style="vertical-align: middle; text-align: center;" rowspan="2">Position (Posisi)</th>
	                                    <th style="vertical-align: middle; text-align: center;" class="text-center" colspan="3">Number Personnel<br>(Jumlah Orang)</th>
                                        <th style="vertical-align: middle; text-align: center;" rowspan="2" class="text-center">Explanation For Unfulfilled<br>(Penjelasan Kenapa Belum Terpenuhi)</th>
                                        <th style="vertical-align: middle; text-align: center;" rowspan="2" class="text-center">Solution (IF Aplicable)<br>(Solisi)</th>
	                                    <th style="vertical-align: middle; text-align: center;" rowspan="2" class="text-center">Date Of Fulfillment<br>(Rencana Waktu Pemenuhan)</th>
                                        <th style="vertical-align: middle; text-align: center;" rowspan="2" class="text-center">Setting</th>
	                                </tr>
	                                <tr>
	                                    <th style="vertical-align: middle; text-align: center;">Total Needed<br>(Jumlah Kebutuhan)</th>
	                                    <th style="vertical-align: middle; text-align: center;">Full Filled<br>(Sudah Terpenuhi)</th>
	                                    <th style="vertical-align: middle; text-align: center;">Unfilled<br>(Belum Terpenuhi)</th>
	                                </tr>
	                            </thead>
                                <tbody>
                                    <?php
                                    $tot_sisa = 0;
                                    $tot_penuhi = 0;
                                    $tot_minta = 0;
                                    $tot_identifikasi = 0;
                                    foreach($_selectData as $row){?>
                                    <?php
                                        echo '<tr 
                                        data-id="'.$row->DetailID.'" class="rowdetail" >';
                                        $target           = $row->TKTarget;
                                        $sedia            = $row->TKSedia;
                                        $minta            = $row->TKPermintaan;
                                        $jumlahID         = $row->Identifikasi;
                                        
                                        $sisa             = $target-$sedia;
                                        $penuhi           = $sisa-$minta;
                                        $diidentifikasi   = $jumlahID-($penuhi);
                                        
                                        $tot_sisa         += $sisa;
                                        $tot_penuhi       += $penuhi;
                                        $tot_minta        += $minta;
                                        $tot_identifikasi += $diidentifikasi;
                                    ?>
                                        <td><?php echo $row->DetailID;?></td>
                                        <td><?php echo $row->DeptAbbr;?></td>
                                        <td><?php echo $row->NamaDivisi;?></td>
                                        <td><?php echo $row->Pekerjaan;?></td>
                                        <td style="text-align: center; vertical-align: middle;"><?php echo $sisa;?></td>
                                        <td style="text-align: center; vertical-align: middle;"><?php echo $penuhi;?></td>
                                        <td style="text-align: center; vertical-align: middle;"><?php echo $minta;;?></td>
                                        <td>
                                            <?php if( $row->PenjelasanBelumPenuh == null){
                                                echo "<span class='label label-sm label-danger'> Belum disetting </span>";
                                            }else{
                                                echo $row->PenjelasanBelumPenuh;
                                            }
                                            ?>
                                        </td>
                                        <td><?php if( $row->Solusi == null){
                                                echo "<span class='label label-sm label-danger'> Belum disetting </span>";
                                            }else{
                                                echo $row->Solusi;
                                            }
                                            ?>
                                        </td>
                                        <td><?php if( $row->StatusPemenuhan == null){
                                                echo "<span class='label label-sm label-danger'> Belum disetting </span>";
                                            }else{
                                                echo $row->StatusPemenuhan;
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <a title="View Issue" data-rel="tooltip" href="#" class="edit btn btn-minier btn-round btn-primary" hidden>
                                                <i class="ace-icon fa fa-pencil bigger-100"></i> Edit
                                            </a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4">Total</th>
                                        <th style="text-align: center; vertical-align: middle;"><span class="label label-sm label-primary"><?= $tot_sisa;?></span></th>
                                        <th style="text-align: center; vertical-align: middle;"><span class="label label-sm label-success"><?= $tot_penuhi;?></span></th>
                                        <th style="text-align: center; vertical-align: middle;"><span class="label label-sm label-danger"><?= $tot_minta;?></span></th>
                                        <th colspan="4"></th>
                                    </tr>
                                </tfoot>
	                        </table>
	                    </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
<div class="modal fade" id="viewModalEdit" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Edit Issue Permintaan <strong class="green"><?php echo $this->session->userdata('username');?></strong></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="edit" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-Issue').dataTable({
			"order": [[0,'desc']]
		});
        $("#dataTables-Issue").on("click", ".edit", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url:"<?php echo site_url('statistic/viewEditIssue');?>",
                type:"POST",
                data:"kode="+id,
                datatype:"json",
                cache:false,
                success:function(msg){
                    $("#edit").html(msg);
                }
            });
            $("#viewModalEdit").modal("show");
        });
    });
</script>
<script>
    $('#target').click(function(){
        var val = document.getElementById('inputDataFilter').value;
        window.location = '<?php echo site_url();?>statistic/downloadissue?jenis='+val;
        console.log(val);
    });
</script>