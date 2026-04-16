<div class="row">
    <div class="col-lg-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">MBTI TEST</h4>
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
            <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('PsychologicalAssisment/simpanDataMbti')?>">
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
                    $('#Mbtitest').dataTable();
                    $('#Mbtitest').click(function(){
                    $('.panel-heading').hide();
                    $('.panel-body').hide();
                    });
                });
            </script>
            <div class="panel panel-default">
                <div class="panel-body">
                    <div style="padding: 5px;"></div>
                        <table class="table table-hover table-striped table table-striped table-hover table-bordered" id="Mbtitest">

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
<div class="modal fade" id="myModal" tabindex="-2" role="dialog" aria-labelledby="view" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">MBTI Test</h4>
            </div>
            <div class="modal-body">
                <div id="lihat_detail" class="well">
                    <div class="form-group">
                        <label class="col-lg-2 control-label">Find By Nama/ID </label>
                        <div class="col-lg-5">
                            <input type="text" class="form-control" name="txtFindBy" id="FindByName" required="" placeholder="Find By Name Or ID">
                        </div>
                        <button type="button" id="btnCari" class="btn btn-sm btn-success" style="background-color: #8B008B !important; border-color: #8B008B;" onclick="callAjax();"> 
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
                                    <th class="text-center">Jenis Kelamin</th>
                                    <th class="text-center">Jabatan</th>
                                    <th class="text-center">Pendidikan Terakhir</th>
                                    <th class="text-center">Perusahaan</th>
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
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function callAjax(){
        var Nama = $('#FindByName').val();
         //alert(Nama);

        if(Nama == ''){
            alert('Data Tidak Boleh Kosong');
        }else{
            $.ajax({
                type: "GET",
                dataType: "html",
                url: "<?php echo base_url('PsychologicalAssisment/getKaryawanMbti')?>"+"/"+Nama,
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
         //alert(id); 
        if(id != ''){
            $.ajax({
                type: "POST",
                url : "<?php echo site_url('PsychologicalAssisment/getNamaMbti')?>",
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
                url : "<?php echo site_url('PsychologicalAssisment/getNamaMbti')?>"+"/"+id,
                success: function(msg){
                    $('#ajaxFormHeader').html(msg);
                }
            });
        }
    };
</script>