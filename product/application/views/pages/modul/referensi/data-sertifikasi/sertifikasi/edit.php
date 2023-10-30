
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
        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                title="Kembali Ke Manage <?=$subtitlepage?>">
          <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->Kd_Sertifikasi)?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />                
        
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Nama Sertifikasi<br/>
            <input type="text" class="form-control" name="Desc_Sertifikasi" id="Desc_Sertifikasi" placeholder="Desc Sertifikasi"  value="<?=$dtdefault->Desc_Sertifikasi?>" >
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Kode Singkat<br/>
            <input type="text" class="form-control" name="Kode_Singkatan" id="Kode_Singkatan" placeholder="Kode Singkatan" value="<?=$dtdefault->Kode_Singkatan?>" >
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Jenis Sertifikasi I<br/>
            <select name="FKd_Jns_Sertifikasi1" class="form-control select2" style="width: 100%;">
              <option value="" readonly disabled selected>Pilih Jenis Sertifiaksi 1</option>
              <?php
              foreach ($fkd_jns_sertifikasi1->result() as $fkd1) {
                $slc = ($dtdefault->FKd_Jns_Sertifikasi1==$fkd1->Kd_Jns_Sertifikasi1)? 'selected':'';
              ?>
              <option value="<?=$fkd1->Kd_Jns_Sertifikasi1?>" <?=$slc?> ><?=$fkd1->Desc_Jns_Sertifikasi1?></option>
              <?php
              }
              ?>
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Jenis Sertifikasi II<br/>
            <select name="FKd_Jns_Sertifikasi2" class="form-control select2" style="width: 100%;">
              <option value="" readonly disabled selected>Pilih Jenis Sertifiaksi 2</option>
              <?php
              foreach ($fkd_jns_sertifikasi2->result() as $fkd2) {
                $slc = ($dtdefault->FKd_Jns_Sertifikasi2==$fkd2->Kd_Jns_Sertifikasi2)? 'selected':'';
              ?>
              <option value="<?=$fkd2->Kd_Jns_Sertifikasi2?>" <?=$slc?> ><?=$fkd2->Desc_Jns_Sertifikasi2?></option>
              <?php
              }
              ?>
            </select>
          </div>
        </div>


        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Keterangan<br/>
            <textarea class="form-control" name="Keterangan" placeholder="Keterangan"><?=$dtdefault->Keterangan?></textarea>
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
            <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-danger btn-block btn-flat">Back</a>
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