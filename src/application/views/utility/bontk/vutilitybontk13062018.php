<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Utility Bon-TK
    </span>
</h4>

<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="controlperiode">
       <div class="panel panel-default">
	       <div class="panel-heading">
		     <h3 class="panel-title">Setting Bon TK per Periode</h3>
		   </div>
	   </div>
	   <div class="panel-body">
	       <div class="col-lg-4 col-md-5 col-sm-6 col-xs-7"><Label>Buka Bon-TK sebelum hari H akhir periode </label></div> 
		   <div class="col-lg-8 col-md-7 col-sm-6 col-xs-5 form-group">
		      <div class="input-group col-lg-4 col-md-5 col-sm-6">
		        <input type="text" class="form-control input-control input-sm" placeholder="3" value="<?php if(isset($databon)){
					echo $databon->h;
				} ?>" id="txtlength">
				<span class="input-group-addon" id="basic-addon2">hari</span>
			  </div>	
		   </div>
		   <div class="col-lg-4 col-md-5 col-sm-6 col-xs-7"><Label>Tutup Bon-TK pada jam (HH:mm)</label></div>
		   <div class="col-lg-8 col-md-7 col-sm-6 col-xs-5">
				<div class="input-group col-lg-4 col-md-5 col-sm-6" id="timetk">
				   <input type="text" class="form-control" aria-describedby="basic-addon2" id="txttime" value="<?php
				      if(isset($databon)){
						  echo $databon->bontkhour;
					  }
				   ?>"/>
				   <span class="input-group-addon" id="basic-addon2">
				      <span class="glyphicon glyphicon-time"></span>
				   </span>
				</div>
		   </div>
		   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"></div>
		   <div class="col-lg-4 col-md-5 col-sm-6 col-xs-7"></div>
		   <div class="col-lg-2 col-md-2 col-sm-2 col-xs-3 paddingtop5">
		       <button type="button" class="btn btn-primary btn-sm btn-block" id="btnsettk">Simpan</button>
		   </div>
	   </div>
   </div>
</div>
