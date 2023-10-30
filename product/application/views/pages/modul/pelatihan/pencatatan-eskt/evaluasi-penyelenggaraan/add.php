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
                <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/hasil/'.$kelas->Id_Kelas_n_Angkatan)?>" class="btn btn-box-tool" data-toggle="tooltip"
                    title="Lihat Hasil Evaluasi Kelas">
                <i class="fa fa-book"></i> Lihat Hasil</a>
            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                <i class="fa fa-refresh"></i> Refresh</button>
            </div>
          </div>
          <div class="box-body">
            <form action="<?=base_url($this->uri->segment(1)."/".$this->uri->segment(2)."/store")?>" method="POST">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  
            <input type="hidden" name="idkelas" value="<?=$kelas->Id_Kelas_n_Angkatan?>" />  
            
            <div class="form-group col-sm-12" align="center">
                <h3><img src="<?=base_url()?>/assets/images/soppia.png" width="70" height="70" /> <b>YAYASAN PENDIDIKAN INTERNAL AUDIT (YPIA)</b> <img src="<?=base_url()?>/assets/images/dsqia.png" width="70" height="70" /></h3>
            </div>
            
            <div class="form-group col-sm-12">
                <hr style="margin-bottom:0;margin-top:0" />
            </div>
              
            <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Program Pendidikan</label>
                </div>
                <div class="col-sm-8" style="color:#9900cc">
                  : &nbsp; <?=$kelas->Desc_JenisPelatihan?>
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Angkatan</label>
                </div>
                <div class="col-sm-8" style="color:#9900cc">
                  : &nbsp; <?=$kelas->No_Urut_Angkatan?> (<?=$kelas->DescBebas_Kelas_n_Angkatan?>)
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Tanggal</label>
                </div>
                <div class="col-sm-8" style="color:#9900cc">
                  : &nbsp; <?=tgl_indo($kelas->Tgl_Mulai_Aktual)?> s/d <?=tgl_indo($kelas->Tgl_Selesai_Aktual)?>
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <hr style="margin-bottom:0;margin-top:0" />
              </div>
                
              <?php if($pesertaqia->num_rows() > 0) { ?>
              <div class="col-sm-4 pull-right">
                  <select name="idpeserta" class="form-control select2" style="width: 100%;">
                    <option value="" readonly disabled selected>Pilih Peserta (Jika ada)</option>
                    <?php
                    foreach ($pesertaqia->result() as $data) {
                      $slc = ($this->session->flashdata('oldinput')['id_peserta']==$data->Id_Peserta)? 'selected':'';
                      $namapes = "--";
                      if($data->NamaLengkap_DgnGelar != null){
                          $namapes = $data->NamaLengkap_DgnGelar;
                      }
                    ?>
                    <option value="<?=$data->Id_Peserta?>" <?=$slc?> ><?=$namapes?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <?php } ?>
                
                <?php if($pesertanonqia->num_rows() > 0) { ?>
                <div class="col-sm-4 pull-right">
                  <select name="idpeserta" class="form-control select2" style="width: 100%;">
                    <option value="" readonly disabled selected>Pilih Peserta (Jika ada)</option>
                    <?php
                    foreach ($pesertanonqia->result() as $data) {
                      $slc = ($this->session->flashdata('oldinput')['id_peserta']==$data->Id_Peserta)? 'selected':'';
                      $namapes = "--";
                      if($data->NamaLengkap_DgnGelar != null){
                          $namapes = $data->NamaLengkap_DgnGelar;
                      }
                    ?>
                    <option value="<?=$data->Id_Peserta?>" <?=$slc?> ><?=$namapes?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
                <?php } ?>
            
              <div class="container" style="margin-left:40px">
                  <div class="row" style="margin-top:30px">
                      <div class="col-md-12">
                        1. Bagaimana Anda menilai kualitas pelatihan ini secara keseluruhan ? 
                      </div>
                  </div> <!--row-->
                  <div class="row" style="margin-top:10px;margin-left:20px">
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval1" value="5"> Sangat Baik
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval1" value="4"> Baik
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval1" value="3"> Cukup
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval1" value="2"> Kurang
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval1" value="1"> Sangat Kurang
                    </div>
                  </div> <!--row-->
                  
                  <div class="row" style="margin-top:50px">
                      <div class="col-md-12">
                        2. Seberapa jauh pelatihan ini membantu Anda dalam pelaksanaan tugas sehari-hari ? 
                      </div>
                  </div> <!--row-->
                  <div class="row" style="margin-top:10px;margin-left:20px">
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval2" value="4"> Sangat Membantu
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval2" value="3"> Membantu
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval2" value="2"> Kurang Membantu
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval2" value="1"> Sangat Tidak Membantu
                    </div>
                  </div> <!--row-->
                  
                  <div class="row" style="margin-top:50px">
                      <div class="col-md-12">
                        3. Bagaimana penilaian Anda terhadap fasilitas pendukung seperti : Ruangan, hidangan, serta peralatan ? 
                      </div>
                  </div> <!--row-->
                  <div class="row" style="margin-top:10px;margin-left:20px">
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval3" value="5"> Sangat Baik
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval3" value="4"> Baik
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval3" value="3"> Cukup
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval3" value="2"> Kurang
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval3" value="1"> Sangat Kurang
                    </div>
                  </div> <!--row-->
                  
                  <div class="row" style="margin-top:50px">
                      <div class="col-md-12">
                        4. Apa saran Anda agar pelatihan ini menjadi lebih efektif ? 
                      </div>
                  </div> <!--row-->
                  <div class="row" style="margin-top:10px;margin-left:20px">
                    <div class="col-md-10">
                        <textarea class="form-control" name="Saran" id="Saran" placeholder="Saran"></textarea>
                    </div>
                  </div> <!--row-->
              </div> <!--container--> <br/>
            
            <div class="form-group col-sm-12">
              <hr style="margin-bottom:0;margin-top:0" />
            </div>

            <div class="form-group col-sm-12"> 
              <div class="col-sm-3 pull-right">
                <button type="submit" title="Simpan Data" class="btn btn-block btn-flat btn-success" onclick="return confirm('Apakah Anda yakin dengan data tersebut ?')">Save</button>
              </div>
              <div class="col-sm-3 pull-right">
                <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" title="Kembali" class="btn btn-danger btn-block btn-flat">Back</a>
              </div>
            </div>
            
          </div><!-- /.box-body -->
          </form>
        </div> <!-- box-success -->
      </div> <!-- col -->
    </div> <!-- row -->
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
  });
</script>