<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit <?=$titlepage?>
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

    <div class="box-body">
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->Id_Kelas_n_Angkatan)?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  

      <div class="row ">
        <div class="col-md-6"> 
          <div class="box box-warning">

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
                  <label>Nama Kelas & Angkatan (Baku) <span style="color:red">*</span></label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="DescBaku_Kelas_n_Angkatan" id="DescBaku_Kelas_n_Angkatan" value="<?=$dtdefault->DescBaku_Kelas_n_Angkatan?>" readonly>
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Nama Kelas & Angkatan (Ketikan Bebas) <span style="color:red">*</span></label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="DescBebas_Kelas_n_Angkatan" placeholder="Nama Bebas Kelas" id="DescBebas_Kelas_n_Angkatan" value="<?=$dtdefault->DescBebas_Kelas_n_Angkatan?>" required>
                </div>
              </div>
              
                <div class="form-group col-sm-12">
                  <div class="col-sm-4">
                    <label>Angkatan Ke <span style="color:red">*</span></label>
                  </div>
                  <div class="col-sm-8">
                    <input type="number" min="1" class="form-control" name="No_Urut_Angkatan" id="No_Urut_Angkatan" value="<?=$dtdefault->No_Urut_Angkatan?>" required>
                    <input type="hidden" class="form-control" name="no_proforma" value="<?=$dtdefault->idproforma?>">
                    <input type="hidden" class="form-control" name="sk_pembukaankelas" value="<?=$dtdefault->idskreguler?>">
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
                        $slc = ($dtdefault->FId_JenisPelatihan == $data->Id_JenisPelatihan)? 'selected':'';
                    ?>
                    <option value="<?=$data->Id_JenisPelatihan?>" <?=$slc?> ><?=$data->Desc_JenisPelatihan?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              
            <?php
                if($dtdefault->idskreguler == null){
            ?>
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Perusahaan / Instansi <span style="color:red">*</span></label>
                </div>
                <div class="col-sm-8">
                  <select name="FId_PershInstansi" class="form-control select2" style="width: 100%;" required>
                    <option value="" readonly disabled selected>Pilih Perusahaan</option>
                    <?php
                    foreach ($FId_PershInstansi->result() as $data) {
                        $slc = ($dtdefault->FId_PershInstansi == $data->Id_PershInstansi)? 'selected':'';
                    ?>
                    <option value="<?=$data->Id_PershInstansi?>" <?=$slc?> ><?=$data->Desc_PershInstansi?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            <?php
                }
            ?>

              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Kode Singkatan Kelas tsb.</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="KODE_Singkatan" id="KODE_Singkatan" placeholder="Kode Singkatan Kelas" value="<?=$dtdefault->KODE_Singkatan?>">
                </div>
              </div>

            </div><!-- /.box-body -->
          </div> <!-- box-warning -->

          <div class="box box-warning">
            <div class="box-header with-border">
              <h3 class="box-title">Pelaksanaan</h3>
            </div>

            <div class="box-body">
              
              <div class="form-group">
                <label class="col-sm-4 control-label">Jumlah Peserta</label>
                <div class="col-sm-8">
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="number" class="form-control" name="Jml_Peserta" id="Jml_Peserta" placeholder="Jumlah Peserta" value="<?=$dtdefault->Jml_Peserta?>">
                </div>
                </div>
              </div> <br><br>

              <div class="form-group">
                <label class="col-sm-4 control-label">Tanggal Mulai</label>
                <div class="col-sm-8">
                  <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control" name="Tgl_Mulai_Aktual" placeholder="Tanggal Mulai Kelas" id="Tgl_Mulai_Aktual" value="<?=$dtdefault->Tgl_Mulai_Aktual?>">
                </div>
                </div>
              </div> <br><br>

              <div class="form-group">
                <label class="col-sm-4 control-label">Tanggal Selesai</label>
                <div class="col-sm-8">
                  <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="date" class="form-control" name="Tgl_Selesai_Aktual" placeholder="Tanggal Selesai Kelas" id="Tgl_Selesai_Aktual" value="<?=$dtdefault->Tgl_Selesai_Aktual?>">
                </div>
                </div>
              </div> <br><br>
            
              <div class="form-group">
                <label class="col-sm-4 control-label">Lama Hari Pelatihan</label>
                <div class="col-sm-8">
                  <input type="number" class="form-control" name="LamaHariPelatihan" placeholder="Lama Hari" id="LamaHariPelatihan" value="<?=$dtdefault->LamaHariPelatihan?>">  
                </div>
              </div> <br><br>

            </div>
          </div> <!-- box-warning -->
        </div> <!-- col -->

        <div class="col-md-6"> 
          <div class="box box-warning">
            
            <div class="box-header with-border">
              <h3 class="box-title">Lokasi Penyelenggaraan</h3>
            </div>

            <div class="box-body">
              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Kota Tempat Pelatihan</label>
                </div>
                <div class="col-sm-8">
                  <select name="FKd_KotaTraining" class="form-control select2" style="width: 100%;">
                    <option value="" readonly disabled selected>Pilih Kota Training</option>
                    <?php
                    foreach ($FKd_KotaTraining->result() as $data) {
                      $slc = ($dtdefault->FKd_KotaTraining==$data->Kd_KotaTraining)? 'selected':'';
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
                  <input type="text" class="form-control" name="LokasiPenyelenggaraan" placeholder="Lokasi Penyelenggaraan Kelas Kelas" id="LokasiPenyelenggaraan" value="<?=$dtdefault->LokasiPenyelenggaraan?>">
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Google Map (Url)</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="Koordinat_Latitude" placeholder="Google Map (Url)" value="<?=$dtdefault->Koordinat_Latitude?>">
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-4">
                  <label>Status Kelas</label>
                </div>
                <div class="col-sm-8">
                  <select name="Flag_Selesai" class="form-control select2" style="width: 100%;">
                    <option value="" readonly disabled selected>Pilih</option>
                    <?php
                      $selesai = "";
                      if($dtdefault->Flag_Selesai == "B"){
                        $selesai = "Kelas Belum Dimulai";
                      }
                      elseif($dtdefault->Flag_Selesai == "L"){
                        $selesai = "Kelas Sedang Berlangsung";
                      }
                      elseif($dtdefault->Flag_Selesai == "E"){
                        $selesai = "Kelas Sudah Berakhir";
                      }
                      elseif($dtdefault->Flag_Selesai == "C"){
                        $selesai = "Kelas Sudah Ditutup";
                      }
                    ?>
                    <?php
                       $slc1 = ($dtdefault->Flag_Selesai=="B")? 'selected':'';
                       $slc2 = ($dtdefault->Flag_Selesai=="L")? 'selected':'';
                       $slc3 = ($dtdefault->Flag_Selesai=="E")? 'selected':'';
                       $slc4 = ($dtdefault->Flag_Selesai=="C")? 'selected':'';
                    ?>
                    <option value="B"<?=$slc1?>>Kelas Belum Dimulai</option>
                    <option value="L"<?=$slc2?>>Kelas Sedang Berlangsung</option>
                    <option value="E"<?=$slc3?>>Kelas Sudah Berakhir</option>
                    <option value="C"<?=$slc4?>>Kelas Sudah Ditutup</option>
                    }
                    ?>
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

            </div><!-- /.box-body -->
          </div> <!-- box-warning -->
        </div> <!-- col -->
    </div> <!-- row -->              
        
       
    </div>
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2()
  })
</script>