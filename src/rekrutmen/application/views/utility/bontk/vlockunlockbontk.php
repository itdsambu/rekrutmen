<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        UnLock / Lock Bon-TK 
    </span>
</h4>
<div class="row">
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="readperiode">
       <label class="col-lg-2 col-md-2 col-sm-3 col-xs-12 text-right">Periode</label>
	   <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
	   <select class="selectpicker form-control btn-sm" id="periodes" data-style="btn-primary btn-sm">
	      <?php if(isset($periode)) { ?>
				<option value="<?php echo $periode->curperiode;?>"><?php echo $periode->curperiode; ?></option>
		  <?php };?>			   
	   </select>
	   </div>
	   <div class="col-lg-2 col-md-2 col-sm-3 col-xs-12">
	      <button type="button" id="btnrefresh" class="btn btn-sm btn-primary btpadding2"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>  Refresh</button>
	   </div>
   </div>
   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="row">
	     <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		    <div class="panel panel-default">
			    <div class="panel panel-info">
				   <div class="panel-heading">Status Lock/UnLock Bon TK - </div>
				</div>
				<div class="panel-body row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					    <section id="tblview">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<table id="tblperusahaan" class="table table-striped table-hover table-nowrap table-colored">
									<thead>
										<tr>
											<th>Perusahaan</th>
											<th>Lock</th>
											<th>UnLock</th>
											<th>Status</th>											
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							<div id="takeform"></div>
							</div>
						</section>
					</div>					
				</div>
			</div>
		 </div>
	  </div>
   </div>   
</div>