<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
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

  <div class="row ">
      <div class="col-md-12"> 
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
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->FId_Kelas_n_Angkatan)?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Nama Kelas</label>
                </div>
                <div class="col-sm-10">
                  <select name="FId_Kelas_n_Angkatan" class="form-control select2" style="width: 100%;">
                    <option value="" readonly disabled selected>Pilih Kelas</option>
                    <?php
                    foreach ($FId_Kelas_n_Angkatan->result() as $data) {
                      $slc = ($dtdefault->FId_Kelas_n_Angkatan==$data->Id_Kelas_n_Angkatan)? 'selected':'';
                    ?>
                    <option value="<?=$data->Id_Kelas_n_Angkatan?>" <?=$slc?> ><?=$data->DescBebas_Kelas_n_Angkatan?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>No Urut Hari</label>
                </div>
                <div class="col-sm-10">
                  <input type="number" class="form-control" name="No_Urut_Hari" id="No_Urut_Hari" value="<?=$dtdefault->No_Urut_Hari?>">
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Tanggal</label>
                </div>
                <div class="col-sm-10">
                  <input type="date" class="form-control" name="Tgl" id="Tgl" value="<?=$dtdefault->Tgl?>">
                </div>
              </div>  

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Hari</label>
                </div>
                <div class="col-sm-10">
                  <select name="Hari" class="form-control select2" style="width: 100%;">
                    <?php
                       $slc1 = ($dtdefault->Hari=="Senin")? 'selected':'';
                       $slc2 = ($dtdefault->Hari=="Selasa")? 'selected':'';
                       $slc3 = ($dtdefault->Hari=="Rabu")? 'selected':'';
                       $slc4 = ($dtdefault->Hari=="Kamis")? 'selected':'';
                       $slc5 = ($dtdefault->Hari=="Jumat")? 'selected':'';
                       $slc6 = ($dtdefault->Hari=="Sabtu")? 'selected':'';
                    ?>
                    <option value="Senin"<?=$slc1?>>Senin</option>                  
                    <option value="Selasa"<?=$slc2?>>Selasa</option>                  
                    <option value="Rabu"<?=$slc3?>>Rabu</option>                  
                    <option value="Kamis"<?=$slc4?>>Kamis</option>                  
                    <option value="Jumat"<?=$slc5?>>Jumat</option>                  
                    <option value="Sabtu"<?=$slc6?>>Sabtu</option>                  
                  </select>
                </div>
              </div> 

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>No Urut Sesi</label>
                </div>
                <div class="col-sm-10">
                  <input type="number" class="form-control" name="No_Urut_Sesi" id="No_Urut_Sesi" value="<?=$dtdefault->No_Urut_Sesi?>">
                </div>
              </div>
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Deskripsi Sesi</label>
                </div>
                <div class="col-sm-10">
                  <select name="FKd_Sesi_Satuan" class="form-control select2" style="width: 100%;">
                    <option value="" readonly disabled selected>Pilih Sesi</option>
                    <?php
                    foreach ($FKd_Sesi_Satuan->result() as $data) {
                      $slc = ($dtdefault->FKd_Sesi_Satuan==$data->Kd_Sesi_Satuan)? 'selected':'';
                    ?>
                    <option value="<?=$data->Kd_Sesi_Satuan?>" <?=$slc?> ><?=$data->Desc_Sesi?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div> 

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Deskripsi Materi</label>
                </div>
                <div class="col-sm-10">
                  <select name="FKd_Materi_n_Aktifitas" class="form-control select2" style="width: 100%;">
                    <option value="" readonly disabled selected>Pilih Materi</option>
                    <?php
                    foreach ($FKd_Materi_n_Aktifitas->result() as $data) {
                      $slc = ($dtdefault->FKd_Materi_n_Aktifitas==$data->Kd_Materi_n_Aktifitas)? 'selected':'';
                    ?>
                    <option value="<?=$data->Kd_Materi_n_Aktifitas?>" <?=$slc?> ><?=$data->Desc_Materi_n_Aktifitas?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>    

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Nama Instruktur</label>
                </div>
                <div class="col-sm-10">
                  <select name="FId_Instruktur" class="form-control select2" style="width: 100%;">
                    <option value="" readonly disabled selected>Pilih Instruktur</option>
                    <?php
                    foreach ($FId_Instruktur->result() as $data) {
                      $slc = ($dtdefault->FId_Instruktur==$data->Id_Instruktur)? 'selected':'';
                    ?>
                    <option value="<?=$data->Id_Instruktur?>" <?=$slc?> ><?=$data->NamaLengkap_DgnGelar?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>           

              <div class="box-body">
                <?php echo form_open_multipart($this->uri->segment(1).'/'.$this->uri->segment(2)."/store");?>
                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  

                <div class="form-group col-sm-12">
                  <hr style="margin-bottom:0;margin-top:0" />
                </div>

                <div class="form-group col-sm-12"> 
                  <div class="col-sm-3 pull-right">
                    <button type="submit" title="Simpan Data" class="btn btn-block btn-flat btn-success">Save</button>
                  </div>
                  <div class="col-sm-3 pull-right">
                    <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" title="Kembali" class="btn btn-danger btn-block btn-flat">Back</a>
                  </div>
                </div>

              </div><!-- /.box-body -->
            </div> <!-- box-warning -->
          </div> <!-- col -->
       </div> <!-- row -->                     
    </div>
</section>

<script type="text/javascript">  
  $(function () {
    $('.select2').select2()
  })
</script>