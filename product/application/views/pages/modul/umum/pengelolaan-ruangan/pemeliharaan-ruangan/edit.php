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
        
        //console.log(plain,reversed, reversedWithDots, normal);
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
              <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->id_pemeliharaan)?>" method="POST">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  
                  
                <div class="form-group col-sm-12">
                    <div class="col-sm-2">
                      <label>Nama Ruangan</label>
                    </div>
                    <div class="col-sm-10">
                      <select name="id_ruang" class="form-control select2" style="width: 100%;">
                        <option value="" readonly disabled selected>Pilih Ruangan</option>
                        <?php
                        foreach ($ruang->result() as $data) {
                            $slc = ($dtdefault->id_ruang==$data->Kd_RuangLantai)? 'selected':'';
                        ?>
                        <option value="<?=$data->Kd_RuangLantai?>" <?=$slc?> ><?=$data->Desc_RuangLantai?></option>
                        <?php
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  
                <div class="form-group col-sm-12">
                  <label class="col-sm-2 control-label">Tanggal Mulai</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" name="tgl_mulai" placeholder="Tanggal Mulai" value="<?=$dtdefault->tgl_mulai?>" >
                  </div>
                </div>
                
                <div class="form-group col-sm-12">
                  <label class="col-sm-2 control-label">Tanggal Selesai</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" name="tgl_selesai" placeholder="Tanggal Selesai" value="<?=$dtdefault->tgl_selesai?>" >
                  </div>
                </div>
                
                <div class="form-group col-sm-12">
                  <label class="col-sm-2 control-label">Penanggung Jawab</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="petugas" placeholder="Penanggung Jawab" value="<?=$dtdefault->petugas?>" >
                  </div>
                </div>
                
                <div class="form-group col-sm-12">
                  <label class="col-sm-2 control-label">Keterangan</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" name="alasan_perbaikan" placeholder="Keterangan Pemeliharaan / Perbaikan"><?=$dtdefault->alasan_perbaikan?></textarea>
                  </div>
                </div>
            
                <div class="form-group col-sm-12">
                  <label class="col-sm-2 control-label">Biaya Pemeliharaan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="biaya" onkeyup="splitInDots(this)" placeholder="Biaya Pemeliharaan" value="<?=number_format($dtdefault->biaya)?>" >
                  </div>
                </div>
                
                <div class="form-group col-sm-12">
                    <hr style="margin-bottom:0;margin-top:0" />
                </div>
                
                <div class="col-sm-4">
                  <button type="submit" class="btn btn-block btn-flat">Save</button>
                </div>
                
                <div class="col-sm-4">
                  <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-danger btn-block btn-flat">Back</a>
                </div>

              </div><!-- /.box-body -->
            </div> <!-- box-warning -->
          </div> <!-- col -->
       </div> <!-- row -->                     
    </div>
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")?>"></script>
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
</script>