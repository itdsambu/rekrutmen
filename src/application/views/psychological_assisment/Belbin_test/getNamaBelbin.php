<?php foreach($getData as $get){?>
<div class="col-sm-6">
    <div class="form-group">
        <label class="col-lg-2 control-label"></label>
        <div class="col-sm-6">
            <input type="hidden" name="txtHeaderid" id="headerid" class="form-control" value="<?php echo $get->CalonPelamarID?>">
        </div>
    </div> 
    <div class="form-group">
        <label class="col-lg-2 control-label">Nama Lengkap</label> 
            <div class="col-sm-6">
                <input type="text" class="form-control" name="txtnama" id="Nama" required="" readonly="" placeholder="Input Nama" value="<?php echo $get->Nama?>">
            </div>
            <!-- <a href="#myModal" data-toggle="modal" id="btnFind" class="btn btn-success btn-sm" style="background-color: #2D8B4D !important; border-color: #2D8B4D;">
                <i class="fa fa-search"></i>
            Search Name
            </a> -->
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Tanggal Lahir</label>
            <div class="col-sm-6">
                <input type="text" name="txttgllahir" id="tgl_lahir" class="form-control" required="" readonly="" value="<?php echo date('d-M-Y',strtotime($get->TanggalLahir))?>">
            </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Jenis Kelamin</label>
        <div class="col-sm-6">
            <input type="text" name="txtjeniskelamin" id="jeniskelamin" class="form-control" required="" readonly="" value="<?php echo $get->JenisKelamin?>">
        </div>
    </div>
</div>
<div class="col-sm-6">
    <div class="form-group">
        <label class="col-lg-2 control-label"></label>
        <div class="col-sm-4">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Pendidikan Terakhir</label>
        <div class="col-sm-6">
            <input type="text" name="txtpendidikan" id="pendidikan" readonly="" class="form-control" required="" value="<?php echo $get->Pendidikan?>">
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Departemen Tujuan</label>
        <div class="col-sm-6">
            <input type="text" name="txtperusahaan" id="perusahaan" required="" class= "form-control" readonly="" value="<?php echo $get->DeptAbbr?>" >
        </div>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-body">
        <div style="padding: 5px;">
            <table class="table table-hover table-striped table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th colspan="8" style="background-color: #2D8B4D"><font color="#FFFFFF">BELBIN TEST</font></th>
                    </tr>
                    <tr>
                        <th class="text-center">SH</th>
                        <th class="text-center">CO</th>
                        <th class="text-center">PL</th>
                        <th class="text-center">ME</th>
                        <th class="text-center">IMP</th>
                        <th class="text-center">RI</th>
                        <th class="text-center">TW</th>
                        <th class="text-center">CF</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding-top: 17px;">
                            <center><select name="txtbelbink1" id="belbink1">
                                <?php for ($i = 0; $i <= 20; $i++) { ?>
                                <option value="<?php echo "$i" ?>"><?php echo "$i"?></option>
                                <?php } ?>
                            </select></center>
                        </td>
                        <td style="padding-top: 17px;">
                            <center><select name="txtbelbink2" id="belbink2">
                                <?php for ($i = 0; $i <= 20; $i++) { ?>
                                <option value="<?php echo "$i" ?>"><?php echo "$i"?></option>
                                <?php } ?>
                            </select></center>
                        </td>
                        <td style="padding-top: 17px;">
                            <center><select name="txtbelbink3" id="belbink3">
                                <?php for ($i = 0; $i <= 20; $i++) { ?>
                                <option value="<?php echo "$i" ?>"><?php echo "$i"?></option>
                                <?php } ?>
                            </select></center>
                        </td>
                        <td style="padding-top: 17px;">
                            <center><select name="txtbelbink4" id="belbink4">
                                <?php for ($i = 0; $i <= 20; $i++) { ?>
                                <option value="<?php echo "$i" ?>"><?php echo "$i"?></option>
                                <?php } ?>
                            </select></center>
                        </td>
                        <td style="padding-top: 17px;">
                            <center><select name="txtbelbink5" id="belbink5">
                                <?php for ($i = 0; $i <= 20; $i++) { ?>
                                <option value="<?php echo "$i" ?>"><?php echo "$i"?></option>
                                <?php } ?>
                            </select></center>
                        </td>
                        <td style="padding-top: 17px;">
                            <center><select name="txtbelbink6" id="belbink6">
                                <?php for ($i = 0; $i <= 20; $i++) { ?>
                                <option value="<?php echo "$i" ?>"><?php echo "$i"?></option>
                                <?php } ?>
                            </select></center>
                        </td>
                        <td style="padding-top: 17px;">
                            <center><select name="txtbelbink7" id="belbink7">
                                <?php for ($i = 0; $i <= 20; $i++) { ?>
                                <option value="<?php echo "$i" ?>"><?php echo "$i"?></option>
                                <?php } ?>
                            </select></center>
                        </td>
                        <td style="padding-top: 17px;">
                            <center><select name="txtbelbink8" id="belbink8">
                                <?php for ($i = 0; $i <= 20; $i++) { ?>
                                <option value="<?php echo "$i" ?>"><?php echo "$i"?></option>
                                <?php } ?>
                            </select></center>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8"><textarea class="form-control" name="txtbelbinarea" id="belbinarea" placeholder="Text Area MBTI TEST" required=""></textarea></td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <label class="col-lg-1 control-label"></label>
                <div class="col-sm-12">
                   <button class="col-lg-12 btn btn-sm btn-primary" name="simpanBelbin" id="simpanBelbin" style="background-color: #2D8B4D !important; border-color: #2D8B4D;">
                        <span class="fa fa-save"></span>
                        Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php }?>

<script type="text/javascript">
    function callAjax(){
        var Nama = $('#FindByName').val();
         //alert(Nama);

        if(Nama == ''){
            alert('Data Tidak Boleh Kosong');
        }else{
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PsychologicalAssisment/getKaryawanBelbin')?>"+"/"+Nama,
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