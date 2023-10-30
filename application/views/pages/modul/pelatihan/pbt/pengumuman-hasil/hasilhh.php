<link rel="stylesheet" href="<?=base_url("assets/style/print.min.css")?>">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$titlepage?>
    <small><?=$subtitlepage?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a><?=$breadcrumb2?></a></li>
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

  <!-- Default box -->
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">ID Kelas : <?=$kelas->nomor_kelas?> | <?=$kelas->DescBebas_Kelas_n_Angkatan?></h3>
      <div class="box-tools pull-right">
        <button type="button" class="btn btn-xs btn-primary" id="wordbtn"><i class="fa fa-file-word-o"></i> Export to word</button>
        <a href="<?=base_url('pbt/pengumuman-hasil/print/'.$this->uri->segment(4).'/'.$this->uri->segment(5))?>" target="_blank" class="btn btn-xs btn-default"><i class="fa fa-print"></i> Print</a>
        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/hasil/'.$this->uri->segment(4))?>" class="btn btn-box-tool" data-toggle="tooltip"
                  title="Kembali Ke Manage <?=$subtitlepage?>">
            <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i> Refresh</button>
      </div>
    </div>
    <div class="box-body">

      <style type="text/css">
                table.customTable {
                  width: 100%;
                  background-color: #FFFFFF;
                  border-collapse: separate;
                  border-width: 1px;
                  border-color: #000000;
                  border-style: solid;
                  color: #000000;
                }
                table.customTable td, table.customTable th {
                  border-width: 1px;
                  border-color: #000000;
                  border-style: solid;
                  padding: 5px;
                }
                
                table.customTable thead {
                  background-color: #F8F837;
                }
                * {
                  -webkit-print-color-adjust: exact !important;
                }
                @media print{
                    table.customTable {
                      width: 100% !important;
                      background-color: #FFFFFF !important;
                      border-collapse: separate !important;
                      border-width: 0px !important;
                      border-color: #000000 !important;
                      border-style: solid !important;
                      color: #000000 !important;
                    }
                    table.customTable td, table.customTable th {
                      border-width: 1px !important;
                      border-color: #000000 !important;
                      border-style: solid !important;
                      padding: 5px !important;
                    }
                    
                    table.customTable thead {
                      background-color: #F8F837 !important;
                      
                    }
                }
                </style>

            <div class="row" id="view-hasil">
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
                <div class="col-sm-12">
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
            </div>

    </div>

    </div>
  </div>
</section>

<script src="<?=base_url("assets/script/print.min.js")?>"></script>
<script src="<?=base_url("assets/script/FileSaver.js")?>"></script>
<script src="<?=base_url("assets/script/jquery.wordexport.js")?>"></script>

<script type="text/javascript">
  $(function(){

    $(document).on("click","#wordbtn",function(){
        $("#view-hasil").wordExport('Peserta_<?=$hasil->row()->NIPP.'_'.str_replace(" ","_",$kelas->nomor_kelas)?>_<?=str_replace(" ","_",$kelas->DescBebas_Kelas_n_Angkatan)?>');
    });
  })
</script>