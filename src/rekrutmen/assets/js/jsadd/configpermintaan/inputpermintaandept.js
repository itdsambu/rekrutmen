$(function(){
    //jquery here
    $('#btnuploadmemotk').on('click',function(e){
        e.preventDefault();
        var fm = $('#frmideal')[0];
        var fd = new FormData(fm);
        $.ajax({
            url:'./updatedatakrytk',
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
                    $('#txtnoref').val(r.ref);
                }
            },
            error: function(r){
                swal(r.Msg,'Error','error');
            }
        });
    })
})