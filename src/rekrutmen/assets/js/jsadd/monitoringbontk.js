var view=[];

var viewbon = Backbone.View.extend({
	el:'#inputcontent',
	templateform : _.template('<input type="hidden" name="<%= name1 %>" value="<%= val1 %>"><input type="hidden" name="<%= name2 %>" value="<%= val2 %>">'),
	events:{
		'click #btnrefresh':'dorefresh',
		'click #btnconvertexcel':'doexcel',
        'click #btntopdf':'dopdf'		
	},
	initialize: function(){
		var acol = [
		 {'title':'Dept','data':'DeptAbbr','width':'49'}
		,{'title':'Bagian','data':'Pekerjaan','width':'75'}
		,{'title':'NIK','data':'Nik','width':'40'}
		,{'title':'Nama','data':'Nama','width':'100'}
		,{'title':'TglMsk','data':'tglmasuk','width':'70'}
		,{'title':'Bon','data':'Bon','width':'50'}
		,{'title':'Tgl Update','data':'tglupdate','width':'50'}
		,{'title':'Oleh User','data':'useroleh','width':'50'}
		];
		
		view.bontk = new BackboneDatatableServer({el:'#viewer'});
		view.bontk.returnme = this;
		view.bontk.el_table = '#tblnotbontk';
		view.bontk.urlAjax = './havebontk';
		
		view.bontk.extraData = {"perusahaan":function(){var t=$('#selectperusahaan').selectpicker('val');return t;},
		                        "bontk":1,
								"ms":0,
								"periode":function(){var periode=$('#selectperiod').selectpicker('val'); return periode;}
								};
		view.bontk.beforeRefresh = function(){
			$('#sumtotal').val('0');  
		};						
        view.bontk.onItemDataReturn = function(data,parentme){
		   var bon = data.Bon;
		   var totalbon = format('#,###.',data.totalbon);
           var str = format('#,###.',bon);
		   data.Bon=str.replace(",",".");
		   $('#sumtotal').val(totalbon);
		};								
	
		view.bontk.inittable(acol);
	},
	dorefresh : function(e){
		e.preventDefault();
		view.bontk.searchdata();
	},
	doexcel : function(e){
		e.preventDefault();
		var p = $('#selectperusahaan').selectpicker('val');
		var periode=$('#selectperiod').selectpicker('val'); 
		var pdata = this.templateform({"name1":"perusahaan","val1":p,"name2":"periode","val2":periode});
		$('#helperform').empty().html(pdata);
		document.helperform.submit();
	},
	dopdf : function(e){
		e.preventDefault();
		var p = $('#selectperusahaan').selectpicker('val');
		var periode=$('#selectperiod').selectpicker('val'); 
		var pdata = this.templateform({"name1":"perusahaan","val1":p,"name2":"periode","val2":periode});
		$('#helperpdf').empty().html(pdata);
		document.helperpdf.submit();
	}
});


$(function(){
	view.vbontk = new viewbon();
});



