<div class="row">
  <div class="col-lg-12">
    <div class="widget-body">
      <div class="widget-main">
        <div class="row">
          <div class="col-lg-12">
            <?php foreach($_getDataHdr as $hdr){?>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-lg-4 control-label">Nama Lengkap :</label>
                <div class="col-sm-4">
                  <label class="control-label"><?php echo $hdr->Nama;?></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 control-label">Usia :</label>
                <div class="col-sm-4">
                  <label class="control-label"><?php echo $hdr->Usia;?></label>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <label class="col-lg-4 control-label">Jenis Kelamin :</label>
                <div class="col-sm-4">
                  <label class="control-label"><?php echo $hdr->Jenis_Kelamin;?></label>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 control-label">Tanggal Tes :</label>
                <div class="col-sm-4">
                  <label class="control-label"><?php echo $hdr->TanggalTes;?></label>
                </div>
              </div>
            </div>
            <?php }?>
          </div>
        </div>
        <hr>
        <div class="table-responsive" id="listid">
           <table class="table table-bordered" id="dataTables">
            <thead>
              <tr>
                <th class="text-center" style="width:15px;">No.</th>
                <th class="text-center" style="background-color: #F0E68C;">P</th>
                <th class="text-center" style="background-color:  #3CB371;">K</th>
                <th class="text-center">P</th>
                <th class="text-center">K</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $no = 1;
              foreach($_getDataDtl as $dtl){
              ?>
                <tr>
                    <td class="text-center"><?php echo $no++;?></td>
                    <td style="background-color: #F0E68C;text-align: center;"><?php echo $dtl->Jawaban_P;?></td>
                    <td style="background-color:  #3CB371;text-align: center;"><?php echo $dtl->Jawaban_X;?></td>
                    <td class="text-center">
                      <?php if($dtl->Jawaban_P == 1){
                        echo "S";
                      }elseif($dtl->Jawaban_P == 2){
                        echo "I";
                      }elseif($dtl->Jawaban_P == 3){
                        echo "*";
                      }elseif($dtl->Jawaban_P == 4){
                        echo "C";
                      }else{
                        echo "";
                      }?>
                    </td>
                    <td class="text-center">
                      <?php if($dtl->Jawaban_X == 1){
                        echo "S";
                      }elseif($dtl->Jawaban_X == 2){
                        echo "I";
                      }elseif($dtl->Jawaban_X == 3){
                        echo "*";
                      }elseif($dtl->Jawaban_X == 4){
                        echo "C";
                      }else{
                        echo "";
                      }?>
                    </td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <label class="col-lg-2 control-label">HASIL :</label>
              <div class="col-sm-3">
                <label class="control-label">D : 
                  <?php foreach($Bag1 as $key){
                    if($key->Jawaban_P == 1){
                      if($key->jml_p == NULL){
                        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
                      }else{
                        echo $key->jml_p.'&nbsp;&nbsp;&nbsp;&nbsp;';
                      }
                      if($key->jml_x == NULL){
                        echo "0";
                      }else{
                        echo $key->jml_x;
                      }
                    }
                  }?>
                    
                </label><br>
                <label class="control-label">I &nbsp;:
                  <?php foreach($Bag1 as $key){
                    if($key->Jawaban_P == 2){
                      if($key->jml_p == NULL){
                        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
                      }else{
                        echo $key->jml_p.'&nbsp;&nbsp;&nbsp;&nbsp;';
                      }
                      if($key->jml_x == NULL){
                        echo "0";
                      }else{
                        echo $key->jml_x;
                      }
                    }
                  }?>
                </label><br>
                <label class="control-label">S : 
                  <?php foreach($Bag1 as $key){
                    if($key->Jawaban_P == 3){
                      if($key->jml_p == NULL){
                        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
                      }else{
                        echo $key->jml_p.'&nbsp;&nbsp;&nbsp;&nbsp;';
                      }
                      if($key->jml_x == NULL){
                        echo "0";
                      }else{
                        echo $key->jml_x;
                      }
                    }
                  }?>
                </label><br>
                <label class="control-label">C :
                  <?php foreach($Bag1 as $key){
                    if($key->Jawaban_P == 4){
                      if($key->jml_p == NULL){
                        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
                      }else{
                        echo $key->jml_p.'&nbsp;&nbsp;&nbsp;&nbsp;';
                      }
                      if($key->jml_x == NULL){
                        echo "0";
                      }else{
                        echo $key->jml_x;
                      }
                    }
                  }?>
                </label>
              </div>
              <div class="col-sm-3">
                <label class="control-label">D :
                  <?php foreach($Bag2 as $key){
                    if($key->Jawaban_P == 1){
                      if($key->jml_p == NULL){
                        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
                      }else{
                        echo $key->jml_p.'&nbsp;&nbsp;&nbsp;&nbsp;';
                      }
                      if($key->jml_x == NULL){
                        echo "0";
                      }else{
                        echo $key->jml_x;
                      }
                    }
                  }?>
                </label><br>
                <label class="control-label">I &nbsp;:
                  <?php foreach($Bag2 as $key){
                    if($key->Jawaban_P == 2){
                      if($key->jml_p == NULL){
                        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
                      }else{
                        echo $key->jml_p.'&nbsp;&nbsp;&nbsp;&nbsp;';
                      }
                      if($key->jml_x == NULL){
                        echo "0";
                      }else{
                        echo $key->jml_x;
                      }
                    }
                  }?>
                </label><br>
                <label class="control-label">S :
                  <?php foreach($Bag2 as $key){
                    if($key->Jawaban_P == 3){
                      if($key->jml_p == NULL){
                        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
                      }else{
                        echo $key->jml_p.'&nbsp;&nbsp;&nbsp;&nbsp;';
                      }
                      if($key->jml_x == NULL){
                        echo "0";
                      }else{
                        echo $key->jml_x;
                      }
                    }
                  }?>
                </label><br>
                <label class="control-label">C :
                  <?php foreach($Bag2 as $key){
                    if($key->Jawaban_P == 4){
                      if($key->jml_p == NULL){
                        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
                      }else{
                        echo $key->jml_p.'&nbsp;&nbsp;&nbsp;&nbsp;';
                      }
                      if($key->jml_x == NULL){
                        echo "0";
                      }else{
                        echo $key->jml_x;
                      }
                    }
                  }?>
                </label>
              </div>
              <div class="col-sm-3">
                <label class="control-label">D :
                  <?php foreach($Bag3 as $key){
                    if($key->Jawaban_P == 1){
                      if($key->jml_p == NULL){
                        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
                      }else{
                        echo $key->jml_p.'&nbsp;&nbsp;&nbsp;&nbsp;';
                      }
                      if($key->jml_x == NULL){
                        echo "0";
                      }else{
                        echo $key->jml_x;
                      }
                    }
                  }?>
                </label><br>
                <label class="control-label">I &nbsp;:
                  <?php foreach($Bag3 as $key){
                    if($key->Jawaban_P == 2){
                      if($key->jml_p == NULL){
                        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
                      }else{
                        echo $key->jml_p.'&nbsp;&nbsp;&nbsp;&nbsp;';
                      }
                      if($key->jml_x == NULL){
                        echo "0";
                      }else{
                        echo $key->jml_x;
                      }
                    }
                  }?>
                </label><br>
                <label class="control-label">S :
                  <?php foreach($Bag3 as $key){
                    if($key->Jawaban_P == 3){
                      if($key->jml_p == NULL){
                        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
                      }else{
                        echo $key->jml_p.'&nbsp;&nbsp;&nbsp;&nbsp;';
                      }
                      if($key->jml_x == NULL){
                        echo "0";
                      }else{
                        echo $key->jml_x;
                      }
                    }
                  }?>
                </label><br>
                <label class="control-label">C :
                  <?php foreach($Bag3 as $key){
                    if($key->Jawaban_P == 4){
                      if($key->jml_p == NULL){
                        echo "0 &nbsp;&nbsp;&nbsp;&nbsp;";
                      }else{
                        echo $key->jml_p.'&nbsp;&nbsp;&nbsp;&nbsp;';
                      }
                      if($key->jml_x == NULL){
                        echo "0";
                      }else{
                        echo $key->jml_x;
                      }
                    }
                  }?>
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>