<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net/buttons.dataTables.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")?>">
<style>
    label{
        color:#00008B;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Pengantaran / Entry Permohonan Placement
    <small>Data Permohonan</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a>Konektifitas DS QIA</a></li>
    <li class="active">Permohonan</li>
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
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Tambah Pengantaran / Entry Permohonan Placement</h3>
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
              <label class="col-sm-2 control-label">Nama Peserta</label>
              <div class="col-sm-10">
                <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-user"></i>
                </div>
                <select name="FId_Peserta" class="form-control select2" style="width: 100%;" required>
                  <option value="" readonly disabled selected>Pilih Peserta</option>
                  <?php
                  foreach ($FId_Peserta->result() as $data) {
                    $slc = ($this->session->flashdata('oldinput')['FId_Peserta']==$data->Id_Peserta)? 'selected':'';
                  ?>
                  <option value="<?=$data->Id_Peserta?>" <?=$slc?> ><?=$data->NamaLengkap_DgnGelar?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              </div>
            </div>  

            <div class="form-group col-sm-12">
              <div class="col-sm-2">
                <label>Pelatihan QIA</label>
              </div>
              <div class="col-sm-10">
                <select name="Flag_PernahPelatihanQIASebelumnya" id="Flag_PernahPelatihanQIASebelumnya" class="form-control select2" style="width: 100%;" required>
                  <option value="" readonly disabled selected>Pilih</option>                  
                  <option value="Y">Pernah Ikut Pelatihan</option>                  
                  <option value="N">Belum Pernah Ikut Pelatihan</option>                
                </select>
              </div>
            </div>

            <div class="form-group col-sm-12 kelasqia">
              <div class="col-sm-2">
                <label>Kelas QIA</label>
              </div>
              <div class="col-sm-10">
                <select name="StatusKelasQIA_SaatIni" id="StatusKelasQIA_SaatIni" class="form-control select2" style="width: 100%;" required>
                  <option value="" readonly disabled selected>Pilih Kelas QIA (Yang Diinginkan/Yang Pernah Diikuti)</option>            
                  <option value="A">Dasar 1</option>                
                  <option value="B">Dasar 2</option>                
                  <option value="C">Lanjutan 1</option>                
                  <option value="D">Lanjutan 2</option>                
                  <option value="E">Manajerial</option>                
                  <option value="AA">DASAR</option>                
                  <option value="BB">LANJUTAN</option>                
                  <option value="CC">MANAJERIAL</option>                
                </select>
              </div>
            </div>
           
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">File CV Peserta</label>
              <div class="col-sm-10">
              <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-folder"></i>
                </div>
                <input type="file" class="form-control" name="Path_CV_Peserta[]" placeholder="File CV Peserta" id="Path_CV_Peserta" multiple >
              </div>
              <p class="pull-left" style="color:grey">File berupa: .jpg .pdf .doc .xls .txt (Max: 3 Mb)</p>
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
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
    $(document).on("change","#Flag_PernahPelatihanQIASebelumnya",function(){
      var _thisval = $(this).val();
      if(_thisval == "N"){
        $("#StatusKelasQIA_SaatIni").prop("disabled", true); 
      }else{
        $("#StatusKelasQIA_SaatIni").prop("disabled", false); 
      }
    });
    $('.date').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight:true,
    });
  });
</script>
