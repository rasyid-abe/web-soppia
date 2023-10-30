<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")?>">
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
  </div>
  <div class="row">
    <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->id_pegawai)?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    
    
    <div class="col-sm-6"> 
    <div class="box" style="border-top:0px solid">
        <div class="box-header with-border">
          <h3 class="box-title">Data Diri</h3>
        </div>
        <div class="box-body">

            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  NIK<br/>
                  <input type="text" class="form-control" name="nik" id="nik" placeholder="Nomer Induk Kependudukan" value="<?=$dtdefault->nik?>"  required >
                </div>
            </div>
            
            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Nama Lengkap Pegawai<br/>
                  <input type="text" class="form-control" name="nama_pegawai" placeholder="Nama lengkap pegawai" value="<?=$dtdefault->nama_pegawai?>" >
                </div>
            </div>
            
            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Jenis Kelamin<br/>
                  <select class="form-control" name="jenis_kelamin">
                    <?php
                       $slc1 = ($dtdefault->jenis_kelamin=="Laki-laki")? 'selected':'';
                       $slc2 = ($dtdefault->jenis_kelamin=="Perempuan")? 'selected':'';
                       $slc3 = ($dtdefault->jenis_kelamin==null)? 'selected':'';
                    ?>
                      <option value=""<?=$slc3?>>Pilih</option>
                      <option <?=$slc1?>>Laki-laki</option>
                      <option <?=$slc2?>>Perempuan</option>
                  </select>
                </div>
            </div>
            
            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Jabatan Pegawai<br/>
                  <input type="text" class="form-control" name="jabatan" placeholder="Jabatan pegawai" value="<?=$dtdefault->jabatan?>" >
                </div>
            </div>
            
            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Kota Lahir<br/>
                  <input type="text" class="form-control" name="kota_lahir" placeholder="Kota Lahir" value="<?=$dtdefault->kota_lahir?>" >
                </div>
            </div>     
            
            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Tanggal Lahir<br/>
                  <input type="text" class="form-control date" name="tgl_lahir" placeholder="Tanggal Lahir" value="<?=$dtdefault->tgl_lahir?>" >
                </div>    
            </div>
            
            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Alamat Rumah<br/>            
                  <input type="text" class="form-control" name="alamat" placeholder="Alamat Rumah" value="<?=$dtdefault->alamat?>" >
                </div>  
            </div>  
            
            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Strata Pendidikan<br/>
                  <select class="form-control" name="strata_pendidikan">
                    <?php
                       $slc1 = ($dtdefault->strata_pendidikan=="Laki-S1")? 'selected':'';
                       $slc2 = ($dtdefault->strata_pendidikan=="S2")? 'selected':'';
                       $slc3 = ($dtdefault->strata_pendidikan=="S3")? 'selected':'';
                       $slc4 = ($dtdefault->strata_pendidikan==null)? 'selected':'';
                    ?>
                      <option value=""<?=$slc4?>>Pilih</option>
                      <option <?=$slc1?>>S1</option>
                      <option <?=$slc2?>>S2</option>
                      <option <?=$slc3?>>S3</option>
                  </select>
                </div>
            </div>
            
            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Bidang Pendidikan<br/>            
                  <input type="text" class="form-control" name="bidang_pendidikan" placeholder="Bidang Pendidikan" value="<?=$dtdefault->bidang_pendidikan?>" >
                </div>  
            </div> 
            
            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Jumlah Anak<br/>            
                  <input type="number" min="0" class="form-control" name="jml_anak" placeholder="Jumlah Anak" value="<?=$dtdefault->jml_anak?>" >
                </div>  
            </div> 
            
            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Email Pegawai<br/>            
                  <input type="email" class="form-control" name="email" placeholder="Email Pegawai" value="<?=$dtdefault->email?>" >
                </div>  
            </div> 
            
            <div class="form-group col-sm-12">
                <hr style="margin-bottom:0;margin-top:0" />
            </div>
            
            <div class="col-sm-4">
              <button type="submit" class="btn btn-block btn-flat">Save</button>
            </div>
            
            <div class="col-sm-4">
              <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-danger btn-block btn-flat">Back</a>
            </div>
          
        </div>
      </div>
    </div>

    </form>
  </div>
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
    $('.date').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight:true,
    });
  });
</script>