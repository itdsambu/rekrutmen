<table class="table table-bordered" id="dataTables1">
<thead>
  <tr>
    <th class="text-center" style="background-color: #d9edf7;">No.</th>
    <!-- <th class="text-center" style="background-color: #d9edf7;">Fixno</th> -->
    <th class="text-center" style="background-color: #d9edf7;">Nama</th>
    <th class="text-center" style="background-color: #d9edf7;">Nik</th>
    <th class="text-center" style="background-color: #d9edf7;">Dept</th>
    <th class="text-center" style="background-color: #d9edf7;width: 150px;">Tanggal</th>
    <th class="text-center" style="background-color: #d9edf7; width: 300px;">Item Cicilan</th>
    <th class="text-center" style="background-color: #d9edf7;">Quantity</th>
    <th class="text-center" style="background-color: #d9edf7;">Harga Total</th>
    <th class="text-center" style="background-color: #d9edf7;">Dp</th>
    <th class="text-center" style="background-color: #d9edf7;">Harga Yang Harus Dibayar</th>
    <th class="text-center" style="background-color: #d9edf7;">Jumlah Periode Cicilan (x)</th>
    <!-- <th class="text-center" style="background-color: #d9edf7;">Periode Pemotongan</th> -->
    <th class="text-center" style="background-color: #d9edf7;">Nominal Cicilan</th>
    <!-- <th class="text-center" style="background-color: #d9edf7;">Total Periode Yang Sudah Tercicil (x)</th> -->
    <!-- <th class="text-center" style="background-color: #d9edf7;">Total Periode Yang Belum Tercicil (x)</th>
    <th class="text-center" style="background-color: #d9edf7;">Sisa Cicilan Yang Harus Dilunasi</th> -->
    <th class="text-center" style="background-color: #d9edf7;">Action</th>
  </tr>
