
<!-- Jay Windy Panggabean -->

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
<div class="panel panel-default">
    <div class="panel-body">
        <div style="padding: 5px;">
            <table class="table table-hover table-striped table table-striped table-hover table-bordered">
                <thead>
                    <tr style="background-color: #000000;">
                        <b><th colspan="4"><font color="#000000" size="3px">EXPRESSED :</font></th></b>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th style="background-color: #105183;"><font color = '#ffffff'>INCLUSION</font></th>
                        <th style="background-color: #105183;"><font color = '#ffffff'>CONTROL</font></th>
                        <th style="background-color: #105183;"><font color = '#ffffff'>AFFECTION</font></th>
                        <th style="background-color: #105183;"><font color = '#ffffff'></font></th>
                    </tr>
                    <tr>
                        <th style="background-color: #0673C7;"><font color="#FFFFFF">EXPRESSED INCLUSION</font></th>
                        <th style="background-color: #0673C7;"><font color="#FFFFFF">EXPRESSED CONTROL</font></th>
                        <th style="background-color: #0673C7;"><font color="#FFFFFF">EXPRESSED AFFECTION</font></th>
                        <th style="background-color: #0673C7;"><font color="#FFFFFF">TOTAL EXPRESSED</font></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>NILAI
                            <select class="form-control" name="txtexpressedInclusion" id="expressedInclusion" required="">
                                <?php 
                                    for ($i=0; $i <=9 ; $i++) { ?>
                                    <option value="<?php echo "$i"?>"><?php echo "$i"?></option>
                                    <?php } ?>
                            </select>
                        </td>
                        <td>NILAI
                            <select class="form-control" name="txtexpressedControl" id="expressedControl" required="">
                                <?php 
                                    for ($i=0; $i <=9 ; $i++) { ?>
                                    <option value="<?php echo "$i"?>"><?php echo "$i"?></option>
                                    <?php } ?>
                            </select>
                        </td>
                        <td>NILAI
                            <select class="form-control" name="txtexpressedAffection" id="expressedAffection" required="">
                                <?php 
                                    for ($i=0; $i <=9 ; $i++) { ?>
                                    <option value="<?php echo "$i"?>"><?php echo "$i"?></option>
                                    <?php } ?>
                            </select>
                        </td>
                        <td>TOTAL
                            <input type="text" class="form-control" name="txttotalExpressed" id="totalExpressed" value="0" readonly="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea class="form-control" name="txtAreaexpressedInc" id="AreaexpressedInc" readonly=""></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" name="txtAreaexpressedCon" id="AreaexpressedCon" readonly=""></textarea>
                        </td>
                        <td> 
                            <textarea class="form-control" name="txtAreaexpressedAff" id="AreaexpressedAff" readonly=""></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" name="txtAreaexpressedTot" id="AreaexpressedTot" readonly=""></textarea>
                        </td>
                    </tr>
                    <tr style="background-color: #C0C0C0;">
                        <td>Range 0 - 9</td>
                        <td>Range 0 - 9</td>
                        <td>Range 0 - 9</td>
                        <td>Range 0 - 27</td>
                    </tr>
                    
                </tbody>
            </table>
            <table class="table table-hover table-striped table table-striped table-hover table-bordered">
                <thead>
                    <tr style="background-color: #000000;">
                        <b><th colspan="4"><font color="#000000" size="3px"> WANTED :</font></th></b>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th style="background-color: #1F7DC5;"><font color="#FFFFFF">WANTED INCLUSION</font></th>
                        <th style="background-color: #1F7DC5;"><font color="#FFFFFF">WANTED CONTROL</font></th>
                        <th style="background-color: #1F7DC5;"><font color="#FFFFFF">WANTED AFFECTION</font></th>
                        <th style="background-color: #1F7DC5;"><font color="#FFFFFF">WANTED EXPRESSED</font></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>NILAI
                            <select class="form-control" name="txtwantedInclusion" id="wantedInclusion" required="">
                                <?php 
                                    for ($i=0; $i <=9 ; $i++) { ?>
                                    <option value="<?php echo "$i"?>"><?php echo "$i"?></option>
                                    <?php } ?>
                            </select>
                        </td>
                        <td>NILAI
                            <select class="form-control" name="txtwantedControl" id="wantedControl" required="">
                                <?php 
                                    for ($i=0; $i <=9 ; $i++) { ?>
                                    <option value="<?php echo "$i"?>"><?php echo "$i"?></option>
                                    <?php } ?>
                            </select>
                        </td>
                        <td>NILAI
                            <select class="form-control" name="txtwantedAffection" id="wantedAffection" required="">
                                <?php 
                                    for ($i=0; $i <=9 ; $i++) { ?>
                                    <option value="<?php echo "$i"?>"><?php echo "$i"?></option>
                                    <?php } ?>
                            </select>
                        </td>
                        <td>TOTAL
                            <input type="text" class="form-control" name="txtwantedExpressed" id="wantedExpressed" value="0" readonly="">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea class="form-control" name="txtAreawantedInc" id="AreawantedInc" readonly=""></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" name="txtAreawantedCon" id="AreawantedCon" readonly=""></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" name="txtAreawantedAff" id="AreawantedAff" readonly=""></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" name="txtAreawantedExpressed" id="AreawantedExpressed" readonly=""></textarea>
                        </td>
                    </tr>
                    <tr style="background-color: #C0C0C0;">
                        <td>Range 0 - 9</td>
                        <td>Range 0 - 9</td>
                        <td>Range 0 - 9</td>
                        <td>Range 0 - 27</td>
                    </tr>

                </tbody>
            </table>
            <table class="table table-hover table-striped table table-striped table-hover table-bordered">
            </table>
            <table class="table table-hover table-striped table table-striped table-hover table-bordered">
                <thead>
                    <tr style="background-color: #2687D2;">
                        <th><font color="#000000">TOTAL INCLUSION</font></th>
                        <th><font color="#000000">TOTAL CONTROL</font></th>
                        <th><font color="#000000">TOTAL AFFECTION</font></th>
                        <th><font color="#000000">OVERALL</font></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>NILAI
                            <input type="text" class="form-control" name="txttotalInclusion" id="totalInclusion" value="0" readonly="">
                        </td>
                        <td>NILAI
                            <input type="text" class="form-control" name="txttotalControl" id="totalControl" value="0" readonly="">
                        </td>
                        <td>NILAI
                            <input type="text" class="form-control" name="txttotalAffection" id="totalAffection" value="0" readonly="">
                        </td>
                        <td>TOTAL
                            <input type="text" class="form-control" name="txtOverall" id="overall" value="0" readonly="">
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            <textarea class="form-control" name="txtAreatotalInc" id="AreatotalInc" readonly=""></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" name="txtAreatotalCon" id="AreatotalCon" readonly=""></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" name="txtAretotalAff" id="AreatotalAff" readonly=""></textarea>
                        </td>
                        <td>
                            <textarea class="form-control" name="txtAreaoverall" id="Areaoverall" readonly=""></textarea>
                        </td>
                    </tr>
                    <tr style="background-color: #C0C0C0;">
                        <td>Range 0 - 18</td>
                        <td>Range 0 - 18</td>
                        <td>Range 0 - 18</td>
                        <td>Range 0 - 54</td>
                    </tr>
                    
                </tbody>
            </table>
            <table class="table table-hover table-striped table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Nilai</th>
                        <th>Overall</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>0 - 6 = Rendah</td>
                        <td>0 - 25 = Rendah</td>
                    </tr>
                    <tr>
                        <td>7 - 12 = Sedang</td>
                        <td>26 - 39 = Sedang</td>
                    </tr>
                    <tr>
                        <td>13 - 18 = Tinggi</td>
                        <td>40 - 54 = Tinggi</td>
                    </tr> 
                </tbody>
            </table>
            </div>
            <div class="form-group">
                <label class="col-lg-2 control-label"></label>
                <div class="col-sm-12">
                   <button class="col-lg-12 btn btn-sm btn-primary" name="txtSimpan">
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
        // alert(Nama);

        if(Nama == ''){
            alert('Data Tidak Boleh Kosong');
        }else{
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PsychologicalAssisment/getKaryawanFiro')?>"+"/"+Nama,
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

<script type="text/javascript">
    $('#expressedInclusion').on('change',function(){
        var a = document.getElementById('expressedInclusion').value;
        if (a<3){
            var hasil = "Kurang berinisiatif";
            }else if (a>2 && a<7){
                var hasil = "Kadang-kadang ingin mengajukan inisiatif";
            }else{
                var hasil = "Penggerak atau pengorganisir kelompok";
            }
        document.getElementById('AreaexpressedInc').innerHTML = hasil;
    });
    $('#expressedControl').on('change',function(){
        var a = document.getElementById('expressedControl').value;
        if (a<3){
            var hasil = "Tidak ingin memimpin atau mencari tanggung jawab";
            }else if (a>2 && a<7){
                var hasil = "Kadang-kadang bersedia memimpin";
            }else{
                var hasil = "Senang mengarahkan atau memberi petunjuk kepada orang tentang apa yang harus dikerjakan";
            }
        document.getElementById('AreaexpressedCon').innerHTML = hasil;
    });
    $('#expressedAffection').on('change',function(){
        var a = document.getElementById('expressedAffection').value;
        if (a<3){
            var hasil = "Menyukai membuat jarak dengan teman atau kenalan";
            }else if (a>2 && a<7){
                var hasil = "Melihat-lihat dulu, siapa yang kenalan dan apa tujuan perkenalan itu";
            }else{
                var hasil = "Suka bersikap akrab, hangat, ramah kepada orang lain";
            }
        document.getElementById('AreaexpressedAff').innerHTML = hasil;
    });
    $('#wantedInclusion').on('change',function(){
        var a = document.getElementById('wantedInclusion').value;
        if (a<3){
            var hasil = "Tidak tertarik kepada pengelompokan";
            }else if (a>2 && a<7){
                var hasil = "Menggantungkan diri pada kelompok";
            }else{
                var hasil = "Mempunyai dorongan yang kuat untuk diikutsertakan dalam kelompok";
            }
        document.getElementById('AreawantedInc').innerHTML = hasil;
    });
    $('#wantedControl').on('change',function(){
        var a = document.getElementById('wantedControl').value;
        if (a<3){
            var hasil = "Tidak senang diawasi atau diatur orang";
            }else if (a>2 && a<7){
                var hasil = "Kadang-kadang mau diatur tergantung pada pentingnya topik atau situasi";
            }else{
                var hasil = "Merasa lebih enak atau senang kalau ada orang yang membimbing atau memberi petunjuk";
            }
        document.getElementById('AreawantedCon').innerHTML = hasil;
    });
    $('#wantedAffection').on('change',function(){
        var a = document.getElementById('wantedAffection').value;
        if (a<3){
            var hasil = "Tidak ingin didekati atau diakrabi orang lain";
            }else if (a>2 && a<7){
                var hasil = "Bersifat pilih pilih";
            }else{
                var hasil = "Butuh dicintai, diperhatikan, didekati";
            }
        document.getElementById('AreawantedAff').innerHTML = hasil;
    });
    $('#expressedInclusion, #wantedInclusion').on('change',function(){
        var a = document.getElementById('totalInclusion').value;
        if (a<6){
            var hasil = "Anda cenderung memilih waktu sendirian dibanding menghabiskan waktu dengan orang lain";
            }else if (a>5 && a<13){
                var hasil = "Anda lebih memilih keseimbangan antara waktu sendirian dan waktu dengan orang lain";
            }else{
                var hasil = "Anda memiliki preferensi yang kuat untuk terlibat dalam situasi sosial sebagian besar waktu";
            }
        document.getElementById('AreatotalInc').innerHTML = hasil;
    });
    $('#expressedControl, #wantedControl').on('change',function(){
        var a = document.getElementById('totalControl').value;
        if (a<6){
            var hasil = "Anda cenderung memilih situasi tidak terstruktur";
            }else if (a>5 && a<13){
                var hasil = "Anda lebih memilih jumlah keseimbangan struktur dan kejelasan wewenang dan tanggung jawab";
            }else{
                var hasil = "Anda cenderung memilih situasi terstruktur dimana ada garis yang jelas tentang wewenang dan tanggung jawab";
            }
        document.getElementById('AreatotalCon').innerHTML = hasil;
    });
    $('#expressedAffection, #wantedAffection').on('change',function(){
        var a = document.getElementById('totalAffection').value;
        if (a<6){
            var hasil = "Anda cenderung untuk menjaga hal-hal bersifat pribadi dan lebih memilih yang lebih formal, seperti hubungan bisnis";
            }else if (a>5 && a<13){
                var hasil = "Anda lebih memilih keseimbangan hubungan antara probadi dan hubungan bisnis";
            }else{
                var hasil = "Biasanya anda suka banyak kehangatan dan kedekatan dalam satu ke satu hubungan anda";
            }
        document.getElementById('AreatotalAff').innerHTML = hasil;
    });
    $('#expressedAffection, #expressedControl, #expressedInclusion').on('change',function(){
        var a = document.getElementById('totalExpressed').value;
        if (a<8){
            var hasil = "Anda cenderung nyaman memulai kegiatan dan biasanya menunggu sebelum berbicara atau bertindak untuk melihat apakah kontribusi anda diperlukan";
            }else if (a>7 && a<20){
                var hasil = "Anda akan memulai dengan orang lain, tapi jelas tergantung pada orangnya dan situasinya";
            }else{
                var hasil = "Anda merasa nyaman dengan orang lain dan situasi dalam memulai suatu kegiatan";
            }
        document.getElementById('AreaexpressedTot').innerHTML = hasil;
    });
    $('#wantedAffection, #wantedControl, #wantedInclusion').on('change',function(){
        var a = document.getElementById('wantedExpressed').value;
        if (a<8){
            var hasil = "Anda cenderung tidak nyaman dengan orang lain untuk memulai kegiatan dan biasanya tidak berharap banyak dari orang";
            }else if (a>7 && a<20){
                var hasil = "Anda merasa nyaman dengan orang lain memulai kegiatan tetapi jelas tergantung pada orang dan situasi";
            }else{
                var hasil = "Anda merasa nyaman dengan orang lain dalam memulai suatu kegiatan";
            }
        document.getElementById('AreawantedExpressed').innerHTML = hasil;
    });
    $('#expressedControl, #expressedInclusion, #expressedAffection, #wantedInclusion, #wantedControl, #wantedAffection').on('change',function(){
        var a = document.getElementById('overall').value;
        if (a<16){
            var hasil = "Anda mungkin merasa sedikit kebutuhan untuk terlibat dengan orang lain, memiliki preferensi yang kuat untuk bekerja sendiri dan cenderung dekat dengan sedikit atau beberapa orang";
            }else if (a>15 && a<27){
                var hasil = "Keterlibatan dengan orang lain dapat bermanfaat untuk anda, tergantung pada situasi";
            }else if (a>26 && a<39){
                var hasil = "Keterlibatan dengan orang lain sering memuaskan anda. Anda mungkin lebih suka bekerja dengan kelompok kecil dan kontak regular dan cenderung memiliki kelompok yang lebih besar dari teman dan rekan";
            }else{
                var hasil = "Anda memiliki kebutuhan untuk keterlibatan dengan orang lain. Memiliki preferensi yang kuat untuk bekerja dalam kelompok besar dan dekat dengan banyak orang";
            }
        document.getElementById('Areaoverall').innerHTML = hasil;
    });
    $('#expressedAffection, #expressedControl, #expressedInclusion').on('change',function(){
        var a = document.getElementById('expressedInclusion').value;
        var b = document.getElementById('expressedControl').value;
        var c = document.getElementById('expressedAffection').value;
        var total = parseInt(a) + parseInt(b) + parseInt(c);
        document.getElementById('totalExpressed').value = total;
    });
    $('#wantedAffection, #wantedControl, #wantedInclusion').on('change',function(){
        var a = document.getElementById('wantedInclusion').value;
        var b = document.getElementById('wantedControl').value;
        var c = document.getElementById('wantedAffection').value;
        var total = parseInt(a) + parseInt(b) + parseInt(c);
        document.getElementById('wantedExpressed').value = total;
    });
    $('#expressedInclusion, #wantedInclusion').on('change',function(){
        var a = document.getElementById('wantedInclusion').value;
        var b = document.getElementById('expressedInclusion').value;
        var total = parseInt(a) + parseInt(b);
        document.getElementById('totalInclusion').value = total;
    });
    $('#wantedControl, #expressedControl').on('change',function(){
        var a = document.getElementById('expressedControl').value;
        var b = document.getElementById('wantedControl').value;
        var total = parseInt(a) + parseInt(b);
        document.getElementById('totalControl').value = total;
    });
    $('#wantedAffection, #expressedAffection').on('change',function(){
        var a = document.getElementById('expressedAffection').value;
        var b = document.getElementById('wantedAffection').value;
        var total = parseInt(a) + parseInt(b);
        document.getElementById('totalAffection').value = total;
    });
    $('#expressedControl, #expressedInclusion, #expressedAffection, #wantedInclusion, #wantedControl, #wantedAffection').on('change',function(){
        var a = document.getElementById('expressedInclusion').value;
        var b = document.getElementById('expressedControl').value;
        var c = document.getElementById('expressedAffection').value;
        var d = document.getElementById('wantedInclusion').value;
        var e = document.getElementById('wantedControl').value;
        var f = document.getElementById('wantedAffection').value;
        var total = parseInt(a) + parseInt(b) + parseInt(c) + parseInt(d) + parseInt(e) + parseInt(f);
        document.getElementById('overall').value = total;
    });
</script>