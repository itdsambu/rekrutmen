<?php if(($this->session->userdata('dept') == 'PSN') || ($this->session->userdata('dept') == 'ITD')):?>
<!-- <?php if ($this->session->userdata('dept') == 'ITD') {
echo '<script language="javascript">';
echo 'alert("Modul Sedang Perbaikan !!")';
echo '</script>';
} ?>  -->
<div class="page-header">
    <h1>
        Data List Tenaga Kerja
    </h1>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">List Tenaga Kerja Aktif</h4>
                 <div class="widget-toolbar no-border">
                    <button class="btn btn-minier btn-success" id="btnExport">
                        <i class="ace-icon fa fa-file-excel-o bigger-120"></i> Export to Excel
                    </button>
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-xs-12">
                        </div>
                    <form class="form-horizontal" role="form" method="POST" action="<?php echo base_url('datakaryawan/filterdata');?>">
                        <div class="col-xs-12 col-sm-4">
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Status KTP</label>
                                <div class="col-sm-8">
                                    <select name="txtStatusKtp" id="inputStatusKtp" class="form-control input-sm">
                                        <option value="0" <?php if ($_selected == 0) { echo 'selected';} ?>>All Data Tenaga Kerja</option>
                                        <option value="1" <?php if ($_selected == 1) { echo 'selected';} ?>>Data Tenaga Kerja Registered</option>
                                        <option value="2" <?php if ($_selected == 2) { echo 'selected';} ?>>Data Tenaga Kerja Unregistered</option>
                                        option
                                    </select>
                                </div>
                                <script>
                                    $('#inputStatusKtp').change( function (){
                                        var val = this.value;
                                        window.location = '<?php echo site_url();?>datakaryawan/listuploadktp/'+val;
                                    });
                                </script>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">No. Fix</label>
                                <div class="col-sm-8">
                                    <input name="txtNofix" id="inputNofix" type="number" class="form-control input-sm" autocomplete="off" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label no-padding-right">Departemen</label>
                                <div class="col-sm-8">
                                    <select name="txtDept" id="inputDept" class="form-control input-sm">
                                        <option value="">- Pilih Departemen -</option>
                                        <?php foreach ($all_dept as $dept) { ?>
                                            <option value="<?php echo $dept->IDDept; ?>" <?php if ($_selectedDept == $dept->IDDept) { echo 'selected';} ?>><?php echo $dept->DeptAbbr; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-1">
                            <div class="form-group">
                                <input name="btnCari" id="inputcari" type="submit" value="Refresh" class="btn btn-mini btn-block" />
                            </div>
                        </div>
                    </form>
                        <br>
                        <br>
                        <br>
                        <div id="data" class="col-xs-12 table-responsive">
                            <table <?php if (!empty($_selectWhere)) {echo 'id="myTable"';} ?> class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="excludeExport">FixNo</th>
                                        <th>Departemen</th>
                                        <th>NAMA</th>
                                        <th>TEMPAT/TANGGAL LAHIR</th>
                                        <th class="excludeExport">NO KTP RO</th>
                                        <th class="excludeExport">NO KTP PAYBORO</th>
                                        <th>FILE KTP</th>
                                        <th class="excludeExport">Registered By RO</th>
                                        <th class="excludeExport">ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if($_selectWhere == NULL){
                                    echo '<tr><td colspan="9" class="text-center">Tidak Ada Data !!</td></tr>';
                                    }else ?>
                                <?php
                                 foreach($_selectWhere as $row):
                                    if ($row->KTP != '' || $row->KTP != null) {
                                        $KTP = $row->KTP;
                                    } else {
                                        $KTP = 'undefined';
                                    }
                                    $style_notif2 = "";
                                    if($_selected == 0) {
                                        if ($row->HeaderID != null && file_exists(FCPATH . ''.str_replace("./", "", $KTP).'')) {
                                            $checkktp = 'File KTP Tersedia';
                                        } else if ($row->HeaderID == null && file_exists(FCPATH . 'dataupload/berkas/ktp_fixno/2_'.$row->FixNo.'_ktp.pdf')) {
                                            $checkktp = 'File KTP Tersedia';
                                        } else {
                                            $checkktp = 'File KTP Tidak Tersedia';
                                            $style_notif2  = 'style="background: red"';
                                        }

                                        //Is-register
                                        if ($row->HeaderID != '') {
                                            $is_registered = 'Registered';
                                        } else {
                                            $is_registered = 'Unregistered';
                                        }
                                    } else if ($_selected == 1) {
                                        if (file_exists(FCPATH . ''.str_replace("./", "", $KTP).'')) {
                                            $checkktp = 'File KTP Tersedia';
                                        } else {
                                            $checkktp = 'File KTP Tidak Tersedia';
                                            $style_notif2 = 'style="background: red"';
                                        }
                                        $is_registered = 'Registered';
                                    } else if($_selected == 2) {
                                        if (file_exists(FCPATH.'dataupload/berkas/ktp_fixno/2_'.$row->FixNo.'_ktp.pdf')) {
                                            $checkktp = 'File KTP Tersedia';
                                        } else {
                                            $checkktp = 'File KTP Tidak Tersedia';
                                            $style_notif2 = 'style="background: red"';
                                        }
                                        $is_registered = 'Unregistered';
                                    } else {
                                        $checkktp = "NULL";
                                        $is_registered = 'NULL';
                                    }
                                    $style_notif = "";
                                    if (TRIM($row->ro_ktp) != TRIM($row->boro_ktp)) {
                                        $style_notif = 'style="background: yellow"';
                                    }
                                  ?>
                                    <tr class="info" data-id="<?php echo $row->HeaderID?>">
                                        <!-- <td><?php echo $row->ROW?></td>  -->
                                        <td class="fixno excludeExport"><?php echo $row->FixNo?></td>
                                        <td><?php echo $row->DeptAbbr?></td>
                                        <td class="nama"><?php echo $row->nama?></td>
                                        <td><?php echo $row->tempatlahir . ", " . date('d-M-Y', strtotime($row->tgllahir))?></td>
                                        <td class="excludeExport" <?= $style_notif ?>><?php echo $row->ro_ktp ?></td>
                                        <td class="excludeExport" <?= $style_notif ?>><?php echo $row->boro_ktp ?></td>
                                        <td <?= $style_notif2 ?> class="status_ktp"><?php echo $checkktp; ?></td>
                                        <td class="excludeExport"><?= $is_registered; ?></td>
                                        <td class="text-left excludeExport">
                                            <div class="btn-group">
                                                <a title="Lihat KTP" data-rel="tooltip" href="#" class="detail_ktp btn btn-minier btn-round btn-primary">
                                                    <i class="ace-icon fa fa-files-o bigger-100"></i> Lihat KTP
                                                </a>
                                                <a title="Upload KTP" data-rel="tooltip" href="<?php echo site_url
                                                    ('datakaryawan/doUploadKTP')."?id=".$row->HeaderID."&nama=".$row->nama."&fixno=".$row->FixNo; ?>" class="upload_ktp btn btn-minier btn-round btn-success">
                                                    <i class="ace-icon fa fa-upload"></i> Upload KTP
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                </tbody>
                                <tbody>
                                    <?php ?>
                                    <tr>
                                        <td colspan="9" class="center"><?php echo $_pagination;?></td>
                                    </tr>
                                </tbody>    
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header"> <!--style="background-color: #008cba">-->                
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 id="titleModal" class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="inputdetail" name="iddetail">
                <div id="show_detailktp" class="well">
                        <!--load tabel dari file detail.php melalui javascript-->
                </div>
            </div>
            <div class="modal-footer">              
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<script src="http://192.168.3.5/rekrutmen/assets/js/dataTables/jquery.dataTables.js"></script>
<script src="http://192.168.3.5/rekrutmen/assets/js/dataTables/jquery.dataTables.bootstrap.js"></script>
<script src="http://192.168.3.5/rekrutmen/assets/js/dataTables/extensions/TableTools/js/dataTables.tableTools.js"></script>
<script src="http://192.168.3.5/rekrutmen/assets/js/dataTables/extensions/ColVis/js/dataTables.colVis.js"></script>
<script type="text/javascript" src="http://192.168.3.5/rekrutmen/assets/jqv/jquery.tablesorter.min.js"></script>
<script>
    function tableToExcel(table, sheetName, fileName) {

        var uri = 'data:application/vnd.ms-excel;base64,',
            templateData = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta http-equiv="content-type" content="text/plain; charset=UTF-8"/></head><body><table>{table}</table></body></html>',
            base64Conversion = function (s) { return window.btoa(unescape(encodeURIComponent(s))) },
            formatExcelData = function (s, c) { return s.replace(/{(\w+)}/g, function (m, p) { return c[p]; }) }

        $("tbody > tr[data-level='0']").show();

        if (!table.nodeType)
            table = document.getElementById(table)

        var ctx = { worksheet: sheetName || 'Worksheet', table: table.innerHTML }

        var element = document.createElement('a');
        element.setAttribute('href', 'data:application/vnd.ms-excel;base64,' +
        base64Conversion(formatExcelData(templateData, ctx)));
        element.setAttribute('download', fileName);
        element.style.display = 'none';
        document.body.appendChild(element);
        element.click();
        document.body.removeChild(element);

        $("tbody > tr[data-level='0']").hide();
    }
    $(document).ready(function(){
        $("#btnExport").click(function() {
            var tempTable = $("#myTable").html();

            $("#myTable .excludeExport").remove();
            tableToExcel("myTable", "Sheet 1", "KTP Harian");

            $("#myTable").html(tempTable);
        });
        // $("myTable").tablesorter();
         $('#myTable').DataTable({
            "aaSorting": [[ 6, "desc" ]],
            
            "pageLength": 500,
            "lengthMenu": [10,25,50,100,500]
        });
        $('[data-rel=tooltip]').tooltip();

        $("#myTable").on("click", ".detail_ktp", function() {
            var id = $(this).closest('tr').data('id');
            var name = "KTP";
            var tk = $(this).closest('tr').find(".nama").text().trim();
            var fixnoid = $(this).closest('tr').find(".fixno").text().trim();
                
                document.getElementById('titleModal').textContent = "File "+name+" dari saudara, "+tk+"";
                $.ajax({
                    url:"<?php echo site_url('datakaryawan/viewDocs');?>",
                    type:"POST",
                    data:"kode="+id+"&nama="+name+"&fixno="+fixnoid,
                    datatype:"json",
                    cache:false,
                    success:function(msg){
                        // if (id === null || id === "") {
                        //     $("#show_detailktp").html('Reg ID Tidak Tersedia').css('text-align', 'center');
                        // } else {
                            $("#show_detailktp").html(msg);
                        // }
                    }               
                });
            $("#viewModal").modal("show");
        });
    })
</script>

<!-- <script>
    $(document).ready(function(){
        $("myTable").dataTable({"order":[[0,'asc']]
    });
    });
</script> -->
<?php else:?>
<div class="center">
    <span class="red">ANDA TIDAK MEMILIKI AKSES UNTUK FORM INI !!!</span>
</div>
<?php endif;?>