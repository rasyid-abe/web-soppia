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
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->Id_DokBukaKlsReguler)?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
            Deskripsi SK Pembukaan Kelas Reguler<br/>
            <input type="text" class="form-control" name="Desc_DokBukaKlsReguler" id="Desc_DokBukaKlsReguler" placeholder="Desc Dok Pembukaan Kelas Non IHT" value="<?=$dtdefault->Desc_DokBukaKlsReguler?>" >
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
            Rencana Tempat Penyelenggaraan<br/>
            <input type="text" class="form-control" name="Rencana_TempatSelenggara" id="Rencana_TempatSelenggara" placeholder="Rencana Tempat"  value="<?=$dtdefault->Rencana_TempatSelenggara?>" >
          </div>
        </div>


        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
            File Sebelumnya : 
            
            	<?php
                    if($dtdefault->File_Lampiran!=null){
                        if( @unserialize($dtdefault->File_Lampiran) !=  false){
                ?>
                    <div style="max-height:150px;overflow:auto">
                        <?php
                            foreach(unserialize($dtdefault->File_Lampiran) as $val ){
                            if($val == 'a:0:{}' || $val == null || $val == ''){
                                    
                                }else{
                        ?>
                                <button type="button" class="btn btn-xs btn-danger btn-delete-file-lampiran" data="<?=base_url('non-iht/Pembukaan_kelas_non_iht/delete_file/'.$dtdefault->Id_DokBukaKlsReguler.'/'.$val)?>"><i class="fa fa-trash"></i></button> <a href="<?=base_url('uploads/fileapps/non-iht/'.$val)?>" download> <?=$val?></a> <?=gettimefile($val)?> <br/> <br/>
                        <?php
                                }
                            }
                        ?>
                    </div>
                <?php
                        }else{
                            if($dtdefault->File_Lampiran != null && $dtdefault->File_Lampiran != 'a:0:{}' ){
                ?>
                            <button type="button" class="btn btn-xs btn-danger btn-delete-file-lampiran" data="<?=base_url('non-iht/Pembukaan_kelas_non_iht/delete_file/'.$dtdefault->Id_DokBukaKlsReguler.'/'.$dtdefault->File_Lampiran )?>"><i class="fa fa-trash"></i></button> <a href="<?=base_url('uploads/fileapps/non-iht/'.$dtdefault->File_Lampiran)?>"  download> <?=$dtdefault->File_Lampiran?></a> <?=gettimefile($dtdefault->File_Lampiran)?>
                <?php
                            }
                        }
                    }
                ?>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
            File Lampiran <br/>
            <input type="file" class="form-control" name="File_Lampiran[]" id="File_Lampiran" placeholder="File Lampiran" multiple>
            <p class="pull-right" style="color:grey">FIle berupa: .jpg .pdf .doc .xls .txt (Max: 3 Mb)</p>
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
    
     $(document).on("click",".btn-delete-file-lampiran",function(){
        var _url = $(this).attr("data");
        var _this = $(this);
        $.get(_url,function(data){
            _this.next().next().remove();
            _this.next().remove();
            _this.remove();
        })
    });
  });
</script>