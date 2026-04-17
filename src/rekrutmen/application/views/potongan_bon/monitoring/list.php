<table class="table table-bordered" id="dataTables1">
    <thead>
        <tr>
            <th rowspan="2" class="text-center" style="background-color: #d9edf7;">No.</th>
            <!-- <th rowspan="2" class="text-center" style="background-color: #d9edf7;">FixNoTenaga_kerja</th> -->
            <th rowspan="2" class="text-center" style="background-color: #d9edf7;">NIK</th>
            <th rowspan="2" class="text-center" style="background-color: #d9edf7;">Nama Lengkap</th>
            <th rowspan="2" class="text-center" style="background-color: #d9edf7;">Dept</th>
            <th rowspan="2" class="text-center" style="background-color: #d9edf7;">Cv. Perusahaan</th>
            <th rowspan="2" class="text-center" style="background-color: #d9edf7;">SISA POTONGAN PERIODE SEBELUMNYA</th>
            <th rowspan="2" class="text-center" style="background-color: #d9edf7;">Potongan Sembako</th>
            <th rowspan="2" class="text-center" style="background-color: #d9edf7;">Potongan Cicilan</th>
            <th rowspan="2" class="text-center" style="background-color: #d9edf7;">Total<br> (Sembako + Cicilan + Sisa)</th>
            <th rowspan="2" class="text-center" style="background-color: #d9edf7;">Dipotong saat kalkulasi<br> (Sembako + Cicilan)</th>
            <!-- <th rowspan="2" class="text-center" style="background-color: #d9edf7;"> Sisa Potongan</th> -->
            <th colspan="3" class="text-center" style="background-color: #d9edf7;">Sisa</th>
            <th rowspan="2" class="text-center" style="background-color: #d9edf7;">Action</th>
        </tr>
        <tr>
            <th style="background-color: #d9edf7;">Sembako + Sisa Periode Sebelumnya</th>
            <th style="background-color: #d9edf7;">Pot Cicilan</th>
            <th style="background-color: #d9edf7;">Total Sisa</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($_getDataCicilan as $get) {
            $bulan = date('m', strtotime($Periode));
            $tahun = date('Y', strtotime($Periode));
            $hari  = date('d', strtotime($Periode));
            //jumlah dari potongan saat kalkulasi
            $dipotong_saat_kalkulasi = $get->DiPotongPeriodeIni_Sembako + $get->DiPotong_Periode_iniCicilan;
            //total sisa sembako periode ini untuk TK Baru
            // $sisaSembakoPeriodeIniTKB = ($get->Sisa_PeriodeSebelumnya_tkbaru + $get->Pot_Sembako + $get->SisaCicilanKemaren) - $get->DiPotongPeriodeIni_Sembako;
            $sisaSembakoPeriodeIniTKB = ($get->Sisa_PeriodeSebelumnya_tkbaru + $get->Pot_Sembako) - $get->DiPotongPeriodeIni_Sembako;
            // sisa sembako periode ini untuk TK Lama
            $sisaTKLama = $get->SisaSembakoPeriodeini_tklama;



            if ($get->TanggalKeluarTemp !=  NULL) { ?>
                <tr style="background-color:#FFB6C1">
                    <td class="text-center"><?php echo $no++; ?></td>
                    <!-- <td class="text-center"><?php echo $get->FixNoTenaga_kerja ?></td> -->
                    <td class="text-center"><?php echo $get->Nik ?></td>
                    <td><?php echo $get->Nama ?></td>
                    <td class="text-center"><?php echo $get->BagianAbbr ?></td>
                    <td><?php echo $get->Perusahaan ?></td>
                    <td>
                        <!-- Total Periode Sebelumnya -->
                        <?php if ($get->PasTigaBulan  >= '0' && $get->PasTigaBulan <= '3'  && $get->SelisihHari >= '0') {
                            //sisa sebelumnya untuk TK Baru
                            $sisa = $get->Sisa_PeriodeSebelumnya_tkbaru ;
                        ?>
                            <a href="<?php echo base_url() ?>PotonganBon/detail_sisa_periode_sebelumnya_tkbaru/<?php echo $get->FixNoTenaga_kerja ?>/<?php echo $Periode ?>" class="btn btn-minier btn-round btn-success">Rp.<?php echo number_format($sisa, 0, ",", ".") ?></a>
                        <?php } else { ?>
                            <!-- sisa sebelumnya untuk TK Lama -->
                            <a href="<?php echo base_url() ?>PotonganBon/detail_sisa_periode_sebelumnya/<?php echo $get->FixNoTenaga_kerja ?>/<?php echo $Periode ?>" class="btn btn-minier btn-round btn-success">Rp.<?php echo number_format(($get->SisaPotBon + $get->SisaCicilanKemaren), 0, ",", ".") ?></a>
                        <?php } ?>
                    </td>
                    <td class="text-center">
                        <!-- Pot Sembako -->
                        <?php
                        if ($bulan == '01' && $tahun == '1970') {
                            echo "Rp.0";
                        } else { ?>
                            <a href="<?php echo base_url() ?>PotonganBon/detail_potongan_sembako/<?php echo $get->FixNoTenaga_kerja ?>/<?php echo $Periode ?>" class="btn btn-minier btn-round btn-success">Rp.<?php echo number_format($get->Pot_Sembako, 0, ",", ".") ?></a>
                        <?php }
                        ?>
                    </td>
                    <td class="text-center">
                        <!-- Pot Cicilan -->
                        <?php
                        if ($bulan == '01' && $tahun == '1970') {
                            echo "Rp.0";
                        } elseif ($bulan == '03' && $tahun == '2022') { ?>
                            <a href="<?php echo base_url() ?>PotonganBon/detail_potongan_cicilan/<?php echo $get->FixNoTenaga_kerja ?>/<?php echo $Periode ?>" class="btn btn-minier btn-round btn-success">Rp.
                                <?php echo number_format($get->Pot_Cicilan, 0, ",", "."); ?>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo base_url() ?>PotonganBon/detail_potongan_cicilan/<?php echo $get->FixNoTenaga_kerja ?>/<?php echo $Periode ?>" class="btn btn-minier btn-round btn-success">Rp.
                                <?php echo number_format($get->Pot_Cicilan, 0, ",", "."); ?>
                            </a>
                        <?php }
                        ?>
                    </td>
                    <td class="text-center">
                        <!-- Total Sembako + Cicilan + sisa-->
                        <?php
                        if ($bulan == '01' && $tahun == '1970') {
                            echo "Rp.0";
                        } else {
                            if ($get->PasTigaBulan  >= '0' && $get->PasTigaBulan <= '3'  && $get->SelisihHari >= '0') {
                                $total = $sisa + $get->Pot_Sembako + $get->Pot_Cicilan;
                                echo "Rp." . number_format($total, 0, ",", ".");
                            } else {
                                // $total = $get->SisaPeriodeSebelumnya_tklama + $get->Pot_Sembako + $get->Pot_Cicilan + $get->SisaSembakoPeriodeIni_tkbaru + $get->SisaCicilanKemaren;
                                $total = $get->SisaPeriodeSebelumnya_tklama + $get->Pot_Sembako + $get->Pot_Cicilan + $get->SisaCicilanKemaren;
                                echo "Rp." . number_format($total, 0, ",", ".");
                            }
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <!-- Dipotong Saat Kalkulasi -->
                        <?php
                        if ($bulan == '01' && $tahun == '1970') {
                            echo "Rp.0";
                        } else {
                            echo "Rp." . number_format($dipotong_saat_kalkulasi, 0, ",", ".");
                        }
                        ?>
                    </td>
                    <td>
                        <!-- Sisa Sembako -->
                        <?php if ($dipotong_saat_kalkulasi == '0') {
                            echo "Rp.0";
                        } else {
                            if ($get->PasTigaBulan  >= '0' && $get->PasTigaBulan <= '3'  && $get->SelisihHari >= '0') {
                                echo "Rp." . number_format($sisaSembakoPeriodeIniTKB, 0, ",", ".");
                            } else {
                                // echo "Rp." . number_format($get->SisaPeriodeSebelumnya_tklama + $get->SisaSembakoPeriodeIni_tkbaru, 0, ",", ".");
                                echo "Rp." . number_format($sisaTKLama, 0, ",", ".");
                            }
                        } ?>
                    </td>
                    <td class="text-center">
                        <!-- Sisa Cicilan -->
                        <?php
                        echo "Rp." . number_format($get->SisaCicilan, 0, ",", ".");
                        ?>
                    </td>
                    <td>
                        <!-- Rumus : sisa sembako + sisa cicilan -->
                        <?php if ($dipotong_saat_kalkulasi == '0') {
                            echo "Rp.0";
                        } else {
                            if ($get->PasTigaBulan  >= '0' && $get->PasTigaBulan <= '3'  && $get->SelisihHari >= '0') {
                                echo "Rp." . number_format($sisaSembakoPeriodeIniTKB + $get->SisaCicilan, 0, ",", ".");
                            } else {
                                echo "Rp." . number_format($get->SisaPeriodeSebelumnya_tklama + $get->SisaCicilan, 0, ",", ".");
                            }
                        } ?>
                    </td>
                    <td>
                        <p class="text-center">
                            <a href="<?php echo base_url(); ?>PotonganBon/print_data/<?php echo $get->FixNoTenaga_kerja ?>/<?php echo $Periode ?>/<?php echo $tglMulai ?>" class="btn btn-minier btn-round btn-primary"><i class="fa fa-print"></i></a>
                        </p>
                    </td>
                </tr>
            <?php } else { ?>
                <tr>
                    <td class="text-center"><?php echo $no++; ?></td>
                    <!-- <td class="text-center"><?php echo $get->FixNoTenaga_kerja ?></td> -->
                    <td class="text-center"><?php echo $get->Nik ?></td>
                    <td><?php echo $get->Nama ?></td>
                    <td class="text-center"><?php echo $get->BagianAbbr ?></td>
                    <td><?php echo $get->Perusahaan ?></td>
                    <td>
                        <!-- Total Periode Sebelumnya -->
                        <?php if ($get->PasTigaBulan  >= '0' && $get->PasTigaBulan <= '3'  && $get->SelisihHari >= '0' || isset($get->Sisa_PeriodeSebelumnya_tkbaru)) {
                            //sisa sebelumnya untuk TK Baru
                            // $sisa =  ($get->Sisa_PeriodeSebelumnya_tkbaru   + $get->SisaCicilanKemaren);
                            $sisa =  ($get->Sisa_PeriodeSebelumnya_tkbaru);
                        ?>

                            <a href="<?php echo base_url() ?>PotonganBon/detail_sisa_periode_sebelumnya_tkbaru/<?php echo $get->FixNoTenaga_kerja ?>/<?php echo $Periode ?>" class="btn btn-minier btn-round btn-success">Rp.<?php echo number_format($sisa, 0, ",", ".") ?></a>
                        <?php } else { ?>
                            <a href="<?php echo base_url() ?>PotonganBon/detail_sisa_periode_sebelumnya/<?php echo $get->FixNoTenaga_kerja ?>/<?php echo $Periode ?>" class="btn btn-minier btn-round btn-success">Rp.<?php echo number_format($get->SisaPotBon + $get->SisaCicilanKemaren, 0, ",", ".") ?></a>
                        <?php }                        ?>
                    </td>
                    <td class="text-center">
                        <!-- Pot Sembako -->
                        <?php
                        if ($bulan == '01' && $tahun == '1970') {
                            echo "Rp.0";
                        } else { ?>
                            <a href="<?php echo base_url() ?>PotonganBon/detail_potongan_sembako/<?php echo $get->FixNoTenaga_kerja ?>/<?php echo $Periode ?>" class="btn btn-minier btn-round btn-success">Rp.<?php echo number_format($get->Pot_Sembako, 0, ",", ".") ?></a>
                        <?php }
                        ?>
                    </td>
                    <td class="text-center">
                        <!-- Pot Cicilan -->
                        <?php
                        if ($bulan == '01' && $tahun == '1970') {
                            echo "Rp.0";
                        } elseif ($bulan == '03' && $tahun == '2022') { ?>
                            <a href="<?php echo base_url() ?>PotonganBon/detail_potongan_cicilan/<?php echo $get->FixNoTenaga_kerja ?>/<?php echo $Periode ?>" class="btn btn-minier btn-round btn-success">Rp.
                                <?php echo number_format($get->Pot_Cicilan, 0, ",", "."); ?>
                            </a>
                        <?php } else { ?>
                            <a href="<?php echo base_url() ?>PotonganBon/detail_potongan_cicilan/<?php echo $get->FixNoTenaga_kerja ?>/<?php echo $Periode ?>" class="btn btn-minier btn-round btn-success">Rp.
                                <?php echo number_format($get->Pot_Cicilan, 0, ",", "."); ?>
                            </a>
                        <?php }
                        ?>
                    </td>
                    <td class="text-center">
                        <!-- Total Sembako + Cicilan + sisa-->
                        <?php
                        if ($bulan == '01' && $tahun == '1970') {
                            echo "Rp.0";
                        } else {
                            if ($get->PasTigaBulan  >= '0' && $get->PasTigaBulan <= '3'  && $get->SelisihHari >= '0') {
                                $total = $sisa + $get->Pot_Sembako + $get->Pot_Cicilan;
                                echo "Rp." . number_format($total, 0, ",", ".");
                            } else {
                                // $total = $get->SisaPeriodeSebelumnya_tklama + $get->Pot_Sembako + $get->Pot_Cicilan + $get->SisaSembakoPeriodeIni_tkbaru + $get->SisaCicilanKemaren;
                                $total = ($get->SisaPotBon + $get->SisaCicilanKemaren ) + $get->Pot_Sembako + $get->Pot_Cicilan;
                                echo "Rp." . number_format($total, 0, ",", ".");
                            }
                        }
                        ?>
                    </td>
                    <td class="text-center">
                        <!-- Dipotong Saat Kalkulasi -->
                        <?php
                        if ($bulan == '01' && $tahun == '1970') {
                            echo "Rp.0";
                        } else {
                            echo "Rp." . number_format($dipotong_saat_kalkulasi, 0, ",", ".");
                        }
                        ?>
                    </td>
                    <td>
                        <!-- Sisa Sembako -->
                        <?php if ($dipotong_saat_kalkulasi == '0') {
                            echo "Rp.0";
                        } else {
                            if (($get->PasTigaBulan  >= '0' && $get->PasTigaBulan <= '3'  && $get->SelisihHari >= '0' ) || isset($get->Sisa_PeriodeSebelumnya_tkbaru)) {
                                echo "Rp." . number_format($sisaSembakoPeriodeIniTKB, 0, ",", ".");
                            } else {
                                // echo "Rp." . number_format($get->SisaSembakoPeriodeini_tklama + $get->SisaSembakoPeriodeIni_tkbaru, 0, ",", ".");
                                echo "Rp." . number_format($sisaTKLama, 0, ",", ".");
                            }
                        } ?>
                    </td>
                    <td class="text-center">
                        <!-- Sisa Cicilan -->
                        <?php
                        echo "Rp." . number_format($get->SisaCicilan, 0, ",", ".");
                        ?>
                    </td>
                    <td>
                        <!-- Rumus : sisa sembako + sisa cicilan -->
                        <?php if ($dipotong_saat_kalkulasi == '0') {
                            echo "Rp.0";
                        } else {
                            if (($get->PasTigaBulan  >= '0' && $get->PasTigaBulan <= '3'  && $get->SelisihHari >= '0' )|| isset($get->Sisa_PeriodeSebelumnya_tkbaru)) {
                                echo "Rp." . number_format($sisaSembakoPeriodeIniTKB + $get->SisaCicilan, 0, ",", ".");
                            } else {
                                echo "Rp." . number_format($sisaTKLama + $get->SisaCicilan, 0, ",", ".");
                            }
                        } ?>
                    </td>
                    <td>
                        <p class="text-center">
                            <a href="<?php echo base_url(); ?>PotonganBon/print_data/<?php echo $get->FixNoTenaga_kerja ?>/<?php echo $Periode ?>/<?php echo $tglMulai ?>" class="btn btn-minier btn-round btn-primary"><i class="fa fa-print"></i></a>
                        </p>
                    </td>
                </tr>
        <?php }
        } ?>
    </tbody>

</table>
<br>
<div class="form-group">
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-3">
        <?php foreach ($_getDataSub as $get) {
            if ($get->IDSubPemborong == NULL) {
                echo "";
            } else { ?>
                <a href="<?php echo base_url(); ?>PotonganBon/ExportPDFBySub/<?php echo $get->IDPemborong ?>/<?php echo $get->IDSubPemborong ?>/<?php echo $get->PeriodeGajian ?>" class="btn btn-sm btn-round btn-success">
                    <i class="fa fa-excel"></i>
                    Export To PDF
                </a>
        <?php }
        } ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables1').dataTable({});
    });
</script>

<div class="modal fade" id="myModalCari" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <!--style="background-color: #008cba">-->
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Detail Potongan Pemborong</h4>
            </div>
            <div id="lihat_detail">
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function get_detail_potongan(clicked_id) {
            var nofix = clicked_id;
            var tglAwal = $('#tglAwal').val();
            var tglAkhir = $('#tglAkhir').val();

            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PotonganBon/get_detail_potongan') ?>" + "/" + nofix + "/" + tglAwal + "/" + tglAkhir,
                success: function(msg) {
                    if (msg == '') {
                        alert('Tidak ada data');
                    } else {
                        $('#lihat_detail').html(msg);
                    }
                }
            });

            $('#myModalCari').modal('show');
        }
    </script>
</div>