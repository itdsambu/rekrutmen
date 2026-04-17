<!--<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Entry data Ideal Permintaan Karyawan dan TK
    </span>
</h4>
<style>
    .bordering {
		border: solid 2px #1ca8c5;
        padding: 20px;
	}
</style>
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="controlsetup">
       <div class="panel panel-default">
	       <div class="panel-heading">
		     <h3 class="panel-title">Input Memo Permintaan </h3>
		   </div>
	   </div>
        <div class="panel-body">
            <section id="viewtabel">
            <form  action="<?= base_url('configpermintaan/inputmemo')?>" name="frmideal" id="frmideal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                <div class="col-sm-12 form-horizontal">  
                   <div class="form-group">     
                        <label class="col-sm-3 control-label">Dept</label>             
                        <div class="col-sm-3">
                            <select class="selectpicker form-control btn-sm" id="selectdept" name="selectdept" data-style="btn-primary btn-sm">
                            <?php
                               foreach($dept as $d){
                                   ?>
                                     <option value="<?=$d->DeptAbbr?>"><?=$d->NamaDept?></option> 
                                   <?php
                               }
                            ?>
                            </select>
                        </div>                        
                    </div>
                    <div class="form-group">
                       <label class="col-sm-3 control-label">Type</label>
                       <div class="col-sm-3">
                         <select class="selectpicker form-control btn-sm" id="selecttipe" name="selecttipe" data-style="btn-info btn-sm">
                               <option value="tk">Tenaga Kerja</option>
                               <option value="kry">Karyawan</option>
                         </select>
                       </div>  
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">No.Ref (auto)</label>
                        <div class="col-sm-3">
                             <input type="text" class="form-control input-sm" id="txtnoref" name="txtnoref" readonly>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-3  control-label">Input Memo (pdf file)</div>                                            
                        <div class="col-sm-6">
                            <input id="txtupload" name="txtupload" class="input-sm form-control" type="file" accept="application/pdf" id="txtmemotk" accept="pdf"/>                                                 
                        </div>                                             
                    </div>  
                    <div class="form-group"> 
                            <div class="col-sm-3"></div>
                            <div class="col-sm-9">
                                <button type="submit" id="btnuploadmemotk" class="btn btn-primary btn-sm">Simpan</button>
                            </div>
                    </div>               
                </div>
            </form>    
            </section>
        </div>
    </div>
</div> -->

<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Entry data Ideal Permintaan Karyawan dan TK
    </span>
</h4>
<style>
    .bordering {
		border: solid 2px #1ca8c5;
        padding: 20px;
	}
</style>
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="controlsetup">
       <div class="panel panel-default">
	       <div class="panel-heading">
		     <h3 class="panel-title">Input Memo Permintaan </h3>
		   </div>
	   </div>
        <div class="panel-body">
            <section id="viewtabel">
            <form  action="<?= base_url('configpermintaan/inputmemo')?>" name="frmideal" id="frmideal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                <div class="col-sm-12 form-horizontal">
                  <div class="form-group">
                      <label class="col-sm-3 control-label">No.Ref (auto)</label>
                      <div class="col-sm-3">
                           <input type="text" class="form-control input-sm" id="txtnoref" name="txtnoref" readonly>
                      </div>
                  </div>
                   <div class="form-group">     
                        <label class="col-sm-3 control-label">Dept</label>             
                        <div class="col-sm-3">
                            <select class="selectpicker form-control btn-sm selectdept" id="selectdept" name="selectdept" data-style="btn-primary btn-sm">
                              <option value="">-- pilih departement --</option> 
                            <?php
                               foreach($dept as $d){
                                   ?>
                                     <option value="<?=$d->DeptAbbr?>"><?=$d->NamaDept?></option> 
                                   <?php
                               }
                            ?>
                            </select>
                        </div>                        
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Jumlah Ideal Karyawan Sekarang</label>
                      <div class="col-sm-3">
                        <input type="text" name="txtidealkryskr" id="inputidealkryskr" class="input-sm form-control txtidealkryskr" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Jumlah Ideal Tenaga Kerja Sekarang</label>
                      <div class="col-sm-3">
                        <input type="text" name="txtidealtkskr" id="inputidealtkskr" class="input-sm form-control txtidealtkskr" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Jumlah Ideal Tambahan</label>
                      <div class="col-sm-3">
                        <input type="text" name="txtidealtambahan" id="inputidealtambahan" class="input-sm form-control txtidealtambahan">
                      </div>
                    </div>
                    <div class="form-group">
                       <label class="col-sm-3 control-label">Type</label>
                       <div class="col-sm-4">
                         <div class="radio">
                          <label>
                             <input type="radio" class="ace" name="selecttipe" id="inputtypekry" value="kry" onclick="ideal(this.value);">
                             <span class="lbl"> Karyawan</span>
                           </label>
                         </div>
                         <div class="radio">
                          <label>
                             <input type="radio" class="ace" name="selecttipe" id="inputtypebor" value="tk" onclick="ideal(this.value);">
                             <span class="lbl"> Tenaga Kerja</span>
                           </label>
                         </div>
                       </div>  
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Total</label>
                      <div class="col-sm-3">
                        <input type="text" name="txttotalideal" onclick="ideal(this.value);" id="inputtotalideal" class="input-sm form-control txttotalideal" readonly>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-3 control-label">Alasan Penambahan</label>
                      <div class="col-sm-3">
                        <textarea class="form-control" name="txtketerangan" id="inputketerangan"></textarea>
                      </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-3"></div>
                        <div class="col-sm-9">
                            <button type="submit" id="btnuploadmemotk" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </div>               
                </div>
            </form>    
            </section>
        </div>
    </div>
</div>
<script type="text/javascript">
  $(function(){
    $(document).on('change','.selectdept',function(){
      var selDept = $(this).val();
      $.ajax({
        type : 'POST',
        url : "<?php echo base_url();?>Configpermintaan/getDataIdeal",
        data : {selDept: selDept},
        success: function(data){
          var datan = data.split(", ");
          var kry = datan[0];
          var bor = datan[1];
          $('#inputidealkryskr').val(kry);
          $('#inputidealtkskr').val(bor);
        }
      });
    });
  });
</script>
<script type="text/javascript">
  function ideal(objek){
    if (objek === 'tk') {
      var idealbor    = parseInt(document.getElementById('inputidealtkskr').value);
      var addidealbor = parseInt(document.getElementById('inputidealtambahan').value);
      var totaltk     = idealbor + addidealbor;

      document.getElementById('inputtotalideal').value = totaltk;
    }else{
      var idealkry    = parseInt(document.getElementById('inputidealkryskr').value);
      var addidealkry = parseInt(document.getElementById('inputidealtambahan').value);
      var totalkry    =  idealkry + addidealkry;

      document.getElementById('inputtotalideal').value = totalkry;
    }
  }
</script>