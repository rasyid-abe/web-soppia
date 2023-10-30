<link rel="stylesheet" href="<?=base_url("assets/adminlte/plugins/iCheck/all.css")?>">
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
  <div class="box" style="border-top:0px solid">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$titlebox?> <b><?=$role->name?></b></h3>

      <div class="box-tools pull-right">        
        <a href="<?=base_url($this->uri->segment(1))?>" class="btn btn-box-tool" data-toggle="tooltip" title="Kembali Ke Manage <?=$subtitlepage?>"><i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">
        <div class="panel-group" id="accordion">
          <?php
          $noomas = 1;
            foreach($menu->result() as $mn){
             if($mn->parent == null || $mn->parent == ''){
          ?>
              <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$noomas?>"><?=$mn->name?></a>
                  </h4>
                </div>
                <div id="collapse<?=$noomas?>" class="panel-collapse collapse <?=($noomas=='1')? 'in':''; ?>">
                 <?php
                  $cekanak = $this->db->where("parent",$mn->idmenu)->order_by("urutan")->get("menu");
                  if($cekanak->num_rows()>0){
                ?>
                  <div class="panel-body">
                    <div class="panel-group" id="accordion<?=$noomas?>">
                    <?php
                      $noomasa = 1;
                      foreach ($cekanak->result() as $cekank ) {
                    ?>
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion<?=$noomas?>" href="#collapseaa<?=$noomas?><?=$noomasa?>"><?=$cekank->name?></a>
                          </h4>
                        </div>
                        <div id="collapseaa<?=$noomas?><?=$noomasa?>" class="panel-collapse collapse ">
                          <?php
                            $ceksubdarianak = $this->db->where("parent",$cekank->idmenu)->order_by("urutan")->get("menu");
                            if($ceksubdarianak->num_rows()>0){
                            ?>
                              <div class="panel-body">
                                <div class="panel-group" id="accordion<?=$noomasa?>">
                            <?php
                              $nomasaabb = 1;
                              foreach ($ceksubdarianak->result() as $kv){
                            ?>
                                <div class="panel panel-default">
                                  <div class="panel-heading">
                                    <h4 class="panel-title">
                                      <a data-toggle="collapse" data-parent="#accordion<?=$noomasa?>" href="#collapseaa<?=$noomas?><?=$noomasa?><?=$nomasaabb?>"><?=$kv->name?></a>
                                    </h4>
                                  </div>
                                  <div id="collapseaa<?=$noomas?><?=$noomasa?><?=$nomasaabb?>" class="panel-collapse collapse ">
                                  <?php
                                          
                                    $getperm = $this->db->where('idmenu',$kv->idmenu)->order_by("name")->get("permission");
                                    if($getperm->num_rows()>0){
                                      foreach ($getperm->result() as $val) {
                                        ?>
                                        <div class="panel-body">
                                          <label>
                                            <?php $check = (checkroleperm($role->idrole,$val->idpermission))? 'checked':''; ?>
                                            <input type="checkbox" class="flat-red set-role-checkbox" data-role="<?=$role->idrole?>" data-perm="<?=$val->idpermission?>" <?=$check?> disabled >
                                            <?=ucfirst($val->name)?>
                                          </label>
                                          <br/>
                                            <?=$val->description?>
                                        </div>
                                        <?php
                                      }
                                    }
                                  ?>
                                  </div>
                                </div>
                            <?php
                              $nomasaabb++;
                              }
                            ?>
                                </div>
                              </div>
                            <?php
                            }else{
                              $getperm = $this->db->where('idmenu',$cekank->idmenu)->order_by("name")->get("permission");
                              if($getperm->num_rows()>0){
                                foreach ($getperm->result() as $val) {
                                  ?>
                                  <div class="panel-body">
                                    <label>
                                      <?php $check = (checkroleperm($role->idrole,$val->idpermission))? 'checked':''; ?>
                                      <input type="checkbox" class="flat-red set-role-checkbox" data-role="<?=$role->idrole?>" data-perm="<?=$val->idpermission?>" <?=$check?> readonly disabled >
                                      <?=ucfirst($val->name)?>
                                    </label>
                                    <br/>
                                      <?=$val->description?>
                                  </div>
                                  <?php
                                }
                              }
                            }
                          ?>
                        </div>
                      </div>
                    <?php
                        $noomasa++;
                      }
                    ?>
                    </div>
                  </div>
                <?php
                  }
                ?>
                </div>
              </div>
          <?php
             }
             $noomas++; 
            }
          ?>
        </div>

    </div>

  </div>

</section>
<script src="<?=base_url("assets/adminlte/plugins/iCheck/icheck.min.js")?>"></script>
<script type="text/javascript">  
  $(function(){    
    $.ajaxSetup({
      data: {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      }
    });
    
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    });

    $(document).on("ifChanged","input[type='checkbox'].set-role-checkbox",function(){
      var thisval = $(this);
      //alert(thisval.val());
      //var Thislink = _BASE_URL_+'role/permrole/'+thisval.attr("data-role")+'/'+thisval.attr("data-perm");
      //if(thisval.is(':checked')){
        //$.ajax({method: "GET", url: Thislink, success: function(rs){
          //if(rs == 'sukses'){          
            //location.reload();
          //};
        //}});
     // }else{
      //   $.ajax({method: "GET", url: Thislink, success: function(rs){
       //     if(rs == 'sukses'){          
              //location.reload();
       //     };
       //   }});
//}
    });

  });
</script>