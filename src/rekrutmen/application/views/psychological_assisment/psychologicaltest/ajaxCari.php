<table id="dataTables" class="table table-hover table-striped table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Tempat,Tanggal Lahir</th>
            <th class="text-center">Jenis Kelamin</th>
            <th class="text-center">Tempat Lahir</th>
            <th class="text-center">Registered By</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($getData as $get){?>
        <tr>
            <td class="text-center"><?php echo $get->CalonID?></td>
            <td onclick="pilih(this.id)" id="<?php echo $get->CalonID ?>" data-dismiss="modal"><?php echo $get->Nama?></td>
            <td><?php echo $get->TempatLahir?>,<?php echo date('d-M-Y',strtotime($get->TanggalLahir))?></td>
            <td class="text-center"><?php echo $get->JenisKelamin?></td>
            <td class="text-center"><?php echo $get->TempatLahir?></td>
            <td class="text-center"><?php echo $get->CreatedBy?><br><?php echo date('d-M-Y',strtotime($get->CreatedDate))?></td>
        </tr>
        <?php }?>
    </tbody>
</table>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables').dataTable();
    });
</script>
<script type="text/javascript">
    function pilih($id){
        var nama = $id;

        // alert(nama);
        if(nama != ''){
            $.ajax({
                type: "POST",
                dataType: "html",
                url : "<?php echo site_url('PsychologicalAssisment/getNama')?>"+"/"+nama,
                success: function(msg){
                    $('#ajaxFormHeader').html(msg);
                }
            });
        }
    };
</script>
