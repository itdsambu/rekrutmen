<!-- BEGIN: Vendor JS-->
<script src="<?= base_url() ?>new-assets/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="<?= base_url() ?>new-assets/app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="<?= base_url() ?>new-assets/app-assets/vendors/js/extensions/toastr.min.js"></script>
<!-- Toastr JS -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script> -->


<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="<?= base_url() ?>new-assets/app-assets/js/core/app-menu.js"></script>
<script src="<?= base_url() ?>new-assets/app-assets/js/core/app.js"></script>
<script src="<?= base_url() ?>new-assets/app-assets/js/scripts/components.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<!-- END: Page JS-->

<!-- BEGIN: Page JS-->
<script src="<?= base_url() ?>new-assets/app-assets/js/scripts/extensions/toastr.js"></script>
<!-- END: Page JS-->

<!-- Date Picker -->
<script src="<?= base_url(); ?>new-assets/datepicker.min.js"></script>

<script src="<?= base_url(); ?>new-assets/app-assets/vendors/js/pickers/pickadate/picker.js"></script>
<script src="<?= base_url(); ?>new-assets/app-assets/vendors/js/pickers/pickadate/picker.date.js"></script>
<script src="<?= base_url(); ?>new-assets/app-assets/vendors/js/pickers/pickadate/picker.time.js"></script>
<script src="<?= base_url(); ?>new-assets/app-assets/vendors/js/pickers/pickadate/legacy.js"></script>
<script src="<?= base_url(); ?>new-assets/app-assets/js/scripts/pickers/dateTime/pick-a-datetime.js"></script>
<script src="<?= base_url(); ?>new-assets/app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>

<!-- END Date Picker -->

<!-- Jquery Mask -->
<script src="<?= base_url(); ?>new-assets/jquerymask.min.js" type="text/javascript"></script>
<script src="<?= base_url(); ?>new-assets/jqueryinputmask.js" type="text/javascript"></script>
<!-- End Jquery Mask -->
<!-- Tambahkan ini di bagian <head> dokumen HTML kamu -->
<script src="<?= base_url(); ?>new-assets/js/pdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
<!-- SELECT 2 -->
<script src="<?= base_url(); ?>new-assets/app-assets/vendors/js/forms/select/select2.full.min.js"></script>
<script src="<?= base_url(); ?>new-assets/app-assets/js/scripts/forms/select/form-select2.js"></script>
<!-- AddRoW js -->
<script src="<?= base_url(); ?>new-assets/addRow.js"></script>

<!-- Sweet Alert 2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Cofetti JS -->
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.5.1/dist/confetti.browser.min.js"></script>
<!-- Typed JS -->
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.12"></script>




<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            todayHighlight: 'TRUE',
            autoclose: true,
            orientation: "bottom",
        }).on('changeDate', function(ev) {
            $(this).find('input').removeClass("is-invalid");
        });

        $(document).on('change', '.valid_date', function() {
            if ($(this).val().trim() != '') {
                var ast = $(this);
                var from = ast.val();

                if (from.trim() != '') {
                    var regPattern = /^(0[1-9]|[12][0-9]|3[01])(-)(0[1-9]|1[012])(-)(19|20)\d\d$/;
                    var checkArray = from.match(regPattern);
                    if (checkArray == null) {
                        toastr.error("Format Date : DD-MM-YYYY");
                        ast.val('');
                        ast.focus();
                    } else {

                    }
                }
            }
        });

        $(document).on('focus', '.dttgl', function() {
            $(this).datepicker({
                format: 'dd-mm-yyyy',
                todayBtn: "linked",
                todayHighlight: 'TRUE',
                autoclose: true,
                orientation: "bottom",
            });
        });
    })
</script>