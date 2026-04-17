    <div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title">LIST OF PSYCHOLOGICAL TEST</h4>

                <div class="widget-toolbar">
                    <a href="#" data-action="collapse"><i class="ace-icon fa fa-chevron-up"></i></a>
                </div>
                <div class="widget-toolbar no-border">
                </div>
            </div>
            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- alert -->
                            <?php if($this->input->get('msg') == "success"){
                                echo "<div class='alert alert-success'>";
                                echo "<strong>Sukses !!!</strong> Data berhasil disimpan.";
                                echo "</div>";
                            }elseif($this->input->get('msg') == "failed"){
                                echo "<div class='alert alert-danger'>";
                                echo "<strong>Gagal !!!</strong> Maaf Masih Ada Memo Yang belum Terpenuh,Data Tidak Dapat di Simpan .!!";
                                echo "</div>";
                            } ?> 
                            <form class="form-horizontal" role="form" method="POST" action="">
                            
                            </form>
                        </div>
                    </div>
                           
                </div>
            </div>
        </div>
    </div>
</div>