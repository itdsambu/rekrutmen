<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="txtkerabatterdekat"> Kerabat Terdekat* </label>
    <div class="col-sm-8">
        <input type="text" id="txtkerabatterdekat" name="txtkerabatterdekat" placeholder="Kerabat Terdekat" class="col-xs-12 col-sm-10" required maxlength="50" />
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="txtnohpkerabat">Nomor HP. Kerabat* </label>
    <div class="col-sm-8">
        <input type="text" id="txtnohpkerabat" name="txtnohpkerabat" placeholder="Nomor telepon" class="col-xs-12 col-sm-10" required maxlength="20" />
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label no-padding-right" for="txtnohpkerabat">Hubungan dgn. Kerabat* </label>
    <div class="col-sm-8">
        <input type="text" id="txthubungan" name="txthubungan" placeholder="Hubungan" class="col-xs-12 col-sm-10" required maxlength="20" />
    </div>
</div>

<script>
  function validateNumber(event) {
     var key = window.event ? event.keyCode : event.which;
     if (event.keyCode === 8 || event.keyCode === 46) {
         return true;
     } else if ( key < 48 || key > 57 ) {
         return false;
     } else {
         return true;
     }
 };

 $(function(){
     $('#txtnohpkerabat').keypress(validateNumber);
 })
</script>