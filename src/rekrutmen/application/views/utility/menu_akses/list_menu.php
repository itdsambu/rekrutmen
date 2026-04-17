<table id="tblMenu" class="table table-striped table-hover table-bordered">
    <thead>
        <tr>
            <th style="width: 100px" class="text-center">
                <label class="pos-rel">
                    <input type="checkbox" class="ace">
                    <span class="lbl"></span>
                </label>
            </th>
            <th>Menu</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($_getMenu1 as $menu1):?>
        <tr>
            <td class="text-center">
                <label class="pos-rel">
                    <input name="checkList[]" type="checkbox" class="ace" value="<?php echo $menu1->MenuID;?>" 
                           <?php if($menu1->Atc == 1){echo 'checked';}?> >
                    <span class="lbl"></span>
                </label>
            </td>
            <td><i class="ace-icon fa fa-check-square purple"></i> <strong><?php echo $menu1->MenuLabel;?></strong>*</td>
        </tr>
            <?php foreach($_getMenu2 as $row2): ?>
                <?php if($row2->MenuHeader=== $menu1->MenuID): ?>
                    <tr>
                        <td class="text-center">
                            <label class="pos-rel">
                                <input name="checkList[]" type="checkbox" class="ace" value="<?php echo $row2->MenuID;?>"
                                       <?php if($row2->Atc == 1){echo 'checked';}?> >
                                <span class="lbl"></span>
                            </label>
                        </td>
                        <td>&nbsp;&nbsp;&nbsp; <i class="ace-icon fa fa-plus-square blue"></i> <?php echo $row2->MenuLabel;?></td>
                    </tr>
                    <?php foreach($_getMenu3 as $row3): ?>
                        <?php if($row3->MenuHeader=== $row2->MenuID): ?>
                            <tr>
                                <td class="text-center">
                                    <label class="pos-rel">
                                        <input name="checkList[]" type="checkbox" class="ace" value="<?php echo $row3->MenuID;?>"
                                               <?php if($row3->Atc == 1){echo 'checked';}?> >
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="ace-icon fa fa-minus-square red"></i> <?php echo $row3->MenuLabel;?></td>
                            </tr>
                        <?php endif;?>
                    <?php endforeach;?>
                <?php endif;?>
            <?php endforeach;?>
        <?php endforeach;?>
    </tbody>
</table>

<!--<div class="dd" id="nestable">
    <ol class="dd-list">
        <?php foreach($_getMenu1 as $row1):?>
        <li class="dd-item dd-collapsed" data-id="1">
            <div class="dd2-content">
                <label class="pos-rel">
                    <input name="checkList[]" type="checkbox" class="ace" value="<?php echo $row1->MenuID;?>" >
                    <span class="lbl"><?php echo $row1->MenuLabel;?></span>
                </label>
            </div>
            <ol class="dd-list">
                <?php foreach($_getMenu2 as $row2): ?>
                <?php if($row2->MenuHeader === $row1->MenuID): ?>
                <li class="dd-item" data-id="2">
                    <div class="dd2-content">
                        <label class="pos-rel">
                            <input name="checkList[]" type="checkbox" class="ace" value="<?php echo $row2->MenuID;?>" >
                            <span class="lbl"><?php echo $row2->MenuLabel;?></span>
                        </label>
                    </div>
                    <ol class="dd-list">
                        <?php foreach($_getMenu3 as $row3): ?>
                        <?php if($row3->MenuHeader === $row2->MenuID): ?>
                        <li class="dd-item" data-id="3">
                            <div class="dd2-content">
                                <label class="pos-rel">
                                    <input name="checkList[]" type="checkbox" class="ace" value="<?php echo $row3->MenuID;?>" >
                                    <span class="lbl"><?php echo $row3->MenuLabel;?></span>
                                </label>
                            </div>
                        </li>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </ol>
                </li>
                <?php endif; ?>
                <?php endforeach; ?>
            </ol>
        </li>
        <?php endforeach; ?>
    </ol>
</div>-->

<button type="submit" class="btn btn-sm btn-primary btn-block" id='btnsimpan'>
    <span class="ace-icon fa fa-save bigger-130">&nbsp;</span>SIMPAN
</button>

<script src="<?php echo base_url();?>assets/js/jquery.nestable.js"></script>
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
<script type="text/javascript">
    jQuery(function($){
        $('.dd').nestable();

//        $('.dd-handle a').on('mousedown', function(e){
//            e.stopPropagation();
//        });

        $('[data-rel="tooltip"]').tooltip();
    });
</script>