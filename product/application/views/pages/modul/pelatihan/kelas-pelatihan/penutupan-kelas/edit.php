<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<style>
    label {
        color:#00008B;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Ubah Status Kelas
    <small>Data Ubah Status Kelas</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a ><?=$breadcrumb2?></a></li>
    <li class="active">Ubah Status Kelas</li>
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
        <div class="col-md-12"> 
          <div class="box box-warning">

            <div class="box-header with-border">
              <h3 class="box-title">Ubah Status Kelas</h3>
              <div class="box-tools pull-right">
              <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                          title="Kembali Ke Manage <?=$subtitlepage?>">
                    <i class="fa fa-arrow-circle-left"></i> Back</a>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                  <i class="fa fa-refresh"></i> Refresh</button>
              </div>
            </div>

            <div class="box-body">
              <?php echo form_open_multipart($this->uri->segment(1).'/'.$this->uri->segment(2)."/store");?>
              <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  
                
                <div class="form-group col-sm-12">
                <div class="col-sm-3">
                  <label>Nama Kelas & Angkatan (Baku)</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="DescBaku_Kelas_n_Angkatan" id="DescBaku_Kelas_n_Angkatan" value="<?=$dtdefault->DescBaku_Kelas_n_Angkatan?>" readonly>
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-3">
                  <label>Nama Kelas & Angkatan (Ketikan Bebas)</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="DescBebas_Kelas_n_Angkatan" placeholder="Nama Bebas Kelas" id="DescBebas_Kelas_n_Angkatan" value="<?=$dtdefault->DescBebas_Kelas_n_Angkatan?>" readonly>
                </div>
              </div>
              
                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                    <label>Angkatan Ke</label>
                  </div>
                  <div class="col-sm-8">
                    <input type="number" class="form-control" name="No_Urut_Angkatan" id="No_Urut_Angkatan" value="<?=$dtdefault->No_Urut_Angkatan?>" readonly>
                    <input type="hidden" class="form-control" name="no_proforma" value="<?=$dtdefault->idproforma?>" readonly>
                    <input type="hidden" class="form-control" name="sk_pembukaankelas" value="<?=$dtdefault->idskreguler?>" readonly>
                  </div>
                </div>

                <div class="form-group col-sm-12">
                  <div class="col-sm-3">
                    <label>Jenis Pelatihan</label>
                  </div>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" value="<?=$dtdefault->Desc_JenisPelatihan?>" readonly>
                  </div>
                </div>
                
                <?php
                    if($dtdefault->Desc_PershInstansi != ""){ ?>
                        <div class="form-group col-sm-12">
                        <div class="col-sm-3">
                          <label>Perusahaan / Instansi</label>
                        </div>
                        <div class="col-sm-8">
                          <input type="text" class="form-control" value="<?=$dtdefault->Desc_PershInstansi?>" readonly>
                        </div>
                      </div>
                <?php
                    }
                ?>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-3">
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
                <div class="col-sm-3">
                  <label>Summary</label>
                </div>
                <div class="col-sm-8">
                  <textarea class="form-control" name="Summary_Jalannya_Kelas" placeholder="Kesimpulan Kelas"><?=$dtdefault->Summary_Jalannya_Kelas?></textarea>
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-3">
                  <label>Keterangan</label>
                </div>
                <div class="col-sm-8">
                  <textarea class="form-control" name="Keterangan" placeholder="Keterangan Kelas"><?=$dtdefault->Keterangan?></textarea>
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-3">
                  <label>Format Sertifikat</label>
                </div>
                <div class="col-sm-8">
                  <select name="FId_FormatPiagamSertifikat" class="form-control select2" style="width: 100%;">
                    <option value="" readonly disabled selected>Pilih Format</option>
                    <?php
                    foreach ($FId_FormatPiagamSertifikat->result() as $data) {
                      $slc = ($dtdefault->FId_FormatPiagamSertifikat==$data->Id_FormatPiagamSertifikat)? 'selected':'';
                    ?>
                    <option value="<?=$data->Id_FormatPiagamSertifikat?>" <?=$slc?> ><?=$data->Desc_Piagam_Sertifikat?></option>
                    <?php
                    }
                    ?>
                  </select>
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