<h4 class="row header smaller lighter green">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-files-o"></i>
        Utility Permintaan Karyawan dan TK
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
		     <h3 class="panel-title">Management Permintaan Karyawan dan TK</h3>
		   </div>
	   </div>
        <div class="panel-body">
            <section id="viewtabel">
                <div class="col-sm-6">
	    		    <table id="tblsettingkrytk" class="table table-striped table-hover table-nowrap table-colored" style="width:100%;">
        			    <thead>
           				    <tr>
              			        <th>Dept</th>
              			        <th>Ideal Kry</th>
              			        <th>Real Kry</th>
                                <th>Ideal TK</th>
                                <th>Real TK</th>
           				    </tr>
        			    </thead>
        		        <tbody>
        		        </tbody>
        		    </table>
        		    <div id="formupdate"></div>
	 		    </div>
                <div class="col-sm-6" id="inputdataform">
                    <div class="panel panel-default">
	                    <div class="panel-heading">
		                    <h3 class="panel-title">Update Data Ideal Karyawan</h3>
		                </div>
                        <div class="panel-body" id="formkry">
                           <div class="row">
                                <div class="col-sm-12">
                                    
                                    
                                    <form action="<?= base_url('configpermintaan/updatedata')?>" name="frmkry" id="frmkry" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                            <input type="hidden" id="idkrydept" name="idkrydept">
                                            <div class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Dept</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="txtdeptname" readonly>
                                                    </div>
                                                </div>  
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Jmlh.Kry Real</label>
                                                    <div class="col-sm-6">
                                                        <input type="text" class="form-control" id="txtrealkry" name="stxtrealkry" readonly>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Jmlh.Kry Ideal</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="txtidealkry"  readonly>
                                                    </div>
                                                    <label class="col-sm-2 control-label">Update</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="txtidealkrys" name="stxtidealkry" required maxlength="5" value="0">
                                                    </div>
                                                </div>                                                  
                                                <div class="form-group"> 
                                                    <div class="col-sm-3"></div>                                            
                                                    <div class="col-sm-9">
                                                        <input id="txtmemokry" name="stxtmemokry" class="input-sm form-control" type="file" id="txtmemokry" accept="pdf"/>                                                 
                                                    </div>                                             
                                                </div>      
                                                <div class="form-group"> 
                                                    <div class="col-sm-3"></div>
                                                    <div class="col-sm-9">
                                                        <button type="submit" id="btnuploadmemo" class="btn btn-primary btn-sm">Simpan</button>
                                                    </div>
                                                </div>                              
                                            </div>
                                    </form>

                                </div>
                           </div>
                        </div>
	                </div>
                    <div class="panel panel-default">
	                    <div class="panel-heading">
		                    <h3 class="panel-title">Update Data Ideal TK</h3>
		                </div>
                        <div class="panel-body" id="formtk">
                           <div class="row">
                                <div class="col-sm-12">
                                <form action="<?= base_url('configpermintaan/updatedatatk')?>" name="frmtk" id="frmtk" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                    <input type="hidden" id="idkrrybor" name="idkrrybor">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                             <label class="col-sm-3 control-label">Dept</label>
                                             <div class="col-sm-6">
                                                 <input type="text" class="form-control" id="txtdepttk" readonly>
                                             </div>
                                        </div>  
                                        <div class="form-group">
                                             <label class="col-sm-3 control-label">Jmlh. TK Real</label>
                                             <div class="col-sm-6">
                                                 <input type="text" class="form-control" id="txtrealtk" name="txtrealtk" readonly>
                                             </div>
                                        </div>
                                        <div class="form-group">
                                             <label class="col-sm-3 control-label">Jmlh. TK Ideal</label>
                                             <div class="col-sm-2">
                                                 <input type="text" class="form-control" id="txtidealtk" name="txtidealtk" readonly>
                                             </div>
                                             <label class="col-sm-2 control-label">Update</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="txtidealtks" name="txtidealtks" required maxlength="5" value="0">
                                                    </div>
                                        </div>  
                                        <div class="form-group"> 
                                             <div class="col-sm-3"></div>                                            
                                             <div class="col-sm-9">
                                                    <input id="txtmemotk" name="txtmemotk" class="input-sm form-control" type="file" id="txtmemotk" accept="pdf"/>                                                 
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
                                </div>
                           </div>
                        </div>
	                </div>
                </div><!--end of div col-sm-6-->                
            </section>
        </div>
    </div>
</div>


