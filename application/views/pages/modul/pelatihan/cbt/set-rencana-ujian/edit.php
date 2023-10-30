<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
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
        <div class="box box-success">         
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
            <div class="form-group col-sm-12" align="center">
                <h3><img src="<?=base_url()?>/assets/images/soppia.png" width="70" height="70" /> <b>YAYASAN PENDIDIKAN INTERNAL AUDIT (YPIA)</b> <img src="<?=base_url()?>/assets/images/dsqia.png" width="70" height="70" /></h3>
            </div>
            
            <div class="form-group col-sm-12">
                <hr style="margin-bottom:0;margin-top:0" />
            </div>
            
            <form action="<?=base_url($this->uri->segment(1)."/".$this->uri->segment(2)."/update/".$dtdefault->Kd_SettingRencanaUjian)?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" /> 
            <div class="form-group col-sm-6">
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Tanggal Ujian</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <input type="date" class="form-control" name="Tgl_Ujian" placeholder="Tanggal Ujian Berlangsung" value="<?=$dtdefault->Tgl_Ujian?>" required/>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Kelas Pelatihan</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <select  class="form-control select2" name="FId_Kelas_n_Angkatan" required>
                          <option value="" selected readonly>Pilih Kelas Pelatihan</option>
                          <?php
                            foreach ($kelas->result() as $data) {
                              $slcb1 = ($dtdefault->FId_Kelas_n_Angkatan == $data->Id_Kelas_n_Angkatan)? 'selected':'';
                          ?>
                              <option value="<?=$data->Id_Kelas_n_Angkatan?>" <?=$slcb1?> ><?=$data->DescBebas_Kelas_n_Angkatan?></option>
                          <?php
                            }
                          ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Materi Pelatihan</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <select  class="form-control select2" name="FKd_Materi_n_Aktifitas" required>
                          <option value="" selected readonly>Materi dan Aktifitas</option>
                          <?php
                            foreach ($materi->result() as $data) {
                              $slcb1 = ($dtdefault->FKd_Materi_n_Aktifitas == $data->Kd_Materi_n_Aktifitas)? 'selected':'';
                          ?>
                              <option value="<?=$data->Kd_Materi_n_Aktifitas?>" <?=$slcb1?> ><?=$data->Desc_Materi_n_Aktifitas?></option>
                          <?php
                            }
                          ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Username Pembuka</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <input type="text" class="form-control" name="UserNama_Pembuka" placeholder="Username Pembuka" value="<?=$dtdefault->UserNama_Pembuka?>" required/>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Password Pembuka (isi jika ingin menganti password)</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <input type="password" class="form-control" name="Password_Pembuka" placeholder="Password Pembuka" />
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Skor Benar</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-4">
                      <input type="number" min="1" class="form-control" value="<?=$dtdefault->Skor_Benar?>" name="Skor_Benar" placeholder="Skor Benar"/>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Skor Salah</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-4">
                      <input type="number" min="0" class="form-control" value="<?=$dtdefault->Skor_Salah?>" name="Skor_Salah" placeholder="Skor Salah"/>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Skor Default</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-4">
                      <input type="number" min="0" class="form-control"  value="<?=$dtdefault->Skor_Default?>" name="Skor_Default" placeholder="Skor Default"/>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Pengumuman Hasil Ujian</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <select  class="form-control select2" name="Flag_HasilTayangLangsung" required>
                          <option value="" selected readonly>Pilih</option>
                          <option value="Y" <?=($dtdefault->Flag_HasilTayangLangsung == "Y")? 'selected':''; ?> >Hasil Ditayangkan Langsung</option>
                          <option value="N" <?=($dtdefault->Flag_HasilTayangLangsung == "N")? 'selected':''; ?>>Hasil Diumumkan Kemudian</option>
                     </select>
                  </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Bisa Mundur Soal ?</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <select  class="form-control select2" name="Flag_BisaMundur" required>
                          <option value="" selected readonly>Pilih</option>
                          <option value="Y" <?=($dtdefault->Flag_BisaMundur == "Y")? 'selected':''; ?> >Ya, Bisa Mundur</option>
                          <option value="N" <?=($dtdefault->Flag_BisaMundur == "N")? 'selected':''; ?> >Tidak Bisa Mundur</option>
                     </select>
                  </div>
                </div>
            </div> <!--row-6-->
            
            <div class="form-group col-sm-6">
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Batasan Jumlah Soal</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <select id="flag_bts_jumsoal" class="form-control select2" name="Flag_JmlSoalTakTerbatas" required>
                          <option value="" selected readonly>Pilih</option>
                          <option value="N" <?=($dtdefault->Flag_JmlSoalTakTerbatas == "N")? 'selected':''; ?> >Jumlah Soal Dibatasi</option>
                          <option value="Y" <?=($dtdefault->Flag_JmlSoalTakTerbatas == "Y")? 'selected':''; ?> >Jumlah Soal Tidak Terbatas</option>
                      </select>
                  </div>
                </div>
                <?php
                  $hide1 = ($dtdefault->Flag_JmlSoalTakTerbatas != "N")? 'hide':''; 
                ?>
                <div class="form-group col-sm-12 <?=$hide1?>" id="tamp_flag_bts_jumsoal1">
                    <div class="col-sm-4">
                      <label>Jumlah Soal Ujian</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-6">
                      <input type="number" min="0" class="form-control" name="Jml_SoalUjian" value="<?=$dtdefault->Jml_SoalUjian?>" placeholder="Jumlah Soal Ujian"/>
                    </div>
                </div>
                <div class="form-group col-sm-12" id="tamp_flag_bts_jumsoal2">
                    <div class="col-sm-4"> 
                      <label>Beda Presentasi Antar Bab</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <select  class="form-control select2" name="Flag_BedaPersentaseAntarBab" required>
                          <option value=""  readonly>Pilih</option>
                          <option value="Y" <?=($dtdefault->Flag_BedaPersentaseAntarBab == "Y")? 'selected':'';?> >Antar Bab Memiliki Perbedaan Jumlah Soal</option>
                          <option value="N" <?=($dtdefault->Flag_BedaPersentaseAntarBab == "N")? 'selected':'';?> >Antar Bab Jumlah Soalnya Sama</option>
                     </select>
                  </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Durasi Ujian</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-5">
                      <input type="number" min="0" class="form-control" name="Lama_WaktuUjian" value="<?=$dtdefault->Lama_WaktuUjian?>" placeholder="Lama Waktu Ujian" required />
                    </div>
                    <div class="col-sm-2">
                      <label>/menit</label>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Catatan Pelaksanaan Ujian</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <textarea class="form-control" name="CatatanPelaksanaanUjian" id="CatatanPelaksanaanUjian" placeholder="Catatan Pelaksanaan Ujian" required><?=$dtdefault->CatatanPelaksanaanUjian?></textarea>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <hr>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Status Pengumuman Hasil Ujian</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <select  class="form-control select2" name="Flag_TelahDiumumkan" required>
                          <option value="" readonly>Pilih</option>
                          <option value="Y" <?=($dtdefault->Flag_TelahDiumumkan == "Y")? 'selected':'';?> >Sudah Diumumkan</option>
                          <option value="N" <?=($dtdefault->Flag_TelahDiumumkan == "N")? 'selected':'';?> >Belum Diumumkan</option>
                     </select>
                  </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Tanggal Pengumuman</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <input type="date" class="form-control" name="Tgl_pengumuman" value="<?=$dtdefault->Tgl_pengumuman?>" placeholder="Tanggal Pengumuman"/>
                    </div>
                </div>
            </div> <!--row-6--> <br/><br/>
              
            <div class="form-group col-sm-12"> 
              <div class="col-sm-3 pull-right">
                <button type="submit" title="Simpan Data" class="btn btn-block btn-flat btn-success" 
                onclick="return confirm('Apakah Anda yakin dengan data tersebut ?')"><i class="fa fa-save"></i> Save</button>
              </div>
            </div>
            </form>
            <div class="form-group col-sm-12">
              <hr style="margin-bottom:0;margin-top:0" />
            </div>
            
          </div><!-- /.box-body -->
          
        </div> <!-- box-success -->
      </div> <!-- col -->
    </div> <!-- row -->
    
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
    $(document).on('change','#flag_bts_jumsoal',function(){
      var _thisval = $(this).val();
      if(_thisval == 'N'){
        $("#tamp_flag_bts_jumsoal1").removeClass("hide");
        //$("#tamp_flag_bts_jumsoal2").removeClass("hide");
      }else{
        $("#tamp_flag_bts_jumsoal1").addClass("hide");
        //$("#tamp_flag_bts_jumsoal2").addClass("hide");
      }
    })
  });
</script>