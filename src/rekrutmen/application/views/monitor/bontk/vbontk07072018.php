<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Minotoring Bon-TK
    </span>
</h4>

<div class="row">
    
	<!--header content-->
    
		    
			 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-inline"  id="inputcontent" style="margin-bottom: 5px;">
				<div class="row">
				  <div class="col-lg-10 col-md-9 col-sm-8">
				   <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12 form-inline" style="margin-bottom: 5px;">
							<select class="selectpicker form-control btn-sm" id="selectperiod" data-style="btn-primary btn-sm">
								<option value="<?php echo $periode->curperiode;?>"><?php echo $periode->curperiode;?></option>
									<?php foreach ($allperiode as $item){?>
									<?php echo '<option value="' . $item['showperiode'] . '">' . $item['showperiode'] . '</option>'; ?>
									<?php };?>
							</select>
					</div> 
					<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">				   
						<select class="selectpicker form-control btn-sm" id="selectperusahaan" data-style="btn-primary btn-sm">						
						<option value="0">Select Perusahaan</option>						
							<?php if( isset($data) ) : ?>
									<?php foreach ($data as $item) { ?>
										<option value="<?php echo $item['cperusahaan']; ?>"><?php echo $item['perusahaan'] ?></option>							 
									<?php } ?>					   
							<?php endif;?>							
						</select>					
					</div>
					<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12"></div>
					<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-bottom:10px;">
							<div class="btn-group" role="group" aria-label="...">
								<!--<button type="button" id="btnconvertexcel" class="btnmygroup btn btn-success"><i class="fa fa-file-excel-o" aria-hidden="true"></i></button>-->
								<button type="button" id="btntopdf" class="btnmygroup btn btn-success"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
								 <div class="input-group input-sum-group">
									<span class="input-group-addon">Total</span>
									<input type="text" id="sumtotal" value="0" disabled>
								</div>
							</div>
						</div>						
					</div>
													      
					  <!--<form name="helperform" id="helperform" method="POST" action=<?php echo base_url('bonpiutang/excellshow');?>>
					  </form>-->					  					 
					  <form name="helperpdf" id="helperpdf" method="POST" action=<?php echo base_url('bonpiutang/pdfshow');?>>
					  </form>				    
				  </div> 
				  <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12">
				      <button class="btn btn-success btn-sm btn-block" id="btnrefresh">Refresh</button>
				  </div>
				</div>	
			 </div>
           <input type="hidden" id="txtperiodehidden" value="<?php echo $periode->curperiode; ?>">		   
    <!--end header -->
	
	
	<!--viewer -->
	<section id="viewer">
	 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    <table id="tblnotbontk" class="table table-striped table-hover table-nowrap table-colored">
        <thead>
           <tr>
              <th>DEPT</th>
              <th>BAGIAN</th>
              <th>FIXNO</th>
              <th>NIK</th>
              <th>NAMA</th>
			  <th>Tgl-Msk</th>
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