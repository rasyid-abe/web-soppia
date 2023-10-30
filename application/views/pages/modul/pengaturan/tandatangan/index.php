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
          <i class="fa fa-refresh"></i>
        </button>
      </div>
    </div>
    <div class="box-body">
      
    <form action="<?=base_url("pengaturan/tanda-tangan/store")?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" /> 
        <div class="table-responsive">
        <table class="table table-bordered table-striped dt-table" style="width: 100%">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Jabatan</th>
                <th><?=nbs(2)?></th>
              </tr>
            </thead>
            <tbody>
                <?php
                    if($dt->num_rows()>0){
                        foreach($dt->result() as $key => $data){
                ?>
                        <tr>
                            <td>
                                <input type="hidden" name="id[]" class="form-control" value="<?=$data->idttd?>">
                                <input type="text" name="nama[]" class="form-control" placeholder="Nama Penanda Tanggan" value="<?=$data->nama?>">
                            </td>
                            <td><input type="text" name="jabatan[]" class="form-control"  placeholder="Jabatan Penanda Tanggan" value="<?=$data->jabatan?>"></td>
                            <td>
                            <?php
                                if($key <= 0){
                            ?>
                                <button type="button" class="btn btn-default btn-sm" id='btn-add'><i class="fa fa-plus-circle"></i></button>
                                <button type="button" class="btn btn-danger btn-sm hide" id='btn-remove'><i class="fa fa-trash"></i></button>
                            <?php
                                }                            
                            ?>
                            </td>
                        </tr>
                <?php
                        }
                    }else{
                ?>
                <tr>
                    <td><input type="text" name="nama[]" class="form-control" placeholder="Nama Penanda Tanggan"></td>
                    <td><input type="text" name="jabatan[]" class="form-control"  placeholder="Jabatan Penanda Tanggan"></td>
                    <td>
                        <button type="button" class="btn btn-default btn-sm" id='btn-add'><i class="fa fa-plus-circle"></i></button>
                        <button type="button" class="btn btn-danger btn-sm hide" id='btn-remove'><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
                <?php     
                    }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                    </td>
                </tr>
            </tfoot>
        </table>
        </div>
    </form>
    </div>

  </div>

</section>

<!--<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/dataTables.buttons.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.flash.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jszip.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/pdfmake.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/vfs_fonts.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.html5.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.print.min.js")?>"></script>-->

<script type="text/javascript">  
  $(function () {
    $.ajaxSetup({
      data: {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      }
    });
    $(document).on("click","#btn-add",function(){
        var thisclone = $(this).parent().parent().clone(true);
        thisclone.find(".form-control").val("");
        thisclone.find("#btn-add").addClass("hide");
        thisclone.find("#btn-remove").removeClass("hide");
        thisclone.appendTo($(this).parent().parent().parent());
    });
    $(document).on("click","#btn-remove",function(){
        $(this).parent().parent().remove(); 
    });
  })  
</script>