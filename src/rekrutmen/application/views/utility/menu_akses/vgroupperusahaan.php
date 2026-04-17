<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Mansgement Group Perusahaan
    </span>
</h4>
<div class="row" id="upgroupperusahaan">
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
       <label>Group User</label>
       <div class="row">
		  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
		     <input type="text" class="form-control" id="txtidgroup" disabled>
		  </div>
		  <div class="col-lg-10 col-md-10 col-sm-8 col-xs-12">
		     <input type="text" class="form-control" id="txtgroupname" disabled>
		  </div>
	   </div>
   </div>
   <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <label>Perusahaan</label>
	      <div class-"row">
	         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		        <select class="selectpicker form-control btn-sm" id="selectperusahaan" data-style="btn-primary">
				   <option value="0">Select Perusahaan</option>
				   <?php if( isset($data) ) : ?>
				       <?php foreach ($data as $item) { ?>
					         <option value="<?php echo $item['idperusahaan']; ?>"><?php echo $item['perusahaan'] ?></option>							 
					   <?php } ?>					   
				   <?php endif;?>
				</select>
			 </div>
		   </div>	 
   </div>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h4 class="smaller"></h4>
	    <button class="btn btn-sm btn-block btn-info" id="btnsimpan">Update Group Perusahaan</button>
   </div>
 </div>
 <div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <h4 class="header smaller lighter green"></h4>
	<section id="viewgroup">
	    <table id="tabelgroupperusahaan" class="table table-striped table-hover table-nowrap table-colored">
		    <thead>
            <tr>
              <th>Group</th>
              <th>Nama</th>
              <th>IdPerusahaan</th>
              <th>Perusahaan</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
		</table>
	</section>
   </div>
</div>