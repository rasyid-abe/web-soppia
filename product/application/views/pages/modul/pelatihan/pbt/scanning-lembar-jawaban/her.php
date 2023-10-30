<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
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

    <div class="row ">
      <div class="col-md-12"> 
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Entry Nilai Her 1 : <?=$peserta->NamaLengkap_DgnGelar?> | Kelas : <?=$kelas->DescBebas_Kelas_n_Angkatan?></h3>
            <div class="box-tools pull-right">
              <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/peserta/'.$kelas->Id_Kelas_n_Angkatan)?>" class="btn btn-box-tool" data-toggle="tooltip"
                      title="Kembali Ke Manage <?=$subtitlepage?>">
                <i class="fa fa-arrow-circle-left"></i> Back</a>
              <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                <i class="fa fa-refresh"></i> Refresh</button>
            </div>
          </div>

          <div class="box-body">
            <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/nilaiher1")?>" method="POST">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  
            <input type="hidden" name="FId_Kelas_n_Angkatan" value="<?=$kelas->Id_Kelas_n_Angkatan?>" />  
            <input type="hidden" name="FId_Peserta" value="<?=$peserta->Id_Peserta?>" />  

            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Nama Materi</label>
              <div class="col-sm-7">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-book"></i>
                  </div>
                  <select name="FKd_Materi_n_Aktifitas" class="form-control select2" required>
                    <option value="" readonly disabled selected>Pilih Materi</option>
                    <?php
                      $id_peserta = $this->uri->segment(4);
                      $id_kelas = $this->uri->segment(5);
                      $query = $this->db
                        ->join("mst_materi_n_aktifitas",'mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas = tre_bukakelasangkatan_peserta_hasilujian.FKd_Materi_n_Aktifitas','Left')
                        ->where(array(
                        'FId_Kelas_n_Angkatan'=>$id_kelas,
                        'FId_Peserta'=>$id_peserta,
                        'Flag_LulusUjian1'=>'N'
                        ))->get('tre_bukakelasangkatan_peserta_hasilujian')->result();
                      foreach ($query as $data) {
                        $slc = ($this->session->flashdata('oldinput')['FKd_Materi_n_Aktifitas']==$data->FKd_Materi_n_Aktifitas)? 'selected':'';
                    ?>
                      <option value="<?=$data->FKd_Materi_n_Aktifitas?>" <?=$slc?> ><?=$data->Desc_Materi_n_Aktifitas?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div> 

            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Tanggal Ujian Her 1</label>
              <div class="col-sm-3">
                <input type="date" class="form-control" name="Tgl_Her1" placeholder="Tanggal Ujian Her 1" required>
              </div>
            </div> 

            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Hasil Ujian Her 1</label>
              <div class="col-sm-3">
                <input type="number" min="0" max="100" class="form-control" name="Hasil_Her1" placeholder="Nilai Ujian Her 1" required>
              </div>
            </div> 

            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Status Kelulusan</label>
              <div class="col-sm-3">
                <select name="Flag_LulusHer1" class="form-control select2" required>
                  <option value="" readonly disabled selected>Pilih</option>
                  <option value="Y">Lulus</option>
                  <option value="N">Belum Lulus</option>
                </select>
              </div>
            </div>                

            <div class="form-group col-sm-12">
              <hr style="margin-bottom:0;margin-top:0" />
            </div>

            <div class="form-group col-sm-12"> 
              <div class="col-sm-2 pull-right">
                <button type="submit" title="Simpan Data" class="btn btn-block btn-flat btn-success">Save</button>
              </div>
              <div class="col-sm-2 pull-right">
                <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" title="Kembali" class="btn btn-danger btn-block btn-flat">Back</a>
              </div>
            </div>
          </form>
          </div><!-- /.box-body -->
        </div> <!-- box-success -->
      </div> <!-- col -->
    </div> <!-- row -->

    <div class="row ">
      <div class="col-md-12"> 
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Hasil Her 1</h3>            
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped dt-table" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Materi</th>
                    <th>Hasil Ujian</th>
                    <th>Tanggal Ujian</th>
                    <th>Status Kelulusan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; foreach ($hasil as $key) { ?>
                    <tr>
                      <td><?=$no++?></td>
                      <td><?=$key->Desc_Materi_n_Aktifitas?></td>
                      <td><?php if($key->Hasil_Her1 != '') echo $key->Hasil_Her1; else echo "<code>N/A</code>";?></td>
                      <td><?=tgl_indo($key->Tgl_Her1)?></td>
                      <td>
                        <?php                          
                            $hasil = "<code>N/A</code>";
                            $warna = "";
                            $label = "fa fa-mins";
                          if($key->Flag_LulusHer1 == 'N'){
                            $hasil = "Belum Lulus";
                            $warna = "badge bg-red";
                            $label = "fa fa-times";
                          } 
                          elseif ($key->Flag_LulusHer1 == 'Y') {
                            $hasil = "Lulus";
                            $warna = "badge bg-green";
                            $label = "fa fa-check";
                          } 
                        ?>  
                        <span class="<?=$warna?>"><i class="<?=$label?>"></i></span> <?=$hasil?>
                      </td>
                      <td>
                        <?php if($key->Flag_LulusHer1 != ''){?>
                        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/hapusher1/".$key->FId_Kelas_n_Angkatan.'/'.$key->FId_Peserta.'/'.$key->FKd_Materi_n_Aktifitas)?>" class='btn btn-xs btn-danger' data-toggle='tooltip' title='Hapus Data' onclick="return confirm('Apakah Anda yakin akan menghapus data ini?')"><i class='fa fa-trash'></i> Hapus</a>
                        <?php } else echo "<code>N/A</code>"; ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div><!-- /.box-body -->
        </div> <!-- box-success -->
      </div> <!-- col -->
    </div> <!-- row -->

    <?php if($her2->num_rows() > 0) { ?>
    <div class="row ">
      <div class="col-md-12"> 
        <div class="box box-danger">
          <div class="box-header with-border">
            <h3 class="box-title">Entry Nilai Her 2 : <?=$peserta->NamaLengkap_DgnGelar?> | Kelas : <?=$kelas->DescBebas_Kelas_n_Angkatan?></h3>            
          </div>

          <div class="box-body">
            <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/nilaiher2")?>" method="POST">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  
            <input type="hidden" name="FId_Kelas_n_Angkatan" value="<?=$kelas->Id_Kelas_n_Angkatan?>" />  
            <input type="hidden" name="FId_Peserta" value="<?=$peserta->Id_Peserta?>" />  

            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Nama Materi</label>
              <div class="col-sm-7">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-book"></i>
                  </div>
                  <select name="FKd_Materi_n_Aktifitas" class="form-control select2" required>
                    <option value="" readonly disabled selected>Pilih Materi</option>
                    <?php
                      $id_peserta = $this->uri->segment(4);
                      $id_kelas = $this->uri->segment(5);
                      $query = $this->db
                        ->join("mst_materi_n_aktifitas",'mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas = tre_bukakelasangkatan_peserta_hasilujian.FKd_Materi_n_Aktifitas','Left')
                        ->where(array(
                        'FId_Kelas_n_Angkatan'=>$id_kelas,
                        'FId_Peserta'=>$id_peserta,
                        'Flag_LulusHer1'=>'N'
                        ))->get('tre_bukakelasangkatan_peserta_hasilujian')->result();
                      foreach ($query as $data) {
                        $slc = ($this->session->flashdata('oldinput')['FKd_Materi_n_Aktifitas']==$data->FKd_Materi_n_Aktifitas)? 'selected':'';
                    ?>
                      <option value="<?=$data->FKd_Materi_n_Aktifitas?>" <?=$slc?> ><?=$data->Desc_Materi_n_Aktifitas?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            </div> 

            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Tanggal Ujian Her 2</label>
              <div class="col-sm-3">
                <input type="date" class="form-control" name="Tgl_Her2" placeholder="Tanggal Ujian Her 2" required>
              </div>
            </div> 

            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Hasil Ujian Her 2</label>
              <div class="col-sm-3">
                <input type="number" min="0" max="100" class="form-control" name="Hasil_Her2" placeholder="Nilai Ujian Her 2" required>
              </div>
            </div> 

            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Status Kelulusan</label>
              <div class="col-sm-3">
                <select name="Flag_LulusHer2" class="form-control select2" required>
                  <option value="" readonly disabled selected>Pilih</option>
                  <option value="Y">Lulus</option>
                  <option value="N">Belum Lulus</option>
                </select>
              </div>
            </div>    

            <div class="form-group col-sm-12">
              <hr style="margin-bottom:0;margin-top:0" />
            </div>

            <div class="form-group col-sm-12"> 
              <div class="col-sm-2 pull-right">
                <button type="submit" title="Simpan Data" class="btn btn-block btn-flat btn-success">Save</button>
              </div>
              <div class="col-sm-2 pull-right">
                <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" title="Kembali" class="btn btn-danger btn-block btn-flat">Back</a>
              </div>
            </div>
          </form>
          </div><!-- /.box-body -->
        </div> <!-- box-success -->
      </div> <!-- col -->
    </div> <!-- row-2-->  

    <div class="row ">
      <div class="col-md-12"> 
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">Hasil Her 2</h3>            
          </div>
          <div class="box-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped dt-table" style="width: 100%">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Materi</th>
                    <th>Hasil Ujian</th>
                    <th>Tanggal Ujian</th>
                    <th>Status Kelulusan</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $no=1; foreach ($her2->result() as $key) { ?>
                    <tr>
                      <td><?=$no++?></td>
                      <td><?=$key->Desc_Materi_n_Aktifitas?></td>
                      <td><?php if($key->Hasil_Her2 != '') echo $key->Hasil_Her2; else echo "<code>N/A</code>";?></td>
                      <td><?=tgl_indo($key->Tgl_Her2)?></td>
                      <td>
                        <?php                          
                            $hasil = "<code>N/A</code>";
                            $warna = "";
                            $label = "fa fa-mins";
                          if($key->Flag_LulusHer2 == 'N'){
                            $hasil = "Belum Lulus";
                            $warna = "badge bg-red";
                            $label = "fa fa-times";
                          } 
                          elseif ($key->Flag_LulusHer2 == 'Y') {
                            $hasil = "Lulus";
                            $warna = "badge bg-green";
                            $label = "fa fa-check";
                          } 
                        ?>  
                        <span class="<?=$warna?>"><i class="<?=$label?>"></i></span> <?=$hasil?>
                      </td>
                      <td>
                        <?php if($key->Flag_LulusHer2 != ''){?>
                        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/hapusher2/".$key->FId_Kelas_n_Angkatan.'/'.$key->FId_Peserta.'/'.$key->FKd_Materi_n_Aktifitas)?>" class='btn btn-xs btn-danger' data-toggle='tooltip' title='Hapus Data' onclick="return confirm('Apakah Anda yakin akan menghapus data ini?')"><i class='fa fa-trash'></i> Hapus</a>
                        <?php } else echo "<code>N/A</code>"; ?>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div><!-- /.box-body -->
        </div> <!-- box-success -->
      </div> <!-- col -->
    </div> <!-- row -->  
    <?php } ?>
</section>

<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/dataTables.buttons.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();       
  });

  $(function () {
    $.ajaxSetup({
      data: {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      }
    });
    $('table.dt-table').DataTable({
      "responsive"  : true,
      "processing"  : false, 
      "serverSide"  : true, 
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true
    })
  })  
</script>
