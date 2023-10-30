<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/morris.js/morris.css")?>">
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
                <?php
                    $idds = $this->uri->segment(5);
                    $kelas = $this->uri->segment(6);
                ?>
                <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/add/'.$kelas.'/'.$idds)?>" class="btn btn-box-tool" data-toggle="tooltip"
                    title="Kembali Ke <?=$subtitlepage?>">
                <i class="fa fa-arrow-circle-left"></i> Back</a>
            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                <i class="fa fa-refresh"></i> Refresh</button>
            </div>
          </div>
          <div class="box-body">
            
            <div class="form-group col-sm-12" align="center">
                <h3><img src="<?=base_url("assets/images/soppia.png")?>" width="70" height="70" /> <b>YAYASAN PENDIDIKAN INTERNAL AUDIT (YPIA)</b> <img src="<?=base_url()?>/assets/images/dsqia.png" width="70" height="70" /></h3>
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
                <div class="col-sm-2">
                  <label>Total Evaluasi</label>
                </div>
                <div class="col-sm-8" style="color:#9900cc">
                  : &nbsp; <?=$hasil->num_rows();?> Peserta
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <hr style="margin-bottom:0;margin-top:0" />
              </div>
              
              <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                      <div class="box-group" id="accordion">
                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                        <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h4 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                1. Apakah materi/pokok bahasan yang dibawakan fasilitator sesuai dengan harapan dan kebutuhan Anda ?
                              </a>
                            </h4>
                          </div>
                          <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="box-body">
                                <div class="col-sm-12">
                                    <?php 
                                        $inst  = $this->uri->segment(4);
                                        $class = $this->uri->segment(6);
                                        $jwb1a = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval1",'T')
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb1b = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval1",'Y')
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb1c = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval1",'S')
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                    ?>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Tidak</td>
                                                <td><?=$jwb1a?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Ya</td>
                                                <td><?=$jwb1b?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Sangat Sesuai</td>
                                                <td><?=$jwb1c?> Peserta</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h4 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                2. Bagaimana perbandingan (ratio) antara "kuliah" dan diskusi ?
                              </a>
                            </h4>
                          </div>
                          <div id="collapseTwo" class="panel-collapse collapse in">
                            <div class="box-body">
                                <div class="col-sm-12">
                                    <?php 
                                        $jwb2a = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval2",'TK')
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb2b = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval2",'S')
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb2c = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval2",'TD')
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                    ?>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Terlalu Banyak Kuliah</td>
                                                <td><?=$jwb2a?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Seimbang</td>
                                                <td><?=$jwb2b?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Terlalu Banyak Diskusi</td>
                                                <td><?=$jwb2c?> Peserta</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h4 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                3. Bagaimana penilaian Anda terhadap fasilitas pendukung seperti : Ruangan, hidangan, serta peralatan ? 
                              </a>
                            </h4>
                          </div>
                          <div id="collapseThree" class="panel-collapse collapse in">
                            <div class="box-body">
                                <div class="col-sm-12">
                                    <?php 
                                        $jwb31a = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval31",5)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb31b = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval31",4)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb31c = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval31",3)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb31d = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval31",2)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb31e = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval31",1)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                    ?>
                                    
                                    <?php 
                                        $jwb32a = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval32",5)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb32b = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval32",4)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb32c = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval32",3)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb32d = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval32",2)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb32e = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval32",1)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                    ?>
                                    
                                    <?php 
                                        $jwb33a = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval33",5)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb33b = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval33",4)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb33c = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval33",3)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb33d = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval33",2)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb33e = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval33",1)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                    ?>
                                    
                                    <?php 
                                        $jwb34a = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval34",5)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb34b = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval34",4)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb34c = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval34",3)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb34d = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval34",2)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb34e = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval34",1)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                    ?>
                                    
                                    <?php 
                                        $jwb35a = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval35",5)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb35b = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval35",4)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb35c = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval35",3)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb35d = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval35",2)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb35e = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval35",1)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                    ?>
                                    
                                    <?php 
                                        $jwb36a = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval36",5)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb36b = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval36",4)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb36c = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval36",3)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb36d = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval36",2)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb36e = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval36",1)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                    ?>
                                    <div class="table-responsive">
                                      <table class="table table-bordered table-striped dt-table" style="width: 100%">
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
                                            <td align="center"><?=$jwb31a?></td>
                                            <td align="center"><?=$jwb31b?></td>
                                            <td align="center"><?=$jwb31c?></td>
                                            <td align="center"><?=$jwb31d?></td>
                                            <td align="center"><?=$jwb31e?></td>
                                          </tr>
                                          <tr>
                                            <td align="center">2</td>
                                            <td>Menghidupkan Suasana Kelas</td>
                                            <td align="center"><?=$jwb32a?></td>
                                            <td align="center"><?=$jwb32b?></td>
                                            <td align="center"><?=$jwb32c?></td>
                                            <td align="center"><?=$jwb32d?></td>
                                            <td align="center"><?=$jwb32e?></td>
                                          </tr>
                                          <tr>
                                            <td align="center">3</td>
                                            <td>Penyampaian Ilustrasi/Contoh-contoh</td>
                                            <td align="center"><?=$jwb33a?></td>
                                            <td align="center"><?=$jwb33b?></td>
                                            <td align="center"><?=$jwb33c?></td>
                                            <td align="center"><?=$jwb33d?></td>
                                            <td align="center"><?=$jwb33e?></td>
                                          </tr>
                                          <tr>
                                            <td align="center">4</td>
                                            <td>Kemampuan Mentransfer Materi/Pokok Bahasan</td>
                                            <td align="center"><?=$jwb34a?></td>
                                            <td align="center"><?=$jwb34b?></td>
                                            <td align="center"><?=$jwb34c?></td>
                                            <td align="center"><?=$jwb34d?></td>
                                            <td align="center"><?=$jwb34e?></td>
                                          </tr>
                                          <tr>
                                            <td align="center">5</td>
                                            <td>Menyimpulkan Bab-bab Mengenai Pokok Bahasan</td>
                                            <td align="center"><?=$jwb35a?></td>
                                            <td align="center"><?=$jwb35b?></td>
                                            <td align="center"><?=$jwb35c?></td>
                                            <td align="center"><?=$jwb35d?></td>
                                            <td align="center"><?=$jwb35e?></td>
                                          </tr>
                                          <tr>
                                            <td align="center">6</td>
                                            <td>Pengembangan Wawasan</td>
                                            <td align="center"><?=$jwb36a?></td>
                                            <td align="center"><?=$jwb36b?></td>
                                            <td align="center"><?=$jwb36c?></td>
                                            <td align="center"><?=$jwb36d?></td>
                                            <td align="center"><?=$jwb36e?></td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h4 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                4. Secara keseluruhan bagaimana rating Anda terhadap fasilitator ?
                              </a>
                            </h4>
                          </div>
                          <div id="collapseFour" class="panel-collapse collapse in">
                            <div class="box-body">
                                <div class="col-sm-12">
                                    <?php 
                                        $jwb4a = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval4",5)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb4b = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval4",4)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb4c = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval4",3)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb4d = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval4",2)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                        $jwb4e = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->where("Jwb_Eval4",1)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi")->num_rows();
                                    ?>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Sangat Baik</td>
                                                <td><?=$jwb4a?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Baik</td>
                                                <td><?=$jwb4b?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Cukup</td>
                                                <td><?=$jwb4c?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Kurang</td>
                                                <td><?=$jwb4d?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Kurang Sekali</td>
                                                <td><?=$jwb4e?> Peserta</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                          </div>
                        </div>
                        <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h4 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseFive">
                                5. Apa saran Anda agar sesi jadi lebih efektif ?
                              </a>
                            </h4>
                          </div>
                          <div id="collapseFive" class="panel-collapse collapse in">
                            <div class="box-body">
                                <table class="table table-bordered dt-table">
                                    <thead>
                                        <tr>
                                            <th>Nama Peserta</th>
                                            <th>Saran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $srn = $this->db
                                                ->where("FId_InstrukturNgajar_diKelas",$inst)
                                                ->where("FId_Kelas_n_Angkatan",$class)
                                                ->get("tre_instrukturngajar_dikelas_evaluasi");
                                            foreach($srn->result() as $val){
                                        ?>
                                            <tr>
                                                <td style="width:50%"><?php
                                                if($val->FId_Peserta == '' || $val->FId_Peserta == null){
                                                    echo '- Tanpa Nama -';
                                                }else{
                                                    echo getnamapeserta($val->FId_Peserta);
                                                }?></td>
                                                <td><?php
                                                if($val->Saran_Eval == '' || $val->Saran_Eval == null){
                                                    echo '- Kosong -';
                                                }else{
                                                    echo $val->Saran_Eval;   
                                                }
                                                ?></td>
                                            </tr>
                                        <?php
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
            
          </div><!-- /.box-body -->
        </div> <!-- box-success -->
      </div> <!-- col -->
    </div> <!-- row -->
</section>
<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/raphael/raphael.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/morris.js/morris.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/dataTables.buttons.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.flash.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jszip.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/pdfmake.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/vfs_fonts.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.html5.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.print.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
     $('.select2').select2();
     $('table.dt-table').DataTable({});
    });
  });
</script>