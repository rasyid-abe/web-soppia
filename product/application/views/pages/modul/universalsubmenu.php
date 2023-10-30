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
	<?php 
	if($childmenu->num_rows()>0){
	?>
	<div class="row">
		<?php
		foreach ($childmenu->result() as $vlc) {
			if(checkaccessmenu($this->session->userdata('username'),$vlc->idmenu) ){
		?>
        <div class="col-lg-4 col-xs-12" >
          <a href="<?=base_url($vlc->url)?>" class="small-box-footer">
	          <div class="small-box bg-aqua" style="min-height:110px" data-toggle="tooltip" title="<?=$vlc->description?>">
	            <div class="inner">
	              <h4><?=$vlc->name?></h4>
	              <p style="color:#f2f2f2!important"><?=$subtitlepage?></p>
	            </div>
	            <div class="icon">
	              <i class="<?=$vlc->icon?>"></i>
	            </div>
	          </div>
          </a>
        </div>
		<?php
			}else{
		?>
		 <div class="col-lg-4 col-xs-12" >
          <a class="small-box-footer">
	          <div class="small-box bg-red" style="min-height:110px">
	            <div class="inner">
	              <h4><?=$vlc->name?></h4>
	              <p style="color:#f2f2f2!important">No Access</p>
	            </div>
	            <div class="icon">
	              <i class="<?=$vlc->icon?>"></i>
	            </div>
	          </div>
          </a>
        </div>
		<?php
			}
		}
		?>
    </div>
    <?php
	}else{
		echo "<p>Tidak Ada Sub Menu Pada Menu ".$menu->name."</p>";
	}
    ?>
</section>
<!-- /.content -->