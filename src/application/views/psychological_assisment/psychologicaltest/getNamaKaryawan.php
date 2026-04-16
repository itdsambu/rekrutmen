<?php foreach($getData as $get){?>
<div class="form-group">
    <label class="col-lg-2 control-label"></label>
    <div class="col-sm-4">
        <input type="hidden" name="txtHeaderid" id="headerid" class="form-control" value="<?php echo $get->CalonPelamarID?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Nama Lengkap</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="txtnama" id="Nama" required="" readonly="" placeholder="Input Nama" value="<?php echo $get->Nama?>">
        </div>
        <!-- <a href="#myModal" data-toggle="modal" id="btnFind" class="btn btn-success btn-sm" style="background-color: #E25FA6 !important; border-color: #E25FA6;">
            <i class="fa fa-search"></i>
        Search Name
        </a> -->
</div>
<div class="form-group">
    <label class="col-lg-2 control-label"> Tanggal Lahir</label>
        <div class="col-sm-4">
            <input type="text" class="form-control" name="txttgllahir" id="tgl_lahir" placeholder="Tanggal Lahir" class="form-control" required="" readonly="" value="<?php echo date('d-m-Y',strtotime($get->TanggalLahir))?>">
        </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">Umur</label>
    <div class="col-lg-4">
        <input type="text" name="txtumur" id="umur" placeholder="Umur" class="form-control" required="" readonly="" value="<?php echo $get->Umur?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Pendidikan</label>
    <div class="col-sm-4">
        <input type="text" name="txtpendidikan" id="pendidikan" placeholder="Input Pendidikan" class="form-control" required="" readonly="" value="<?php echo $get->Pendidikan?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Tanggal Test</label>
    <div class="col-sm-4">
        <input type="date" name="txttgltest" id="tgltest" placeholder="Tanggal Test" class="form-control" required="" value="<?php echo date('Y-m-d')?>">
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2 control-label">Tanggal Laporan
    </label>
    <div class="col-sm-4">
        <input type="date" name="txttgllaporan" id="tgllaporan" placeholder="Tanggal Laporan" class="form-control" required="" readonly="" value="<?php echo date('Y-m-d')?>">
    </div>
</div>

<div class="form-group">
    <table class="table table-hover table-striped table table-striped table-hover table-bordered">
        <thead>
            <tr style="background-color: #E25FA6;">
                <th><strong><font color ="#ffffff">ASSESSMENT PROCEDURE :</font></strong></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="form-group">
                        <label class="col-lg-1 control-label">Input Test</label>
                        <div class="col-lg-12">
                            <input type="text" id="asissmentid" name="txtAssismentid" class="form-control" placeholder="Input Test">
                        </div>
                    </div>
                    <div>
                        <label class="col-lg-1 control-label">Keterangan</label>
                        <div class="col-lg-12">
                            <textarea class="form-control" name="txtKetAssismentProcedure" id="assismentprocedure" placeholder="Input Ketarangan Assisment Procedure"></textarea>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<table class="table table-hover table-striped table table-striped table-hover table-bordered">
    <thead>
        <tr style="background-color: #FF69B4;">
            <td><strong><font color ="#ffffff">BACKGROUND INFORMATION : </strong><p>In this section present paragraphs dealing with family,social,legal,medical,family mental health,etc. Issues,if nedded. Only include those issues that are relvant to the "questions" posed under "PURPOSE FOR EVALUATION."</p></font></td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div>
                    <label class="col-lg-1 control-label"></label>
                    <div class="col-lg-12">
                        <textarea class="form-control" name="txtBackgroundInformation" id="backgroundinformation" placeholder="Input background information"></textarea>
                    </div>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<table class="table table-hover table-striped table table-striped table-hover table-bordered">
    <thead>
        <tr style="background-color: #FC92C2;">
            <th><strong><font color ="#000000">Result From Testing :</font></strong></th>
            <th class="col-lg-2"><strong><font color ="#000000">Recomendation :</font></strong></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="vertical-align: middle;">
                <input type="file" id="resultformtesting" name="txtResultFormTesting" size="20" />
            </td>
            <td style="text-align: center; vertical-align: middle;">
                <select name="txtRecomendation" id="Recomendation">
                    <option value="">--- Pilih ---</option>
                    <option value="Direkomendasikan">Direkomendasikan</option>
                    <option value="Dipertimbangkan">Dipertimbangkan</option>
                    <option value="Tidak Disarankan">Tidak Disarankan</option>
                </select>
            </td>
        </tr>
    </tbody>
</table>

<div class="form-group">
    <label class="col-lg-2 control-label">
        <strong> 
            <i class="fa fa-list"></i>
            INTERVIEW REPORT :
        </strong>
    </label>
</div>
<br>
<table class="table table-hover table-striped table table-striped table-hover table-bordered">
    <thead>
        <tr style="background-color: #FFA6C8;">
                <th class="text-center"><font color ="#000000">Sikap</font></th>
                <th class="text-center"><font color ="#000000">Penilaian</font></th>
            </font>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Sikap Selama Wawancara</td>
            <td>
                <select class="form-control" name="txtSikapWawancara" id="sikapwawancara">
                    <option value="Menantang">Menantang</option>
                    <option value="Kurang Serius">Kurang Serius</option>
                    <option value="Tenang">Tenang</option>
                    <option value="Baik">Baik</option>
                    <option value="Antusias">Antusias</option>
                </select>
            </td>  
        </tr>
        <tr>
            <td>Sikap ketika berbicara</td>
            <td>
                <select class="form-control" name="txtSikapKetikaberbicara" id="sikapketikaberbicara">
                    <option value="Kasar">Kasar</option>
                    <option value="Kurang Sopan">Kurang Sopan</option>
                    <option value="Cukup Sopan">Cukup Sopan</option>
                    <option value="Lebih dari cukup">Lebih dari cukup</option>
                    <option value="Cerdas">Cerdas</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                Perkiraan tingkat pengetahuan tentang tugas yang akan dikerjakan
            </td>
            <td>
                <select class="form-control" name="txtSikapTingkatpengetahuan" id="sikaptingkatpengetahuan">
                    <option value="Kurang sekali">Kurang sekali</option>
                    <option value="Terbatas">Terbatas</option>
                    <option value="Cukup Baik">Cukup Baik</option>
                    <option value="Menguasai dengan baik">Menguasai dengan baik</option>
                    <option value="Improvisasi">Improvisasi</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Kemungkinan sikap terhadap atasan</td>
            <td>
                <select class="form-control" name="txtSikapterhadapatasan" id="sikapterhadapatasan">
                    <option value="Cenderung membantah">Cenderung membantah</option>
                    <option value="Yes-man">Yes-man</option>
                    <option value="Patuh dan penurut">Patuh dan penurut</option>
                    <option value="Cenderung dominan">Cenderung dominan</option>
                    <option value="Bisa">Bisa</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>Tanggapan atas energi yang dimiliki</td>
            <td>
                <select class="form-control" name="txtTanggapanAtasEnergi" id="tanggapanatasenergi">
                    <option value="Terbatas sekali">Terbatas sekali</option>
                    <option value="Kurang berusaha">Kurang berusaha</option>
                    <option value="Cukup baik">Cukup baik</option>
                    <option value="Kuat">Kuat</option>
                    <option value="Kuat sekali">Kuat sekali</option>
                </select>
            </td>
        </tr>
    </tbody>
</table>
<div class="form-group">
    <label class="col-lg-1 control-label"></label>
    <div class="col-lg-4">
        <button class="btn btn-sm btn-primary" name="simpan" id="simpan" style="background-color: #E25FA6 !important; border-color: #E25FA6;">
            Submit
        </button>
        <a href="" class="btn btn-sm btn-danger">
            Reset
        </a>
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
                url: "<?php echo base_url('PsychologicalAssisment/getKaryawan')?>"+"/"+Nama,
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