var view=[];

var bonmodel = Backbone.Model.extend({
	url:'./resetbontk',
	defaults:{
		nofix:'',
		potongan:'',
		periodegajian:'',
		lcid:'',
		idperusahaan:''
	}
});

/*
var boncollect = Backbone.Collection.extend({
	model:bonmodel,
	url:'./resetbontk'
});
*/

var unlockview = Backbone.View.extend({
	el: '#inputcontent',
	mydata:null,
	templateinput:_.template('<button type="button" class="btn btn-primary btn-sm btn-block" id="<%= idbtn %>" ><%= caps %></button>'),
	templatetext:_.template('<div class="checkbox"><label><input type="checkbox" id="cid<%= bonid %>"/></label<</div>'),
	events:{
		'click #btnrefresh':'dorefresh'
	},
	initialize : function(){
		var arcol = [
		{'title':'Dept','data':'BagianAbbr','width':'49'}
		,{'title':'Bagian','data':'Pekerjaan','width':'50'}
		,{'title':'FixNo','data':'Nofix','width':'40'}
		,{'title':'NIK','data':'Nik','width':'35'}
		,{'title':'Nama','data':'Nama','width':'60'}
		,{'title':'Bon','data':'Potongan','width':'50'}
		,{'title':'Lock','data':'locks','width':'50'}
		,{'title':'UnLock','data':'unlock','width':'50'}
		];
		
		view.bontk = new mytabledata({el:'#viewer',model:new bonmodel()});
		view.bontk.returnme = this;
		view.bontk.el_table = '#tblnotbontk';
		view.bontk.urlAjax = './unlocknotbontk';
		
		view.bontk.extraData = {"pemborong":function(){var t = $('#IDPemborong').selectpicker('val');return t;},
		                        "periode":function(){var p = $('#txtperiode').val();return p;}};
		
		view.bontk.onItemDataReturn = function(data,parentme){			
		   if (data.flaglock2==1){
			   data.locks='-';
			   data.unlock='-';
		   }else
		   if (data.islockcv==1 || data.flaglock1==1 ){
			   data.unlock=parentme.templateinput({idbtn:'btnunlock',caps:'UnLock'});
			   data.locks = '-';
		   }else{
			   data.locks=parentme.templateinput({idbtn:'btnlock',caps:'Lock'});
			   data.unlock = '-';
		   }
		   data.cid = 'cid'+data.ID;
        		   
		};
		
		view.bontk.changedom = function(){
			this.defaultdomtable = 'rl<"' + this.defaultdomchangeid +'">t<"#buttonsave.col-lg-12 col-md-12 col-sm-12 col-xs-12">ip'; 
		}
		view.bontk.onRowClick = function(data,parentme){
			parentme.mydata = data;
		}
		
		view.bontk.onFinishCreate = function(){
			//$('#buttonsave').empty().html(this.returnme.templateinput());
		};
    	view.bontk.doaddevent({
			'click #btnsaving':'dosavedata',
			'click #btnlock':'dosavelock',
			'click #btnunlock':'doopenlock'
		});
		
		view.bontk.inittable(arcol);
		
	},
	dorefresh : function(e){
		e.preventDefault();
		view.bontk.searchdata();
	}
});

var mytabledata = BackboneDatatableServer.extend({
	doopenlock: function(e){
		var me = this;
		var curr = $(e.target).parents('td');
		var n = curr.siblings();		
		var row = this.tabeldata.row($(e.target).parents('tr'));
		var ndata = row.data();
		this.model.set({fixno:this.returnme.mydata.ndata,
		                periode:this.returnme.mydata.periode,
						lcid:0});
        this.model.save(null,{
			success: function(model,response){
				console.log(response);
				if(response.error==0){
					 $(n[6]).empty().html(me.returnme.templateinput({idbtn:'btnlock',caps:'Lock'}));
					 curr.empty().html('-');					 					
				}
			}
		});
	},
	dosavelock : function(e){
		var me = this;
		var curr = $(e.target).parents('td');
		var n = curr.siblings();		
		var row = this.tabeldata.row($(e.target).parents('tr'));
		var ndata = row.data();
		this.model.set({fixno:this.returnme.mydata.ndata,
		                periode:this.returnme.mydata.periode,
						lcid:1});
        this.model.save(null,{
			success: function(model,response){
				console.log(response);
				if(response.error==0){
					 $(n[6]).empty().html(me.returnme.templateinput({idbtn:'btnunlock',caps:'UnLock'}));
					 curr.empty().html('-');					 					
				}
			}
		});
	}
	
});

$(function(){
	 $('#selectperusahaan').selectpicker();
	 view.unlview = new unlockview();	 
});