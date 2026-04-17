<table class="table table-bordered" id="dataTables1">
    <thead>
    <tr>
        <th class="text-center" style="background-color: #d9edf7;">No.</th>
        <th class="text-center" style="background-color: #d9edf7;">Nofix</th>
        <th class="text-center" style="background-color: #d9edf7;">NIK</th>
        <th class="text-center" style="background-color: #d9edf7;">Nama Lengkap</th>
        <th class="text-center" style="background-color: #d9edf7;">Dept</th>
        <th class="text-center" style="background-color: #d9edf7;">Sub Pemborong</th>
        <th class="text-center" style="background-color: #d9edf7;">Potongan Sembako</th>
        <th class="text-center" style="background-color: #d9edf7;">Potongan Cicilan</th>
        <th class="text-center" style="background-color: #d9edf7;">Total</th>
        <th class="text-center" style="background-color: #d9edf7;">Dipotong saat kalkulasi</th>
        <th class="text-center" style="background-color: #d9edf7;">Sisa Bon</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $no = 1;
    foreach($_getData as $get){?>
        <tr>
            <td class="text-center"><?php echo $no++;?></td>
            <td class="text-center"><?php echo $get->Nofix?></td>
            <td class="text-center"><?php echo $get->Nik?></td>
            <td><?php echo $get->Nama?></td>
            <td class="text-center"><?php echo $get->Bagian?></td>
            <td><?php echo $get->NamaSub?></td>
            <td class="text-center">
                <a href="<?php echo base_url()?>PotonganBon/detail_potongan_sembako/<?php echo $get->Nofix?>/<?php echo $get->PeriodeGajian?>" class="btn btn-minier btn-round btn-success"> Rp.<?php echo number_format($get->Pot_Sembako,0,",",".")?>
                </a>
            </td>
            <td class="text-center">
                <a href="<?php echo base_url()?>PotonganBon/detail_potongan_cicilan/<?php echo $get->Nofix?>/<?php echo $get->PeriodeGajian?>" class="btn btn-minier btn-round btn-success"> Rp.<?php echo number_format($get->Cicilan,0,",",".")?>
                </a>
            </td>
            <td class="text-center">
                Rp.<?php echo number_format($get->Pot_Sembako + $get->Cicilan ,0,",",".") ?>
            </td>
            <td></td>
            <td></td>

        </tr>
    <?php }?>
    <div class="form-group">
        <label>Tes</label>
    </div>
    </tbody>

</table>
<br>
<!--<div class="form-group">-->
<!--    <label class="col-sm-0 control-label"></label>-->
<!--    <div class="col-sm-2">-->
<!--        --><?php //foreach($_getDataSub as $get){
//            if($get->IDSubPemborong == NULL){
//                echo "";
//            }else{ ?>
<!--                <a href="--><?php //echo base_url();?><!--PotonganBon/EksportExcelBySub/--><?php //echo $get->IDPemborong?><!--/--><?php //echo $get->IDSubPemborong?><!--/--><?php //echo $get->PeriodeGajian?><!--" class="btn btn-sm btn-round btn-success">-->
<!--                    <i class="fa fa-excel"></i>-->
<!--                    Export To Excell-->
<!--                </a>-->
<!--            --><?php //}
//        }?>
<!--    </div>-->
<!--</div>-->
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables1').dataTable({
        });
    });
</script>