<div class="col-lg-12" id="getListPra">
    <?php foreach ($getBarcode as $kode){?>
    <div class="form-group">
        <label class="col-lg-2 control-label">Kode Item (Auto)</label>
        <div class="col-sm-4">
          <input type="hidden" name="txtTanggal" class="form-control" value="<?php echo date('Y-m-d')?>">
          <input type="hidden" name="txtItemID" class="form-control" value="<?php echo $kode->ItemID?>">
            <input type="text" name="txtKodeItem" class="form-control" value="<?php echo $kode->KodeItem;?>" readonly>
        </div>
    </div>
     
    <div class="form-group">
        <label class="col-lg-2 control-label">Nama Item</label>
        <div class="col-sm-4">
            <input type="text" name="txtNamaItem" class="form-control" placeholder="Nama Item" required value="<?php echo $kode->NamaItem?>" readonly>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Satuan</label>
        <div class="col-sm-4">
            <input type="text" name="txtSatuanid" class="form-control" placeholder="Nama Item" required value="<?php echo $kode->SingkatanSatuan?>" readonly>
            <input type="hidden" name="txtSatuan" class="form-control" placeholder="Nama Item" required value="<?php echo $kode->SatuanID?>" readonly>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Kategori</label>
        <div class="col-sm-4">
            <input type="text" name="txtKategoriid" class="form-control" placeholder="Nama Item" required value="<?php echo $kode->NamaKategori?>" readonly>
            <input type="hidden" name="txtKategori" class="form-control" placeholder="Nama Item" required value="<?php echo $kode->KategoriID?>" readonly>
        </div>
    </div>
    <div class="form-group">
        <label class="col-lg-2 control-label">Harga</label>
        <div class="col-sm-4">
        <?php $group_id = $this->session->userdata('groupuser');
        $data_pemborong = $this->M_PotonganBon->GetIdSubPemborong($group_id);
        
        $id_sub_pemborong = $data_pemborong->IDSubPemborong;?>

        <?php if($id_sub_pemborong == $kode->IDSubPemborong):?>
            <input type="text" name="txtHarga" id="Harga"  class="form-control"  placeholder="Harga" autocomplete="off" onkeydown="return numbersonly(this, event);" onkeyup="tandaPemisahTitik(this);" value="<?php echo number_format($kode->Harga,0,",",".")?>">
        <?php else:?>
            <input type="text" name="txtHarga" id="Harga" class="form-control" autocomplete="off" placeholder="Harga" value="">
        <?php endif;?>
        </div>
    </div>                       
    <div class="form-group">
        <label class="col-lg-2 control-label"></label>
        <div class="col-sm-4">
            <button type="submit" class="btn btn-sm btn-success">Simpan</button>
        </div>
    </div>
  </div>
<?php }?>
</div>

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