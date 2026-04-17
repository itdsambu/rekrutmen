<style>
    .fixed-content {
        min-height: 300px;
        max-height: 300px;
        overflow-y: scroll;
    }
</style>
<?php echo smiley_js(); ?>

<div class="row">
    <div class="col-xs-12">
        <div class="alert alert-block alert-danger">
            <button type="button" class="close" data-dismiss="alert">
                    <i class="ace-icon fa fa-times"></i>
            </button>
            <i class="ace-icon fa fa-warning red"></i>
            <strong>Warning!!</strong> Gunakan ruang ini dengan bijak..</small><br/>
        </div>
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><i class="ace-icon fa fa-comments-o"></i> Chat Room!!</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>

            <div class="widget-body ">
                <div id="body" class="widget-main fixed-content">
                    <p>Loading...</p>
                </div>
            </div>
            <div class="widget-body" style="background: #C4C4C4;">
                <div class="widget-main">
                    <form class="form-horizontal">
                        <fieldset>

                            <div class="form-group">
                                <label class="control-label col-xs-2" for="txtUser">Message</label>
                                <div class="col-xs-9">
                                    <div class="input-group">
                                        <input id="txtMessage" name="txtMessage"  class="form-control input-sm" type="text" id="form-field-mask-1">
                                        <span class="input-group-btn">
                                            <button type="button" id="btnSend" class="btn btn-xs btn-primary">
                                                <i class="ace-icon fa fa-send"></i> Send</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-xs-1">
                                    <div class="popover-markup"> 
                                        <a href="#" class="trigger btn btn-xs btn-block btn-info" data-placement="left">
                                            Emot <i class="ace-icon fa fa-smile-o"></i></a> 
                                        <div class="head hide">Lorem Ipsum</div>
                                        <div class="content hide">
                                            <?php echo $smiley_table; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    jQuery(function($) {
        $('.popover-markup>.trigger').popover({
            html: true,
            title: function () {
                return $(this).parent().find('.head').html();
            },
            content: function () {
                return $(this).parent().find('.content').html();
            }
        });
    });

</script>

<script defer>
    $(function () {
        $('.error').hide();
        $('.sukses').hide();
        $('#btnSend').click(function () {
            var isipesan = $('#txtMessage').val();

            if (isipesan === '') {
                $('.error').show();
                $('.sukses').hide();
                return false;
            }

            var strdata = 'txtMessage=' + isipesan;
            
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url(); ?>chat/sendMessage',
                data: strdata,
                success: function () {
                    $('#txtMessage').val('');
                    $('.sukses').show();
                    $('.error').hide();
                    $('#body').attr({scrollBottom: $('#body').attr('scrollHeight')});
                }
            });
        });
    });
</script>

<script defer>
    $(setInterval(function () {
        $('#body').load('<?php echo base_url(); ?>chat/viewMessage'),
                $('#body').attr({scrollBottom: $('#body').attr('scrollHeight')});
    }, 500));
    $(setInterval(function () {
        var objDiv = document.getElementById("body");
        objDiv.scrollTop = objDiv.scrollHeight;
    }, 3000));
</script>