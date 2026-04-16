
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><i class="glyphicon glyphicon-shopping-cart"></i> TRANSAKSI PESANAN</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <br>
            <div class="col-lg-12">
            <?php if($this->input->get('msg') == "success"){
                  echo "<div class='alert alert-success'>";
                  echo "<strong>Sukses !!!</strong> Data berhasil di Proses.";
                  echo "</div>";
              }elseif($this->input->get('msg') == "failed"){
                  echo "<div class='alert alert-danger'>";
                  echo "<strong>Gagal !!!</strong> Data Sudah diinput..!!";
                  echo "</div>";
              }?>
                
            </div>
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PotonganBon/simpan_trn_potongan_pemborong');?>">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                      <div class="col-lg-12">
                        <?php foreach($_getTrnHeader as $hdr){?>
                            <input type="hidden" name="txtHeaderID" id="headerid" value="<?php echo $hdr->HeaderID?>">
                      	<div class="form-group">
                      		<label class="col-lg-2 control-label">Tanggal Transaksi</label>
                      		<div class="col-sm-4">
                      			<input type="date" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d',strtotime($hdr->Tanggal))?>" readonly>
                      		</div>
                      	</div>
                      	<div class="form-group">
                      		<label class="col-lg-2 control-label">Pemborong</label>
                      		<div class="col-sm-4">
                      			<select class="form-control select2" name="txtPemborong" id="pemborong" onchange="get_item_pemborong()">
                                    <option value="">- Pilih -</option>
                                    <?php foreach($_getDataPemborong as $pbr){
                                        if($pbr->IDPemborong == $hdr->IDPemborong){
                                            echo "<option value='".$pbr->IDPemborong."' selected>".$pbr->Pemborong."</option>";
                                        }else{
                                            echo "<option value='".$pbr->IDPemborong."'>".$pbr->Pemborong."</option>";
                                        }
                                    }?>
                                </select>
                      		</div>
                      	</div>
                        <div class="form-group">
                            <label class="col-lg-2 control-label">NIK</label>
                            <div class="col-sm-4">
                                <input type="text" name="txtNik" id="nik" placeholder="Input Nik" class="form-control" value="<?php echo $hdr->Nik?>" readonly>
                                <input type="hidden" name="txtNofix" id="nofix" placeholder="Input Nik" class="form-control" value="<?php echo $hdr->Nofix?>" readonly>
                            </div>
                        </div>
                        <div id="tkid">
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Nama Lengkap</label>
                                <div class="col-sm-4">
                                    <input type="text" name="txtNama" class="form-control" readonly="" value="<?php echo $hdr->Nama?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-lg-2 control-label">Bagian/Dept</label>
                                <div class="col-sm-4">
                                    <input type="text" name="txtDept" class="form-control" readonly="" value="<?php echo $hdr->Bagian?>">
                                </div>
                            </div>
                        </div>
                        <?php }?>
                      </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-lg-12">
                           <div class="table-responsive" id="listid">
                            <a class="btn btn-sm btn-warning" onclick="tambah_baris()"><i class="fa fa-plus"></i> Tambah Item</a>
                            <hr>
                           <table class="table table-bordered" id="dataTables">
                            <thead>
                              <tr>
                                <th class="text-center" style="background-color: #d9edf7;"><label class="label label-sm label-default"><i class="fa fa-trash"></i></label>
                                    
                                </th>
                                <th class="text-center" style="background-color: #d9edf7;">Nama Item</th>
                                <th class="text-center" style="background-color: #d9edf7;">Harga (Rp.)</th>
                                <th class="text-center" style="background-color: #d9edf7;">Quantity</th>
                                <th class="text-center" style="background-color: #d9edf7;">Satuan</th>
                                <th class="text-center" style="background-color: #d9edf7;">Kategori</th>
                                <th class="text-center" style="background-color: #d9edf7;">Total</th>
                              </tr>
                            </thead>
                            <tbody id="">
                                <?php 
                                $no = 1;
                                $htg = 1;
                                foreach($_getTrnDetail as $dtl){?>
                                <tr>
                                    <td class="text-center">
                                        <a class="btn btn-minier btn-danger" id="<?php echo $dtl->DetailID?>" onclick="hapus_item(this.id);"><i class="fa fa-trash"></i></a>
                                        <input type="hidden" name="txtPemborong" id="pemborong1" value="<?php echo $dtl->IDPemborong?>">
                                        <input type="hidden" name="txtDetailID[]" id="detailid" value="<?php echo $dtl->DetailID?>">
                                    </td>
                                    <td style="width: 350px;">
                                        <div>
                                            <select class="form-control select2 txt" name="txtItem[]" id="item<?php echo $no++;?>" onchange="ajax_harga(this.id)">
                                                <option value="">- Pilih -</option>
                                                <?php foreach($_getListItem as $itm){
                                                    if($dtl->ItemID != $itm->ItemID){
                                                        echo "<option value='".$itm->ItemID."'>".$itm->NamaItem."</option>";
                                                    }else{
                                                        echo "<option value='".$itm->ItemID."' selected>".$itm->NamaItem."</option>";
                                                    }
                                                }?>
                                            </select>
                                        </div>
                                    </td>
                                    <td id="idItem1">
                                        <input type="text" class="form-control" name="txtHarga[]" id="harga<?php echo $no++;?>" value="<?php echo number_format($dtl->Harga,0,",",".")?>" onkeyup="hitung(1)" readonly="">
                                        <input type="hidden" class="form-control" name="txtHargaid[]" id="hargaid1" value="<?php echo $dtl->HargaID?>">
                                    </td>
                                    <td><input type="number" class="form-control" name="txtQuantity[]" id="quantity<?php echo $no++;?>" value="<?php echo $dtl->Quantity?>" onkeyup="hitung(1)"></td>
                                    <td>
                                        <input type="text" class="form-control" name="txtSatuan[]" id="satuan1" readonly="" value="<?php echo $dtl->SingkatanSatuan?>">
                                        <input type="hidden" name="txtSatuanid[]" id="satuanid1" class="form-control" readonly="" value="<?php echo $dtl->SatuanID?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="txtKategori[]" id="kategori1" readonly="" value="<?php echo $dtl->NamaKategori?>">
                                        <input type="hidden" class="form-control" name="txtKategoriid[]" id="kategoriid1" readonly="" value="<?php echo $dtl->KategoriID?>">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="txtTotal[]" id="total<?php echo $no++?>" value="<?php echo $dtl->Total?>" readonly="" onkeyup="hitung(1)">
                                    </td>
                                </tr>
                                <?php }?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-center"><strong>Grand Total</strong></td>
                                    <td>
                                        <input type="text" class="form-control" name="txtGrandTotal" id="grandTotal" value="<?php foreach($_getGrandTotal as $gtl){ echo number_format($gtl->GrandTotal,0,",","."); }?>" readonly>
                                    </td>
                                </tr>
                            </tfoot>
                          </table>
                        </div>
                        </div>
                    </div>
                    <hr>
                    <button class="btn btn-sm btn-success">Simpan</button>
                    <a href="" class="btn btn-sm btn-default">Kembali</a>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
   $(document).ready(function() {
    $('.select2').select2();
});
</script>

