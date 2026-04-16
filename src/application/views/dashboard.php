<div class="page-header">
    <div class="row">
        <div class="col-xs-12">
            <div class="col-sm-6" style="text-align: left">
                <h1>Dashboard</h1>
            </div>
            <div class="col-sm-6" style="text-align: right">
                <div class="page-header-buttons">
                    <span class="btn btn-sm btn-success">
                        <i class="ace-icon fa fa-calendar bigger-110"></i>
                        <?php echo date('l, d M Y'); ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.page-header -->
<div class="row">
    <div class="col-xs-12">
        <div class="col-sm-12  infobox-container" style="margin-bottom:10px">
            <object type="image/svg+xml" data="<?= base_url('assets/images/animate.svg') ?>" width="300"></object>
            <div class="mb-2">
                <img src="<?= base_url('assets/images/logo_psg_new.png') ?>" width="80" alt="">
                <img src="<?= base_url('assets/images/KAN_BARU.png') ?>" width="80" alt="">
                <img src="<?= base_url('assets/images/Kara.jpg') ?>" width="80" alt="">
                <img src="<?= base_url('assets/images/KaraCoco.jpg') ?>" width="80" alt="">
            </div>
            <h4>Hallo! <?php echo greeting_time(date('H')) ?><strong> <?php echo html_escape(preg_replace('/[^a-zA-Z0-9\s]/', '', $this->session->userdata('username'))); ?>.</strong> Welcome in, <strong> Recruitment Management System, </strong>and have a wonderful day!</h4>
        </div>

        <div class="col-sm-12">
            <div class="row">
                <div class="col-xs-12 col-sm-12">
                    <div class="row">
                        <div class="col-sm-12 infobox-container" style="margin-bottom: 20px;">
                            <div class="infobox infobox-grey infobox-large infobox-dark">
                                <div class="infobox-icon">
                                    <i class="ace-icon fa fa-download"></i>
                                </div>
                                <div class="infobox-data">
                                    <div class="infobox-content">
                                        <?php
                                        $this->load->model('m_dashboard');
                                        $all    = $this->m_dashboard->itungAllTK();
                                        echo $all;
                                        ?>
                                    </div>
                                    <div class="infobox-content"><small>Registered</small></div>
                                </div>
                            </div>

                            <div class="infobox infobox-blue infobox-large infobox-dark">
                                <div class="infobox-icon">
                                    <i class="ace-icon fa fa-calendar-o"></i>
                                </div>

                                <div class="infobox-data">
                                    <div class="infobox-content">
                                        <?php
                                        $today  = $this->m_dashboard->todayReg();
                                        echo $today;
                                        ?>
                                    </div>
                                    <div class="infobox-content">Register</div>
                                </div>
                            </div>

                            <div class="infobox infobox-green infobox-large infobox-dark">
                                <div class="infobox-icon">
                                    <i class="ace-icon fa fa-users"></i>
                                </div>

                                <div class="infobox-data">
                                    <span class="infobox-content">
                                        <?php
                                        $user  = $this->m_dashboard->itunguserOnline();
                                        echo $user;
                                        ?>
                                    </span>
                                    <div class="infobox-content">Online</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="widget-box ui-sortable-handle">
                                <div class="widget-header">
                                    <h5 class="widget-title">Data Pelamar yang Terakhir Tersimpan</h5>
                                </div>
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <div class="table-responsive">
                                            <table id="tblLastRecord" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>ID Pelamar</th>
                                                        <th>Nama Pelamar</th>
                                                        <th>Jenis Kelamin</th>
                                                        <th>Tempat/ Tanggal Lahir</th>
                                                        <th>Registered Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($_getLast as $set) : ?>
                                                        <tr>
                                                            <td><?php echo $set->HeaderID; ?></td>
                                                            <td><?php echo ucwords(strtolower($set->Nama)); ?></td>
                                                            <td>
                                                                <?php if ($set->Jenis_Kelamin == "M" || $set->Jenis_Kelamin == "LAKI-LAKI") {
                                                                    $jekel = "Laki-laki";
                                                                } else {
                                                                    $jekel = "Perempuan";
                                                                }
                                                                echo $jekel; ?>
                                                            </td>
                                                            <td>
                                                                <?php echo ucwords(strtolower($set->Tempat_Lahir)) . "/ " . date('d-M-Y',  strtotime($set->Tgl_Lahir)); ?>
                                                            </td>
                                                            <td><?php echo $set->RegisteredDate; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
