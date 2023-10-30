<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<style>
    label{
         color:#00008B
    }
</style>
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

  <div class="row">
    <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->id_anggota)?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    
    
    <div class="col-sm-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"><?=$titlebox?></h3>
          <div class="box-tools pull-right">
            <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                    title="Kembali Ke Manage <?=$subtitlepage?>">
              <i class="fa fa-arrow-circle-left"></i> Back</a>
            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
              <i class="fa fa-refresh"></i> Refresh</button>
          </div>
        </div>
        <div class="box-body">
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Nomor KTP</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="noktp" id="noktp" value="<?=$dtdefault->noktp?>" >
              </div>
            </div>
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Nama Anggota</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="nama_anggota" id="nama_anggota" value="<?=$dtdefault->nama_anggota?>" >
              </div>
            </div>
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Alamat Anggota</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="alamat" id="alamat" value="<?=$dtdefault->alamat?>" >
              </div>
            </div>
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Nomor HP</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="nohp" id="nohp" value="<?=$dtdefault->nohp?>" >
              </div>
            </div>
            
            <div class="col-sm-12"> 
              <div class="form-group col-sm-12"> 
                <div class="col-sm-3 pull-right">
                  <button type="submit" class="btn btn-block btn-flat btn-success">Save</button>
                </div>
                <div class="col-sm-3 pull-right">
                  <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-danger btn-block btn-flat">Back</a>
                </div>
              </div>
            </div>
            
        </div> <!-- box-body -->
      </div> <!-- box -->
    </div> <!-- col -->
    
    </form>
  </div>
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
  });
</script>