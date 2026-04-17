<?php echo form_open_multipart('Monitor/do_upload/ijazah', array('id' => 'formUpload','class'=>'form-horizontal')); ?>
    <div class="row center">
        <div class="col-xs-12">
            <div class="col-lg-offset-3 col-sm-6">
                    <h4>Unggah <?php echo $namaberkas;?> Atas Nama <strong><?php echo $namapelamar;?></strong></h4>

                    <h5>Silakan pilih <?php echo $namaberkas;?> dari komputer dengan menekan tombol PILIH (format file PDF)</h5>

                    <input type="hidden" name="txtid" value="<?php echo $id;?>">
                    <input type="hidden" name="txtnamapelamar" value="<?php echo $namapelamar;?>">

                    <input name="txtfile" type="file" id="id-input-file-2" accept="pdf"/>
                    <input class="btn btn-primary" name="submit" type="submit" value="Simpan">
            </div>
        </div>
    </div>
</form>

<script type="text/javascript">
    jQuery(function($) {
        $('#id-input-file-2').ace_file_input({
            no_file:'Attach file from your storage!',
            btn_choose:'Pilih',
            btn_change:'Change',
            droppable:false,
            onchange:null,
            thumbnail:false //| true | large
//            whitelist:'gif|png|jpg|jpeg',
//            blacklist:'exe|php'
            //onchange:''
            //
        });
        //pre-show a file name, for example a previously selected file
        //$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])

        $('#id-input-file-3').ace_file_input({
            style:'well',
            btn_choose:'Click or drop files here..!',
            btn_change:null,
            no_icon:'ace-icon fa fa-cloud-upload',
            droppable:true,
            thumbnail:'small'
//            whitelist:'gif|png|jpg|jpeg',
//            blacklist:'exe|php'
            ////large | fit
            //,icon_remove:null//set null, to hide remove/reset button
            /**,before_change:function(files, dropped) {
                    //Check an example below
                    //or examples/file-upload.html
                    return true;
            }*/
            /**,before_remove : function() {
                    return true;
            }*/
            ,
            preview_error : function(filename, error_code) {
                    //name of the file that failed
                    //error_code values
                    //1 = 'FILE_LOAD_FAILED',
                    //2 = 'IMAGE_LOAD_FAILED',
                    //3 = 'THUMBNAIL_FAILED'
                    //alert(error_code);
            }

        }).on('change', function(){
                //console.log($(this).data('ace_input_files'));
                //console.log($(this).data('ace_input_method'));
        });


        //$('#id-input-file-3')
        //.ace_file_input('show_file_list', [
                //{type: 'image', name: 'name of image', path: 'http://path/to/image/for/preview'},
                //{type: 'file', name: 'hello.txt'}
        //]);

    });
</script>