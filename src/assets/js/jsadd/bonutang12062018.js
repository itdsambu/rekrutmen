var view = {};

var bonmodel = Backbone.Model.extend({
	defaults:{
		fixno:'',
		bon:'',
		periode:'',
		lcid:'',
		idperusahaan:'',
		ms:12
	}
});

var boncollect = Backbone.Collection.extend({
	model:bonmodel,
	url:'./storebon' 
});

var isibon = Backbone.View.extend({
	el:'#inputcontent',
	mydata:null,
	islockdata:100,
	templateinput:_.template('<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">'+
	                         '</div>'+
						     '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 divbontk">'+
							     '<button id="btnsaving" class="btn btn-primary btn-sm btn-block marginbottom10">Simpan</button>'+
						     '</div>'),
    templatetext:_.template('<input type="text" max=200000 class="autonumerik input-control input-sm" data-target="<%= bonid %>" value="<%= bondata %>"/>'),
	templatetextms:_.template('<input type="text" max=200000 class="autonumerikms input-control input-sm" data-target="<%= bonid %>" value="<%= bondata %>"/>'),
	events:{
		'click #btnrefresh':'dorefresh'
	},
	initialize: function(){
		var acol = [
		{'title':'Dept','data':'DeptAbbr','width':'49'}
		,{'title':'Bagian','data':'Pekerjaan','width':'100'}
		,{'title':'NIK','data':'Nik','width':'40'}
		,{'title':'Nama','data':'Nama','width':'100'}
		,{'title':'Bon','data':'Bon','width':'50'}
		];
		
		view.bontk = new mytabledata({el:'#viewer',collection:new boncollect()});
		view.bontk.returnme = this;
		view.bontk.el_table = '#tblnotbontk';
		view.bontk.urlAjax = './notbontk';
		view.bontk.columnDefs = [
		   {"orderable":false,"targets":4}
		];
		
		view.bontk.extraData = {"perusahaan":function(){var t=$('#selectperusahaan').selectpicker('val');return t;},
		                        "bontk":function(){var i = 0;if($('#bonshow').hasClass('active')){i=1;} return i;},
								"mskerja":function(){var i = 0;if($('#ms3month').hasClass('active')){i=1;} return i;},
		                        "periode":function(){ var periode=$('#txtperiodehidden').val();return periode}};
        //"bontk":function(){ var state=$('#selectbontype').selectpicker('val');return state; },								
		/*function(){
			var val ={'perusahaanid':
                         			$('#selectperusahaan').selectpicker('val'),'statusbon':$('#selectbontype').selectpicker('val')};
			return val;
		};
		*/
		
		
		
		view.bontk.onItemDataReturn = function(data,parentme){		
		   if(data.islockcv==0){
			   if(parentme.islockdata!=0){
				   parentme.islockdata=0;
				   $('#buttonsave').empty().html(this.returnme.templateinput());
			   }
			   if($('#txtstate').html()!='')   $('#txtstate').empty(); 
		   }else{
			   if(parentme.islockdata!=1){
				   parentme.islockdata=1;
				   $('#buttonsave').empty();
			   }
			   if($('#txtstate').html()=='') $('#txtstate').html('( Lock )');
		   }
		   if(data.islockcv==0){
			   var str;
			   if(data.ms > 3) {
		         str = parentme.templatetext({bonid:data.ID,bondata:data.Bon});
			   }else{
				 str = parentme.templatetextms({bonid:data.ID,bondata:data.Bon});  
			   }	 
		      data.Bon=str;
		   }
			 
		};			
		view.bontk.changedom = function(){
			this.defaultdomtable = 'l<"' + this.defaultdomchangeid +'"><tr><"#buttonsave.col-lg-12 col-md-12 col-sm-12 col-xs-12">ip'; 
		}
		view.bontk.onFinishCreate = function(){
			$('#buttonsave').empty().html(this.returnme.templateinput());
		};
		view.bontk.onDrawCallback = function(setting){
			if($('.autonumerik').length > 0 ) {
			new AutoNumeric.multiple('.autonumerik',{
				"decimalPlaces":0,
				"digitGroupSeparator":".",
				"decimalCharacter":",",
				"maximumValue":90000000,
				"minimumValue":0
			});
			}
			if($('.autonumerikms').length>0){
			new AutoNumeric.multiple('.autonumerikms',{
				"decimalPlaces":0,
				"digitGroupSeparator":".",
				"decimalCharacter":",",
				"maximumValue":200000,
				"minimumValue":0
			});
			}
		};	
		
    	view.bontk.doaddevent({
			'click #btnsaving':'dosavedata'
		});
		

		view.bontk.inittable(acol);
	},
	dorefresh : function(e){
		e.preventDefault();
		view.bontk.searchdata();
	}
});

var mytabledata = BackboneDatatableServer.extend({
	dosavedata : function(e){
		var me = this;
		var mymodel = new bonmodel();
		var bont=0;
		var cid=0;
		var data=null;
		e.preventDefault();
		
		
		this.collection.reset();
        
		$.when(
		
		this.tabeldata.rows().every(function(rowIdx,tableLoop,rowLoop){
			bont = $(this.node()).find('input').val();
			lcid = $(this.node()).find('input').attr('data-target');
			var data = this.data();
			data.Bon=bont;
			me.collection.add([{fixno:data.ndata,bon:data.Bon,periode:$('#txtperiodehidden').val(),lcid:cid,idperusahaan:$('#selectperusahaan').selectpicker('val'),ms:data.ms}]);			
		})
		
		).then(
		    $('#btnsaving').prop('disabled',true)
		).done(
		     
			Backbone.sync('create',me.collection,
			                  {emulateJSON:true,
								  success: function(response){
									 me.searchdata();									
									 if(response.error==1){
										 swal('Simpan Data','Gagal, Input Bon untuk periode telah di tutup','error');										 
									 }else{
										  $('#btnsaving').prop('disabled',false);
										  swal('Simpan Data','Berhasil, Simpan data','success');
									 }
							      }
							  })
			
		);
		
		
	}
})



$(function(){
   
   view.inbon = new isibon({model:new bonmodel()});
   $('#selectperusahaan').selectpicker();
   
});