<script type="text/javascript">
    function tambah_baris(){
        // alert('hahaha');
        var jum = document.getElementsByClassName('txt');
        var l = jum.length+1;

        var no = l+1;
          var num = 1;
          for (var i = 0; i < num; i++) {
              $('table[id="dataTables"]').append('<tbody id="dataTable1">\n\
                <tr>\n\
                  <td class="text-center">\n\
                  <a id="hapus'+l+'" class="btn btn-minier btn-danger" onclick="hapus_baris(this)"><i class="fa fa-trash"></i>\n\
                    </a>\n\
                    <input type="hidden" name="txtDetailID[]" id="detailid" value="">\n\
                  </td>\n\
                  <td>\n\
                      <select id="item'+l+'" name="txtItem[]" class="form-control select2 txt" onchange="ajax_harga(this.id)">\n\
                      </select>\n\
                  </td>\n\
                  <td class="text-center" id="idItem'+l+'">\n\
                     <input type="text" class="form-control" id="harga'+l+'" name="txtHarga[]" value="0" onkeydown="return numbersonly(this, event);" onkeyup="tandaPemisahTitik(this);" readonly=""/>\n\
                     <input type="hidden" class="form-control" name="txtHargaid[]" id="hargaid'+l+'" value="">\n\
                  </td>\n\
                  <td class="text-center">\n\
                       <input type="text" name="txtQuantity[]" id="quantity'+l+'" class="form-control" value="0" onkeyup="hitung('+l+')">\n\
                    </td>\n\
                   <td class="text-center">\n\
                      <input type="text" name="txtSatuan[]" id="satuan'+l+'" class="form-control" readonly="">\n\
                      <input type="hidden" name="txtSatuanid[]" id="satuanid'+l+'" class="form-control" readonly="">\n\
                  </td>\n\
                  <td>\n\
                        <input type="text" class="form-control" name="txtKategori[]" id="kategori'+l+'" readonly="">\n\
                        <input type="hidden" class="form-control" name="txtKategoriid[]" id="kategoriid'+l+'" readonly="">\n\
                    </td>\n\
                  <td class="text-center">\n\
                     <input type="text" name="txtTotal[]" id="total'+l+'" value="0" class="form-control" onkeyup="hitung('+l+')" readonly=""/>\n\
                     </td>\n\
              </tr>\n\
              </tbody>');
          }

          $('#item1 option').clone().appendTo('#item'+l);
          $('.select2').select2(); 
    }

    function hitung(id){
        var jmlBaris    = document.getElementsByClassName('txt').length;
        var hrg         = $('#harga'+id).val();
        var harga       = hrg.replace(".","");
        var quantity    = $('#quantity'+id).val();

        alert(hrg);

        // jumlah = harga * quantity;
        // // alert(jumlah);
        // document.getElementById('total'+id).value = jumlah;

        // var grand = 0;
        // for(var i= 1; i<=jmlBaris;i++){
        //   grand += parseInt($('#total'+i).val());
          
        // }

        // grandTotal = Math.ceil(grand);
        
        // document.getElementById("grandTotal").value = tandaPemisahTitik(grandTotal);
    }

    function hapus_baris(ip){
      var tr = ip.parentNode.parentNode;
      tr.parentNode.removeChild(tr);
      location.reload();
    }

    function tandaPemisahTitik(b){
        var _minus = false;
        if (b<0) _minus = true;
        b = b.toString();
        b=b.replace(".","");
        
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--){
             j = j + 1;
             if (((j % 3) == 1) && (j != 1)){
               c = b.substr(i-1,1) + "." + c;
             } else {
               c = b.substr(i-1,1) + c;
             }
        }
        if (_minus) c = "-" + c ;
        return c;
    }

    function numbersonly(ini, e){
        if (e.keyCode>=49){
            if(e.keyCode<=57){
            a = ini.value.toString().replace(".","");
            b = a.replace(/[^\d]/g,"");
            b = (b=="0")?String.fromCharCode(e.keyCode):b + String.fromCharCode(e.keyCode);
            ini.value = tandaPemisahTitik(b);
            return false;
            }
            else if(e.keyCode<=105){
                if(e.keyCode>=96){
                    //e.keycode = e.keycode - 47;
                    a = ini.value.toString().replace(".","");
                    b = a.replace(/[^\d]/g,"");
                    b = (b=="0")?String.fromCharCode(e.keyCode-48):b + String.fromCharCode(e.keyCode-48);
                    ini.value = tandaPemisahTitik(b);
                    //alert(e.keycode);
                    return false;
                    }
                else {return false;}
            }
            else {
                return false; }
        }else if (e.keyCode==48){
            a = ini.value.replace(".","") + String.fromCharCode(e.keyCode);
            b = a.replace(/[^\d]/g,"");
            if (parseFloat(b)!=0){
                ini.value = tandaPemisahTitik(b);
                return false;
            } else {
                return false;
            }
        }else if (e.keyCode==95){
            a = ini.value.replace(".","") + String.fromCharCode(e.keyCode-48);
            b = a.replace(/[^\d]/g,"");
            if (parseFloat(b)!=0){
                ini.value = tandaPemisahTitik(b);
                return false;
            } else {
                return false;
            }
        }else if (e.keyCode==8 || e.keycode==46){
            a = ini.value.replace(".","");
            b = a.replace(/[^\d]/g,"");
            b = b.substr(0,b.length -1);
            if (tandaPemisahTitik(b)!=""){
                ini.value = tandaPemisahTitik(b);
            } else {
                ini.value = "";
            }
            
        return false;
        } else if (e.keyCode==9){
            return true;
        } else if (e.keyCode==17){
            return true;
        } else {
            //alert (e.keyCode);
        return false;
        }

    }
