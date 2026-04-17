<div class="modal-body">
    <form class="form-horizontal" role="form" method="POST" action="#">
        <div class="row">
            <div class="col-lg-12">
               <div class="table-responsive" id="listid">
                   <table class="table table-bordered" id="dataTables">
                    <thead>
                      <tr>
                        <th class="text-center" style="background-color: #d9edf7;">No.</th>
                        <th class="text-center" style="background-color: #d9edf7;">Periode</th>
                        <th class="text-center" style="background-color: #d9edf7;">Cicilan</th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no= 1;
                        foreach($_getDataList as $get){
                        ?>
                        <tr>
                            <td class="text-center"><?php echo $no++;?></td>
                            <td class="text-center"><?php echo date('d-M-Y',strtotime($get->Periode));?></td>
                            <td class="text-center">Rp.<?php echo number_format($get->DiPotong,0,",",".");?></td>
                        </tr>
                    <?php }?>
                    </tbody>
                  </table>
              </div>
            </div>
        </div>
    </form>         
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables2').dataTable({
        });
    });
</script>
