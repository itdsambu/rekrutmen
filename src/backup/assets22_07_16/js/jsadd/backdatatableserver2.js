var BackboneDatatableServer= Backbone.View.extend({
   el_table : null, 
   defaultdomchangeid:null,
   defaultdomtable :null,
   currentdomtable:null,
   tabeldata:null,
   jqtabeldata:null,

   scrollX:'100%',
   scrollY:'410px',
   scrollCollapse : 'true',
   sScrollXInner : '100%',

   urlAjax:null,
   extraData :null,
   mybutton:null,
   columnOrder:null,
   columnDefs:null,
   onInfoCallback:null,
   ordering:true,
   onAllDataReturn : null,
   onItemDataReturn :null,
   onRowClick:null,
   onRowCallback:null,
   onDrawCallback:null,
   onInitDone:null,
   onFinishCreate:null,
   returnme:null,
   beforeRefresh:null,
   oldlength:0,
   textsearchid:'searchvalue',
   refreshtable:null,
   onfooter:null,
   originitialize:this.initialization,
   search_template :_.template('<div class="input-group col-sm-12">'+
            '<input class="form-control input-sm" id="<%= searchvalue %>">'+
            '<span class="input-group-btn">'+
                '<button class="btn btn-primary btn-sm btnsearch" type="button">'+
                    '<i class="fa fa-search"></i>'+
                '</button>'+
            '</span>'+
            '</div>'),

   events:{
     "click button.btnsearch" : "searchdata"  
   }
});
BackboneDatatableServer.prototype.hidethetable=function(){
       osettings = this.jqtabeldata.fnSettings();
	   osettings.iDisplayLength = this.oldlength;
	   this.jqtabeldata.fnDraw();   
};
BackboneDatatableServer.prototype.hidethetable=function(){
    this.jqtabeldata.fnClearTable();    
};
BackboneDatatableServer.prototype.doaddevent=function(){
    this.delegateEvents( _.extend(_.clone(this.events),ev)); 
};
BackboneDatatableServer.prototype.thisdone=function(){
    if(this.onFinishCreate) this.onFinishCreate();  
};
BackboneDatatableServer.prototype.changedom=function(){
    this.defaultdomtable = '<"row"<"col-sm-6"l><"col-sm-6"<"col-sm-12"<"' + this.defaultdomchangeid +'">>>><"row"<"fixgrid"tr>><"row"<"col-sm-6"i><"col-sm-6"<"pull-right"p>>>';            
};
BackboneDatatableServer.prototype.defaultchangediddom = function(){
    this.defaultdomchangeid =this.el_table + 'changesearch';
};
BackboneDatatableServer.prototype.searchdom = function(){
    this.textsearchid = this.el_table.slice(1) + this.textsearchid;
	this.refreshtable = this.searchdata;
};
BackboneDatatableServer.prototype.searchdata = function(){
      idfilter = '#'+this.textsearchid;
	  if(this.beforeRefresh){
		   this.beforeRefresh();
	  }
      this.jqtabeldata.fnFilter($(idfilter).val());	
};
BackboneDatatableServer.prototype.initialization = function(){
    this.returnme = this;
    this.originitialize();
};
BackboneDatatableServer.prototype.inittable = function(arcolumn){
    var me = this;
    if(this.el_table==null) return;
    this.defaultchangediddom();
    this.changedom();
    this.searchdom();
    if(this.currentdomtable==null){ this.currentdomtable=this.defaultdomtable;}


    if(this.onAllDataReturn!=null || this.onItemDataReturn!=null)
    {       
         $(this.el_table).on('xhr.dt',function(e,settings,json,xhr){
             if(!json) return;
             if(me.onAllDataReturn){
                 me.onAllDataReturn(json.data);
             }else if(me.onItemDataReturn){
                 if(json.data.length > 0){
                     _.each(json.data,function(item){
                             me.onItemDataReturn(item,me.returnme,e,settings);
                     })
                 }
             }

         });
    }

    if(this.onRowClick!=null){
        $(this.el_table).on('click','tr',{name:me},function(e){
            var data = me.tabeldata.row(this).data();              
            me.onRowClick(data,me.returnme);
        });
    }

   $.when(

    this.jqtabeldata = $(this.el_table).dataTable({
        "scrollX": this.scrollX,
        "scrollY": this.scrollY,
        "scrollCollapse":this.scrollCollapse,
        "sScrollXInner":this.sScrollXInner,
        "columns" : arcolumn,
        "columnDefs":this.columnDefs,
        "dom" : this.currentdomtable,
        "buttons":this.mybutton,
        "ordering":this.ordering,
        "objectparent":this,
        "info":true,
        "footerCallback":function(row,data,start,end,display){
               
            if(me.onfooter){
                me.onfooter(row,data,start,end,display,this);
            }
        },
        "initComplete" : function(se,js){
            var osettings = me.jqtabeldata.fnSettings();
            me.oldlength = osettings.iDisplayLength;
            if(me.onInitDone){                      
                  me.onInitDone(se,js,me);
            }
        },
         "rowCallback":function(row, data, index){
             if(me.onRowCallback)
                 me.onRowCallback(row,data,index);
         },
         "drawCallback": function(setting){
             if(me.onDrawCallback)
                 me.onDrawCallback(setting); 
         },
        "bLengthChange": true,
        "oLanguage":{
            "sProcessing" : function(){
              return "Data still loading..pleae wait";				 
            } 
        },
        "processing":true,
        "serverSide":true,
        "ajax" : {
            url : me.urlAjax,
            type: 'POST',
            data : {
                extradata : me.extraData,
                columnorder:me.columnOrder
            }
        },
         "pagingType":"full_numbers",
    })

    ).done(
         
           this.tabeldata = $(this.el_table).DataTable(),
           $(this.defaultdomchangeid).empty().html(me.search_template({searchvalue:me.textsearchid})),
           this.thisdone()		  
    );
           
};