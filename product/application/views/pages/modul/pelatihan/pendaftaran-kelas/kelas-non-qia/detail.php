<?php ini_set('memory_limit', '-1');?>
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net/buttons.dataTables.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")?>">
<style>
    label{
        color:#00008B;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Kelas <?=$kelas->DescBebas_Kelas_n_Angkatan?>
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
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Tambah Peserta Kelas</h3>

      <div class="box-tools pull-right">
        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                title="Kembali Ke Manage <?=$subtitlepage?>">
          <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i> Refresh</button>
      </div>
    </div>
    <div class="box-body">
        <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/store")?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    
            <input type="hidden" name="nonqia" value="<?=$idkelasnonqia?>" /> 
            <input type="hidden" name="defaultqia" value="<?=$kelas->Flag_DefaultAwalQIA?>" />
            <input type="hidden" name="status_pel" value="<?=$kelas->status_pel?>" />   
              <div class="form-group col-sm-12">
                    <div class="col-sm-2">
                      <label>Nama Peserta</label>
                    </div>
                    <div class="col-sm-10">
                      <input type="hidden" name="id_kelas" value="<?=$kelas->Id_Kelas_n_Angkatan?>">
                      <select name="id_peserta" class="form-control select2" id='idpeserta' style="width: 100%;" required>
                        
                      </select>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                  <hr style="margin-bottom:0;margin-top:0" />
                </div>
        
                <div class="form-group col-sm-12"> 
                  <div class="col-sm-3 pull-right">
                    <button type="submit" class="btn btn-block btn-success">Save</button>
                  </div>
                </div>
            </form>
    </div>
  </div>

  <!-- Default box -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Daftar Peserta Pelatihan <?=$kelas->Desc_JenisPelatihan?></h3>
      <div class="box-tools pull-right">
        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/print/'.$kelas->Id_Kelas_n_Angkatan)?>" class="btn btn-xs btn-warning" data-toggle="tooltip" title="Cetak"><i class="fa fa-print"></i> <b>Kelola Print</b></a>
      </div>
    </div>
    <div class="box-body">
      <table class="table table-bordered table-striped dt-table" style="width: 100%">
        <thead>
          <tr>
            <th style="width:40px">No</th>
            <th style='width:100px'>NIK</th>
            <th style='width:100px'>NIPP</th>
            <th style='width:200px'>Nama Peserta</th>
            <th style='width:200px'>Perusahaan/Instansi</th>
            <th style='width:120px'>Action</th>
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
<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>

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
      <?php if(accessperm('mengekspor-data-kelas-non-qia')){ ?>
      "dom": 'Bfrtip',
      "buttons": [
        { extend: 'copy', text: '<i class="fa fa-copy"></i> Copy','className':'btn btn-sm btn-default',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }},
        { extend: 'excel', text: '<i class="fa fa-save"></i> Excel',title:'<?=$subtitlepage?>','className':'btn btn-sm btn-success',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        } },
        { extend: 'csv', text: '<i class="fa fa-save"></i> Csv',title:'<?=$subtitlepage?>','className':'btn btn-sm btn-success',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }  },
        { extend: 'pdf', text: '<i class="fa fa-save"></i> Pdf' ,title:'<?=$subtitlepage?>','className':'btn btn-sm btn-danger',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        } },
        { extend: 'print', text: '<i class="fa fa-print"></i> Print',title:'<?=$subtitlepage?>' ,'className':'btn btn-sm btn-info',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        } },
      ],
      <?php } ?>
      "ajax": {
        "url": "<?php echo site_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/getdatanonqia/'.$idkelasnonqia)?>",
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
          "targets": [ 5 ], 
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
    })
  })  
</script>
<script type="text/javascript">  
  $(function () {
    $("#idpeserta").select2({
        placeholder: 'Masukkan NIPP/NIK/Nama',
        ajax: {
            dataType: 'json',
            url: '<?=base_url('pendaftaran-kelas/kelas-non-qia/getpeserta')?>',
            delay: 250,
            processResults: function (data, params) {
              // parse the results into the format expected by Select2
              // since we are using custom formatting functions we do not need to
              // alter the remote JSON data, except to indicate that infinite
              // scrolling can be used
              params.page = params.page || 1;
              return {
                results: $.map(data.result, function (item) {
                    return {
                        text: item.text,
                        id: item.id
                    }
                }),
                pagination: {
                  more: (params.page * 30) < data.total_count
                }
              };
            },
            cache: true
        }
    });
  })
</script>