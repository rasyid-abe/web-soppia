<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net/buttons.dataTables.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")?>">
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

  <!-- Default box -->
  <div class="box" style="border-top:0px solid">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$titlebox?></h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">
          <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab"><b>Informasi Kelas</b></a></li>
      <li><a href="#tab_2" data-toggle="tab"><b>Materi Kelas</b></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
		<table class="table table-bordered table-striped" style="width: 100%">
        	<tr>
        		<td valign="top" style="color:#00008B">Jenis Pelatihan</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=$dtdefault->Desc_JenisPelatihan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Perusahaan / Instansi</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=$dtdefault->Desc_PershInstansi?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">No Urut</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=$dtdefault->No_Urut_Angkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Baku Kelas & Angkatan</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=$dtdefault->DescBaku_Kelas_n_Angkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Bebas Kelas & Angkatan</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=$dtdefault->DescBebas_Kelas_n_Angkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Kode Singkatan</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=$dtdefault->KODE_Singkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Kota Training</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=$dtdefault->Desc_KotaTraining?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Lokasi</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=$dtdefault->LokasiPenyelenggaraan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Jumlah Peserta</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=$dtdefault->Jml_Peserta?> Peserta</td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Tanggal Mulai</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=tgl_indo($dtdefault->Tgl_Mulai_Aktual)?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Tanggal Selesai</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=tgl_indo($dtdefault->Tgl_Selesai_Aktual)?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Lama Hari</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=$dtdefault->LamaHariPelatihan?> Hari</td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Flag Selesai</td>
        		<td valign="top">:</td>
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
        		<td valign="top"><?=$selesai?></td>
        	</tr>
        </table>        
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="tab_2">
        
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->

    </div>

  </div>

</section>

<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/dataTables.buttons.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.flash.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jszip.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/pdfmake.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/vfs_fonts.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.html5.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.print.min.js")?>"></script>
