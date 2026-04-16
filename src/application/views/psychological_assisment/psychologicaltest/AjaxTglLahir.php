<?php foreach($getData as $set){?>
<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama </label>
        <div class="col-sm-8">
            <input type="text" class="col-xs-12 col-sm-10" name="txtnama" id="HeaderID"  value="<?php echo $set->Nama?>" disabled="disabled">
            <input type="hidden" class="col-xs-12 col-sm-10" name="txtHeaderID" id="HeaderID"  value="<?php echo $set->HeaderID?>">
             &nbsp;&nbsp;&nbsp;
                <a href="#myModal"  data-toggle="modal" id="btnFind" class="btn btn-success btn-sm">Pilih</a>
        </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Tanggal Lahir </label>
        <div class="col-sm-8">
            <input type="text" class="col-xs-12 col-sm-10" name="txttgllahir"  value="<?php echo $set->Tgl_Lahir?>" disabled="disabled">
        </div>
</div> 
<?php }?>

<div class="modal fade" id="myModal" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">           
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Nama Peserta Psychological Test</h4>
            </div>
            <div class="modal-body">
                <div id="lihat_detail" class="well">
                    <div class="form-group">
                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Nama </label>
                        <div class="col-sm-8">
                            <input type="text" class="col-xs-12 col-sm-10" name="txtnama" id="FindByName">
                            &nbsp;&nbsp;&nbsp;
                            <button type="button" id="btnCari" class="btn btn-success btn-sm" style="background-color: #E25FA6 !important; border-color: #E25FA6;"> Refresh</button>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div>
                        <table id="getList" class="table table-hover table-striped table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tanggal Lahir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
        $("#btnCari").click(function(){
            var Nama = $('#FindByName').val();
            if(Nama == ''){

            }else{
                
                $.ajax({
                    type: "POST",
                    url : "<?php echo site_url('PsychologicalAssisment/getNama')?>",
                    data: {
                        'Nama' : Nama
                    },
                    success: function(msg){
                        $('#getList').html(msg);
                    }
                });
                document.getElementById('btnCari').disabled = false;
            }
            
        });
    </script>
</div>