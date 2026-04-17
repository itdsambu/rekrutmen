<style>
    thead tr th {
        background-color: #d9edf7 !important;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>
<?php
function format_rupiah($number) {
    return number_format($number,0,",",".");
}
?>
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">TRANSAKSI AKHIR POTONGAN BON</h4>
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
            <form class="form-horizontal" method="post" action="<?=base_url();?>PotonganBon/TransaksiAkhir_update?id=4500">
                <input type="hidden" name="txtHeaderID" value="<?=$_getHeader->HeaderID;?>">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Tanggal Transaksi</label>
                                    <div class="col-sm-4">
                                        <input type="date" name="txtTanggal" class="form-control" value="<?php echo $_getHeader->Tanggal;?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Pemborong</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="<?=$_getHeader->Pemborong;?>" id="pemborong" readonly>
                                        <input type="hidden" name="txtPemborong" value="<?=$_getHeader->IDPemborong;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">CV Perusahaan</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="<?=$_getHeader->Perusahaan;?>" id="sub-pemborong" readonly>
                                        <input type="hidden" name="txtSubPemborong" value="<?=$_getHeader->IDSubPemborong;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">NIK</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="nik" id="nik" class="form-control" value="<?=$_getHeader->Nik;?>" readonly>
                                        <input type="hidden" name="txtNofix" id="nofix" class="form-control" value="<?=$_getHeader->FixNo;?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nama Lengkap</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtNama" class="form-control" readonly value="<?=$_getHeader->Nama;?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Bagian/Dept</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtDept" class="form-control" readonly="" value="<?=$_getHeader->BagianAbbr;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Periode</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtDept" class="form-control" readonly="" value="<?=($_periode == 1)?'Periode 1':'Periode 2'?>">
                                        <input type="hidden" name="txtPeriode" value="<?=$_periode;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped" id="dataTables">
                                        <thead>
                                        <tr>
                                            <th class="text-center"></th>
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Tipe</th>
                                            <th class="text-center">Nama Item</th>
                                            <th class="text-center">Harga (Rp.)</th>
                                            <th class="text-center">DP (Rp.)</th>
                                            <th class="text-center">Cicilan</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">Satuan</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center" style="min-width: 100px;">Realisasi</th>
                                            <th class="text-center" style="min-width: 100px;">Sisa</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $total = 0;
                                        $total_realisasi = 0;
                                        $total_sisa = 0;
                                        ?>
                                        <?php foreach ($_getDataDetail as $key => $detail): ?>
                                            <tr>
                                                <td>
                                                    <?=($key+1);?>
                                                    <input type="hidden" name="txtIDDtlAkhir[]" value="<?=$detail->IDDtlAkhir;?>">
                                                    <input type="hidden" name="txtIDDtlProses[]" value="<?=$detail->DetailID;?>">
                                                </td>
                                                <td><?=date('d/m/Y',strtotime($detail->Tanggal));?></td>
                                                <td>
                                                    <?=$detail->Type;?>
                                                    <input type="hidden" name="txtType[]" value="<?=$detail->Type;?>">
                                                </td>
                                                <td>
                                                    <?=$detail->NamaItem;?>
                                                </td>
                                                <td class="text-right">
                                                    <?=format_rupiah($detail->HargaFull);?>
                                                </td>
                                                <td class="text-right">
                                                    <?=format_rupiah($detail->DP);?>
                                                </td>
                                                <td class="text-right">
                                                    <?=$detail->Cicilan;?>
                                                </td>
                                                <td class="text-right">
                                                    <?=$detail->Quantity;?>
                                                </td>
                                                <td>
                                                    <?=$detail->NamaSatuan;?>
                                                </td>
                                                <td>
                                                    <?=$detail->NamaKategori;?>
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                    $total += $detail->Total;
                                                    echo format_rupiah($detail->Total);
                                                    ?>
                                                    <input class="totalNilai" name="txtTotal[]" type="hidden" value="<?=$detail->Total;?>">
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                    $total_realisasi += $detail->Realisasi;
                                                    ?>
                                                    <input class="realNilai form-control" name="txtReal[]" onkeyup="hitung(this);" type="number" min="0" max="<?=$detail->Realisasi;?>"  value="<?=$detail->Realisasi;?>" style="text-align: right;">
                                                </td>
                                                <td>
                                                    <?php
                                                    $total_sisa += $detail->Sisa;
                                                    ?>
                                                    <input class="sisaNilai form-control" name="txtSisa[]" type="text" value="<?=$detail->Sisa;?>" style="text-align: right;" readonly>
                                                    <input type="hidden" name="txtStatusSisa[]" value="<?=$detail->StatusSisa;?>">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th class="text-right" colspan="10">Grand Total</th>
                                            <th class="text-right"><?=format_rupiah($total);?></th>
                                            <th class="text-right"><span id="total_real"><?=format_rupiah($total_realisasi);?></span></th>
                                            <th class="text-right"><span id="total_sisa"><?=format_rupiah($total_sisa);?></span></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success">Simpan</button>
                        <a href="<?=base_url();?>PotonganBon/TransaksiAkhir?id=4500" class="btn btn-sm btn-default">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function hitung(el)
    {
        var tr = $(el).closest('tr');
        var total = tr.find('.totalNilai');
        var sisa = tr.find('.sisaNilai');

        var nilai_sisa = total.val() - $(el).val();

        sisa.val(nilai_sisa);

        var total_real = 0;
        $('.realNilai').each(function(){
            total_real += parseInt($(this).val());
        });
        $('#total_real').text(total_real.toLocaleString('id-ID'));

        var total_sisa = 0;
        $('.sisaNilai').each(function(){
            total_sisa += parseInt($(this).val());
        });
        $('#total_sisa').text(total_sisa.toLocaleString('id-ID'));

    }
</script>