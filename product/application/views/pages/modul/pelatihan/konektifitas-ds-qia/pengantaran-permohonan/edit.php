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
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Edit Pengantaran / Entry Permohonan Placement</h3>
            <div class="box-tools pull-right">
              <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                      title="Kembali Ke Manage <?=$subtitlepage?>">
                <i class="fa fa-arrow-circle-left"></i> Back</a>
              <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                <i class="fa fa-refresh"></i> Refresh</button>
            </div>
          </div>

    <div class="box-body">
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->FId_Peserta)?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  

              <div class="form-group col-sm-12">
                <label class="col-sm-2 control-label">Nama Peserta</label>
                <div class="col-sm-10">
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" value="<?=$dtdefault->NamaLengkap_TanpaGelar?>" readonly>
                </div>
                </div>
              </div>  

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Pelatihan QIA</label>
                </div>
                <div class="col-sm-10">
                  <select name="Flag_PernahPelatihanQIASebelumnya" id="Flag_PernahPelatihanQIASebelumnya" class="form-control select2" style="width: 100%;">
                      <?php
                           $slc1 = ($dtdefault->Flag_PernahPelatihanQIASebelumnya=="Y")? 'selected':'';
                           $slc2 = ($dtdefault->Flag_PernahPelatihanQIASebelumnya=="N")? 'selected':'';
                        ?>
                    <option value="Y"<?=$slc1?>>Pernah Ikut Pelatihan</option>                  
                    <option value="N"<?=$slc2?>>Belum Pernah Ikut Pelatihan</option>                
                  </select>
                </div>
              </div>
              
              <div class="form-group col-sm-12 kelasqia">
                <div class="col-sm-2">
                  <label>Kelas QIA</label>
                </div>
                <div class="col-sm-10">
                  <select name="StatusKelasQIA_SaatIni" id="StatusKelasQIA_SaatIni" class="form-control select2" style="width: 100%;">
                   <?php
                       $slc1 = ($dtdefault->StatusKelasQIA_SaatIni=="A")? 'selected':'';
                       $slc2 = ($dtdefault->StatusKelasQIA_SaatIni=="B")? 'selected':'';
                       $slc3 = ($dtdefault->StatusKelasQIA_SaatIni=="C")? 'selected':'';
                       $slc4 = ($dtdefault->StatusKelasQIA_SaatIni=="D")? 'selected':'';
                       $slc5 = ($dtdefault->StatusKelasQIA_SaatIni=="E")? 'selected':'';
                       $slc6 = ($dtdefault->StatusKelasQIA_SaatIni=="AA")? 'selected':'';
                       $slc7 = ($dtdefault->StatusKelasQIA_SaatIni=="BB")? 'selected':'';
                       $slc8 = ($dtdefault->StatusKelasQIA_SaatIni=="CC")? 'selected':'';
                    ?>
                    <option value="">Pilih Kelas</option>                
                    <option value="A"<?=$slc1?>>Dasar 1</option>                
                    <option value="B"<?=$slc2?>>Dasar 2</option>                
                    <option value="C"<?=$slc3?>>Lanjutan 1</option>                
                    <option value="D"<?=$slc4?>>Lanjutan 2</option>                
                    <option value="E"<?=$slc5?>>Manajerial</option>                
                    <option value="AA"<?=$slc6?>>DASAR</option>                
                    <option value="BB"<?=$slc7?>>LANJUTAN</option>                
                    <option value="CC"<?=$slc8?>>MANAJERIAL</option>                
                  </select>
                </div>
              </div>
                
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">File CV Peserta</label>
              <div class="col-sm-5">
                <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-folder"></i>
                    </div>
                    <input type="file" class="form-control" name="Path_CV_Peserta[]" placeholder="File CV Peserta" id="Path_CV_Peserta" multiple >
                </div>
                <p class="pull-right" style="color:grey">File berupa: .jpg .pdf .doc .xls .txt (Max: 3 Mb)</p>
              </div>
              <div class="col-sm-5">
                <b>File Sebelumnya : </b>
                <?php

                  if($dtdefault->Path_CV_Peserta != null){
                    $data = $dtdefault->Path_CV_Peserta;
                    if(file_exists("./uploads/fileapps/dsqia/".$data)){
                      echo '<a href="'.base_url("./uploads/fileapps/dsqia/".$data).'" download > <i class="fa fa-download"></i> download file</a> <button type="button" data="'.$data.'" class="btn btn-danger btn-xs" id="delete-file-placement"> <i class="fa fa-trash"></i> </button>';
                    }else{
                      $data = explode(',',$data);
                      $rs = '<br/>';
                      foreach ($data as $key => $value) {
                        $dt = $this->db->where(array('idmeta'=>$value,'sourcefile'=>'pengantar_placement'))->get('meta_file_new')->row();
                        $rs .= '<a href="'.base_url("./uploads/fileapps/dsqia/".$dt->namefile).'" download > <i class="fa fa-download"></i> download file '.($dt->namefile).'</a> <button type="button" data="'.$value.'" class="btn btn-danger btn-xs" id="delete-file-placement"> <i class="fa fa-trash"></i> </button> <br/>';
                      }
                      echo $rs;
                    }
                  }else{
                    echo '<code>N/A</code>';
                  }
                ?>
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
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();

    $('.date').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight:true,
    });

    $(document).on("change","#Flag_PernahPelatihanQIASebelumnya",function(){
      var _thisval = $(this).val();
      if(_thisval == "N"){
        $("#StatusKelasQIA_SaatIni").prop("disabled", true); 
      }else{
        $("#StatusKelasQIA_SaatIni").prop("disabled", false); 
      }
    });

    $(document).on("click",'#delete-file-placement',function(){
        var _data = $(this).attr("data");
        var self = $(this);
        $.getJSON('<?=base_url("konektifitas-ds-qia/Pengantaran_permohonan/getjson")?>',{ data : _data,peserta:'<?=$dtdefault->FId_Peserta?>'},function(data){
          if(data.status == true){
            self.next().remove();
            self.prev().remove();
            self.remove();
          }
        });
    });

  });
</script>
