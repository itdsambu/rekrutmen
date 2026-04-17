<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8">
    <title><?php echo $this->config->item("nama_app"); ?></title>
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <meta name="description" content="overview &amp; stats" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel='shortcut icon' type='image icon' href="<?php echo base_url(); ?>assets/img/psg-logo.png" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome.css" />

    <!-- page specific plugin styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/sp/scroll-persen.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.custom.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-datepicker3.min.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/daterangepicker.css" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/datepicker.css" />

    <!-- text fonts -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-fonts.css" />
    <!-- Table Hover -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap/tablehover.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/ace-skins.css" id="ace-skins-stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap-timepicker.min.css" />
    <!-- button  -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/buttons.dataTables.min.css" />
    <!-- Toastr -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/toastr.min.css" />
    <!-- select2 -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/select2/select2.min.css" />


    <!-- ace settings handler -->
    <script src="<?php echo base_url(); ?>assets/js/ace-extra.js"></script>



    <script src="<?php echo base_url(); ?>assets/dp/jquery-1.10.2.js"></script>
    <!-- <script src="<?php echo base_url(); ?>assets/dp/jquery.datepick.js"></script> -->
    <script src="<?php echo base_url(); ?>assets/dp/jquery.plugin.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/socket.io.js"></script>

    <!-- sweet alert -->
    <link href="<?php echo base_url(); ?>assets/sweetalert2-11.3.6/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/sweetalertpabo/sweet.js"></script>

    <!-- validate -->
    <script src="<?= base_url(); ?>assets/validate/jquery-3.5.1.min.js"></script>
    <script src="<?= base_url(); ?>assets/validate/jquery.validate.min.js"></script>

    <!-- select2 -->
    <script src="<?php echo base_url(); ?>assets/js/select2/select2.min.js"></script>

    <?php
    if (isset($cssadd)) :
        foreach ($cssadd as $jsitem) {
    ?>
            <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/' . $jsitem; ?>" />
    <?php
        }
    endif
    
    ?>

    <style>
        #loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 20px;
            color: #000;
            z-index: 9999;
        }

        .spinner-overlay {
            display: none;
            position: absolute;
            top: 80%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            border: 12px solid #f3f3f3;
            /* Light grey */
            border-top: 12px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #loading {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 20px;
            color: #000;
            z-index: 9999;
        }

        .spinner-overlay {
            display: none;
            position: absolute;
            top: 80%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 20px;
            z-index: 9999;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .spinner {
            border: 12px solid #f3f3f3;
            /* Light grey */
            border-top: 12px solid #3498db;
            /* Blue */
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .centered-tab {
            width: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            line-height: 1.5;
            height: 50px;
            padding-bottom: 20px;
            /* Tentukan tinggi yang konsisten */
            white-space: nowrap;
            /* Mencegah teks membungkus */
        }

        .centered-tab i {
            margin-right: 5px;
            /* Berikan jarak antara ikon dan teks */
            vertical-align: middle;
        }

        .centered-tab span {
            vertical-align: middle;
        }
    </style>
    <style>
        /* Gaya khusus untuk toastr */
        .custom-toast-top {
            top: 80px;
            /* Menyesuaikan posisi vertikal */
        }
    </style>

    <style>
        /* Gaya khusus untuk tombol close */
        .toast-close-button-custom {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            font-size: 16px;
            cursor: pointer;
            color: #fff;
        }
    </style>
</head>

<body class="skin-3 no-skin">
    <div id="scroll"></div>
    <?php echo $_navbar; ?>

    <div class="main-container" id="main-container">
        <?php echo $_sidebar; ?>

        <div class="main-content">
            <div class="main-content-inner">
                <!-- breadcrumbs here -->
                <div class="page-content">
                    <?php echo $_content; ?>
                </div>
            </div>
        </div>

        <?php echo $_footer; ?>

        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
        </a>
    </div>

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script type="text/javascript">
        window.jQuery || document.write("<script src='<?php echo base_url(); ?>/assets/js/jquery.js'>" + "<" + "/script>");
    </script>

    <!-- <![endif]-->

    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("<script src='<?php echo base_url(); ?>assets/js/jquery.mobile.custom.js'>" + "<" + "/script>");
    </script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>

    <!-- page specific plugin scripts -->
    <script src="<?php echo base_url(); ?>assets/sp/scroll-persen.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>


    <script src="<?php echo base_url(); ?>assets/js/date-time/bootstrap-datepicker.js"></script>

    <!--[if lte IE 8]>
	  <script src="<?php echo base_url(); ?>assets/js/excanvas.js"></script>
	<![endif]-->
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery-ui.custom.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.ui.touch-punch.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.easypiechart.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.sparkline.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.pie.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/flot/jquery.flot.resize.js"></script>

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
    <script src="<?php echo base_url(); ?>assets/js/socketonelogin.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/bootstrap-timepicker.min.js"></script>

    <!-- Toastr -->
    <script src="<?= base_url() ?>assets/js/toastr.min.js"></script>
    <!-- confetti -->
    <script src="<?= base_url() ?>assets/js/canvas-confetti.js"></script>
    <?php
    if (isset($jsadd)) :
        foreach ($jsadd as $jsitem) {
    ?>
            <script src="<?php echo base_url() . 'assets/js/' . $jsitem; ?>"></script>
    <?php
        }
    endif
    ?>


    <!-- <script nonce="</?= $csp_nonce ?>">
        var a = </?= ENVIRONMENT == 'development' ? 'true' : 'false' ?>;

        if (!a) {
            DisableDevtool({
                disableMenu: false,
            });
        }
    </script> -->

    <?php if ($this->session->userdata('dept') == 'ITD' || $this->session->userdata('dept') == 'HRD') { ?>
        <script nonce="<?= $csp_nonce ?>">
            $(document).ready(function() {
                const getNotifications = <?php echo get_notifications(); ?>;
                var toastrInstances = {};
                var isPrevented = false;

                toastr.options = {
                    "closeButton": false,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right custom-toast-top", // Menggunakan kelas CSS kustom
                    "preventDuplicates": false,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "0",
                    "extendedTimeOut": "0",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut",
                    "tapToDismiss": false,
                    "onclick": null,

                }


                // Function to handle approval action
                function handleApproval(key, nama, id) {
                    showDialog(nama, id).then(function(result) {
                        if (result) {
                            toastr.clear(toastrInstances[key], {
                                force: true
                            }); // Clear the specific toastr instance
                            delete toastrInstances[key]; // Remove the toastr instance reference
                        }
                    });
                }

                // Proses data notifikasi
                // Contoh: Tampilkan di dalam elemen HTML

                var toastrInstance
                var username = "<?= html_escape(preg_replace('/[^a-zA-Z0-9\s]/', '', $this->session->userdata('username'))) ?>";

                getNotifications.forEach(function(data, index) {

                    // toastrInstance = toastr.success(`CALON KARYAWAN AN ${data.Nama} (${data.HeaderID}) SUDAH SELESAI REGISTRASI MANDIRI, TEST PROGRAMMER !!!`);
                    toastrInstance = toastr.success(`🎉 Halo ${username} ! <br>Calon Karyawan bernama <strong>${data.Nama}</strong> (${data.HeaderID}) telah berhasil menyelesaikan Registrasi Mandiri !!`);
                    // toastrInstance = toastr.success(`🎉 Halo ${html_escape(preg_replace('/[^a-zA-Z0-9\s]/', '', $username))} ! <br>Calon Karyawan bernama <strong>${data.Nama}</strong> (${data.HeaderID}) telah berhasil menyelesaikan Registrasi Mandiri !!`);

                    if (toastrInstance.find('.toast-message')) {

                        // Mengatur teks menjadi rata kanan-kiri
                        toastrInstance.find('.toast-message').css({
                            'text-align': 'left', // Rata kanan-kiri

                        });

                        var key = 'toastr_' + index; // Generate a unique key for the toastr instance
                        toastrInstances[key] = toastrInstance; // Add the toastr instance to the object with the generated key
                        toastrInstance.find('.toast-message').append('<br><br><button class="mt-2 btn btn-sm btn-success approve-button" style="float: right;">Tandai sudah dibaca</button>');

                        // Attach click event to approval button
                        toastrInstance.find('.approve-button').on('click', function() {
                            handleApproval(key, data.Nama, data.HeaderID);
                        });


                    }

                });

            })

            function showDialog(nama, id) {
                return new Promise(function(resolve) {
                    swal.fire({
                        title: "Anda Yakin? ",
                        text: `Notifikasi ini akan menghilang, anda yakin sudah check data AN ${nama} : ${id} ?`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Sudah!"
                    }).then(function(result) {
                        if (result.isConfirmed) {

                            $.ajax({
                                type: "post",
                                url: "<?= site_url('update-input-mandiri') ?>",
                                data: {
                                    id: id,
                                    // ci_exsambu: token_new
                                },
                                dataType: "json",
                                success: function(res) {
                                    console.log('res: ', res);

                                    if (res.status == 200) {
                                        Swal.fire({
                                            title: "Berhasil!",
                                            text: "Berhasil Update Data.",
                                            icon: "success"
                                        });
                                        resolve(result.isConfirmed);
                                        // Menambahkan efek confetti
                                        confetti({
                                            particleCount: 100,
                                            spread: 70,
                                            origin: {
                                                y: 0.6
                                            }
                                        });
                                        // $("#trnInputTable").DataTable().ajax.reload(null, false);
                                    } else {
                                        Swal.fire({
                                            title: "Gagal!",
                                            text: "Gagal Update Data.",
                                            icon: "error"
                                        });
                                    }

                                }
                            }); //end ajax

                        } // end result.isConfirmed

                    });
                });
            }


            /**
             * //////////////////////////////////////////////////////////////////////// Notifications for Salmonella Carrier ////////////////////////////////////////////////////////////////////////////
             */
            var toastrInstances = {};
            var toastrInstance
            var username = "<?= html_escape(preg_replace('/[^a-zA-Z0-9\s]/', '', $this->session->userdata('username'))) ?>";

            toastr.options = {
                "closeButton": true,


            }

            // Function to handle approval action
            function handleAcc(key, nama, id) {
                showDialogSalmonella(nama, id).then(function(result) {
                    if (result) {
                        toastr.clear(toastrInstances[key], {
                            force: true
                        }); // Clear the specific toastr instance
                        delete toastrInstances[key]; // Remove the toastr instance reference
                    }
                });
            }

            let displayedHeaderIDs = [];

            function notifSalmonella() {
                const salomonellaNotif = <?php echo salomonellaNotif(); ?>;

                salomonellaNotif.forEach(function(data, index) {

                    if (!displayedHeaderIDs.includes(data.HeaderID)) {

                        // toastrInstance = toastr.warning(`🎉 Halo ${username} ! <br>Calon Karyawan bernama <strong>${data.Nama}</strong> (${data.HeaderID}) telah masuk di daftar Salmonella Carrier !!`);
                        toastrInstance = toastr.warning(`🎉 Halo ${username} ! <br>Calon Karyawan bernama <strong>${data.Nama}</strong> (${data.HeaderID}) telah masuk di daftar Salmonella Carrier !!`);

                        if (toastrInstance.find('.toast-message')) {

                            // Mengatur teks menjadi rata kanan-kiri
                            toastrInstance.find('.toast-message').css({
                                'text-align': 'left', // Rata kanan-kiri
                            });

                            var key = 'toastr_' + index; // Generate a unique key for the toastr instance
                            toastrInstances[key] = toastrInstance; // Add the toastr instance to the object with the generated key
                            toastrInstance.find('.toast-message').append('<br><br><button class="mt-2 btn btn-sm btn-success approve-button" style="float: right;">Tandai sudah dibaca</button>');

                            // Attach click event to approval button
                            toastrInstance.find('.approve-button').on('click', function() {
                                handleAcc(key, data.Nama, data.HeaderID);
                            });

                            displayedHeaderIDs.push(data.HeaderID);
                        }
                    }
                })



            }

            function showDialogSalmonella(nama, id) {
                return new Promise(function(resolve) {
                    swal.fire({
                        title: "Anda Yakin? ",
                        text: `Notifikasi ini akan menghilang, anda yakin sudah check data AN ${nama} : ${id} ?`,
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Sudah!"
                    }).then(function(result) {
                        if (result.isConfirmed) {

                            $.ajax({
                                type: "post",
                                url: "<?= site_url('blacklist/updateNotif') ?>",
                                data: {
                                    id: id,
                                },
                                dataType: "json",
                                success: function(res) {
                                    console.log('res: ', res);

                                    if (res.status == 200) {
                                        Swal.fire({
                                            title: "Berhasil!",
                                            text: "Berhasil Update Data.",
                                            icon: "success"
                                        });
                                        resolve(result.isConfirmed);
                                        // Menambahkan efek confetti
                                        confetti({
                                            particleCount: 100,
                                            spread: 70,
                                            origin: {
                                                y: 0.6
                                            }
                                        });
                                        // $("#trnInputTable").DataTable().ajax.reload(null, false);
                                    } else {
                                        Swal.fire({
                                            title: "Gagal!",
                                            text: "Gagal Update Data.",
                                            icon: "error"
                                        });
                                    }

                                }
                            }); //end ajax

                        } // end result.isConfirmed

                    });
                });
            }

            $(document).ready(function() {
                setInterval(notifSalmonella, 5000);
                // console.log('base url : ', '<?= base_url() ?>');

            })

            $(document).ready(function() {
                $('select').not('.select2-hidden-accessible').select2();
            });
        </script>
    <?php } ?>

    <script nonce="<?= $csp_nonce ?>">
        (function() {

            let idleLimit = 10800; // detik (sesuaikan config sess_expiration)
            let idleTime = 0;
            let pingInterval = 60; // tiap 60 detik ping server
            let lastPing = 0;

            function resetIdle() {
                idleTime = 0;
            }

            // Deteksi aktivitas user
            window.addEventListener("mousemove", resetIdle);
            window.addEventListener("keydown", resetIdle);
            window.addEventListener("click", resetIdle);
            window.addEventListener("scroll", resetIdle);
            window.addEventListener("touchstart", resetIdle);

            function pingServer() {
                fetch("<?= base_url('welcome/ping_session'); ?>", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            "X-Requested-With": "XMLHttpRequest" // tambahkan ini
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log('data: ', data.status);

                        if (data.status !== "active") {
                            window.location.href = "<?= base_url('welcome/logout'); ?>";
                        }
                    })
                    .catch(err => {
                        console.log("Ping error:", err);
                    });
            }

            // Timer utama
            setInterval(function() {
                idleTime++;
                // console.log(idleTime++);


                // kalau idle lebih dari limit => logout
                if (idleTime >= idleLimit) {
                    window.location.href = "<?= base_url('welcome/logout'); ?>";
                }

                // ping server kalau user aktif (idleTime kecil)
                if (idleTime < idleLimit) {
                    if ((idleTime - lastPing) >= pingInterval) {
                        lastPing = idleTime;
                        pingServer();
                    }
                }

            }, 1000);

        })();
    </script>


</body>

</html>