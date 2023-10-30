<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/style/jquery-ui.css")?>">
<style>
    label {
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
    <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->id_kinerja)?>" method="POST" enctype="multipart/form-data">
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
                    <div class="col-sm-2">
                      <label>Nama Pegawai</label>
                    </div>
                    <div class="col-sm-10">
                      <select name="id_pegawai" class="form-control select2" style="width: 100%;">
                        <option value="" readonly disabled selected>Pilih Pegawai</option>
                        <?php
                        foreach ($pegawai->result() as $data) {
                          $slc = ($dtdefault->id_pegawai==$data->id_pegawai)? 'selected':'';
                        ?>
                        <option value="<?=$data->id_pegawai?>" <?=$slc?> ><?=$data->nama_pegawai?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>

            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Kedisiplinan</label>
              <div class="col-sm-10">
                <select class="form-control select2" name="kedisiplinan" id="kedisiplinan">
                  <option value="" selected readonly disabled>Pilih Penilaian</option>
                  <?php
                    $slc1 = ($dtdefault->kedisiplinan == "A") ? "selected":"";
                    $slc2 = ($dtdefault->kedisiplinan == "B") ? "selected":"";
                    $slc3 = ($dtdefault->kedisiplinan == "C") ? "selected":"";
                    $slc4 = ($dtdefault->kedisiplinan == "D") ? "selected":"";
                  ?>
                  <option value="A" <?=$slc1?>>A</option>
                  <option value="B" <?=$slc2?>>B</option>
                  <option value="C" <?=$slc3?>>C</option>
                  <option value="D" <?=$slc4?>>D</option>
                </select>
              </div>
            </div>
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Tanggung Jawab</label>
              <div class="col-sm-10">
                <select class="form-control select2" name="tanggung_jawab" id="tanggung_jawab">
                  <option value="" selected readonly disabled>Pilih Penilaian</option>
                  <?php
                    $slc1 = ($dtdefault->tanggung_jawab == "A") ? "selected":"";
                    $slc2 = ($dtdefault->tanggung_jawab == "B") ? "selected":"";
                    $slc3 = ($dtdefault->tanggung_jawab == "C") ? "selected":"";
                    $slc4 = ($dtdefault->tanggung_jawab == "D") ? "selected":"";
                  ?>
                  <option value="A" <?=$slc1?>>A</option>
                  <option value="B" <?=$slc2?>>B</option>
                  <option value="C" <?=$slc3?>>C</option>
                  <option value="D" <?=$slc4?>>D</option>
                </select>
              </div>
            </div>
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Komunikasi</label>
              <div class="col-sm-10">
                <select class="form-control select2" name="komunikasi" id="komunikasi">
                  <option value="" selected readonly disabled>Pilih Penilaian</option>
                  <?php
                    $slc1 = ($dtdefault->komunikasi == "A") ? "selected":"";
                    $slc2 = ($dtdefault->komunikasi == "B") ? "selected":"";
                    $slc3 = ($dtdefault->komunikasi == "C") ? "selected":"";
                    $slc4 = ($dtdefault->komunikasi == "D") ? "selected":"";
                  ?>
                  <option value="A" <?=$slc1?>>A</option>
                  <option value="B" <?=$slc2?>>B</option>
                  <option value="C" <?=$slc3?>>C</option>
                  <option value="D" <?=$slc4?>>D</option>
                </select>
              </div>
            </div>
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Antusiasme Kerja</label>
              <div class="col-sm-10">
                <select class="form-control select2" name="antusias_kerja" id="antusias_kerja">
                  <option value="" selected readonly disabled>Pilih Penilaian</option>
                  <?php
                    $slc1 = ($dtdefault->antusias_kerja == "A") ? "selected":"";
                    $slc2 = ($dtdefault->antusias_kerja == "B") ? "selected":"";
                    $slc3 = ($dtdefault->antusias_kerja == "C") ? "selected":"";
                    $slc4 = ($dtdefault->antusias_kerja == "D") ? "selected":"";
                  ?>
                  <option value="A" <?=$slc1?>>A</option>
                  <option value="B" <?=$slc2?>>B</option>
                  <option value="C" <?=$slc3?>>C</option>
                  <option value="D" <?=$slc4?>>D</option>
                </select>
              </div>
            </div>
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Nama Pegawai</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="keterangan" id="keterangan" value="<?=$dtdefault->keterangan?>" >
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
<script src="<?=base_url("assets/script/jquery-ui.js")?>"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $( "#nama_pegawai" ).autocomplete({
      source: "<?php echo site_url('kepegawaian/kinerja_pegawai/get_autocomplete'); ?>",
      select: function (event, ui) {
        $('[name="nama_pegawai"]').val(ui.item.label);
        $('[name="id_pegawai"]').val(ui.item.id_pegawai);
      }
    });
  });
</script>
