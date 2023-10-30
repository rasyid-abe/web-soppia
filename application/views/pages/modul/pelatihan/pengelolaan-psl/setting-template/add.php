<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")?>">
<style type="text/css">
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
    <div class="alert alert-danger" role='alert'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <?=$this->session->flashdata('error')?>
    </div>
  <?php }else if($this->session->flashdata('success')){ ?>
    <br>
    <div class="alert alert-success" role='alert'>
        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
        <?=$this->session->flashdata('success')?>
    </div>
  <?php } ?>

    <div class="row ">
        <?php if($format == 0){ ?>
          <div class="col-md-12"> 
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Nomor Kelas <?=$kelas->nomor_kelas?> | <?=$kelas->DescBebas_Kelas_n_Angkatan?></h3>
                <div class="box-tools pull-right">
                  <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                          title="Kembali Ke Manage <?=$subtitlepage?>">
                    <i class="fa fa-arrow-circle-left"></i> Back</a>
                  <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                    <i class="fa fa-refresh"></i> Refresh</button>
                </div>
              </div>
    
              <div class="box-body">
                <div class="col-md-6">
                    <!--form action-->
                    <?php echo form_open_multipart($this->uri->segment(1).'/'.$this->uri->segment(2)."/store");?>
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  
                    <input type="hidden" name="id_kelas" value="<?=$kelas->Id_Kelas_n_Angkatan?>" />  
                    
                    <?php if($pesertaqia->num_rows() > 0) { ?>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Nama Peserta</label>
                        </div>
                        <div class="col-sm-8">
                          <select name="id_peserta" class="form-control select2" style="width: 100%;" required>
                            <option value="" readonly disabled selected>Pilih Peserta</option>
                            <?php
                            foreach ($pesertaqia->result() as $data) {
                              $slc = ($this->session->flashdata('oldinput')['id_peserta']==$data->Id_Peserta)? 'selected':'';
                              $nipp = "-";
                              $nama = "-";
                              if($data->NIPP != null){
                                  $nipp = $data->NIPP;
                              }
                              if($data->NamaLengkap_DgnGelar != null){
                                  $nama = $data->NamaLengkap_DgnGelar;
                              }
                            ?>
                            <option value="<?=$data->Id_Peserta?>" <?=$slc?> ><?=$nipp?> | <?=$nama?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if($pesertanonqia->num_rows() > 0) { ?>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Nama Peserta</label>
                        </div>
                        <div class="col-sm-8">
                          <select name="id_peserta" class="form-control select2" style="width: 100%;" required>
                            <option value="" readonly disabled selected>Pilih Peserta</option>
                            <?php
                            foreach ($pesertanonqia->result() as $data) {
                              $slc = ($this->session->flashdata('oldinput')['id_peserta']==$data->Id_Peserta)? 'selected':'';
                              $nipp = "-";
                              $nama = "-";
                              if($data->NIPP != null){
                                  $nipp = $data->NIPP;
                              }
                              if($data->NamaLengkap_DgnGelar != null){
                                  $nama = $data->NamaLengkap_DgnGelar;
                              }
                            ?>
                            <option value="<?=$data->Id_Peserta?>" <?=$slc?> ><?=$nipp?> | <?=$nama?></option>
                            <?php
                            }
                            ?>
                          </select>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <?php if($pesertanonqia->num_rows() == 0 && $pesertaqia->num_rows() == 0) { ?>
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Nama Peserta</label>
                        </div>
                        <div class="col-sm-8">
                          <label><i>Belum ada peserta yang mendaftar.</i></label>
                        </div>
                    </div>
                    <?php } ?>
                    
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Deskripsi</label>
                        </div>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="Desc_Piagam_Sertifikat" placeholder="Deskripsi Piagam Sertifikat"><?=$this->session->flashdata('oldinput')['Desc_Piagam_Sertifikat']?></textarea>
                        </div>
                    </div>
                    
                     <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Tanggal</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control date" name="tanggal" placeholder="Tanggal" value="<?=$this->session->flashdata('oldinput')['tanggal']?>"  required >
                        </div>
                    </div>
                </div> <!--col-6-->
                
                <div class="col-md-6">
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Pembina</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="pembina" placeholder="Pembina" value="<?=$this->session->flashdata('oldinput')['pembina']?>"  required >
                        </div>
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Jabatan</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" value="<?=$this->session->flashdata('oldinput')['jabatan']?>"  required >
                        </div>
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Jenis Font</label>
                        </div>
                        <div class="col-sm-8">
                          <select name="font" class="form-control select2" style="width: 100%;">
                            <option value="" readonly disabled selected>Pilih Font</option>
                            <option>Arial</option>
                            <option>Times New Roman</option>
                            <option>Verdana</option>
                            <option>Constantia</option>
                            <option>Harrington</option>
                          </select>
                        </div>
                    </div>
                    
                    <div class="form-group col-sm-12">
                      <hr style="margin-bottom:0;margin-top:0" />
                    </div>
                  
                    <div class="form-group col-sm-12"> 
                      <div class="col-sm-4 pull-right">
                        <button type="submit" title="Simpan Data" class="btn btn-block btn-flat btn-success">Save</button>
                      </div>
                      <div class="col-sm-4 pull-right">
                        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" title="Kembali" class="btn btn-danger btn-block btn-flat">Back</a>
                      </div>
                    </div>
                </div> <!--col-6-->
              </div><!-- /.box-body -->
            </div> <!-- box-success -->
          </div> <!-- col -->
        <?php } ?>
        
        <!--edit sertifikat-->
        <?php 
            if($format > 0){ 
                $formats = $this->db
                ->join("mst_peserta","mst_peserta.Id_Peserta=mst_formatpiagamsertifikat.id_peserta",'left')
                ->where("mst_formatpiagamsertifikat.id_kelas",$kelas->Id_Kelas_n_Angkatan)
                ->get("mst_formatpiagamsertifikat")->row();
        ?>
        
          <div class="col-md-12 tampil"> 
            <div class="box box-danger">
              <div class="box-header with-border">
                <h3 class="box-title">Nomor Kelas <?=$kelas->nomor_kelas?> | <?=$kelas->DescBebas_Kelas_n_Angkatan?></h3>
                <div class="box-tools pull-right">
                  <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                          title="Kembali Ke Manage <?=$subtitlepage?>">
                    <i class="fa fa-arrow-circle-left"></i> Back</a>
                  <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                    <i class="fa fa-refresh"></i> Refresh</button>
                </div>
              </div>
    
              <div class="box-body">
                <div class="col-md-6">
                    <!--form action-->
                    <?php echo form_open_multipart($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$kelas->Id_Kelas_n_Angkatan);?>
                    <input type="hidden" name="id_kelas" value="<?=$kelas->Id_Kelas_n_Angkatan?>" />  
                    
                    <?php if($pesertaqia->num_rows() > 0) { ?>
                        <div class="form-group col-sm-12">
                            <div class="col-sm-4">
                              <label>Nama Peserta</label>
                            </div>
                            <div class="col-sm-8">
                              <select name="id_peserta" class="form-control select2" style="width: 100%;">
                                <option value="" readonly disabled selected>Pilih Peserta</option>
                                <?php
                                foreach ($pesertaqia->result() as $data) {
                                  $slc = ($formats->id_peserta==$data->Id_Peserta)? 'selected':'';
                                  $nipp = "-";
                                  $nama = "-";
                                  if($data->NIPP != null){
                                      $nipp = $data->NIPP;
                                  }
                                  if($data->NamaLengkap_DgnGelar != null){
                                      $nama = $data->NamaLengkap_DgnGelar;
                                  }
                                ?>
                                <option value="<?=$data->Id_Peserta?>" <?=$slc?> ><?=$nipp?> | <?=$nama?></option>
                                <?php
                                }
                                ?>
                              </select>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <?php if($pesertanonqia->num_rows() > 0) { ?>
                        <div class="form-group col-sm-12">
                            <div class="col-sm-4">
                              <label>Nama Peserta</label>
                            </div>
                            <div class="col-sm-8">
                              <select name="id_peserta" class="form-control select2" style="width: 100%;">
                                <option value="" readonly disabled selected>Pilih Peserta</option>
                                <?php
                                foreach ($pesertanonqia->result() as $data) {
                                  $slc = ($formats->id_peserta==$data->Id_Peserta)? 'selected':'';
                                  $nipp = "-";
                                  $nama = "-";
                                  if($data->NIPP != null){
                                      $nipp = $data->NIPP;
                                  }
                                  if($data->NamaLengkap_DgnGelar != null){
                                      $nama = $data->NamaLengkap_DgnGelar;
                                  }
                                ?>
                                <option value="<?=$data->Id_Peserta?>" <?=$slc?> ><?=$nipp?> | <?=$nama?></option>
                                <?php
                                }
                                ?>
                              </select>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Deskripsi</label>
                        </div>
                        <div class="col-sm-8">
                            <textarea class="form-control" name="Desc_Piagam_Sertifikat" placeholder="Deskripsi Piagam Sertifikat"><?=$formats->Desc_Piagam_Sertifikat?></textarea>
                        </div>
                    </div>
                    
                     <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Tanggal</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control date" name="tanggal" placeholder="Tanggal" value="<?=$formats->tanggal?>"  required >
                        </div>
                    </div>
                </div> <!--col-6-->
                
                <div class="col-md-6">
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Pembina</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="pembina" placeholder="Pembina" value="<?=$formats->pembina?>"  required >
                        </div>
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Jabatan</label>
                        </div>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="jabatan" placeholder="Jabatan" value="<?=$formats->jabatan?>"  required >
                        </div>
                    </div>
                    
                    <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Jenis Font</label>
                        </div>
                        <div class="col-sm-8">
                          <select name="font" class="form-control select2" style="width: 100%;">
                            <option value="" readonly disabled selected>Pilih Font</option>
                            <option <?php if($formats->font=='Arial'){echo "Selected";}?>>Arial</option>
                            <option <?php if($formats->font=='Times New Roman'){echo "Selected";}?>>Times New Roman</option>
                            <option <?php if($formats->font=='Verdana'){echo "Selected";}?>>Verdana</option>
                            <option <?php if($formats->font=='Constantia'){echo "Selected";}?>>Constantia</option>
                            <option <?php if($formats->font=='Harrington'){echo "Selected";}?>>Harrington</option>
                          </select>
                        </div>
                    </div>
                    
                    <div class="form-group col-sm-12">
                      <hr style="margin-bottom:0;margin-top:0" />
                    </div>
                  
                    <div class="form-group col-sm-12"> 
                      <div class="col-sm-4 pull-right">
                        <button type="submit" title="Simpan Data" class="btn btn-block btn-flat btn-success">Save</button>
                      </div>
                      <div class="col-sm-4 pull-right">
                        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" title="Kembali" class="btn btn-danger btn-block btn-flat">Back</a>
                      </div>
                    </div>
                </div> <!--col-6-->
              </div><!-- /.box-body -->
            </div> <!-- box-success -->
          </div> <!-- col -->
        <?php } ?>
    </div> <!-- row -->
    
    <div class="row ">
      <div class="col-md-12"> 
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Output Sertifikasi</h3>
            <div class="box-tools pull-right">
                <?php if($format > 0){ ?>
                    <a class='btn btn-xs btn-warning edits' title='Edit Data'> <i class='fa fa-pencil'></i> Edit </a>
                    <a href="<?=base_url("pengelolaan-psl/setting-template/delete/".$kelas->Id_Kelas_n_Angkatan)?>" class='btn btn-xs btn-danger delete-data' title='Hapus Data'> <i class='fa fa-trash'></i> Hapus </a>
                    <a class='btn btn-xs btn-primary' title='Print Data' onclick="printContent('div1')"> <i class='fa fa-print'></i> Print </a>
                <?php } ?>
            </div>
          </div>
          <div class="box-body" id="div1">
            <div class="form-group col-sm-12">
                <div class="container">
                    <?php
                        
                    ?>
                    
                    <div class="centered" style="margin-right: 15%">
                        <?php
                            $peserta = "<i>tempat untuk nama peserta</i>";
                            $deskripsi = "<i>tempat deskripsi piagam sertifikat</i>";
                            $tanggal = tgl_indo(date('Y-m-d'));
                            $pembina = "tempat untuk nama pembina atau atasan";
                            $jabatan = "<i>tempat untuk nama jabatan</i>";
                            
                            $font = "Arial";
                            if($format > 0){
                                $format = $this->db
                                ->join("mst_peserta","mst_peserta.Id_Peserta=mst_formatpiagamsertifikat.id_peserta",'left')
                                ->where("mst_formatpiagamsertifikat.id_kelas",$kelas->Id_Kelas_n_Angkatan)
                                ->get("mst_formatpiagamsertifikat")->row();
                                
                                $peserta = $format->NamaLengkap_DgnGelar;
                                $deskripsi = $format->Desc_Piagam_Sertifikat;
                                $tanggal = tgl_indo($format->tanggal);
                                $pembina = $format->pembina;
                                $jabatan = $format->jabatan;
                                $font = $format->font;
                            }
                        ?>
                        <style>
                            .centered {
                                text-align: center;
                                font-family: <?=$font?>;
                            }
                        </style>
                        <div style="margin-top: 12%;">&nbsp;</div>
                        <div style="margin-top: 20px">
                            <h1>&nbsp;</h1>
                            <p style="font-size: 30px; font-weight: bold"><?=$peserta?></p>
                            <p style="margin-top: 28px">
                                <?=$deskripsi?>
                            </p>
                            <div class="row" style="padding-top: 50px;padding-bottom: 30px">
                                <div class="col-md-6">
                                    
                                </div>
                                <div class="col-md-6">
                                    <p>Jakarta, <?=$tanggal?></p> <br/><br/><br/>
                                    <b><u><?=$pembina?></u></b>
                                    <p><?=$jabatan?></p>
                                </div>
                            </div>
                        </div>
                    </div> <!--centered-->
                </div> <!--container-->
            </div> <!--col-12-->
          </div><!-- /.box-body -->
        </div> <!-- box-success -->
      </div> <!-- col-12 -->
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
<script>
function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>
<script>
$(document).ready(function(){
    $(".tampil").hide();
    $(".edits").click(function(){
        $(".tampil").show();
    });
});
</script>