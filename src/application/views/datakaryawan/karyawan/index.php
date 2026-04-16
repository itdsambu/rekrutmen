<?php if (($this->session->userdata('userid') == 'riyan') or ($this->session->userdata('userid') == 'psn_gia') or ($this->session->userdata('userid') == 'psn_lisa') or ($this->session->userdata('userid') == 'IMAM41900') or ($this->session->userdata('userid') == 'kiki')) : ?>
    <div class="page-header">
        <h1>
            Data Karyawan
        </h1>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">List Karyawan</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-xs-12">
                                <form class="form-hoeizontal" role="form" method="POST" action="<?php echo base_url('datakaryawan/karyawantest') ?>">
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group">
                                            <div class="row">
                                                <label class="col-sm-3 control-label no-padding-right">Filter Data</label>
                                                <div class="col-sm-6">
                                                    <select class="form-control input-sm" name="selDataFilter" id="inputDataFilter">
                                                        <option value="0" <?php if ($_selected == 0) {
                                                                                echo 'selected';
                                                                            } ?>> Semua Data</option>
                                                        <option value="1" <?php if ($_selected == 1) {
                                                                                echo 'selected';
                                                                            } ?>> Laki-laki</option>
                                                        <option value="2" <?php if ($_selected == 2) {
                                                                                echo 'selected';
                                                                            } ?>> Perempuan</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
                                                    <!-- <input type="text" class="cari" name="cari">  -->
                                                </div>
                                            </div>
                                            <script>
                                                $('#inputDataFilter').change(function() {
                                                    var val = this.value;
                                                    window.location = '<?php echo site_url(); ?>datakaryawan/karyawan/' + val;
                                                });

                                                $('.cari').keyup(function() {
                                                    var val = this.value;
                                                    // alert(val);
                                                    $.ajax({
                                                        url: "<?php echo site_url('datakaryawan/KaryawanFilter'); ?>",
                                                        type: "POST",
                                                        data: {
                                                            val
                                                        },
                                                        datatype: "json",

                                                        success: function(msg) {
                                                            $("#timpa").html(msg);
                                                            console.log(msg)
                                                        }
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <br>
                            <br>
                            <div id="data" class="col-xs-12 table-responsive">
                                <table id="myTable" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th hidden>NIK</th>
                                            <th>NAMA</th>
                                            <th>TEMPAT/TANGGAL LAHIR</th>
                                            <th>SUKU</th>
                                            <th>AGAMA</th>
                                            <th>ALAMAT</th>
                                            <th>DAERAH ASAL</th>
                                            <th>DETAIL</th>
                                        </tr>
                                    </thead>
                                    <tbody id="timpa">
                                        <?php if ($_selectWhere == NULL) {
                                            echo '<tr><td colspan="7" class="center">Not select data</td></tr>';
                                        } else ?>
                                        <?php foreach ($_selectWhere as $row) : ?>
                                            <tr class="info" data-id="<?php echo $row->NIK ?>">
                                                <td hidden><?php echo $row->NIK ?></td>
                                                <td><?php echo $row->NAMA ?></td>
                                                <td><?php echo $row->TEMPATLHR ?>,<?php echo date('d-M-Y', strtotime($row->TGLLAHIR)) ?></td>
                                                <td><?php echo $row->NamaSuku ?></td>
                                                <td><?php echo $row->AGAMA ?></td>
                                                <td><?php echo $row->ALAMATS ?></td>
                                                <td><?php echo $row->ALAMATR ?></td>
                                                <td>
                                                    <a title="View Detail" data-rel="tooltip" href="#" class="detail btn btn-minier btn-round btn-primary">
                                                        <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                                                    </a>
                                                    <a title="Print" data-rel="tooltip" href="<?php echo site_url('datakaryawan/viewKaryawan/' . $row->NIK); ?>" target="_blank" class="btn btn-minier btn-round btn-warning">
                                                        <i class="ace-icon fa fa-print bigger-100"></i> Print
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tbody>
                                        <tr>
                                            <td colspan="9" class="center"><?php echo $_pagination; ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal View -->
    <div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <!--style="background-color: #008cba">-->
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Informasi Data Karyawan</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="inputdetail" name="iddetail">
                    <div id="detail" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url(); ?>assets/jqv/jquery.tablesorter.min.js"></script>
    <script>
        $(document).ready(function() {
            $("myTable").tablesorter();
            $('[data-rel=tooltip]').tooltip();
        })
    </script>

    <script>
        $(document).ready(function() {
            $("myTable").dataTable({
                "order": [
                    [0, 'asc']
                ]
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $("myTable").tablesorter();
            $('[data-rel=tooltip]').tooltip();
            $("#myTable").on("click", ".detail", function() {
                var id = $(this).closest('tr').data('id');
                $.ajax({
                    url: "<?php echo site_url('datakaryawan/detailk'); ?>",
                    type: "POST",
                    data: "kode=" + id,
                    datatype: "json",
                    cache: false,
                    success: function(msg) {
                        $("#detail").html(msg);
                    }
                });
                $("#viewModal").modal("show");
            });
        })
    </script>
<?php else : ?>
    <div class="center">
        <span class="red">ANDA TIDAK MEMILIKI AKSES UNTUK FORM INI !!!</span>
    </div>
<?php endif; ?>