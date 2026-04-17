var view = [];

var msettingtk = Backbone.Model.extend({
	url : './settingk',
	defaults:{
		lastday:'0',
		endtime:'00:00'
	}
})

var bonsetting = Backbone.Model.extend({
	url:'./settingbon',
	defaults:{
		idperusahaan:'0',
		min:'200000',
		max:'9000000'
	}
})

var vsetting = Backbone.View.extend({
	el:'#controlperiode',
	beforetime : $('#txtlength'),
	perusahaan:$('#txtperusahaan'),
	events:{
		'click #btnsettk':'simpansetting'
	},
	initialize: function(){
		this.timetk = $('#timetk');
		this.timetk.datetimepicker({format:'HH:mm'});
		this.perusahaan.selectpicker('setStyle','btn-sm btn-block btn-primary');
	},
	simpansetting:function(e){
		var jml =$.trim(this.beforetime.val());
		var rnumeric = new RegExp('^[0-9]*$');
		if(rnumeric.test(jml)==false || jml===''){
			swal('Data buka bon Tk','Harap diisi dengan benar (format numerik)','error');
			return;
		};
		var tim = $.trim($('#txttime').val());
		rnumeric = new RegExp('^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$');
		if(rnumeric.test(tim)==false || rnumeric==''){
			swal('Tutup Bon Tk','Harap diisi dengan benar (format HH:mm)','error');
			return;
		};

		var mysetting = new msettingtk({lastday:jml,endtime:tim});
		mysetting.save(null,{
			emulateJSON:true,
			success : function(model,resp){				
				if(resp.error == 0){
					swal('Simpan data','Berhasil menyimpan data','success');
				}else{
					swal('Simpan data','Gagal menyimpan data','error');
				}
			}
		});
	}
});

var vminmax = Backbone.View.extend({
	el:'#viewer',
	data : null,
	minval:null,
	maxval:null,
	events:{
		"click #btnupdatenilai":"update_nilai"
	},
	initialize:function(){
		var acol = [
			{'title':'Perusahaan','data':'Perusahaan','width':'100'}
			,{'title':'Max (3 bulan kerja )','data':'ismin','width':'40'}
			,{'title':'Max (Umum)','data':'ismax','width':'40'}			
			];

		view.minmax =new BackboneDatatableServer({el:'#controlminmax'});
		view.minmax.returnme=this;
		view.minmax.el_table='#tblsettingbon';
		view.minmax.urlAjax = './getbonminmax';
		view.minmax.onRowClick = function(data,parent){
			parent.data=data;	
			ismin = parseInt(data.ismin.replace(/\D/g, ""), 10);
			ismax = parseInt(data.ismax.replace(/\D/g, ""), 10);
			parent.minval.set(ismin);
			parent.maxval.set(ismax);		
			$('#idp').val(data.idperusahaan);
			$('#idperusahaan').val(data.Perusahaan);
		}
		
		this.minval = new AutoNumeric('#minvalue',{
			"decimalPlaces":0,
			"digitGroupSeparator":".",
			"decimalCharacter":",",
			"maximumValue":90000000,
			"minimumValue":0
		});

		this.maxval = new AutoNumeric('#maxvalue',{
			"decimalPlaces":0,
			"digitGroupSeparator":".",
			"decimalCharacter":",",
			"maximumValue":90000000,
			"minimumValue":0
		});

		view.minmax.inittable(acol);
	},
	update_nilai:function(e){
		// parseInt(string.replace(/\D/g, ""), 10);
		$.ajax({
			url:'./updatemaxminbon',
			type:'POST',
			dataType:'json',
			data:{idperusahaan:$('#idp').val(),ismin:this.minval.get(),ismax:this.maxval.get()},
			success:function(d,r,x){
				view.minmax.searchdata();
			}
		});
	}
});

$(function(){
	
	view.settingtk = new vsetting();
	view.datatable = new vminmax();

	
	
});