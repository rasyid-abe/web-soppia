  <div class="login-logo">  
    <img src="<?=base_url('assets/images/soppia.png')?>" width="80px">
    <b>Admin</b> <?=$this->config->item("appname")?>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" style="border-radius: 10px">
    <h3 class="text-center">Forgot Password</h3>
    <hr/>
    <form action="<?=base_url('forgot/send')?>" method="post">
      <div class="form-group">
        <input type="email" class="form-control" placeholder="Email">
      </div>
      <br/>
      <div class="row">
        <div class="col-xs-6">
          <button type="submit" class="btn btn-default btn-block btn-flat">Submit</button>
        </div>
        <div class="col-xs-6">
          <a href="<?=base_url('login')?>" class="btn btn-danger btn-block btn-flat">Back</a>
        </div>
        <!-- /.col -->
      </div>
    </form>
  </div>
  <!-- /.login-box-body -->