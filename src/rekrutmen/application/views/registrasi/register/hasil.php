<style>
    @media print{

        article,
        aside,
        details,
        figcaption,
        figure,
        footer,
        header,
        hgroup,
        nav,
        section {
            display: none;
        }

        .image-button{
            display: none;
        }
        
        .page-header{
            display: none;
        }
        .no-print{
            display: none;
        }
    }
</style>
<div class="page-header">
    <h1>
        REGISTRASI
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Selesai
        </small>
    </h1>
</div>
<div class="page-content">
    <div class="no-print">
    <?php echo $message; ?>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="space-6"></div>

            <div class="row">
                <?php
                    foreach($datatk as $row):
                ?>
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="widget-box transparent">
                        <div class="widget-header widget-header-large">
                            <h3 class="widget-title grey lighter">
                                <i class="ace-icon fa fa-users green"></i>
                                <?php 
                                if($row->Jenis_Kelamin == "M" || $row->Jenis_Kelamin == "LAKI-LAKI"){
                                    $sapa = 'Mr. ';
                                    $jekel= 'Laki-laki';
                                }  else {
                                    $sapa = 'Mrs. ';
                                    $jekel= 'Perempuan';
                                }
                                echo $sapa.ucwords(strtolower($row->Nama));?>
                            </h3>

                            <div class="widget-toolbar no-border invoice-info">
                                <span class="invoice-info-label">ID Reg:</span>
                                <span class="red"><?php echo "#".$row->HeaderID;?></span>

                                <br />
                                <span class="invoice-info-label">Date Reg:</span>
                                <span class="blue"><?php echo date('M, d Y',  strtotime($row->RegisteredDate));?></span>
                            </div>

                            <div class="no-print widget-toolbar hidden-480">
                                <a href="<?php echo site_url('registrasi');?>" class="btn btn-white btn-default btn-round">
                                    &nbsp;<i class="ace-icon fa fa-arrow-circle-o-left"></i> Back to Registrasi &nbsp;
                                </a>
                                <a href="javascript:window.print()" class="btn btn-white btn-default btn-round">
                                    &nbsp;<i class="ace-icon fa fa-print"></i> Print &nbsp;
                                </a>
                            </div>

                                <!-- /section:pages/invoice.info -->
                        </div>
                        <div class="col-sm-offset-5 col-sm-12">
                            <div class="row">
                                <span class="profile-picture">
                                    <img id="avatar" width="150" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url(); ?>dataupload/<?php echo $filefoto;?>.jpg" style="display: block;"></img>
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
                                                    No. KTP : <?php echo $row->No_Ktp;?>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                                    Alamat : <?php echo ucwords(strtolower($row->Alamat))." RT: ".$row->RT." RW: ".$row->RW;?>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                                    Jenis Kelamin : <?php echo $jekel;?>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                                    Tempat/Tanggal Lahir : <?php echo ucwords(strtolower($row->Tempat_Lahir)).' / '.date('M, d Y',  strtotime($row->Tgl_Lahir));?>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                                    Phone : 
                                                    <b class="red"><?php echo $row->NoHP;?></b>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right blue"></i>
                                                    Status : <?php echo ucwords(strtolower($row->Status_Personal));?>
                                                </li>
                                                <li class="divider"></li>
                                            </ul>
                                        </div>
                                    </div><!-- /.col -->

                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-xs-12 label label-lg label-success arrowed-in arrowed-right">
                                                <b>Informasi Lainnya</b>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <ul class="list-unstyled  spaced">
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>
                                                    Perusahaan : <?php echo $row->CVNama;?>
                                                </li>
                                                <li>
                                                    <i class="ace-icon fa fa-caret-right green"></i>
                                                    Pemborong : <?php echo $row->Pemborong;?>
                                                </li>
                                            </ul>
                                        </div>
                                           
                                    </div><!-- /.col -->
                                </div><!-- /.row -->

                            </div>
                        </div>
                        <div class="col-xs-12 label label-lg label-danger arrowed-in arrowed-in-right">
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
                                        <td class="center">
                                            <?php echo $row->Pendidikan;?>
                                        </td>
                                        <td>
                                            <?php echo $row->Jurusan;?>
                                        </td>
                                        <td>
                                            <?php echo $row->Universitas;?>
                                        </td>
                                        <td>
                                            <?php echo $row->IPK;?>
                                        </td>
                                        <td><?php echo $row->TahunMasuk;?></td>
                                        <td><?php echo $row->TahunLulus;?></td>
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

                <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div>