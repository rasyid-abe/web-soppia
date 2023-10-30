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
    <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
  <?php }else if($this->session->flashdata('success')){ ?>
    <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
  <?php } ?>

  <!-- Default box -->
  <div class="box" style="border-top:0px solid">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$titlebox?></h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">

<div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <?php
                    if($this->session->flashdata('tabact')){
                        $tabact = $this->session->flashdata('tabact');
                        if($tabact == '2'){
                            $tab2 = "active";
                            $tab1 = '';
                        }else{
                            $tab2 = "";
                            $tab1 = 'active';
                        }
                    }else{
                        $tab2 = "";
                        $tab1 = 'active';
                    }
                ?>
              <li class="<?=$tab1?>"><a href="#tab_1" data-toggle="tab">Informasi Profil</a></li>
              <li class="<?=$tab2?>"><a href="#tab_2" data-toggle="tab">Pengaturan Profil</a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane <?=$tab1?>" id="tab_1">
                <table class="table">
                    <tr>
                        <td>Nama Lengkap</td>
                        <td><?=$detail->row()->fullname?></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td><?=$user->row()->username?></td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td><?=$user->row()->email?></td>
                    </tr>
                    <tr>
                        <td>Role/Peran</td>
                        <td><?=getrolename($user->row()->iduser)?></td>
                    </tr>
                </table>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane <?=$tab2?>" id="tab_2">
                <div class="container-fluid">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-info"></i> Info!</h4>
                        Ketika anda mengganti password/username/email sistem akan mengembalikan anda kepada halaman login untuk melakukan login berdasarkan password/username/email yang anda perbaharui.
                    </div>
                    <form action="<?=base_url($this->uri->segment(1)."/store")?>" method="POST">
                        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                        <input type="hidden" name="iduser" value="<?=$user->row()->iduser?>" />
                        <div class="form-group col-sm-12">
                          <div class="col-sm-6">
                            Nama Lengkap<br/>
                            <input type="text" class="form-control" name="fullname" id="fullname" placeholder="Fullname" value="<?=$detail->row()->fullname?>" >
                          </div>
                        </div>
                        <div class="form-group col-sm-12">
                          <div class="col-sm-6">
                            Email<br/>
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email" value="<?=$user->row()->email?>" >
                          </div>
                        </div>
                        <div class="form-group col-sm-12">
                          <div class="col-sm-6">
                            Username<br/>
                            <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?=$user->row()->username?>" >
                          </div>
                        </div>
                        <div class="form-group col-sm-12">
                          <div class="col-sm-6 text-right">
                              <button class="btn btn-primary btn-xs" type="button" id="gnti-password" data="0"><i class="fa fa-asterisk"></i> Ganti Password</button>
                          </div>
                        </div>
                        <div class="form-group col-sm-12 password hide">
                          <div class="col-sm-6">
                            Password<br/>
                            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                          </div>
                        </div>
                        <div class="form-group col-sm-12 password  hide">
                          <div class="col-sm-6">
                            Konfirmasi Password<br/>
                            <input type="password" class="form-control" name="cpassword" id="cpassword" placeholder="Konfirmasi Password">
                          </div>
                        </div>
                        <div class="form-group col-sm-12">
                          <div class="col-sm-6">
                              <button class="btn btn-success btn-sm" type="submit"><i class="fa fa-cog"></i> Simpan</button>
                          </div>
                        </div>
                    </form>
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>     

    </div>

  </div>

</section>


<script type="text/javascript">  
  $(function () {
    $.ajaxSetup({
      data: {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      }
    });
    
    $(document).on("click","#gnti-password",function(){
        var thisval = $(this).attr("data");
        if(thisval == "0"){
            $(this).attr("data","1");
            $(".password").removeClass("hide");
        }else{
            $(this).attr("data","0");
            $(".password").addClass("hide");
        }
    });
  })  
</script>