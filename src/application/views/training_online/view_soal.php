<div class="alert alert-primary">
    <h2 class="mt-0 header-title"><b>
            <center>LEMBAR SOAL</center>
        </b></h2>
</div>
<h6 class="mt-0 header-title dagdigdug"><b> Pilihlah salah satu jawaban yang paling benar. </b></h6>
<hr>
<br>
<div class="col-md-12 text-center heading-section">
    <?php
    $no = 1;
    $jb = 0;
    foreach ($getSoal as $row) { ?>
        <h2 class="mb-3 text-left pertayaan">
            <?php echo $no++ . '. ' . $row->Soal; ?> &nbsp;
            <?php if ($row->Link == NULL) {
                echo "";
            } else {
                $s = 1;
                if ($jenis_soal == 1) { ?>
                    <div class="">
                        <img src="<?php echo base_url('assets/ttdtraining/GambarSoal/PreTest/' . $row->ID . '.JPG'); ?>" class="img-fluid d-block mx-auto" alt="Responsive image" style="width: 500px;height: 300px;">
                    </div>
                <?php
                } else { ?>
                    <div>
                        <img src="<?php echo base_url('assets/ttdtraining/GambarSoal/PostTest/' . $row->ID . '.JPG'); ?>" style="width: 500px;height: auto;">
                    </div>
            <?php
                }
            } ?>
        </h2>
        <hr>

        <input type="hidden" name="txtSoal" id="soal_id_<?= $jb; ?>" value="<?php echo $row->IDSoal; ?>" class="txt form-control">
        <input type="hidden" name="txtHdrSoal" id="hdr_soal_id_" value="<?php echo $row->IdMstSoalHdr; ?>" class="txt form-control">
        <input type="hidden" name="txtHdrJawaban" id="hdr_id_jawaban" value="<?php echo $hdrid; ?>" class="txt form-control">

        <?php
        $this->load->model("M_TrainingOnline");
        $jawaban = $this->M_TrainingOnline->_getJawaban($row->IDSoal);
        foreach ($jawaban as $key) {
            if ($key->IDSoal == $row->IDSoal) { ?>
                <label class='container text-left'>
                    <!-- <input type='radio' class="" name='" + index.no +"' id='ya' value='" + key + "'><span class='checkmark'></span> -->
                    <input type="radio" id="objectif_id<?php echo $key->IDSoal; ?>" name="objectif<?php echo $key->IDSoal ?>" class="md-radiobtn txtobjectif_<?= $jb; ?>" value="<?php echo $key->IDObjectif; ?>">
                    <input type="hidden" name="txtDetailID" id="detailid" class="form-control detail_id_<?= $jb; ?>" value="<?php echo $row->DetailID ?>">
                    <span class='checkmark'></span>
                    <?php if ($key->Link == NULL) {
                        echo $key->Objectif;
                    } else {
                        if ($jenis_soal == 1) { ?>
                            <img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PreTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br>
                        <?php
                        } else { ?>
                            <img src="<?php echo base_url('assets/ttdtraining/GambarObjektif/PostTest/' . $key->ID . '_' . $key->NamaObjektif . '.jpg'); ?>" style="width: 150px;height: 80px;"><br><br>
                    <?php
                        }
                    } ?>
                </label>
        <?php
            }
        } ?>
        <hr>

    <?php
        $jb++;
    } ?>
</div>
<br>
<div class="row ttd_view">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12">
                <div class="card-content">
                    <div class="card-body card-dashboard">
                        <div class="alert alert-primary">
                            <h4 class="mt-0 header-title"><b>
                                    <center>TANDA TANGAN</center>
                                </b></h4>
                        </div>
                        <br>
                        <center>
                            <form id="themain">
                                <form method="post" id="ttdkontrak" action="simpan_ttdkuk.php" enctype="multipart/form-data">
                                    <canvas id="can" name="can" width="300" height="260" style="border:1px solid #ddd;" onclick="myFunction()"></canvas>
                                    <br><br><i><b>NOTE : Jika Tombol Save tidak aktif, Silahkan klik 1x di frame Tanda Tangan....!</b></i><br><br>
                                </form>
                                <div id="btns">
                                    <button type="button" id="btnclean" class="btn btn-info" onclick="myButton()">Reset</button>
                                    <button id="ttd" type="button" onclick="simpan();" class="btn btn-primary" download="" value="Simpan Tanda Tangan" style="width:200px;">Save</button>
                                    <input type="hidden" name="hidden_data" id='hidden_data' />
                                </div>
                            </form>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="form-group" id="frame_btn">
    <center>
        <button type="submit" class="btn btn-lg btn-primary ttd_submit">Tanda Tanggan</button>
        <a href="#" class="btn btn-lg btn-danger ttd_submit">Batal</a>
    </center>
</div>

<script>
    const h2 = document.getElementsByClassName('pertayaan');
    for (let index = 0; index < h2.length; index++) {
        h2[index].style.fontSize = "large";
    }

    const frame_ttd = document.getElementById('frame_btn');
    $('.ttd_view').prop('style', 'display: none');
    frame_ttd.addEventListener('click', function() {
        $('.ttd_submit').prop('style', 'display: none');
        $('.ttd_view').prop('style', 'display: block');
    });
