<div class="widget-box widget-color-blue2 ui-sortable-handle">
    <div class="widget-header">
        <h4 class="widget-title"><strong><?php echo $title; ?>!!</strong></h4>

            <div class="widget-toolbar">
                    <a href="#" data-action="collapse">
                            <i class="1 ace-icon fa fa-chevron-up bigger-125"></i>
                    </a>
            </div>
    </div>

    <div class="widget-body">
        <?php echo form_open('registrasi/simpanReg');?>
        <?php echo form_fieldset();?>
        <?php echo form_hidden($arrhidden);?>
            <div class="widget-main">
                <div class="alert alert-block alert-danger">
                    <button type="button" class="close" data-dismiss="alert">
                        <i class="ace-icon fa fa-times"></i>
                    </button>
                    <h5><i class="fa fa-warning fa-lg">&nbsp;</i>Data atas nama <strong><?php echo $nama;?></strong> yang anda masukkan <strong>sudah pernah</strong> di registrasi sebelumnya.</h5>
                </div>
                
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Bagian</th>
                            <th>Register Oleh</th>
                            <th>Register Tgl</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            $no = 1;
                            foreach($datapelamar as $row):
                        ?>
                        <tr>
                            <td><?php echo $no;?></td>
                            <td><?php echo $row->Nama;?></td>
                            <td><?php echo $row->Alamat;?></td>
                            <td><?php echo $row->DeptTujuan;?></td>
                            <?php 
                                if ($row->RegisteredBy == NULL)
                                {
                                    echo "<td>".strtoupper($row->CreatedBy)."</td>";
                                    echo "<td>".datetime_ind($row->CreatedDate)."</td>";
                                }
                                else
                                {
                                    echo "<td>".strtoupper($row->RegisteredBy)."</td>";
                                    echo "<td>".datetime_ind($row->RegisteredDate)."</td>";
                                }
                            ?>
                        </tr>
                        <?php
                            $no++;
                            endforeach;
                        ?>

                    </tbody>
                </table>
            </div>

            <div class="widget-toolbox padding-6 clearfix">
                Apakah Anda Ingin Menyimpan Data Entrian Anda?
                <button id="btnSimpan" type="submit" class="btn btn-sm btn-success pull-right" ><i class="glyphicon glyphicon-ok">&nbsp;</i>YA</button>
                <a id="btnBatal" href="<?php echo site_url('registrasi/confrimCancel/'.$hdridtemp);?>" class="btn btn-sm btn-danger pull-right" ><i class="glyphicon glyphicon-remove">&nbsp;</i>TIDAK</a>
            </div>
        <?php echo form_fieldset_close();?>
        <?php echo form_close();?>
    </div>
</div>