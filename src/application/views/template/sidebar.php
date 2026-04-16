<div id="sidebar" class="sidebar responsive ace-save-state">
    <script type="text/javascript">
        try {
            ace.settings.check('sidebar', 'fixed')
        } catch (e) {}
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
        <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
            <button class="btn btn-primary btn-white">
                <i class="ace-icon fa fa-signal red"></i>
            </button>
            <button class="btn btn-primary btn-white">
                <i class="ace-icon fa fa-pencil blue"></i>
            </button>
            <button class="btn btn-primary btn-white">
                <i class="ace-icon fa fa-users green"></i>
            </button>
            <button class="btn btn-primary btn-white">
                <i class="ace-icon fa fa-cogs"></i>
            </button>
        </div>

        <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
            <span class="btn btn-success"></span>

            <span class="btn btn-info"></span>

            <span class="btn btn-warning"></span>

            <span class="btn btn-danger"></span>
        </div>
    </div>

    <ul class="nav nav-list">
        <li class="active">
            <a href="<?php echo base_url(); ?>">
                <i class="menu-icon fa fa-tachometer"></i>
                <span class="menu-text"> Dashboard </span>
            </a>
            <b class="arrow"></b>
        </li>

        <?php foreach ($_getMenu1 as $row1) : ?>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <?php echo $row1->MenuIcon; ?>
                    <span class="menu-text"><?php echo $row1->MenuLabel; ?></span>
                    <b class="arrow fa fa-angle-down"></b>
                </a>
                <b class="arrow"></b>

                <ul class="submenu">
                    <?php foreach ($_getMenu2 as $row2) : ?>
                        <?php if ($row2->MenuHeader === $row1->MenuID) : ?>
                            <li class="">
                                <?php if ($row2->MenuLink == '#') {
                                    echo "<a href='" . site_url($row2->MenuLink) . "' class='dropdown-toggle'>";
                                } else {
                                    echo "<a href='" . site_url($row2->MenuLink) . "' >";
                                } ?>
                                <?php echo $row2->MenuIcon; ?>
                                <?php echo $row2->MenuLabel; ?>
                                </a>
                                <b class="arrow fa fa-angle-down"></b>

                                <ul class="submenu">
                                    <?php foreach ($_getMenu3 as $row3) : ?>
                                        <?php if ($row3->MenuHeader === $row2->MenuID) : ?>
                                            <li class="">
                                                <a href="<?php echo site_url($row3->MenuLink); ?>">
                                                    <?php echo $row3->MenuIcon; ?>
                                                    <?php echo $row3->MenuLabel; ?>
                                                </a>
                                                <b class="arrow"></b>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </ul>

                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            </li>
        <?php endforeach; ?>


    </ul>
    <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse" style="z-index: 1;">
        <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
    </div>

</div>