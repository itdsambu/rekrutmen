var view=[];

var mgruppt = Backbone.Model.extend({
	defaults : {
		'groupid':0,
		'idperusahaan':0
	},
	url : './getgoruppt'
});

var ingroupperusahaan = Backbone.View.extend({
	el:'#upgroupperusahaan',
	perusahaan:$('#selectperusahaan'),
	idgroup:$('#txtidgroup'),
	groupname:$('#txtgroupname'),
	mydata:null,
	events : {
		'click #btnsimpan':'simpandata'
	},
	simpandata : function(){
		var me = this;
		$('#btnsimpan').prop('disabled',true);
		idg = this.idgroup.val();
		pid = this.perusahaan.selectpicker('val');
		var updategpt = new mgruppt({'groupid':idg,'idperusahaan':pid});
		updategpt.save(null,{
			emulateJSON:true,
			success: function(model,resp){
				if(resp.length>0){
					view.grouppt.searchdata();
					$('#btnsimpan').prop('disabled',false);
				}
			}
		});
	},
	initialize : function(){
		acol = [
		{'title':'Id','data':'groupid','width':'20'},
		{'title':'Group','data':'groupname','width':'100'},
		{'title':'IdP','data':'idperusahaan','width':'20'},
		{'title':'Perusahaan','data':'perusahaan','width':'100'},
		];
		
		view.grouppt = new BackboneDatatableServer({el:'#viewgroup'});
		view.grouppt.el_table = '#tabelgroupperusahaan';
		view.grouppt.urlAjax = './getinfogrouptk';
		view.grouppt.onRowClick = this.onRowClick;
		view.grouppt.returnme = this;
		view.grouppt.inittable(acol);
	},
	onRowClick : function(data,parentme)
	{
		parentme.mydata = data;
		parentme.showData();
	},
	showData : function(){
		this.idgroup.val(this.mydata.groupid);
		this.groupname.val(this.mydata.groupname);
        this.perusahaan.selectpicker('val',this.mydata.idperusahaan);		
	}
});

$(function(){
	view.groupperusahaan = new ingroupperusahaan();
});