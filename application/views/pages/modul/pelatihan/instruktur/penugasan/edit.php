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
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->Id_InstrukturNgajar_diKelas)?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Tanggal Mengajar</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?=$dtdefault->Tgl_Mengajar?>" readonly>
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Nama Instruktur</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?=$dtdefault->NamaLengkap_DgnGelar?>" readonly>
                </div>
              </div>      

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Kelas & Angkatan</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?=$dtdefault->DescBebas_Kelas_n_Angkatan?>" readonly>
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Deskripsi Materi</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?=$dtdefault->Desc_Materi_n_Aktifitas?>" readonly>
                </div>
              </div>   

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Keterangan</label>
                </div>
                <div class="col-sm-10">
                  <textarea class="form-control" name="Keterangan" placeholder="Keterangan" id="Keterangan"><?=$dtdefault->Keterangan?></textarea>
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