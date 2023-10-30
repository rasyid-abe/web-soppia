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
          <a href="<?=base_url($this->uri->segment(1).'/accounting-jurnal')?>" class="btn btn-box-tool" data-toggle="tooltip"
                title="Kembali Ke Manage <?=$subtitlepage?>">
          <i class="fa fa-arrow-circle-left"></i> Back</a>
        <?php if(accessperm('mengimport-data-accounting-jurnal')){ ?>        
          <a href="<?=base_url(uri_string()."/import")?>" class="btn btn-box-tool" data-toggle="tooltip" title="Import Data"> <i class="fa fa-file-text"></i> Import Data</a>
        <?php }else{?>
          <a class="btn btn-box-tool" data-toggle="tooltip" title="No Access"><i class="fa fa-file-text"></i> No Access</a>
        <?php }?>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">
        
      <table class="table table-bordered table-striped dt-table" style="width: 100%">
        <thead>
          <tr>
            <th>Tanggal Transaksi</th>
            <th>Deskripsi Transaksi</th>
            <th>Deskripsi Account</th>
            <th>Debet / Kredit</th>
            <th>Nilai (Rp)</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>

    </div>
  </div>

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
      <?php if(accessperm('mengekspor-data-accounting-jurnal')){ ?>
      "dom": 'Bfrtip',
      "buttons": [
        { extend: 'copy', text: '<i class="fa fa-copy"></i> Copy','className':'btn btn-sm btn-default',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }},
        { extend: 'excel', text: '<i class="fa fa-save"></i> Excel',title:'<?=$subtitlepage?>','className':'btn btn-sm btn-success',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }},
        { extend: 'csv', text: '<i class="fa fa-save"></i> Csv',title:'<?=$subtitlepage?>','className':'btn btn-sm btn-success',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }},
        { extend: 'pdf', text: '<i class="fa fa-save"></i> Pdf' ,title:'<?=$subtitlepage?>','className':'btn btn-sm btn-danger',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }},
        { extend: 'print', text: '<i class="fa fa-print"></i> Print',title:'<?=$subtitlepage?>' ,'className':'btn btn-sm btn-info',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }},
      ],
      <?php } ?>
      "ajax": {
        "url": "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/getdata/'.$idpro)?>",
        "type": "POST",
        "dataSrc": function ( json ) {
            $(document).CsrfAjaxGet();
            return json.data;
        } 
      },
      'paging'      : false,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : false,
      'info'        : false,
      'autoWidth'   : false
    })
  })  
</script>