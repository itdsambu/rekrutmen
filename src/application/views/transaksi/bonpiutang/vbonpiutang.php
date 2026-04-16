<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Update Bon TK<span id="txtstate"> <?php if( $islock==1 ) : ?>
		     - ( Status: Lock ) 
		<?php endif;?></span>
    </span>
</h4>

<div class="row">
    
	<!--header content-->
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="inputcontent">
	       <div class="row">
		    <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 form-inline" style="margin-bottom: 5px;">
			    <div class="form-group">
				   <label>Periode</label>				   
				   <input type="text" class="form-control input-sm" id="txtperiode" disabled value="<?php echo $periode->curperiode;?>">				   
				</div>
			 </div> 
			 <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12 form-inline" style="margin-bottom: 5px;">
				<div class="row">
				  <div class="col-lg-7 col-md-7 col-sm-8">
				   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">				   
						<select class="selectpicker form-control btn-sm" id="selectperusahaan" data-style="btn-primary btn-sm">						
						<option value="0">Select Perusahaan</option>						
					<?php if( isset($data) ) : ?>
				       <?php foreach ($data as $item) { ?>
					         <option value="<?php echo $item['cperusahaan']; ?>"><?php echo $item['perusahaan'] ?></option>							 
					   <?php } ?>					   
				   <?php endif;?>							
						</select>					
				   </div>
				   <div class="col-lg-6 col-md-12 col-sm-6 col-xs-6">
					   <div class="form-group">
					   <div class="btn-group"  data-toggle="buttons">
					   <label class="btn btn-sm btn-success active" id="bonshow">
					       <input type="checkbox" class="input-sm" autocomplete="off" checked>
						   <span class="glyphicon glyphicon-ok"></span>
					   </label>
					   </div>
					   <label>Termasuk Bon >0</label>
					   </div>
				   </div>
				   <div class="col-lg-6 col-md-12 col-sm-6 col-xs-6">
					   <div class="form-group">
					   <div class="btn-group"  data-toggle="buttons">
					   <label class="btn btn-sm btn-success" id="ms3month">
					       <input type="checkbox" class="input-sm" autocomplete="off" checked>
						   <span class="glyphicon glyphicon-ok"></span>
					   </label>
					   </div>
					   <label>M.Kerja 0-3 Bln</label>
					   </div>
				   </div>
				  </div> 
				  <div class="col-lg-2 col-md-3 col-sm-4">
				      <button class="btn btn-success btn-sm btn-block" id="btnrefresh">Refresh</button>
				  </div>
				</div>	
			 </div>
		   </div> 	
           <input type="hidden" id="txtperiodehidden" value="<?php echo $periode->currperiode; ?>">		   
    </div> 
	
	
	<!--viewer -->
	<section id="viewer">
	 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <table id="tblnotbontk" class="table table-striped table-hover table-nowrap table-colored">
        <thead>
           <tr>
              <th>DEPT</th>
              <th>BAGIAN</th>
              <th>NIK</th>
              <th>NAMA</th>
			  <th>Tgl Lahir</th>
			  <th>Nama Ibu</th>
			  <th>BON</th>
           </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
        <div id="takeform"></div>
	 </div>
	</section>
	
</div>
<script>
  var islock = <?php echo $islock;?>;
</script>