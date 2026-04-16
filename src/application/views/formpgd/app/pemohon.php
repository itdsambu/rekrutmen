<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/components.css">
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/core.css">
<?php
    $this->load->view('template/sweetAlert');
    $this->load->view('template/formPicker');
    $this->load->view('template/formValidation');
?>
<div class="page-header">
    <h1>
        TTD
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Daftar TTD Surat PGD
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><b> TTD TK Berhenti</b></div>
            <div class="panel-body">
                <form name="ttdtenaker" id="ttdtenaker" class="form-horizontal" method="POST">
                    <input type="hidden" name="idref" id="idref" value="<?php if(isset($_rifid)){echo $_rifid;}?>">
                    <div class="panel-body panel-pb">
                        <?php foreach($_getdata as $row){?>
                        <input type="hidden" id="idkry" value="">
                        <div class="form-group">
                            <div class="col-md-12 col-sm-6">
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-offset-5 col-sm-12">
                                        <div class="form-group">
                                            <span class="profile-picture">
                                                <img id="avatar" width="150" class="editable img-responsive editable-click editable-empty" src="<?php echo base_url();?>dataupload/Blacklist/foto_kar/BORO/<?php echo trim($row->NIK);?>.jpg" style="display: block;"></img>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-md-5">NIK</label>
                                    <div class="col-md-4">
                                        <div class="col-sm-12 input-group">
                                            <input name="txtnik" id="txtnik" value="<?php echo $row->NIK;?>" class="form-control input-sm" type="text" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-5">Dept</label>
                                    <div class="col-md-4">
                                        <div class="col-sm-12 input-group">
                                            <input name="txtdept" id="txtdept" value="<?php echo $row->DeptAbbr;?>" class="form-control input-sm" type="text" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Nama</label>
                                    <div class="col-md-4">
                                        <div class="col-sm-12 input-group">
                                            <input name="txtnama" id="txtnama" value="<?php echo $row->NAMA;?>" class="form-control input-sm" type="text" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-2">Jabatan</label>
                                    <div class="col-md-4">
                                        <div class="col-sm-12 input-group">
                                            <input name="txtjabatan" id="txtjabatan" value="<?php echo $row->Jabatan;?>" class="form-control input-sm" type="text" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </form>
                <div class="col-sm-12">
                    <!-- <div class="panel panel-color panel-primary panel-mbno"> -->
                        <div class="panel-body panel-pb">
                            <center>
                                <form id="themain">
                                    <form method="post" id="ttdkontrak" action="simpan_foto.php" enctype="multipart/form-data">
                                        <canvas id="can" name="can" width="850" height="500" style="border:1px solid #ddd;" onclick="myFunction()"></canvas>
                                    </form>
                                    <div id="btns">
                                        <button type="button" id="btnclean" class="btn btn-info" onclick="myButton()">Reset</button>
                                        <button id="ttd" type="button" onclick="uploadEx();" class="btn btn-primary" download="<?php echo decode_str($id); ?>" value="Simpan Tanda Tangan" style="width:200px;">Save</button>
                                        <form method="post" accept-charset="utf-8" id="form1" action="<?php echo base_url(); ?>Suratpgd/simpan_foto">
                                            <input name="hidden_data" id='hidden_data' type="text"/>
                                            <input type="text" name="refid" id="refid" value="<?php echo $id; ?>"/>
                                            <input type="text" id="txt_kode" name="txt_kode"  value="<?= $_getkode?>">
                                            <input type="text" id="txt_status" name="txt_status" value="<?= $_status?>">
                                        </form>
                                    </div>
                                </form>
                            </center>
                        </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var btn = document.getElementById('ttd').value;
        $('#themain').submit(function(){
            window.onbeforeunload = null;
        });

        if(btn === 'Save'){
            window.onbeforeunload = function(){
                return "YANG BERSANGKUTAN BELUM TANDA TANGAN"
            };
        }

        document.getElementById("ttd").disabled=true;
    });
    function myFunction(){
        document.getElementById("ttd").disabled = false;
    }
    
    function myButton(){
        document.getElementById("ttd").disabled = true;
    }
</script>
<script>
    var el,ctx,bounds,isDrawing,points=[];
    function midPointBtw(p1, p2) {
            return {
                x: p1.x + (p2.x - p1.x) / 2,
                y: p1.y + (p2.y - p1.y) / 2
            };
    }
    
    
    $('#btnclean').on('click',function(e){
        e.preventDefault();
        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
        points.length=0;
    }); 
    
    
    function isEmptydata(datas){
        if(datas.trim()==='')
        {
            return true;
        }else{
            return false;
        }
    }

    $(function(){
        el = document.getElementById('can');
        ctx = el.getContext('2d');
        ctx.lineWidth = 10;
        ctx.lineJoin = ctx.lineCap = 'round';       

        el.onmousedown = function(e) {
            bounds = el.getBoundingClientRect();
            if (!isDrawing) {
                 isDrawing = true;
            }
            points.push({ x: e.clientX - bounds.x, y: e.clientY - bounds.y });
        };

        el.onmousemove = function(e) {
            if (!isDrawing) return;
            points.push({ x: e.clientX - bounds.x, y: e.clientY - bounds.y });
            var p1 = points[0];
            var p2 = points[1];
            ctx.beginPath();
            ctx.moveTo(p1.x, p1.y);
            for (var i = 1, len = points.length; i < len; i++) {
                var midPoint = midPointBtw(p1, p2);
                ctx.quadraticCurveTo(p1.x, p1.y, midPoint.x, midPoint.y);
                p1 = points[i];
                p2 = points[i+1];
            }
            ctx.lineTo(p1.x, p1.y);
            ctx.stroke();
        };

        el.onmouseup = function() {
            if(isDrawing){
               isDrawing = false;
            }
            points.length = 0;
        };
        
        <?php if( isset($filedata) ){ ?>
            var image = new Image();
            image.onload = function(){
                ctx.drawImage(image,0,0);
            };
            image.src ="<?= $filedata ?>";
        <?php } ?>
    });
</script>
<script>
    function uploadEx() {
        var canvas = document.getElementById("can");
        var dataURL = canvas.toDataURL("image/png");
        document.getElementById('hidden_data').value = dataURL;
        var fd = new FormData(document.getElementById("form1"));

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'tanda_tangan/tes', true);
        
        xhr.upload.onprogress = function (e) {
            if (e.lengthComputable) {
                var percentComplete = (e.loaded / e.total) * 100;
                console.log(percentComplete + '% uploaded');
                document.getElementById("form1").submit();
                alert('Tanda Tangan berhasil disimpan');
            }
        };
     
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(fd);
    }
    ;
</script>