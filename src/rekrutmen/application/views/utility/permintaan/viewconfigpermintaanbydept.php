<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Utility Permintaan Karyawan dan TK
    </span>
</h4>
<style>
    .bordering {
        border: solid 2px #1ca8c5;
        padding: 20px;
    }
</style>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="controlsetup">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Management Permintaan Karyawan dan TK</h3>
            </div>
        </div>
        <div class="panel-body">
            <section id="viewtabel">
                <div class="col-sm-12">
                    <table id="tblsettingkrytk" class="table table-striped table-hover table-nowrap table-colored" style="width:100%;">
                        <thead>
                            <tr>
                                <th>Dept</th>
                                <th>Ideal Kry</th>
                                <th>Real Kry</th>
                                <th>Req. Kry Approve</th>
                                <th>Req. Kry Pending</th>
                                <th>Ideal TK</th>
                                <th>Real TK</th>
                                <th>Req. TK Approve</th>
                                <th>Req. TK Pending</th>
                                <th>Periode</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th style="text-align:left">Grand Total:</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    <div id="formupdate"></div>
                </div>
            </section>
        </div>
    </div>
</div>

<script src="<?= base_url() ?>assets/js/jsadd/autoNumeric.min.js"></script>
<script src="<?= base_url() ?>assets/js/jsadd/sweetalert.min.js"></script>
<script src="<?= base_url() ?>assets/js/jsadd/bootstrap-select.min.js"></script>
<script src="<?= base_url() ?>assets/js/jsadd/underscore-min.js"></script>
<script src="<?= base_url() ?>assets/js/jsadd/backbone-min.js"></script>
<script src="<?= base_url() ?>assets/js/jsadd/backdatatableserver2.js"></script>


<script>
    var view = {};

    var viewtabelpermintaan = Backbone.View.extend({
        el: '#controlsetup',
        ikrys: null,
        initialize: function() {
            rowdata = [{
                    'data': 'krydeptname'
                },
                {
                    'data': 'IKry',
                    'className': 'text-right'
                },
                {
                    'data': 'RKry',
                    'className': 'text-right'
                },
                {
                    'data': 'PERMINTAANKARApp',
                    'className': 'text-right'
                },
                {
                    'data': 'PERMINTAANKARPending',
                    'className': 'text-right'
                },
                {
                    'data': 'IBor',
                    'className': 'text-right'
                },
                {
                    'data': 'RBor',
                    'className': 'text-right'
                },
                {
                    'data': 'PERMINTAANBORApp',
                    'className': 'text-right'
                },
                {
                    'data': 'PERMINTAANBORPending',
                    'className': 'text-right'
                },
                {
                    'data': 'Periode',
                    'className': 'text-right'
                }
            ];
            view.tblkry = new vwtabledata();
            view.tblkry.urlAjax = './getdatacountkrytkdept';
            view.tblkry.returnme = this;


            view.tblkry.inittable(rowdata);
        }
    });

    // var vwtabledata = BackboneDatatableServer.extend({
    //     el: '#viewtabel',
    //     el_table: '#tblsettingkrytk',
    //     urlAjax: './getdatacountkrytk',
    //     onfooter: function(r, d, s, e, display, my) {
    //         var api = my.api();
    //         $.get('./getajaxsummarydept', {}, function(res) {
    //             j = res.data[0];
    //             $(api.column(1).footer()).html(j.Ideal_Kry);
    //             $(api.column(2).footer()).html(j.Real_Kry);
    //             $(api.column(3).footer()).html(j.ReqK);
    //             $(api.column(4).footer()).html(j.ReqKP);
    //             $(api.column(5).footer()).html(j.Ideal_Bor);
    //             $(api.column(6).footer()).html(j.Real_Bor);
    //             $(api.column(7).footer()).html(j.ReqB);
    //             $(api.column(8).footer()).html(j.ReqBP);
    //         }, 'json');
    //     }
    // })

    var formkry = Backbone.View.extend({
        el: '#formkry',
        eldept: '#idkrydept',
        elrealkry: '#txtrealkry',
        idealkry: '#txtidealkrys',
        idsave: null,
        events: {
            "click #btnuploadmemo": "doupdatedata"
        },
        initialize: function() {
            this.idsave = new AutoNumeric(this.idealkry, {
                decimalPlaces: 0,
                decimalCharacter: ',',
                digitGroupSeparator: '.',
                maximumValue: 9000,
                minimumValue: 0
            });
        },
        doupdatedata: function(e) {
            e.preventDefault();
            var fm = $('#frmkry')[0];
            var fd = new FormData(fm);
            $.ajax({
                url: './updatedata',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: fd,
                type: 'POST',
                success: function(r) {
                    if (r.Err == 1) {
                        swal(r.Msg, 'Error', 'error');
                    } else {
                        swal(r.Msg, 'Success', 'success');
                        view.tblkry.refreshtable();
                        view.pkrytk.clean();
                    }
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    });

    var formtk = Backbone.View.extend({
        el: '#formtk',
        idtk: null,
        events: {
            "click #btnuploadmemotk": "doupdateadatatk"
        },
        initialize: function() {
            this.idtk = new AutoNumeric('#txtidealtks', {
                decimalPlaces: 0,
                decimalCharacter: ',',
                digitGroupSeparator: '.',
                maximumValue: 9000,
                minimumValue: 0
            });
        },
        doupdateadatatk: function(e) {
            e.preventDefault();
            var fm = $('#frmtk')[0];
            var fd = new FormData(fm);
            $.ajax({
                url: './updatedatatk',
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                data: fd,
                type: 'POST',
                success: function(r) {
                    if (r.Err == 1) {
                        swal(r.Msg, 'Error', 'error');
                    } else {
                        swal(r.Msg, 'Success', 'success');
                        view.tblkry.refreshtable();
                        view.pkrytk.clean();
                    }
                },
                error: function(r) {
                    swal(r.Msg, 'Error', 'error');
                }
            });
        }

    });


    $(function() {
        // view.formkry = new formkry();
        // view.formtk = new formtk();
        view.pkrytk = new viewtabelpermintaan();
    });
</script>