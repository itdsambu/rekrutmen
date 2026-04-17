<div class="page-header">
    <h1>
        MANAGEMENT GROUP
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Group Department
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <?php $att = array('class'=>'form-horizontal', 'role'=>'form');
        echo form_open('grupDept/simpan', $att);?>
            <fieldset>
                
                <div class="row">
                    <div class="col-xs-12">
                        <div class="widget-box">
                            <div class="widget-header">
                                <h4 class="widget-title">Select Department</h4>

                                <div class="widget-toolbar">
                                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> Pilih Group User </label>
                                        <div class="col-sm-8">
                                            <select class="col-xs-12 col-sm-10" name="txtGroupID" id="dropdownGrupUser">
                                                <option value=""> -- Silahkan pilih group user</option>
                                                <?php
                                                    foreach ($_getGrupUser as $row):
                                                ?>
                                                <option value="<?php echo $row->GroupID;?>"><?php echo $row->GroupName;?></option>
                                                <?php
                                                    endforeach;
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-offset-2 col-sm-6">
                                            <div id="tbllist">
                                                <table class="table table-striped table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width: 100px" class="text-center">
                                                                <label class="pos-rel">
                                                                    <input type="checkbox" class="ace">
                                                                    <span class="lbl"></span>
                                                                </label>
                                                            </th>
                                                            <th>Department</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </fieldset>
        </form>

    </div>
</div>
<script type="text/javascript">
    $("#dropdownGrupUser").change(function(){
        var selectValues = $("#dropdownGrupUser").val();
        if (selectValues === 0)
        {
            var msg = "<table class='table table-striped table-hover table-bordered'><thead><tr><th>Pilih</th><th>Department</th></tr></thead></table>";
            $('#tbllist').html(msg);					
        }
        else
        {
            var grupid = {grupid:$("#dropdownGrupUser").val()};
            $.ajax({
                type: "POST",
                url : "<?php echo site_url('grupDept/get_listDept')?>",
                data: grupid,
                success: function(msg){
                    $('#tbllist').html(msg);
                }
            });
        }
    });
</script>