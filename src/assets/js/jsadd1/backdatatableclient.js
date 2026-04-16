var BackboneDatatableClient= Backbone.View.extend({
    tabeldata:null,
    jqtabeldata:null,
    el_table:null,
    m_data:null,
    domtable : 'rlftip',
    currentrow:null,
    currentdata:null,
    parent:null,
    field_edit : null,
    field_delete : null,

    ColumnDefs:null,

    //event api
    onRowAdd : null,
    onDelete : null,
    onSave:null,
    onBeforeEdit:null,
    onEdit:null,
    onBeforeDelete:null,
    confirmDelete:true,
    inprocess:0,
    fetchall:null,

    btnedit_template:_.template('<button type="button" class="btn btn-default btn-xs <%= btnclass %>"><i class="fa fa-pencil-square-o"aria-hidden="true"></i></button>'),
    btnsave_template:_.template('<button type="button" class="btn btn-default btn-xs <%= btnclass %>"><i class="fa fa-check" aria-hidden="true"></i></button>'),
    btncancel_template:_.template('<button type="button" class="btn btn-default btn-xs <%= btnclass %>"><i class="fa fa-times" aria-hidden="true"></i></button>'),
    btndelete_template: _.template('<button type="button" class="btn btn-default btn-xs <%= btnclass %>"><i class="fa fa-times"aria-hidden="true"></i></button>'),

    events : {
        "click .btncancel" : "canceldata",
        "click .btnsave" : "savedata",
        "click .btndelete" : "deletedata",
        "click .btnedit" : "editdata"
    },

    set_tableColumns : function(arcolumn){

        if(this.el_table==null) return;
        
        this.jqtabeldata = $(this.el_table).dataTable({
        "sScrollY": "410px",
        "scrollX": "100%",
        "scrollCollapse":true,
        "sScrollXInner": "100%",
        "columns" : arcolumn,
        "dom" : this.domtable,
        "ordering":this.ordering,
        "serverSide":false,
        "language":{
          "processing":"Data is loading..please wait"
        },
        "processing":true,
        "pagingType":"full_numbers"
      });

      this.tabeldata = $(this.el_table).DataTable();
    },
    add_data_row:function(data,iscomplete){
        if(iscomplete==1){
          this.tabeldata.row.add(data).draw();
        }else{
            if(_.has(data,this.field_edit)==false){
                if(this.field_edit!==null) data[this.field_edit] = this.btnedit_template({btnclass:'btnedit'});
            }
            if(_.has(data.field_delete)==false){
                if(this.field_delete!==null) data[this.field_delete] = this.btndelete_template({btnclass:'btndelete'});
            }
            this.tabeldata.row.add(data).draw();
        }
    },
    getcell: function(datarow,idtext){
      var dr = $(datarow.node()).find('td').find(idtext);
      return dr;
    },
    getalldata : function(){
       this.inprocess = 0;
       this.tabeldata.clear().draw(); 
       if(this.fetchall){
           this.fetchall();
       }
    }
    ,add_datable : function(){
        var me = this;
        if(this.inprocess>0) return;
        this.inprocess=1;
        if(this.jqtabeldata.find('.isadd').length > 0) return;

        var data = $.extend(true,{},this.m_data);
        this.changebuttontemplate(data,true); 

        if(this.onRowAdd){
            this.onRowAdd(data,me.parent); //fire event onRowAdd
        }
        var rowNode = this.tabeldata.row.add(data).draw().node();
        $(rowNode).addClass('isadd');
    }

    //save data
    ,savedata : function(e){
        e.preventDefault();
        var me =this;
        var i = this.inprocess;
        var datarow = this.tabeldata.row($(e.target).parents('tr'));        
        if(this.onBeforeSave){
            this.onBeforeSave(function(ishalt){
                if(!ishalt) return;
                me.internalsave(datarow,me,i);
            },datarow,me);
        }else{
            this.internalsave(datarow,this,i);
        }        
    }

    //internalsave
    ,internalsave : function(mydata,me,state){
        var my=me;
        if(me.onSave){
            me.onSave(mydata,function(completed,databack){
                if(completed){
                    var d = mydata.data();
                    if(databack) d=databack;
                    me.changebuttontemplate(d,false,me);
                    mydata.data(d).draw();
                    var node = mydata.node();
                    me.jqtabeldata.find('.isadd').removeClass('isadd');
                    me.jqtabeldata.find('.isedit').removeClass('isedit');
                    console.log(node);
                    console.log(me.jqtabeldata.find('.isadd'));
                }
            },state);
        }
        me.inprocess=0;
    }

    //cancel data
    ,canceldata : function(e){
        e.preventDefault();
        if(this.tabeldata.row('.isadd').length > 0) this.tabeldata.row('.isadd').remove().draw();
        if(this.tabeldata.row('.isedit').length>0){
            this.tabeldata.row('.isedit').data(this.currentdata).draw();
            this.jqtabeldata.find('.isedit').removeClass('.isedit');
        }
        this.inprocess = 0;
    }

    //delete data
    ,deletedata : function(e){
       e.preventDefault();
       var me= this;
       if(this.inprocess) return;
       var datarow = this.tabeldata.row($(e.target).parents('tr')); 

       if(this.confirmDelete){
           if(this.onDelete){
               this.onDelete(datarow,function(continuedelege){
                   if(continuedelege==true){
                       //datarow.remove().draw();
                       me.getalldata();
                   }
               })
           }else{
               //datarow.remove().draw();
               me.getalldata();
           }
       }

    }

    //edit data
    ,editdata : function(e){
        e.preventDefault();
        if(this.inprocess > 0) return;
        this.inprocess = 2;
        var me =this;
        var datarow = this.tabeldata.row($(e.target).parents('tr')); 
        var mydata =datarow.data();
        this.currentdata = $.extend(true,{},mydata);

        var n = datarow.node();
        $(n).addClass('isedit');
        
        
        if(this.onEdit){
            this.onEdit(datarow,function(data,iscontinue){
               if(iscontinue){
                   me.changebuttontemplate(data,true,me);
                    datarow.data(data).draw();                   
               }
            });
            return this;
        }else{
           return this; 
        }
    }

    ,changebuttontemplate : function(data,isedit,me){
        var sellf = this;
        if(me) sellf = me;
        if(isedit){
          if(_.has(data,sellf.field_edit)) data[sellf.field_edit] = sellf.btnsave_template({btnclass:'btnsave'});
          if(_.has(data,sellf.field_delete)) data[sellf.field_delete] = sellf.btncancel_template({btnclass:'btncancel'});
        }else{           
          if(_.has(data,sellf.field_edit)) data[sellf.field_edit] = sellf.btnedit_template({btnclass:'btnedit'});
          if(_.has(data,sellf.field_delete)) data[sellf.field_delete] = sellf.btndelete_template({btnclass:'btndelete'});  
        }
        return sellf;
    }


});