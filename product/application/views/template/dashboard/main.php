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
  <link rel="stylesheet" href="<?=base_url('assets/adminlte/dist/css/skins/_all-skins.min.css')?>">
<!--  <link rel="stylesheet" href="<?=base_url('assets/adminlte/plugins/pace/pace.css')?>">-->
  <link rel="shortcut icon" href="<?=base_url('assets/images/soppia.png')?>">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <link rel="stylesheet" href="<?=base_url("assets/style/font.css")?>">
  <link rel="stylesheet" href="<?=base_url("assets/style/animate.min.css")?>">
  <link rel="stylesheet" href="<?=base_url("assets/style/nestable.css")?>">
  <script src="<?=base_url('assets/adminlte/bower_components/jquery/dist/jquery.min.js')?>"></script>
  <script src="<?=base_url('assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js')?>"></script>
  <!--<script src="<?=base_url('assets/adminlte/bower_components/PACE/pace.min.js')?>"></script>-->
  <script src="<?=base_url('assets/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')?>"></script>
  <script src="<?=base_url('assets/adminlte/bower_components/fastclick/lib/fastclick.js')?>"></script>
  <script src="<?=base_url('assets/adminlte/dist/js/adminlte.min.js')?>"></script>
  <script src="<?=base_url('assets/script/jquery.nestable.js')?>"></script>
  <script src="<?=base_url('assets/script/jquery.session.js')?>"></script>
  <script src="<?=base_url('assets/script/script.js')?>"></script>
  <script type="text/javascript">
      // Set CodeIgniter base_url in JavaScript var to use within
      var _BASE_URL_ = "<?=base_url()?>";
      var _CSRF_NAME_ = "<?=$this->security->get_csrf_token_name()?>";

      (function($) {
          /**
           * New jQuery function to set/refresh CSRF token in Body & to attach AjaxPOST
           * @param  {[type]} $ [description]
           * @return {[type]}   [description]
           */
           $.fn.CsrfAjaxSet = function(CsrfObject) {
              // getting meta object from body head section by csrf name
              var CsrfMetaObj = $('meta[name="' + _CSRF_NAME_ + '"]'),
              CsrfSecret = {};
              // if CsrfObject not set/pass in function
              if (typeof CsrfObject == 'undefined') {
                  // assign meta object in CsrfObject
                  CsrfObject = CsrfMetaObj;
                  // get meta tag name & value
                  CsrfSecret[CsrfObject.attr('name')] = CsrfObject.attr('content');
              }
              // CsrfObject pass in function
              else {
                  // get Csrf Token Name from JSON
                  var CsrfName = Object.keys(CsrfObject);
                  // set csrf token name & hash value in object
                  CsrfSecret[CsrfName[0]] = CsrfObject[CsrfName[0]];
              }
              // attach CSRF object for each AjaxPOST automatically
              $.ajaxSetup({
                  data: CsrfSecret
              });
          };
          /**
           * New jQuery function to get/refresh CSRF token from CodeIgniter
           * @param  {[type]} $ [description]
           * @return {[type]}   [description]
           */
           $.fn.CsrfAjaxGet = function() {
              return $.get(_BASE_URL_ + 'Csrfdata', function(CsrfJSON) {
                  $(document).CsrfAjaxSet(CsrfJSON);
              }, 'JSON');            
          };
      })(jQuery);

      // On DOM ready attach CSRF within AjaxPOST
      $(document).CsrfAjaxSet();
  </script>
   <style type="text/css">
    .wrapper::-webkit-scrollbar {
      width: 0.25em;
    }
     
    .wrapper::-webkit-scrollbar-track {
      -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0);
    }
     
    .wrapper::-webkit-scrollbar-thumb {
      background-color: rgba(0,0,0,0.3);
      outline: 1px solid slategrey;
    }

    div::-webkit-scrollbar {
      width: 0.4em;
    }
     
    div::-webkit-scrollbar-track {
      -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0);
    }
     
    div::-webkit-scrollbar-thumb {
      background-color: rgba(0,0,0,0.3);
      outline: 1px solid slategrey;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini skin-black-light">

  <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
      <div class="modal-content"  style="border-radius: 15px;border:0px solid">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
  </div>

  <div class="wrapper" style="background:#ecf0f5">

    <?=$header?>
    <?=$asidebar?>
    <div class="content-wrapper" id="content-wrapper">
     <?=$content?>
    </div>

  </div>

  <script>
    $(document).ready(function () {
      $('.sidebar-menu').tree()
    })
  </script>

  <?=$footer?>

</body>
</html>
