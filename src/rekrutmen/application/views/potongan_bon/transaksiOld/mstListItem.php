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
        <tr>
            <td class="text-center">
                <a class="btn btn-minier btn-danger"><i class="fa fa-trash"></i></a>
                <input type="hidden" name="txtPemborong" id="pemborong1" value="<?php echo $pemborong?>">
            </td>
            <td style="width: 350px;">
                <div>
                    <select class="form-control select2 txt" name="txtItem[]" id="item1" onchange="ajax_harga(this.id)">
                        <option value="">- Pilih -</option>
                        <?php foreach($_getListItem as $itm){
                            echo "<option value='".$itm->ItemID."'>".$itm->NamaItem."</option>";
                        }?>
                    </select>
                </div>
            </td>
            <td id="idItem1">
                <input type="text" class="form-control" name="txtHarga[]" id="harga1" value="" onkeyup="hitung(1)">
                <input type="hidden" class="form-control" name="txtHargaid[]" id="hargaid1" value="">
            </td>
            <td><input type="text" class="form-control" name="txtQuantity[]" id="quantity1" value="0" onkeyup="hitung(1)"></td>
            <td>
                <input type="text" class="form-control" name="txtSatuan[]" id="satuan1" readonly="">
                <input type="hidden" name="txtSatuanid[]" id="satuanid1" class="form-control" readonly="">
            </td>
            <td>
                <input type="text" class="form-control" name="txtKategori[]" id="kategori1" readonly="">
                <input type="hidden" class="form-control" name="txtKategoriid[]" id="kategoriid1" readonly="">
            </td>
            <td>
                <input type="text" class="form-control" name="txtTotal[]" id="total1" value="0" readonly="" onkeyup="hitung(1)">
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6" class="text-center"><strong>Grand Total</strong></td>
            <td>
                <input type="text" class="form-control" name="txtGrandTotal" id="grandTotal" value="0" readonly="">
            </td>
        </tr>
    </tfoot>
</table>

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
                  <input type="hidden" name="txtPemborong" id="pemborong1" value="<?php echo $pemborong?>">\n\
                  <a id="hapus'+l+'" class="btn btn-minier btn-danger" onclick="hapus_baris(this)"><i class="fa fa-trash"></i>\n\
                    </a>\n\
                  </td>\n\
                  <td>\n\
                      <select id="item'+l+'" name="txtItem[]" class="form-control select2 txt" onchange="ajax_harga(this.id)">\n\
                      </select>\n\
                  </td>\n\
                  <td class="text-center" id="idItem'+l+'">\n\
                     <input type="text" class="form-control" id="harga'+l+'" name="txtHarga[]" onkeyup="hitung('+l+')"/>\n\
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
                     <input type="text" name="txtTotal[]" id="total'+l+'" class="form-control" onkeyup="hitung('+l+')" readonly=""/>\n\
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

        jumlah = harga * quantity;
        document.getElementById('total'+id).value = jumlah;

        var grand = 0;
        for(var i= 1; i<=jmlBaris;i++){
          grand += parseInt($('#total'+i).val());
          
        }
        
        document.getElementById("grandTotal").value = Math.ceil(grand);
    }

    function hapus_baris(ip){
      var tr = ip.parentNode.parentNode;
      tr.parentNode.removeChild(tr);
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
</script>

<script type="text/javascript">
   $(document).ready(function() {
    $('.select2').select2();
});
</script>