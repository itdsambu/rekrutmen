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
              foreach($_getDataDtl as $dtl){?>
                <tr>
                    <td class="text-center"><?php echo $no++;?></td>
                    <td style="background-color: #F0E68C;text-align: center;"><?php echo $dtl->Jawaban_P;?></td>
                    <td style="background-color:  #3CB371;text-align: center;"><?php echo $dtl->Jawaban_X;?></td>
                    <td class="text-center">
                     <?php echo $dtl->P;?>
                    </td>
                    <td class="text-center">
                      <?php echo $dtl->X;?>
                    </td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">
          <div class="col-lg-12">
            <div class="form-group">
              <label class="col-lg-2 control-label">HASIL :</label>
              <div class="col-lg-3">
                <table>
                  <tr>
                    <tr>
                      <td>D</td>
                      <td>&nbsp;:
                        <?php foreach($Bag1 as $bg1){
                          if($bg1->DISC == 'D'){
                            if($bg1->jml_p != NULL){
                              echo $bg1->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag1 as $bg1){
                          if($bg1->DISC == 'D'){
                            if($bg1->jml_x != NULL){
                              echo $bg1->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                    <tr>
                      <td>I</td>
                      <td>&nbsp;:
                        <?php foreach($Bag1 as $bg1){
                          if($bg1->DISC == 'I'){
                            if($bg1->jml_p != NULL){
                              echo $bg1->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag1 as $bg1){
                          if($bg1->DISC == 'I'){
                            if($bg1->jml_x != NULL){
                              echo $bg1->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                    <tr>
                      <td>S</td>
                      <td>&nbsp;:
                        <?php foreach($Bag1 as $bg1){
                          if($bg1->DISC == 'S'){
                            if($bg1->jml_p != NULL){
                              echo $bg1->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag1 as $bg1){
                          if($bg1->DISC == 'S'){
                            if($bg1->jml_x != NULL){
                              echo $bg1->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                    <tr>
                      <td>C</td>
                      <td>&nbsp;:
                        <?php foreach($Bag1 as $bg1){
                          if($bg1->DISC == 'C'){
                            if($bg1->jml_p != NULL){
                              echo $bg1->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag1 as $bg1){
                          if($bg1->DISC == 'C'){
                            if($bg1->jml_x != NULL){
                              echo $bg1->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                    <tr>
                      <td>*</td>
                      <td>&nbsp;:
                        <?php foreach($Bag1 as $bg1){
                          if($bg1->DISC == '*'){
                            if($bg1->jml_p != NULL){
                              echo $bg1->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag1 as $bg1){
                          if($bg1->DISC == '*'){
                            if($bg1->jml_x != NULL){
                              echo $bg1->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                  </tr>
                </table>
              </div>
              <div class="col-lg-3">
                <table>
                  <tr>
                    <tr>
                      <td>D</td>
                      <td>&nbsp;:
                        <?php foreach($Bag2 as $bg2){
                          if($bg2->DISC == 'D'){
                            if($bg2->jml_p != NULL){
                              echo $bg2->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag2 as $bg2){
                          if($bg2->DISC == 'D'){
                            if($bg2->jml_x != NULL){
                              echo $bg2->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                    <tr>
                      <td>I</td>
                      <td>&nbsp;:
                        <?php foreach($Bag2 as $bg2){
                          if($bg2->DISC == 'I'){
                            if($bg2->jml_p != NULL){
                              echo $bg2->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag2 as $bg2){
                          if($bg2->DISC == 'I'){
                            if($bg2->jml_x != NULL){
                              echo $bg2->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                    <tr>
                      <td>S</td>
                      <td>&nbsp;:
                        <?php foreach($Bag2 as $bg2){
                          if($bg2->DISC == 'S'){
                            if($bg2->jml_p != NULL){
                              echo $bg2->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag2 as $bg2){
                          if($bg2->DISC == 'S'){
                            if($bg2->jml_x != NULL){
                              echo $bg2->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                    <tr>
                      <td>C</td>
                      <td>&nbsp;:
                        <?php foreach($Bag2 as $bg2){
                          if($bg2->DISC == 'C'){
                            if($bg2->jml_p != NULL){
                              echo $bg2->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag2 as $bg2){
                          if($bg2->DISC == 'C'){
                            if($bg2->jml_x != NULL){
                              echo $bg2->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                    <tr>
                      <td>*</td>
                      <td>&nbsp;:
                        <?php foreach($Bag2 as $bg2){
                          if($bg2->DISC == '*'){
                            if($bg2->jml_p != NULL){
                              echo $bg2->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag2 as $bg2){
                          if($bg2->DISC == '*'){
                            if($bg2->jml_x != NULL){
                              echo $bg2->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                  </tr>
                </table>
              </div>
              <div class="col-lg-3">
                <table>
                  <tr>
                    <tr>
                      <td>D</td>
                      <td>&nbsp;:
                        <?php foreach($Bag3 as $bg3){
                          if($bg3->DISC == 'D'){
                            if($bg3->jml_p != NULL){
                              echo $bg3->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag3 as $bg3){
                          if($bg3->DISC == 'D'){
                            if($bg3->jml_x != NULL){
                              echo $bg3->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                    <tr>
                      <td>I</td>
                      <td>&nbsp;:
                        <?php foreach($Bag3 as $bg3){
                          if($bg3->DISC == 'I'){
                            if($bg3->jml_p != NULL){
                              echo $bg3->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag3 as $bg3){
                          if($bg3->DISC == 'I'){
                            if($bg3->jml_x != NULL){
                              echo $bg3->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                    <tr>
                      <td>S</td>
                      <td>&nbsp;:
                        <?php foreach($Bag3 as $bg3){
                          if($bg3->DISC == 'S'){
                            if($bg3->jml_p != NULL){
                              echo $bg3->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag3 as $bg3){
                          if($bg3->DISC == 'S'){
                            if($bg3->jml_x != NULL){
                              echo $bg3->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                    <tr>
                      <td>C</td>
                      <td>&nbsp;:
                        <?php foreach($Bag3 as $bg3){
                          if($bg3->DISC == 'C'){
                            if($bg3->jml_p != NULL){
                              echo $bg3->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;
                      </td>
                      <td>
                        <?php foreach($Bag3 as $bg3){
                          if($bg3->DISC == 'C'){
                            if($bg3->jml_x != NULL){
                              echo $bg3->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                    <tr>
                      <td>*</td>
                      <td>&nbsp;:
                        <?php foreach($Bag3 as $bg3){
                          if($bg3->DISC == '*'){
                            if($bg3->jml_p != NULL){
                              echo $bg3->jml_p;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                        &nbsp;&nbsp;</td>
                      <td>
                        <?php foreach($Bag3 as $bg3){
                          if($bg3->DISC == '*'){
                            if($bg3->jml_x != NULL){
                              echo $bg3->jml_x;
                            }else{
                              echo '0';
                            }
                          }
                        }?>
                      </td>
                    </tr>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
    </div>
  </div>
</div>