</thead>
<tbody>
    <?php 
    $no = 1;
    foreach($_getDataTrnCicilanhdr as $get){?>
    <tr>
        <td class="text-center"><?php echo $no++;?></td>
        <!-- <td class="text-center"><?php echo $get->Nofix;?></td> -->
        <td><?php echo $get->Nama;?></td>
        <td class="text-center"><?php echo $get->Nik;?></td>
        <td class="text-center"><?php echo $get->BagianAbbr;?></td>
        <td class="text-center">
            <table class="table table-bordered">
                <?php foreach($_getDataTrnCicilan as $key){
                if($get->Nofix == $key->Nofix){?>
                    <tr>
                        <td><?php echo date('d-M-Y',strtotime($key->Tanggal));?></td>
                    </tr>
                <?php }}?>
            </table>
        </td>
        <td>
            <table class="table table-bordered">
                <?php foreach($_getDataTrnCicilan as $key){
                if($get->Nofix == $key->Nofix){?>
                    <tr>
                        <td><?php echo $key->NamaCicilan;?></td>
                    </tr>
                <?php }}?>
            </table>
        </td>
        <td>
            <table class="table table-bordered">
                <?php foreach($_getDataTrnCicilan as $key){
                if($get->Nofix == $key->Nofix){?>
                    <tr>
                        <td class="text-center"><?php echo $key->Quantity;?></td>
                    </tr>
                <?php }}?>
            </table>
        </td>
        <td>
            <table class="table table-bordered">
            <?php foreach($_getDataTrnCicilan as $key){
                if($get->Nofix == $key->Nofix){?>
                    <tr>
                        <td>Rp.<?php echo number_format($key->Harga,0,",",".");?></td>
                    </tr>
                <?php }}?>
            </table>
        </td>
        <td>
            <table class="table table-bordered">
            <?php foreach($_getDataTrnCicilan as $key){
                if($get->Nofix == $key->Nofix){?>
                    <tr>
                        <td>Rp.<?php echo number_format($key->DP,0,",",".");?></td>
                    </tr>
                <?php }}?></table>
        </td>
        <td>
            <table class="table table-bordered">
            <?php foreach($_getDataTrnCicilan as $key){
                if($get->Nofix == $key->Nofix){?>
                    <tr>
                        <td>Rp.<?php echo number_format($key->Harga - $key->DP,0,",",".");?></td>
                    </tr>
                <?php }}?>
            </table>
        </td>
        <td>
            <table class="table table-bordered">
                <?php foreach($_getDataTrnCicilan as $key){
                    if($get->Nofix == $key->Nofix){?>
                        <tr>
                            <td class="text-center"><?php echo $key->Cicilan;?></td>
                        </tr>
                    <?php }
                }?>
            </table>
        </td>
        <!-- <td>
            <table class="table table-bordered">
                <?php foreach($_getDataTrnCicilan as $key){
                    if($get->Nofix == $key->Nofix){?>
                        
                        <tr>
                            <td class="text-center"><?php if($key->PeriodeDipotong == 1){
                                    echo "1";
                                }elseif($key->PeriodeDipotong == 2){
                                    echo "2";
                                }else{
                                    echo "1 dan 2";
                                }?> 
                            </td>
                        </tr>
                    <?php }
                }?>
            </table>
        </td> -->
        <td>
            <table class="table table-bordered">
                <?php foreach($_getDataTrnCicilan as $key){
                    if($get->Nofix == $key->Nofix){?>
                        <tr>
                            <td>Rp.<?php echo number_format($key->HargaCicilan,0,",",".");?></td>
                        </tr>
                    <?php }
                }?>
            </table>
        </td>
        <!-- <td>
            <table class="table table-bordered">
                <?php foreach($_getDataTrnCicilan as $key){
                    if($get->Nofix == $key->Nofix){?>
                        <tr>
                            <td class="text-center"><a href="#" id="<?php echo $key->DetailIDCicilan?>" onclick="view_detail_cicilan_lunas(this.id)" class="btn btn-minier btn-round btn-success" data-toggle="modal"><?php if($key->JmlCicilanLunas == NULL){echo "0";}else{echo $key->JmlCicilanLunas;};?>
                                <input type="hidden" name="txtDetail" id="detail" value="<?php echo $key->DetailIDCicilan?>"> -->
                                <!-- <input type="hidden" name="txtNofix" id="nofix" value="<?php echo $get->Nofix;?>">
                                <input type="hidden" name="txtPemborong" id="pemborong" value="<?php echo $pbr;?>">
                                <input type="hidden" name="txtSubPemborong" id="subpemborong" value="<?php echo $sub;?>">
                            </a></td>
                        </tr>
                    <?php }
                }?>
            </table>
        </td> -->
        <!-- <td>
            <table class="table table-bordered">
                <?php foreach($_getDataTrnCicilan as $key){
                    if($get->Nofix == $key->Nofix){?>
                        <tr>
                            <td class="text-center"><?php if($key->Durasi == NULL){echo "0";}else{echo $key->Durasi;};?></td>
                        </tr>
                    <?php }
                }?>
            </table>
        </td> -->
        <!-- <td>
            <table class="table table-bordered">
                <?php foreach($_getDataTrnCicilan as $key){
                    if($get->Nofix == $key->Nofix){?>
                        <tr>
                            <td>Rp.<?php echo number_format($key->Harga - $key->dipotong,0,",",".");?></td>
                        </tr>
                    <?php }
                }?>
            </table>
        </td> -->
        <td>
            <p class="text-center">
                <a  href="<?php echo base_url();?>PotonganBon/print_cicilan/<?php echo $get->Nofix?>" class="btn btn-minier btn-round btn-primary"><i class="fa fa-print"></i></a>
            </p>
        </td>
    </tr>
    <?php }?>
</tbody>

</table>
<br>
<!-- <div class="form-group">
    <label class="col-sm-12 control-label"></label>
    <div class="col-sm-12">
        <a href="<?php echo base_url();?>PotonganBon/CicilanBySub/<?php echo $getSub->IDSubPemborong?>" class="btn btn-sm btn-round btn-success">
            <i class="fa fa-print"></i>
            Print
        </a>
   </div>
</div> -->

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables1').dataTable({
        });
    });
</script>

<div class="modal fade" id="myModalViewDetailCicilanLunas" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Detail Cicilan Lunas</h4>
            </div>
            <div id="lihat_detail">
              <div class="modal-body">
                
              </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
    function view_detail_cicilan_lunas(click_id){
        var dtlid = click_id;

        $.ajax({
          type: "GET",
          dataType: "html",
          url: "<?php echo base_url('PotonganBon/getViewCicilanLunas')?>"+"/"+dtlid,
          success: function(msg){
                if(msg == ''){
                  alert('Tidak ada data');
                } 
                else{
                    $("#lihat_detail").html(msg);                                                     
                }
            }
         });

        $('#myModalViewDetailCicilanLunas').modal('show');
    }

    </script>
</div>