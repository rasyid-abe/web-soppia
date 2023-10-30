<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net/buttons.dataTables.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")?>">
<style>
    label {
        color:#00008B;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$titlepage?> QIA
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
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title">Data Peserta <?=$peserta->NamaLengkap_TanpaGelar?></h3>
      <div class="box-tools pull-right">
        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                title="Kembali Ke Manage <?=$subtitlepage?>">
          <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i> Refresh</button>
      </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-2" style="padding-left:30px">
                <?php
                    $foto="def-img.png";
                    if($peserta->FilePhoto != ""){
                        $foto = $peserta->FilePhoto;
                    }
                ?>
               <img src='<?=base_url("uploads/photo/".$foto)?>' height="170px" width="140px" alt="Foto" title="Belum Upload Foto">
            </div>
            <div class="form-group col-sm-5">
              <label class="col-sm-4 control-label">Nama Peserta</label>
              <div class="col-sm-8" style="color:#9900cc">
               : <?=$peserta->NamaLengkap_DgnGelar?>
              </div>
            </div>
            <div class="form-group col-sm-5">
              <label class="col-sm-4 control-label">NIK</label>
              <div class="col-sm-8" style="color:#9900cc">
               : <?=$peserta->NIK?>
              </div>
            </div>
            <div class="form-group col-sm-5">
              <label class="col-sm-4 control-label">NIPP</label>
              <div class="col-sm-8" style="color:#9900cc">
               : <?=$peserta->NIPP?>
              </div>
            </div>
            <div class="form-group col-sm-5">
              <label class="col-sm-4 control-label">Kota Lahir</label>
              <div class="col-sm-8" style="color:#9900cc">
               : <?=$peserta->Kota_Lahir?>
              </div>
            </div>
            <div class="form-group col-sm-5">
              <label class="col-sm-4 control-label">Tanggal Lahir</label>
              <div class="col-sm-8" style="color:#9900cc">
               : <?=tgl_indo($peserta->Tgl_Lahir)?>
              </div>
            </div>
            <div class="form-group col-sm-5">
              <label class="col-sm-4 control-label">Alamat Rumah</label>
              <div class="col-sm-8" style="color:#9900cc">
               : <?=$peserta->Alamat_Rumah?>
              </div>
            </div>
            <div class="form-group col-sm-5">
              <label class="col-sm-4 control-label">Email Peserta</label>
              <div class="col-sm-8" style="color:#9900cc">
               : <?=$peserta->eMail_Pribadi?>
              </div>
            </div>
        </div> <!--row-->
    </div> <!--box-body-->
  </div> <!--default-box-->
  
  <!-- Default box -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$titlebox?> QIA</h3>
      <div class="box-tools pull-right">
       
      </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
      <table class="table table-bordered table-striped dt-table" style="width: 100%">
        <thead>
          <tr>
            <th>No</th>
            <th style="width: 180px">Jenis Pelatihan</th>
            <th>Nama Kelas</th>
            <th>Inisiasi Kegiatan</th>
            <th width="150px">Dokumen Kelas</th>
            <th>ID Kelas</th>
            <th>Status Kelulusan</th>
          </tr>
        </thead>
        <tbody>
            <?php 
              $no=1;
    		  foreach($kelasqia as $kq){ 
    		    $kelas = "";
    		    if($kq->idproforma != null){
                    $kelas = "Kelas IHT";
                }
                if($kq->idskreguler != null){
                    $kelas = "Kelas Reguler";
                }
                
                $dok = "";
                if($kq->idproforma != ""){
                    $dok = "Proforma Kontrak Nomor ".$kq->No_ProformaKontrak;
                }
                if($kq->idskreguler != ""){
                    $dok = "SK Pembukaan Kelas Reguler Nomor ".$kq->No_Klsreguler;
                }
                
                $lulus = "";
                if($kq->kelulusan == 0){
                    $lulus = "Kelas Belum Selesai";
                }
                elseif($kq->kelulusan == 1){
                    $lulus = "Lulus";
                }
                elseif($kq->kelulusan == 2){
                    $lulus = "Tidak Lulus";
                }
    		?>
    		<tr>
                <td><?=$no++?></td>
                <td><?=$kq->Desc_JenisPelatihan?></td>
                <td><?=$kq->DescBebas_Kelas_n_Angkatan?></td>
                <td><?=$kelas?></td>
                <td><?=$dok?></td>
                <td><?=$kq->nomor_kelas?></td>
                <td><?=$lulus?></td>                    
            </tr>
            <?php } ?>
        </tbody>
      </table>
      </div>
    </div> <!--box-body-->
  </div> <!--default-box-->
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
<script type="text/javascript">  
  $(function () {
    $('table.dt-table').DataTable({
      "responsive": true,
      "processing": false, 
      "serverSide": true, 
      "columnDefs": [
        { 
          "targets": [ 0,6 ], 
          "orderable": false, 
          "searchable": false, 
        }
      ],
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true
    })
  })  
</script>