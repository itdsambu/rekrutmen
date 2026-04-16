<!-- <div class="form-group row" id="status">
    <label for="example-search-input" class="col-sm-2 col-form-label">Status Pekerja</label>
    <div class="col-sm-4">
        <select class="form-control status" name="txtStatus">
            <option value="">- Pilih Status Pekerja -</option>
            <option value="1" <?php if ($status_tk == '1') { echo 'selected'; } ?>>Tenaga Kerja </option>
            <option value="2" <?php if ($status_tk == '2') { echo 'selected'; } ?>>Non Tenaga Kerja </option>
        </select>
    </div>
</div> -->
<div class="form-group row NIK">
    <label for="example-search-input" class="col-sm-2 col-form-label">NIK</label>
    <div class="col-sm-4">
        <input type="text" name="txtNik" id="nik_id" class="form-control" onchange="get_list_tkb();" value="<?php if(isset($_getTenagaKerjaKar->NIKPayroll)){ echo $_getTenagaKerjaKar->NIKPayroll;}?>" placeholder="Input NIK" required>
        <input type="hidden" name="txtfixReg" id="fixreg" class="form-control" value="<?php if(isset($_getTenagaKerjaKar->RegFixno)){ echo $_getTenagaKerjaKar->RegFixno;}?>" readonly required>
        <input type="hidden" name="txtPerson" id="idPerson" class="form-control" value="<?php if(isset($_getTenagaKerjaKar->PersonID)){ echo $_getTenagaKerjaKar->PersonID;}?>" readonly required>
        <input type="hidden" name="txtStatusPerson" id="karyawanSt" class="form-control" value="<?php if(isset($_getTenagaKerjaKar->StatusPerson)){ echo $_getTenagaKerjaKar->StatusPerson;}?>" readonly required>
    </div>
</div>
<!-- <div class="form-group row ID">
    <label for="example-search-input" class="col-sm-2 col-form-label">ID</label>
    <div class="col-sm-4">
        <input type="text" name="txtId" id="id_register" class="form-control" onchange="get_list_tkb();" placeholder="Input ID" required>
    </div>
</div> -->
<div class="form-group row">
    <label for="example-search-input" class="col-sm-2 col-form-label">Nama</label>
    <div class="col-sm-4" id="nmLengkap">
        <input type="text" name="txtNama" id="nama_lengkap" class="form-control tes" value="<?php if(isset($_getTenagaKerjaKar->Nama)){ echo $_getTenagaKerjaKar->Nama;}?>" readonly required placeholder="Nama Auto">
    </div>
</div>
<div class="form-group row">
    <label for="example-search-input" class="col-sm-2 col-form-label">Bagian</label>
    <div class="col-sm-4">
        <input type="text" name="txtBagian" id="bagian" class="form-control" value="<?php if(isset($_getTenagaKerjaKar->Departemen)){ echo $_getTenagaKerjaKar->Departemen;}?>" readonly required placeholder="Bagian Auto">
        <input type="hidden" name="txtBagianID" id="bagianID" class="form-control" value="<?php if(isset($_getTenagaKerjaKar->DeptID)){ echo $_getTenagaKerjaKar->DeptID;}?>" readonly required placeholder="Bagian Auto">
    </div>
</div>
<div class="form-group row">
    <label for="example-search-input" class="col-sm-2 col-form-label">Jabatan</label>
    <div class="col-sm-4">
        <input type="text" name="txtJabatan" id="jabatan" class="form-control" value="<?php if(isset($_getTenagaKerjaKar->Jabatan)){ echo $_getTenagaKerjaKar->Jabatan;}?>" readonly required placeholder="Jabatan Auto">
    </div>
</div>