</script>

<script type="text/javascript">
    function ajax_harga(id){
        var idBaris  = id.substr(4);
        var jmlBaris = document.getElementsByClassName('txt').length;
        var item     = $('#'+id).val();
        var pbr     = $('#pemborong1').val();

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_harga')?>"+"/"+item+"/"+pbr,
            success: function(msg){
                  if(msg == ''){
                    alert('Tidak ada data');
                  } 
                  else{
                      $("#harga"+idBaris).val(msg);                                                       
                  }
              }
       });

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_hargaid')?>"+"/"+item+"/"+pbr,
            success: function(msg){
                  if(msg == ''){
                    alert('Tidak ada data');
                  } 
                  else{
                      $("#hargaid"+idBaris).val(msg);                                                       
                  }
              }
       });

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_satuan')?>"+"/"+item+"/"+pbr,
            success: function(msg){
                  if(msg == ''){
                    alert('Tidak ada data');
                  } 
                  else{
                      $("#satuan"+idBaris).val(msg);                                                     
                  }
              }
        });

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_satuanid')?>"+"/"+item+"/"+pbr,
            success: function(msg){
                  if(msg == ''){
                    alert('Tidak ada data');
                  } 
                  else{
                      $("#satuanid"+idBaris).val(msg);                                                     
                  }
              }
        });

        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_kategori')?>"+"/"+item+"/"+pbr,
            success: function(msg){
                  if(msg == ''){
                    alert('Tidak ada data');
                  } 
                  else{
                      $("#kategori"+idBaris).val(msg);                                                     
                  }
              }
       });
        $.ajax({
            type: "GET",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/ajax_kategoriid')?>"+"/"+item+"/"+pbr,
            success: function(msg){
                  if(msg == ''){
                    alert('Tidak ada data');
                  } 
                  else{
                      $("#kategoriid"+idBaris).val(msg);                                                     
                  }
              }
       });
    }

    function hapus_item(id){
        var dtlid = id;

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url('PotonganBon/hapus_item')?>"+"/"+dtlid,
            success: function(msg){
                location.reload();
            }
          });
    }
</script>
