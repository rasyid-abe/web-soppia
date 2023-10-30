<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
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
  <div class="box" style="border-top:0px solid">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$titlebox?></h3>

      <div class="box-tools pull-right">
        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                title="Kembali Ke Manage <?=$subtitlepage?>">
          <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/store")?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
            Addendum Kontrak<br/>
            <input type="text" class="form-control" name="Desc_AddKontrak" id="Desc_AddKontrak" placeholder="Desc Addendum Kontrak" value="<?=$this->session->flashdata('oldinput')['Desc_AddKontrak']?>" >
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
            Proforma Kesepakatan Kontrak<br/>
            <select name="FId_ProformaKontrak" class="form-control select2" id="FId_ProformaKontrak" style="width: 100%;" required="required">
              <option value="" readonly disabled selected>Pilih Proforma Kontrak</option>
              <?php
              foreach ($fid_proformakontrak->result() as $fiid) {
                $slc = ($this->session->flashdata('oldinput')['FId_ProformaKontrak']==$fiid->Id_ProformaKontrak)? 'selected':'';
              ?>
              <option value="<?=$fiid->Id_ProformaKontrak?>" <?=$slc?> ><?=$fiid->Desc_ProformaKontrak?></option>
              <?php
              }
              ?>
            </select>
          </div>
        </div>
        <div  id="temp-pershinstansi">
        
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
     $.ajaxSetup({
      data: {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      }
    });
    $(document).on("change","#FId_ProformaKontrak",function(){
      var _ThisVal = $(this).val();
      $('#temp-pershinstansi').load(_BASE_URL_+'ajax/getproformapersInst/'+_ThisVal,function(){
        $('.select2').select2();
      });
    });
  });
</script>