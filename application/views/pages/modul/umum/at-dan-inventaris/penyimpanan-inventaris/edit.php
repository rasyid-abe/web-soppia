<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
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
     
     
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->Id_AT_n_Invent)?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
          Nama Barang AT dan Inventaris
            <br>
            <input type="text" name="nama" value="<?=$dtdefault->Desc_AT_n_Invent?>" class="form-control" id="nama" readonly />
          </div>
        </div>

         <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
          Lokasi Penyimpanan
            <br/>
            <select class="form-control select2" name="lok_penyimpanan" id="lok_penyimpanan" required>
              <option value="" selected readonly disabled> Pilih Lokasi Penyimpanan </option>
              <?php
                foreach($ref_lokasi_simpan->result() as $ref_lok){
                    $slc = ($ref_lok->Kd_Lokasi_Simpan == $dtdefault->FKd_Lokasi_Simpan)? 'selected':'';
                ?>
                <option value="<?=$ref_lok->Kd_Lokasi_Simpan?>" <?=$slc?> ><?=$ref_lok->Desc_Lokasi_Simpan?></option>
                <?php
                }
              ?>
            </select>
          </div>
        </div>
        

        <div class="form-group col-sm-12">
          <hr style="margin-bottom:0;margin-top:0" />
        </div>

        <div class="form-group col-sm-12"> 
          <div class="col-sm-2">
            <button type="submit" class="btn btn-block btn-flat">Save</button>
          </div>
          <div class="col-sm-2">
            <a href="" class="btn btn-danger btn-block btn-flat">Back</a>
          </div>
        </div>

      </form>

    </div>

  </div>

</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
  });
</script>