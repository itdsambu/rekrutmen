<style>
    .ui-autocomplete {
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 99999 !important;
    }

    /* #viewModalInfo .modal-body {
        position: relative;
    }

    .modal {
        transform: none !important;
    } */

    /* Hilangkan transform agar offset jQuery UI akurat */
    /* .modal.show .modal-dialog {
        transform: none !important;
    } */



    #autocomplete-container {
        position: absolute;
        top: 100%;
        /* tepat di bawah input */
        left: 0;
        /* sejajar kiri input */
        width: 100%;
        /* sama lebar parent (input) */
        z-index: 2000;
    }
</style>

<div class="page-header">
    <h1>
        MONITOR
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            List Pekerja yang bermasalah
        </small>
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Salmonella Carrier
        </small>
    </h1>
</div>
<!-- <div id="autocomplete-container"></div> -->



<div class="widget-body">
    <div class="widget-main">

    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h5 class="widget-title">Salmonella Carrier</h5>
                <div class="widget-toolbar">
                    <button class="btn btn-minier btn-primary" id="add-modal-button">
                        <i class="ace-icon fa fa-plus"></i> Tambah
                    </button>

                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="table-responsive">
                        <table id="dataTablesTK" class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>NAMA</th>
                                    <th>NO KTP</th>
                                    <th>TANGGAL LAHIR</th>
                                    <th>JENIS KELAMIN</th>
                                    <th>NAMA IBU KANDUNG</th>
                                    <th>Perusahaan / CV</th>
                                    <th>PEMBORONG</th>
                                    <th>SUB PEMBORONG</th>
                                    <th>Keterangan</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dinamiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"> Informasi Tenaga Kerja Blacklist</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="iddetail" id="inputdetail">
                <div id="detail" class="well">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalToExcel" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="titleExcel"> Export to Excel</h4>
            </div>
            <div class="modal-body">
                <div class="center">
                    <form class="form-horizontal" id="formExportExcel" action="<?php echo site_url('toExcel/downloadExcelTenaker'); ?>" method="POST">
                        <div class="form-group">
                            <label class="col-sm-5 control-label right" for="inputDataExport">Data export</label>
                            <select name="selDataExport" id="inputDataExport" class="col-md-3">
                                <option value="tenaker">Tenaga Kerja</option>
                            </select>
                        </div>
                        <div class="center">
                            <button type="submit" class="btn btn-mini btn-success">
                                <i class="ace-icon fa fa-download"></i> Download
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ##################################################### MODAL ADD ##################################################### -->

<!-- Modal View -->
<div class="modal fade" id="viewModalInfo" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Data</h4>
            </div>
            <div class="modal-body">
                <form id="formAdd" class="form-horizontal">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="headerid" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="headerid" name="iheaderid" placeholder="Masukkan NIK">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama" class="form-label">Nama</label>
                            <!-- <input type="text" class="form-control" id="nama" name="inama" placeholder="Masukkan Nama"> -->
                            <div class="autocomplete-wrapper" style="position: relative;">
                                <input type="text" class="form-control" id="nama" name="inama" placeholder="Masukkan Nama" autocomplete="off">
                                <div id="autocomplete-container"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="noktp" class="form-label">No. KTP</label>
                            <input type="text" class="form-control" id="noktp" name="iktp" placeholder="Masukkan No. KTP" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                            <input type="text" class="form-control" id="tgl_lahir" name="itgl_lahir" placeholder="Masukkan Tanggal Lahir" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="cv_nama" class="form-label">Perusahaan</label>
                            <input type="text" class="form-control" id="cv_nama" name="icv_nama" placeholder="Masukkan Perusahaan" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="pemborong" class="form-label">Pemborong</label>
                            <input type="text" class="form-control" id="pemborong" name="ipemborong" placeholder="Masukkan Pemborong" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="sub_pemborong" class="form-label">Sub Pemborong</label>
                            <input type="text" class="form-control" id="sub_pemborong" name="isub_pemborong" placeholder="Masukkan Sub Pemborong" readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nama_ibu" class="form-label">Nama Ibu</label>
                            <input type="text" class="form-control" id="nama_ibu" name="inama_ibu" placeholder="Masukkan Nama Ibu" readonly>
                            <input type="hidden" class="form-control" id="daerah_asal" name="idaerah_asal">
                            <input type="hidden" class="form-control" id="suku" name="isuku">
                            <input type="hidden" class="form-control" id="id_pemborong" name="iid_pemborong">
                            <input type="hidden" class="form-control" id="id_sub_pemborong" name="iid_sub_pemborong">
                            <input type="hidden" class="form-control" id="jenis_kelamin" name="ijenis_kelamin">
                        </div>
                        <div class="col-md-6">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="iketerangan" id="keterangan" class="form-control" placeholder="Masukkan Keterangan"></textarea>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                <button type="button" id="btnSimpan" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>


