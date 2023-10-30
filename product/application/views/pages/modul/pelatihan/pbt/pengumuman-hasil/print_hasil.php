<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>YPIA</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css')?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/bower_components/Ionicons/css/ionicons.min.css')?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/dist/css/AdminLTE.min.css')?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <!-- info row -->
    <div class="row invoice-info">
       <div class="col-sm-6">
                  <table class="table table-striped table-bordered" width="100%">
                    <tr>
                      <td valign="top" width="150"><b>Nama</b></td>
                      <td valign="top" width="30">:</td>
                      <td valign="top" width="300"><?=$hasil->row()->NamaLengkap_DgnGelar?></td>
                    </tr>
                    <tr>
                      <td valign="top" width="150"><b>NIPP</b></td>
                      <td valign="top" width="30">:</td>
                      <td valign="top" width="300"><?=$hasil->row()->NIPP?></td>
                    </tr>
                  </table>
                </div>
                <div class="col-sm-6">
                  
                  <table class="table table-striped table-bordered" width="100%">
                    <tr>
                      <td valign="top" width="150"><b>ID Kelas</b></td>
                      <td valign="top" width="30">:</td>
                      <td valign="top" width="300"><?=$kelas->nomor_kelas?></td>
                    </tr>
                    <tr>
                      <td valign="top" width="150"><b>Nama Kelas</b></td>
                      <td valign="top" width="30">:</td>
                      <td valign="top" width="300"><?=$hasil->row()->DescBebas_Kelas_n_Angkatan?></td>
                    </tr>
                  </table>

                </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">

                  <table class="table table-striped table-bordered" width="100%">
                    <thead>
                      <tr>
                        <th>Materi & Aktifitas</th>
                        <th>Ujian Ke 1</th>
                        <th>Ujian Ke 2</th>
                        <th>Ujian Ke 3</th>
                        <th>Ujian Ke 4</th>
                        <th>Keterangan</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $ttl = 0;
                        $getm = $this->db
                          ->select('any_value(mst_materi_n_aktifitas.Desc_Materi_n_Aktifitas) as Desc_Materi_n_Aktifitas,any_value(mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas) as Kd_Materi_n_Aktifitas ')
                          ->join("mst_materi_n_aktifitas",'mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas = tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas','Left')
                          ->where(array('FId_Kelas_n_Angkatan'=>$kelas->Id_Kelas_n_Angkatan,
                              'tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas !=' =>'',
                              'tre_pembukaankelas_n_angkatan_sesi.FId_Instruktur !=' => ''
                            ))
                          ->group_by('Desc_Materi_n_Aktifitas')
                          ->get('tre_pembukaankelas_n_angkatan_sesi');
                          foreach ($getm->result() as $vv) {
                      ?>
                        <tr>
                          <td><?=$vv->Desc_Materi_n_Aktifitas?></td>
                          <td><?php
                              $ujian1 = $this->db
                                ->where(array(
                                  'FId_Kelas_n_Angkatan'=>$kelas->Id_Kelas_n_Angkatan,
                                  'FId_Peserta'=>$hasil->row()->Id_Peserta,
                                  'FKd_Materi_n_Aktifitas'=>$vv->Kd_Materi_n_Aktifitas,
                                  ))->get('tre_bukakelasangkatan_peserta_hasilujian');
                              if($ujian1->num_rows()>0){
                                    echo $ujian1->row()->Hasil_Ujian1;
                              }else{
                                echo "-";
                              }
                          ?></td>
                          <td><?php
                              $ujian2 = $this->db
                                ->where(array(
                                  'FId_Kelas_n_Angkatan'=>$kelas->Id_Kelas_n_Angkatan,
                                  'FId_Peserta'=>$hasil->row()->Id_Peserta,
                                  'FKd_Materi_n_Aktifitas'=>$vv->Kd_Materi_n_Aktifitas,
                                  ))->get('tre_bukakelasangkatan_peserta_hasilujian');
                              if($ujian2->num_rows()>0){
                                    echo $ujian2->row()->Hasil_Her1;
                              }else{
                                echo "-";
                              }
                          ?></td>
                          <td><?php
                              $ujian3 = $this->db
                                ->where(array(
                                  'FId_Kelas_n_Angkatan'=>$kelas->Id_Kelas_n_Angkatan,
                                  'FId_Peserta'=>$hasil->row()->Id_Peserta,
                                  'FKd_Materi_n_Aktifitas'=>$vv->Kd_Materi_n_Aktifitas,
                                  ))->get('tre_bukakelasangkatan_peserta_hasilujian');
                              if($ujian3->num_rows()>0){
                                    echo $ujian2->row()->Hasil_Her2;
                              }else{
                                echo "-";
                              }
                          ?></td>
                          <td><?php
                              $ujian4 = $this->db
                                ->where(array(
                                  'FId_Kelas_n_Angkatan'=>$kelas->Id_Kelas_n_Angkatan,
                                  'FId_Peserta'=>$hasil->row()->Id_Peserta,
                                  'FKd_Materi_n_Aktifitas'=>$vv->Kd_Materi_n_Aktifitas,
                                  ))->get('tre_bukakelasangkatan_peserta_hasilujian');
                              if($ujian4->num_rows()>0){
                                    echo $ujian2->row()->Hasil_Extra_Her1;
                              }else{
                                echo "-";
                              }
                          ?></td>
                          <td>
                            <?php
                              $keterangan = $this->db
                                ->where(array(
                                  'FId_Kelas_n_Angkatan'=>$kelas->Id_Kelas_n_Angkatan,
                                  'FId_Peserta'=>$hasil->row()->Id_Peserta,
                                  'FKd_Materi_n_Aktifitas'=>$vv->Kd_Materi_n_Aktifitas,
                                  ))->get('tre_bukakelasangkatan_peserta_hasilujian');
                                $lulus = 0;
                                if($keterangan->num_rows()>0){
                                  if($keterangan->row()->Flag_LulusUjian1 == "Y"){
                                    $lulus = $lulus+1;
                                  }
                                  if($keterangan->row()->Flag_LulusHer1 == "Y"){
                                    $lulus = $lulus+1;
                                  }
                                  if($keterangan->row()->Flag_LulusHer2 == "Y"){
                                    $lulus = $lulus+1;
                                  }
                                  if($keterangan->row()->Hasil_Extra_Her1 == "Y"){
                                    $lulus = $lulus+1;
                                  }

                                  if($lulus>0){
                                    echo "lulus";
                                    $ttl = $ttl+1;
                                  }else{
                                    echo "tidak lulus";
                                  }

                                }
                            ?>


                          </td>
                        </tr>
                      <?php
                          }
                      ?>
                      <tr>
                        <td colspan="5">
                          <b>HASIL</b>
                        </td>
                        <td>
                          <b>
                          <?php
                            if($ttl == $getm->num_rows()){
                              echo 'LULUS';
                            }else{
                              echo "BELUM LULUS";
                            }
                          ?>
                          </b>
                        </td>
                      </tr>
                    </tbody>
                  </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
