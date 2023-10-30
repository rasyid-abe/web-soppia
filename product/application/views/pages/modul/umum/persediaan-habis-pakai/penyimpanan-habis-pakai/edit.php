<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
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

  <div class="row">
    <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->Id_Consumables)?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    
    
    <div class="col-sm-12">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"><?=$titlebox?></h3>
          <div class="box-tools pull-right">
            <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                    title="Kembali Ke Manage <?=$subtitlepage?>">
              <i class="fa fa-arrow-circle-left"></i> Back</a>
            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
              <i class="fa fa-refresh"></i> Refresh</button>
          </div>
        </div>
        <div class="box-body">
              <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Deskripsi Habis Pakai</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="Desc_Consumables" id="Desc_Consumables" placeholder="Deskripsi Consumables"><?=$dtdefault->Desc_Consumables?></textarea>
              </div>
            </div>
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Pilih Lokasi Simpan</label>
              <div class="col-sm-10">
                <div class="input-group">
                <div class="input-group-addon">
                  <i class="fa fa-map"></i>
                </div>
                <select name="FKd_Lokasi_Simpan" class="form-control select2" style="width: 100%;">
                  <option value="" readonly disabled selected>Pilih Lokasi</option>
                  <?php
                  foreach ($FKd_Lokasi_Simpan->result() as $data) {
                    $slc = ($dtdefault->FKd_Lokasi_Simpan==$data->Kd_Lokasi_Simpan)? 'selected':'';
                  ?>
                  <option value="<?=$data->Kd_Lokasi_Simpan?>" <?=$slc?> ><?=$data->Desc_Lokasi_Simpan?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
              </div>
            </div> 
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Tanggal</label>
              <div class="col-sm-10">
                <input type="date" class="form-control" name="Tgl_PengadaanPertama" id="Tgl_PengadaanPertama" placeholder="Tanggal Pengadaan Pertama" value="<?=$dtdefault->Tgl_PengadaanPertama?>"  >
              </div>
            </div>
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Saldo</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="Saldo" id="Saldo" onkeyup="splitInDots(this)" placeholder="Saldo" value="<?=number_format($dtdefault->Saldo)?>" >
              </div>
            </div> <br/>
            
            <div class="col-sm-12"> 
              <div class="form-group col-sm-12"> 
                <div class="col-sm-3 pull-right">
                  <button type="submit" class="btn btn-block btn-flat btn-success">Save</button>
                </div>
                <div class="col-sm-3 pull-right">
                  <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-danger btn-block btn-flat">Back</a>
                </div>
              </div>
            </div>
            
        </div> <!-- box-body -->
      </div> <!-- box -->
    </div> <!-- col -->
    
    </form>
  </div>
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
    
    $('.date').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight:true,
    });
  });
</script>