var view=[];

var bonmodel = Backbone.Model.extend({
	defaults:{
		nofix:'',
		potongan:'',
		periodegajian:'',
		lcid:'',
		idpemborong:'',
		idperusahaan:''
	}
});

var boncollect = Backbone.Collection.extend({
	model:bonmodel,
	url:'./storebon' 
});

// var isibon = Backbone.View.extend({
// 	el:'#inputcontent',
// 	mydata:null,
// 	islockdata:100,
// 	templateinput:_.template('<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">'+
// 	                         '</div>'+
// 						     '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 divbontk">'+
// 							     '<button id="btnsaving" class="btn btn-primary btn-sm btn-block marginbottom10">Simpan</button>'+
// 						     '</div>'),
//     templatetext:_.template('<div>'+
//     	'<input type="text" class="input-control input-sm" onkeydown="return numbersonly(this, event);" onkeyup="javascript:tandaPemisahTitik(this);" data-target="<%= bonid %>" value="<%= bondata %>"/>'+
//     	'</div>'),

// 	events:{
// 		'click #btnrefresh':'dorefresh'
// 	},

var isibon = Backbone.View.extend({
	el:'#inputcontent',
	mydata:null,
	islockdata:100,
	issanksi:0,
	ismin:0,
	ismax:0,
	templateinput:_.template('<div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">'+
	                         '</div>'+
						     '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 divbontk">'+
							     '<button id="btnsaving" class="btn btn-primary btn-sm btn-block marginbottom10">Simpan</button>'+
						     '</div>'),
    templatetext:_.template('<input type="text" class="autonumerik input-control input-sm" data-target="<%= bonid %>" value="<%= databon %>"/>'),
	// templatetextms:_.template('<input type="text" max=200000 class="autonumerikms input-control input-sm" data-target="<%= bonid %>" value="<%= bondata %>"/>'),
	events:{
		'click #btnrefresh':'dorefresh'
	},

	initialize: function(){
		var acol = [
		{'title':'Dept','data':'BagianAbbr','width':'49'}
		,{'title':'Bagian','data':'Pekerjaan','width':'50'}
		,{'title':'FixNo','data':'Nofix','width':'40'}
		,{'title':'NIK','data':'Nik','width':'40'}
		,{'title':'Nama','data':'Nama','width':'100'}
		,{'title':'Bon','data':'Potongan','width':'50'}
		];
		
		view.bontk = new mytabledata({el:'#viewer',collection:new boncollect()});
		view.bontk.returnme = this;
		view.bontk.el_table = '#tblnotbontk';
		view.bontk.urlAjax = './notbontk';
		view.bontk.columnDefs = [
		   {"orderable":false,"targets":5}
		   // {"visible":false,"targets":}//isikan target yang akan di hidden.
		];

		
		view.bontk.extraData = {"pemborong":function(){var t=$('#IDPemborong').selectpicker('val');return t;},
		                        "bontk":function(){var i = 0;if($('#bonshow').hasClass('active')){i=1;} return i;},
		                        "periode":function(){ var periode=$('#txtperiodehidden').val();return periode}};
        //"bontk":function(){ var state=$('#selectbontype').selectpicker('val');return state; },								
		/*function(){
			var val ={'perusahaanid':
                         			$('#selectperusahaan').selectpicker('val'),'statusbon':$('#selectbontype').selectpicker('val')};
			return val;
		};
		*/	
		
		view.bontk.onItemDataReturn = function(data,parentme){	
			 console.log(data);

			 if(parentme.issanksi!=data.sanksi){
			 	parentme.issanksi=data.sanksi;
			  }	

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
		   // if(data.islockcv==0){
		   //   var str = parentme.templatetext({bonid:data.ID,bondata:data.Potongan});
		   //   data.Potongan=formatNumber(str);
		   // }
		    if(data.islockcv==0){
		         str = parentme.templatetext({bonid:data.ID,databon:data.Potongan});
		         data.Potongan=formatNumber(str);			   
		      // data.Bon=str;

		   }
		   // if(parentme.ismin!=data.ismin){
			  //  parentme.ismin =data.ismin;
		   // };
		   // if(parentme.ismax!=data.ismax){
			  //  parentme.ismax = data.ismax;
		   // }
		};
			
				
		//view.bontk.currentdomtable = 'lrt<"#buttonsave.col-lg-12 col-md-12 col-sm-12 col-xs-12">ip';
		view.bontk.changedom = function(){
			this.defaultdomtable = 'rl<"' + this.defaultdomchangeid +'">t<"#buttonsave.col-lg-12 col-md-12 col-sm-12 col-xs-12">ip'; 
			//$('#buttonsave').empty().html(this.returnme.templateinput());
		}
		view.bontk.onFinishCreate = function(){
			$('#buttonsave').empty().html(this.returnme.templateinput());
		};

		view.bontk.onDrawCallback = function(setting){
			if(view.inbon.issanksi == 1){
				new AutoNumeric.multiple('.autonumerik',{
				"decimalPlaces":3,
				"digitGroupSeparator":"",
				"decimalCharacter":",",
				"maximumValue":200000,
				"minimumValue":0,
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
			bont = bont
			    .replace(/\./g, '')  // replace all separators
			    .replace(/,/, '.');  // replace comma with dot 

			data.Potongan = parseFloat(bont);
			me.collection.add([{nofix:data.Nofix,potongan:data.Potongan,periodegajian:$('#txtperiodehidden').val(),lcid:cid,idpemborong:$('#IDPemborong').selectpicker('val'),idperusahaan:''}]);			
		})
		
		).then(
		    $('#btnsaving').prop('disabled',true)
		).done(
		     
			Backbone.sync('create',me.collection,
			                  {emulateJSON:true,
								  success: function(response){
									 console.log(response); 
									 
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
   

	$('input[type="text"]').keyup(function(e) {
	    if(e.keyCode == 13) {
	        $(this).next().focus();
	    }
	});
});

function tandaPemisahTitik(b){
	var _minus = false;
	if (b<0) _minus = true;
	b = b.toString();
	b=b.replace(".","");
	
	c = "";
	panjang = b.length;
	j = 0;
	for (i = panjang; i > 0; i--){
		 j = j + 1;
		 if (((j % 3) == 1) && (j != 1)){
		   c = b.substr(i-1,1) + "." + c;
		 } else {
		   c = b.substr(i-1,1) + c;
		 }
	}
	if (_minus) c = "-" + c ;
	return c;
}

function numbersonly(ini, e){
	if (e.keyCode>=49){
		if(e.keyCode<=57){
		a = ini.value.toString().replace(".","");
		b = a.replace(/[^\d]/g,"");
		b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
		ini.value = tandaPemisahTitik(b);
		return false;
		}
		else if(e.keyCode<=105){
			if(e.keyCode>=96){
				//e.keycode = e.keycode - 47;
				a = ini.value.toString().replace(".","");
				b = a.replace(/[^\d]/g,"");
				b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
				ini.value = tandaPemisahTitik(b);
				//alert(e.keycode);
				return false;
				}
			else {return false;}
		}
		else {
			return false; }
	}else if (e.keyCode==48){
		a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
		b = a.replace(/[^\d]/g,"");
		if (parseFloat(b)!=0){
			ini.value = tandaPemisahTitik(b);
			return false;
		} else {
			return false;
		}
	}else if (e.keyCode==95){
		a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
		b = a.replace(/[^\d]/g,"");
		if (parseFloat(b)!=0){
			ini.value = tandaPemisahTitik(b);
			return false;
		} else {
			return false;
		}
	}else if (e.keyCode==8 || e.keycode==46){
		a = ini.value.replace(".","");
		b = a.replace(/[^\d]/g,"");
		b = b.substr(0,b.length -1);
		if (tandaPemisahTitik(b)!=""){
			ini.value = tandaPemisahTitik(b);
		} else {
			ini.value = "";
		}
		
	return false;
	} else if (e.keyCode==9){
		return true;
	} else if (e.keyCode==17){
		return true;
	} else {
		//alert (e.keyCode);
	return false;
	}

}

function formatNumber (num) {
    var hasil = num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    // var hasilakhir = hasil.replace(",", "");
    return hasil;
}