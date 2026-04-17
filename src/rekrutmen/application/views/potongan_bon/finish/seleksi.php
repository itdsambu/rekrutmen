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
            <form class="form-horizontal" method="post" action="<?=base_url();?>PotonganBon/TransaksiAkhir_simpan?id=4500">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Tanggal Transaksi</label>
                                    <div class="col-sm-4">
                                        <input type="date" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d')?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Pemborong</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="<?=$_getInfo->Pemborong;?>" id="pemborong" readonly>
                                        <input type="hidden" name="txtPemborong" value="<?=$_getInfo->IDPemborong;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Sub Pemborong</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="<?=$_getInfo->Perusahaan;?>" id="sub-pemborong" readonly>
                                        <input type="hidden" name="txtSubPemborong" value="<?=$_getInfo->IDSubPemborong;?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">NIK</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="nik" id="nik" class="form-control" value="<?=$_getInfo->Nik;?>" readonly>
                                        <input type="hidden" name="txtNofix" id="nofix" class="form-control" value="<?=$_getInfo->FixNo;?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nama Lengkap</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtNama" class="form-control" readonly value="<?=$_getInfo->Nama;?>" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Bagian/Dept</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtDept" class="form-control" readonly="" value="<?=$_getInfo->BagianAbbr;?>">
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
                                            <th class="text-center">Periode Cicilan</th>
                                            <th class="text-cneter">Cicilan Ke</th>
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
                                        $no = 0;
                                        ?>
                                        <?php foreach ($_getSisaDetail as $key => $detail): ?>
                                            <tr>
                                                <td>
                                                    <?=++$no;?>
                                                    <input type="hidden" name="txtSisaID[]" value="<?=$detail->IDDtlAkhir;?>">
                                                    <input type="hidden" name="txtDetailID[]" value="<?=$detail->DetailID;?>">
                                                </td>
                                                <td><?=date('d/m/Y',strtotime($detail->Tanggal));?></td>
                                                <td>
                                                    Sisa <?=$detail->Type;?>
                                                    <input type="hidden" name="txtType[]" value="<?=$detail->Type;?>">
                                                </td>
                                                <td>
                                                    <?=$detail->NamaItem;?>
                                                    <input type="hidden" name="txtItemID[]" value="<?=$detail->ItemID;?>">
                                                </td>
                                                <td class="text-right">
                                                    <?=format_rupiah($detail->HargaFull);?>
                                                    <input type="hidden" name="txtHargaFull[]" value="<?=$detail->HargaFull;?>">
                                                </td>
                                                <td class="text-right">
                                                    <?=format_rupiah($detail->DP);?>
                                                    <input type="hidden" name="txtDP[]" value="<?=$detail->DP;?>">
                                                </td>
                                                <td class="text-right">
                                                    <?=$detail->Cicilan;?>
                                                    <input type="hidden" name="txtCicilan[]" value="<?=$detail->Cicilan;?>">
                                                </td>
                                                <td class="text-right">
                                                    <?php if($detail->Type == 'Cicilan'): ?>
                                                        <?=$detail->Cicilanke;?>
                                                        <input type="hidden" name="txtCicilanKe[]" value="<?=$detail->Cicilanke;?>">
                                                    <?php else: ?>
                                                        <input type="hidden" name="txtCicilanKe[]" value="">
                                                    <?php endif;?>
                                                </td>
                                                <td class="text-right">
                                                    <?=$detail->Quantity;?>
                                                    <input type="hidden" name="txtQuantity[]" value="<?=$detail->Quantity;?>">
                                                </td>
                                                <td>
                                                    <?=$detail->NamaSatuan;?>
                                                    <input type="hidden" name="txtSatuanID[]" value="<?=$detail->SatuanID;?>">
                                                </td>
                                                <td>
                                                    <?=$detail->NamaKategori;?>
                                                    <input type="hidden" name="txtKategoriID[]" value="<?=$detail->KategoriID;?>">
                                                </td>
                                                <td class="text-right">
                                                    <?php
                                                    $total += $detail->Sisa;
                                                    echo format_rupiah($detail->Sisa);
                                                    ?>
                                                    <input class="totalNilai" name="txtTotal[]" type="hidden" value="<?=$detail->Sisa;?>">
                                                </td>
                                                <td class="text-right">
                                                    <input class="realNilai form-control" name="txtReal[]" onkeyup="hitung(this);" type="number" min="0" max="<?=$detail->Sisa;?>"  value="<?=$detail->Sisa;?>" style="text-align: right;">
                                                </td>
                                                <td>
                                                    <input class="sisaNilai form-control" name="txtSisa[]" type="text" value="0" style="text-align: right;" readonly>
                                                    <input type="hidden" name="txtStatusSisa[]" value="1">
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php foreach ($_getDataDetail as $key => $detail): ?>
                                        <tr>
                                            <td>
                                                <?=++$no;?>
                                                <input type="hidden" name="txtDetailID[]" value="<?=$detail->DetailID;?>">
                                            </td>
                                            <td><?=date('d/m/Y',strtotime($detail->Tanggal));?></td>
                                            <td>
                                                <?=$detail->Type;?>
                                                <input type="hidden" name="txtType[]" value="<?=$detail->Type;?>">
                                            </td>
                                            <td>
                                                <?=$detail->NamaItem;?>
                                                <input type="hidden" name="txtItemID[]" value="<?=$detail->ItemID;?>">
                                            </td>
                                            <td class="text-right">
                                                <?=format_rupiah($detail->HargaFull);?>
                                                <input type="hidden" name="txtHargaFull[]" value="<?=$detail->HargaFull;?>">
                                            </td>
                                            <td class="text-right">
                                                <?=format_rupiah($detail->DP);?>
                                                <input type="hidden" name="txtDP[]" value="<?=$detail->DP;?>">
                                            </td>
                                            <td class="text-right">
                                                <?=$detail->Cicilan;?>
                                                <input type="hidden" name="txtCicilan[]" value="<?=$detail->Cicilan;?>">
                                            </td>
                                            <td class="text-right">
                                                <?php if($detail->Type == 'Cicilan'): ?>
                                                    <?=$detail->Cicilanke;?>
                                                    <input type="hidden" name="txtCicilanKe[]" value="<?=$detail->Cicilanke;?>">
                                                <?php else: ?>
                                                    <input type="hidden" name="txtCicilanKe[]" value="">
                                                <?php endif;?>
                                            </td>
                                            <td class="text-right">
                                                <?=$detail->Quantity;?>
                                                <input type="hidden" name="txtQuantity[]" value="<?=$detail->Quantity;?>">
                                            </td>
                                            <td>
                                                <?=$detail->NamaSatuan;?>
                                                <input type="hidden" name="txtSatuanID[]" value="<?=$detail->SatuanID;?>">
                                            </td>
                                            <td>
                                                <?=$detail->NamaKategori;?>
                                                <input type="hidden" name="txtKategoriID[]" value="<?=$detail->KategoriID;?>">
                                            </td>
                                            <td class="text-right">
                                                <?php
                                                $total += $detail->Total;
                                                echo format_rupiah($detail->Total);
                                                ?>
                                                <input class="totalNilai" name="txtTotal[]" type="hidden" value="<?=$detail->Total;?>">
                                            </td>
                                            <td class="text-right">
                                                <input class="realNilai form-control" name="txtReal[]" onkeyup="hitung(this);" type="number" min="0" max="<?=$detail->Total;?>"  value="<?=$detail==null?'0':$detail->Total;?>" style="text-align: right;">
                                            </td>
                                            <td>
                                                <input class="sisaNilai form-control" name="txtSisa[]" type="text" value="0" style="text-align: right;" readonly>
                                                <input type="hidden" name="txtStatusSisa[]" value="0">
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-right" colspan="11">Grand Total</th>
                                                <th class="text-right"><?=format_rupiah($total);?></th>
                                                <th class="text-right"><span id="total_real"><?=format_rupiah($total);?></span></th>
                                                <th class="text-right"><span id="total_sisa">0</span></th>
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