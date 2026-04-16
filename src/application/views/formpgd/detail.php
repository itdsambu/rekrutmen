<h4 class="row header smaller lighter blue">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-info-circle"></i>
        Approval oleh Pemohon, Pimpinan dept, Pimpinan PKK, PSN
    </span>
</h4>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Approval</th>
                <th><i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Approved By</th>
                <th><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Approved Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $row): ?>
            <tr>
                <td>Pemohon</td>
                <!-- <td><?php echo $row->PemohonApproval;?></td> -->
                <td>
                    <?php if(($row->PemohonStatus == 1) OR ($row->PemohonStatus == 2)){
                        echo $row->NAMA;
                    } else {
                        echo '';
                    }?>
                </td>
                <td><?php echo $row->PemohonDate;?></td>
                <td>
                    <?php if($row->PemohonStatus == 1):?>
                    <span class="label label-sm label-success">Disetujui</span>
                    <?php elseif($row->PemohonStatus == 2):?>
                    <span class="label label-sm label-danger">Ditolak</span>
                    <?php else:?>
                    <span class="label label-sm label-warning">Pending</span>
                    <?php endif;?>
                </td>
            </tr>    
            <tr>
                <td>PIMPINAN DEPT</td>
                <td><?php echo $row->DEPTApproval;?></td>
                <td><?php echo $row->DEPTDate;?></td>
                <td>
                    <?php if($row->DEPTStatus == 1):?>
                    <span class="label label-sm label-success">Disetujui</span>
                    <?php elseif($row->DEPTStatus == 2):?>
                    <span class="label label-sm label-danger">Ditolak</span>
                    <?php else:?>
                    <span class="label label-sm label-warning">Pending</span>
                    <?php endif;?>
                </td>
            </tr>
            <tr>
                <td>PIMPINAN PPK</td>
                <td><?php echo $row->PemborongApproval;?></td>
                <td><?php echo $row->PemborongDate;?></td>
                <td>
                    <?php if($row->PemborongStatus == 1):?>
                    <span class="label label-sm label-success">Disetujui</span>
                    <?php elseif($row->PemborongStatus == 2):?>
                    <span class="label label-sm label-danger">Ditolak</span>
                    <?php else:?>
                    <span class="label label-sm label-warning">Pending</span>
                    <?php endif;?>
                </td>
            </tr>
            <tr>
                <td>PSN-PSG</td>
                <td><?php echo $row->PSNApproval;?></td>
                <td><?php echo $row->PSNDate;?></td>
                <td>
                    <?php if($row->PSNStatus == 1):?>
                    <span class="label label-sm label-success">Disetujui</span>
                    <?php elseif($row->PSNStatus == 2):?>
                    <span class="label label-sm label-danger">Ditolak</span>
                    <?php else:?>
                    <span class="label label-sm label-warning">Pending</span>
                    <?php endif;?>
                </td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<h4 class="row header smaller lighter blue">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-info-circle"></i>
        Keterangan lainnya
    </span>
</h4>
<div class="table-responsive">
    <table class="table table-striped">
        <?php foreach ($data as $row):?>
        <tr>
            <th class="col-sm-2">NAMA</th>
            <td>
                <?php echo $row->NAMA;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">NIK</th>
            <td>
                <?php echo $row->NIK;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">DEPARTEMEN</th>
            <td>
                <?php echo $row->DeptAbbr;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">JABATAN</th>
            <td>
                <?php echo $row->Jabatan;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">PERUSAHAAN/CV</th>
            <td>
                <?php echo $row->Perusahaan;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">PEMBORONG</th>
            <td>
                <?php echo $row->Pemborong;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">TANGGAL MASUK KERJA</th>
            <td>
                <?php echo $row->TglMasuk;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">MESS/BLOK</th>
            <td>
                <?php echo $row->Alamat;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">TANGGAL KELUAR</th>
            <td>
                <?php echo $row->TglKeluar;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">KETERANGAN</th>
            <td>
                <?php echo $row->Keterangan;?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
</div>
