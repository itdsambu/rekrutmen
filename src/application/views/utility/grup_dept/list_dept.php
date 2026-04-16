<table id="tblMenu" class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th style="width: 100px" class="text-center">
                <label class="pos-rel">
                    <input type="checkbox" class="ace">
                    <span class="lbl"></span>
                </label>
            </th>
            <th>Department</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($_getDept as $row):?>
        <tr>
            <td class="text-center">
                <label class="pos-rel">
                    <input name="checkList[]" type="checkbox" class="ace" value="<?php echo $row->DeptID;?>"
                           <?php if($row->Act == 1){ echo 'checked';}?> >
                    <span class="lbl"></span>
                </label>
            </td>
            <td><strong><?php echo $row->DeptAbbr;?></strong> - <?php echo $row->NamaDept;?></strong></td>
        </tr>
        <?php endforeach;?>
    </tbody>
</table>

<button type="submit" class="btn btn-sm btn-primary btn-block" id='btnsimpan'>
    <span class="ace-icon fa fa-save bigger-130">&nbsp;</span>SIMPAN
</button>
<script type="text/javascript">
    $(document).ready(function() {
        var active_class = 'active';
        $('#tblMenu > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
            var th_checked = this.checked;//checkbox inside "TH" table header
            $(this).closest('table').find('tbody > tr').each(function(){
                var row = this;
                if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
            });
        });
    });
</script>