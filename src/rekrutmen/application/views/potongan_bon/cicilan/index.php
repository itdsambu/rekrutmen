<link href="<?php echo base_url(); ?>assets/sweetalert2-11.3.6/dist/sweetalert2.min.css" rel="stylesheet">
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><i class="glyphicon glyphicon-shopping-cart"></i> LIST CICILAN <?php echo $tanggal; ?></h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <br>
            <div class="col-lg-12">
                <?php if ($this->input->get('msg') == "success") {
                    echo "<div class='alert alert-success'>";
                    echo "<strong>Sukses !!!</strong> Data berhasil di Simpan.";
                    echo "</div>";
                } elseif ($this->input->get('msg') == "failed") {
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Gagal !!!</strong> Data Sudah diinput..!!";
                    echo "</div>";
                } ?>

            </div>
            <form class="form-horizontal" role="form" method="POST" action="#">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <p class="pull-left">
                                            <a class="btn btn-sm btn-primary" href="<?php echo base_url('PotonganBon/tambahCicilan'); ?>"><i class="fa fa-plus"></i> Tambah Order</a>
                                        </p>
                                    </div>
                                </div>
                                <hr>
                                <?php if ($this->session->userdata('groupuser') == 93 || $this->session->userdata('groupuser') == 156 || $this->session->userdata('groupuser') == 79) { ?>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Pemborong</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="txtPemborong" id="pemborong" onchange="CariSub2()">
                                                <?php if (count($_getDataPemborong) > 1) {
                                                    $selected = '';
                                                } else {
                                                    $selected = 'selected';
                                                } ?>
                                                <option value="">- Pilih Pemborong -</option>
                                                <?php foreach ($_getDataPemborong as $pbr) {
                                                    echo "<option value='" . $pbr->IDPemborong . "' " . $selected . ">" . $pbr->Pemborong . "</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">CV. Perusahaan</label>
                                        <div class="col-sm-4" id="tblSub">
                                            <select class="form-control" name="txtSubPemborong" id="subpemborong">
                                                <?php if (count($_getDataSub) > 1) {
                                                    $selected = '';
                                                } else {
                                                    $selected = 'selected';
                                                } ?>
                                                <option value="">- Pilih Sub Pemborong-</option>
                                                <?php foreach ($_getDataSub as $pbr) {
                                                    echo "<option value='" . $pbr->IDSubPemborong . "' " . $selected . ">" . $pbr->Perusahaan . "</option>";
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Periode</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="txtPeriode" id="periode">
                                                <option value="">- Pilih Periode -</option>
                                                <option value="1">Periode 1</option>
                                                <option value="16">Periode 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Bulan</label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="txtBulan" id="bulan">
                                                <?php
                                                $b = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                                                $a = 1;
                                                for ($i = 0; $i < 12; $i++) {
                                                    if ((date('n') - 1) == $i) {
                                                        echo "<option value=" . $a . " selected>" . $b[$i] . "</option>";
                                                    } else {
                                                        echo "<option value=" . $a . ">" . $b[$i] . "</option>";
                                                    }
                                                    $a++;
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Tahun</label>
                                        <div class="col-lg-4">
                                            <select class="form-control" name="txtTahun" id="tahun">
                                                <?php for ($i = date('Y') - 1; $i <= (date('Y') + 2); $i++) {
                                                    if ($i == date('Y')) { ?>
                                                        <option value="<?php echo $i; ?>" selected><?php echo $i; ?></option>
                                                    <?php } else { ?>
                                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php }
                                                } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label"></label>
                                        <div class="col-sm-4">
                                            <a href="#" class="btn btn-sm btn-success" onclick="Ajax_data()"><i class="fa fa-search"></i> Cari</a>
                                        </div>
                                    </div>
                                    <div class="table-responsive" id="tbllistmntcicilan">
                                        <table class="table table-bordered" id="dataTables">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th class="text-center">Tanggal Order</th>
                                                    <th class="text-center">Nik</th>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">CV</th>
                                                    <th class="text-center">Pemborong</th>
                                                    <th class="text-center">CV. Perusahaan</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($_getListOrder as $get) { ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $no++; ?></td>
                                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($get->Tanggal)); ?></td>
                                                        <td class="text-center"><?php echo $get->Nik; ?></td>
                                                        <td class="text-left"><?php echo $get->Nama; ?></td>
                                                        <td class="text-center"><?php echo $get->Perusahaan; ?></td>
                                                        <td class="text-center"><?php echo $get->Pemborong; ?></td>
                                                        <td class="text-center"><?php echo $get->NamaSub; ?></td>
                                                        <td class="text-center">
                                                            <a href="<?php echo base_url('PotonganBon/lihat_pesanan_cicilan/' . date('Y-m-d', strtotime($get->Tanggal)) . '/' . $get->Nofix . '/' . $get->IDSubPemborong . '/' . $get->HeaderID); ?>" class="btn btn-minier btn-round btn-success"><i class="glyphicon glyphicon-inbox"></i> Edit</a>
                                                            <!-- <a href="<?php echo base_url('PotonganBon/HapusCicilan/' . $get->HeaderID); ?>" class="btn btn-minier btn-round btn-danger"><i class="glyphicon glyphicon-trash"></i> Hapus </a> -->
                                                            <a href="#" class="btn btn-minier btn-round btn-danger" id="<?= $get->HeaderID ?>" onclick="viewHapus(this.id)"><i class="glyphicon glyphicon-trash"></i> Hapus </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else { ?>
                                    <div class="table-responsive" id="listid">
                                        <table class="table table-bordered" id="dataTables">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No.</th>
                                                    <th class="text-center">Tanggal Order</th>
                                                    <th class="text-center">Nik</th>
                                                    <th class="text-center">Nama</th>
                                                    <th class="text-center">CV</th>
                                                    <th class="text-center">Pemborong</th>
                                                    <th class="text-center">Sub Pemborong</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $no = 1;
                                                foreach ($_getListOrder as $get) { ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $no++; ?></td>
                                                        <td class="text-center"><?php echo date('d-m-Y', strtotime($get->Tanggal)); ?></td>
                                                        <td class="text-center"><?php echo $get->Nik; ?></td>
                                                        <td class="text-left"><?php echo $get->Nama; ?></td>
                                                        <td class="text-center"><?php echo $get->Perusahaan; ?></td>
                                                        <td class="text-center"><?php echo $get->Pemborong; ?></td>
                                                        <td class="text-center"><?php echo $get->NamaSub; ?></td>
                                                        <td class="text-center"></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables').dataTable();
    });
</script>
<script type="text/javascript">
    function CariSub2() {
        console.log("test");
        var pemborong = $('#pemborong').val();

        if (pemborong == '') {

        } else {
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PotonganBon/MntSub') ?>" + "/" + pemborong,
                success: function(msg) {
                    if (msg == '') {
                        alert('Tidak ada data');
                    } else {
                        $("#tblSub").html(msg);
                    }
                }
            });
        }
    }
</script>
<script type="text/javascript">
    function Ajax_data() {
        var pbr = $('#pemborong').val();
        var sub = $('#subpemborong').val();
        var periode = $('#periode').val();
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();

        $('#tbllistmntcicilan').html('<p style="text-align:center;"><img src="<?php echo base_url(); ?>assets/images/NewLoading.gif"></p>');
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajaxListCicilan') ?>" + "/" + pbr + "/" + sub + "/" + periode + "/" + bulan + "/" + tahun,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {
                    $("#tbllistmntcicilan").html(msg);
                }
            }
        });

    }

    function viewHapus(id) {
        let id_ = id
        // console.log(id_)
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(id_)
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {
                        id: id_
                    },
                    url: "<?php echo base_url('PotonganBon/HapusDataPotCicilan') ?>",
                    success: function(msg) {
                        // alert(msg)
                        Swal.fire({
                            title: 'Data Sudah Terhapus!!!',
                            text: "You won't be able to revert this!",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })

                        // console.log(msg)

                    },
                    error: function() {
                        Swal.fire(
                            'GAGALL!',
                            'Data tidak terhapus!',
                            'error'
                        )
                    }
                });

            }
        })

    }

    function viewHapus(id) {
        let id_ = id
        console.log(id_)
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                console.log(id_)
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    data: {
                        id: id_
                    },
                    url: "<?php echo base_url('PotonganBon/HapusDataPotCicilanHdr') ?>",
                    success: function(msg) {
                        // alert(msg)
                        Swal.fire({
                            title: 'Data Sudah Terhapus!!!',
                            text: "You won't be able to revert this!",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })

                        console.log(msg)

                    },
                    error: function() {
                        Swal.fire(
                            'GAGALL!',
                            'Data tidak terhapus!',
                            'error'
                        )
                    }
                });

            }
        })
    }
</script>