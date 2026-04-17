<form class="form-inline" align="center" method="post" action="<?php echo base_url().'form_interview/cetakpdf' ?>" target="_blank">
                <p>&nbsp;</p>
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">Daftar Calon Tenaga Kerja</h4>

                        <div class="widget-toolbar">
                            
                        </div>
                        <div class="widget-toolbar">
                            <input class="form-control" type="text" id="search" placeholder="Search">
                        </div>
                    </div>
                    
                    <div class="widget-body">
                        <div class="widget-main">
                            <!-- <table class="table table-bordered">
                                
                            </table> -->
                            <div class="table-responsive" style="overflow:auto;width:100%;height:500px;padding:10px;border:1px  #000000">
                            <table  class="table table-bordered" id="dataTables"  id='myScrollTable'>
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>CV</th>
                                        <th>Pemborong</th>
                                        <!-- <th>Opsi</th> -->
                                    </tr>
                                </thead>
                                <tbody id="ajaxFormDetail">
                                    <?php
                                    foreach ($getListTK as $set):
                                        ?>
                                        <?php
                                           echo '<tr data-id="'.$set->HeaderID.'" class="rowdetail info" >';
                                        ?>
                                            <td class="text-center">
                                                <div class="checkbox">
                                                <label class="pos-rel">
                                                    <input name="checkVerifi[]" type="checkbox" class="ace" value="<?php echo $set->HeaderID;?>">
                                                    <span class="lbl"></span>
                                                </label>
                                                </div>
                                            </td>
                                            <td style="width: 50px " class="text-right"><?php echo $set->HeaderID;?></td>
                                            <td><?php echo $set->Nama;?></td>
                                            <td><?php echo $set->CVNama;?></td>
                                            <td><?php echo $set->Pemborong;?></td>
                                            <!-- <td class="text-center">
                                                <a title="View Detail" data-rel="tooltip" href="#" class="detail btn btn-minier btn-round btn-primary">
                                                    <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                                                </a>
                                                <a title="print Kartu Interview" class="download btn btn-minier btn-round btn-primary" data-rel="tooltip" href="<?php echo site_url('printControl/viewPF_INTERVIEW/'.$set->HeaderID);?>" target="_blank">Download</a>
                                            </td> -->
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                    <div align="center">
                    <button type="submit" id="print" class="btn btn-primary" value="Print" >Print <i class="fa fa-print fa-1x"></i></button>
                    </div>
                    
                </div>
                </form>
            </div>
        </div>
    </div>
</div>









<style type="text/css">
    #myScrollTable{
    clear: both;
    border: 1px solid #FF6600;
    height: 420px;
    overflow:auto;
    float:left;
    width:900px;
    }
</style>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/daterangepicker.js"></script>
<script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datetimepicker.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $("#search").keyup(function(){
         _this = this;
        $.each($("#dataTables tbody tr"), function() {
            if($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
               $(this).hide();
            else
               $(this).show();                
        });
    });
    document.getElementById('print').disabled = true;
});

    function tes(val){
        
        var t = document.getElementsByClassName('incheck');

        var a = 0;
        for (var i = 0 ; i < t.length; i++){
            if(t[i].checked){
                a += 1;
            }
            
        }

        if(a > 4 || a < 1){
            document.getElementById('print').disabled = true;
        }else{
            document.getElementById('print').disabled = false;
        }
    }
