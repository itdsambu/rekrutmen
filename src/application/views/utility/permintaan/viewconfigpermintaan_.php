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
                                <th>Existing</th>
                                <th>Req. Kry Approve</th>
                                <th>Req. Kry Pending</th>
                                <th>Ideal TK</th>
                                <th>Real TK</th>
                                <th>Req. TK Approve</th>
                                <th>Req. TK Pending</th>
                                <th>Periode</th>
                                <th>Update By</th>
                                <th>Update Date</th>
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
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    <div id="formupdate"></div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6" id="inputdataform">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Update Data Ideal Karyawan</h3>
                                </div>
                                <div class="panel-body" id="formkry">
                                    <div class="row">
                                        <div class="col-sm-12">


                                            <form action="<?= base_url('configpermintaan/updatedata') ?>" name="frmkry" id="frmkry" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                                <input type="hidden" id="idkrydept" name="idkrydept">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Dept</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="txtdeptname" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Jmlh.Kry Real</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="txtrealkry" name="stxtrealkry" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Jmlh.Kry Ideal</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="txtidealkry" readonly>
                                                        </div>
                                                        <label class="col-sm-2 control-label">Update</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="txtidealkrys" name="stxtidealkry" required maxlength="5" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-9">
                                                            <button type="submit" id="btnuploadmemo" class="btn btn-primary btn-sm">Simpan</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6" id="inputdataform">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">Update Data Ideal TK</h3>
                                </div>
                                <div class="panel-body" id="formtk">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <form action="<?= base_url('configpermintaan/updatedatatk') ?>" name="frmtk" id="frmtk" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                                <input type="hidden" id="idkrrybor" name="idkrrybor">
                                                <div class="form-horizontal">
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Dept</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="txtdepttk" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Jmlh. TK Real</label>
                                                        <div class="col-sm-6">
                                                            <input type="text" class="form-control" id="txtrealtk" name="txtrealtk" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label">Jmlh. TK Ideal</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="txtidealtk" name="txtidealtk" readonly>
                                                        </div>
                                                        <label class="col-sm-2 control-label">Update</label>
                                                        <div class="col-sm-2">
                                                            <input type="text" class="form-control" id="txtidealtks" name="txtidealtks" accept="application/pdf" required maxlength="5" value="0">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="col-sm-3"></div>
                                                        <div class="col-sm-9">
                                                            <button type="submit" id="btnuploadmemotk" class="btn btn-primary btn-sm">Simpan</button>
                                                        </div>
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
                    'data': 'DeptAbbr'
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
                },
                {
                    'data': 'UpdatedBy',
                    'className': 'text-right'
                },
                {
                    'data': 'UpdatedDate',
                    'className': 'text-right'
                }
            ];
            view.tblkry = new vwtabledata();
            view.tblkry.urlAjax = './getdatacountkrytk';
            view.tblkry.returnme = this;


            view.tblkry.onRowClick = function(d, m) {
                console.log(d);

                $('#idkrydept').val(d.DeptKry);
                $('#txtdeptname').val(d.DeptAbbr);
                $('#txtrealkry').val(d.RKry);
                $('#txtidealkry').val(d.IDEALKARYAWAN);
                $('#idkrrybor').val(d.DeptBor);
                $('#txtrealtk').val(d.RBor);
                $('#txtidealtk').val(d.IDEALBOR);
                $('#txtidealtks').val(d.IDEALBOR);
                $('#txtdepttk').val(d.DeptAbbr);
                view.formkry.idsave.set(d.IDEALKARYAWAN);
                view.formtk.idtk.set(d.IDEALBOR);
            };
            view.tblkry.inittable(rowdata);
        },
        clean: function() {
            $('#idkrydept').val('');
            $('#txtdeptname').val('');
            $('#txtrealkry').val('');
            $('#txtidealkry').val('');
            $('#idkrrybor').val('');
            $('#txtrealtk').val('');
            $('#txtidealtk').val('');
            $('#txtidealtks').val('');
            $('#txtdepttk').val('');
            view.formkry.idsave.set(0);
            view.formtk.idtk.set(0);
            $('a.remove').trigger('click');
        }
    });

    var vwtabledata = BackboneDatatableServer.extend({
        el: '#viewtabel',
        el_table: '#tblsettingkrytk',
        urlAjax: './getdatacountkrytk',
        onfooter: function(r, d, s, e, display, my) {
            dept = $('#tblsettingkrytksearchvalue').val() != '' ? $('#tblsettingkrytksearchvalue').val() : 'dept'
            // console.log(test);

            var api = my.api();
            $.get('./getajaxsummary', {
                dept: dept
            }, function(res) {
                j = res.data[0];
                // $(api.column(1).footer()).html(232323);
                $(api.column(1).footer()).html(j.Ideal_Kry);
                $(api.column(2).footer()).html(j.Real_Kry);
                $(api.column(3).footer()).html(j.ReqK);
                $(api.column(4).footer()).html(j.ReqKP);
                $(api.column(5).footer()).html(j.Ideal_Bor);
                $(api.column(6).footer()).html(j.Real_Bor);
                $(api.column(7).footer()).html(j.ReqB);
                $(api.column(8).footer()).html(j.ReqBP);
                $(api.column(9).footer()).html(j.UpdatedBy);
            }, 'json');
        }
    })

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
                    console.log(r)
                    if (r.Err == 1) {
                        swal(r.Msg, 'Error', 'error');
                    } else {
                        swal(r.Msg, 'Success', 'success');
                        view.tblkry.refreshtable();
                        view.pkrytk.clean();
                    }
                },
                error: function(e) {
                    // alert('apa');
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
                    console.log(r);
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
        view.formkry = new formkry();
        view.formtk = new formtk();
        view.pkrytk = new viewtabelpermintaan();
        $('#txtmemokry').ace_file_input({
            no_file: 'Pilih file memo yang akan disimpan',
            dropable: false,
            onchange: null,
            thumbnail: false
        });
        $('#txtmemotk').ace_file_input({
            no_file: 'Pilih file memo yang akan disimpan',
            dropable: false,
            onchange: null,
            thumbnail: false
        });
    });
</script>