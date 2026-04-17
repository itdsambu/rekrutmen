<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Change Photo's
        </small>
    </h1>
</div><!-- /.page-header -->
<div class="row">
    <div class="col-xs-12"><div class="row">
        <div class="col-xs-12">
		<?php foreach($_getdatafoto as $row){?>
            <div class="panel panel-info">
                <div class="panel-heading"><b> Change Photo - <?= $row->Nama?></b></div>
				<div class="panel-body">
					<?php if($this->session->flashdata('_message')):?>
                        <div class="alert <?= ($_GET['success'] == 'ok'? 'alert-success':'alert-danger')?> alert-dismissible" rolw="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                            <strong><?= ($_GET['success'] == 'ok'? 'Well done':'Oh snap')?>!</strong> <?= $this->session->flashdata('_message')?>
                        </div>
                        <?php endif;?>
					<div class="row">
						<div class="col-xs-12">
							<?php $att = array('class'=>'form-horizontal', 'role'=>'form');
							echo form_open_multipart('monitor/uploadPhoto', $att);?>
								<div class="form-group">
									<div class="center">
										<input type="hidden" name="txtID" value="<?php echo $_refid;?>" />
										<input name="fileFoto1" type="file" id="id-input-file-2" />
										<input name="fileFoto2" type="file" id="id-input-file-3" />
									</div>
								</div>
								<div class="form-group">
									<div class="center">
										<button class="btn btn-info" type="submit">
											<i class="ace-icon fa fa-save "></i>
											Submit
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		<?php } ?>
		</div>
	</div>
</div>
<script type="text/javascript">
    jQuery(function($) {
        $('#id-input-file-2').ace_file_input({
            no_file:'Attach image from your storage!',
            btn_choose:'Choose',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false
        });
        
        $('#id-input-file-3').ace_file_input({
            style:'well',
            btn_choose:'Or drop files here..!',
            btn_change:null,
            no_icon:'ace-icon fa fa-cloud-upload',
            droppable:true,
            thumbnail:'small'
            ,
            preview_error : function(filename, error_code) {
            }

        }).on('change', function(){
                //console.log($(this).data('ace_input_files'));
                //console.log($(this).data('ace_input_method'));
        });
    });
</script>