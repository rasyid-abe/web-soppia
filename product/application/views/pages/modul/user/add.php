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
          <i class="fa fa-refresh"></i> Refresh</button>
      </div>
    </div>
    <div class="box-body">
      <form action="<?=base_url($this->uri->segment(1)."/store")?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />        
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            <strong>Account</strong>
          </div>
          <hr style="margin-bottom:0" />
        </div>
        <div class="form-group col-sm-6">
          <div class="col-sm-12">
            Nama Lengkap<br/>
            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname" value="<?=$this->session->flashdata('oldinput')['fullname']?>" >
          </div>
        </div>
        <div class="form-group col-sm-6">
          <div class="col-sm-12">
            Email<br/>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?=$this->session->flashdata('oldinput')['email']?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <hr style="margin-bottom:0;margin-top:0" />
        </div>
        <div class="form-group col-sm-4">
          <div class="col-sm-12">
            Username<br/>
            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?=$this->session->flashdata('oldinput')['username']?>" >
          </div>
        </div>
        <div class="form-group col-sm-4">
          <div class="col-sm-12">
            Password<br/>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
          </div>
        </div>
        <div class="form-group col-sm-4">
          <div class="col-sm-12">
            Peran/Role<br/>
            <select name="role" class="form-control select2" style="width: 100%;">
              <option value="" readonly disabled selected>Role/Peran</option>
              <?php
              foreach ($role->result() as $rl) {
                if(is_admin()){
                    $slc = ($this->session->flashdata('oldinput')['role']==$rl->idrole)? 'selected':'';
                    ?>
                    <option value="<?=$rl->idrole?>" <?=$slc?> ><?=$rl->name?></option>
                    <?php
                }else{
                  if($rl->is_khusus != '1'){
                    $slc = ($this->session->flashdata('oldinput')['role']==$rl->idrole)? 'selected':'';
                  ?>
                  <option value="<?=$rl->idrole?>" <?=$slc?> ><?=$rl->name?></option>
                  <?php
                  }
                }
              }
              ?>
            </select>
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
    $('.select2').select2();
  });
</script>