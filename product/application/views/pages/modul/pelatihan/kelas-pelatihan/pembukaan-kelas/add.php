<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")?>">
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

    <div class="row ">
      <div class="col-md-6"> 
        <div class="box box-success">

          <div class="box-header with-border">
            <h3 class="box-title">Detail Kelas</h3>
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
                <div class="col-sm-4">
                  <label>Pilih Kelas <span style="color:red">*</span></label>
                </div>
                <div class="col-sm-8">
                  <select name="jenis_kelas" class="form-control select2" id="jenis_kelas" style="width: 100%;" required>
                    <option value="" selected>Pilih Kelas</option>
                    <option value="IHT" >IHT</option>
                    <option value="NONIHT" >NON IHT</option>
                  </select>
                </div>
              </div>
              <div class="form-group col-sm-12 tamp-kelas-pembukaan-kelas">
              </div>
              <div class="form1 hide">
                  
              <div class="form-group col-sm-12">
              <div class="col-sm-4">
                <label>Nama Kelas & Angkatan (Ketikan Bebas) <span style="color:red">*</span></label>
              </div>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="DescBebas_Kelas_n_Angkatan" id="DescBebas_Kelas_n_Angkatan" placeholder="Deskripsi Bebas Kelas" required>
              </div>
            </div>
            
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Jenis Pelatihan <span style="color:red">*</span></label>
                </div>
                <div class="col-sm-8">
                  <select name="FId_JenisPelatihan" class="form-control select2" style="width: 100%;" required>
                    <option value="" readonly disabled selected>Pilih Jenis Pelatihan</option>
                    <?php
                    foreach ($FId_JenisPelatihan->result() as $data) {
                      $slc = ($this->session->flashdata('oldinput')['FId_JenisPelatihan']==$data->Id_JenisPelatihan)? 'selected':'';
                    ?>
                    <option value="<?=$data->Id_JenisPelatihan?>" <?=$slc?> ><?=$data->Desc_JenisPelatihan?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>

            <div class="form-group col-sm-12" id="tamp-perusahaan">
              <div class="col-sm-4">
                <label>Perusahaan / Instansi <span style="color:red">*</span></label>
              </div>
              <div class="col-sm-8">
                <select name="FId_PershInstansi" class="form-control select2" style="width: 100%;">
                  <option value="" readonly disabled selected>Pilih Perusahaan / Instansi</option>
                  <?php
                  foreach ($FId_PershInstansi->result() as $data) {
                    $slc = ($this->session->flashdata('oldinput')['FId_PershInstansi']==$data->Id_PershInstansi)? 'selected':'';
                  ?>
                  <option value="<?=$data->Id_PershInstansi?>" <?=$slc?> ><?=$data->Desc_PershInstansi?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-4">
                <label>Angkatan Ke <span style="color:red">*</span></label>
              </div>
              <div class="col-sm-8">
                <input type="number" min="1" class="form-control" name="No_Urut_Angkatan" id="No_Urut_Angkatan" placeholder="Angkatan Ke" value="<?=$this->session->flashdata('oldinput')['No_Urut_Angkatan']?>" required>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-4">
                <label>Kode Singkatan Kelas tsb.</label>
              </div>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="KODE_Singkatan" id="KODE_Singkatan" placeholder="Kode Singkatan" value="<?=$this->session->flashdata('oldinput')['KODE_Singkatan']?>">
              </div>
            </div>
            </div>
          </div><!-- /.box-body -->
        </div> <!-- box-success -->

        <div class="box box-success form2  hide">
          <div class="box-header with-border">
            <h3 class="box-title">Pelaksanaan</h3>
          </div>

          <div class="box-body">
            
            <div class="form-group col-sm-12">
              <label class="col-sm-4 control-label">Jumlah Peserta</label>
              <div class="col-sm-8">
                <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-user"></i>
                </div>
                <input type="number" min="0" class="form-control" name="Jml_Peserta" id="Jml_Peserta" placeholder="Jumlah Peserta" value="<?=$this->session->flashdata('oldinput')['Jml_Peserta']?>">
              </div>
              </div>
            </div> 

            <div class="form-group col-sm-12">
              <label class="col-sm-4 control-label">Tanggal Mulai</label>
              <div class="col-sm-8">
                <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control date" name="Tgl_Mulai_Aktual" id="Tgl_Mulai_Aktual" placeholder="Tanggal Mulai" value="<?=$this->session->flashdata('oldinput')['Tgl_Mulai_Aktual']?>">
              </div>
              </div>
            </div> 

            <div class="form-group col-sm-12">
              <label class="col-sm-4 control-label">Tanggal Selesai</label>
              <div class="col-sm-8">
                <div class="input-group date">
                <div class="input-group-addon">
                  <i class="fa fa-calendar"></i>
                </div>
                <input type="text" class="form-control date" name="Tgl_Selesai_Aktual" id="Tgl_Selesai_Aktual" placeholder="Tanggal Selesai" value="<?=$this->session->flashdata('oldinput')['Tgl_Selesai_Aktual']?>">
              </div>
              </div>
            </div> 
          
            <div class="form-group col-sm-12">
              <label class="col-sm-4 control-label">Lama Hari Pelatihan</label>
              <div class="col-sm-8">
                <input type="number" min="0" class="form-control" name="LamaHariPelatihan" id="LamaHariPelatihan" placeholder="Lama Hari Pelatihan" value="<?=$this->session->flashdata('oldinput')['LamaHariPelatihan']?>">  
              </div>
            </div> 

          </div>
        </div> <!-- box-success -->
      </div> <!-- col -->

      <div class="col-md-6 form3 hide"> 
        <div class="box box-success">
          
          <div class="box-header with-border">
            <h3 class="box-title">Lokasi Penyelenggaraan</h3>
          </div>

          <div class="box-body">
            <?php echo form_open_multipart($this->uri->segment(1).'/'.$this->uri->segment(2)."/store");?>
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />   

              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Kota Tempat Pelatihan</label>
                </div>
                <div class="col-sm-8">
                  <select name="FKd_KotaTraining" class="form-control select2" style="width: 100%;">
                    <option value="" readonly disabled selected>Pilih Kota</option>
                    <?php
                    foreach ($FKd_KotaTraining->result() as $data) {
                      $slc = ($this->session->flashdata('oldinput')['FKd_KotaTraining']==$data->Kd_KotaTraining)? 'selected':'';
                    ?>
                    <option value="<?=$data->Kd_KotaTraining?>" <?=$slc?> ><?=$data->Desc_KotaTraining?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Lokasi Penyelenggaraan</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="LokasiPenyelenggaraan" id="LokasiPenyelenggaraan" placeholder="Lokasi Selenggara" value="<?=$this->session->flashdata('oldinput')['LokasiPenyelenggaraan']?>">
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Google Map (Url)</label></label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="Koordinat_Latitude" placeholder="Google Map (Url)" value="<?=$this->session->flashdata('oldinput')['Koordinat_Latitude']?>">
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
    $('.date').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight:true,
    });
    $(document).on("change","#jenis_kelas",function(){
        var thisval = $(this).val();
        $(".form1").addClass("hide");
        $(".form2").addClass("hide");
        $(".form3").addClass("hide");
        if(thisval == ""){
            $(".tamp-kelas-pembukaan-kelas").html("");
        }else{
            if(thisval == 'IHT'){
                $("#tamp-perusahaan").show();
            }else{
                $("#tamp-perusahaan").hide();
            }
            var link = _BASE_URL_+'kelas-pelatihan/pembukaan-kelas/getfromselect/'+thisval;
            $(".tamp-kelas-pembukaan-kelas").load(link,function(){
                $('.select2').select2();
                $(document).on("change","#sk_pembukaankelas",function(){
                    var thisval = $(this).val();
                    if(thisval == ""){
                        $(".form1").addClass("hide");
                        $(".form2").addClass("hide");
                        $(".form3").addClass("hide");
                    }else{
                        $(".form1").removeClass("hide");
                        $(".form2").removeClass("hide");
                        $(".form3").removeClass("hide");
                    }
                });
                
                $(document).on("change","#no_proforma",function(){
                    var thisval = $(this).val();
                    if(thisval == ""){
                        $(".form1").addClass("hide");
                        $(".form2").addClass("hide");
                        $(".form3").addClass("hide");
                    }else{
                        $(".form1").removeClass("hide");
                        $(".form2").removeClass("hide");
                        $(".form3").removeClass("hide");
                    }
                });
            });
        }
    });
   
    
  })
</script>