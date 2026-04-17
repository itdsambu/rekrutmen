<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Minotoring Bon-TK Per PT/CV
    </span>
</h4>

<div class="row">
    
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 marginbottom10" id="inputcontent">
	       <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 form-inline" style="margin-bottom: 5px;">
			    <select class="selectpicker form-control btn-sm" id="selectperiod" data-style="btn-primary btn-sm">
					   <option value="<?php echo $periode->curperiode;?>"><?php echo $periode->curperiode;?></option>
					   <?php foreach ($allperiode as $item){?>
					        <?php echo '<option value="' . $item['showperiode'] . '">' . $item['showperiode'] . '</option>'; ?>
					   <?php };?>
				</select>
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
				  
				  </div> 
				  <div class="col-lg-2 col-md-3 col-sm-4">
				      <button class="btn btn-success btn-sm btn-block" id="btnrefresh">Refresh</button>
				  </div>
				</div>	
			 </div>
	</div>
	
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="viewcontent">
	     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <table id="tblcounttk" class="table table-striped table-hover table-nowrap table-colored">
        <thead>
           <tr>
              <th>Perusahaan</th>
              <th>Total</th>
              <th>Total Update</th>
              <th>Total Sisa (belum update)</th>
           </tr>
        </thead>
        <tbody>
        </tbody>
        </table>
        <div id="takeform"></div>
	 </div>
	</div>

</div>