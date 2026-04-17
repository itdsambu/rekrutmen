<table class="table table-bordered" id="dataTables1">
    <thead>
      <tr style="background-color: #b3ccff;color: #000000;height: 50%;font-weight: bold;">
        <th class="text-center">No.</th>
        <th class="text-center">Nama Item</th>
        <th class="text-center">Satuan</th>
        <th class="text-center">Kategori</th>
        <th class="text-center">Barcode</th>
        <th class="text-center">Harga</th>
      </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
            if($cek_data == NULL){
                foreach($_getHarga as $itm){?>
                <tr>
                    <td class="text-center"><?php echo $no++;?>
                        <input type="hidden" name="txtHeaderid">
                    </td>
                    <td>
                        <?php echo $itm->NamaItem?>
                        <input type="hidden" class="form-control" style="width: 100%;" name="txtNamaItem[]" value="<?php echo $itm->NamaItem?>" >
                        <input type="hidden" name="txtItemID[]" value="<?php echo $itm->ItemID?>">
                    </td>
                    <td>
                       <input type="text" class="form-control" name="txtNamaSatuan[]" value="<?php echo $itm->SingkatanSatuan?>" readonly>
                       <input type="hidden" class="form-control" name="txtSatuanID[]" value="<?php echo $itm->SatuanID?>">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="txtNamaKategori[]" value="<?php echo $itm->NamaKategori?>" readonly>
                        <input type="hidden" class="form-control" name="txtKategoriID[]" value="<?php echo $itm->KategoriID?>">
                    </td>
                    <td class="text-center">
                        <input type="text" class="form-control" value="<?php echo $itm->KodeBarkode?>" readonly>
                    </td>
                    <td>
                        <input type="text" name="txtHarga[]" class="form-control" id="harga" style="width: 100%;" onkeydown="return numbersonly(this, event);" onkeyup="tandaPemisahTitik(this);" class="form-control" value="<?php foreach($_getHarga as $get){if($get->ItemID == $itm->ItemID){echo number_format($get->Harga,0,",",".");}}?>">
                    </td>
                </tr>
            <?php }
            }else{
                foreach($_getHarga as $itm){?>
                <tr>
                    <td class="text-center"><?php echo $no++;?>
                        <input type="hidden" name="txtHeaderid" value="<?php echo $itm->HeaderHargaID; ?>">
                        <input type="hidden" name="txtDetailID" value="<?php echo $itm->DetailHargaID; ?>">
                    </td>
                    <td>
                        <?php echo $itm->NamaItem?>
                        <input type="hidden" class="form-control" style="width: 100%;" name="txtNamaItem[]" value="<?php echo $itm->NamaItem?>" >
                        <input type="hidden" name="txtItemID[]" value="<?php echo $itm->ItemID?>">
                    </td>
                    <td>
                       <input type="text" class="form-control"  name="txtNamaSatuan[]" value="<?php echo $itm->SingkatanSatuan?>" readonly>
                       <input type="hidden" name="txtSatuanID[]" value="<?php echo $itm->SatuanID?>">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="txtNamaKategori[]" value="<?php echo $itm->NamaKategori?>" readonly>
                        <input type="hidden" name="txtKategoriID[]" value="<?php echo $itm->KategoriID?>">
                    </td>
                    <td>
                        <input type="text" class="form-control" value="Not Found" readonly>
                    </td>
                    <td>
                        <input type="text" name="txtHarga[]" class="form-control" style="width: 100%;" onkeydown="return numbersonly(this, event);" onkeyup="tandaPemisahTitik(this);" class="form-control" value="<?php foreach($_getHarga as $get){if($get->ItemID == $itm->ItemID){echo number_format($get->Harga,0,",",".");}}?>">
                    </td>
                </tr>
            <?php }
            }
        ?>
    </tbody>
</table>
<script type="text/javascript">
   $(document).ready(function() {
        $('#dataTables').dataTable({
            paging: false,
            searching : false,
        });
    });

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

function formatNumber (num) {
    var hasil = num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
    // var hasilakhir = hasil.replace(",", "");
    return hasil;
}
</script>