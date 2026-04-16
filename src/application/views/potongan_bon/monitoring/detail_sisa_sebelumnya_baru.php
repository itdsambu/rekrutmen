<div class="widget-body">
    <div class="widget-main">
        <div class="row">
            <div class="form-horizontal">
                <div class="col-lg-12">
                    <?php foreach ($_getDataTrnHdr as $hdr) { ?>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Pemborong</label>
                            <div class="col-sm-5">
                                <input type="text" name="txtPemborong" class="form-control" value="<?php echo $hdr->Pemborong ?>" readonly>
                            </div>
                        </div>
                        <!-- <div class="form-group">
                            <label class="col-lg-2 control-label">Sub Pemborong</label>
                            <div class="col-sm-5">
                                <input type="text" name="txtSubPemborong" class="form-control" value="<?php echo $hdr->NamaSub ?>" readonly>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Perusahaan</label>
                            <div class="col-sm-5">
                                <input type="text" name="txtPerusahaan" class="form-control" value="<?php echo $hdr->Perusahaan ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">NIK</label>
                            <div class="col-sm-5">
                                <input type="text" name="txtNik" class="form-control" value="<?php echo $hdr->Nik ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Nama</label>
                            <div class="col-sm-5">
                                <input type="text" name="txtNama" class="form-control" value="<?php echo $hdr->Nama ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Bagian/Dept</label>
                            <div class="col-sm-5">
                                <input type="text" name="txtDept" class="form-control" value="<?php echo $hdr->BagianAbbr ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Sisa Sembako</label>
                            <div class="col-sm-5">
                                <input type="text" name="txtSisaSembako" class="form-control" value="
                            <?php
                            if (!empty($_getSisaSembako)) {
                                foreach ($_getSisaSembako as $get) {
                                    if ($get->FixNo == $hdr->Nofix) {
                                        echo "Rp." . number_format($get->SisaPotonganTKBaru, 0, ",", ".");
                                    }
                                }
                            } else {
                                echo "Rp.0";
                            }
                            ?>" readonly>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">Sisa Cicilan</label>
                            <div class="col-sm-5">
                                <input type="text" name="txtSisaCicilan" class="form-control" value="<?php
                                                                                                        if (!empty($_getSisaCicilan)) {
                                                                                                            foreach ($_getSisaCicilan as $key) {
                                                                                                                if ($key->FixNo == $hdr->Nofix) {
                                                                                                                    echo "Rp." . number_format($key->Sisa, 0, ",", ".");
                                                                                                                }
                                                                                                            }
                                                                                                        } else {
                                                                                                            echo "Rp.0";
                                                                                                        }
                                                                                                        ?>" readonly>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables').dataTable();
    });
</script>