<!-- ##################################################### END MODAL ADD ##################################################### -->
<script src="<?php echo base_url(); ?>assets/js/buttons/jquery.dataTables.min.js"></script>

<script type="text/javascript" src="<?php echo base_url(); ?>assets/jqv/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/jQuery/jquery-ui.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        ///////////////////////////////////////////////////
        const site_url = '<?= site_url() ?>';
        const base_url = '<?= base_url() ?>';

        var table = $("#dataTablesTK").DataTable({
            processing: false,
            responsive: true,
            order: [],
            serverSide: true,
            // ordering: false // Menonaktifkan pengurutan
            ajax: {
                url: base_url + "blacklist/show",
                type: "POST",
                data: function(d) {
                    // d.selTenaker = $('#selTenaker').val();
                    // d.start_date = $('#start_date').val();
                    // d.end_date = $('#end_date').val();
                },
                beforeSend: function() {
                    // $('#loading').show(); // Tampilkan loading spinner sebelum request
                },
                complete: function() {
                    // $('#loading').hide(); // Sembunyikan loading spinner setelah request selesai                
                }

            },
            orderMulti: false, // Hanya menyortir data di halaman saat ini
            language: {
                // url: base_url + 'assets/stexo/plugins/datatables/language/id.json',
                searchPlaceholder: "Cari..."
            },
            lengthMenu: [5, 10, 25, 41, 50, 100],
            // Mengatur tampilan default menjadi 10
            pageLength: 5,

            columnDefs: [{
                    type: 'date-eu',
                    targets: 3
                }, // Mengatur kolom indeks ke-4 (indeks dimulai dari 0) sebagai tipe data tanggal

                {
                    targets: [3, 5], // indeks kolom pertama
                    orderable: false // membuat kolom pertama tidak dapat diurutkan
                }
            ]
        });
    })

    $(document).on('click', '#add-modal-button', function() {
        $('#viewModalInfo').modal('show');
    })

    $(document).on('change', '#headerid', function() {
        var id = $(this).val().trim();
        console.log(id);

        $.ajax({
            url: "<?php echo site_url('blacklist/getTenaker'); ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(data) {
                console.log(data);

                if (data.status == 200) {
                    var i = data.data[0]

                    $('#nama').val(i.Nama);
                    $('#noktp').val(i.No_Ktp);
                    $('#tgl_lahir').val(formatTanggal(i.Tgl_Lahir));
                    $('#cv_nama').val(i.CVNama);
                    $('#pemborong').val(i.Pemborong);
                    $('#sub_pemborong').val(i.SubPemborong);
                    $('#nama_ibu').val(i.NamaIbuKandung);
                    $('#daerah_asal').val(i.Daerah_Asal);
                    $('#suku').val(i.Suku);
                    $('#id_pemborong').val(i.IDPemborong);
                    $('#id_sub_pemborong').val(i.IDSubPemborong);
                    $('#jenis_kelamin').val(i.Jenis_Kelamin);

                } else {

                    $('#nama').val('');
                    $('#noktp').val('');
                    $('#tgl_lahir').val('');
                    $('#cv_nama').val('');
                    $('#pemborong').val('');
                    $('#sub_pemborong').val('');
                    $('#nama_ibu').val('');
                    $('#daerah_asal').val('');
                    $('#suku').val('');
                    $('#id_pemborong').val('');
                    $('#id_sub_pemborong').val('');
                    $('#jenis_kelamin').val('');
                }
            }
        })
    })

    $(document).on('click', '#btnSimpan', function() {
        var serializedData = $('#formAdd').serialize();

        Swal.fire({
            title: "Yakin nih?",
            text: "Aksi ini tidak bisa di-undo, lho!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Simpan!"
        }).then((result) => {
            if (result.isConfirmed) {
                handleSaveData(serializedData);
            }
        });
    })

    function handleSaveData(data) {

        $.ajax({
            url: "<?php echo site_url('blacklist/saveSalmonellaCarrier'); ?>",
            method: "POST",
            data: data,
            dataType: "JSON",
            success: function(data) {
                console.log(data);
                if (data.status == 200) {
                    $('#viewModalInfo').modal('hide');
                    $('#formAdd').trigger("reset");
                    Swal.fire({
                        title: "Berhasil!",
                        text: data.message,
                        icon: "success"
                    });

                    setTimeout(() => {
                        // notifSalmonella()
                    }, 1000)
                } else if (data.status == 400) {
                    Swal.fire({
                        title: "Gagal!",
                        text: data.message,
                        icon: "error"
                    })
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: data.message,
                        icon: "error"
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat menyimpan data.",
                    icon: "error"
                });
            }

        })
        $('#viewModalInfo').modal('hide');

        setTimeout(() => {
            $("#dataTablesTK").DataTable().ajax.reload();
        }, 1000);

    }

    $(document).on('click', '.cancel', function() {
        var id = $(this).data('id');
        console.log(id);

        if (id.trim != '') {
            Swal.fire({
                title: "Yakin nih?",
                text: "Aksi ini tidak bisa di-undo, lho!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Keluarkan!"
            }).then((result) => {
                if (result.isConfirmed) {
                    handleUpdateData(id);
                }
            });
        }
    })

    function handleUpdateData(id) {
        $.ajax({
            url: "<?php echo site_url('blacklist/updateSalmonellaCarrier'); ?>",
            method: "POST",
            data: {
                id: id
            },
            dataType: "JSON",
            success: function(data) {
                // console.log(data);
                if (data.status == 200) {
                    Swal.fire({
                        title: "Berhasil!",
                        text: data.message,
                        icon: "success"
                    });
                } else if (data.status == 400) {
                    Swal.fire({
                        title: "Gagal!",
                        text: data.message,
                        icon: "error"
                    })
                } else {
                    Swal.fire({
                        title: "Gagal!",
                        text: data.message,
                        icon: "error"
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: "Gagal!",
                    text: "Terjadi kesalahan saat mengeluarkan data.",
                    icon: "error"
                });
            }
        })

        setTimeout(() => {
            $("#dataTablesTK").DataTable().ajax.reload();
        }, 1000);
    }



    function formatTanggal(tanggal) {
        // Membuat objek Date dari string tanggal
        const dateObj = new Date(tanggal);

        // Mendapatkan hari, bulan, dan tahun
        const day = String(dateObj.getDate()).padStart(2, '0'); // Tambahkan nol jika kurang dari 10
        const month = String(dateObj.getMonth() + 1).padStart(2, '0'); // Bulan dimulai dari 0
        const year = dateObj.getFullYear();

        // Mengembalikan format dd-mm-yyyy
        return `${day}-${month}-${year}`;
    }

    $(document).ready(function() {
        console.log("jQuery Ready"); // DEBUG
        $("#nama").autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "<?= site_url('blacklist/search-nama') ?>", // Ganti dengan endpoint pencarian
                    type: "POST",
                    dataType: "json",
                    data: {
                        term: request.term,

                    },
                    success: function(data) {
                        console.log('data: ', data);

                        // response(data); // Format: [{ label: "Nama", value: "Nama", id: 123 }, ...]
                        response($.map(data, function(item) {
                            return {
                                label: item.value + ' (' + item.headerid + ')', // tampil di list
                                value: item.value,
                                headerid: item.headerid,
                                tgl_lahir: item.tgl_lahir,
                                pemborong: item.pemborong,
                                perusahaan: item.perusahaan,
                                nama_ibu: item.nama_ibu,
                                sub_pemborong: item.sub_pemborong,
                                no_ktp: item.no_ktp,
                                daerah_asal: item.daerah_asal,
                                suku: item.suku,
                                id_pemborong: item.id_pemborong,
                                id_sub_pemborong: item.id_sub_pemborong,
                                jenis_kelamin: item.jenis_kelamin,
                            };
                        }));
                    }
                });
            },
            minLength: 2,
            select: function(event, ui) {
                // Jika user pilih salah satu, isi input dengan nama
                $("#nama").val(ui.item.value);
                $("input[name='iheaderid']").val(ui.item.headerid);
                $("input[name='itgl_lahir']").val(ui.item.tgl_lahir);
                $("input[name='ipemborong']").val(ui.item.pemborong);
                $("input[name='inama_ibu']").val(ui.item.nama_ibu);
                $("input[name='iktp']").val(ui.item.no_ktp);
                $("input[name='icv_nama']").val(ui.item.pemborong);
                $("input[name='isub_pemborong']").val(ui.item.sub_pemborong);
                $("input[name='idaerah_asal']").val(ui.item.daerah_asal);
                $("input[name='isuku']").val(ui.item.suku);
                $("input[name='iid_pemborong']").val(ui.item.id_pemborong);
                $("input[name='iid_sub_pemborong']").val(ui.item.id_sub_pemborong);
                $("input[name='ijenis_kelamin']").val(ui.item.jenis_kelamin);


                return false;
            },

            appendTo: "#autocomplete-container",
            position: {
                my: "left top+2",
                at: "left bottom",
                of: "#nama"
            }

        });

        // function positionAutocompleteContainer() {
        //     var $input = $("#nama");
        //     var offset = $input.offset();
        //     var height = $input.outerHeight();

        //     $("#autocomplete-container").css({
        //         position: "absolute",
        //         top: offset.top + height - 50, // tepat di bawah input
        //         left: offset.left - 215,
        //         width: $input.outerWidth(), // sama lebar dengan input
        //         zIndex: 2000
        //     });
        // }

        // $("#nama").on("focus input", function() {
        //     positionAutocompleteContainer();
        // });

        $("#nama").on("keyup", function() {
            // ambil teks lalu ubah ke huruf besar
            this.value = this.value.toUpperCase();
        });
    })
</script>