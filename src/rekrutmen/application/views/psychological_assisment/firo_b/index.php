<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">FIRO B</h4>
                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>

                <div class="widget-toolbar no-border">
                    <!-- <a id="<?php echo $_getFormID ?>" class="btn btn-round btn-primary btn-minier" onclick="menu(this.id)"> About Information <i class="ace-icon fa fa-info-circle bigger-80"></i>
                    </a> -->
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-1 control-label"></label>
                <div class="col-lg-12">
                     <!-- alert -->
                    <?php if($this->input->get('msg') == "success"){
                        echo "<div class='alert alert-success'>";
                        echo "<strong>Sukses !!!</strong> Data berhasil disimpan.";
                        echo "</div>";
                    }elseif($this->input->get('msg') == "failed"){
                        echo "<div class='alert alert-danger'>";
                        echo "<strong>Gagal !!!</strong> Gagal menyimpan data .!!";
                        echo "</div>";
                    } ?> 
                </div>
            </div>
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PsychologicalAssisment/simpanDataFiro')?>">
                <div id="ajaxFormHeader">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="col-lg-2 control-label"></label>
                            <div class="col-sm-4">
                                <input type="hidden" name="txtHeaderid" id="headerid" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <script>
                $(document).ready(function(){
                    $('#firoBtest').dataTable();
                    $('#firoBtest').click(function(){
                    $('.panel-heading').hide();
                    $('.panel-body').hide();
                    });
                });
            </script>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div style="padding: 5px;"></div>
                        <table class="table table-hover table-striped table table-striped table-hover table-bordered" id="firoBtest">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">Header ID</th>
                                    <th style="text-align: center;">Name</th>
                                    <th style="text-align: center;">Tanggal Lahir</th>
                                    <th style="text-align: center;">Pendidikan Terakhir</th>
                                    <th style="text-align: center;">Jenis Kelamin</th>
                                    <th style="text-align: center;">Departemen Tujuan</th>
                                    <th style="text-align: center;">Jadwal Tes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    foreach ($list as $get) { ?>
                                        <tr onclick="pilih(this.id)" id="<?php echo $get->CalonPelamarID ?>" style="cursor: pointer;">
                                            <td class="text-center"><?php echo $get->CalonPelamarID; ?></td>
                                            <td><?php echo $get->Nama; ?></td>
                                            <td class="text-center"><?php echo date('d-M-Y',strtotime($get->TanggalLahir)) ?></td>
                                            <td class="text-center"><?php echo $get->Pendidikan; ?></td>
                                            <td class="text-center"><?php echo $get->JenisKelamin; ?></td>
                                            <td class="text-center"><?php echo $get->DeptAbbr; ?></td>
                                            <td class="text-center"><?php echo $get->JadwalTes; ?></td>
                                        </tr>
                                        <?php
                                    }
                                ?>
                            </tbody>
                        </table>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">User Firo B</h4>
            </div>
            <div class="modal-body">
                <div id="lihat_detail" class="well">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Find By Nama/ID </label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="txtFindBy" id="FindByName" required="" placeholder="Input ID">
                        </div>
                        <button type="button" id="btnCari" class="btn btn-sm btn-success" style="background-color: #105183 !important; border-color: #105183;" onclick="callAjax();"> 
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
                                    <th class="textarea">Organization</th>
                                    <th class="text-center">Education</th>
                                    <th class="text-center">Gender</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
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
                url: "<?php echo base_url('PsychologicalAssisment/getKaryawanFiro')?>"+"/"+Nama,
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
        var nama = $('#Nama').val();
        // alert(nama);
        if(nama != ''){
            $.ajax({
                type: "POST",
                url : "<?php echo site_url('PsychologicalAssisment/getNamaFiro')?>",
                data: {
                    'nama' : nama
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
                url : "<?php echo site_url('PsychologicalAssisment/getNamaFiro')?>"+"/"+id,
                success: function(msg){
                    $('#ajaxFormHeader').html(msg);
                }
            });
        }
    };
</script>
<script type="text/javascript">
    $('#expressedAffection, #expressedControl, #expressedInclusion').on('change',function(){
        var a = document.getElementById('expressedInclusion').value;
        var b = document.getElementById('expressedControl').value;
        var c = document.getElementById('expressedAffection').value;
        var total = parseInt(a) + parseInt(b) + parseInt(c);
        document.getElementById('totalExpressed').value = total;
    });
    $('#wantedAffection, #wantedControl, #wantedInclusion').on('change',function(){
        var a = document.getElementById('wantedInclusion').value;
        var b = document.getElementById('wantedControl').value;
        var c = document.getElementById('wantedAffection').value;
        var total = parseInt(a) + parseInt(b) + parseInt(c);
        document.getElementById('wantedExpressed').value = total;
    });
    $('#expressedInclusion, #wantedInclusion').on('change',function(){
        var a = document.getElementById('wantedInclusion').value;
        var b = document.getElementById('expressedInclusion').value;
        var total = parseInt(a) + parseInt(b);
        document.getElementById('totalInclusion').value = total;
    });
    $('#wantedControl, #expressedControl').on('change',function(){
        var a = document.getElementById('expressedControl').value;
        var b = document.getElementById('wantedControl').value;
        var total = parseInt(a) + parseInt(b);
        document.getElementById('totalControl').value = total;
    });
    $('#wantedAffection, #expressedAffection').on('change',function(){
        var a = document.getElementById('expressedAffection').value;
        var b = document.getElementById('wantedAffection').value;
        var total = parseInt(a) + parseInt(b);
        document.getElementById('totalAffection').value = total;
    });
    $('#expressedControl, #expressedInclusion, #expressedAffection, #wantedInclusion, #wantedControl, #wantedAffection').on('change',function(){
        var a = document.getElementById('expressedInclusion').value;
        var b = document.getElementById('expressedControl').value;
        var c = document.getElementById('expressedAffection').value;
        var d = document.getElementById('wantedInclusion').value;
        var e = document.getElementById('wantedControl').value;
        var f = document.getElementById('wantedAffection').value;
        var total = parseInt(a) + parseInt(b) + parseInt(c) + parseInt(d) + parseInt(e) + parseInt(f);
        document.getElementById('overall').value = total;
    });
</script>