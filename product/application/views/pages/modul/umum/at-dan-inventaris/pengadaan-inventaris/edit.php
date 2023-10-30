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
     
      
       <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->Id_AT_n_Invent)?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Kategori AT dan Inventaris
            <br/>
            <select class="form-control select2" name="kat_at_inv" id="kat_at_inv">
              <option value="" selected readonly disabled> Pilih Kategori </option>
              <?php
                $slc1 = ($dtdefault->Flag_AT_or_Inv == "AT")? "selected":"";
                $slc2 = ($dtdefault->Flag_AT_or_Inv == "INV")? "selected":"";
              ?>
              <option value="AT" <?=$slc1?> >Aktiva Tetap</option>
              <option value="INV" <?=$slc2?> >Inventaris</option>
              
            </select>
          </div>
        </div>
        
        
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           No AT dan Inventaris
            <br/>
            <input type="text" class="form-control" name="no_at_inv" id="no_at_inv" placeholder="no at dan Inventaris" value="<?=$dtdefault->no_at_inv?>" required>
          </div>
        </div>
  
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Nama Barang
            <br/>
            <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Barang"  value="<?=$dtdefault->Desc_AT_n_Invent?>" required>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
          Tanggal Pembelian
            <br/>
            <input type="date" class="form-control" name="tgl_pembelian" id="tgl_pembelian" placeholder="Tanggal Pembelian" value="<?=$dtdefault->Tgl_Pengadaan?>"  required>
          </div>
        </div>


        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Penanggung Jawab
            <br/>
            <input type="text" class="form-control" name="penanggung_jawab" id="penanggung_jawab" value="<?=$dtdefault->penanggung_jawab?>" placeholder="Penggung Jawab"  >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
            No HP Penanggung Jawab 
            <br/>
            <input type="text" class="form-control" name="kontak_penanggung_jawab" id="kontak_penanggung_jawab" value="<?=$dtdefault->kontak_penanggung_jawab?>" placeholder="HP Kontak Penanggung Jawab"  >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Harga Barang 
            <br/>
            <input type="text" class="form-control" name="harga_barang" id="harga_barang" onkeyup="splitInDots(this)" value="<?=$dtdefault->Harga_Perolehan_Rp?>" placeholder="harga_barang"  >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Bukti Pembelian (jpg/jpeg/png) Sebelumnya :
            <?php
    		    if($dtdefault->bukti != null){
    		    ?>
    		    <a href="<?=base_url("uploads/fileapps/".$dtdefault->bukti)?>" download>Download Bukti Pembelian</a><br/>
    		    <img src="<?=base_url("uploads/fileapps/".$dtdefault->bukti)?>" style="width:130px;height:130px">
    		    <?php
    		    }
    		?>
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Ganti Bukti Pembelian (jpg/jpeg/png) 
            <br/>
            <input type="file" class="form-control" name="bukti" id="bukti"  >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Keterangan
            <br/>
            <textarea rows="5" cols="77px" name="keterangan"><?=$dtdefault->Keterangan?></textarea>
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
            <a href="" class="btn btn-danger btn-block btn-flat">Back</a>
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