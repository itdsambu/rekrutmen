var view = [];


var viewbontkpt = Backbone.View.extend({

     el:'#inputcontent',
	 events:{
		'click #btnrefresh':'dorefresh'
	 },
	 initialize : function(){
		 
		 var arcol = [
		     {'title':'Pemborong','data':'pemborong','width':'0'},
			 {'title':'Total TK','data':'totalkar','width':'70'},
			 {'title':'Update','data':'totalsetup','width':'70'},
			 {'title':'Belum Update','data':'sisa','width':'70'}
		 ];
		 view.bonpt = new BackboneDatatableServer('#viewcontent');
		 view.bonpt.el_table = '#tblcounttk';
		 view.bonpt.returnme=this;
		 view.bonpt.urlAjax = './bonptmonitor';
		 view.bonpt.extraData = {"pemborong":function(){var t=$('#IDPemborong').selectpicker('val');return t;},
		                         "periode":function(){var periode=$('#selectperiod').selectpicker('val'); return periode;}
		                          }
         view.bonpt.columnDefs = [{"orderable":false,"targets":[1,2,3]}];								  
         view.bonpt.inittable(arcol);
		 
		 
	 },
	 dorefresh : function(e){
		 e.preventDefault();
		 view.bonpt.searchdata();
	 }
	
});


$(function(){
   
     view.vbonpt = new viewbontkpt();

});