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
  
  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab"><b>Kelas QIA</b></a></li>
      <li><a href="#tab_2" data-toggle="tab"><b>Kelas Non QIA</b></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
        <!-- Default box -->
          <div class="box" style="border-top:0px solid">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$titlebox?> QIA</h3>
              <div class="box-tools pull-right">
                <!--<?php if(accessperm('menambahkan-data-riwayat-kelas-peserta')){ ?>
                  <a href="<?=base_url(uri_string()."/add")?>" class="btn btn-box-tool" data-toggle="tooltip" title="Add Data"> <i class="fa fa-plus-circle"></i> Add Data</a>
                <?php }else{?>
                  <a class="btn btn-box-tool" data-toggle="tooltip" title="No Access"><i class="fa fa-plus-circle"></i> No Access</a>
                <?php }?>--><!-- 
                <?php if(accessperm('mengimport-data-riwayat-kelas-peserta')){ ?>        
                  <a href="<?=base_url(uri_string()."/import")?>" class="btn btn-box-tool" data-toggle="tooltip" title="Import Data"> <i class="fa fa-file-text"></i> Import Data</a>
                <?php }else{?>
                  <a class="btn btn-box-tool" data-toggle="tooltip" title="No Access"><i class="fa fa-file-text"></i> No Access</a>
                <?php }?> -->
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                  <i class="fa fa-refresh"></i> Refresh</button>
              </div>
            </div>
            <div class="box-body">
                <div class="table-responsive">
              <table class="table table-bordered table-striped dt-table" style="width: 100%">
                <thead>
                  <tr>
                    <th style="width:50px">No</th>
                    <th style="width:80px">Foto</th>
                    <th style="width:100px">NIPP</th>
                    <th style="width:200px">Nama Peserta</th>
                    <th style="width:150px">Kota Lahir</th>
                    <th style="width:200px">Email Peserta</th>
                    <th style="width:120px">Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
              </div>
            </div> <!--box-body-->
          </div> <!--default-box-->
      </div> <!-- /.tab-pane -->
      
      <div class="tab-pane" id="tab_2">
        <!-- Default box -->
          <div class="box" style="border-top:0px solid">
            <div class="box-header with-border">
              <h3 class="box-title"><?=$titlebox?> Non QIA</h3>
              <div class="box-tools pull-right">
                <!--<?php if(accessperm('menambahkan-data-riwayat-kelas-peserta')){ ?>
                  <a href="<?=base_url(uri_string()."/add")?>" class="btn btn-box-tool" data-toggle="tooltip" title="Add Data"> <i class="fa fa-plus-circle"></i> Add Data</a>
                <?php }else{?>
                  <a class="btn btn-box-tool" data-toggle="tooltip" title="No Access"><i class="fa fa-plus-circle"></i> No Access</a>
                <?php }?>--><!-- 
                <?php if(accessperm('mengimport-data-riwayat-kelas-peserta')){ ?>        
                  <a href="<?=base_url(uri_string()."/import")?>" class="btn btn-box-tool" data-toggle="tooltip" title="Import Data"> <i class="fa fa-file-text"></i> Import Data</a>
                <?php }else{?>
                  <a class="btn btn-box-tool" data-toggle="tooltip" title="No Access"><i class="fa fa-file-text"></i> No Access</a>
                <?php }?> -->
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                  <i class="fa fa-refresh"></i> Refresh</button>
              </div>
            </div>
            <div class="box-body">
              <table class="table table-bordered table-striped dt-table2" style="width: 100%">
                <thead>
                  <tr>
                    <th style="width:50px">No</th>
                    <th style="width:80px">Foto</th>
                    <th style="width:100px">NIPP</th>
                    <th style="width:200px">Nama Peserta</th>
                    <th style="width:150px">Kota Lahir</th>
                    <th style="width:200px">Email Peserta</th>
                    <th style="width:120px">Action</th>
                  </tr>
                </thead>
                <tbody>
                </tbody>
              </table>
            </div> <!--box-body-->
          </div> <!--default-box-->
      </div> <!-- /.tab-pane -->
    </div> <!-- /.tab-content -->
  </div> <!-- nav-tabs-custom -->
