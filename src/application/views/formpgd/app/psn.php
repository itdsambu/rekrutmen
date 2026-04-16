<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/checkboxall.js"></script> -->
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/components.css">
<link rel="stylesheet" type="text/css" href="<?= base_url()?>assets/css/core.css">
<?php
    $this->load->view('template/sweetAlert');
    $this->load->view('template/formPicker');
    $this->load->view('template/formValidation');
?>
<div class="page-header">
    <h1>
        Approval
        <small>
            <i class="ace-icon fa fa-angle-double-right"></i>
            Approval PGD By Personalia
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><b> List Tenaga Kerja PGD</b></div>
            <div class="panel-body">
                <?php
                if($this->input->get('msg') == 'success_approve'){
                    echo "<p class='alert alert-info'><button type='button' class='close' data-dismiss='alert'>
                    <i class='ace-icon fa fa-times'></i></button>Data berhasil diapprove.</p>";
                }elseif ($this->input->get('msg') == 'failed_approve') {
                    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
                    <i class='ace-icon fa fa-times'></i></button>Maaf, data anda tidak memiliki akses approve.</p>";
                }elseif ($this->input->get('msg') == 'failed') {
                    echo "<p class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'>
                    <i class='ace-icon fa fa-times'></i></button>Maaf, data gagal diapprove.</p>";
                }elseif ($this->input->get('msg') == 'success') {
                    echo "<p class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>
                    <i class='ace-icon fa fa-times'></i></button>Selamat, data berhasil diapprove.</p>";
                }
                ?>
                <div class="col-sm-12">
                    <form id="formpgd" class="form-horizontal" role="form" method="POST">
                        <input type="hidden" name="txtregno" id="idregno" readonly value="<?= $_getdata['regno']?>">
                        <input type="hidden" name="txtnik" id="idnik" readonly value="<?= $_getdata['nik']?>">
                        <input type="hidden" name="txtnama" id="idnama" readonly value="<?= $_getdata['nama']?>">
                        <input type="hidden" name="txtjabatan" id="idjabatan" readonly value="<?= $_getdata['jabatan']?>">
                        <table id="dataTables-listTK" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th style="vertical-align: middle; text-align: center;">
                                        <input type="checkbox" class="chk-head"><label></label>
                                    </th>
                                    <th>No</th>
                                    <th>NIK</th>
                                    <th>NAMA</th>
                                    <th>PEMBORONG</th>
                                    <th>CV/PERUSAHAAN</th>
                                    <th>DEPT/BAG</th>
                                    <th>JABATAN</th>
                                    <th>TANGGAL KELUAR</th>
                                    <th>KETERANGAN</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($getdata)){?>
                                <tr>
                                    <td class="text-center" colspan="10">Data Masih Kosong</td>
                                </tr>
                                <?php } else {
                                    $no=1;
                                    foreach ($getdata as $r) {
                                ?>
                                <tr>
                                    <td style="vertical-align: middle; text-align: center;">
                                        <div class="mk-trc" data-style="check" data-text="true">
                                            <input name="chkNIK[]" type="checkbox" value="<?= $r->NIK?>" class="chk-child" >
                                            <label></label>
                                        </div>
                                    </td>
                                    <td><?php echo $no++;?></td>
                                    <td><?php echo trim($r->NIK);?></td>
                                    <td><?php echo $r->NAMA;?></td>
                                    <td><?php echo $r->Pemborong;?></td>
                                    <td><?php echo $r->Perusahaan;?></td>
                                    <td><?php echo $r->DeptAbbr;?></td>
                                    <td><?php echo $r->Jabatan;?></td>
                                    <td><input type="hidden" name="txtTglkeluar[]" id="Tglkeluar" value="<?= $r->TglKeluar?>"><?php echo date('d-m-Y',strtotime($r->TglKeluar));?></td>
                                    <td><input type="hidden" name="txtKeterangan[]" id="Keterangan" value="<?= $r->Keterangan?>"><?php echo $r->Keterangan;?></td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
                <div class="col-sm-12">
                    <div class="well text-center">
                        <input type="button" id="btnApprovePSNPGD" value="Approve" name="Submit" class="btn btn-success" >
                        <input type="button" id="btnRejectPSNPGD" value="Decline" name="Submit" class="btn btn-danger" >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var urlApprovePSNMulti = '<?= base_url() ?>Suratpgd/approvekonfirmasikontrakPSNMulti',
        urlRejectePSNMulti = '<?= base_url() ?>Suratpgd/rejectkonfirmasikontrakPSNMulti';
</script>
<script type="text/javascript">
    $('.chk-head').click(function(){
        var th_checked =this.checked;
        if(th_checked){ $('.chk-child').prop('checked',true);}
        else{ $('.chk-child').prop('checked',false);}
    });
    $('#tbl').click(function(){
        var get = document.getElementsByClassName('chk-child');
        var con = 0;
        for(i=0;i<get.lenght;i++){
            con += get[i].checked;
        }
        if(con === get.lenght && get.lenght > 0){ $('.chk-head').prop('checked',true);}
        else{ $('chk-head').prop('checked',false);}
    });

    $('#btnApprovePSNPGD').click(function(){
        $("#formpgd").attr('action', urlApprovePSNMulti);
        swal({
            title: "Approve data ?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function(isConfirm){
            if(isConfirm){
                $("#formpgd").submit();
            }
            $("#formpgd").attr('action',"");
        });
    });

    $('#btnRejectPSNPGD').click(function(){
        $("#formpgd").attr('action', urlRejectePSNMulti);
        swal({
            title: "Reject data ?",
            type: "info",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
            closeOnConfirm: true
        }, function(isConfirm){
            if(isConfirm){
                $("#formpgd").submit();
            }
            $("#formpgd").attr('action',"");
        });
    });
</script>