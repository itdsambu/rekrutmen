<?php
$this->load->view('template/sweetAlert');
$this->load->view('template/formPicker');
$this->load->view('template/formValidation');
?>
<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Entry Data Kandidat
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-info">
                    <div class="panel-heading"><b> Entry Calon Kandidat</b></div> <br>
                    <?php if ($this->session->userdata('userid') == 'NURUL FATHIA') { ?>
                        <div class="alert-danger " style="text-align: center;"><b> WAJIB DI ISI SEMUA !!</b></div>
                    <?php } ?>
                    <div class="panel-body">
                        <div class="row">
                            <?php if ($this->session->flashdata('_message')) : ?>
                                <div class="alert <?= ($_GET['success'] == 'ok' ? 'alert-success' : 'alert-danger') ?> alert-dismissible" rolw="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">x</span></button>
                                    <strong><?= ($_GET['success'] == 'ok' ? 'Well done' : 'Oh snap') ?>!</strong> <?= $this->session->flashdata('_message') ?>
                                </div>
                            <?php endif; ?>
                            <form class="form-horizontal" role="form" method="post" id="savedatack">
                                <div class="col-xs-12">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Nama</label>
                                            <div class="col-md-8">
                                                <input type="text" id="txtInputNama" name="txtNama" require class="form-control input-sm" placeholder="Nama" autofocus required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Jenis Kelamin</label>
                                            <div class="col-md-8">
                                                <select class="form-control input-sm btn btn-info btn-sm" id="selInputJK" name="selJK" required>
                                                    <option value="">-- pilih --</option>
                                                    <option value="L">Laki-laki</option>
                                                    <option value="P">Perempuan</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">TTL</label>
                                            <div class="col-md-4">
                                                <input type="text" id="txtInputTempatL" name="txtTempatL" require class="form-control input-sm" placeholder="Tempat Lahir" required>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="text" id="txtInputTglL" name="txtTglL" require class="form-control input-sm datepick" placeholder="Tanggal Lahir" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">No. KTP</label>
                                            <div class="col-md-6">
                                                <input type="text" id="txtInputNo_Ktp" name="txtNo_Ktp" require class="form-control input-sm" placeholder="No. KTP" maxlenght="16" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">No. HP</label>
                                            <div class="col-md-6">
                                                <input type="text" id="txtInputNoHP" name="txtNoHP" require class="form-control input-sm" placeholder="No. HP" maxlenght="12" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Email</label>
                                            <div class="col-md-6">
                                                <input type="text" id="txtInputEmail" name="txtEmail" require class="form-control input-sm" placeholder="example@example.com" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Posisi</label>
                                            <div class="col-md-6">
                                                <input type="text" id="txtInputPosisi" name="txtPosisi" require class="form-control input-sm" placeholder="Posisi" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Level</label>
                                            <div class="col-md-6">
                                                <input type="text" id="txtInputLevel" name="txtLevel" require class="form-control input-sm" placeholder="Level" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Dept</label>
                                            <div class="col-md-6">
                                                <select class="form-control input-sm btn btn-info btn-sm" id="selInputDept" name="selDept" required>
                                                    <option value="">-- pilih --</option>
                                                    <?php foreach ($_getDept as $rowDept) :
                                                        if (isset($_getData)) {
                                                            if ($_getData[0]->DeptID == $rowDept->DeptID) {
                                                    ?>
                                                                <option value="<?= $rowDept->DeptID ?>" selected><?= $rowDept->DeptAbbr ?></option>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                <option value="<?= $rowDept->DeptID ?>"><?= $rowDept->DeptAbbr ?></option>
                                                            <?php
                                                            }
                                                        } else { ?>
                                                            <option value="<?= $rowDept->DeptID ?>"><?= $rowDept->DeptAbbr ?></option>
                                                        <?php } ?>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Divisi</label>
                                            <div class="col-md-6">
                                                <select class="form-control input-sm btn btn-info btn-sm" id="selInputDivisi" name="selDivisi" required>
                                                    <option value="">-- pilih --</option>
                                                    <?php
                                                    if (isset($_getkabupaten)) {
                                                        foreach ($_getkabupaten as $div) :
                                                            if (isset($_getData)) {
                                                                if ($_getData[0]->KabKotaID == $div->kodedivisi) { ?>
                                                                    <option value="<?= $div->kodedivisi ?>" selected><?= $div->NamaDivisi ?></option>
                                                                <?php
                                                                } else { ?>
                                                                    <option value="<?= $div->kodedivisi ?>"><?= $div->NamaDivisi ?></option>
                                                                <?php
                                                                }
                                                            } else {
                                                                ?>
                                                                <option value="<?= $div->kodedivisi ?>"><?= $div->NamaDivisi ?></option>
                                                    <?php
                                                            }
                                                        endforeach;
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Pendidikan</label>
                                            <div class="col-md-6">
                                                <select class="form-control input-sm btn btn-info btn-sm" id="selInputPendidikan" name="selPendidikan" required>
                                                    <option value="">-- pilih --</option>
                                                    <?php
                                                    foreach ($_getPendidikan as $rowPendidikan) :
                                                        echo "<option value'$rowPendidikan->ID'>$rowPendidikan->Pendidikan</option>";
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Jurusan</label>
                                            <div class="col-md-6">
                                                <select class="form-control input-sm btn btn-info btn-sm" id="selInputJurusan" name="selJurusan" required>
                                                    <option value="">-- pilih --</option>
                                                    <?php
                                                    foreach ($_getJurusan as $rowJurusan) :
                                                        echo "<option value'$rowJurusan->ID'>$rowJurusan->Jurusan</option>";
                                                    endforeach;
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Jadwal Tes</label>
                                            <div class="col-md-6">
                                                <input type="text" id="txtInputJadwal" name="txtJadwal" require class="form-control input-sm datepick-days" placeholder="Jadwal Test" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Status</label>
                                            <div class="col-md-6">
                                                <select class="form-control input-sm btn btn-info btn-sm" id="selInputSts" name="selSts" required>
                                                    <option value="">-- pilih --</option>
                                                    <option value="L">Lulus</option>
                                                    <option value="TL">Tidak Lulus</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Status Test</label>
                                            <div class="col-md-6">
                                                <select class="form-control input-sm btn btn-info btn-sm" id="selInputStsT" name="selStsT" required>
                                                    <option value="">-- pilih --</option>
                                                    <option value="Test">Test</option>
                                                    <option value="Non Test">Non Test</option>
                                                    <option value="Lulus Test Proses">Lulus Test Proses</option>
                                                    <option value="Tidak Lulus Test Proses">Tidak Lulus Test Proses</option>
                                                    <option value="Tidak Lulus Non Proses">Tidak Lulus Non Proses</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Transport</label>
                                            <div class="col-md-6">
                                                <select class="form-control input-sm btn btn-info btn-sm" id="selInputTransport" onChange="ChangeBiaya(this.value);" name="selTransport" required>
                                                    <option value="">-- pilih --</option>
                                                    <option value="Diganti">Diganti</option>
                                                    <option value="Tidak Diganti">Tidak Diganti</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group" id="biaya" style="display: none">
                                            <label class="col-md-3 control-label"></label>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control input-sm" onkeypress="return isNumber(event)" name="txtBiaya" id="inputBiaya">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Sumber Pelamar</label>
                                            <div class="col-md-6">
                                                <input type="text" id="txtInputSumberPelamar" name="txtSumberPelamar" require class="form-control input-sm" placeholder="Sumber Pelamar" autofocus required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label">Keterangan</label>
                                            <div class="col-sm-6">
                                                <input type="text" id="txtInputKeterangan" name="txtKeterangan" require class="form-control input-sm biaya" placeholder="Keterangan" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12 text-right">
                                    <hr style="border:0;height:2px;background-image:linear-gradient(to right,rgba(107,95,181,1),rgba(125,115,191,1),rgba(0,0,0,0));">
                                    <button id="btnSubmit" type="button" class="btn btn-sm btn-primary"> <b>Simpan</b></button>
                                    <button id="btnCancel" type="reset" class="btn btn-sm btn-danger"> <b>Batal</b></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-timepicker.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/date-time/moment.js"></script>
    <script>
        var urlSaveCK = '<?= base_url() ?>Registrasi/simpanCK';
    </script>
    <script type="text/javascript">
        jQuery(function($) {
            $('.datepick').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            });
            $('.datepick-days').datepicker({
                autoclose: true,
                format: 'DD, dd-mm-yyyy'
            });

            $('#btnSubmit').click(function() {
                $('#savedatack').attr('action', urlSaveCK);
                swal({
                    title: "Data akan disimpan?",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonText: "Yes",
                    cancelButtonText: "No",
                    closeOnConfirm: true
                }, function(isConfirm) {
                    if (isConfirm) {
                        // $('#savedatack').submit();
                        if ($('#savedatack').parsley().validate()) {
                            $('#savedatack').submit();
                        }
                    }
                    $('#savedatack').attr('action', '');
                });
            });
        });
    </script>
    <script>
        jQuery(document).ready(function() {

            $('#inputBiaya').on('keypress', function(e) {
                var c = e.keyCode || e.charCode;
                switch (c) {
                    case 8:
                    case 9:
                    case 27:
                    case 13:
                        return;
                    case 65:
                        if (e.ctrlKey === true) return;
                }
                if (c < 48 || c > 57) e.preventDefault();
            }).on('keyup', function() {
                var inp = $(this).val().replace(/\./g, '');
                diambil = new Number(inp);
                $(this).val(formatAngka(inp));
            });

            $(function() {
                $('#selInputDept').on('change', function() {
                    idp = $(this).find(":selected").val();
                    $.ajax({
                        type: 'GET',
                        dataType: 'json',
                        url: '<?= base_url() ?>/registrasi/getdept',
                        data: {
                            iddiv: idp
                        },
                        success: function(d, r, x) {
                            data = d.data;
                            $('#selInputDivisi').empty().html('<option value="">-- pilih --</option>');
                            for (i = 0; i < data.length; i++) {
                                $('#selInputDivisi').append('<option value="' + data[i].kodedivisi + '">' + data[i].NamaDivisi + '</option>');
                            }
                        }
                    });
                });
            });
        });
    </script>
    <script>
        function formatAngka(angka) {
            if (typeof(angka) != 'string') angka = angka.toString();
            var reg = new RegExp('([0-9]+)([0-9]{3})');
            while (reg.test(angka)) angka = angka.replace(reg, '$1.$2');
            return angka;
        }
    </script>
    <script language="JavaScript">
        function ChangeBiaya(vstatus) {
            if (vstatus === "Diganti") {
                document.getElementById('biaya').style.display = "block";
                document.getElementById('inputBiaya').disabled = false;
            } else {
                document.getElementById('inputBiaya').value = "";
                document.getElementById('biaya').style.display = "none";
                document.getElementById('inputBiaya').disabled = true;
            }
        }
    </script>
    <script>
        function isNumber(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        }
    </script>