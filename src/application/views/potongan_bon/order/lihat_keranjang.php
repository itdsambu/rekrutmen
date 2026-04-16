<link rel="stylesheet" href="<?php echo base_url()?>assets/class/select2.css"/>
<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><i class="glyphicon glyphicon-shopping-cart"></i> KERANJANG BELANJA</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
            </div>
            <br>
            <div class="col-lg-12">
            <?php if($this->input->get('msg') == "success"){
                  echo "<div class='alert alert-success'>";
                  echo "<strong>Sukses !!!</strong> Data berhasil di Simpan.";
                  echo "</div>";
              }elseif($this->input->get('msg') == "failed"){
                  echo "<div class='alert alert-danger'>";
                  echo "<strong>Gagal !!!</strong> Data Sudah Pernah Diregistrasi..!!";
                  echo "</div>";
              }?>
                
            </div>
            <div class="form-horizontal">
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive" id="tbllist">
                               <table class="table table-bordered" id="dataTables">
                                <thead>
                                  <tr>
                                    <th class="text-center">No.</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Item/Produk</th>
                                    <th class="text-center">Satuan</th>
                                    <th class="text-center">Kategori</th>
                                    <th class="text-center">Kuantitas</th>
                                    <!-- <th class="text-center">Total Harga</th> -->
                                    <th class="text-center">Aksi</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $qty = 1;
                                    $min = 1;
                                    $pls = 1;
                                    $id = 1;
                                    foreach($_getOrderHdr as $hdr){?>
                                    <tr>
                                        <td style="vertical-align:middle;text-align: center;"><?php echo $no++;?></td>
                                        <td style="vertical-align:middle;text-align: center;"><?php echo date('d-M-Y',strtotime($hdr->Tanggal));?></td>
                                        <td>
                                        <?php foreach($_getOrder as $dtl){
                                            if($hdr->HeaderID == $dtl->HeaderID){
                                                echo "<table class='table table-hover table-bordered'>
                                                    <tr>
                                                        <td>".$dtl->NamaItem."</td>
                                                    </tr>
                                                </table>";
                                            }
                                        }?>
                                        </td>
                                        <td>
                                        <?php foreach($_getOrder as $dtl){
                                            if($hdr->HeaderID == $dtl->HeaderID){
                                                echo "<table class='table table-hover table-bordered'>
                                                    <tr>
                                                        <td>".$dtl->SingkatanSatuan."</td>
                                                    </tr>
                                                </table>";
                                            }
                                        }?>
                                        </td>
                                        <td>
                                        <?php foreach($_getOrder as $dtl){
                                            if($hdr->HeaderID == $dtl->HeaderID){
                                                echo "<table class='table table-hover table-bordered'>
                                                    <tr>
                                                        <td>".$dtl->NamaKategori."</td>
                                                    </tr>
                                                </table>";
                                            }
                                        }?>
                                        </td>
                                        <td>
                                        <?php foreach($_getOrder as $dtl){
                                            if($hdr->HeaderID == $dtl->HeaderID){?>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td class="text-center">
                                                            <a href="#" class="btn btn-minier btn-round btn-primary" id="minus<?php echo $min++?>" onclick="minus(this.id);"><i class="fa fa-minus"></i> 
                                                                
                                                            </a>
                                                            <input type="hidden" name="txtDetailID" id="dtlid<?php echo $id++?>" value="<?php echo $dtl->DetailID?>">
                                                            <input type="text" style="width:24px;height: 24px;" name="txtKuantitas txt" id="kuantitas<?php echo $qty++?>" value="<?php echo $dtl->Quantity?>">
                                                            <a href="#" class="btn btn-minier btn-round btn-primary" id="plus<?php echo $pls++?>" onclick="plus(this.id);"><i class="fa fa-plus"></i></a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            <?php }
                                        }?>
                                        </td>
                                        <!-- <td>
                                        <?php foreach($_getOrder as $dtl){
                                            if($hdr->HeaderID == $dtl->HeaderID){
                                                echo "<table class='table table-hover table-bordered'>
                                                    <tr>
                                                        <td class='text-right'>Rp.
                                                            ".number_format($dtl->Quantity * $dtl->Harga,0,",",".")."
                                                        </td>
                                                    </tr>
                                                </table>";
                                            }
                                        }?>
                                        </td> -->
                                        <td>
                                        <?php foreach($_getOrder as $dtl){
                                            if($hdr->HeaderID == $dtl->HeaderID){
                                                echo "<table class='table table-hover table-bordered'>
                                                    <tr>
                                                        <td class='text-center'>
                                                           <a href='".base_url('Order/hapus_item/'.$dtl->DetailID.'/'.$dtl->Nofix)."' class='btn btn-minier btn-round btn-danger'><i class='fa fa-trash'></i>
                                                           </a>
                                                        </td>
                                                    </tr>
                                                </table>";
                                            }
                                        }?>
                                        </td>
                                    </tr>
                                    <?php }?>
                                </tbody>
                              </table>
                              <hr>
                             <!--  <div>
                                  <a href="" class="btn btn-sm btn-warning btn-round">Sudah Belanja</a>
                              </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function minus(id){
        var min_id = id.substr(5);
        var jmlBaris    = document.getElementsByClassName('txt').length;
        var qty         = $("#kuantitas"+min_id).val();
        var dtlid       = $("#dtlid"+min_id).val();
        // alert(dtlid);

        jumlah = qty - 1;
        document.getElementById('kuantitas'+min_id).value = jumlah;

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url('Order/hapus_quantity')?>"+"/"+dtlid+"/"+qty,
            success: function(msg){
                // load_halaman_order();
            }
          }); 
    }

    function plus(id){
        var min_id = id.substr(4);
        var jmlBaris    = document.getElementsByClassName('txt').length;
        var qty         = $("#kuantitas"+min_id).val();
        var dtlid       = $("#dtlid"+min_id).val();
        // alert(qty);

        // plus = 1;
        // jumlah = qty + plus;
        document.getElementById('kuantitas'+min_id).value = (parseInt(qty) + parseInt(1));

        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo base_url('Order/tambah_quantity')?>"+"/"+dtlid+"/"+qty,
            success: function(msg){
                // load_halaman_order();
            }
          }); 
    }
</script>