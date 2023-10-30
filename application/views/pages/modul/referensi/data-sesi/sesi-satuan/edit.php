
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
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->Kd_Sesi_Satuan)?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Nama Paket Sesi Satuan<br/>
            <input type="text" class="form-control" name="Desc_Sesi" id="Desc_Sesi" placeholder="Desc Sesi Satuan"  value="<?=$dtdefault->Desc_Sesi?>" >
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Flag Ramadhan<br/>
            <select name="Flag_Ramadhan" class="form-control select2" style="width: 100%;">
              <option value="" readonly disabled selected>Flag Ramadhan</option>
              <?php
                $slc1 = ($dtdefault->Flag_Ramadhan == "Y" )? 'selected' :'';
                $slc2 = ($dtdefault->Flag_Ramadhan == "N" )? 'selected' :'';
              ?>
              <option value="Y" <?=$slc1?> >Ya</option>
              <option value="N" <?=$slc2?> >Tidak</option>
              <?php
              
              ?>
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Flag Jumat<br/>
            <select name="Flag_Jumat" class="form-control select2" style="width: 100%;">
              <option value="" readonly disabled selected>Flag Jumat</option>
              <?php
                $slc3 = ($dtdefault->Flag_Jumat == "Y" )? 'selected' :'';
                $slc4 = ($dtdefault->Flag_Jumat == "N" )? 'selected' :'';
              ?>
              <option value="Y" <?=$slc3?> >Ya</option>
              <option value="N" <?=$slc4?> >Tidak</option>
              <?php
              
              ?>
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Flag Rehat Lunch<br/>
            <select name="Flag_RehatLunch" class="form-control select2" style="width: 100%;">
              <option value="" readonly disabled selected>Flag Rehat Lunch</option>
              <?php
                $slc5 = ($dtdefault->Flag_RehatLunch == "Y" )? 'selected' :'';
                $slc6 = ($dtdefault->Flag_RehatLunch == "N" )? 'selected' :'';
              ?>
              <option value="Y" <?=$slc5?> >Ya</option>
              <option value="N" <?=$slc6?> >Tidak</option>
              <?php
              
              ?>
            </select>
          </div>
        </div>        

        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Keterangan<br/>
            <textarea class="form-control" name="Keterangan" id="Keterangan" placeholder="Keterangan"><?=$dtdefault->Keterangan?></textarea>
          </div>
        </div>   

        <div class="form-group col-sm-12">
          <hr style="margin-bottom:0;margin-top:0" />
        </div>

        <div class="form-group col-sm-12"> 
          <div class="col-sm-2">
            <button type="submit" class="btn btn-block btn-flat">Update</button>
          </div>
          <div class="col-sm-2">
            <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-danger btn-block btn-flat">Back</a>
          </div>
        </div>

      </form>
    </div>

  </div>

</section>

<script type="text/javascript">  
  $(function () {
  });
</script>