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
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">Entry Nilai Pada Kelas <?=$kelas->DescBebas_Kelas_n_Angkatan?></h3>

      <div class="box-tools pull-right">        
        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip" title="Kembali Ke Manage <?=$subtitlepage?>">
                <i class="fa fa-arrow-circle-left"></i> Back</a>        
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i> Refresh</button>
      </div>
    </div>
    <div class="box-body">
      <div class="row">
        <div class="col-sm-12">
          <div class="table-responsive">
            <table class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th style="width: 10px">No</th>
                  <th style="width: 80px">Foto</th>                
                  <th style="width: 130px">NIPP</th>                
                  <th style="width: 300px">Nama Peserta</th>                
                  <th>Perusahaan/Instansi</th>                
                  <th style="width: 200px">Action</th>                
                </tr>
              </thead>
              <tbody>
                <?php if($qia > 0){$no=1;foreach($pesertaqia as $data){ ?>
                <tr>
                    <td><?=$no++?></td>
                    <td><?=($data->FilePhoto!= null)? '<img src="'.base_url("uploads/photo/".$data->FilePhoto).'" width="50px" height="50px"></img>' : '<code>N/A</code>';?></td>
                    <td><?=$data->NIPP?></td>
                    <td><?=$data->NamaLengkap_DgnGelar?></td>
                    <td><?=($data->NamaPershInstansi!= null)? $data->NamaPershInstansi : '<code>N/A</code>';?></td>
                    <td>
                      <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/add/'.$data->id_peserta.'/'.$kelas->Id_Kelas_n_Angkatan)?>" class="btn btn-flat btn-xs btn-success" data-toggle='tooltip' title='Entry Data Ujian'><i class='fa fa-pencil-square'></i> Input Nilai</a>                    
                                         
                    </td>
                </tr>
                <?php } } ?>

                <?php if($nonqia > 0){$no=1;foreach($pesertanonqia as $data){ ?>
                <tr>
                    <td><?=$no++?></td>
                    <td><?=($data->FilePhoto!= null)? '<img src="'.base_url("uploads/photo/".$data->FilePhoto).'" width="50px" height="50px"></img>' : '<code>N/A</code>';?></td>
                    <td><?=$data->NIPP?></td>
                    <td><?=$data->NamaLengkap_DgnGelar?></td>
                    <td><?=($data->NamaPershInstansi!= null)? $data->NamaPershInstansi : '<code>N/A</code>';?></td>
                    <td>
                      <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/add/'.$data->id_peserta.'/'.$kelas->Id_Kelas_n_Angkatan)?>" class="btn btn-flat btn-xs btn-success" data-toggle='tooltip' title='Entry Data Ujian'><i class='fa fa-pencil-square'></i> Input Nilai</a>                     
                                    
                    </td>
                </tr>
                <?php } } ?>
              </tbody>
            </table>
          </div> <!-- responsive -->
        </div> <!-- col-12 -->                     
      </div> <!-- row -->
    </div> <!-- box-body -->
  </div> <!-- box -->
</section>

<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('table.dt-table').DataTable({
      "responsive"  : true,
      "processing"  : false, 
      "serverSide"  : true, 
      'paging'      : false,
      'lengthChange': true,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true
    })
  })  
</script>