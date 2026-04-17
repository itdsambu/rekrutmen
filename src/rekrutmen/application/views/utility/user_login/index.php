<?php
$this->load->view('template/sweetAlert');
$this->load->view('template/formPicker');
$this->load->view('template/formValidation');
?>
<div class="page-header">
    <h1>
        MANAGEMENT USER
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Input User
        </small>
    </h1>
</div>
<!-- <?= $this->session->userdata('nik') ?> -->
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><b> Registrasi User</b></div>
            <div class="panel-body">
                <?php
                if ($this->input->get('msg') == 'success') {
                    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                            <i class='ace-icon fa fa-times'></i></button>Penambahan User berhasil..</p>";
                } elseif ($this->input->get('msg') == 'failed') {
                    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
                            <i class='ace-icon fa fa-times'></i></button>Penambahan User gagal..</p>";
                } elseif ($this->input->get('msg') == 'success_edit') {
                    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                            <i class='ace-icon fa fa-times'></i></button>Data behasil diedit..</p>";
                } elseif ($this->input->get('msg') == 'failed_edit') {
                    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
                            <i class='ace-icon fa fa-times'></i></button>Data gagal diedit..</p>";
                }
                ?>
                <form class="form-horizontal" role="form" method="post" id="simpanuser">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Type</label>
                        <div class="col-sm-4">
                            <select class="form-control input-sm btn btn-primary" name="selType" id="inputType">
                                <option value="">-- pilih type --</option>
                                <option value="K">KARYAWAN</option>
                                <option value="TK">BORONGAN/HARIAN</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Find NIK</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" class="form-control input-sm search-query" name="txtFindByid" id="findBynik" placeholder="Find by NIK" />
                                <span class="input-group-btn">
                                    <button type="button" id="btnFind" class="btn btn-info btn-sm">
                                        <span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                        <label class="control-label col-sm-4">NIK</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control input-sm" name="txtNIK" id="inputNIK" placeholder="NIK" readonly /> -->
                            <input type="text" class="form-control input-sm" name="txtNIK" id="inputNIK" placeholder="NIK" />
                            <input type="hidden" class="form-control input-sm" name="txtRegno" id="txtRegno" placeholder="txtRegno" />
                            <input type="hidden" class="form-control input-sm" name="txtPersonalStatus" value="<?php if (set_value('inputType') == 'K') {
                                                                                                                    echo set_value('txtPersonalStatus');
                                                                                                                } elseif (set_value('inputType') == 'TK') {
                                                                                                                    echo set_value('txtPersonalStatus');
                                                                                                                } ?>" id="txtPersonalStatus" placeholder="txtPersonalStatus" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Nama</label>
                        <div class="col-sm-4">
                            <!-- <input type="text" class="form-control input-sm" name="txtNama" id="inputNama" placeholder="Nama" readonly /> -->
                            <input type="text" class="form-control input-sm" name="txtNama" id="inputNama" placeholder="Nama" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Dept</label>
                        <div class="col-sm-4">
                            <input type="hidden" class="form-control input-sm" name="txtDeptID" id="inputDeptID" placeholder="Dept" readonly />
                            <!-- <input type="text" class="form-control input-sm" name="txtDept" id="inputDept" placeholder="Dept" readonly /> -->
                            <input type="text" class="form-control input-sm" name="txtDept" id="inputDept" placeholder="Dept" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Jabatan</label>
                        <div class="col-sm-4">
                            <input type="hidden" class="form-control input-sm" name="txtJabatanID" id="inputJabatanID" placeholder="Jabatan" readonly />
                            <!-- <input type="text" class="form-control input-sm" name="txtJabatan" id="inputJabatan" placeholder="Jabatan" readonly /> -->
                            <input type="text" class="form-control input-sm" name="txtJabatan" id="inputJabatan" placeholder="Jabatan" />
                        </div>
                    </div>
                    <br />
                    <div class="form-group">
                        <label class="control-label col-sm-4">Username</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control input-sm" name="txtUsername" id="inputUsername" placeholder="Username" />
                        </div>
                    </div>
                    <?php
                    $random_hash  = md5(uniqid(rand(), true));
                    $auth         = strtoupper(substr($random_hash, 0, 6));
                    ?>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Password</label>
                        <div class="col-sm-4">
                            <!-- <input type="password" class="form-control input-sm" name="txtPassword" id="inputPassword" placeholder="Password" value="PASS1234" readonly /> -->
                            <input type="password" class="form-control input-sm" name="txtPassword" id="inputPassword" placeholder="Password" value="PASS1234" />
                            <input type="checkbox" class="form-checkbox"> Show password
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"> Grup User </label>
                        <div class="col-sm-4">
                            <select class="form-control btn btn-success" id="inputGrupID" name="txtGrupID">
                                <?php foreach ($getGrupUser as $set) : ?>
                                    <option value="<?php echo $set->GroupID; ?>"><?php echo $set->GroupName;
                                                                                    ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"> Anggota Screening </label>
                        <div class="col-sm-4">
                            <div class="radio">
                                <label>
                                    <input name="txtScreening" type="radio" class="ace" value="1" required="" />
                                    <span class="lbl"> YES</span>
                                </label>
                                <label>
                                    <input name="txtScreening" type="radio" class="ace" value="0" checked />
                                    <span class="lbl"> NO</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"> Status </label>
                        <div class="col-sm-4">
                            <div class="radio">
                                <label>
                                    <input name="txtStatus" type="radio" class="ace" value="0" required="" checked />
                                    <span class="lbl"> Active</span>
                                </label>
                                <label>
                                    <input name="txtStatus" type="radio" class="ace" value="1" />
                                    <span class="lbl"> Not Active</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"> Akses Notif Tele </label>
                        <div class="col-sm-4">
                            <div class="radio">
                                <label>
                                    <input name="txtaccessnotif" type="radio" class="ace" value="1" required="" />
                                    <span class="lbl"> Active</span>
                                </label>
                                <label>
                                    <input name="txtaccessnotif" type="radio" class="ace" value="0" checked />
                                    <span class="lbl"> Not Active</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"> Tele Notif Screening by HRD
                        </label>
                        <div class="col-sm-4">
                            <div class="radio">
                                <label>
                                    <input name="txtTelenotif" type="radio" class="ace" value="1" required="" />
                                    <span class="lbl"> Active</span>
                                </label>
                                <label>
                                    <input name="txtTelenotif" type="radio" class="ace" value="0" checked />
                                    <span class="lbl"> Not Active</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4"> Tele Notif Screening by TIM
                        </label>
                        <div class="col-sm-4">
                            <div class="radio">
                                <label>
                                    <input name="txtTelenotifTim" type="radio" class="ace" value="1" required="" />
                                    <span class="lbl"> Active</span>
                                </label>
                                <label>
                                    <input name="txtTelenotifTim" type="radio" class="ace" value="0" checked />
                                    <span class="lbl"> Not Active</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="widget-toolbox padding-8 clearfix">
                <div class="well text-center">
                    <button type="button" class="btn btn-info" id="btnSimpan">
                        <i class="ace-icon fa fa-check bigger-110"></i>
                        Submit
                    </button>
                    <button type="reset" class="btn btn-danger">
                        <i class="ace-icon fa fa-undo bigger-110">
                            Reset
                        </i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <?php
        $random_hash  = md5(uniqid(rand(), true));
        $auth         = strtoupper(substr($random_hash, 0, 6));
        print_r($auth);
        print_r(md5(sha1($auth)));
        ?> -->


