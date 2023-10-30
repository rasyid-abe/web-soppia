<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")?>">
<style>
    label {
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
    Pembebanan Biaya Kelas
    <small>Data Pembebanan Biaya Kelas</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a >Reguler</a></li>
    <li class="active">Biaya Kelas</li>
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
            <h3 class="box-title">Tambah Biaya Kelas</h3>
            <div class="box-tools pull-right"> 
              <?php $add = $kelas->row();?>
              <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/detail/'.$add->Id_Kelas_n_Angkatan)?>" class="btn btn-box-tool" data-toggle="tooltip"
                      title="Kembali Ke Manage <?=$subtitlepage?>">
                <i class="fa fa-arrow-circle-left"></i> Back</a>
              <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                <i class="fa fa-refresh"></i> Refresh</button>
            </div>
          </div>

          <div class="box-body">
            <?php echo form_open_multipart($this->uri->segment(1).'/'.$this->uri->segment(2)."/store");?>
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  

            <div class="form-group col-sm-12">
              <div class="col-sm-2">
                <label>Nama Kelas & Angkatan (Baku)</label></label>
              </div>
              <div class="col-sm-10">
                <input type="hidden" class="form-control" name="FId_Kelas_n_Angkatan" id="FId_Kelas_n_Angkatan" value="<?=$add->Id_Kelas_n_Angkatan?>" readonly>
                <input type="text" class="form-control" value="<?=$add->DescBaku_Kelas_n_Angkatan?>" readonly>
              </div>
            </div>           

            <div class="form-group col-sm-12">
              <div class="col-sm-2">
                <label>Deskripsi Transaksi <span style="color:red">*</span></label>
              </div>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="Desc_Transaksi" id="Desc_Transaksi" placeholder="Deskripsi Transaksi" value="<?=$this->session->flashdata('oldinput')['Desc_Transaksi']?>" required>
              </div>
            </div>    

            <div class="form-group col-sm-12">
              <div class="col-sm-2">
                <label>Nilai Rupiah <span style="color:red">*</span></label>
              </div>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="Nilai_Rp" id="Nilai_Rp" onkeyup="splitInDots(this)" placeholder="Nilai Rupiah" value="<?=$this->session->flashdata('oldinput')['Nilai_Rp']?>" required>
              </div>
            </div>     

            <div class="form-group col-sm-12">
              <div class="col-sm-2">
                <label>Keterangan</label>
              </div>
              <div class="col-sm-10">
                <textarea class="form-control" name="Keterangan" placeholder="Keterangan"><?=$this->session->flashdata('oldinput')['Keterangan']?></textarea>
              </div>
            </div>      

            <div class="form-group col-sm-12">
              <hr style="margin-bottom:0;margin-top:0" />
            </div>

            <div class="form-group col-sm-12"> 
              <div class="col-sm-3 pull-right">
                <button type="submit" title="Simpan Data" class="btn btn-block btn-flat btn-success" onclick="return confirm('Apakah Anda yakin dengan data tersebut ?')">Save</button>
              </div>
              <div class="col-sm-3 pull-right">
                <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" title="Kembali" class="btn btn-danger btn-block btn-flat">Back</a>
              </div>
            </div>

          </div><!-- /.box-body -->
        </div> <!-- box-success -->
      </div> <!-- col -->
    </div> <!-- row -->
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