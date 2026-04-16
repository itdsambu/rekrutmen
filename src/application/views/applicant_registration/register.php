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
                                        <div class="card-title">
                                            <h4 class="mb-0">Buat Akun!</h4>
                                        </div>
                                    </div>
                                    <p class="px-2">Isi formulir di bawah ini untuk membuat akun baru.</p>
                                    <div class="card-content">
                                        <div class="card-body pt-0">
                                            <form action="<?= base_url('register-action') ?>" method="POST">
                                                <div class="form-label-group">
                                                    <input type="text" id="inputName" name="fullname" class="form-control" placeholder="Nama (Sesuai KTP)" value="<?= set_value('fullname') ?>" required>
                                                    <small id="nameError" class="text-danger"><?= form_error('fullname') ?></small>
                                                </div>
                                                <div class="form-label-group">
                                                    <input type="text" id="inputNik" name="nik_ktp" class="form-control isNumberKey" placeholder="NIK KTP" value="<?= set_value('nik_ktp') ?>" required maxlength="16">
                                                    <small id="nikError" class="text-danger"><?= form_error('nik_ktp') ?></small>
                                                </div>
                                                <div class="form-label-group">
                                                    <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email" value="<?= set_value('email') ?>" required>
                                                    <small id="emailError" class="text-danger"><?= form_error('email') ?></small>
                                                </div>
                                                <!-- <div class="form-label-group">
                                                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Sandi" required>
                                                    <small id="sandiError" class="text-danger"><?= form_error('password') ?></small>

                                                </div>
                                                <div class="form-label-group">
                                                    <input type="password" id="inputConfPassword" name="confirm_password" class="form-control" placeholder="Konfirmasi Sandi" required>
                                                    <small id="sandiKonfError" class="text-danger"><?= form_error('confirm_password') ?></small>
                                                </div> -->
                                                <fieldset class="form-group position-relative input-divider-right">
                                                    <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Sandi" required>
                                                    <small id="sandiError" class="text-danger"><?= form_error('password') ?></small>
                                                    <div class="form-control-position">
                                                        <i type="button" id="togglePassword" class="feather icon-eye-off"></i> <!-- Default eye icon -->
                                                    </div>
                                                </fieldset>

                                                <fieldset class="form-group position-relative input-divider-right">
                                                    <input type="password" id="inputConfPassword" name="confirm_password" class="form-control" placeholder="Konfirmasi Sandi" required>
                                                    <small id="sandiKonfError" class="text-danger"><?= form_error('confirm_password') ?></small>
                                                    <small id="matchError" class="text-danger"></small>
                                                    <div class="form-control-position">
                                                        <i type="button" id="toggleConfPassword" class="feather icon-eye-off"></i> <!-- Default eye icon -->
                                                    </div>
                                                </fieldset>


                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <fieldset class="checkbox">
                                                            <div class="vs-checkbox-con vs-checkbox-primary">
                                                                <input type="checkbox" id="check-here">
                                                                <span class="vs-checkbox">
                                                                    <span class="vs-checkbox--check">
                                                                        <i class="vs-icon feather icon-check"></i>
                                                                    </span>
                                                                </span>
                                                                <span>Saya memastikan bahwa nama dan no ktp sudah sesuai.</span>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <a href="<?= base_url('login-act') ?>" class="btn btn-outline-primary float-left btn-inline mb-50">Masuk</a>
                                                <button type="submit" class="btn btn-primary float-right btn-inline mb-50" id="daftar-button" disabled>Daftar</a>
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
<script>
    $(document).on('click', '#check-here', function() {
        if ($(this).is(':checked')) {
            $('#daftar-button').prop('disabled', false)
        } else {
            $('#daftar-button').prop('disabled', true)
        }
    })

    $(document).ready(function() {
        // Ketika input NIK KTP berubah
        $('#inputNik').on('change', function() {
            var nik = $(this).val();
            var errorMessage = '';

            // Cek apakah NIK kosong
            if (nik === '') {
                errorMessage = 'NIK KTP tidak boleh kosong.';
            }
            // Cek apakah NIK hanya terdiri dari angka dan 16 digit
            else if (!/^\d{16}$/.test(nik)) {
                errorMessage = 'NIK KTP harus berupa 16 digit angka.';
                $(this).val('')
            }

            // Tampilkan pesan error jika ada
            if (errorMessage !== '') {
                $('#nikError').text(errorMessage); // Tampilkan pesan error
            } else {
                $('#nikError').text(''); // Kosongkan pesan error jika validasi berhasil
            }
        });
    });

    // Mengatur agar hanya input angka
    $('.isNumberKey').on('keypress', function(e) {
        // Cegah input jika bukan angka
        if (e.which < 48 || e.which > 57) {
            e.preventDefault();
        }
    });

    // Ketika input email berubah
    $('#inputEmail').on('change', function() {
        var email = $(this).val();
        var errorMessage = '';

        // Cek apakah email kosong
        if (email === '') {
            errorMessage = 'Email tidak boleh kosong.';
        }
        // Cek apakah email sesuai format yang benar
        else if (!/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email)) {
            errorMessage = 'Format email tidak valid.';
            $(this).val('')
        }

        // Tampilkan pesan error jika ada
        if (errorMessage !== '') {
            $('#emailError').text(errorMessage); // Tampilkan pesan error
        } else {
            $('#emailError').text(''); // Kosongkan pesan error jika validasi berhasil
        }
    });

    // Toggle visibility untuk password
    $('#togglePassword').click(function() {
        var passwordField = $('#inputPassword');
        var icon = $(this); // Dapatkan elemen ikon

        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            icon.removeClass('icon-eye-off').addClass('icon-eye');
        } else {
            passwordField.attr('type', 'password');
            icon.removeClass('icon-eye').addClass('icon-eye-off');
        }
    });

    // Toggle visibility untuk konfirmasi password
    $('#toggleConfPassword').click(function() {
        var confPasswordField = $('#inputConfPassword');
        var icon = $(this); // Dapatkan elemen ikon

        if (confPasswordField.attr('type') === 'password') {
            confPasswordField.attr('type', 'text');
            icon.removeClass('icon-eye-off').addClass('icon-eye');
        } else {
            confPasswordField.attr('type', 'password');
            icon.removeClass('icon-eye').addClass('icon-eye-off');
        }
    });

    // Validasi password dan konfirmasi password
    $('#inputConfPassword').on('input', function() {
        var password = $('#inputPassword').val();
        var confirmPassword = $('#inputConfPassword').val();

        if (password !== confirmPassword) {
            $('#matchError').text('Password dan Konfirmasi Password harus sama.'); // Pesan error jika tidak cocok
        } else {
            $('#matchError').text(''); // Kosongkan pesan error jika cocok
        }
    });
</script>

<?php $this->load->view('applicant_registration/templates/footer_end'); ?>