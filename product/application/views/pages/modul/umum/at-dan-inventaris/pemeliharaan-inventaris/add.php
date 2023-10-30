<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
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
     
       <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/store')?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
            No AT dan Inventaris
            <br/>
            <select class="form-control select2" name="no_at_inv" id="no_at_inv">
              <option value="" selected> Pilih No AT dan Inventaris </option>
              <?php
                foreach($atinv->result() as $at){
              ?>
                <option value="<?=$at->Id_AT_n_Invent?>"><?=$at->no_at_inv?> <?=($at->Desc_AT_n_Invent != null || $at->Desc_AT_n_Invent != '' )? ' - '.$at->Desc_AT_n_Invent :'';?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
            Deskripsi Pemeliharaan
            <br/>
            <textarea class="form-control" name="desc_pemeliharaan" id="desc_pemeliharaan" placeholder="Deskripsi Pemeliharaan " ></textarea>
          </div>
        </div>
        
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Penanggung Jawab
            <br/>
            <input type="text" class="form-control" name="penggung_jawab" id="penggung_jawab" placeholder="Penggung Jawab "  value="<?=$this->session->userdata("username")?>" >
          </div>
        </div>
        
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Biaya
            <br/>
            <input type="text" class="form-control" name="biaya" id="biaya" onkeyup="splitInDots(this)" placeholder="Harga Barang (tanpa titik/koma )"  >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Keterangan
            <br/>
            <textarea rows="5" cols="77px" name="keterangan" id="keterangan"></textarea>
          </div>
        </div>
   

        <div class="form-group col-sm-12">
          <hr style="margin-bottom:0;margin-top:0" />
        </div>

        <div class="form-group col-sm-12"> 
          <div class="col-sm-2">
            <button type="submit" class="btn btn-block btn-flat">Save</button>
          </div>
          <div class="col-sm-2">
            <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-danger btn-block btn-flat">Back</a>
          </div>
        </div>

      </form>

    </div>

  </div>

</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
  });
</script>