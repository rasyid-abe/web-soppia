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
                <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/add/'.$kelas->Id_Kelas_n_Angkatan)?>" class="btn btn-box-tool" data-toggle="tooltip"
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
                    <!--<div class="col-md-12">
                        <div class="box-body chart-responsive">
                          <div class="chart" id="bar-chart" style="height: 300px;"></div>
                        </div>
                    </div>-->
                    <div class="col-md-12">
                      <div class="box-group" id="accordion">
                        <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                        <div class="panel box box-primary">
                          <div class="box-header with-border">
                            <h4 class="box-title">
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                                1. Bagaimana Anda menilai kualitas pelatihan ini secara keseluruhan ? 
                              </a>
                            </h4>
                          </div>
                          <div id="collapseOne" class="panel-collapse collapse in">
                            <div class="box-body">
                                <div class="col-sm-12">
                                    <?php
                                        $total = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4)))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows(); 
                                        $jwb1_a = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval1'=>'5'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                        $jwb1_b = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval1'=>'4'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                        $jwb1_c = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval1'=>'3'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                        $jwb1_d = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval1'=>'2'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                        $jwb1_e = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval1'=>'1'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                    ?>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Sangat Baik</td>
                                                <td><?=$jwb1_a?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Baik</td>
                                                <td><?=$jwb1_b?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Cukup</td>
                                                <td><?=$jwb1_c?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Kurang</td>
                                                <td><?=$jwb1_d?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Sangat Kurang</td>
                                                <td><?=$jwb1_e?> Peserta</td>
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
                                2. Seberapa jauh pelatihan ini membantu Anda dalam pelaksanaan tugas sehari-hari ? 
                              </a>
                            </h4>
                          </div>
                          <div id="collapseTwo" class="panel-collapse collapse in">
                            <div class="box-body">
                                <div class="col-sm-12">
                                    <?php
                                        $jwb2_a = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval2'=>'5'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                        $jwb2_b = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval2'=>'4'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                        $jwb2_c = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval2'=>'3'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                        $jwb2_d = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval2'=>'2'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                        $jwb2_e = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval2'=>'1'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                    ?>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Sangat Baik</td>
                                                <td><?=$jwb2_a?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Baik</td>
                                                <td><?=$jwb2_b?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Cukup</td>
                                                <td><?=$jwb2_c?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Kurang</td>
                                                <td><?=$jwb2_d?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Sangat Kurang</td>
                                                <td><?=$jwb2_e?> Peserta</td>
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
                                        $total = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4)))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows(); 
                                        $jwb3_a = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval3'=>'5'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                        $jwb3_b = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval3'=>'4'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                        $jwb3_c = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval3'=>'3'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                        $jwb3_d = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval3'=>'2'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                        $jwb3_e = $this->db->where(array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4),'Jwb_Eval3'=>'1'))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya")->num_rows();
                                    ?>
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <td>Sangat Baik</td>
                                                <td><?=$jwb3_a?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Baik</td>
                                                <td><?=$jwb3_b?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Cukup</td>
                                                <td><?=$jwb3_c?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Kurang</td>
                                                <td><?=$jwb3_d?> Peserta</td>
                                            </tr>
                                            <tr>
                                                <td>Sangat Kurang</td>
                                                <td><?=$jwb3_e?> Peserta</td>
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
                              <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                4. Apa saran Anda agar pelatihan ini menjadi lebih efektif ? 
                              </a>
                            </h4>
                          </div>
                          <div id="collapseFour" class="panel-collapse collapse in">
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
                                    $srn = $this->db->where( array('FId_Kelas_n_Angkatan'=>$this->uri->segment(4)))->get("tre_pembukaankelas_n_angkatan_peserta_n_evalnya");
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
                                        if($val->Saran == '' || $val->Saran == null){
                                            echo '- Kosong -';
                                        }else{
                                            echo $val->Saran;   
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
     
     //BAR CHART
    var bar = new Morris.Bar({
      element: 'bar-chart',
      resize: true,
      data: [
        {y: 'Sangat Baik', a: <?=$jwb1_a?>, b: <?=$jwb2_a?>,c:<?=$jwb3_a?>},
        {y: 'Baik', a: <?=$jwb1_b?>, b: <?=$jwb2_b?>, c:<?=$jwb3_b?>},
        {y: 'Cukup', a: <?=$jwb1_c?>, b: <?=$jwb2_c?>, c:<?=$jwb3_c?>},
        {y: 'Kurang', a: <?=$jwb1_d?>, b: <?=$jwb2_d?>,c:<?=$jwb3_d?>},
        {y: 'Kurang Baik', a: <?=$jwb1_e?>, b: <?=$jwb2_e?>,c:<?=$jwb3_e?>},
      ],
      barColors: ['#00a65a', '#f56954','#cc33ff'],
      xkey: 'y',
      ykeys: ['a', 'b','c'],
      labels: ['Jumlah Jawaban Pertanyaan 1', 'Jumlah Jawaban Pertanyaan 2','Jumlah Jawaban Pertanyaan 3'],
      hideHover: 'auto'
    });
  });
</script>