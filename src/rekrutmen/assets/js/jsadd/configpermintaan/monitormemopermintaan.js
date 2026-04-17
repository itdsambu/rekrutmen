var view={};


var dltabel = Backbone.View.extend({
    el:'#viewtabel',
    initialize:function(){
        rowdata = [
            {'data':'opsi'},
            {'data':'IDMemo'},
            {'data':'Doc'},
            {'data':'DeptAbbr'},
            {'data':'IsKry'},
            {'data':'Jumlah'},
            {'data':'IsComplete'},
            {'data':'Memo'}
        ];
        view.tblmonitor = new dbmonitor();
        view.tblmonitor.returnme = this;
        view.tblmonitor.inittable(rowdata);        
    }
})


var dbmonitor = BackboneDatatableServer.extend({
    el:'#viewtabel',
    el_table:'#tblsettingkrytk',
    urlAjax:'./getmonitormemo',  
    initialize: function(){
        this.onRowClick = this.onrowclicked;
        this.onItemDataReturn = this.onitemreturn;
    }
    ,onrowclicked: function(){

    },
    onitemreturn:function(i,p){
        console.log(i);
        if(i.IsKry==1){
            i.IsKry='Kry';
            i.Jumlah = i.Jumlah + ' Kry';
        }else{
            i.IsKry='TK';
            i.Jumlah = i.Jumlah + ' TK';
        }        
        s = '<a target="_blank" href="./printMemo?idmemo=' + i.IDMemo + '" class="btncollapse btninfo btn btn-icon btn-xs btnnoborder btnnobackground">Memo</a>';
        i.Memo = s;
    }
})


$(function(){
    view.table = new dltabel();
    if( mpesan!='' ){
        swal(mpesan,'Information','success');
    }
});