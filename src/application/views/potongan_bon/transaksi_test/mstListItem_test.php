<input type="hidden" name="txtSubPemborong" value="<?=$subpemborong?>">
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <label><b><i class="fa fa-search"></i> Pencarian Item</b></label>
    </div>    
</div>
<div class="row">
    <div class="col-lg-10 col-sm-9 col-xs-9">
        <input type="text" id="search" class="form-control" autocomplete="off" placeholder="Contoh : MILO SC 22G (RTG10+1)">
    </div>
    <div class="col-lg-2 col-sm-3 col-xs-3">
        <button type="button" class="btn btn-primary btn-sm col-lg-12 col-sm-12 col-xs-12" onclick="getSearchItem();"><b>Cari Item</b></button>
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <div style="height: 300px; overflow-y: scroll;">    
            <table class="table table-bordered" id="dataTables">
                <thead>
                  <tr>
                    <th class="text-center" style="background-color: #d9edf7;">Nama Item</th>
                    <th class="text-center" style="background-color: #d9edf7;">Harga (Rp.)</th>
                    <th class="text-center" style="background-color: #d9edf7;">Satuan</th>
                    <th class="text-center" style="background-color: #d9edf7;">Kategori</th>
                    <th class="text-center" style="background-color: #d9edf7;">Aksi</th>
                  </tr>
                </thead>
                <tbody id="tbodySearchItem">
                    <tr>
                        <td class="text-center" colspan="5">Silahkan untuk mencari produk...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-1 col-sm-2 col-xs-2">
        <label class=" control-label"><b>Barcode</b></label>
    </div>
    <div class="col-lg-11 col-sm-10 col-xs-10">
        <input type="text" id="BarcodeID" class="form-control" autocomplete="off">
    </div>
</div>
<br>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-xs-12">
        <table class="table table-bordered table-responsive" id="dataTables">
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
            <tbody id="tbodyItem"></tbody>
            <tfoot>
                <tr>
                    <td colspan="6" class="text-center"><strong>Grand Total</strong></td>
                    <td>
                        <input type="text" class="form-control" name="txtGrandTotal" id="grandTotal" readonly="">
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<div class="modal fade" id="modalPilihItem" tabindex="-1" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog" style="width:97%;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">PILIH ITEM</h4>
            </div>
            <div class="modal-body">                
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-xs-12">
                        <div style="height: 300px; overflow-y: scroll;">    
                            <table class="table table-bordered">
                                <thead>
                                  <tr>
                                    <th class="text-center" style="background-color: #d9edf7;">Nama Item</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Harga (Rp.)</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Satuan</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Kategori</th>
                                    <th class="text-center" style="background-color: #d9edf7;">Aksi</th>
                                  </tr>
                                </thead>
                                <tbody id="modalBodyItem">
                                    <tr>
                                        <td class="text-center" colspan="5">Silahkan untuk mencari produk...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#btnCari").click(function(){
        var Nik = $('#txtPraID').val();
        var pemborong = $('#pemborong').val();
        var subpemborong = $('#subpemborong').val();
        // alert(Nik);
        // alert(pemborong);
        if(Nik == ''){
            // alert('hahahaha');
        }else{
            // alert('wkwkwkwk');
            $.ajax({
                type: "POST",
                url : "<?php echo site_url('PotonganBon/cari_tenagakerja')?>",
                data: {
                    'Nik' : Nik,
                    'pemborong' : pemborong,
                    'subpemborong' : subpemborong,
                },
                success: function(msg){
                    $('#getListPra').html(msg);
                }
            });
            document.getElementById('btnCari').disabled = false;
        }
    });
