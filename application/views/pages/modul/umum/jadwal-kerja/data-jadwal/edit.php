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
    <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->id_jadwal)?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />

    <div class="col-sm-6">
    <div class="box" style="border-top:0px solid">
        <div class="box-header with-border">
          <h3 class="box-title">Data Jadwal</h3>
        </div>
        <div class="box-body">

            <!-- <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Hari<br/>
                  <select class="form-control" name="hari">
                    <?php
                       $slc1 = ($dtdefault->hari_jadwal=="Minggu")? 'selected':'';
                       $slc2 = ($dtdefault->hari_jadwal=="Senin")? 'selected':'';
                       $slc3 = ($dtdefault->hari_jadwal=="Selasa")? 'selected':'';
                       $slc4 = ($dtdefault->hari_jadwal=="Rabu")? 'selected':'';
                       $slc5 = ($dtdefault->hari_jadwal=="Kamis")? 'selected':'';
                       $slc6 = ($dtdefault->hari_jadwal=="Jum'at")? 'selected':'';
                       $slc7 = ($dtdefault->hari_jadwal=="Sabtu")? 'selected':'';
                    ?>
                      <option value=""<?=$slc3?>>Pilih</option>
                      <option <?=$slc1?>>Minggu</option>
                      <option <?=$slc2?>>Senin</option>
                      <option <?=$slc3?>>Selasa</option>
                      <option <?=$slc4?>>Rabu</option>
                      <option <?=$slc5?>>Kamis</option>
                      <option <?=$slc6?>>Jum'at</option>
                      <option <?=$slc7?>>Sabtu</option>
                  </select>
                </div>
            </div> -->

            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Shift<br/>
                  <input type="text" class="form-control" name="shift" placeholder="Shift" value="<?=$dtdefault->shift_jadwal?>" >
                </div>
            </div>

            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Jam Mulai<br/>
                  <input type="text" class="form-control" name="mulai" placeholder="Jam Mulai Kerja" value="<?=$dtdefault->jam_mulai_jadwal?>" >
                </div>
            </div>

            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Jam Akhir<br/>
                  <input type="text" class="form-control" name="akhir" placeholder="Jam Akhir Kerja" value="<?=$dtdefault->jam_akhir_jadwal?>" >
                </div>
            </div>

            <div class="form-group col-sm-12">
                <div class="col-sm-12" style="color:#00008B">
                  Keterangan<br/>
                  <input type="text" class="form-control" name="keterangan" placeholder="Keterangan" value="<?=$dtdefault->ket_jadwal?>" >
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