<script>
    var urlSubmit = '<?= base_url() ?>user_login/savenewuser'
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('.form-checkbox').click(function() {
            if ($(this).is(':checked')) {
                $('#inputPassword').attr('type', 'text');
            } else {
                $('#inputPassword').attr('type', 'password');
            }
        });
    });
</script>
<script>
    jQuery(document).ready(function() {
        $('#btnSimpan').click(function() {
            $('#simpanuser').attr('action', urlSubmit);
            swal({
                title: "Data akan disimpan?",
                type: "info",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: true
            }, function(isConfirm) {
                if (isConfirm) {
                    $('#simpanuser').submit();
                    if ($('#simpanuser').parsley().validate()) {
                        $('#simpanuser').submit();
                        console.log($('#simpanuser').serialize())
                    }
                }
                $('#simpanuser').attr('action', '');
            });
        });
    });
</script>
<script type="text/javascript">
    $("#btnFind").on('click', function(e) {
        var nik = $('#findBynik').val();
        var status = document.getElementById('inputType').value;
        if (status == 'K') {
            if (nik == '') {
                swal({
                    title: "NIK Karyawan tidak boleh kosong !",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonText: "OK",
                    closeOnConfirm: true
                });
            } else {
                $.ajax({
                    data: {
                        nik: $('#findBynik').val(),
                        'tipe': 'K'
                    },
                    type: 'POST',
                    dataType: 'json',
                    url: './getmynikKaryawan',
                    success: function(d, r, x) {
                        $('#inputNIK').val('');
                        $('#inputNama').val('');
                        $('#inputDeptID').val('');
                        $('#inputDept').val('');
                        $('#inputJabatanID').val('');
                        $('#inputJabatan').val('');
                        $('#txtRegno').val('');
                        $('#txtInActive').val('');
                        $('#txtPersonalStatus').val('1');
                        console.log(d);
                        if (d.Err == 0) {
                            nik = d.Msg[0].NIK;
                            nama = d.Msg[0].NAMA;
                            deptid = d.Msg[0].DeptID;
                            dept = d.Msg[0].DeptAbbr;
                            jabid = d.Msg[0].JabatanID;
                            jab = d.Msg[0].JabatanName;
                            reg = d.Msg[0].RegNo;
                            status = d.Msg[0].InActive;
                            $('#inputNIK').val(nik);
                            $('#inputNama').val(nama);
                            $('#inputDeptID').val(deptid);
                            $('#inputDept').val(dept);
                            $('#inputJabatanID').val(jabid);
                            $('#inputJabatan').val(jab);
                            $('#txtRegno').val(reg);
                            // $('#txtInActive').val(status);
                        } else {
                            swal(d.Msg, 'Error', 'error');
                        }
                    }
                });
            }
        } else if (status == 'TK') {
            if (nik == '') {
                swal({
                    title: "NIK Harian/Borongan tidak boleh kosong !",
                    type: "warning",
                    showCancelButton: false,
                    confirmButtonText: "OK",
                    closeOnConfirm: true
                });
            } else {
                $.ajax({
                    data: {
                        nik: $('#findBynik').val(),
                        'tipe': 'TK'
                    },
                    type: 'POST',
                    dataType: 'json',
                    url: './getmynikKaryawan',
                    success: function(d, r, x) {
                        $('#inputNIK').val('');
                        $('#inputNama').val('');
                        $('#inputDeptID').val('');
                        $('#inputDept').val('');
                        $('#inputJabatanID').val('');
                        $('#inputJabatan').val('');
                        $('#txtRegno').val('');
                        $('#txtPersonalStatus').val('2');
                        if (d.Err == 0) {
                            console.log(d);
                            nik = d.Msg[0].Nik;
                            nama = d.Msg[0].NAMA;
                            deptid = d.Msg[0].IDDepartemen;
                            dept = d.Msg[0].DeptAbbr;
                            jabid = d.Msg[0].IDJabatan;
                            jab = d.Msg[0].Jabatan;
                            reg = d.Msg[0].RegNo;
                            $('#inputNIK').val(nik);
                            $('#inputNama').val(nama);
                            $('#inputDeptID').val(deptid);
                            $('#inputDept').val(dept);
                            $('#inputJabatanID').val(jabid);
                            $('#inputJabatan').val(jab);
                            $('#txtRegno').val(reg);
                        } else {
                            swal(d.Msg, 'Error', 'error');
                        }
                    }
                });
            }
        } else {
            swal({
                title: "Pilih status terlebih dahulu!",
                type: "warning",
                showCancelButton: false,
                confirmButtonText: "OK",
                closeOnConfirm: true
            });
        }
    });
</script>
<script>

</script>