</script>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        // Fungsi Ketika Input Barcode Diisi
        $('#BarcodeID').on('keydown',function(event){
            // Jika tombol Enter
            if(event.keyCode === 13) {
                event.preventDefault();
                // Ambil Isi Barcode
                var barCode = $('#BarcodeID').val();
                // Kosongkan Barcode
                $('#BarcodeID').val("");
                tambah_baris_barcode(barCode);
            }
        });

        $(window).keydown(function(event){
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });

        $('.select2').select2();
    });

    //BEGIN :: YAWALIYUL
    var arrItemID = [0];
    var arrSearchItem;
    var arrItemDiatasSatu;

    function getSearchItem(){
        $.ajax({
            url:"<?=base_url()?>PotonganBon/ajax_search_item_iyul",
            type:"POST",
            data:
            {
                pbrSub:$("#subpemborong").val(),
                search:$("#search").val(),
                kode:0,
            },
            dataType:"JSON",
            beforeSend:function()
            {
                $("#tbodySearchItem").html(`
                    <tr>
                        <td class="text-center" colspan="5"><b>Loading...Item sedang di cari!</b></td>
                    </tr>
                `);
            },
            error:function(){
                $("#tbodySearchItem").html(`
                    <tr>
                        <td class="text-center" colspan="5"><b>Error...Server tidak merespon!</b></td>
                    </tr>
                `);
            },
            success:function(response)
            {
                arrSearchItem = response;
                var html = "";
                for(var i = 0;i<response.length;i++){
                    html += `
                        <tr>
                            <td>${response[i].NamaItem}</td>
                            <td class="text-center">${tandaPemisahTitik(response[i].Harga)}</td>
                            <td class="text-center">${response[i].SingkatanSatuan}</td>
                            <td class="text-center">${response[i].NamaKategori}</td>
                            <td class="text-center"><button type="button" onclick="pilihItem(${i});" class="btn btn-primary btn-sm"><b>Pilih</b></button></td>
                        </tr>`;
                }
                $("#tbodySearchItem").html(html);
            }
        });
    }

    function pilihItem(x){
        var statusItemID = 0;
        for(var i=0;i < arrItemID.length;i++){
            if(arrSearchItem[x].ItemID == arrItemID[i]){
                statusItemID = 1;
                var quantity = parseInt($("#quantity_"+arrSearchItem[x].ItemID).val())+1;
                $("#quantity_"+arrSearchItem[x].ItemID).val(quantity);
                hitungTotal(arrSearchItem[x].ItemID);
                break;
            }else{
                statusItemID = 0;
            }
        }

        if(statusItemID == 0){
            arrItemID.push(arrSearchItem[x].ItemID);
            var html;
            html += `
                <tr class="rowItem" id="itemID_${arrSearchItem[x].ItemID}">
                    <input type="hidden" class="form-control" id="item_${arrSearchItem[x].ItemID}" name="txtItem[]" value="${arrSearchItem[x].ItemID}"/>
                    <input type="hidden" name="txtHargaid[]" value="${arrSearchItem[x].DetailHargaID}" id="hargaid_${arrSearchItem[x].ItemID}"class="form-control">
                    <input type="hidden" name="txtSatuanid[]" value="${arrSearchItem[x].SatuanID}" id="satuanid_${arrSearchItem[x].ItemID}" class="form-control">
                        <input type="hidden" name="txtKategoriid[]" value="${arrSearchItem[x].KategoriID}" id="kategoriid_${arrSearchItem[x].ItemID}" class="form-control">
                    <td class="text-center">
                        <a id="hapus_${arrSearchItem[x].ItemID}" class="btn btn-minier btn-danger col-lg-12 col-sm-12 col-xs-12" onclick="hapus_baris(this, ${arrSearchItem[x].ItemID})"><i class="fa fa-trash"></i>
                        </a>
                    </td>
                    <td class="col-lg-4 col-sm-4 col-xs-4">${arrSearchItem[x].NamaItem}</td>
                    <td class="text-center col-lg-2 col-sm-2 col-xs-2">
                        <input type="text" name="txtHarga[]" value="${tandaPemisahTitik(arrSearchItem[x].Harga)}" id="harga_${arrSearchItem[x].ItemID}" class="form-control classHarga" onkeypress="return getNumber(event);" onkeyup="hitungTotal(${arrSearchItem[x].ItemID});inputanFormat(this.value, this.id);"/>
                    </td>
                    <td class="text-center col-lg-1 col-sm-1 col-xs-1">
                        <input type="text" name="txtQuantity[]" value="1" id="quantity_${arrSearchItem[x].ItemID}" class="form-control classQuantity" onkeypress="return getNumber(event);" onkeyup="hitungTotal(${arrSearchItem[x].ItemID});">
                    </td>
                    <td class="text-center col-lg-1 col-sm-1 col-xs-1">
                        <input type="text" name="txtSatuan[]" value="${arrSearchItem[x].SingkatanSatuan}" id="satuan_${arrSearchItem[x].ItemID}" class="form-control" readonly="">
                    </td>
                    <td>
                        <input type="text col-lg-2 col-sm-2 col-xs-2" name="txtKategori[]" value="${arrSearchItem[x].NamaKategori}" id="kategori_${arrSearchItem[x].ItemID}" class="form-control" readonly="">
                    </td>
                    <td class="text-center col-lg-2 col-sm-2 col-xs-2">
                        <input type="text" name="txtTotal[]" id="total_${arrSearchItem[x].ItemID}" class="form-control rowGrandTotal" readonly=""/>
                    </td>
                </tr>`;
            if($("#tbodyItem tr").length > 0){
                $("#tbodyItem tr:first").before(html);
            }else{
                $("#tbodyItem").append(html);
            }
            hitungTotal(arrSearchItem[x].ItemID);
        }
    }

    function pilihItemBarcode(x){
        var statusItemID = 0;
        for(var i=0;i < arrItemID.length;i++){
            if(arrItemDiatasSatu[x].ItemID == arrItemID[i]){
                statusItemID = 1;
                var quantity = parseInt($("#quantity_"+arrItemDiatasSatu[x].ItemID).val())+1;
                $("#quantity_"+arrItemDiatasSatu[x].ItemID).val(quantity);
                hitungTotal(arrItemDiatasSatu[x].ItemID);
                break;
            }else{
                statusItemID = 0;
            }
        }

        if(statusItemID == 0){
            arrItemID.push(arrItemDiatasSatu[x].ItemID);
            var html;
            html += `
                <tr class="rowItem" id="itemID_${arrItemDiatasSatu[x].ItemID}">
                    <input type="hidden" class="form-control" id="item_${arrItemDiatasSatu[x].ItemID}" name="txtItem[]" value="${arrItemDiatasSatu[x].ItemID}"/>
                    <input type="hidden" name="txtHargaid[]" value="${arrItemDiatasSatu[x].DetailHargaID}" id="hargaid_${arrItemDiatasSatu[x].ItemID}"class="form-control">
                    <input type="hidden" name="txtSatuanid[]" value="${arrItemDiatasSatu[x].SatuanID}" id="satuanid_${arrItemDiatasSatu[x].ItemID}" class="form-control">
                        <input type="hidden" name="txtKategoriid[]" value="${arrItemDiatasSatu[x].KategoriID}" id="kategoriid_${arrItemDiatasSatu[x].ItemID}" class="form-control">
                    <td class="text-center">
                        <a id="hapus_${arrItemDiatasSatu[x].ItemID}" class="btn btn-minier btn-danger col-lg-12 col-sm-12 col-xs-12" onclick="hapus_baris(this, ${arrItemDiatasSatu[x].ItemID})"><i class="fa fa-trash"></i>
                        </a>
                    </td>
                    <td class="col-lg-4 col-sm-4 col-xs-4">${arrItemDiatasSatu[x].NamaItem}</td>
                    <td class="text-center col-lg-2 col-sm-2 col-xs-2">
                        <input type="text" name="txtHarga[]" value="${tandaPemisahTitik(arrItemDiatasSatu[x].Harga)}" id="harga_${arrItemDiatasSatu[x].ItemID}" class="form-control classHarga" onkeypress="return getNumber(event);" onkeyup="hitungTotal(${arrItemDiatasSatu[x].ItemID});inputanFormat(this.value, this.id);"/>
                    </td>
                    <td class="text-center col-lg-1 col-sm-1 col-xs-1">
                        <input type="text" name="txtQuantity[]" value="1" id="quantity_${arrItemDiatasSatu[x].ItemID}" class="form-control classQuantity" onkeypress="return getNumber(event);" onkeyup="hitungTotal(${arrItemDiatasSatu[x].ItemID});">
                    </td>
                    <td class="text-center col-lg-1 col-sm-1 col-xs-1">
                        <input type="text" name="txtSatuan[]" value="${arrItemDiatasSatu[x].SingkatanSatuan}" id="satuan_${arrItemDiatasSatu[x].ItemID}" class="form-control" readonly="">
                    </td>
                    <td>
                        <input type="text col-lg-2 col-sm-2 col-xs-2" name="txtKategori[]" value="${arrItemDiatasSatu[x].NamaKategori}" id="kategori_${arrItemDiatasSatu[x].ItemID}" class="form-control" readonly="">
                    </td>
                    <td class="text-center col-lg-2 col-sm-2 col-xs-2">
                        <input type="text" name="txtTotal[]" id="total_${arrItemDiatasSatu[x].ItemID}" class="form-control rowGrandTotal" readonly=""/>
                    </td>
                </tr>`;
            if($("#tbodyItem tr").length > 0){
                $("#tbodyItem tr:first").before(html);
            }else{
                $("#tbodyItem").append(html);
            }
            hitungTotal(arrItemDiatasSatu[x].ItemID);
        }
         $("#modalPilihItem").modal('hide');
    }

    function tambah_baris_barcode(barcode){
        $.ajax({
            url:"<?=base_url()?>PotonganBon/ajax_search_item_iyul",
            type:"POST",
            data:
            {
                pbrSub:$("#subpemborong").val(),
                search:barcode,
                kode:1,
            },
            dataType:"JSON",
            success:function(response)
            {
                if(response.length == 0){
                    Swal.fire(`Item Kosong`, `Item dengan barcode ${barcode} tidak ditemukan!`, 'warning');
                }else if(response.length > 1){
                    $("#modalPilihItem").modal("show");
                    arrItemDiatasSatu = response;
                    var html;
                    for(var i = 0;i<response.length;i++){
                        html += `
                            <tr>
                                <td>${response[i].NamaItem}</td>
                                <td class="text-center">${tandaPemisahTitik(response[i].Harga)}</td>
                                <td class="text-center">${response[i].SingkatanSatuan}</td>
                                <td class="text-center">${response[i].NamaKategori}</td>
                                <td class="text-center"><button type="button" onclick="pilihItemBarcode(${i});" class="btn btn-primary btn-sm"><b>Pilih</b></button></td>
                            </tr>`;
                    }
                    $("#modalBodyItem").html(html);
                }else{
                    var statusItemID = 0;
                    for(var i=0;i < arrItemID.length;i++){
                        if(response[0].ItemID == arrItemID[i]){
                            statusItemID = 1;
                            var quantity = parseInt($("#quantity_"+response[0].ItemID).val())+1;
                            $("#quantity_"+response[0].ItemID).val(quantity);
                            hitungTotal(response[0].ItemID);
                            break;
                        }else{
                            statusItemID = 0;
                        }
                    }

                    if(statusItemID == 0){
                        arrItemID.push(response[0].ItemID);
                        var html;
                        html += `
                            <tr class="rowItem" id="itemID_${response[0].ItemID}">
                                <input type="hidden" class="form-control" id="item_${response[0].ItemID}" name="txtItem[]" value="${response[0].ItemID}"/>
                                <input type="hidden" name="txtHargaid[]" value="${response[0].DetailHargaID}" id="hargaid_${response[0].ItemID}" class="form-control">
                                <input type="hidden" name="txtSatuanid[]" value="${response[0].SatuanID}" id="satuanid_${response[0].ItemID}" class="form-control">
                                    <input type="hidden" name="txtKategoriid[]" value="${response[0].KategoriID}" id="kategoriid_${response[0].ItemID}" class="form-control">
                                <td class="text-center">
                                    <a id="hapus_${response[0].ItemID}" class="btn btn-minier btn-danger" onclick="hapus_baris(this, ${response[0].ItemID})"><i class="fa fa-trash"></i>
                                    </a>
                                </td>
                                <td class="col-lg-4 col-sm-4 col-xs-4">${response[0].NamaItem}</td>
                                <td class="text-center col-lg-2 col-sm-2 col-xs-2">
                                    <input type="text" name="txtHarga[]" value="${response[0].Harga}" id="harga_${response[0].ItemID}" class="form-control classHarga" onkeypress="return getNumber(event);" onkeyup="hitungTotal(${response[0].ItemID});inputanFormat(this.value, this.id);"/>
                                </td>
                                <td class="text-center col-lg-1 col-sm-1 col-xs-1">
                                    <input type="text" name="txtQuantity[]" value="1" id="quantity_${response[0].ItemID}" class="form-control classQuantity" onkeypress="return getNumber(event);" onkeyup="hitungTotal(${response[0].ItemID});">
                                </td>
                                <td class="text-center col-lg-1 col-sm-1 col-xs-1">
                                    <input type="text" name="txtSatuan[]" value="${response[0].SingkatanSatuan}" id="satuan_${response[0].ItemID}" class="form-control" readonly="">
                                </td>
                                <td class="text-center col-lg-2 col-sm-2 col-xs-2">
                                    <input type="text" name="txtKategori[]" value="${response[0].NamaKategori}" id="kategori_${response[0].ItemID}" class="form-control" readonly="">
                                </td>
                                <td class="text-center col-lg-2 col-sm-2 col-xs-2">
                                    <input type="text" name="txtTotal[]" id="total_${response[0].ItemID}" class="form-control rowGrandTotal" readonly=""/>
                                </td>
                            </tr>`;
                        if($("#tbodyItem tr").length > 0){
                            $("#tbodyItem tr:first").before(html);
                        }else{
                            $("#tbodyItem").append(html);
                        }
                        hitungTotal(response[0].ItemID);
                    }                    
                } 
            }
        });
    }

    function hitungTotal(ItemID){
        var harga = $("#harga_"+ItemID).val();
        var quantity = $("#quantity_"+ItemID).val();
        var total = hilangkanTandaTitik(harga) * hilangkanTandaTitik(quantity);
        $("#total_"+ItemID).val(tandaPemisahTitik(total));
        hitungGrandTotal();
    }

    function hitungGrandTotal(){
        var grandTotal = 0;
        for(var i = 1; i <= arrItemID.length-1;i++){
            grandTotal += parseInt(hilangkanTandaTitik($("#total_"+arrItemID[i]).val()));
        }
        $("#grandTotal").val(tandaPemisahTitik(grandTotal));
    }

    function hapus_baris(ip, ItemID){
      var tr = ip.parentNode.parentNode;
      tr.parentNode.removeChild(tr);
      var index = arrItemID.indexOf(ItemID);
      arrItemID.splice(index, 1);
      hitungGrandTotal();
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

    function hilangkanTandaTitik(value){
       var reverse = value.toString().split('.');
       var result = reverse.join('').split('').join('');
       return result;
    }

    function inputanFormat(value, id){
       var reverse = value.toString().split('.');
       var result = reverse.join('').split('').join('');
        var _minus = false;
        if (result < 0) _minus = true;
        result = result.toString();
        result = result.replace(".","");
        c = "";
        panjang = result.length;
        j = 0;
        for (i = panjang; i > 0; i--){
             j = j + 1;
             if (((j % 3) == 1) && (j != 1)){
               c = result.substr(i-1,1) + "." + c;
             } else {
               c = result.substr(i-1,1) + c;
             }
        }
        if (_minus) c = "-" + c ;
        $("#"+id).val(c);
    }

    function getNumber(evt) 
    {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 47 && charCode < 58)
            return true;
        return false;
    }

    //END :: YAWALIYUL
</script>
<script src="<?php echo base_url();?>assets/sweetalert2-11.3.6/dist/sweetalert2.min.js"></script>