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
<div class="col-sm-12">
                                    
                                    
                                    <form action="<?= base_url('configpermintaan/updatedatamemopsn')?>" name="frmupdate" id="frmupdate" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                                            <input type="hidden" id="noref" name="noref" value="<?=$datamemo->IDMemo?>">
                                            <div class="form-horizontal">
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Dept</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="txtdeptname" readonly value="<?=$datamemo->DeptAbbr?>">
                                                    </div>
                                                </div>  
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Tipe Permintaan</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="txttipe"  readonly value="<?=$datamemo->IsKry==0 ? 'Tenaga Kerja':'Karyawan'?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Jmlh.Kry Real</label>
                                                    <div class="col-sm-3">
                                                        <input type="text" class="form-control" id="txtrealkry" name="stxtrealkry" readonly value="<?=$datamemo->IsKry==0 ? $datareal->RBor : $datareal->RKry?>">
                                                    </div>
                                                </div>
                                                
                                                <div class="form-group">
                                                    <label class="col-sm-3 control-label">Jmlh.Kry Ideal</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="txtidealkry"  readonly value="<?=$datamemo->IsKry==0 ? $datareal->IBor : $datareal->IKry?>">
                                                    </div>
                                                    <label class="col-sm-2 control-label">Update Kry Ideal</label>
                                                    <div class="col-sm-2">
                                                        <input type="text" class="form-control" id="txtidealkrys" name="stxtidealkry" required maxlength="5" value="<?=$datamemo->IsKry==0 ? $datareal->IBor : $datareal->IKry?>">
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