<?php foreach($getData as $get){?>
<div class="col-sm-6">
    <div class="form-group">
        <label class="col-lg-2 control-label"></label>
        <div class="col-sm-6">
            <input type="hidden" name="txtHeaderid" id="headerid" class="form-control" value="<?php echo $get->CalonPelamarID?>">
        </div> 
    </div> 
    <div class="form-group">
        <label class="col-lg-2 control-label">Nama</label>
            <div class="col-sm-6">
                <input type="text" class="form-control" name="txtnama" id="Nama" required="" readonly="" placeholder="Input Nama" value="<?php echo $get->Nama?>">
            </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Position</label>
        <div class="col-lg-6">
            <input type="text" name="txtposition" id="position" placeholder="" readonly="" class="form-control" required="" value="<?php echo $get->DeptAbbr?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Organization</label>
        <div class="col-lg-6">
            <input type="text" name="txtorganization" id="organization" placeholder="" class="form-control" required="">
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label class="col-lg-2 control-label"></label>
        <div class="col-sm-6">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Date</label>
        <div class="col-sm-6">
            <input type="text" name="txtdate" id="date" class="form-control" required="" readonly="" value="<?php echo date('Y-m-d')?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Education</label>
        <div class="col-lg-6">
            <input type="text" name="txteducation" id="education" placeholder="" readonly="" class="form-control" required="" value="<?php echo $get->Pendidikan?>" >
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Gender</label>
        <div class="col-lg-6">
            <input type="text" name="txtgender" id="gender" placeholder="" class="form-control" readonly="" required="" value="<?php echo $get->JenisKelamin?>">
        </div>
    </div>
</div>
<br>
<div class="panel panel-default">
    <div class="panel-body">
        <div style="padding: 5px;">
            <table class="table table-hover table-striped table table-striped table-hover table-bordered">
                <thead>
                    <tr style="background-color: #000000;">
                        <th><font>Disc Assisment :</font></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <textarea class="form-control" name="txtdiscArea" id="discArea"></textarea>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <label class="col-lg-2 control-label"></label>
                <div class="col-sm-12">
                   <button class="btn btn-sm btn-primary" name="txtSimpan">
                        <span class="fa fa-save"></span>
                        Simpan
                    </button>
                    <a href="location.reload();" class="btn btn-sm btn-danger"><i class="fa fa-close"></i> Batal</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php }?>

 

<script type="text/javascript">
    function callAjax(){
        var Nama = $('#FindByName').val();
        // alert(Nama);

        if(Nama == ''){
            alert('Data Tidak Boleh Kosong');
        }else{
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PsychologicalAssisment/getKaryawanDisc')?>"+"/"+Nama,
                success: function(msg){
                    if(msg == ''){
                      alert('Tidak ada data');
                    } 
                    else{
                        $("#getData").html(msg);                                                     
                    }
                }
            });
        }    
    };
</script>