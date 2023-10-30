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
    <li><a ><?=$breadcrumb2?></a></li>
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
        <?php if(accessperm('menambahkan-data-sesi-satuan')){ ?>
          <a href="<?=base_url("data-sesi/paket-sesi-harian/pengaturansesipaketadd/".$id)?>" class="btn btn-box-tool" data-toggle="tooltip" title="Add Data"> <i class="fa fa-plus-circle"></i> Add Data</a>
        <?php }else{?>
          <a class="btn btn-box-tool" data-toggle="tooltip" title="No Access"><i class="fa fa-plus-circle"></i> No Access</a>
        <?php }?>
        <a href="<?=base_url("data-sesi/paket-sesi-harian")?>"  class="btn btn-box-tool" data-toggle="tooltip" title="Kembali"><i class="fa fa-arrow-circle-left"></i> Back</a> 
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'><i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped dt-table" style="width: 100%">
        <thead>
          <tr>
            <th width="20">No</th>
            <th width="550">Sesi Satuan</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            <?php
                $datasesi = $this->db->where(array("FKd_Paket_Sesi_Harian"=>$id))->get("ref_detil_paket_sesi_harian");
                if($datasesi->num_rows()>0){
                    $i = 1;
                    foreach($datasesi->result() as $dtss){
            ?>
            <tr>
                <td><?=$i?></td>
                <td><?php
                    $dtpktharian = $this->db->where(array("Kd_Sesi_Satuan"=>$dtss->FKd_Sesi_Satuan))->get("ref_sesi_satuan");
                    if($dtpktharian->num_rows()>0){
                        echo $dtpktharian->row()->Desc_Sesi;
                    }else{
                        
                    }
                ?></td>
                <td>
                    <a href="<?=base_url('data-sesi/paket-sesi-harian/pengaturansesipaketview/'.$id.'/'.$dtss->Kd_detail)?>" class='btn btn-xs btn-primary view-data' data-toggle='tooltip' title='View Data'><i class="fa fa-search-plus"></i> View</a>
                    <a href="<?=base_url('data-sesi/paket-sesi-harian/pengaturansesipaketedit/'.$id.'/'.$dtss->Kd_detail)?>" class='btn btn-xs btn-warning' data-toggle='tooltip' title='Edit Data'><i class="fa fa-pencil-square"></i> Edit</a>
                    <a href="<?=base_url('data-sesi/paket-sesi-harian/pengaturansesipaketdelete/'.$id.'/'.$dtss->Kd_detail)?>" class='btn btn-xs btn-danger delete-data' data-toggle='tooltip' title='Delete Data'><i class="fa fa-trash"></i> Delete</a>
                </td>
            </tr>
            <?php
                    $i++;
                    }
                }
            ?>
        </tbody>
      </table>
      </div>
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
    $('table.dt-table').DataTable({});
  })  
</script>