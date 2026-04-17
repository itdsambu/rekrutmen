<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Pendaftaran CTKB
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <div class="row">
            <div class="col-xs-12">
                <div class="widget-box">
                    <div class="widget-header">
                        <h4 class="widget-title">List Calon Tenaga Kerja Baru </h4>

                        <div class="widget-toolbar">
                            <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <?php
                    // <?php $att = array('class' => 'form-horizontal', 'role' => 'form');
                    // echo form_open('postingTenaker/doPosting', $att);
                    ?>
                    <form class="form-horizontal" id="form_cari_data" role="form" method="POST" action="<?php echo base_url('Registrasi/TransaksiPBR'); ?>">
                        <div class="widget-body">
                            <div class="widget-main">
                                <div class="table-responsive">
                                    <table id="dataTables-listTK" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th class="text-center">
                                                    <label class="pos-rel">
                                                        <input type="checkbox" class="ace chk_all">
                                                        <span class="lbl"></span>
                                                    </label>
                                                </th>
                                                <th class="info">ID</th>
                                                <th class="info">Nama</th>
                                                <th class="info">Pemborong</th>
                                                <th class="info">Sub Pemborong</th>
                                                <th class="info">Tangga Lahir</th>
                                                <th class="info">Jenis Kelamin</th>
                                                <th class="info">
                                                    <i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Registered By
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php
                                            foreach ($_getTenaker as $set) :
                                            ?>
                                                <!-- <?php
                                                        $xxx = '';
                                                        if ($set->IdentifikasiValid == 'Salah') {
                                                            $xxx = 'style="background-color: #ff9999;"';
                                                        }
                                                        echo '<tr ' . $xxx . ' data-id="' . $set->HeaderID . '" class="rowdetail" >';
                                                        ?> -->

                                                <td class="text-center">
                                                    <div class="checkbox">
                                                        <label class="pos-rel">
                                                            <input name="chkPosting[]" id="chkPosting" class="chkPosting" type="checkbox" value="<?php echo $set->HeaderID; ?>">
                                                            <span class="lbl"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td style="width: 50px " class="text-right header"><?php echo $set->HeaderID; ?></td>
                                                <td><?php echo $set->Nama; ?></td>
                                                <td><?php echo $set->Pemborong; ?>
                                                <td><?php echo $set->SubPemborong; ?>
                                                    <?php if ($set->Pemborong == 'YAO HSING') {
                                                        $tipe = 1;
                                                    } else {
                                                        $tipe = 0;
                                                    } ?>
                                                    <input name="txtTipe[]" type="hidden" value="<?php echo $tipe; ?>" readonly="">
                                                </td>
                                                <td class="text-right"><?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir)); ?></td>
                                                <td><?php
                                                    $jekel = $set->Jenis_Kelamin;
                                                    if ($jekel == 'M' || $jekel == 'LAKI-LAKI') {
                                                        echo 'Laki-laki';
                                                    } elseif ($jekel == 'F' || $jekel == 'PEREMPUAN') {
                                                        echo 'Perempuan';
                                                    } else {
                                                        echo 'Gx Jelas';
                                                    }
                                                    ?></td>
                                                <td>
                                                    <div class="text-left"><?php echo $set->RegisteredBy; ?></div>
                                                    <div class="text-right smaller-90"><?php echo $set->RegisteredDate; ?></div>
                                                </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="widget-toolbox padding-8 clearfix">
                        <div class="well text-center">
                            <button type="submit" name="btnPosting" id="btnPosting" class="btnPosting btn btn-success">Daftar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-listTK').dataTable();
        $('[data-rel=tooltip]').tooltip();
    });

    $(document).on('click', '.chk_all', function() {
        if (this.checked) {
            $('.chkPosting').prop('checked', true)
        } else {
            $('.chkPosting').prop('checked', false)
        }

    })



    var urlSaveKirimPBR = '<?= base_url() ?>Registrasi/updateDikirim';

    $(document).ready(function() {
        $('.btnPosting').click(function(event) {
            var headerID = []

            $('.chkPosting').each(function(i, e) {
                if ($(this).is(':checked')) {

                    headerID.push($(this).val())

                }
            })
            console.log(headerID);
            $.ajax({
                type: "POST",
                url: urlSaveKirimPBR,
                dataType: 'json',
                data: {
                    headerID
                },
                success: function(data) {
                    console.log(data.msg);
                    Swal.fire(
                        data.msg,
                        'Data ' + data.msg + ' disimpan!',
                        data.type
                    ).then((result) => {
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    })
                }
            });

        });
    });
</script>