</section>

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
    
    $('table.dt-table').DataTable({
      "responsive": true,
      "processing": true, 
      "serverSide": true, 
      "order": [], 
      <?php if(accessperm('mengekspor-data-riwayat-kelas-peserta')){ ?>
      "dom": 'Bfrtip',
      "buttons": [
        { extend: 'copy', text: '<i class="fa fa-copy"></i> Copy','className':'btn btn-sm btn-default',exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5 ]
          },init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }},
        { extend: 'excel', text: '<i class="fa fa-save"></i> Excel',title:'<?=$subtitlepage?>','className':'btn btn-sm btn-success',exportOptions: {
              columns: [ 0, 1, 2, 3, 4,5]
          },init: function(api, node, config) {
           $(node).removeClass('dt-button')
        } },
        { extend: 'csv', text: '<i class="fa fa-save"></i> Csv',title:'<?=$subtitlepage?>','className':'btn btn-sm btn-success',exportOptions: {
              columns: [ 0, 1, 2, 3, 4,5 ]
          },init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }  },
        { extend: 'pdf', text: '<i class="fa fa-save"></i> Pdf' ,title:'<?=$subtitlepage?>','className':'btn btn-sm btn-danger',exportOptions: {
              columns: [ 0, 1, 2, 3, 4,5 ]
          },init: function(api, node, config) {
           $(node).removeClass('dt-button')
        } },
        { extend: 'print', text: '<i class="fa fa-print"></i> Print',title:'<?=$subtitlepage?>' ,'className':'btn btn-sm btn-info',exportOptions: {
              columns: [ 0, 1, 2, 3, 4,5 ]
          },init: function(api, node, config) {
           $(node).removeClass('dt-button')
        } },
      ],
      <?php } ?>
      "ajax": {
        "url": "<?php echo site_url(uri_string().'/getdata')?>",
        "type": "POST",
        "dataSrc": function ( json ) {
            $(document).CsrfAjaxGet();
            return json.data;
        } 
      },
      "columnDefs": [
        { 
          "targets": [ 0 ], 
          "orderable": false, 
        },
        { 
          "targets": [ 1,6 ], 
          "orderable": false, 
          "searchable": false, 
        }
      ],
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    });
    
    $('table.dt-table2').DataTable({
      "responsive": true,
      "processing": true, 
      "serverSide": true, 
      "order": [], 
      <?php if(accessperm('mengekspor-data-riwayat-kelas-peserta')){ ?>
      "dom": 'Bfrtip',
      "buttons": [
        { extend: 'copy', text: '<i class="fa fa-copy"></i> Copy','className':'btn btn-sm btn-default',exportOptions: {
              columns: [ 0, 1, 2, 3, 4, 5 ]
          },init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }},
        { extend: 'excel', text: '<i class="fa fa-save"></i> Excel',title:'<?=$subtitlepage?>','className':'btn btn-sm btn-success',exportOptions: {
              columns: [ 0, 1, 2, 3, 4,5]
          },init: function(api, node, config) {
           $(node).removeClass('dt-button')
        } },
        { extend: 'csv', text: '<i class="fa fa-save"></i> Csv',title:'<?=$subtitlepage?>','className':'btn btn-sm btn-success',exportOptions: {
              columns: [ 0, 1, 2, 3, 4,5 ]
          },init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }  },
        { extend: 'pdf', text: '<i class="fa fa-save"></i> Pdf' ,title:'<?=$subtitlepage?>','className':'btn btn-sm btn-danger',exportOptions: {
              columns: [ 0, 1, 2, 3, 4,5 ]
          },init: function(api, node, config) {
           $(node).removeClass('dt-button')
        } },
        { extend: 'print', text: '<i class="fa fa-print"></i> Print',title:'<?=$subtitlepage?>' ,'className':'btn btn-sm btn-info',exportOptions: {
              columns: [ 0, 1, 2, 3, 4,5 ]
          },init: function(api, node, config) {
           $(node).removeClass('dt-button')
        } },
      ],
      <?php } ?>
      "ajax": {
        "url": "<?php echo site_url(uri_string().'/getdata2')?>",
        "type": "POST",
        "dataSrc": function ( json ) {
            $(document).CsrfAjaxGet();
            return json.data;
        } 
      },
      "columnDefs": [
        { 
          "targets": [ 0 ], 
          "orderable": false, 
        },
        { 
          "targets": [ 1,6 ], 
          "orderable": false, 
          "searchable": false, 
        }
      ],
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    });
  })  
</script>