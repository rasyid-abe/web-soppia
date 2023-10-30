<div class="alert alert-danger alert-dismissible alert-verifikasi-pembukaan-kunci">
  <div class="tamp-msg">

  </div>
</div>
<form action="<?=base_url('peserta/pembukaan-kunci-entry/verifikasi-proses/'.$dtdefault->Id_Peserta)?>" method="post" id="verifikasi-pembukaan-kunci-entry">
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
    <div class="col-xs-4 text-right">
	   <button type="submit" class="btn btn-default btn-block btn-flat">Verifikasi</button>
    </div>
  </div>
</form>


<script type="text/javascript">
  $(document).ready(function(){
    $(".alert-verifikasi-pembukaan-kunci").hide();
    
    $(document).on("click","#see-lock-login",function(){
      if($(this).find("i:first-child").attr("style") == undefined ){
        $(this).parent().prev().attr("type","text");
        $(this).find("i:first-child").css({"color": "#A2A8B0"});
      }else{          
        $(this).parent().prev().attr("type","password");
        $(this).find("i:first-child").removeAttr("style");
      }
    });

    $( "#verifikasi-pembukaan-kunci-entry" ).submit(function( event ) {
      event.preventDefault();
      var getaction = $(this).attr("action");
      var dataall = $(this).serialize();

      var rsl;
      $.ajax({    
        async: false,
        global: false,
        dataType: "json",
        method: "POST", 
        url: getaction,
        data:dataall, 
          success: function(result){
            rsl = result;
          }
      });
      if(rsl.status == 'error'){
        $(".alert-verifikasi-pembukaan-kunci").find(".tamp-msg").html(rsl.msg);
        $(".alert-verifikasi-pembukaan-kunci").fadeIn(200).delay( 1300 ).fadeOut(300);
      }else{
        $(".alert-verifikasi-pembukaan-kunci").find(".tamp-msg").html("<i class='fa fa-spinner fa-spin'></i> Data anda valid...<br/>tunggu beberapa menit anda akan dialihkan kehalaman pembukaan kunci....");
        $(".alert-verifikasi-pembukaan-kunci").removeClass("alert-danger").addClass("alert-success");
        $(".alert-verifikasi-pembukaan-kunci").fadeIn(200);
        setTimeout(function(){ window.location = rsl.msg; }, 5000);
        
      }

    });

  });
</script>