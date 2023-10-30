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
  <div class="box" style="border-top:0px solid">
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
      <style type="text/css">
        #nestable .dd-item .dd-handle span{
          font-weight: lighter !important;
        }
      </style>
        <div class="dd" id="nestable">
            <ol class="dd-list">
            <?php
              $nesmenunotsub = $this->db->where(array('kategori !='=>'sub','active'=>'1'))->order_by('urutan','ASC')->get("menu");
              foreach ($nesmenunotsub->result() as $nmns) {
                if($nmns->parent == null || $nmns->parent == '' ){
            ?>
              <li class="dd-item" data-id="<?=$nmns->idmenu?>">
                <div class="dd-handle"><?=$nmns->name?> <span class="pull-right"> Label <?=getlabelname($nmns->labelmenu)?></span></div>
                <?php
                  $getchildnmns = $this->db->where(array('parent'=>$nmns->idmenu,'active'=>'1'))->order_by('urutan','ASC')->get("menu");
                  if($getchildnmns->num_rows()>0){
                ?>
                  <ol class="dd-list">
                    <?php
                      foreach ($getchildnmns->result() as $gcnmns) {
                    ?>
                      <li class="dd-item" data-id="<?=$gcnmns->idmenu?>">
                        <div class="dd-handle"><?=$gcnmns->name?> <span class="pull-right"> Label <?=getlabelname($gcnmns->labelmenu)?></span></div>
                        <?php
                          $getchildchildnmns = $this->db->where(array('parent'=>$gcnmns->idmenu,'active'=>'1'))->order_by('urutan','ASC')->get("menu");
                          if($getchildchildnmns->num_rows()>0){
                        ?>
                          <ol class="dd-list">
                            <?php
                              foreach ($getchildchildnmns->result() as $gccnmns) {
                            ?>
                            <li class="dd-item" data-id="<?=$gccnmns->idmenu?>">
                              <div class="dd-handle"><?=$gccnmns->name?><span class="pull-right"> Label <?=getlabelname($gccnmns->labelmenu)?></span></div>
                            </li>
                            <?php
                              }
                            ?>
                          </ol>
                        <?php
                          }
                        ?>
                      </li>
                    <?php
                      }
                    ?>
                  </ol>
                <?php
                  }
                ?>
              </li>
            <?php
                }
              }
            ?>
               
            </ol>
        </div>


    </div>

  </div>

</section>

<script type="text/javascript">  
 $(document).ready(function () {

    $('#nestable').nestable({
        group: 1,
        maxDepth:3,
    }).on('change', function(e){
      var list = e.length ? e : $(e.target), output = list.data('output');
         $.ajaxSetup({
          data: {
              '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
          }
        });
        $.ajax({
            url: _BASE_URL_+"menu/save-position-menu",
            method: "POST",
            data: {
                list: list.nestable('serialize')
            },success: function(rs){        
                
            }
        });
        //location.reload();
    });
});
</script>