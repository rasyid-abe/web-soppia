<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<style>
    label{
        color:#00008B;
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
        <a href="<?=base_url($this->uri->segment(1))?>" class="btn btn-box-tool" data-toggle="tooltip"
                title="Kembali Ke Manage <?=$subtitlepage?>">
          <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i> Refresh</button>
      </div>
    </div>
    <div class="box-body">
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->Id_PershInstansi)?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />        
       
        <div class="col-md-12">
            <div class="col-sm-6">
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Nama Perusahaan</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="name" id="name" placeholder="Name"  value="<?=$dtdefault->Desc_PershInstansi?>" required >
                </div>
              </div>
            
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Alamat Perusahaan</label>
                </div>
                <div class="col-sm-8">
                    <textarea class="form-control" name="alamat" required placeholder="Alamat Perusahaan" id="alamat"><?=$this->session->flashdata('oldinput')['alamat']?></textarea>
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Holding Group</label>
                </div>
                <div class="col-sm-8">
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
                <div class="col-sm-4">
                  <label>Jenis Usaha</label>
                </div>
                <div class="col-sm-8">
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
                <div class="col-sm-4">
                  <label>No Telp</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="telp" id="telp" placeholder="Telp"  value="<?=$this->session->flashdata('oldinput')['telp']?>" >
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Fax</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="fax" id="fax" placeholder="Fax"  value="<?=$this->session->flashdata('oldinput')['fax']?>" >
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Email</label>
                </div>
                <div class="col-sm-8">
                  <input type="email" class="form-control" name="email" id="email" placeholder="Email"  value="<?=$this->session->flashdata('oldinput')['email']?>" >
                </div>
              </div>
            </div> <!--row6-->
            
            <div class="col-sm-6"> 
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Kontak Person</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="kontak_person" id="kontak_person" placeholder="Kontak Person"  value="<?=$this->session->flashdata('oldinput')['kontak_person']?>" >
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Nomor HP</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="hp_kontak_person" id="hp_kontak_person" placeholder="HP Kontak Person"  value="<?=$this->session->flashdata('oldinput')['hp_kontak_person']?>" >
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Kode Singkat</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="kode_singkat" id="kode_singkat" placeholder="Kode Singkat"  value="<?=$this->session->flashdata('oldinput')['kode_singkat']?>" >
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Keterangan</label>
                </div>
                <div class="col-sm-8">
                  <textarea class="form-control" name="keterangan" placeholder="Keterangan" id="keterangan"><?=$this->session->flashdata('oldinput')['keterangan']?></textarea>
                </div>
              </div>
    
            <div class="form-group col-sm-12">
              <hr style="margin-bottom:0;margin-top:0" />
            </div>
    
            <div class="form-group col-sm-12"> 
              <div class="col-sm-4">
                <button type="submit" class="btn btn-block btn-success">Update</button>
              </div>
              <div class="col-sm-4">
                <a href="<?=base_url($this->uri->segment(1))?>" class="btn btn-danger btn-block btn-flat">Back</a>
              </div>
            </div>
          </div> <!--row6-->
        </div> <!--row12-->

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