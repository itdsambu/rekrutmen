<form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_mst_harga'); ?>">
    <table class="table table-bordered" id="dataTables1">
        <div class="form-group">
            <label class="col-lg-2 control-label">Tanggal</label>
            <div class="col-sm-4">
                <input type="date" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d') ?>">
                <input type="hidden" name="txtItem" id="idItem" value="<?php echo $id_item; ?>">
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Pemborong</label>
            <div class="col-sm-4">
                <select class="form-control" name="txtPemborong" id="pemborong" onchange="CariSub()">
                    <?php if (count($_getDataPemborong) > 1) {
                        $selected = '';
                    } else {
                        $selected = 'selected';
                    } ?>
                    <option value="">- Pilih -</option>
                    <?php foreach ($_getDataPemborong as $pbr) {
                        echo "<option value='" . $pbr->IDPemborong . "' " . $selected . ">" . $pbr->Pemborong . "</option>";
                    } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label class="col-lg-2 control-label">Nama CV</label>
            <div class="col-sm-4" id="tblSub"></div>
        </div>
        <thead>
            <tr>
                <th style="text-align: center">No</th>
                <th style="text-align: center">Nama Item</th>
                <th style="text-align: center">Satuan</th>
                <th style="text-align: center">Kategori</th>
                <th style="text-align: center">Harga</th>
            </tr>
        </thead>
        <tbody id="tblItem">
            <tr>
                <td></td>
                <td class="text-center"></td>
                <td class="text-center"></td>
                <td></td>

            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td>
                    <button type="submit" class="btn btn-success"> Simpan </button>
                <td>
            </tr>
        </tfoot>

    </table>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables').dataTable();
        CariSub();
        var jmlData = "<?php echo count($_getDataSub); ?>";
        if (jmlData == 1) {
            // console.log("jalan langsung");
        }
    });

    function CariSub() {
        var pemborong = $('#pemborong').val();

        if (pemborong == '') {

        } else {
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PotonganBon/ajax_subPBR') ?>" + "/" + pemborong,
                success: function(msg) {
                    if (msg == '') {
                        alert('Tidak ada data');
                    } else {
                        $("#tblSub").html(msg);
                    }
                }
            });
        }
    }

    function Cariitem() {
        var id = $('#idItem').val();
        var pemborong = $('#pemborong').val();
        var subpemborong = $('#subpemborong').val();

        if (subpemborong == '') {

        } else {
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PotonganBon/ajax_modal') ?>" + "/" + id + "/" + pemborong + "/" + subpemborong,
                success: function(msg) {
                    if (msg == '') {
                        alert('Tidak ada data');
                    } else {
                        $("#tblItem").html(msg);
                    }
                }
            });
        }
    }
</script>