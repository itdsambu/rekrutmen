<?php $this->load->view('applicant_registration/templates/header'); ?>
<!-- BEGIN: Content-->
<div class="app-content content">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <section class="row flexbox-container">
                <div class="col-xl-8 col-10 d-flex justify-content-center">
                    <div class="card bg-authentication rounded-0 mb-0">
                        <div class="row m-0">
                            <!-- <div class="col-lg-6 d-lg-block d-none text-center align-self-center pl-0 pr-3 py-0">
                                    <img src="<?= base_url() ?>new-assets/app-assets/images/pages/register.jpg" alt="branding logo">
                                </div> -->
                            <div class="col-lg-12 col-12 p-0">
                                <div class="card rounded-0 mb-0 p-2">
                                    <div class="card-header pt-00 pb-1">
                                        <div class="card-title text-center">
                                            <h4 class="mb-0">Hi <?= $nmlengkap ?>, Data anda sudah tersimpan!</h4>
                                        </div>
                                    </div>
                                    <!-- <p class="px-2">Isi formulir di bawah ini untuk membuat akun baru.</p> -->
                                    <div class="card-content mt-3">
                                        <div class="card-body pt-0 d-flex justify-content-center">
                                            <img src="<?= base_url() ?>new-assets/img/checklist.png" alt="branding logo" width="206px">
                                        </div>
                                    </div>
                                    <div class="card-content mt-1 d-flex justify-content-center">
                                        <a href="<?= base_url('logout') ?>" class=""><i class="feather icon-log-out"></i> Logout</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>
<!-- END: Content-->

<?php $this->load->view('applicant_registration/templates/footer'); ?>

<?php $this->load->view('applicant_registration/templates/footer_end'); ?>