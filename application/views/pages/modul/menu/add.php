<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$titlepage?>
    <small><?=$subtitlepage?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li class="active"><?=$breadcrumb2?></li>
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
        <a href="<?=base_url($this->uri->segment(1))?>" class="btn btn-box-tool" data-toggle="tooltip"
                title="Kembali Ke Manage <?=$subtitlepage?>">
          <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">
      <form action="<?=base_url($this->uri->segment(1)."/store")?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" /> 

        <div class="form-group col-sm-6">
          <div class="col-sm-12">
            Kategori Menu<br/>
            <select name="tipe" class="form-control" id="tipe-select-menu" style="width: 100%;">
              <option value="induk">MENU INDUK</option>
              <option value="tunggal" selected="selected">MENU TUNGGAL</option>
              <option value="sub">SUB MENU</option>
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <hr style="margin-bottom:0;margin-top:0" />
        </div>

        <div class="form-group col-sm-12" id="parent-select-menu-place" >
          <div class="col-sm-6">
            INDUK MENU<br/>
            <select name="parent" class="form-control select2" style="width: 100%;">
              <option value="" readonly disabled selected>PARENT MENU (INDUK MENU)</option>
              <?php
              foreach ($parent->result() as $rl) {
                if(!empty($this->session->flashdata('oldinput')['parent'])){                  
                  $slc = ($this->session->flashdata('oldinput')['parent']==$rl->idmenu)? 'selected':'';
                }else{
                  $slc = '';
                }
              ?>
              <option value="<?=$rl->idmenu?>" <?=$slc?> ><?=$rl->name?></option>
              <?php
              }
              ?>
            </select>
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Nama Menu/Sub Menu<br/>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name Menu/Sub Menu"  value="<?=$this->session->flashdata('oldinput')['name']?>" >
          </div>
        </div>
        <div class="form-group col-sm-12" id="url-input-menu-place">
          <div class="col-sm-6">
            Url<br/>
            <input type="text" class="form-control" name="url" id="url" placeholder="url"  value="<?=$this->session->flashdata('oldinput')['url']?>" >
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-4">
            Icon<br/>
            <input type="text" class="form-control" name="icon" id="icon" placeholder="icon"  value="<?=$this->session->flashdata('oldinput')['icon']?>" >
          </div>
          <div class="col-sm-4">
            <br/>
            <button type="button" class="btn btn-sm btn-flat add-icon-menu"><i class="fa fa-plus-circle"></i></button>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-4" id="label-menu-place-select">
            Label Menu<br/>
            <select name="labelmenu" class="form-control select2" style="width: 100%;">
              <option value="" readonly disabled selected>LABEL MENU</option>
              <?php
              foreach ($labelmenu->result() as $lbmn) {
                if(!empty($this->session->flashdata('oldinput')['labelmenu'])){                  
                  $slc1 = ($this->session->flashdata('oldinput')['labelmenu']==$lbmn->idlabelmenu)? 'selected':'';
                }else{
                  $slc1 = '';
                }
              ?>
              <option value="<?=$lbmn->idlabelmenu?>" <?=$slc1?> ><?=$lbmn->name?></option>
              <?php
              }
              ?>
            </select>
          </div>
          <div class="col-sm-4">
            <br/>
            <button type="button" class="btn btn-sm btn-flat add-label-menu"><i class="fa fa-plus-circle"></i></button>
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-2">
            Status Aktif <br/>
            <select name="active" class="form-control " style="width: 100%;">
              <option value="0">NO ACTIVE</option>
              <option value="1"selected>ACTIVE</option>
            </select>
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Keterangan <br/>
            <textarea name="description" class="form-control" placeholder="Description"><?=$this->session->flashdata('oldinput')['description']?></textarea>
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
            <a href="<?=base_url($this->uri->segment(1))?>" class="btn btn-danger btn-block btn-flat">Back</a>
          </div>
        </div>

      </form>
    </div>

  </div>

</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $.ajaxSetup({
      data: {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      }
    });
    $('.select2').select2();
    $(document).on("click",".add-label-menu",function(){
      $("#modal-default").find(".modal-dialog .modal-content .modal-header .modal-title").html("Tambah Data Label");
      $("#modal-default").find(".modal-dialog .modal-content .modal-body").load(_BASE_URL_+'<?=$this->uri->segment(1)?>/addlabel');
      $("#modal-default").find(".modal-dialog").addClass("animated bounceIn");
      $("#modal-default").modal("show");
    });
    $(document).on("click",'.save-labelmenu-modal',function(){
      $.post(_BASE_URL_+'menu/labelstore/',{'data':$('#labelmenu-modal').val()},function( data ) {
        if(data == 'gagal'){
          $("#modal-default").find(".modal-dialog .modal-content .modal-body").load(_BASE_URL_+'<?=$this->uri->segment(1)?>/addlabel/'+data);
        }else{
          $("#label-menu-place-select").load(_BASE_URL_+'<?=$this->uri->segment(1)?>/loadlabelmenu',function(){
            $('.select2').select2();
          });
          $("#modal-default").find(".modal-dialog .modal-content .modal-body").load(_BASE_URL_+'<?=$this->uri->segment(1)?>/addlabel');

        }
      });
    });
    $(document).on("change","#tipe-select-menu",function(){
      var thisval = $(this).val();
      if(thisval=='induk'){
        $("#parent-select-menu-place").addClass("hide");
        $("#url-input-menu-place").addClass("hide");
      }else if(thisval=='tunggal'){
        $("#parent-select-menu-place").removeClass("hide");
        $("#url-input-menu-place").removeClass("hide");
      }else if(thisval=='sub'){
        $("#parent-select-menu-place").removeClass("hide");
        $("#url-input-menu-place").addClass("hide");
      }else{

      }
    });

    $(document).on("click",".add-icon-menu",function(){
      $("#modal-default").find(".modal-dialog .modal-content .modal-header .modal-title").html("Pilih Icon");
      $("#modal-default").find(".modal-dialog .modal-content .modal-body").load(_BASE_URL_+'<?=$this->uri->segment(1)?>/loadicon');
      $("#modal-default").find(".modal-dialog").addClass("animated bounceIn");
      $("#modal-default").modal("show");
    });

    $(document).on("click",".ico-choice",function(){
      var thisval = $(this).find("i").attr("class");
      $("#icon").val(thisval);
      $("#modal-default").modal("hide");

    });


  });
</script>