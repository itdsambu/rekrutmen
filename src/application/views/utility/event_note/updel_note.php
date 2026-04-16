<div style="width:500px; height:130px; overflow:auto; color:#000000; margin-bottom:20px;" align="center">
    <h4>Edit/hapus catatan untuk tanggal <?php echo "$day $month $year"?></h4>
    <?php echo form_open("mynotes/edit_note/$year/$mon/$day", ' class="submit"');?>
    <table>
        <tr>
            <td>Note</td>
            <td>:</td>
            <td><input type="text" name="note" maxlength="30" size="40" value="<?php echo $note?>" /></td>
        </tr>
        <tr>
            <td colspan="2"></td>
            <td>
                <input type="submit" name="OK" value="Edit">&nbsp;&nbsp;
                <a href="<?php echo site_url("mynotes/delete_note/$year/$mon/$day")?>" title="hapus note">
                    <input type="button" name="hapus" value="Delete" class="del">
                </a>&nbsp;&nbsp;
                <input type="button" name="Batal" value="Batal" class="cancel">
            </td>
        </tr>
    </table>
    </form>
    <script>	
    $('.cancel').click(function(){
        var data = false; $.fn.colorbox.close(data);
    });

    $('.del').click(function(){
        if(confirm('Yakin akan hapus catatan?')){ return true; }else{ return false;}
    });

    $('.submit').submit(function(){
        if(confirm('Edit catatan?')){ return true; }else{ return false; }
    });
    </script>
</div>