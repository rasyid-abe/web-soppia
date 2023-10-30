<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")?>">
<style>
    label{
        color:#00008B;
    }
</style>
<script type="text/javascript">
  
      function reverseNumber(input) {
       return [].map.call(input, function(x) {
          return x;
        }).reverse().join(''); 
      }
      
      function plainNumber(number) {
         return number.split('.').join('');
      }
      
      function splitInDots(input) {
        
        var value = input.value,
            plain = plainNumber(value),
            reversed = reverseNumber(plain),
            reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
            normal = reverseNumber(reversedWithDots);
        input.value = normal;
      }
    
</script>
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
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title">Pembebanan Biaya Instruktur</h3>
            <div class="box-tools pull-right">
              <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                      title="Kembali Ke Manage <?=$subtitlepage?>">
                <i class="fa fa-arrow-circle-left"></i> Back</a>
              <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                <i class="fa fa-refresh"></i> Refresh</button>
            </div>
          </div>

    <div class="box-body">
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/simpanbiaya/".$dtdefault->Id_InstrukturNgajar_diKelas)?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  
        <input type="hidden" class="form-control" name="fidkelas" value="<?=$dtdefault->FId_Kelas_n_Angkatan?>">
        <input type="hidden" class="form-control" name="fidinst" value="<?=$dtdefault->FId_Instruktur?>">
        <input type="hidden" class="form-control" name="fidmateri" value="<?=$dtdefault->FKd_Materi?>">

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Tanggal Mengajar</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="tglngajar" value="<?=$dtdefault->Tgl_Mengajar?>" readonly>
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Nama Instruktur</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?=$dtdefault->NamaLengkap_DgnGelar?>" readonly>
                </div>
              </div>      

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Kelas & Angkatan</label>
                </div>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="<?=$dtdefault->DescBebas_Kelas_n_Angkatan?>" readonly>
                </div>
              </div>

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Deskripsi Materi</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?=$dtdefault->Desc_Materi_n_Aktifitas?>" readonly>
                </div>
              </div>    
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Jumlah Bayar (Rp.)</label>
                </div>
                <div class="col-sm-10">
                  <?php
                     $read = 0;
                     if($dtdefault->Flag_SudahDibayar == "Y") {
                         $read = "readonly";
                     }                    
                  ?>    
                  <input type="text" class="form-control" name="Jumlah_Bayar" required onkeyup="splitInDots(this)" placeholder="Jumlah Bayar (Rp.)" id="Jumlah_Bayar" value="<?=number_format($dtdefault->Jumlah_Bayar)?>" <?=$read?> >
                </div>
              </div> 
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Keterangan</label>
                </div>
                <div class="col-sm-10">
                  <textarea name="keterangan" class="form-control" <?=$read?>><?=$dtdefault->Keterangan?></textarea>
                </div>
              </div> 

              <div class="box-body">
                <div class="form-group col-sm-12">
                  <hr style="margin-bottom:0;margin-top:0" />
                </div>

                <div class="form-group col-sm-12">
                  <?php if($dtdefault->Jumlah_Bayar == 0 or $dtdefault->Jumlah_Bayar == null) { ?>
                  <div class="col-sm-3 pull-right">
                    <button type="submit" title="Simpan Data" onclick="return confirm('Apakah Anda yakin dengan data tersebut ?')" class="btn btn-block btn-flat btn-success">Save</button>
                  </div>
                  <?php } ?>
                  <div class="col-sm-3 pull-right">
                    <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" title="Kembali" class="btn btn-danger btn-block btn-flat">Back</a>
                  </div>
                </div>

              </div><!-- /.box-body -->
            </div> <!-- box-warning -->
          </div> <!-- col -->
       </div> <!-- row -->                     
    </div>
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2()
    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false,
      format: 'hh:mm:ss',
    })
    $('.date').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight:true,
    })
  })
</script>