</script>

<!-- ini script yang lama tidak ada di modify -->
<script>
    $(document).ready(function() {
        var btn = document.getElementById('ttd').value;
        $('#themain').submit(function() {
            window.onbeforeunload = null;
        });

        if (btn === 'Save') {
            window.onbeforeunload = function() {
                return "YANG BERSANGKUTAN BELUM TANDA TANGAN"
            };
        }

        document.getElementById("ttd").disabled = true;
    });

    function myButton() {
        document.getElementById("ttd").disabled = true;
    }

    function myFunction() {
        document.getElementById("ttd").disabled = false;
    }
</script>
<script>
    var el, ctx, bounds, isDrawing, points = [];

    function midPointBtw(p1, p2) {
        return {
            x: p1.x + (p2.x - p1.x) / 2,
            y: p1.y + (p2.y - p1.y) / 2
        };
    }


    $('#btnclean').on('click', function(e) {
        e.preventDefault();
        ctx.clearRect(0, 0, ctx.canvas.width, ctx.canvas.height);
        points.length = 0;
    });


    function isEmptydata(datas) {
        if (datas.trim() === '') {
            return true;
        } else {
            return false;
        }
    }

    $(function() {
        el = document.getElementById('can');
        ctx = el.getContext('2d');
        ctx.lineWidth = 5;
        ctx.lineJoin = ctx.lineCap = 'round';

        var is_touch_device = 'ontouchstart' in document.documentElement;

        if (is_touch_device) {
            // create a drawer which tracks touch movements
            var drawer = {
                isDrawing: false,
                touchstart: function(coors) {
                    ctx.beginPath();
                    ctx.moveTo(coors.x, coors.y);
                    this.isDrawing = true;
                },
                touchmove: function(coors) {
                    if (this.isDrawing) {
                        ctx.lineTo(coors.x, coors.y);
                        ctx.stroke();
                    }
                },
                touchend: function(coors) {
                    if (this.isDrawing) {
                        this.touchmove(coors);
                        this.isDrawing = false;
                    }
                }
            };

            // create a function to pass touch events and coordinates to drawer
            function draw(event) {

                // get the touch coordinates.  Using the first touch in case of multi-touch
                var coors = {
                    x: event.targetTouches[0].pageX,
                    y: event.targetTouches[0].pageY
                };

                // Now we need to get the offset of the canvas location
                var obj = el;

                if (obj.offsetParent) {
                    // Every time we find a new object, we add its offsetLeft and offsetTop to curleft and curtop.
                    do {
                        coors.x -= obj.offsetLeft;
                        coors.y -= obj.offsetTop;
                    }
                    // The while loop can be "while (obj = obj.offsetParent)" only, which does return null
                    // when null is passed back, but that creates a warning in some editors (i.e. VS2010).
                    while ((obj = obj.offsetParent) != null);
                }

                // pass the coordinates to the appropriate handler
                drawer[event.type](coors);
            }

            // attach the touchstart, touchmove, touchend event listeners.
            el.addEventListener('touchstart', draw, false);
            el.addEventListener('touchmove', draw, false);
            el.addEventListener('touchend', draw, false);

            // prevent elastic scrolling
            el.addEventListener('touchmove', function(event) {
                event.preventDefault();
            }, false);
        }
        el.onmousedown = function(e) {
            bounds = el.getBoundingClientRect();
            if (!isDrawing) {
                isDrawing = true;
            }
            points.push({
                x: e.clientX - bounds.x,
                y: e.clientY - bounds.y
            });
        };

        el.onmousemove = function(e) {
            if (!isDrawing) return;
            points.push({
                x: e.clientX - bounds.x,
                y: e.clientY - bounds.y
            });
            var p1 = points[0];
            var p2 = points[1];
            ctx.beginPath();
            ctx.moveTo(p1.x, p1.y);
            for (var i = 1, len = points.length; i < len; i++) {
                var midPoint = midPointBtw(p1, p2);
                ctx.quadraticCurveTo(p1.x, p1.y, midPoint.x, midPoint.y);
                p1 = points[i];
                p2 = points[i + 1];
            }
            ctx.lineTo(p1.x, p1.y);
            ctx.stroke();
        };

        el.onmouseup = function() {
            if (isDrawing) {
                isDrawing = false;
            }
            points.length = 0;
        };

        <?php if (isset($filedata)) { ?>
            var image = new Image();
            image.onload = function() {
                ctx.drawImage(image, 0, 0);
            };
            image.src = "<?= $filedata ?>";
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
        xhr.open('POST', 'tanda_tangan/', true);

        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable) {
                var percentComplete = (e.loaded / e.total) * 100;
                console.log(percentComplete + '% uploaded');
                document.getElementById("form1").submit();
                alert('Tanda Tangan berhasil disimpan');
            }
        };

        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(fd);
    };
</script>