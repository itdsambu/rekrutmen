<!-- <?php if ($this->session->userdata('dept') == 'ITD') {
            echo '<script language="javascript">';
            echo 'alert("Modul Sedang Diperbaiki, Jangan Di Pakai Terlebih Dahulu !!")';
            echo '</script>';
        } ?> -->
<div class="page-header">
    <h1>
        Tujuan Wawancara
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Menentukan Tujuan Departemen Untuk Proses Wawancara
        </small>
    </h1>
</div>

<?php $att = array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'formSetDept');
echo form_open('wawancaraTujuan/simpanTujuan', $att);
?>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">List Tenaga Kerja Baru </h4>

                <div class="widget-toolbar">
                    <!-- <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a> -->
                    <select name="filter_status" id="filter_status">
                        <?php foreach ($_getCVNama as $row) { ?>
                            <option value="<?php echo $row->CVNama; ?>" <?php if ($row->CVNama == $_selected) {
                                                                            echo 'selected';
                                                                        } ?>><?php echo $row->CVNama; ?></option>
                        <?php } ?>
                    </select>
                    <script>
                        $("#filter_status").change(function() {
                            var filter_selected = $("#filter_status").val();
                            var filter_selected2 = filter_selected.split(' ').join('_');
                            console.log(filter_selected2);
                            if (filter_selected2 != '') {
                                if (filter_selected2 == 'PT._PULAU_SAMBU_(GUNTUNG)') {
                                    filter_selected2 = 'PT_PSG';
                                } else {
                                    filter_selected2 = filter_selected2;
                                }
                                window.location = '<?php echo site_url(); ?>wawancaraTujuan/listWawancaraTujuan/' + filter_selected2;
                            } else {
                                window.location = '<?php echo site_url(); ?>wawancaraTujuan/listWawancaraTujuan';
                            }
                        });
                    </script>
                </div>
                <div class="widget-toolbar">
                    <a class="btn btn-minier btn-success" href="<?= site_url('export_excel/C_export_excel_identifikasi_by_psn') ?>" title="Export to Excel" target="_blank" onclick="return confirm('EXPORT TO EXCEL... ?')">
                        &nbsp;<i class="ace-icon fa fa-file-excel-o bigger-120"></i> Export to Excel &nbsp;
                    </a>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="form-group">
                        <div class="col-sm-6">
                            <label>Pekerjaan Harian</label>
                            <select class="form-control" name="cmbIDDetailHarian" id="inputIDDetail" onchange="changePekerjaanHarian(this.value)">
                                <option value="">Pilih</option>
                                <!-- <?php foreach ($_quota as $row) : ?>
                                <?php endforeach; ?> -->
                                <?php foreach ($_getDept1 as $rowDept) : ?>
                                    <option value="<?php echo $rowDept->DetailID; ?>">
                                        <?php echo "#" . $rowDept->DetailID . ". " . $rowDept->DeptAbbr . " - " . $rowDept->Pemborong . " - " . $rowDept->TKPermintaan . " orang - " . $rowDept->Pekerjaan; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label>Pekerjaan Karyawan</label>
                            <select class="form-control" name="cmbIDDetailKar" id="inputIDDetailKaryawan" onchange="changePekerjaanKaryawan(this.value)">
                                <option value="">Pilih</option>
                                <!-- <?php foreach ($_quota as $row) : ?>
                                <?php endforeach; ?> -->
                                <?php foreach ($_getDept2 as $rowDept) : ?>
                                    <option value="<?php echo $rowDept->DetailID; ?>">
                                        <?php echo "#" . $rowDept->DetailID . ". " . $rowDept->DeptAbbr . " - " . $rowDept->Pemborong . " - " . $rowDept->TKPermintaan . " orang - " . $rowDept->Pekerjaan; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="hr hr-20"></div>
                    <div class=" table table-responsive">
                        <table id="dataTables-listTK" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">
                                        <label class="pos-rel">
                                            <input type="checkbox" class="ace">
                                            <span class="lbl"></span>
                                        </label>
                                    </th> <!-- <th>Department</th>-->
                                    <th>TO P2K3</th>
                                    <th>TO ELC</th>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Pemborong</th>
                                    <th>Tempat/Tangga Lahir</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Pendidikan</th>
                                    <th>Status</th>
                                    <th>Alamat</th>
                                    <th>Record Interview</th>
                                </tr>
                            </thead>

                            <tbody>

                                <?php
                                $no1 = 1;
                                $no2 = 1;
                                $no3 = -1;
                                $jml_data = 0;
                                foreach ($_getTenagaKerja as $set) :
                                    $no3++;
                                    echo '<tr data-id="' . $set->HeaderID . '" class="rowdetail info" >';
                                ?>
                                    <td class="text-center">
                                        <div class="checkbox">
                                            <label class="pos-rel">
                                                <input name="ckHdrID[<?= $no3 ?>]" type="checkbox" class="ace" value="<?php echo $set->HeaderID; ?>">

                                                <span class="lbl"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="checkbox">
                                            <label class="pos-rel">
                                                <!-- <input name="alldatapost[<?= $no3 ?>]" class="alldatapost" id="alldatapost" type="hidden" value=""> -->
                                                <input name="to_p2k3[<?= $no3 ?>]" class="to_p2k3" id="to_p2k3" type="checkbox" value="">
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="checkbox">
                                            <label class="pos-rel">
                                                <input name="to_elc[<?= $no3 ?>]" class="to_elc" id="to_elc" type="checkbox" value="">
                                            </label>
                                        </div>
                                    </td>
                                    <td style="width: 50px " class="text-right"><?php echo $set->HeaderID; ?></td>
                                    <td><?php echo $set->Nama; ?></td>
                                    <td><?php echo $set->Pemborong; ?></td>
                                    <td class="text-right"><?php echo ucwords(strtolower($set->Tempat_Lahir)); ?>/<?php echo date('d-M-Y',  strtotime($set->Tgl_Lahir)); ?></td>
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
                                    <td><?php echo $set->Pendidikan; ?></td>
                                    <td><?php echo $set->Status_Personal; ?></td>
                                    <td class="col-sm-2"><?php echo ucwords(strtolower($set->Alamat)); ?></td>
                                    <td class="text-center">
                                        <?php
                                        if ($set->WawancaraKe == NULL) {
                                            echo 'Belum Pernah';
                                        } else {
                                        ?>
                                            <a title="View Detail" data-rel="tooltip" href="#" class="detailInterview btn btn-minier btn-white btn-block">
                                                <i class="ace-icon fa fa-files-o bigger-100"></i> <?php echo $set->WawancaraKe . ' kali'; ?>
                                            </a>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="widget-toolbox padding-8 clearfix">
                <div class="well text-center">
                    <input type="hidden" name="jml_data" value="<?= $no3 ?>" id="jml_data">
                    <input type="submit" value="Simpan" name="Simpan" class="btn btn-success">
                </div>
            </div>
        </div>
    </div>
</div>
</form>

<!-- Modal View -->
<div class="modal fade" id="viewModalInterview" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Informasi Record Wawancara</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="detailInterview" class="well">
                    <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(".to_p2k3").on("click", function() {
        // alert("Coba")
        let that = $(this);
        if (this.checked) {
            let elc = that.closest("tr").find(".to_elc")
            elc.prop("checked", false)
        }
    });
    $(".to_elc").on("click", function() {
        // alert("Coba")
        let that = $(this);
        if (this.checked) {
            let elc = that.closest("tr").find(".to_p2k3")
            elc.prop("checked", false)
        }
    });

    function changePekerjaanHarian(val) {
        if (val != '') {
            $('#inputIDDetailKaryawan').attr('disabled', 'disabled');
        } else {
            $('#inputIDDetailKaryawan').removeAttr('disabled');
        }
    }

    function changePekerjaanKaryawan(val) {
        if (val != '') {
            $('#inputIDDetail').attr('disabled', 'disabled');
        } else {
            $('#inputIDDetail').removeAttr('disabled');
        }
    }
    $(document).ready(function() {
        $('#dataTables-listTK').dataTable();

        $("#dataTables-listTK").on("click", ".detailInterview", function() {
            var id = $(this).closest('tr').data('id');
            $.ajax({
                url: "<?php echo site_url('wawancaraTujuan/cekRecordInterview'); ?>",
                type: "POST",
                data: "kode=" + id,
                datatype: "json",
                cache: false,
                success: function(msg) {
                    $("#detailInterview").html(msg);
                }
            });
            $("#viewModalInterview").modal("show");
        });

        var active_class = 'active';
        $('#dataTables-listTK > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
            var th_checked = this.checked; //checkbox inside "TH" table header
            $(this).closest('table').find('tbody > tr').each(function() {
                var row = this;
                if (th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
            });
        });

    });
</script>

<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        $('#formSetDept').validate({
            errorElement: 'div',
            errorClass: 'help-block',
            focusInvalid: false,
            ignore: "",

            rules: {
                cmbIDDetailHarian: {
                    required: true
                }
            },

            messages: {
                cmbIDDetailHarian: "Harap Pilih Department Tujuan!"

            },


            highlight: function(e) {
                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
            },

            success: function(e) {
                $(e).closest('.form-group').removeClass('has-error'); //.addClass('has-info');
                $(e).remove();
            },

            errorPlacement: function(error, element) {
                if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {
                    var controls = element.closest('div[class*="col-"]');
                    if (controls.find(':checkbox,:radio').length > 1) controls.append(error);
                    else error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));
                } else if (element.is('.select2')) {
                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));
                } else if (element.is('.chosen-select')) {
                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));
                } else error.insertAfter(element.parent());
            }
        });
    });
</script>