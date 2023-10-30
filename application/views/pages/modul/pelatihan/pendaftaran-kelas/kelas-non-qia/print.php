<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net/buttons.dataTables.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")?>">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Kelas <?=$kelas->DescBebas_Kelas_n_Angkatan?>
    <a class='btn btn-xs btn-success' title='Print Data' onclick="printContent('div1')"> <i class='fa fa-print'></i> <b>Print</b></a>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a><?=$breadcrumb2?></a></li>
    <li class="active"><?=$breadcrumb3?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- Default box -->
  <div class="box box-primary" id="div1">
    <div class="box-header with-border" style="text-align: center;">
      <?php
          $tgl1 = date("d",strtotime($kelas->Tgl_Mulai_Aktual));
          $tgl2 = tgl_indo($kelas->Tgl_Selesai_Aktual);
          $bulan1 = date("m",strtotime($kelas->Tgl_Mulai_Aktual));
          $bulan2 = date("m",strtotime($kelas->Tgl_Selesai_Aktual));
          if($bulan1 != $bulan2){
              $tgl1 = tgl_indo($kelas->Tgl_Mulai_Aktual);
          }
      ?>
      <h3 class="box-title"><b>Absensi Peserta Pelatihan <?=$kelas->Desc_JenisPelatihan?></b></h3> <br>     
      <h3 class="box-title" style="margin: 10px;"><b>Angkatan ke-<?=$kelas->No_Urut_Angkatan?> (Tanggal <?=$tgl1?> s/d <?=$tgl2?>)</b></h3>  
    </div>
    <div class="box-body">
      <style type="text/css">
        table {
          border-collapse: collapse;
        }
        table, td, th {
          border: 2px solid black;
          padding: 2px;
        }
        .tengah{text-align: center;}
        .tengahp{text-align: center;width: 50px}
        .null{border: 0px solid black;}
      </style>
      <p style="margin-left: 5px">Hari/Tanggal : </p>
      <div style="overflow-x:auto;">
        <table class="peserta" style="width: 100%">
          <thead>
            <tr>
              <th class="tengah" rowspan="2" style="width: 40px;">No.</th>
              <th style="width: 100px">ID</th>
              <th>Nama Peserta</th>
              <th class="tengah" colspan="5">Paraf</th>
              <th class="tengah" rowspan="2">Nama/TTD Instruktur</th>
            </tr>
            <tr>
              <th colspan="2" style="width: 300px">Instansi / Perusahaan</th>
              <th class="tengahp">1</th>
              <th class="tengahp">2</th>
              <th class="tengahp">3</th>
              <th class="tengahp">4</th>
              <th class="tengahp">5</th>
            </tr>
          </thead>
          <tbody>
            <?php $no=1; foreach ($pesertanonqia->result() as $key => $value) { ?>
              <tr>
                <td class="tengah" rowspan="2"><?=$no++?></td>
                <td><?=$value->NIPP?></td>
                <td><?=$value->NamaLengkap_DgnGelar?></td>
                <td rowspan="2"></td>
                <td rowspan="2"></td>
                <td rowspan="2"></td>
                <td rowspan="2"></td>
                <td rowspan="2"></td>            
                <td class="null tengah"></td>
              </tr>
              <tr>
                <td colspan="2"><?=($value->NamaPershInstansi!= null)? $value->NamaPershInstansi : '<code>N/A</code>';?></td>                
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div> <!-- overflow -->
    </div> <!-- box-body -->
  </div> <!-- box -->
</section>

<script>
function printContent(el){
  var restorepage = document.body.innerHTML;
  var printcontent = document.getElementById(el).innerHTML;
  document.body.innerHTML = printcontent;
  window.print();
  document.body.innerHTML = restorepage;
}
</script>