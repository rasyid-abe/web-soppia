  <div class="login-logo">
    <img src="<?=base_url('assets/images/soppia.png')?>" width="80px"> <br/>
    <b><?=$this->config->item("appname")?></b>
    <center><p style="font-size: 18px">SISTEM INFORMASI OPERASIONAL PIA</p></center>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="border-radius: 10px">
	<p class="login-box-msg">Sign in to start your session</p>
    <form action="<?=base_url('auth/login')?>" method="post">
      <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
      <div class="input-group">
        <input type="text" name="username" class="form-control" placeholder="Username/Email" required >
        <div class="input-group-btn">
          <button class="btn btn-default" type="button">
            <i class="glyphicon glyphicon-user"></i>
          </button>
        </div>
      </div>
      <br>
      <div class="input-group">
        <input type="password" name="password" class="form-control" placeholder="Password" required >
        <div class="input-group-btn">
          <button class="btn btn-default" type="button" id="see-lock-login">
            <i class="glyphicon glyphicon-lock"></i>
          </button>
        </div>
      </div>
      <br>
      <div class="row">
        <div class="col-xs-8">
			<a href="<?=base_url("forgot/password")?>">I forgot my password</a><br>
        </div>
        <div class="col-xs-4 text-right">
			<button type="submit" class="btn btn-default btn-block btn-flat">Sign In </button>
        </div>
      </div>
    </form>
  </div>
  <br/><br/>

  <?php if($this->session->flashdata('error')){ ?>
    <br>
    <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
  <?php }
  if($this->session->flashdata('success')){ ?>
    <br>
    <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
  <?php } ?>

  <script type="text/javascript">
    $(document).ready(function(){

      $(document).on("click","#see-lock-login",function(){
        if($(this).find("i:first-child").attr("style") == undefined ){
          $(this).parent().prev().attr("type","text");
          $(this).find("i:first-child").css({"color": "#A2A8B0"});
        }else{
          $(this).parent().prev().attr("type","password");
          $(this).find("i:first-child").removeAttr("style");
        }
      });

    });
  </script>
