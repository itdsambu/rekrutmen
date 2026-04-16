var BackboneDatatableServer = Backbone.View.extend({
    el_table: null,
    defaultdomchangeid: null,
    defaultdomtable: null,
    currentdomtable: null,
    tabeldata: null,
    jqtabeldata: null,

    scrollX: '100%',
    scrollY: '410px',
    scrollCollapse: 'true',
    sScrollXInner: '100%',

    urlAjax: null,
    extraData: null,
    mybutton: null,
    columnOrder: null,
    columnDefs: null,
    onInfoCallback: null,
    ordering: true,
    onAllDataReturn: null,
    onItemDataReturn: null,
    onRowClick: null,
    onRowCallback: null,
    onDrawCallback: null,
    onInitDone: null,
    onFinishCreate: null,
    returnme: null,
    beforeRefresh: null,
    oldlength: 0,
    textsearchid: 'searchvalue',
    refreshtable: null,
    search_template: _.template('<div class="form-horizontal"> ' +
        '<div class="col-md-3 col-sm-4 col-xs-6 col-md-offset-9 col-sm-offset-8">' +
        ' <div class="form-group">' +
        '<label class="control-label col-md-3 col-sm-3 col-xs-12">Search</label>' +
        '<div class="col-md-9 col-sm-9 col-xs-12">' +
        '<div class="input-group">' +
        '<input class="form-control input-sm" id="<%= searchvalue %>">' +
        '<span class="input-group-btn">' +
        '<button class="btn btn-primary btn-sm btnsearch" type="button">' +
        '<i class="fa fa-search"></i>' +
        '</button>' +
        '</span>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>' +
        '</div>'),

    events: {
        "click button.btnsearch": "searchdata"
    },
    initialization: function () {
        this.returnme = this;
    },
    defaultchangediddom: function () {
        this.defaultdomchangeid = this.el_table + 'changesearch';
    },
    changedom: function () {
        this.defaultdomtable = 'l<"' + this.defaultdomchangeid + '">trip';
    },
    searchdom: function () {
        this.textsearchid = this.el_table.slice(1) + this.textsearchid;
        this.refreshtable = this.searchdata;
    },
    inittable: function (arcolumn) {
        var me = this;
        if (this.el_table == null) return;
        this.defaultchangediddom();
        this.changedom();
        this.searchdom();
        if (this.currentdomtable == null) { this.currentdomtable = this.defaultdomtable; }


        if (this.onAllDataReturn != null || this.onItemDataReturn != null) {

            $(this.el_table).on('xhr.dt', function (e, settings, json, xhr) {
                if (!json) return;
                if (me.onAllDataReturn) {
                    me.onAllDataReturn(json.data);
                } else if (me.onItemDataReturn) {
                    if (json.data.length > 0) {
                        _.each(json.data, function (item) {
                            me.onItemDataReturn(item, me.returnme, e, settings);
                        })
                    }
                }

            });
        }

        if (this.onRowClick != null) {
            $(this.el_table).on('click', 'tr', { name: me }, function (e) {
                var data = me.tabeldata.row(this).data();
                me.onRowClick(data, me.returnme);
            });
        }

        $.when(

            this.jqtabeldata = $(this.el_table).dataTable({
                "scrollX": this.scrollX,
                "scrollY": this.scrollY,
                "scrollCollapse": this.scrollCollapse,
                "sScrollXInner": this.sScrollXInner,
                "columns": arcolumn,
                "columnDefs": this.columnDefs,
                "dom": this.currentdomtable,
                "buttons": this.mybutton,
                "ordering": this.ordering,
                "objectparent": this,
                "info": true,
                "initComplete": function (se, js) {
                    var osettings = me.jqtabeldata.fnSettings();
                    me.oldlength = osettings.iDisplayLength;
                    if (me.onInitDone) {
                        me.onInitDone(se, js, me);
                    }
                },
                "rowCallback": function (row, data, index) {
                    if (me.onRowCallback)
                        me.onRowCallback(row, data, index);
                },
                "drawCallback": function (setting) {
                    if (me.onDrawCallback)
                        me.onDrawCallback(setting);
                },
                "bLengthChange": true,
                "oLanguage": {
                    "sProcessing": function () {
                        return "Data still loading..pleae wait";
                    }
                },
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: me.urlAjax,
                    type: 'POST',
                    data: {
                        extradata: me.extraData,
                        columnorder: me.columnOrder
                    }
                },
                "pagingType": "full_numbers",
            })

        ).done(

            this.tabeldata = $(this.el_table).DataTable(),
            $(this.defaultdomchangeid).empty().html(me.search_template({ searchvalue: me.textsearchid })),
            this.thisdone()
        );

    },
    thisdone: function () {
        if (this.onFinishCreate) this.onFinishCreate();
    },
    searchdata: function () {
        var idfilter = '#' + this.textsearchid;
        if (this.beforeRefresh) {
            this.beforeRefresh();
        }
        this.jqtabeldata.fnFilter($(idfilter).val());
    },
    doaddevent: function (ev) {
        this.delegateEvents(_.extend(_.clone(this.events), ev));
    },
    hidethetable: function () {
        this.jqtabeldata.fnClearTable();
        return;
        var osettings = this.jqtabeldata.fnSettings();
        this.oldlength = osettings.iDisplayLength;
        osettings.iDisplayLength = 0;
        this.jqtabeldata.fnDraw();

    },
    showthetable: function () {
        var osettings = this.jqtabeldata.fnSettings();
        osettings.iDisplayLength = this.oldlength;
        this.jqtabeldata.fnDraw();
    }
});