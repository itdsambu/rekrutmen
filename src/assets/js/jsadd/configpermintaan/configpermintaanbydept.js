
var view = {};

var viewtabelpermintaan = Backbone.View.extend({
    el:'#controlsetup',
    ikrys:null,
    initialize : function(){
        rowdata = [
            {'data':'DeptAbbr'},
            {'data':'IKry'},
            {'data':'RKry'},
            {'data':'IBor'},
            {'data':'RBor'},            
        ];
        view.tblkry = new vwtabledata() ;
        view.tblkry.urlAjax='./getdatacountkrytkdept';
        view.tblkry.returnme = this;        

        
        view.tblkry.inittable(rowdata);        
    }
});

var vwtabledata = BackboneDatatableServer.extend({
    el:'#viewtabel',
    el_table:'#tblsettingkrytk',
    urlAjax:'./getdatacountkrytk',
    onfooter: function(r,d,s,e,display,my){        
        var api = my.api();
        $.get('./getajaxsummarydept',{},function(res){            
            j=res.data[0];
            $(api.column(1).footer()).html(j.Ideal_Kry);
            $(api.column(2).footer()).html(j.Real_Kry);
            $(api.column(3).footer()).html(j.Ideal_Bor);
            $(api.column(4).footer()).html(j.Real_Bor);
        },'json');       
    }   
})

var formkry = Backbone.View.extend({
    el:'#formkry',
    eldept:'#idkrydept',
    elrealkry:'#txtrealkry',
    idealkry:'#txtidealkrys',
    idsave:null,
    events:{
        "click #btnuploadmemo":"doupdatedata"
    },
    initialize : function(){
      this.idsave= new AutoNumeric(this.idealkry,{
            decimalPlaces:0,
            decimalCharacter:',',
            digitGroupSeparator:'.',
            maximumValue:9000,
            minimumValue:0
        });
    },
    doupdatedata:function(e){
        e.preventDefault();
        var fm = $('#frmkry')[0];
        var fd = new FormData(fm);
        $.ajax({
            url:'./updatedata',
            dataType:'json',
            cache:false,
            contentType:false,
            processData:false,
            data:fd,
            type:'POST',
            success: function(r){
                if(r.Err==1){
                    swal(r.Msg,'Error','error');
                }else{
                    swal(r.Msg,'Success','success');
                    view.tblkry.refreshtable();
                    view.pkrytk.clean();
                }
            },
            error: function(e){
                console.log(e);
            }
        });        
    }
});

var formtk = Backbone.View.extend({
    el:'#formtk',
    idtk:null,
    events:{
        "click #btnuploadmemotk":"doupdateadatatk"    
    },
    initialize:function(){
        this.idtk = new AutoNumeric('#txtidealtks',{
            decimalPlaces:0,
            decimalCharacter:',',
            digitGroupSeparator:'.',
            maximumValue:9000,
            minimumValue:0
        });
    },
    doupdateadatatk:function(e){
        e.preventDefault();
        var fm = $('#frmtk')[0];
        var fd = new FormData(fm);
        $.ajax({
            url:'./updatedatatk',
            dataType:'json',
            cache:false,
            contentType:false,
            processData:false,
            data:fd,
            type:'POST',
            success: function(r){
                if(r.Err==1){
                    swal(r.Msg,'Error','error');
                }else{
                    swal(r.Msg,'Success','success');
                    view.tblkry.refreshtable();
                    view.pkrytk.clean();
                }
            },
            error: function(r){
                swal(r.Msg,'Error','error');
            }
        });  
    }

});


$(function(){
   // view.formkry = new formkry();
   // view.formtk = new formtk();
    view.pkrytk = new viewtabelpermintaan();   
});