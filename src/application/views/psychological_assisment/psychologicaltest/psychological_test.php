<!-- <head>
    <title>UNDER REPAIR</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
</head>
<body>      
    <div class="container">
        <div class="alert alert-danger">UNDER REPAIR</div>
    </div>
</body> -->
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title"><center>Psychological Test</center></h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
        <!--         <div class="widget-toolbar no-border">
                </div> -->
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-lg-12">
                            <?php echo form_open_multipart('PsychologicalAssisment/simpanData'); ?>
                            <div class="form-horizontal">
                                <div id="ajaxFormHeader">
                                    <div class="form-group">
                                        <label class="col-lg-2 control-label"></label>
                                        <div class="col-sm-4">
                                            <input type="hidden" name="txtHeaderid" id="headerid" class="form-control">
                                        </div>
                                    </div>
                                    <!-- <div class="form-group">
                                        <label class="col-lg-2 control-label">Nama Lengkap</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="txtnama" id="Nama" required="" readonly="" placeholder="Input Nama">
                                        </div>
                                        <a href="#myModal" data-toggle="modal" id="btnFind" class="btn btn-success btn-sm" style="background-color: #E25FA6 !important; border-color: #E25FA6;">
                                            <i class="fa fa-search" ></i>
                                        Search Name
                                        </a> 
                                    </div> -->
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>   
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                    $('#psikologi').dataTable();
                    $('#psikologi').click(function(){
                    $('.panel-heading').hide();
                    $('.panel-body').hide();
                    });
                });
                </script>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4><b>List Data Calon Karyawan</b></h4>
                    </div>
                    <div class="panel-body">
                        <div style="padding: 5px;"></div>
                        <table class="table table-hover table-striped table table-striped table-hover table-bordered" id="psikologi">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">ID</th>
                                    <th style="text-align: center;">Name</th>
                                    <th style="text-align: center;">Tanggal Lahir</th>
                                    <!-- <th style="text-align: center;">Tempat Lahir</th> -->
                                    <th style="text-align: center;">Pendidikan Terakhir</th>
                                    <th style="text-align: center;">Jenis Kelamin</th>
                                    <th style="text-align: center;">Departemen Tujuan</th>
                                    <th style="text-align: center;">Jadwal Tes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($list)) { ?>
                                    <tr>
                                        <td colspan="7">Data tidak ditemukan</td>
                                    </tr>
                                    <?php
                                } else {
                                    foreach ($list as $get) { ?>
                                        <tr onclick="pilih(this.id)" id="<?php echo $get->CalonPelamarID ?>" style="cursor: pointer;">
                                            <td><?php echo $get->CalonPelamarID; ?></td>
                                            <td><?php echo $get->Nama; ?></td>
                                            <td><?php echo date('d-M-Y',strtotime($get->TanggalLahir)) ?></td>
                                            <!-- <td><?php echo $get->TempatLahir; ?></td> -->
                                            <td><?php echo $get->Pendidikan; ?></td>
                                            <td><?php echo $get->JenisKelamin; ?></td>
                                            <!-- <td><?php echo $get->DeptAbbr; ?></td> -->
                                            <td></td>
                                            <td><?php echo $get->JadwalTes; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>
                            </tbody>
                    </div>
                </div>
                        </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">User Psychological Test</h4>
            </div>
            <div class="modal-body">
                <div id="lihat_detail" class="well">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Find By Nama/ID </label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="txtFindBy" id="FindByName" required="" placeholder="Find By Name Or ID">
                        </div>
                        <button type="button" id="btnCari" class="btn btn-sm btn-success" style="background-color: #E25FA6 !important; border-color: #E25FA6;" onclick="callAjax();"> 
                        <i class="fa fa-refresh"></i>
                            Refresh
                        </button>
                    </div>
                    <div id="getData">
                        <table  class="table table-hover table-striped table table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Tempat,Tanggal Lahir</th>
                                    <th class="text-center">Nama Ibu Kadung</th>
                                    <th class="text-center">Alamat</th>
                                    <th class="text-center">Registered By</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script type="text/javascript">
    function callAjax(){
        var Nama = $('#FindByName').val();
        // alert(Nama);

        if(Nama == ''){
            alert('Data Tidak Boleh Kosong');
        }else{
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PsychologicalAssisment/getKaryawan')?>"+"/"+Nama,
                success: function(msg){
                    if(msg == ''){
                      alert('Tidak ada data');
                    } 
                    else{
                        $("#getData").html(msg);                                                     
                    }
                }
            });
        }    
    };
    $("#btnFind").click(function(){
        var id = $('#Nama').val();
        // alert(nama);
        if(id != ''){
            $.ajax({
                type: "POST",
                url : "<?php echo site_url('PsychologicalAssisment/getNama')?>",
                data: {
                    'id' : id
                },
                success: function(msg){
                    $('#ajaxFormHeader').html(msg);
                }
            });
            document.getElementById('btnFind').disabled = false;
        }
        
    });
    function pilih($id){
        var id = $id;
        // alert(id);
        if(id != ''){
            $.ajax({
                type: "POST",
                dataType: "html",
                url : "<?php echo site_url('PsychologicalAssisment/getNama')?>"+"/"+id,
                success: function(msg){
                    $('#ajaxFormHeader').html(msg);
                }
            });
        }
    };
</script>