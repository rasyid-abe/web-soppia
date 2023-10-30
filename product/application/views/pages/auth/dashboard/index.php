<!-- Content Header (Page header) -->
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net/buttons.dataTables.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")?>">
<section class="content-header">
  <h1>
    <?=$titlepage?>
    <small><?=$subtitlepage?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li class="active"><?=$breadcrumb2?></li>
  </ol>
</section>

    <!-- Main content -->
    <section class="content">
      <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <?php
                $data = $this->db->query("select * from mst_peserta");
              ?>
              <span class="info-box-text">Jumlah Peserta</span>
              <span class="info-box-number"><?=$data->num_rows()?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <?php
                $data2 = $this->db->query("select * from mst_pershinstansi");
              ?>
              <span class="info-box-text">Jumlah Instansi</span>
              <span class="info-box-number"><?=$data2->num_rows()?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <?php
                $data3 = $this->db->query("select * from mst_instruktur");
              ?>
              <span class="info-box-text">Jumlah Instruktr</span>
              <span class="info-box-number"><?=$data3->num_rows()?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-book-outline"></i></span>

            <div class="info-box-content">
              <?php
                $data4 = $this->db->query("select * from mst_materi_n_aktifitas");
              ?>
              <span class="info-box-text">Jumlah Materi</span>
              <span class="info-box-number"><?=$data4->num_rows()?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <!-- Main row -->
      <div class="row">

        <?php if(accessperm('melihat-log-akses')){ ?>
        <div class="col-md-12">
          <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">History Aktifitas User</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
              </div>
            </div>

            <!-- /.box-header -->
            <div class="box-body">

              <div class="table-responsive">

                <table class="table table-bordered table-striped dt-table" style="width: 100%">
                  <thead>
                  <tr>
                    <th>Username</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Aktifitas</th>
                  </tr>
                  </thead>
                  <tbody>
                                    
                  </tbody>
                </table>

              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <?php }?>        
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->


<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/dataTables.buttons.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.flash.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jszip.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/pdfmake.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/vfs_fonts.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.html5.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.print.min.js")?>"></script>

<script type="text/javascript">  
  $(function () {
    $.ajaxSetup({
      data: {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      }
    });

    <?php if(accessperm('melihat-log-akses')){ ?>
    $('table.dt-table').DataTable({
      "responsive": true,
      "processing": true, 
      "serverSide": true, 
      "order": [],       
      "ajax": {
        "url": "<?php echo site_url($this->uri->segment(1).'/getdata')?>",
        "type": "POST",        
        "dataSrc": function ( json ) {
            $(document).CsrfAjaxGet();
            return json.data;
        } 
      },
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    });
    <?php } ?>
  })  
</script>