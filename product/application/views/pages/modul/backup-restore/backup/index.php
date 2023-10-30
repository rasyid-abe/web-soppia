<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net/buttons.dataTables.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")?>">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$titlepage?>
    <small><?=$subtitlepage?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a><?=$breadcrumb2?></a></li>
    <li class="active"><?=$breadcrumb3?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <?php if($this->session->flashdata('error')){ ?>
    <br>
    <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
  <?php }else if($this->session->flashdata('success')){ ?>
    <br>
    <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
  <?php } ?>

  <!-- Default box -->
  <div class="box" style="border-top:0px solid">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$titlebox?></h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
       
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="<?=base_url("backupproses/files")?>">
            <div class="small-box bg-aqua">
              <div class="inner">
                <h4>Backup</h4>
                <p>Backup Files</p><br>
              </div>
              <div class="icon">
                <i class="fa fa-archive"></i>
              </div>
            </div>
          </a>
        </div>
       
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <a href="<?=base_url("backupproses/db")?>">
            <div class="small-box bg-aqua">
              <div class="inner">
                <h4>Backup</h4>
                <p>Backup Database</p><br>
              </div>
              <div class="icon">
                <i class="fa fa-database"></i>
              </div>
            </div>
          </a>
        </div>

      </div>
    </div>

  </div>

</section>


<script type="text/javascript">  
  $(function () {
  })  
</script>