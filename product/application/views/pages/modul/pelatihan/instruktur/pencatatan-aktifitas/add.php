<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")?>">
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
        <div class="box box-danger">
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
            <?php echo form_open_multipart($this->uri->segment(1).'/'.$this->uri->segment(2)."/store");?>
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  

            <div class="form-group col-sm-12">
              <div class="col-sm-2">
                <label>Nama Instruktur</label>
              </div>
              <div class="col-sm-10">
                <select name="FId_Instruktur" class="form-control select2" style="width: 100%;" required>
                  <option value="" readonly disabled selected>Pilih Instruktur</option>
                  <?php
                  foreach ($FId_Instruktur->result() as $data) {
                    $slc = ($this->session->flashdata('oldinput')['FId_Instruktur']==$data->Id_Instruktur)? 'selected':'';
                  ?>
                  <option value="<?=$data->Id_Instruktur?>" <?=$slc?> ><?=$data->NamaLengkap_DgnGelar?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>  
            
            <div class="form-group col-sm-12">
              <div class="col-sm-2">
                <label>Jenis Kegiatan</label>
              </div>
              <div class="col-sm-10">
                <select name="optional" class="form-control" id="optional">
                    <option value="">Pilih Jenis Kegiatan</option>
                    <option value="forum diskusi">Forum Diskusi</option>
                    <option value="rapat instruktuktur">Rapat Instruktuktur</option>
                    <option value="pertemuan romadon">Pertemuan Ramadhan</option>
                    <option value="halal bil halal">Halal Bil Halal</option>
                    <option value="gathering">Gathering</option>
                    <option value="pembuatan modul materi">Pembuatan Modul Materi</option>
                    <option value="pembuatan soal">Pembuatan Soal</option>
                    <option value="rapat lainya">Rapat Lainya</option>
                    <option value="lain -lain">Lain - Lain</option>
                </select>
              </div>
            </div>    

            <div class="form-group col-sm-12">
              <div class="col-sm-2">
                <label>Deskripsi Kegiatan</label>
              </div>
              <div class="col-sm-10">
                <textarea class="form-control" required name="Desc_Aktifitas" id="Desc_Aktifitas" placeholder="Deskripsi Kegiatan"><?=$this->session->flashdata('oldinput')['Desc_Aktifitas']?></textarea>
              </div>
            </div>  
            
            <div class="form-group col-sm-12">
              <div class="col-sm-2">
                <label>Tanggal</label>
              </div>
              <div class="col-sm-10">
                <input type="text" class="form-control date" name="Tanggal" id="Tanggal" placeholder="Tanggal Kegiatan" value="<?=$this->session->flashdata('oldinput')['Tanggal']?>" required>
              </div>
            </div> 

            <div class="bootstrap-timepicker">
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Jam Mulai</label>
                </div>
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control timepicker" name="Jam_Mulai" id="Jam_Mulai" value="<?=$this->session->flashdata('oldinput')['Jam_Mulai']?>">
                  </div>
                </div>
              </div> 
            </div>

            <div class="bootstrap-timepicker">
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Jam Berakhir</label>
                </div>
                <div class="col-sm-10">
                  <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-clock-o"></i>
                    </div>
                    <input type="text" class="form-control timepicker" name="Jam_Berakhir" id="Jam_Berakhir" value="<?=$this->session->flashdata('oldinput')['Jam_Berakhir']?>">
                  </div>
                </div>
              </div> 
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-2">
                <label>Keterangan</label>
              </div>
              <div class="col-sm-10">
                <textarea class="form-control" name="Keterangan_Aktifitas" id="Keterangan_Aktifitas" placeholder="Keterangan Kegiatan"><?=$this->session->flashdata('oldinput')['Keterangan_Aktifitas']?></textarea>
              </div>
            </div>        

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
        </div> <!-- box-success -->
      </div> <!-- col -->
    </div> <!-- row -->
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2()
    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false,
      format: 'hh:mm:ss',
    })
    $('.date').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight:true,
    })
  })
</script>