<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">    
    <script src="<?php echo base_url();?>assets/dp/jquery-1.10.2.js"></script>

    
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet">
    <script src="<?php echo base_url(); ?>assets/js/app.js" type="text/javascript"></script>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js" type="text/javascript"></script>
    

</head>
<body>
       
   <center>
    <h1>
    <div id="themain">
        <form method="post" action="simpan_foto.php" enctype="multipart/form-data">
            <canvas id="can" name="can" width="850" height="500" style="border:1px solid #ddd;"></canvas>
            <div id="clr">
                <div style="background-color:black;"></div>
                <div style="background-color:red;"></div>
                <div style="background-color:green;"></div>
                <div style="background-color:orange;"></div>
                <div style="background-color:#FFFF00;"></div>
                <div style="background-color:#F43059;"></div>
                <div style="background-color:#ff00ff;"></div>
                <div style="background-color:#9ecc3b;"></div>
                <div style="background-color:#fbd;"></div>
                <div style="background-color:#fff460;"></div>
                <div style="background-color:#F43059;"></div>
                <div style="background-color:#82B82C;"></div>
                <div style="background-color:#0099FF;"></div>
                <div style="background-color:#ff00ff;"></div>
                <div style="background-color:rgb(128,0,255);"></div>
                <div style="background-color:rgb(255,128,0);"></div>
                <div style="background-color:rgb(153,254,0);"></div>
                <div style="background-color:rgb(18,0,255);"></div>
                <div style="background-color:rgb(255,28,0);"></div>
                <div style="background-color:rgb(13,54,0);"></div>

            </div><br /><br />
            Pen size: <input type="range" min="0" max="50" value="4" id="bsz"/><br />
            <br />
            Pen color: <input type="color" placeholder="#000"  value="#000" id="bcl"/><br />

        </form>
        <div id="btns">
            <a href="#themain" id="undo" class="minimal" ><button style="width:100px;">Undo</button> </a>
            <a href="#themain" id="clear" class="minimal" ><button style="width:100px;">Hapus</button></a>
             <button id="ttd" type="button" onclick="uploadEx();" class="btn btn-primary" download="<?php echo  $this->uri->segment(3); ?>" value="Simpan Tanda Tangan" style="width:200px;">Simpan Tanda Tangan</button>
            
            <form method="post" accept-charset="utf-8" id="form1" action="<?php echo base_url(); ?>Interview/simpan_foto">
                <input name="hidden_data" id='hidden_data' type="hidden"/>
                <!-- <input type="text" name="HeaderID" id="HeaderID" value="<?php //echo  $this->uri->segment(3); ?>"/> -->
                <input type="hidden" name="Nofix" id="Nofix" value="<?php echo  $this->uri->segment(3); ?>"/>
                <input type="hidden" name="NIK" id="NIK" value="<?php echo  $this->uri->segment(4); ?>"/>
            </form>
        </div>
        <!--
        <form action="action" method="post" id="frm">
            <input type="hidden" name="TransID" id="TransID" value="<?php //echo  $this->uri->segment(3); ?>"/>
            <span id="result"></span>
            <input type="hidden" name="data" id="data" />
            <a id="save" href="#themain" class="minimal">Tampilkan Tanda Tangan</a>
        </form>
        -->
        <button onClick="javascript:window.close();" style="width:200px;">close</button>
    </div>
</center>
</body>

<script language="javascript" type="text/javascript"> 
    function windowClose() { 
    window.open('','_parent',''); 
    window.close();
    } 
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
            }
        };
     
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.send(fd);
    }
    ;
</script>
