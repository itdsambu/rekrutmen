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
function format_rupiah($number)
{
    return number_format($number, 0, ",", ".");
}
?>
<link href="<?php echo base_url(); ?>assets/sweetalert2-11.3.6/dist/sweetalert2.min.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/sweetalertpabo/sweet.js"></script>
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">HAPUS POTONGAN BON</h4>
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
            <form class="form-horizontal" method="post" action="<?= base_url(); ?>PotonganBon/TransaksiAkhir_simpan?id=4500">
                <div class="widget-body">
                    <div class="widget-main">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Tanggal Transaksi</label>
                                    <div class="col-sm-4">
                                        <input type="date" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Pemborong</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="<?= $_getInfo->Pemborong; ?>" id="pemborong" readonly>
                                        <input type="hidden" name="txtPemborong" value="<?= $_getInfo->IDPemborong; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">CV Perusahaan</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" value="<?= $_getInfo->Perusahaan; ?>" id="sub-pemborong" readonly>
                                        <input type="hidden" name="txtSubPemborong" value="<?= $_getInfo->IDSubPemborong; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-lg-2 control-label">Nama Lengkap</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="txtNama" class="form-control" readonly value="<?= $_getInfo->Nama; ?>">
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
                                                <th class="text-center">Periode Gajian</th>
                                                <th class="text-center">CreatedBy</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 0; ?>
                                            <?php foreach ($_getDataDetail as $key => $detail) : ?>
                                                <tr>
                                                    <td>
                                                        <?= ++$no; ?>
                                                        <input type="hidden" name="txtHeaderID[]" value="<?= $detail->HeaderID; ?>">
                                                    </td>
                                                    <td><?= date('d/m/Y', strtotime($detail->PeriodeGajian)); ?></td>

                                                    <td>
                                                        <div class="text-left">
                                                            <?= $detail->CreatedBy; ?>
                                                        </div>
                                                        <div class="text-right smaller-80">
                                                            <?= $detail->CreatedDate ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="#" id="<?= $detail->HeaderID ?>" class="btn btn-minier btn-round btn-purple" onclick="viewDtlPotBon(this.id);"><i class="fa fa-search-plus"></i> Detail</a>
                                                        <a href="#" id="<?= $detail->HeaderID ?>" class="btn btn-minier btn-round btn-danger" onclick="viewHapus(this.id)"><i class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- <button type="submit" class="btn btn-sm btn-success">Simpan</button> -->
                        <a href="<?= base_url(); ?>PotonganBon/HapusDataBon" class="btn btn-sm btn-default">Kembali</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalInfo" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog modal-l">
        <div class="modal-content">
            <div class="modal-header">

            </div>
            <div id="lihat_detail">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="dataTables">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th class="text-center">Nama Item</th>
                                            <th class="text-center">Kategori</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Harga</th>
                                            <th class="text-center">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="isi">

                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function viewDtlPotBon(id) {
            // alert(id)
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    id
                },
                url: "<?php echo base_url('PotonganBon/ajaxDataDetail') ?>",
                success: function(msg) {

                    const rupiah = (number) => {
                        return new Intl.NumberFormat("id-ID", {
                            style: "currency",
                            currency: "IDR"
                        }).format(number);
                    }
                    // console.log(msg)
                    let data = ''
                    let grandTotal = 0
                    $.each(msg, function(i, content) {
                        grandTotal += content.Total
                        data += `<tr>
                    <td>${i+1}</td>
                    <td>${content.NamaItem}</td>
                    <td>${content.NamaKategori}</td>
                    <td>${content.Quantity}</td>
                    <td>${rupiah(content.Harga)}</td>
                    <td>${rupiah(content.Total)}</td>
                    </tr>`;
                        // console.log(content.NamaItem)

                    });
                    data += `
                    <tr>
                    <td colspan = '5' align='center'>Total</td>
                    <td>${rupiah(grandTotal)}</td>
                    </tr>`;


                    $("#isi").html(data)
                    $("#myModalInfo").modal("show")

                }
            });
        }

        const viewHapus = (id) => {
            let id_ = id
            // console.log(id_)
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log(id_)
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        data: {
                            id: id_
                        },
                        url: "<?php echo base_url('PotonganBon/HapusDataPotBon') ?>",
                        success: function(msg) {
                            Swal.fire({
                                title: 'Data Sudah Terhapus!!!',
                                text: "You won't be able to revert this!",
                                icon: 'success',
                                showCancelButton: false,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'OK!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })

                            console.log(msg)

                        },
                        error: function() {
                            Swal.fire(
                                'GAGALL!',
                                'Data tidak terhapus!',
                                'error'
                            )
                        }
                    });

                }
            })

        }
    </script>