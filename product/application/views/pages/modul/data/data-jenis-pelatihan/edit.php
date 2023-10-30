<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$titlepage?>
    <small><?=$subtitlepage?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li class="active"><?=$breadcrumb2?></li>
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
      <form action="<?=base_url($this->uri->segment(1)."/update/".$dtdefault->Id_JenisPelatihan)?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />   

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Nama Jenis Pelatihan <br/>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name"  value="<?=$dtdefault->Desc_JenisPelatihan?>" >
          </div>
        </div>
        
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Tingkatan Pelatihan <br/>
            <select name="tingkatanpelatian" class="form-control select2">
             <?php
                $status_pel = $dtdefault->status_pel;
                if($status_pel == 'dsr1'){$slc1 = "selected";}else{ $slc1 = ""; }
                if($status_pel == 'dsr2'){$slc2 = "selected";}else{ $slc2 = ""; }
                if($status_pel == 'DSR'){$slc3 = "selected";}else{ $slc3 = ""; }
                if($status_pel == 'lnjt1'){$slc4 = "selected";}else{ $slc4 = ""; }
                if($status_pel == 'lnjt2'){$slc5 = "selected";}else{ $slc5 = ""; }
                if($status_pel == 'LNJT'){$slc6 = "selected";}else{ $slc6 = ""; }
                if($status_pel == 'mnj'){$slc7 = "selected";}else{ $slc7 = ""; }
                if($status_pel == 'MNJT'){$slc8 = "selected";}else{ $slc8 = ""; }
                
             ?>
              <option value="" readonly selected disabled>Tingkatan Pelatihan</option>
              <option value="dsr1" <?=$slc1?> >Dasar I</option>
              <option value="dsr2" <?=$slc2?> >Dasar II</option>
              <option value="DSR" <?=$slc3?> >DASAR</option>
              <option value="lnjt1" <?=$slc4?> >Lanjutan I</option>
              <option value="lnjt2" <?=$slc5?> >Lanjutan II</option>
              <option value="LNJT" <?=$slc6?> >LANJUTAN</option>
              <option value="mnj" <?=$slc7?> >Manajerial</option>
              <option value="MNJT" <?=$slc8?> >MANAJERIAL</option>
            </select>
          </div>
        </div>
      
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Kelompok Pelatihan <br/>
            <select name="kelompokpelatihan" class="form-control select2">
              <option value="" readonly selected disabled>Kelompok Pelatihan</option>
              <?php
                foreach ($kelompokpelatihan->result() as $vle) {
                  $slc = ($dtdefault->FKd_KelompokPelatihan == $vle->Kd_KelompokPelatihan)? 'selected':'';
              ?>
              <option value="<?=$vle->Kd_KelompokPelatihan?>" <?=$slc?> ><?=$vle->Desc_KelompokPelatihan?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>
      
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            IHT <br/>
            <select name="iht" class="form-control select2">
              <option value="" readonly selected disabled>IHT</option>
              <?php
                $slc1 = ($dtdefault->Flag_IHT =="Y")? 'selected':'';
                $slc2 = ($dtdefault->Flag_IHT =="N")? 'selected':'';
              ?>
              <option value="Y" <?=$slc1?> >Ya</option>
              <option value="N" <?=$slc2?> >Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            QIA <br/>
            <select name="qia" class="form-control select2">
              <option value="" readonly selected disabled>QIA</option>
              <?php
                $slc11 = ($dtdefault->Flag_QIA =="Y")? 'selected':'';
                $slc22 = ($dtdefault->Flag_QIA =="N")? 'selected':'';
              ?>
              <option value="Y" <?=$slc11?> >Ya</option>
              <option value="N" <?=$slc22?> >Tidak</option>
            </select>
          </div>
        </div>


        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Default Awal QIA <br/>
            <select name="defaultawalqia" class="form-control select2">
              <option value="" readonly selected disabled>Default Awal QIA</option>
              <?php
                $slc1f = ($dtdefault->Flag_DefaultAwalQIA =="Y")? 'selected':'';
                $slc2f = ($dtdefault->Flag_DefaultAwalQIA =="N")? 'selected':'';
              ?>
              <option value="Y" <?=$slc1f?> >Ya</option>
              <option value="N" <?=$slc2f?> >Tidak</option>
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Jenis Pelatihan I <br/>
            <select name="jenispelatihan1" class="form-control select2">
              <option value="" readonly selected disabled>Jenis Pelatihan I</option>
              <?php
                foreach ($jenispelatihan1->result() as $vlea) {
                  $slca1 = ($dtdefault->FKd_JnsPelatihan1 == $vlea->Kd_JnsPelatihan1)? 'selected':'';
              ?>
              <option value="<?=$vlea->Kd_JnsPelatihan1?>" <?=$slca1?> ><?=$vlea->Desc_JnsPelatihan1?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Jenis Pelatihan II <br/>
            <select name="jenispelatihan2" class="form-control select2">
              <option value="" readonly selected disabled>Jenis Pelatihan II</option>
              <?php
                foreach ($jenispelatihan2->result() as $vleb) {
                  $slcb1 = ($dtdefault->FKd_JnsPelatihan2 == $vleb->Kd_JnsPelatihan2)? 'selected':'';
              ?>
              <option value="<?=$vleb->Kd_JnsPelatihan2?>" <?=$slcb1?> ><?=$vleb->Desc_JnsPelatihan2?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Jenis Pelatihan III <br/>
            <select name="jenispelatihan3" class="form-control select2">
              <option value="" readonly selected disabled>Jenis Pelatihan III</option>
              <?php
                foreach ($jenispelatihan3->result() as $vlec) {
                  $slcc1 = ($dtdefault->FKd_JnsPelatihan3 == $vlec->Kd_JnsPelatihan3)? 'selected':'';
              ?>
              <option value="<?=$vlec->Kd_JnsPelatihan3?>" <?=$slcc1?> ><?=$vlec->Desc_JnsPelatihan3?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Kode Singkat <br/>
            <input type="text" class="form-control" name="kodesingkat" id="kodesingkat" placeholder="Kode Singkat"  value="<?=$dtdefault->KODE_Singkatan?>" >
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Keterangan <br/>
            <textarea class="form-control" name="keterangan" id="keterangan" placeholder="Keterangan"><?=$dtdefault->Keterangan?></textarea>
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
            <a href="<?=base_url($this->uri->segment(1))?>" class="btn btn-danger btn-block btn-flat">Back</a>
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