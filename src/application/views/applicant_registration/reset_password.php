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
                <div class="col-xl-7 col-10 d-flex justify-content-center">
                    <div class="card bg-authentication rounded-0 mb-0 w-100">
                        <div class="row m-0">
                            <div class="col-lg-6 d-lg-block d-none text-center align-self-center p-0">
                                <img src="<?= base_url() ?>new-assets/app-assets/images/pages/reset-password.png" alt="branding logo">
                            </div>
                            <div class="col-lg-6 col-12 p-0">
                                <div class="card rounded-0 mb-0 px-2">
                                    <div class="card-header pb-1">
                                        <div class="card-title">
                                            <h4 class="mb-0">Reset Password</h4>
                                        </div>
                                    </div>
                                    <p class="px-2">Masukkan password baru anda</p>
                                    <div class="card-content">
                                        <div class="card-body pt-1">
                                            <?php if ($this->session->flashdata('error')) : ?>
                                                <p class="error"><?= $this->session->flashdata('error'); ?></p>
                                            <?php endif; ?>
                                            <form action="<?= base_url('reset-password-action') ?>" method="post">
                                                <fieldset class="form-label-group">
                                                    <input type="password" name="password" class="form-control" id="user-password" placeholder="Password" required>
                                                    <input type="hidden" name="token" class="form-control token" id="token" value="<?= $token ?>" required>
                                                    <small id="sandiError" class="text-danger"><?= form_error('password') ?></small>
                                                    <label for="user-password">Password</label>
                                                </fieldset>

                                                <fieldset class="form-label-group">
                                                    <input type="password" name="confirm_password" class="form-control" id="user-confirm-password" placeholder="Konfirmasi Password" required>
                                                    <small id="sandiKonfError" class="text-danger"><?= form_error('confirm_password') ?></small>
                                                    <label for="user-confirm-password">Konfirmasi Password</label>
                                                </fieldset>
                                                <div class="row pt-2">
                                                    <div class="col-12 col-md-6 mb-1">
                                                        <a href="<?= base_url('login-act') ?>" class="btn btn-outline-primary btn-block px-0">Kembali ke Login</a>
                                                    </div>
                                                    <div class="col-12 col-md-6 mb-1">
                                                        <button type="submit" class="btn btn-primary btn-block px-0">Reset</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
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