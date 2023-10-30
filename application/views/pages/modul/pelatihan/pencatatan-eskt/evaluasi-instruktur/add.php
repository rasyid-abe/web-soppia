<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")?>">
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
                <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/materi/'.$eval->FId_Kelas_n_Angkatan)?>" class="btn btn-box-tool" data-toggle="tooltip"
                    title="Kembali Ke Pilih Materi">
                <i class="fa fa-arrow-circle-left"></i> Back</a>
                <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/hasil/'.$eval->FId_Instruktur.'/'.$eval->idpembukaankelasangkatan.'/'.$eval->FId_Kelas_n_Angkatan)?>" class="btn btn-box-tool" data-toggle="tooltip"
                    title="Lihat Hasil Evaluasi Kelas">
                <i class="fa fa-book"></i> Lihat Hasil</a>
            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                <i class="fa fa-refresh"></i> Refresh</button>
            </div>
          </div>
          <div class="box-body">
            <form action="<?=base_url($this->uri->segment(1)."/".$this->uri->segment(2)."/store")?>" method="POST">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  
            <input type="hidden" name="idsesi" value="<?=$eval->idpembukaankelasangkatan?>" />  
            <input type="hidden" name="idins" value="<?=$eval->FId_Instruktur?>" />  
            
            <?php
                $kelas = $this->uri->segment(4);
		        $ids = $this->uri->segment(5);
            ?>
            <input type="hidden" name="ids" value="<?=$ids?>" />  
            <input type="hidden" name="kelas" value="<?=$kelas?>" />  
            
            <div class="form-group col-sm-12" align="center">
                <h3><img src="<?=base_url()?>/assets/images/soppia.png" width="70" height="70" /> <b>YAYASAN PENDIDIKAN INTERNAL AUDIT (YPIA)</b> <img src="<?=base_url()?>/assets/images/dsqia.png" width="70" height="70" /></h3>
            </div>
            
            <div class="form-group col-sm-12">
                <hr style="margin-bottom:0;margin-top:0" />
            </div>
              
             <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Program Pendidikan</label>
                  <label>Angkatan</label>
                </div>
                <div class="col-sm-8" style="color:#9900cc">
                  : &nbsp; <?=$eval->Desc_JenisPelatihan?> <br/>
                  : &nbsp; <?=$eval->No_Urut_Angkatan?> (<?=$eval->DescBebas_Kelas_n_Angkatan?>)
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Fasilitator</label>
                  <label>Materi/Pokok Bahasan</label>
                </div>
                <div class="col-sm-8" style="color:#9900cc">
                  : &nbsp; <?=$eval->NamaLengkap_DgnGelar?> <br/>
                  : &nbsp; <?=$eval->Desc_Materi_n_Aktifitas?>
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Tanggal</label>
                </div>
                <div class="col-sm-8" style="color:#9900cc">
                  : &nbsp; <?=tgl_indo($eval->Tgl)?>
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
                        1. Apakah materi/pokok bahasan yang dibawakan fasilitator sesuai dengan harapan dan kebutuhan Anda ?
                      </div>
                  </div> <!--row-->
                  <div class="row" style="margin-top:10px;margin-left:20px">
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval1" value="T"> Tidak
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval1" value="Y"> Ya
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval1" value="S"> Sangat Sesuai
                    </div>
                  </div> <!--row-->
                  
                  <div class="row" style="margin-top:50px">
                      <div class="col-md-12">
                        2. Bagaimana perbandingan (ratio) antara "kuliah" dan diskusi ?
                      </div>
                  </div> <!--row-->
                  <div class="row" style="margin-top:10px;margin-left:20px">
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval2" value="TK"> Terlalu Banyak Kuliah
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval2" value="S"> Seimbang
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval2" value="TD"> Terlalu Banyak Diskusi
                    </div>
                  </div> <!--row-->
                  
                  <div class="row" style="margin-top:50px">
                      <div class="col-md-12">
                        3. Bagaimana penilaian Anda terhadap fasilitas pendukung seperti : Ruangan, hidangan, serta peralatan ? 
                      </div>
                  </div> <!--row-->
                  <div class="row" style="margin-top:10px;margin-left:20px">
                    <div class="table-responsive">
                      <table class="table table-bordered table-striped dt-table" style="width: 80%">
                        <thead>
                          <tr>
                            <td style="width:10px;font-weight:bold" align="center">No</td>
                            <td style="width:180px;font-weight:bold" align="center">Unsur Yang Dinilai</td>
                            <td style="width:50px;font-weight:bold" align="center">Sangat Baik</td>
                            <td style="width:50px;font-weight:bold" align="center">Baik</td>
                            <td style="width:50px;font-weight:bold" align="center">Cukup</td>
                            <td style="width:50px;font-weight:bold" align="center">Kurang</td>
                            <td style="width:50px;font-weight:bold" align="center">Kurang Sekali</td>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td align="center">1</td>
                            <td>Penguasaan Materi</td>
                            <td align="center"><input type="radio" name="Jwb_Eval31" value="5"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval31" value="4"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval31" value="3"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval31" value="2"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval31" value="1"></td>
                          </tr>
                          <tr>
                            <td align="center">2</td>
                            <td>Menghidupkan Suasana Kelas</td>
                            <td align="center"><input type="radio" name="Jwb_Eval32" value="5"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval32" value="4"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval32" value="3"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval32" value="2"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval32" value="1"></td>
                          </tr>
                          <tr>
                            <td align="center">3</td>
                            <td>Penyampaian Ilustrasi/Contoh-contoh</td>
                            <td align="center"><input type="radio" name="Jwb_Eval33" value="5"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval33" value="4"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval33" value="3"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval33" value="2"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval33" value="1"></td>
                          </tr>
                          <tr>
                            <td align="center">4</td>
                            <td>Kemampuan Mentransfer Materi/Pokok Bahasan</td>
                            <td align="center"><input type="radio" name="Jwb_Eval34" value="5"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval34" value="4"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval34" value="3"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval34" value="2"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval34" value="1"></td>
                          </tr>
                          <tr>
                            <td align="center">5</td>
                            <td>Menyimpulkan Bab-bab Mengenai Pokok Bahasan</td>
                            <td align="center"><input type="radio" name="Jwb_Eval35" value="5"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval35" value="4"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval35" value="3"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval35" value="2"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval35" value="1"></td>
                          </tr>
                          <tr>
                            <td align="center">6</td>
                            <td>Pengembangan Wawasan</td>
                            <td align="center"><input type="radio" name="Jwb_Eval36" value="5"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval36" value="4"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval36" value="3"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval36" value="2"></td>
                            <td align="center"><input type="radio" name="Jwb_Eval36" value="1"></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div> <!--row-->
                  
                  <div class="row" style="margin-top:50px">
                      <div class="col-md-12">
                        4. Secara keseluruhan bagaimana rating Anda terhadap fasilitator ?
                      </div>
                  </div> <!--row-->
                  <div class="row" style="margin-top:10px;margin-left:20px">
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval4" value="5"> Sangat Baik
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval4" value="4"> Baik
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval4" value="3"> Cukup
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval4" value="2"> Kurang
                    </div>
                    <div class="col-md-2">
                        <input type="radio" name="Jwb_Eval4" value="1"> Kurang Sekali
                    </div>
                  </div> <!--row-->
                  
                  <div class="row" style="margin-top:50px">
                      <div class="col-md-12">
                        5. Apa saran Anda agar sesi jadi lebih efektif ?
                      </div>
                  </div> <!--row-->
                  <div class="row" style="margin-top:10px;margin-left:20px">
                    <div class="col-md-10">
                        <textarea class="form-control" name="Saran_Eval" id="Saran" placeholder="Saran"></textarea>
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

<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/dataTables.buttons.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
    $('table.dt-table').DataTable({
      "responsive"  : true,
      "processing"  : true, 
      "serverSide"  : true, 
      'paging'      : false,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true
    });
  });
</script>