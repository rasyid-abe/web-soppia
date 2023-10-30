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
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->Id_PershInstansi)?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />        
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Nama Perusahaan
            <br/>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name"  value="<?=$dtdefault->Desc_PershInstansi?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Alamat
            <br/>
            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat Kantor"  value="<?=$dtdefault->Alamat_Utama_Kantor?>" >
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Holding Group
            <br/>
            <select class="form-control select2" name="holdinggroup" id="holdinggroup">
              <option value="" selected readonly disabled> Holding Group</option>
              <?php
                foreach ($holdinggroup->result() as $lue) {
                  $slc1 = ($dtdefault->FId_GrupPershInstansi == $lue->Id_GrupPershInstansi)? 'selected':'';
              ?>
              <option value="<?=$lue->Id_GrupPershInstansi?>" <?=$slc1?> ><?=$lue->Desc_GrupPershInstansi?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Jenis Usaha
            <br/>
            <select class="form-control select2" name="jenisusaha" id="jenisusaha">
              <option value="" selected readonly disabled> Jenis Usaha</option>
              <?php
                foreach ($jenisusaha->result() as $vl) {
                  $slc2 = ($dtdefault->FKd_JenisUsaha == $vl->Kd_JenisUsaha)? 'selected':'';
              ?>
              <option value="<?=$vl->Kd_JenisUsaha?>" <?=$slc2?> ><?=$vl->Desc_JenisUsaha?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            No Telp
            <br/>
            <input type="text" class="form-control" name="telp" id="telp" placeholder="Telp"  value="<?=$dtdefault->Telp?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Fax
            <br/>
            <input type="text" class="form-control" name="fax" id="fax" placeholder="Fax"  value="<?=$dtdefault->Fax?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Email
            <br/>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email"  value="<?=$dtdefault->email?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Kontak Person
            <br/>
            <input type="text" class="form-control" name="kontak_person" id="kontak_person" placeholder="Kontak Person"  value="<?=$dtdefault->Contact_Person?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Hp Person
            <br/>
            <input type="text" class="form-control" name="hp_kontak_person" id="hp_kontak_person" placeholder="HP Kontak Person"  value="<?=$dtdefault->HP_Contact_Person?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Kode Singkat
            <br/>
            <input type="text" class="form-control" name="kode_singkat" id="kode_singkat" placeholder="Kode Singkat"  value="<?=$dtdefault->Kode_Singkatan?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Keterangan
            <br/>
            <textarea class="form-control" name="keterangan" id="keterangan"><?=$dtdefault->Keterangan?></textarea>
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


<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
  });
</script>