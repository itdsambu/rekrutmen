<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta charset="utf-8">
        <title><?php echo $this->config->item("nama_app"); ?></title>

        <meta name="description" content="overview &amp; stats" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
        <link rel='shortcut icon' type='image icon' href="<?php echo base_url(); ?>assets/img/psg-logo.png"/>

        <!-- bootstrap & fontawesome -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.css" />

        <!-- text fonts -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-fonts.css" />

        <!-- ace styles -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-skins.css" id="ace-skins-stylesheet"  type="text/css">

        <!--[if lte IE 9]>
                <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-part2.css" class="ace-main-stylesheet" />
        <![endif]-->

        <!--[if lte IE 9]>
          <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-ie.css" />
        <![endif]-->

        <!-- inline styles related to this page -->

        <!-- ace settings handler -->
        <script src="<?php echo base_url(); ?>assets/js/ace-extra.js"></script>

        <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

        <!--[if lte IE 8]>
        <script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/respond.js"></script>
        <![endif]-->



        <script src="<?php echo base_url(); ?>assets/dp/jquery-1.10.2.js"></script>
        <script src="<?php echo base_url(); ?>assets/dp/jquery.datepick.js"></script>
        <script src="<?php echo base_url(); ?>assets/dp/jquery.plugin.js"></script>
    </head>
    <body onload="window.print()">
        <div class="main-content">
            <div class="main-content-inner">
                <!-- breadcrumbs here -->
                <div class="page-content">
                    
                    <div class="row">
                        <div class="col-sm-offset-2 col-sm-8">
                            <h4 class="row header smaller lighter red">
                                <span class="col-sm-8">
                                    <i class="ace-icon fa fa-bell-o"></i>
                                    <strong> Informasi Calon Tenaga Kerja</strong>
                                </span><!-- /.col -->
                            </h4>
                            <?php
                            foreach ($datatk as $row):
                                $hdrid = $row->HeaderID;
                            endforeach;
                            $namafoto = './dataupload/foto/' . $hdrid . '.jpg';
                            ?>
                            <div class="row">
                                <?php
                                foreach ($datatk as $row):
                                    ?>
                                    <div class="col-sm-12">
                                        <div class="widget-box transparent">
                                            <div class="widget-header widget-header-large">
                                                <h3 class="widget-title grey lighter">
                                                    <i class="ace-icon fa fa-users green"></i>
                                                    <?php
                                                    if ($row->Jenis_Kelamin == "M" || $row->Jenis_Kelamin == "LAKI-LAKI") {
                                                        $sapa = 'Mr. ';
                                                        $jekel = 'Laki-laki';
                                                    } else {
                                                        $sapa = 'Mrs. ';
                                                        $jekel = 'Perempuan';
                                                    }
                                                    echo $sapa . ucwords(strtolower($row->Nama));
                                                    ?>
                                                </h3>

                                                <div class="widget-toolbar no-border invoice-info">
                                                    <span class="invoice-info-label">ID Reg:</span>
                                                    <span class="red"><?php echo "#" . $row->HeaderID; ?></span>

                                                    <br />
                                                    <span class="invoice-info-label">Date Reg:</span>
                                                    <span class="blue"><?php echo date('M, d Y', strtotime($row->RegisteredDate)); ?></span>
                                                </div>
                                            </div>
                                            <div class="col-sm-offset-5 col-sm-12">
                                                <div class="row">
                                                    <span class="profile-picture">
                                                        <img id="avatar" width="150" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url($namafoto); ?>" style="display: block;"></img>
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="widget-body">
                                                <div class="widget-main padding-24">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="row">
                                                                <div class="col-xs-12 label label-lg label-info arrowed-in arrowed-right">
                                                                    <b>Informasi Data Pribadi</b>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <ul class="list-unstyled spaced">
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                                                        Perusahaan : <?php echo $row->CVNama; ?>
                                                                    </li>
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                                                        Pemborong : <?php echo $row->Pemborong; ?>
                                                                    </li>
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                                                        No. KTP : <?php echo $row->No_Ktp; ?>
                                                                    </li>
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                                                        Alamat : <?php echo ucwords(strtolower($row->Alamat)) . " RT: " . $row->RT . " RW: " . $row->RW; ?>
                                                                    </li>
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                                                        Jenis Kelamin : <?php echo $jekel; ?>
                                                                    </li>
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                                                        Tempat/Tanggal Lahir : <?php echo ucwords(strtolower($row->Tempat_Lahir)) . ' / ' . date('M, d Y', strtotime($row->Tgl_Lahir)); ?>
                                                                    </li>
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                                                        Phone : 
                                                                        <b class="red"><?php echo $row->NoHP; ?></b>
                                                                    </li>
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right blue"></i>
                                                                        Sosial Media : 
                                                                        <?php
                                                                        if ($row->AccountFacebook != " ") {
                                                                            ?>
                                                                            <i class="ace-icon fa fa-facebook-square"></i><a href=="http://facebook.com/<?php echo $row->AccountFacebook; ?>" target="_blank">Facebook</a>
                                                                        <?php } elseif ($row->AccountTwitter != " ") { ?>
                                                                            <i class="ace-icon fa fa-twitter-square"></i><a href=="http://facebook.com/<?php echo $row->AccountTwitter; ?>" target="_blank">Facebook</a>
                                                                            <?php
                                                                        } else {
                                                                            echo 'Tidak Ada';
                                                                        }
                                                                        ?>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div><!-- /.col -->

                                                        <div class="col-sm-6">
                                                            <div class="row">
                                                                <div class="col-xs-12 label label-lg label-success arrowed-in arrowed-right">
                                                                    <b>Informasi Keluarga</b>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <ul class="list-unstyled  spaced">
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right green"></i>
                                                                        Status : <?php echo ucwords(strtolower($row->Status_Personal)); ?>
                                                                    </li>
                                                                    <?php
                                                                    if ($row->Status_Personal != 'BUJANG' && $row->Status_Personal != 'GADIS') {
                                                                        echo '<li>
                                                <i class="ace-icon fa fa-caret-right green"></i>
                                                Jumlah Anak : ' . $row->JumlahAnak . '</li>';
                                                                    }
                                                                    ?>

                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right green"></i>
                                                                        Nama Istri/Suami : <?php
                                                                        if ($row->NamaSuamiIstri == NULL) {
                                                                            echo 'Tidak Beristri/Bersuami';
                                                                        } else {
                                                                            echo ucwords(strtolower($row->NamaSuamiIstri));
                                                                        }
                                                                        ?>
                                                                    </li>
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right green"></i>
                                                                        Pekerjaan Istri/Suami : <?php
                                                                        if ($row->PekerjaanSuamiIstri == NULL) {
                                                                            echo 'Tidak Beristri/Bersuami';
                                                                        } else {
                                                                            echo ucwords(strtolower($row->PekerjaanSuamiIstri));
                                                                        }
                                                                        ?>
                                                                    </li>
                                                                </ul>
                                                                <ul class="list-unstyled  spaced">
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right green"></i>
                                                                        Nama Ayah : <?php echo $row->NamaBapak; ?>
                                                                    </li>
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right green"></i>
                                                                        Nama Ibu : <?php echo $row->NamaIbuKandung; ?>
                                                                    </li>
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right green"></i>
                                                                        Pekerjaan Orang Tua : <?php echo $row->ProfesiOrangTua; ?>
                                                                    </li>
                                                                    <li>
                                                                        <i class="ace-icon fa fa-caret-right green"></i>
                                                                        Anak Ke : <?php echo $row->AnakKe . ' dari ' . $row->JumlahSaudara . ' bersaudara'; ?>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                        </div><!-- /.col -->

                                                    </div><!-- /.row -->

                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-xs-12 label label-lg label-purple arrowed-in arrowed-right">
                                                        <b>Informasi Lainnya</b>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ul class="list-unstyled spaced">
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Daerah Asal : <?php echo $row->Daerah_Asal; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Bahasa Daerah : <?php echo $row->BahasaDaerah; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Suku : <?php echo $row->Suku; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Agama : <?php echo $row->Agama; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Hobby : <?php echo $row->Hobby; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Kegiatan Extra : <?php echo $row->KegiatanEkstra; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Kegiatan Organisasi : <?php echo $row->KegiatanOrganisasi; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Pengalaman Kerja : <?php echo $row->PengalamanKerja; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Keahlian (Skill) : <?php echo $row->Keahlian; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Pernah Kerja di PT. SAMBU : <?php echo $row->PernahKerjaDiSambu; ?>
                                                        </li>
                                                        <?php
                                                        if ($row->PernahKerjaDiSambu == 'YA') {
                                                            echo '<li><i class="ace-icon fa fa-caret-right purple"></i>
                                    Department/Bagaian : ' . $row->KerjadiBagian . '</li>';
                                                        }
                                                        ?>

                                                    </ul>
                                                </div>
                                                <div class="col-sm-6">
                                                    <ul class="list-unstyled spaced">
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Tinggi Badan : <?php echo $row->TinggiBadan . ' cm'; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Berat Badan : <?php echo $row->BeratBadan . ' kg'; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Keadaan Fisik : <?php echo $row->KeadaanFisik; ?>
                                                        </li>
                                                        <?php
                                                        if (strtoupper($row->KeadaanFisik) == "CACAT") {
                                                            echo '<li><i class="ace-icon fa fa-caret-right purple"></i>
                                    Cacat yang dialami : ' . $row->CacatApa . '</li>';
                                                        }
                                                        ?>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Idap Penyakit : <?php echo $row->PernahIdapPenyakit; ?>
                                                        </li>
                                                        <?php
                                                        if ($row->PernahIdapPenyakit == "YA") {
                                                            echo '<li><i class="ace-icon fa fa-caret-right purple"></i>
                                    Penyakit yang dimiliki : ' . $row->PenyakitApa . '</li>';
                                                        }
                                                        ?>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Terlibat Kriminal : <?php echo $row->Kriminal; ?>
                                                        </li>
                                                        <?php
                                                        if ($row->Kriminal == "YA") {
                                                            echo '<li><i class="ace-icon fa fa-caret-right purple"></i>
                                    Perkara yang pernah dilakukan : ' . $row->PerkaraApa . '</li>';
                                                        }
                                                        ?>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Bertindik : <?php echo $row->Bertindik; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Bertato : <?php echo $row->Bertato; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Sedia Potong Rambut : <?php echo $row->SediaPotongRambut; ?>
                                                        </li>
                                                        <li>
                                                            <i class="ace-icon fa fa-caret-right purple"></i>
                                                            Sedia Diberhentikan : <?php echo $row->Sediadiberhentikan; ?>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 label label-lg label-danger arrowed-in arrowed-right">
                                                <i class="ace-icon fa fa-university"></i> <b>Informasi Pendidikan</b>
                                            </div>
                                            <div class="table table-responsive">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="center">Pendidikan</th>
                                                            <th>Jurusan</th>
                                                            <th>Sekolah/ Universitas</th>
                                                            <th>Nilai Rata-rata/ IPK (Skalas 4.00)</th>
                                                            <th>Tahun Masuk</th>
                                                            <th>Tahun Lulus</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="center"><?php echo $row->Pendidikan; ?></td>
                                                            <td><?php echo $row->Jurusan; ?></td>
                                                            <td><?php echo $row->Universitas; ?></td>
                                                            <td><?php echo $row->IPK; ?></td>
                                                            <td><?php echo $row->TahunMasuk; ?></td>
                                                            <td><?php echo $row->TahunLulus; ?></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- /section:pages/invoice -->
                                    </div>
                                    <?php
                                endforeach;
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- basic scripts -->

        <!--[if !IE]> -->
        <script type="text/javascript">
            window.jQuery || document.write("<script src='<?php echo base_url(); ?>/assets/js/jquery.js'>" + "<" + "/script>");
        </script>

        <!-- <![endif]-->

        <!--[if IE]>
        <script type="text/javascript">
        window.jQuery || document.write("<script src='<?php echo base_url(); ?>assets/js/jquery1x.js'>"+"<"+"/script>");
        </script>
        <![endif]-->
        <script type="text/javascript">
            if ('ontouchstart' in document.documentElement)
                document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.mobile.custom.js'>" + "<" + "/script>");
        </script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
        <!-- ace scripts -->
        <script src="<?php echo base_url(); ?>assets/js/ace/elements.scroller.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/elements.colorpicker.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/elements.fileinput.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/elements.typeahead.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/elements.wysiwyg.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/elements.spinner.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/elements.treeview.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/elements.wizard.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/elements.aside.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/ace.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/ace.ajax-content.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/ace.touch-drag.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/ace.sidebar.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/ace.sidebar-scroll-1.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/ace.submenu-hover.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/ace.widget-box.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/ace.settings.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/ace.settings-rtl.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/ace.settings-skin.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/ace.widget-on-reload.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/ace/ace.searchbox-autocomplete.js"></script>
    </body>
</html>