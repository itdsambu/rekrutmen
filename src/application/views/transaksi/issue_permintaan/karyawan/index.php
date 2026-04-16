<link rel="stylesheet" href="<?= base_url() ?>assets/css/sweetalert.css" />
<link href="<?php echo base_url(); ?>assets/sweetalert2-11.3.6/dist/sweetalert2.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/sweetalertpabo/sweetalert2.js"></script>
<div class="page-header">
    <h1>
        TRANSAKSI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Issue Permintaan Karayawan
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <?php $att = array('class' => 'form-horizontal', 'role' => 'form', 'id' => 'formkaryawan', 'name' => 'formkaryawan');
        echo form_open('issue/saveIssue_/karayawan', $att); ?>
        <fieldset>

            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Input Issue Karyawan</h4>

                    <div class="widget-toolbar">
                        <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                    </div>
                </div>

                <div class="widget-body">
                    <div class="widget-main">
                        <?php
                        $uri = $this->uri->segment(3);
                        if ($uri == 'success') {
                        ?>
                            <p class='alert alert-success'>
                                <button type='button' class='close' data-dismiss='alert'>
                                    <i class='ace-icon fa fa-times'></i></button>Success Issues Request..
                            </p>
                        <?php
                        }
                        ?>

                        <div class="form-group" <?= $this->session->userdata('dept') != 'HRD' || $this->session->userdata('dept') != 'ITD' ? 'style="display:none;"' : '' ?>>
                            <label class="col-sm-11 control-label" for="form-field-1">
                                <p class="btn btn-sm btn-primary">Target Bongkar hanya muncul di dept HRD dan ITD</p>
                            </label>
                        </div>
                        <div class="form-group" <?= $this->session->userdata('dept') != 'HRD' || $this->session->userdata('dept') != 'ITD' ? 'style="display:none;"' : '' ?>>
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Target Bongkar
                            </label>
                            <div id="target-bongkar" class="col-sm-8">
                                <select class="form-control" id="inputTargetBongkar" name="comboTargetBongkar" required>
                                    <option value="0"> -- Pilih </option>
                                    <?php foreach ($_getTargetBongkar as $rowTarget) : ?>
                                        <option value="<?php echo $rowTarget->id; ?>" <?= $rowTarget->id == $targetBongkar ? 'selected' : '' ?>><?php echo $rowTarget->jumlah; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Prusahaan
                            </label>
                            <div class="col-sm-9">
                                <input type="text" id="inputPemborong" name="txtPemborong" value="PSG" class="col-xs-12 col-sm-10" readonly="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Pilih Departemen
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control select2" id="inputDept" name="comboDept">
                                    <option value=""> -- Pilih </option>
                                    <?php foreach ($getDept as $rowDept) : ?>
                                        <option value="<?php echo $rowDept->DeptID; ?>"><?php echo $rowDept->DeptAbbr; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Jabatan
                            </label>
                            <div id="bagian" class="col-sm-8">
                                <select class="form-control select2" id="inputTransaksi" name="txtJabatan" required>
                                    <option value=""> -- Pilih </option>

                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Sub Jabatan
                            </label>
                            <div id="" class="col-sm-8">
                                <select class="form-control select2" id="txtSubJabatan" name="txtSubJabatan">
                                    <option value="" disabled selected> -- Pilih (saat ini belum tersedia)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Target </label>
                            <div class="col-sm-9">
                                <input type="number" id="inputTarget" name="txtTarget" placeholder="Input Target" readonly class="col-xs-12 col-sm-10" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Tersedia </label>
                            <div class="col-sm-9">
                                <input type="number" id="inputTersedia" name="txtTersedia" placeholder="Input Karyawan yang tersedia" readonly class="col-xs-12 col-sm-10" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Permintaan </label>
                            <div class="col-sm-9">
                                <input type="number" id="inputPermintaan" name="txtPermintaan" class="col-xs-12 col-sm-10" required="required" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Keterangan </label>
                            <div class="col-sm-9">
                                <textarea id="inputKeterangan" name="txtKeterangan" class="col-xs-12 col-sm-10" placeholder="Isi Jobdesk yang akan dikerjakan oleh TK/kary Baru, wajib diisi minimal 3 !!! pisahkan jobdesk dengan tanda koma ( , )" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Umur <small>(optional)</small> </label>
                            <div class="col-sm-9">
                                <input type="text" id="inputUmur" name="txtUmur" placeholder="Input Umur" class="col-xs-12 col-sm-10" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Pilih Pendidikan <small>(optional)</small>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" id="inputPemborong" name="comboPendidikan">
                                    <option value=""> -- Pilih Pendidikan </option>
                                    <option value="Semua"> Semua Jenjang Pendidikan </option>
                                    <?php foreach ($getPend as $rowPend) : ?>
                                        <option value="<?php echo $rowPend->Pendidikan; ?>"><?php echo $rowPend->Pendidikan;
                                                                                            ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Pilih Jurusan <small>(optional)</small>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" id="inputPemborong" name="comboJurusan">
                                    <option value=""> -- Pilih Jurusan </option>
                                    <option value="Semua"> Semua Jurusan </option>
                                    <?php foreach ($getJurs as $rowJurs) : ?>
                                        <option value="<?php echo $rowJurs->Jurusan; ?>"><?php echo $rowJurs->Jurusan;
                                                                                            ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Pilih Jenis Kelamin <small>(optional)</small>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" id="inputPemborong" name="comboJekel">
                                    <option value=""> -- Pilih Jenis Kelamin </option>
                                    <option value="Semua"> Semua </option>
                                    <option value="Pria"> Hanya Laki-laki </option>
                                    <option value="Wanita"> Hanya Perempuan </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Pilih Status Personal <small>(optional)</small>
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" id="inputStatus" name="comboStatus">
                                    <option value=""> -- Pilih Status Personal </option>
                                    <option value="Semua"> Semua </option>
                                    <?php foreach ($getSKwn as $rowSKwn) : ?>
                                        <option value="<?php echo $rowSKwn->StatusKawin; ?>"><?php echo $rowSKwn->StatusKawin;
                                                                                                ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-offset-3 col-md-9">
                                <input class="btn btn-sm btn-info btn_save" type="submit" name="simpan" value="Submit" id="simpandata">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </fieldset>
        </form>

    </div>
