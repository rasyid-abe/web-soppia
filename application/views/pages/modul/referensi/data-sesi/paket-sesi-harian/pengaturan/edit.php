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
    <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
  <?php }else if($this->session->flashdata('success')){ ?>
    <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
  <?php } ?>

  <!-- Default box -->
  <div class="box" style="border-top:0px solid">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$titlebox?></h3>

      <div class="box-tools pull-right">
        <a href="<?=base_url("data-sesi/paket-sesi-harian/pengaturansesipaket/".$idpaket)?>" class="btn btn-box-tool" data-toggle="tooltip" title="Kembali Ke Manage <?=$subtitlepage?>">
          <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">
      <form action="<?=base_url("data-sesi/paket-sesi-harian/pengaturansesipaketupdate/".$idpaket.'/'.$idsesireal)?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />   
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Paket Sesi Satuan<br/>
            <select name="FKd_Sesi_Satuan" class="form-control select2" style="width: 100%;">
              <option value="" readonly disabled selected>Pilih Sesi Satuan</option>
              <?php
              foreach ($fkd_sesi_satuan->result() as $fkd2) {
                $slc = ($idsesi==$fkd2->Kd_Sesi_Satuan)? 'selected':'';
              ?>
              <option value="<?=$fkd2->Kd_Sesi_Satuan?>" <?=$slc?> ><?=$fkd2->Desc_Sesi?></option>
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
            <button type="submit" class="btn btn-block btn-flat">Update</button>
          </div>
          <div class="col-sm-2">
            <a href="<?=base_url("data-sesi/paket-sesi-harian/pengaturansesipaket/".$idpaket)?>" class="btn btn-danger btn-block btn-flat">Back</a>
          </div>
        </div>

      </form>
    </div>

  </div>

</section>

<script type="text/javascript">  
  $(function () {
  });
</script>