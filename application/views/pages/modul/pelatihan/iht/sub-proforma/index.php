<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net/buttons.dataTables.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")?>">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$titlepage?>
    <small><?=$subtitlepage?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a><?=$breadcrumb2?></a></li>
    <li class="active"><?=$breadcrumb3?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <?php if($this->session->flashdata('error')){ ?>
    <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
  <?php }else if($this->session->flashdata('success')){ ?>
    <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
  <?php } ?>

  <div class="box" style="border-top:0px solid">
    <div class="box-header with-border">
        <div class="box-title">
            <?php
                $checkfind = $this->db->where(array('FId_ProformaKontrak'=>$this->uri->segment(3)))->get("mst_kontrakresmi");
                if($checkfind->num_rows()>0){
                    $disabledbtn="";
                }else{
                    $disabledbtn="disabled";
                }
            ?>
          <button type="button" class="btn btn-sm btn-default add-tab-inisiasi-pelatihan " data-toggle="tooltip" title="Add Tab Addendum" <?=$disabledbtn?>><i class="fa fa-plus-circle"></i> Add Tab Addendum</button>
        </div>
        <div class="box-tools pull-right">
          <a href="<?=base_url($this->uri->segment(1).'/proforma-kontrak')?>" class="btn btn-box-tool" data-toggle="tooltip" title="Kembali Ke Manage proforma Kontrak"><i class="fa fa-arrow-circle-left"></i> Back</a>
          <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
            <i class="fa fa-refresh"></i></button>
        </div>
      </div>
    <div class="box-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs tab-inisiasi">
          <?php
            if($this->session->flashdata("active")){
                if( strpos($this->session->flashdata("active"),'addendum_') !== false ){
                  $nomurut = explode("_",$this->session->flashdata("active"));
                  $nomurut = $nomurut[1];
                  $activee = $this->session->flashdata("active");
                }else{
                  $activee = $this->session->flashdata("active");
                }
            }else{
                $activee = 'false';            
            }
          ?>
          <li class="<?=($activee == "false")? 'active':'';?>"><a data-href="<?=base_url("ajax/proforma/".$this->uri->segment(3))?>" data-toggle="tab" id="tabname" aria-expanded="true" style="cursor: pointer">Proforma</a></li>
          <li class="<?=($activee == "kontrakresmi")? 'active':'';?>"><a data-href="<?=base_url("ajax/kontrakresmi/".$this->uri->segment(3))?>" data-toggle="tab" id="tabname" aria-expanded="false" style="cursor: pointer">Kontrak Resmi</a></li> 
          <?php
            if($addendum->num_rows()>0){
              foreach ($addendum->result() as $add) {
          ?>
          <li class="<?=($activee == "addendum_".$add->No_Urut_Add)? 'active':'';?>"><a data-href="<?=base_url("ajax/addendum/".$this->uri->segment(3)."/".$add->No_Urut_Add)?>" data-toggle="tab" id="tabname" aria-expanded="false" style="cursor: pointer">Addendum <?=$add->No_Urut_Add?></a></li> 
          <?php
              }
            }
          ?>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
          <?php
            if(accessperm('melihat-data-proforma-kontrak')){ 
              if($activee == "false"){
              ?>                
              <script type="text/javascript">
                $(function(){
                    var link = '<?=base_url("ajax/proforma/".$this->uri->segment(3))?>';
                    $("#tab_1").load(link);
                })
              </script>
              <?php
              }else if($activee == "kontrakresmi"){

              ?>                
              <script type="text/javascript">
                $(function(){
                    var link = '<?=base_url("ajax/kontrakresmi/".$this->uri->segment(3))?>';
                    $("#tab_1").load(link);
                })
              </script>
              <?php
              }else if(strpos($this->session->flashdata("active"),'addendum_') !== false){

              ?>                
              <script type="text/javascript">
                $(function(){
                    var link = '<?=base_url("ajax/addendum/".$this->uri->segment(3)."/".$nomurut)?>';
                    $("#tab_1").load(link);
                })
              </script>
              <?php

              }
            }else{
              echo "anda tidak memiliki akses untuk melihat ini!";
            }
          ?>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
    </div>
  </div>

</section>

<script type="text/javascript">
  $(function(){
      
    $(document).ready(function(){
        $.session.remove('Desc_KontrakResmi');
        $.session.remove('Nilai_Rp');
        $.session.remove('Rencana_JmlPeserta');
        $.session.remove('Rencana_TempatSelenggara');
    });
    $(document).on("click",".add-tab-inisiasi-pelatihan",function(){
      var sizetab = $(".tab-inisiasi").children().length;
      var _newsize = (sizetab-2+1);
      $.getJSON('<?=base_url('ajax/addendumcheck/')?>'+_newsize+'/'+'<?=$this->uri->segment(3)?>',function(data){
          if(data.status == true){
              if(data.jum == (_newsize-1)){
                   $(".tab-inisiasi").append('<li class=""><a data-href="<?=base_url("ajax/addendumadd/".$this->uri->segment(3))?>" data-toggle="tab" id="tabname" aria-expanded="false" style="cursor: pointer">Addendum '+(sizetab-2+1)+'</a></li>');
              }
          }else{
              if(data.jum == (_newsize-1)){
                   $(".tab-inisiasi").append('<li class=""><a data-href="<?=base_url("ajax/addendumadd/".$this->uri->segment(3))?>" data-toggle="tab" id="tabname" aria-expanded="false" style="cursor: pointer">Addendum '+(sizetab-2+1)+'</a></li>');
              }else{
                alert("mohon selesaikan form addendum "+(_newsize-1)+" jika ingin menambahkan addendum baru");
              }
          }
      });
      
      });

    $(document).on("click","#tabname",function(){
      var link = $(this).attr("data-href");
      $("#tab_1").load(link);
    });

  })

</script>