</div>

<script src="<?= base_url() ?>assets/js/jsadd/sweetalert.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/additional-methods.js"></script>

<script>
    function changePermintaan() {
        //var target  = parseInt(document.getElementById('inputTarget').value);
        //var sedia   = parseInt(document.getElementById('inputTersedia').value);
        // var minta   = 0;

        //minta = target-sedia;

        //document.getElementById('inputPermintaan').value = minta;
    }

    // $('#inputDept').change(function(e) {
    //     $.get('<?= base_url() ?>issue/get_idealkry', {
    //             'id': $(this).val()
    //         },
    //         function(res) {
    //             console.log(res);
    //             $('#inputTarget').val(res.ideal);
    //             $('#inputTarget').prop('readonly', true);
    //             $('#inputTersedia').val(res.real);
    //             $('#inputTersedia').prop('readonly', true);
    //             $('#inputPermintaan').val(res.ideal - res.real);
    //         }, 'json');
    // });

    $('#txtSubJabatan').change(function(e) {
        let inputDept = $('#inputDept').val()
        let inputSubJabatan = $('#txtSubJabatan option:selected').val().split(',')[0]
        let inputTargetBongkar = $('#inputTargetBongkar option:selected').val().split(',')[0]
        console.log({
            inputDept,
            inputSubJabatan,
            inputTargetBongkar
        });


        if (inputDept) {

            $.ajax({
                url: '<?= base_url() ?>issue/get_idealkry_new',
                dataType: 'json',
                data: {
                    id: inputDept,
                    subJabatanID: inputSubJabatan,
                    targetBongkar: inputTargetBongkar
                },
                type: 'get',
                // tampilkan loading di inputan sebelum kirim request
                beforeSend: function() {
                    $('#inputTarget').val('').prop('readonly', true).attr('placeholder', 'Loading...');
                    $('#inputTersedia').val('').prop('readonly', true).attr('placeholder', 'Loading...');
                    $('#inputPermintaan').val('').prop('readonly', false).attr('placeholder', 'Loading...');
                },
                success: function(res) {
                    console.log(res);
                    if (res.status === 200) {
                        $('#inputTarget').val(res.ideal).prop('readonly', true).removeAttr('placeholder');
                        $('#inputTersedia').val(res.real).prop('readonly', true).removeAttr('placeholder');
                        $('#inputPermintaan').val(res.ideal - res.real).prop('readonly', false).removeAttr('placeholder');

                    } else {
                        // $('#inputTarget').val('');
                        // $('#inputTarget').prop('readonly', true);
                        // $('#inputTersedia').val('');
                        // $('#inputTersedia').prop('readonly', true);
                        // $('#inputPermintaan').val('');

                        $('#inputTarget').val('').prop('readonly', true).removeAttr('placeholder');
                        $('#inputTersedia').val('').prop('readonly', true).removeAttr('placeholder');
                        $('#inputPermintaan').val('').prop('readonly', false).removeAttr('placeholder');
                        swal('Ideal TK Tidak ditemukan', 'Error', 'error');
                    }
                    // if (r.Err > 0) {
                    //     swal(r.Msg, 'Error', 'error');
                    // } else {
                    //     swal('Proses berhasil', 'success', 'success');
                    //     document.formborongan.submit();
                    // }
                },
                error: function(r) {
                    swal(r.Msg, 'Error', 'error');
                }
            });

        } else {
            swal('Silakan Pilih Departement Terlebih Dahulu !!!')
        }
    })

    $('#formkaryawan').validate({
        rules: {
            comboTansaksi: {
                required: true
            }
        },
        submitHandler: function(form) {

            Swal.fire({
                title: 'Apakah anda yakin ingin menyimpan transaksi ini??',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Simpan!'
            }).then((result) => {
                if (result.isConfirmed) {

                    var fm = $('#formkaryawan')[0];
                    var fd = new FormData(fm);
                    $.ajax({
                        url: '<?= base_url() ?>issue/cekfirstkar',
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: fd,
                        type: 'POST',
                        success: function(r) {
                            if (r.Err > 0) {
                                swal(r.Msg, 'Error', 'error');
                            } else {
                                swal('Proses berhasil', 'success', 'success')
                                document.formkaryawan.submit();
                            }
                        },
                        error: function(r) {
                            swal(r.Msg, 'Error', 'error');
                        }
                    });

                }
            })
        }
    });

    $(document).on('change', '#inputKeterangan', function() {
        let input = $(this).val();

        // Pisahkan berdasarkan koma, hilangkan spasi berlebih
        let kataArray = input.split(',').map(k => k.trim()).filter(k => k !== '');

        if (kataArray.length === 3 || kataArray.length >= 3) {
            // alert("Ada 3 kata");
            $('#simpandata').prop('disabled', false)
        } else {
            // alert("Jumlah kata bukan 3");
            $('#simpandata').prop('disabled', true)

        }
    })


    $(document).on('change', '#inputTargetBongkar', function() {
        let v = $(this).val();
        let idTargetBongkar = $('#inputTargetBongkar option:selected').val().split(',')[0];
        console.log('ini: ', v);

        updateTargetBongkar(1, idTargetBongkar)
        // if (v) {
        //     getDept()
        // }
    })

    function updateTargetBongkar(id, idTargetBongkar) {
        $.ajax({
            url: '<?= base_url() ?>issue/updateTargetBongkar',
            dataType: 'json',
            type: 'POST',
            data: {
                id: id,
                idTargetBongkar: idTargetBongkar
            },
            success: function(res) {
                if (res.status) {
                    swal('Target Bongkar berhasil diupdate', 'success', 'success');
                } else {
                    swal('Gagal mengupdate Target Bongkar', 'Error', 'error');
                }

            },
            error: function(r) {
                swal(r, 'Error', 'error');
            }
        });
    }

    function getDept() {
        $.ajax({
            url: '<?= base_url() ?>issue/getDeptPayroll',
            dataType: 'json',
            type: 'POST',
            success: function(res) {
                console.log(res);
                if (res.status == 200) {
                    $('#inputDept').html(`<option value="">-- Pilih</option>`)
                    $('#inputDept').append(res.data)
                } else {
                    $('#inputDept').html(`<option value="">-- Pilih</option>`)
                }

            },
            error: function(r) {

            }
        });

    }

    function getJabatanPayroll() {
        $.ajax({
            url: '<?= base_url() ?>issue/get_jabatan_payroll',
            dataType: 'json',
            type: 'POST',
            success: function(res) {
                console.log(res);
                if (res.status == 200) {
                    $('#inputTransaksi').html(res.data)
                } else {
                    $('#inputTransaksi').html(`<option value="">-- Pilih</option>`)
                }

            },
            error: function(r) {

            }
        });
    }

    $(document).on('change', '#inputDept', function() {
        let v = $(this).val();
        if (v) {
            getJabatanPayroll()
        }
    })

    function getSubJabatan(param = NULL) {
        let id = param.split(',')[0];
        console.log('id: ', id);

        $.ajax({
            url: '<?= base_url() ?>issue/get_sub_jabatan',
            dataType: 'json',
            type: 'POST',
            data: {
                idJabatan: id
            },
            success: function(res) {
                console.log(res);
                if (res.status == 200) {
                    $('#txtSubJabatan').html(`<option value="">-- Pilih</option>`)
                    $('#txtSubJabatan').append(res.data)
                } else {
                    $('#txtSubJabatan').html(`<option value="">-- Pilih</option>`)
                }

            },
            error: function(r) {

            }
        });
    }



    $(document).on('change', '#inputTransaksi', function() {
        let v = $(this).val();
        if (v) {
            getSubJabatan(v)
        }
    })
</script>