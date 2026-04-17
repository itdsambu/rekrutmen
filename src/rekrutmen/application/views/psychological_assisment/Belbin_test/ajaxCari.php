<table id="dataTables" class="table table-hover table-striped table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th class="text-center">ID</th>
            <th class="text-center">Nama</th>
            <th class="text-center">Tanggal Lahir</th>
            <th class="text-center">Tempat Lahir</th>
            <th class="text-center">Jenis Kelamin</th>
            <th class="text-center">Jabatan</th>
            <th class="text-center">Pendidikan Terakhir</th>
            <th class="text-center">Perusahaan</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($getData as $get){?>
        <tr onclick="pilih(this.id)" id="<?php echo $get->HeaderID ?>" data-dismiss="modal" style="cursor: pointer;">
            <td class="text-center"><?php echo $get->HeaderID?></td>
            <td><?php echo $get->Nama?></td>
            <td><?php echo date('d-M-Y',strtotime($get->Tgl_Lahir))?></td>
            <td><?php echo $get->Tempat_Lahir?></td>
            <td class="text-center"><?php echo $get->Jenis_Kelamin?></td>
            <td class="text-center"> - </td>
            <td class="text-center"><?php echo $get->Pendidikan?></td>
            <td class="text-center"><?php echo $get->Pemborong?></td>
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
        var id = $id;

        //alert(id);  
        if(id != ''){
            $.ajax({
                type: "POST",
                dataType: "html",
                url : "<?php echo site_url('PsychologicalAssisment/getNamaBelbin')?>"+"/"+id,
                success: function(msg){
                    $('#ajaxFormHeader').html(msg);
                }
            });
        }
    };
</script>
