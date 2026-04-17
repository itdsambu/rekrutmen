<link rel="stylesheet" href="<?= base_url() ?>assets/css/sweetalert.css" />

<div class="page-header">
    <h1>
        TRANSAKSI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Issue Permintaan Borongan
        </small>
    </h1>
</div><!-- /.page-header -->

<div class="row">
    <div class="col-xs-12">
        <!-- PAGE CONTENT BEGINS -->

        <!-- Design Disini -->
        <?php $att = array('class' => 'form-horizontal', 'role' => 'form', 'name' => 'formborongan', 'id' => 'formborongan');
        echo form_open('issue/saveIssue/borongan', $att); ?>
        <fieldset>

            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title">Input Issue Borongan</h4>

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
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Pemborong
                            </label>
                            <div class="col-sm-9">
                                <input type="text" id="inputPemborong" name="txtPemborong" value="ALL PEMBORONG" class="col-xs-12 col-sm-10" readonly="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Pilih Departemen
                            </label>
                            <div class="col-sm-8">
                                <select class="form-control" id="inputDept" name="comboDept" required>
                                    <option value=""> -- Pilih </option>
                                    <?php foreach ($getDept as $rowDept) : ?>
                                        <option value="<?php echo $rowDept->IDDept; ?>"><?php echo $rowDept->DeptAbbr; ?></option>
                                        <!-- <option value="<?php //echo $rowDept->IDBagian; 
                                                            ?>"><?php //echo $rowDept->BagianAbbr; 
                                                                ?></option> -->
                                        <!-- <option value="<?php // echo $rowDept->IDDept; 
                                                            ?>"><?php //echo $rowDept->BagianAbbr; 
                                                                ?></option> -->
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Jenis Pekerjaan
                            </label>
                            <div id="bagian" class="col-sm-8">
                                <select class="form-control" id="inputTransaksi" name="comboTansaksi" required>
                                    <option value="0"> -- Pilih </option>
                                </select>
                            </div>
                        </div>
                        <script type="text/javascript">
                            $("#inputDept").change(function() {
                                var selectValues = $("#inputDept").val();
                                if (selectValues === 0) {
                                    var msg = '<select class="form-control" id="inputTransaksi" name="comboTansaksi"><option value=""> -- Pilih </option></select>';
                                    $('#bagian').html(msg);
                                } else {
                                    var dept = {
                                        dept: $("#inputDept").val()
                                    };
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo site_url('issue/getBagian') ?>",
                                        data: dept,
                                        success: function(msg) {
                                            $('#bagian').html(msg);
                                        }
                                    });
                                }
                            });
                        </script>
                        <?php // if ($this->session->userdata('userid') == "KIKI") { 
                        ?>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Jabatan
                            </label>
                            <div id="bagian" class="col-sm-8">
                                <select class="form-control" id="txtJabatan" name="txtJabatan" required>
                                    <option value="">-- Pilih</option>
                                    <?php foreach ($_getJabatan as $row) : ?>
                                        <option value="<?php echo $row->IDJabatan . ',' . $row->Jabatan ?>" data-id-jabatan="<?= $row->IDJabatan ?>"><?php echo $row->Jabatan; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Sub Jabatan
                            </label>
                            <div id="bagian" class="col-sm-8">
                                <select class="form-control" id="txtSubJabatan" name="txtSubJabatan" required>
                                    <option value="">-- Pilih</option>
                                </select>
                            </div>
                        </div>
                        <?php // } 
                        ?>

                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Target </label>
                            <div class="col-sm-9">
                                <input type="number" id="inputTarget" name="txtTarget" placeholder="Input Target" class="col-xs-12 col-sm-10" required="required" readonly />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">
                                Tersedia </label>
                            <div class="col-sm-9">
                                <input type="number" id="inputTersedia" name="txtTersedia" placeholder="Input Karyawan yang tersedia" class="col-xs-12 col-sm-10" readonly required="required" />
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
                                <textarea id="inputKeterangan" name="txtKeterangan" class="col-xs-12 col-sm-10"></textarea>
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
                                <select class="form-control" id="inputPendidikan" name="comboPendidikan">
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
                                <select class="form-control" id="inputJurusan" name="comboJurusan">
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
                                <select class="form-control" id="inputjeniskelamin" name="comboJekel">
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
                                <input class="btn btn-sm btn-info" type="submit" name="simpan" value="Submit" id="simpandata">
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
        /*
                var target  = parseInt(document.getElementById('inputTarget').value);
                var sedia   = parseInt(document.getElementById('inputTersedia').value);
                var minta   = 0;
                
                minta = target-sedia;
                
                document.getElementById('inputPermintaan').value = minta;*/
    }

    $('#inputDept').change(function(e) {
        $.get('<?= base_url() ?>issue/get_idealbor', {
                'id': $(this).val()
            },
            function(res) {
                console.log(res);
                // $('#inputTarget').val(res.ideal);
                // $('#inputTarget').prop('readonly', true);
                // $('#inputTersedia').val(res.real);
                // $('#inputTersedia').prop('readonly', true);
                // $('#inputPermintaan').val(res.ideal - res.real);
            }, 'json');
    });

    $('#inputDept').change(function(e) {
        let q = $(this)
        let idDept = q.val()
        if (idDept) {
            $.ajax({
                url: '<?= base_url() ?>issue/get_jabatan',
                dataType: 'json',
                data: {
                    id: idDept,
                },
                type: 'POST',

                success: function(res) {
                    console.log(res);
                    if (res.status == 200) {
                        $('#txtJabatan').html(res.data)
                    } else {
                        // $('#txtJabatan').html(`<option value="">-- Pilih</option>`)
                        // $('#txtJabatan').html(`Jabatan dan subjabatan tidak ada di payboro`)
                    }

                },
                error: function(r) {

                }
            });
        }

    });

    $('#txtSubJabatan').change(function(e) {
        let inputDept = $('#inputDept').val()
        console.log('sub :', $('#txtSubJabatan option:selected').val().split(',')[0]);

        let txtSubJabatan = $('#txtSubJabatan option:selected').val().split(',')[0]
        if (inputDept && txtSubJabatan) {

            $.ajax({
                url: '<?= base_url() ?>issue/get_idealbor_',
                dataType: 'json',
                data: {
                    id: inputDept,
                    subJabatanID: txtSubJabatan,
                },
                type: 'POST',
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

    $('#formborongan').validate({
        rules: {
            comboTansaksi: {
                required: true
            }
        },
        submitHandler: function(form) {
            var fm = $('#formborongan')[0];
            var fd = new FormData(fm);
            $.ajax({
                url: '<?= base_url() ?>issue/cekfirstbor',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: fd,
                type: 'POST',
                success: function(r) {
                    console.log(r);
                    if (r.Err > 0) {
                        swal(r.Msg, 'Error', 'error');
                    } else {
                        swal('Proses berhasil', 'success', 'success');
                        document.formborongan.submit();
                    }
                },
                error: function(r) {
                    swal(r.Msg, 'Error', 'error');
                }
            });
        }

    })

    /*

    $('#simpandata').on('click',function(e){
        e.preventDefault();

       

        var fm = $('#formborongan')[0];
        var fd = new FormData(fm);
        $.ajax({
            url:'<?= base_url() ?>issue/cekfirstbor',
            dataType:'json',
            cache:false,
            contentType:false,
            processData:false,
            data:fd,
            type:'POST',
            success: function(r){
                console.log(r); 
                if(r.Err > 0){
                    swal(r.Msg,'Error','error');
                }else{                   
                    swal('Proses berhasil','success','success');
                    document.formborongan.submit();
                }
            },
            error: function(r){
                swal(r.Msg,'Error','error');
            }
        });  
    })
    */

    $(document).on('change', '#txtJabatan', function() {
        let q = $(this);
        let idJabatan = $(this).find(':selected').data('id-jabatan');
        let jabatanName = $(this).find(':selected').val();
        let dept = $('#inputDept option:selected').val()
        let deptAbbr = $('#inputDept option:selected').text()
        // console.log('id jabatan :', idJabatan);
        console.log(dept);
        if (dept != '' && idJabatan != '') {
            $.ajax({
                url: "<?php echo site_url('Issue/getSubJabatan'); ?>",
                method: "POST",
                data: {
                    dept: dept,
                    idJabatan: idJabatan,
                },
                dataType: "JSON",
                success: function(data) {
                    console.log('data :', data);

                    if (data.status == 200) {
                        $('#txtSubJabatan').html(data.data)
                    } else {
                        alert(`Untuk jabatan ${jabatanName.split(',')[1]} dengan departemen ${deptAbbr}, Sub Jabatan Tidak Ditemukan di Program Payboro `)
                        q.val('')
                        $('#inputTarget').val('')
                        $('#inputTersedia').val('')
                        $('#inputPermintaan').val('')
                        $('#txtSubJabatan').html('<option value="">-- Pilih</option>')
                    }

                }
            })

        } else {
            alert('Silakan pilih Dept terlebih dahulu !!')
        }


    })
</script>