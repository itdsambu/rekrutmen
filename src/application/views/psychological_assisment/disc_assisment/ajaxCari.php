<table id="dataTables" class="table table-hover table-striped table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Position</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($getData as $get){?>
        <tr>
            <td class="text-center"><?php echo $get->HeaderID?></td>
            <td onclick="pilih(this.id)" id="<?php echo $get->HeaderID ?>" data-dismiss="modal"><?php echo $get->Nama?></td>
            <td class="text-center"><?php echo $get->DeptTujuan?></td>
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
                url : "<?php echo site_url('PsychologicalAssisment/getNamaDisc')?>"+"/"+nama,
                success: function(msg){
                    $('#ajaxFormHeader').html(msg);
                }
            });
        }
    }; 
</script>
