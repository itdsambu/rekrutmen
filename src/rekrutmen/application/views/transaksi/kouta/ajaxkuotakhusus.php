<?php if($_cekDdata >= 0){?>
	<?php foreach($_getDdata as $row){?>
	    <div class="form-group">
	        <div class="col-sm-3">
	            <input type="text" name="txtFindByid" id="findByid" class="form-control input-sm" placeholder="RegID" value="<?php echo $row->HeaderID?>" readonly/>
	        </div>
	        <div class="col-sm-3">
	            <input type="text" name="txtnama" id="nama" class="form-control input-sm" placeholder="Nama" value="<?php echo $row->Nama?>" readonly/>
	        </div>
	        <div class="col-sm-3">
	            <input type="text" name="txtcv" id="cv" class="form-control input-sm" placeholder="CV" value="<?php echo $row->CVNama?>" readonly/>
	        </div>
	        <div class="col-sm-2">
                <input type="text" name="txtPeriode" id="inputPeriode" class="datepick-month col-sm-12 form-control input-sm" value="<?php echo $_getDate;?>" readonly/>
            </div>
            <div class="col-sm-1">
                <button type="submit" id="btnSimpan" class="btn btn-success btn-sm">Save</button>
            </div>
	    </div>
	<?php } ?>
<?php } else { ?>
		<div class="form-group">
			<div class="col-sm-12">
				<div class="alert alert-danger">RegID tersebut belum melengkapi data. Harap lengkapi data ...
					<button type='button' class='close' data-dismiss='alert'><i class="ace-icon fa fa-times"></i></button>
				</div>
			</div>
		</div>
<?php } ?>