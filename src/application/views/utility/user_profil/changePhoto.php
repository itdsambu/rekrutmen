<div class="row">
    <div class="col-xs-12">
        <?php $att = array('class' => 'form-horizontal', 'role' => 'form');
        echo form_open_multipart('user_profil/uploadPhoto', $att); ?>
        <div class="form-group">
            <div class="center">
                <input type="hidden" name="txtLoginID" value="<?php echo $loginID; ?>" />
                <input name="fileFoto1" type="file" id="id-input-file-2" accept=".jpg,.jpeg,.png" />
                <input name="fileFoto2" type="file" id="id-input-file-3" accept=".jpg,.jpeg,.png" />
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

<script type="text/javascript">
    jQuery(function($) {
        $('#id-input-file-2').ace_file_input({
            no_file: 'Attach image from your storage!',
            btn_choose: 'Choose',
            btn_change: 'Change',
            droppable: false,
            onchange: null,
            thumbnail: false
        });

        $('#id-input-file-3').ace_file_input({
            style: 'well',
            btn_choose: 'Or drop files here..!',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: 'small',
            preview_error: function(filename, error_code) {}

        }).on('change', function() {
            //console.log($(this).data('ace_input_files'));
            //console.log($(this).data('ace_input_method'));
        });
    });
</script>