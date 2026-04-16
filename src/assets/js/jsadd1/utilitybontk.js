var view = [];

var msettingtk = Backbone.Model.extend({
	url : './settingk',
	defaults:{
		lastday:'0',
		endtime:'00:00'
	}
})

var vsetting = Backbone.View.extend({
	el:'#controlperiode',
	beforetime : $('#txtlength'),
	events:{
		'click #btnsettk':'simpansetting'
	},
	initialize: function(){
		this.timetk = $('#timetk');
		this.timetk.datetimepicker({format:'hh:mm'});
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
				console.log(resp)  ;
				if(resp.error == 0){
					swal('Simpan data','Berhasil menyimpan data','success');
				}else{
					swal('Simpan data','Gagal menyimpan data','error');
				}
			}
		});
	}
});

$(function(){
	
    view.settingtk = new vsetting();
	
});