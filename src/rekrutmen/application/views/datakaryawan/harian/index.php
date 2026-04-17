<?php if (($this->session->userdata('userid') == 'riyan') or ($this->session->userdata('userid') == 'psn_gia') or ($this->session->userdata('userid') == 'psn_lisa') or ($this->session->userdata('userid') == 'IMAM41900') or ($this->session->userdata('userid') == 'KIKI')) : ?>
    <div class="page-header">
        <h1>
            Data Harian
        </h1>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">List Tenaga kerja</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-xs-12">
                                <form class="form-hoeizontal" role="form" method="POST" action="<?php echo base_url('datakaryawan/hariantest') ?>">
                                    <div class="col-xs-12 col-sm-4">
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label no-padding-right">Filter Data</label>
                                            <div class="col-sm-8">
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
                                            <script>
                                                $('#inputDataFilter').change(function() {
                                                    var val = this.value;
                                                    window.location = '<?php echo site_url(); ?>datakaryawan/harian/' + val;
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
                                            <th>NAMA</th>
                                            <th>TEMPAT/TANGGAL LAHIR</th>
                                            <th>SUKU</th>
                                            <th>AGAMA</th>
                                            <th>ALAMAT</th>
                                            <th>DAERAH ASAL</th>
                                            <th>DETAIL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($_selectWhere == NULL) {
                                            echo '<tr><td colspan="7" class="center">Not select data</td></tr>';
                                        } else ?>
                                        <?php foreach ($_selectWhere as $row) : ?>
                                            <tr class="info" data-id="<?php echo $row->Nik ?>">
                                                <td><?php echo $row->Nama ?></td>
                                                <td><?php echo $row->TempatLahir ?>,<?php echo date('d-M-Y', strtotime($row->TglLahir)) ?></td>
                                                <td><?php echo $row->Suku ?></td>
                                                <td><?php echo $row->Agama ?></td>
                                                <td><?php echo $row->Alamat ?></td>
                                                <td><?php echo $row->DaerahAsal ?></td>
                                                <td class="text-center">
                                                    <div class="btn-group">
                                                        <a title="View Detail" data-rel="tooltip" href="#" class="detail btn btn-minier btn-round btn-primary">
                                                            <i class="ace-icon fa fa-files-o bigger-100"></i> Detail
                                                        </a>
                                                        <a title="Print" data-rel="tooltip" href="<?php echo site_url('datakaryawan/viewTenaker/' . $row->Nik); ?>" target="_blank" class="btn btn-minier btn-round btn-warning">
                                                            <i class="ace-icon fa fa-print bigger-100"></i> Print
                                                        </a>
                                                    </div>
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
            $("#myTable").on("click", ".detail", function() {
                var id = $(this).closest('tr').data('id');
                $.ajax({
                    url: "<?php echo site_url('datakaryawan/detailtk'); ?>",
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

    <!-- <script>
    $(document).ready(function(){
        $("myTable").dataTable({"order":[[0,'asc']]
    });
    });
</script> -->
<?php else : ?>
    <div class="center">
        <span class="red">ANDA TIDAK MEMILIKI AKSES UNTUK FORM INI !!!</span>
    </div>
<?php endif; ?>