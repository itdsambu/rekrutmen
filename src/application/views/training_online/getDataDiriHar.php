<div id="ajaxfrommodal">
    <div class="form-group row">
        <label for="example-search-input" class="col-sm-2 col-form-label">NIK</label>
        <div class="col-sm-4">
           <input type="text" name="txtNik" id="nik_id" class="form-control" onchange="get_list_tkb();" value="<?php if(isset($_getTenagaKerjaHar->Nik)){ echo $_getTenagaKerjaHar->Nik;}?>" placeholder="Input NIK" required>
				<input type="hidden" name="txtfixReg" id="fixreg" class="form-control" value="<?php if(isset($_getTenagaKerjaHar->Nofix)){ echo $_getTenagaKerjaHar->Nofix;}?>" readonly required>
        </div>
    </div>
    <div class="form-group row">
        <label for="example-search-input" class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-4">
           <input type="text" name="txtNama" id="nama_lengkap" class="form-control" value="<?php if(isset($_getTenagaKerjaHar->Nama)){ echo $_getTenagaKerjaHar->Nama;}?>" readonly required placeholder="Nama Auto">
        </div>
    </div>
    <div class="form-group row">
        <label for="example-search-input" class="col-sm-2 col-form-label">Bagian</label>
        <div class="col-sm-4">
            <input type="text" name="txtBagian" id="bagian" class="form-control" value="<?php if(isset($_getTenagaKerjaHar->Bagian)){ echo $_getTenagaKerjaHar->Bagian;}?>" readonly required placeholder="Bagian Auto">
            <input type="hidden" name="txtBagianID" id="bagianID" class="form-control" value="<?php if(isset($_getTenagaKerjaHar->DeptID)){ echo $_getTenagaKerjaHar->DeptID;}?>" readonly required placeholder="Bagian Auto">
        </div>
    </div>
    <div class="form-group row">
    	<label for="example-search-input" class="col-sm-2 col-form-label">Jabatan</label>
        <div class="col-sm-4">
            <input type="text" name="txtJabatan" id="jabatan" class="form-control" value="<?php if(isset($_getTenagaKerjaHar->Jabatan)){ echo $_getTenagaKerjaHar->Jabatan;}?>" readonly required placeholder="Jabatan Auto">
        </div>
    </div>
</div>