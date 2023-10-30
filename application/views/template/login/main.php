<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$this->config->item("appname")?></title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/bower_components/Ionicons/css/ionicons.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/dist/css/AdminLTE.min.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/plugins/iCheck/square/blue.css')?>">
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/plugins/pace/pace.css')?>">
  <link rel="shortcut icon" href="<?=base_url('assets/images/soppia.png')?>">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="<?=base_url("assets/style/font.css")?>">
  <script src="<?=base_url('assets/adminlte/bower_components/jquery/dist/jquery.min.js')?>"></script>
  <script src="<?=base_url('assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
  <script src="<?=base_url('assets/adminlte/bower_components/PACE/pace.min.js')?>"></script>
  <script src="<?=base_url('assets/adminlte/plugins/iCheck/icheck.min.js')?>"></script>
  <script src="<?=base_url('assets/script/script.js')?>"></script>
  <?=$header?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
 <?=$content?>
</div>
<!-- /.login-box -->
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%'
    });
  });
</script>
 <?=$footer?>
</body>
</html>
