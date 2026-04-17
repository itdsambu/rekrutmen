<table id="dataTables" class="table table-hover table-striped table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Position</th>
            <th class="textarea">Organization</th>
            <th class="text-center">Education</th>
            <th class="text-center">Gender</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($getData as $get){?>
        <tr>
            <td class="text-center"><?php echo $get->CalonID?></td>
            <td onclick="pilih(this.id)" id="<?php echo $get->HeaderID ?>" data-dismiss="modal"><?php echo $get->Nama?></td>
            <td class="text-center"><?php echo $get->DeptAbbr?></td>
            <td class="text-center"> - </td>
            <td class="text-center"><?php echo $get->Pendidikan?></td>
            <td class="text-center"><?php echo $get->JenisKelamin?></td>
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

        if(nama != ''){
            $.ajax({
                type: "POST",
                dataType: "html",
                url : "<?php echo site_url('PsychologicalAssisment/getNamaFiro')?>"+"/"+nama,
                success: function(msg){
                    $('#ajaxFormHeader').html(msg);
                }
            });
        }
    }; 
</script>
