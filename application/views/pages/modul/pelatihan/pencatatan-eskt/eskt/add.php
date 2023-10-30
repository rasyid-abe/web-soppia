<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
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
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/store")?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    

        <div class="form-group col-sm-12">
            <div class="col-sm-2 peserta">
              <label>Nama Peserta</label>
            </div>
            <div class="col-sm-6 peserta">
              <select name="FId_Peserta" class="form-control select2" style="width: 100%;">
                <option value="" readonly disabled selected>Pilih Peserta</option>
                <?php
                foreach ($peserta->result() as $data) {
                  $slc = ($this->session->flashdata('oldinput')['FId_Peserta']==$data->Id_Peserta)? 'selected':'';
                ?>
                <option value="<?=$data->Id_Peserta?>" <?=$slc?> ><?=$data->NamaLengkap_DgnGelar?></option>
                <?php
                }
                ?>
              </select>
            </div>
            <div class="col-sm-2 bukan">
              <label>Bukan Peserta</label>
            </div>
            <div class="col-sm-6 bukan">
              <input type="text" class="form-control" name="Nama_PemberiSaran" placeholder="Nama Pemberi Saran"/>
            </div>
            <div class="col-sm-3">
                <button type="button" class="btn btn-primary btn-sm btnamap">Ganti Pemberi Saran</button>
                <button type="button" class="btn btn-primary btn-sm btnamas">Ganti Pemberi Saran</button>
            </div>
        </div>
        
        <div class="form-group col-sm-12">
            <div class="col-sm-2">
              <label>Isi Saran</label>
            </div>
            <div class="col-sm-10">
                <textarea class="form-control" name="Isi_Saran" id="Isi_Saran" placeholder="Isi Saran"><?=$this->session->flashdata('oldinput')['Isi_Saran']?></textarea>
            </div>
        </div>
        
        <div class="form-group col-sm-12">
            <div class="col-sm-2">
              <label>Isi Komplain</label>
            </div>
            <div class="col-sm-10">
                <textarea class="form-control" name="Isi_Komplain" id="Isi_Komplain" placeholder="Isi Komplain"><?=$this->session->flashdata('oldinput')['Isi_Komplain']?></textarea>
            </div>
        </div>

        <div class="form-group col-sm-12">
          <hr style="margin-bottom:0;margin-top:0" />
        </div>

        <div class="form-group col-sm-12"> 
          <div class="col-sm-3 pull-right">
            <button type="submit" class="btn btn-block btn-success">Save</button>
          </div>
          <div class="col-sm-3 pull-right">
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
<script>
$(document).ready(function(){
    $(".bukan,.btnamas").hide();
    $(".btnamap").click(function(){
        $(".peserta").hide();
        $(".bukan").show();
        $(".btnamas").show();
        $(".btnamap").hide();
    });
    $(".btnamas").click(function(){
        $(".bukan").hide();
        $(".peserta").show();
        $(".btnamap").show();
        $(".btnamas").hide();
    });
});
</script>