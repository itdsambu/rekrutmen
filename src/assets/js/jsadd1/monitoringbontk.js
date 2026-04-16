var view=[];

var viewbon = Backbone.View.extend({
	el:'#inputcontent',
	events:{
		'click #btnrefresh':'dorefresh'
	},
	initialize: function(){
		var acol = [
		 {'title':'Dept','data':'BagianAbbr','width':'49'}
		,{'title':'Bagian','data':'Pekerjaan','width':'100'}
		,{'title':'Fixno','data':'Nofix','width':'40'}
		,{'title':'NIK','data':'Nik','width':'40'}
		,{'title':'Nama','data':'Nama','width':'100'}
		,{'title':'Bon','data':'Potongan','width':'50'}
		];
		
		view.bontk = new BackboneDatatableServer({el:'#viewer'});
		view.bontk.returnme = this;
		view.bontk.el_table = '#tblnotbontk';
		view.bontk.urlAjax = './havebontk';
		view.bontk.columnDefs = [
		   {"orderable":false,"targets":5}
		   // {"visible":false,"targets":2} untuk menghidden fild yang ada di monitor BON
		];
		
		view.bontk.extraData = {"pemborong":function(){var t=$('#IDPemborong').selectpicker('val');return t;},
		                        "bontk":function(){ var state=$('#selectbontype').selectpicker('val');return state; },
								"periode":function(){var periode=$('#selectperiod').selectpicker('val'); return periode;}
								};
								
        view.bontk.onItemDataReturn = function(data,parentme){
		   var Potongan = data.Potongan;
           var str = format('#.###.###,',Potongan);
		   data.Potongan=str.replace(",",".");
		   console.log(data.totalsum);
		   $('#idtotal').val(data.totalsum.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1."));			
		};								
	
		view.bontk.inittable(acol);
	},
	dorefresh : function(e){
		e.preventDefault();
		view.bontk.searchdata();
	}
});


$(function(){
	view.vbontk = new viewbon();
});



