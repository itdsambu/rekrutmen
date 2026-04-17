
    <?php 
    $no = 1;
        foreach($_getData as $item){?>
            <tr>
                <td class="text-center" id=""><?php echo $no++;?>
                </td>
                <td class="text-center" id=""><?php echo $item->NamaItem?>
                    <input type="hidden" name="txtItemID[]" id="TxtItemID" value="<?php echo $item->ItemID?>">
                </td>
                <td><?php echo $item->NamaSatuan?>
                    <input type="hidden" id="txtSatuanID" name="txtSatuanID[]" value="<?php echo $item->SatuanID?>">
                    
                </td>
                <td><?php echo $item->NamaKategori?>
                    <input type="hidden" name="txtKategoriID[]" id="txtKategoriID" value="<?php echo $item->KategoriID?>"></td>
                <td class="text-center">
                    <?php if(count($_getData)>0):?>
                        <input id="harga" name="txtHarga[]" onkeydown="return numbersonly(this, event);" onkeyup="tandaPemisahTitik(this);" value="<?php echo number_format($item->Harga,0,",",".")?>">
                    <?php else:?>
                        <input id="harga" name="txtHarga[]" onkeydown="return numbersonly(this, event);" onkeyup="tandaPemisahTitik(this);" value="">
                    <?php endif;?>
                </td>
            </tr>
    <?php }?>

    <script type="text/javascript">
  $(document).ready(function() {
    $('#dataTables').dataTable();
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

</script>