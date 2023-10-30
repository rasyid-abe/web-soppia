<header class="main-header">
  <!-- Logo -->
  <a href="<?=base_url('dashboard')?>" class="logo">

    <img src="<?=base_url('assets/images/soppia.png')?>" width="30px" style="float:left;margin:10px -80px 0px -4px">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <!--span class="logo-mini"><b>Y</b>PIA</span-->
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b><?=$this->config->item("appname")?></b> YPIA</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </a>

    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <?php
            if(countnotif($this->session->userdata("username"),'pembukaanpeserta') > 0){
        ?>
        <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning"><?=countnotif($this->session->userdata("username"),'pembukaanpeserta')?></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                    <?php
                        if(countnotif($this->session->userdata("username"),'pembukaanpeserta') > 0){
                    ?>
                      <li>
                        <a href="<?=base_url("peserta/pembukaan-kunci-entry")?>" title="<?=countnotif($this->session->userdata("username"),'pembukaanpeserta')?> data peserta terkunci dan perlu diperiksa"><?=countnotif($this->session->userdata("username"),'pembukaanpeserta')?> data peserta terkunci dan perlu diperiksa
                        </a>
                      </li>
                    <?php
                        }
                    ?>
                </ul>
              </li>
            </ul>
        </li>
        <?php 
            }
        ?>
        <li><a href="<?=base_url("logout")?>" class="link-ajax-p" style="padding:15px;text-align: center"><i class="fa fa-power-off"></i></a></li>
      </ul>
    </div>
  </nav>
</header>