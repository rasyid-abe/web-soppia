<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<!-- Content Header (Page header) -->

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
        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3))?>" class="btn btn-box-tool" data-toggle="tooltip"
                title="Kembali Ke Manage <?=$subtitlepage?>">
          <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3)."/update/".$dtdefault->Id_KontrakResmi)?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
            Desc Kontrak Resmi<br/>
            <input type="text" class="form-control" name="Desc_KontrakResmi" id="Desc_KontrakResmi" placeholder="Desc Kontrak Resmi" value="<?=$dtdefault->Desc_KontrakResmi?>" >
          </div>
        </div>
        <div  id="temp-pershinstansi">


          <div class="form-group col-sm-12">
            <div class="col-sm-6" style="color:#00008B">
              Proforma Kontrak<br/>
                <input type="hidden" name="FId_ProformaKontrak" class="form-control " id="FId_ProformaKontrak"  value="<?=$fid_proformakontrak->row()->Id_ProformaKontrak?>">
                <input type="text" class="form-control" value="<?=$fid_proformakontrak->row()->Desc_ProformaKontrak?>" disabled>
            </div>
          </div>

          <div class="form-group col-sm-12">
            <div class="col-sm-6" style="color:#00008B">
              Perusahaan / Instansi<br/>
                <input type="hidden" name="FId_PershInstansi" class="form-control " id="FId_PershInstansi"  value="<?=$fid_pershinstansi->row()->Id_PershInstansi?>">
                <input type="text" class="form-control" value="<?=$fid_pershinstansi->row()->Desc_PershInstansi?>" disabled>
            </div>
          </div>

          <div class="form-group col-sm-12">
            <div class="col-sm-6" style="color:#00008B">
              Nilai Rp<br/>
              <input type="text" class="form-control" name="Nilai_Rp" id="Nilai_Rp" placeholder="Nilai Rp" value="<?=str_replace(",",".",number_format($dtdefault->Nilai_Rp))?>"  onkeyup="splitInDots(this)" >
            </div>
          </div>

          <div class="form-group col-sm-12">
            <div class="col-sm-6" style="color:#00008B">
              Jumlah Peserta<br/>
              <input type="number" class="form-control" name="Rencana_JmlPeserta" id="Rencana_JmlPeserta" placeholder=" Jumlah Peserta" value="<?=$dtdefault->Rencana_JmlPeserta?>" >
            </div>
          </div>

          <div class="form-group col-sm-12">
            <div class="col-sm-6" style="color:#00008B">
              Rencana Tempat Penyelenggaraan<br/>
              <input type="text" class="form-control" name="Rencana_TempatSelenggara" id="Rencana_TempatSelenggara" placeholder="Tempat Pelaksanaan" value="<?=$dtdefault->Rencana_TempatSelenggara?>" >
            </div>
          </div>
          <?php
            if($dtdefault->File_Lampiran != null){
          ?>
          <div class="form-group col-sm-12">
            <div class="col-sm-6" style="color:#00008B">
              File Sebelumnya : <a href="<?=base_url('uploads/fileapps/'.$dtdefault->File_Lampiran)?>">File Lampiran</a>
              <input type="hidden" name="filesebelumnya" value="<?=$dtdefault->File_Lampiran?>" >
            </div>
          </div>
          <?php
            }
          ?>

          <div class="form-group col-sm-12">
            <hr style="margin-bottom:0;margin-top:0" />
          </div>

          <div class="form-group col-sm-12">
            <div class="col-sm-6" style="color:#00008B">
              <?=($dtdefault->File_Lampiran != null)? "Ganti File": "File"; ?>:<br/>
              <input type="file" class="form-control" name="File_Lampiran" id="File_Lampiran" placeholder="File Lampiran" >
              <p class="pull-right" style="color:grey">File berupa: .jpg .pdf .doc .xls .txt (Max: 3 Mb)</p>
            </div>
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
            <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3))?>" class="btn btn-danger btn-block btn-flat">Back</a>
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
     /*$.ajaxSetup({
      data: {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      }
    });
    $(document).on("change","#FId_ProformaKontrak",function(){
      var _ThisVal = $(this).val();
      $('#temp-pershinstansi').load(_BASE_URL_+'ajax/getproformapersInst/'+_ThisVal,function(){
        $('.select2').select2();
      });
    });*/
  });
</script>