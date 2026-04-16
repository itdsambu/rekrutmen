var view = [];

var mlockunlock = Backbone.Model.extend({
	url:'./lockpt',
	defaults:{
		ids:null,
		islock:null,
		periode:null
	}
})

var perusahaan = Backbone.View.extend({
	el : '#readperiode',
	elperiode : $('#periodes'),
	periode:null,
	origdata:null,
	events:{
		'click #btnrefresh':'updatedatatable'
	},
	initialize:function(){
		var me = this;
		var arcol = [
		{'title':'Perusahaan','data':'pcv','width':200},
		{'title':'Lock','data':'lock','width':50},
		{'title':'UnLock','data':'unlock','width':50},
		{'title':'Status','data':'state','width':200}
		];
		
		view.lockcv = new BackboneDatatableServer({el:'#tblview'});
		view.lockcv.returnme = this;
		view.lockcv.el_table = '#tblperusahaan';
		view.lockcv.urlAjax = './lockunlockperusahaan';
		view.lockcv.extraData = {'period':function(){
			var ts = me.elperiode.selectpicker('val') ;
			return ts;
		}};
		
		view.lockcv.onItemDataReturn = function(data,parentme){		
		console.log(data.islock);	
		   if(data.islock==0){
			   data.state = 'unlock';
			   data.lock='<button type="button" class="btn btn-primary btn-sm btn-block btnlock" id="pid'+ data.ids +'">Lock</button>';
			   data.unlock='';
		   }else{
			   data.state = 'lock';
			   data.unlock='<button type="button" class="btn btn-primary btn-sm btn-block btnunlock" id="pid'+ data.ids +'">UnLock</button>';
			   data.lock='';
		   }
		};
		
		view.lockcv.onRowClick = function(mydata,myparent){
			myparent.origdata = mydata;
		}
		
		view.lockcv.doaddevent({
			'click .btnlock':this.lockclick,
			'click .btnunlock': this.unlockclick
		}); 
		
		view.lockcv.inittable(arcol);
	},
	updatedatatable: function(e){
		e.preventDefault();
        view.lockcv.searchdata();		
	},
	updatelockdata: function(data,caps,messages){
		var me = view.varperusahaan;

		me.model.set({ids:data.ids,islock:data.islock,periode:me.elperiode.selectpicker('val')});
		me.model.save(null,{
			success:function(model,response){
				if(response.error==0){
					swal(caps,messages,'success');
					view.lockcv.searchdata(); 					
				}else{
					swal(caps,'Gagal, terdapat kesalahan, periode harus sesuai dengan periode berjalan','error');
				}
	
			}
		});
	},
	unlockclick: function(e){
		e.preventDefault();
		var me = view.varperusahaan;
		var data = me.origdata;
		data.islock = 0;
		me.updatelockdata(data,'Proses UnLock ' +data.pcv,'Proses Unlock data berhasil');
		
	},
	lockclick : function(e){
		e.preventDefault();
		var me = view.varperusahaan;
		var data = me.origdata;
		data.islock = 1;
		me.updatelockdata(data,'Proses Lock ' + data.pcv ,'Proses Lock data berhasil');
	}
});

$(function(){
	view.varperusahaan = new perusahaan({model:new mlockunlock()});
});