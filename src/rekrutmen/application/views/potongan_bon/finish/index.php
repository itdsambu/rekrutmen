
<!-- <link rel="stylesheet" href="<?php echo base_url()?>assets/class/select2.css"/> -->
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">TRANSAKSI POTONGAN PEMBORONG</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <br>
            <div class="col-lg-12">
                <?php if($this->input->get('msg') == "success"){
                    echo "<div class='alert alert-success'>";
                    echo "<strong>Sukses !!!</strong> Data berhasil di Simpan.";
                    echo "</div>";
                }elseif($this->input->get('msg') == "failed"){
                    echo "<div class='alert alert-danger'>";
                    echo "<strong>Gagal !!!</strong> Data Sudah Pernah Diregistrasi..!!";
                    echo "</div>";
                }?>

            </div>
            <form class="form-horizontal" role="form" method="POST" action="#">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Pemborong</label>
                                    <div class="col-sm-4">
                                        <select onchange="ajaxCariSubPemborong();" class="form-control" name="txtPemborong" id="pemborong">
                                            <option value="">- Pilih -</option>
                                            <?php foreach($_getDataPemborong as $pbr){
                                                echo "<option value='".$pbr->IDPemborong."'>".$pbr->Pemborong."</option>";
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">CV Perusahaan</label>
                                    <div class="col-sm-4">
                                        <select id="select-sub-pemborong" name="txtSubPemborong" class="form-control" required>
                                            <option value="">-- Pilih Pemborong Terlebih Dulu --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Periode</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="txtPeriode" id="periode">
                                            <option value="">- Pilih -</option>
                                            <option value="1">Periode 1</option>
                                            <option value="2">Periode 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Bulan</label>
                                    <div class="col-lg-4">
                                        <select class="form-control" name="txtBulan" id="bulan">
                                            <?php
                                            $b = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                            $a = 1;
                                            for($i=0; $i<12; $i++){
                                                if((date('n')-1) == $i){
                                                    echo "<option value=".$a." selected>".$b[$i]."</option>";
                                                }else{
                                                    echo "<option value=".$a.">".$b[$i]."</option>";
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
                                            <?php for($i=date('Y')-1;$i<=(date('Y')+2);$i++){
                                                if($i==date('Y')){ ?>
                                                    <option value="<?php echo $i; ?>" selected><?php echo $i; ?></option>
                                                <?php }else{ ?>
                                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                                <?php }} ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label"></label>
                                    <div class="col-sm-4">
                                        <a href="#" class="btn btn-sm btn-success" onclick="ajaxSearchData();"><i class="fa fa-search"></i> Cari</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive" id="listid">
                                    <table class="table table-bordered" id="dataTables">
                                        <thead>
                                        <tr>
                                            <th class="text-center" style="background-color: #d9edf7;">No.</th>
                                            <th class="text-center" style="background-color: #d9edf7;">NIK</th>
                                            <th class="text-center" style="background-color: #d9edf7;">Nama Lengkap</th>
                                            <th class="text-center" style="background-color: #d9edf7;">Dept</th>
                                            <th class="text-center" style="background-color: #d9edf7;">Total</th>
                                            <th class="text-center" style="background-color: #d9edf7;">Total Realisasi</th>
                                            <th class="text-center" style="background-color: #d9edf7;">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
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

        <?php if($_searchHistory): ?>
            $('#pemborong').val(<?=$_searchHistory['ajax_pbr'];?>);
            $('#periode').val(<?=$_searchHistory['ajax_periode'];?>);
            $('#bulan').val(<?=$_searchHistory['ajax_bulan'];?>);
            $('#tahun').val(<?=$_searchHistory['ajax_tahun'];?>);
            ajaxCariSubPemborong();
        <?php endif;?>
    });

    var sekali = true;

    function ajaxCariSubPemborong()
    {
        var idPbr = $('#pemborong').val();

        // Cek apakah pemborong diisi atau tidak
        if(idPbr){
            $.ajax({
                url : '<?=base_url();?>PotonganBon/ajaxGetSubPemborong/'+idPbr,
                dataType : 'html'
            }).done(function(response){
                $('#select-sub-pemborong').html(response);
                <?php if($_searchHistory): ?>
                    if(sekali == true) {
                        $('#select-sub-pemborong').val(<?=$_searchHistory['ajax_sub_pbr'];?>);
                        ajaxSearchData();
                        sekali = false;
                    }
                <?php endif;?>
            });
        }else{
            $('#select-sub-pemborong').html("<option value=''>-- Pilih Pemborong Terlebih Dahulu --</option>")
        }
    }

    function ajaxSearchData(){
        var pbr     = $('#pemborong').val();
        var subpbr  = $('#select-sub-pemborong').val();
        var periode = $('#periode').val();
        var bln     = $('#bulan').val();
        var thn     = $('#tahun').val();

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_data_transaksi');?>",
            data : {
              ajax_pbr : pbr,
              ajax_sub_pbr : subpbr,
              ajax_periode : periode,
              ajax_bulan : bln,
              ajax_tahun : thn
            },
            success: function(msg){
                if(msg == ''){
                    alert('Tidak ada data');
                }
                else{
                    $("#listid").html(msg);
                }
            }
        });
    }
</script>

