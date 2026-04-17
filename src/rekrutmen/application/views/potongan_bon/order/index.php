<link rel="stylesheet" href="<?php echo base_url() ?>assets/class/select2.css" />
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"></h4>
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
                    echo "<strong>Gagal !!!</strong> Data Sudah Pernah Diregistrasi..!!";
                    echo "</div>";
                } ?>

            </div>
            <div class="form-horizontal">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-lg-1 control-label">NIK</label>
                                    <div class="col-sm-3">
                                        <input type="text" name="txtNik" id="nik" class="form-control" onchange="send_otp();" placeholder="Silahkan Masukkan Nik Anda !!">
                                    </div>
                                </div>
                                <div id="otpid">

                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                            <div id="listid">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<script type="text/javascript">
    function send_otp() {
        var nik = $('#nik').val();

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('Order/send_otp') ?>" + "/" + nik,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {
                    $("#otpid").html(msg);
                }
            }
        });
    }

    function load_halaman_order() {
        // var otp   = $("#otp").val();
        // var telid = $('#telid').val();
        var pbrid = $('#pemborongid').val();
        var sub = $('#SubPemborong').val();
        var nofix = $('#nofix').val();

        // alert(nofix);

        $('#listid').html('<p style="text-align:center;"><img src="<?php echo base_url(); ?>assets/images/8REG.gif"></p>');

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('Order/load_halaman_order') ?>" + "/" + pbrid + "/" + sub + "/" + nofix,
            success: function(msg) {
                if (msg == '') {
                    alert('Tidak ada data');
                } else {
                    $("#listid").html(msg);
                }
            }
        });
    }
</script>