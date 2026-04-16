<script type="text/javascript" src="<?php echo base_url();?>assets/js/checkboxall.js"></script>
<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Approve data Ideal Permintaan
    </span>
</h4>
<?php 
    $att = array('class'=>'form-horizontal', 'role'=>'form');
    echo form_open('Memopermintaan/multiApprovalDept', $att);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">Approve Memo Permintaan By - Pimpinan</h4>
                <div class="widget-toolbar">
                    <a href="" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <?php
                        if($this->input->get('msg') == 'Success'){
                            echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                                    <i class='ace-icon fa fa-times'></i></button>Approve By Pimpinan Success !</p>";
                        }
                    ?>
                    <table id="dataTables" class="table table-bordered table-hover table-responsive">
				   		<thead>
				   			<tr>
				   				<th class="text-center" width="10px">
	                                <label class="pos-rel">
	                                    <input type="checkbox" class="ace" onclick="checkUncheckAll(this);">
	                                    <span class="lbl"></span>
	                                </label>
	                            </th>
				   				<th>IDMemo</th>
				   				<th>Doc</th>
				   				<th>Type</th>
				   				<th>Total</th>
								<th>View</th>
				   			</tr>
				   		</thead>
				   		<tbody>
				   			<?php if(empty($getmemodept)){?>
				   				<tr>
									<td style="text-align: center;"></td>
									<td style="text-align: center;"></td>
									<td style="text-align: center;"></td>
									<td style="text-align: center;"></td>
									<td style="text-align: center;"></td>
									<td style="text-align: center;"></td>
								</tr>
				   			<?php } else { ?>
				   				<?php foreach($getmemodept as $row){?>
				   					<tr class="info" data-id="<?php echo $row->IDMemo;?>">
				   						<td class="text-center">
	                                        <div class="checkbox">
	                                        <label class="pos-rel">
	                                            <input name="IDMemo[]" type="checkbox" class="ace" value="<?php echo $row->IDMemo;?>" >
	                                            <span class="lbl"></span>
	                                        </label>
	                                        </div>
	                                    </td>
			   							<td><?php echo $row->IDMemo;?></td>
			   							<td><?php echo $row->Doc;?></td>
			   							<td><?php if($row->IsKry==1){echo 'Karyawan';}else{echo 'Tenaga Kerja';}?></td>
			   							<td><?php echo $row->Jumlah;?></td>
										<td><a href="#" class="viewMemo btn btn-danger btn-sm">Memo</a></td>
				   					</tr>
				   				<?php } ?>
				   			<?php } ?>
	                    </tbody>
				   	</table>
				</div>
		   	</div>
		   	<div class="widget-toolbox padding-8 clearfix">
                <div class="well text-center">
                    <input type="submit" value="Approve" name="Submit" class="btn btn-success" >
                    <input type="submit" value="Decline" name="Submit" class="btn btn-danger" >
                </div>
            </div>
		</div>
	</div>
</div>

<div class="modal fade" id="viewDetailMemo" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dinamiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Memo Permintaan Ideal TK/Karyawan</h4>
            </div>
            <div class="modal-body">
            	<input type="hidden" name="idviewMemo" id="inputviewMemo">
            	<div id="viewMemo" class="well">
            		
            	</div>
            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
            </div>
        </div>
    </div>
</div>
<script>
	$(document).ready(function(){
		$('#dataTables').on("click", ".viewMemo", function(){
			var id = $(this).closest('tr').data('id');
			$.ajax({
				url 	: "<?php echo site_url('Memopermintaan/detailMemo');?>",
				type	: "POST",
				data 	: "kode="+id,
				datatype: "json",
				cache	: false,
				success	: function(msg){
					$("#viewMemo").html(msg);
				}
			});
			$('#viewDetailMemo').modal("show");
		});
	})
</script>
<script>
$(document).ready( function () {
    $('#dataTables').DataTable();
} );
</script>