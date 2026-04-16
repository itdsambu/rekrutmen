<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">HASIL INPUT HARGA DI ITEM BARANG OLEH PEMBORONG</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <form class="form-horizontal" role="form" method="POST">
        
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="form-group" >
                            <label class="col-lg-2 control-label">Tanggal :</label>
                            <div class="col-sm-4">
                                <input class="form-control" type="date" name="tanggal" id="tanggal">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label"></label>
                            <div class="col-sm-3">
                                <a class="btn btn-sm btn-primary" onclick="ajax()">
                                    <i class="fa fa-search"></i>
                                    Search
                                </a>
                           </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table table-responsive" id="tbllist">
                <table id="dataTables2" class="table table-striped table-bordered table-hover">
                   <thead>
                        <tr style="background: #4C87B9;color: #ffffff;">
                            <th class="text-center">No</th>
                            <th class="text-center">Pemborong</th>
                            <th class="text-center">Sub Pemborong</th>  
                            <th class="text-center">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $i = 1;
                        foreach($_getData as $key=>$get){?>
                                <td class="text-center"><?php echo $key+1;?></td>
                                <td><?php echo $get->Pemborong?></td>
                                <td><?php echo $get->NamaSub?></td>
                                <td class="text-center"><?php echo $get->Jumlah?></td>
                            </tr>
                        <?php $i++; }?>
                    </tbody>   
                </table>
                <br>
                <div class="form-group">
                    <label class="col-sm-2 control-label"></label>
                    <div class="col-sm-3">
                        <a href="<?php echo base_url();?>PotonganBon/EksportExcel" class="btn btn-sm btn-round btn-primary">
                            <i class="fa fa-excel"></i>
                            Export To Excell
                        </a>
                   </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables2').dataTable();
    });
    function ajax()
    {
        console.log("test2");
            var tanggal = $('#tanggal').val();
           //alert(tanggal);
           $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajaxMonitorHarga')?>"+"/"+tanggal,
            success: function(msg){
                if(msg == ''){
                  alert('Tidak ada data');
                } 
                else{
                    $("#tbllist").html(msg);                                                     
                }
            }
          }); 
    }
</script>
