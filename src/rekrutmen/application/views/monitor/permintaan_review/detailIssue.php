<h4 class="row header smaller lighter blue">
    <span class="col-sm-12">
        <i class="ace-icon fa fa-info-circle"></i>
        Approval oleh Department, Divisi, Personalia, AGM dan VGM
    </span>
</h4>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Approval</th>
                <th><i class="ace-icon fa fa-user bigger-110 hidden-480"></i> Approved By</th>
                <th><i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i> Approved Date</th>
                <th>Keputusan</th>
                <th>Other Information</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($getTran as $row): ?>
            <tr>
                <td>Department</td>
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
                <td><?php echo $row->DEPTRemark;?></td>
            </tr>
            <tr>
                <td>Divisi</td>
                <td><?php echo $row->DIVISIApproval;?></td>
                <td><?php echo $row->DIVISIDate;?></td>
                <td>
                    <?php if($row->DIVISIStatus == 1):?>
                    <span class="label label-sm label-success">Disetujui</span>
                    <?php elseif($row->DIVISIStatus == 2):?>
                    <span class="label label-sm label-danger">Ditolak</span>
                    <?php else:?>
                    <span class="label label-sm label-warning">Pending</span>
                    <?php endif;?>
                </td>
                <td><?php echo $row->DIVISIRemark;?></td>
            </tr>
            <tr>
                <td>Personalia</td>
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
                <td><?php echo $row->PSNRemark;?></td>
            </tr>
            <tr>
                <td>AGM</td>
                <td><?php echo $row->AGMApproval;?></td>
                <td><?php echo $row->AGMDate;?></td>
                <td>
                    <?php if($row->AGMStatus == 1):?>
                    <span class="label label-sm label-success">Disetujui</span>
                    <?php elseif($row->AGMStatus == 2):?>
                    <span class="label label-sm label-danger">Ditolak</span>
                    <?php else:?>
                    <span class="label label-sm label-warning">Pending</span>
                    <?php endif;?>
                </td>
                <td><?php echo $row->AGMRemark;?></td>
            </tr>
            <tr>
                <td>VGM</td>
                <td><?php echo $row->VGMApproval;?></td>
                <td><?php echo $row->VGMDate;?></td>
                <td>
                    <?php if($row->VGMStatus == 1):?>
                    <span class="label label-sm label-success">Disetujui</span>
                    <?php elseif($row->VGMStatus == 2):?>
                    <span class="label label-sm label-danger">Ditolak</span>
                    <?php else:?>
                    <span class="label label-sm label-warning">Pending</span>
                    <?php endif;?>
                </td>
                <td><?php echo $row->VGMRemark;?></td>
            </tr>
            <?php endforeach; ?>
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
        <?php foreach ($getTran as $row):?>
        <tr>
            <th class="col-sm-2">Ketentuan</th>
            <td>
                <?php echo $row->IssueRemark;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">Batasan Umur</th>
            <td>
                <?php echo $row->Umur;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">Pedidikan</th>
            <td>
                <?php echo $row->Pendidikan;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">Jurusan</th>
            <td>
                <?php echo $row->Jurusan;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">Gender</th>
            <td>
                <?php echo $row->JenisKelamin;?>
            </td>
        </tr>
        <tr>
            <th class="col-sm-2">Status Pernikahan</th>
            <td>
                <?php echo $row->StatusPersonal;?>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
</div>
