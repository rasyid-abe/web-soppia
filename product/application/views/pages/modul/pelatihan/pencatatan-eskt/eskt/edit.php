<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<style>
    label{
        color:#00008B;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$titlepage?>
    <small><?=$subtitlepage?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a ><?=$breadcrumb2?></a></li>
    <li class="active"><?=$breadcrumb3?></li>
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

  <div class="row ">
      <div class="col-md-12"> 
        <div class="box box-warning">
          <div class="box-header with-border">
            <h3 class="box-title"><?=$titlebox?></h3>
            <div class="box-tools pull-right">
              <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                      title="Kembali Ke Manage <?=$subtitlepage?>">
                <i class="fa fa-arrow-circle-left"></i> Back</a>
              <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                <i class="fa fa-refresh"></i> Refresh</button>
            </div>
          </div>

        <div class="box-body">
          <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->Id_Saran_Komplain)?>" method="POST">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  
            
            <?php
                $saran = "";
                $komplain = "";
                $tl1 = "";
                $tl2 = "";
                
                if($dtdefault->Isi_Saran==null) {
                    $saran = "-";
                } else $saran = $dtdefault->Isi_Saran;
                
                if($dtdefault->Isi_Komplain==null) {
                    $komplain = "-";
                } else $komplain = $dtdefault->Isi_Komplain;
                
                if($dtdefault->Isi_TL_yg_sudah_dilakukan==null) {
                    $tl1 = "Belum Ada Tindak Lanjut";
                } else $tl1 = $dtdefault->Isi_TL_yg_sudah_dilakukan;
                
                if($dtdefault->Isi_TL_yg_akan_dilakukan==null) {
                    $tl2 = "Belum Ada Tindak Lanjut";
                } else $tl2 = $dtdefault->Isi_TL_yg_akan_dilakukan;
            ?>

            <?php if($dtdefault->FId_Peserta != "") {?>
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Nama Peserta</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?=$dtdefault->NamaLengkap_DgnGelar?>" readonly >
                </div>
              </div>
            <?php } ?>
            
            <?php if($dtdefault->Nama_PemberiSaran != "") {?>  
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Nama Pemberi Saran</label>
                </div>
                <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?=$dtdefault->Nama_PemberiSaran?>" readonly >
                </div>
              </div>
            <?php } ?>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Isi Saran</label>
                </div>
                <div class="col-sm-10">
                  <textarea class="form-control" name="Isi_Saran" id="Isi_Saran" placeholder="Isi Saran" ><?=$saran?></textarea>
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Isi Komplain</label>
                </div>
                <div class="col-sm-10">
                  <textarea class="form-control" name="Isi_Komplain" id="Isi_Komplain" placeholder="Isi Komplain" ><?=$komplain?></textarea>
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Isi Tindak Lanjut (Yang sudah dilakukan)</label>
                </div>
                <div class="col-sm-10">
                  <textarea class="form-control" name="Isi_TL_yg_sudah_dilakukan" id="Isi_TL_yg_sudah_dilakukan" placeholder="Isi Tindak Lanjut (Yang sudah dilakukan)" ><?=$tl1?></textarea>
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Isi Tindak Lanjut (Yang akan dilakukan)</label>
                </div>
                <div class="col-sm-10">
                  <textarea class="form-control" name="Isi_TL_yg_akan_dilakukan" id="Isi_TL_yg_akan_dilakukan" placeholder="Isi Tindak Lanjut (Yang akan dilakukan)" ><?=$tl2?></textarea>
                </div>
              </div>

              <div class="box-body">
                <?php echo form_open_multipart($this->uri->segment(1).'/'.$this->uri->segment(2)."/store");?>
                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  

                <div class="form-group col-sm-12">
                  <hr style="margin-bottom:0;margin-top:0" />
                </div>

                <div class="form-group col-sm-12"> 
                  <div class="col-sm-3 pull-right">
                    <button type="submit" title="Simpan Data" class="btn btn-block btn-flat btn-success">Update</button>
                  </div>
                  <div class="col-sm-3 pull-right">
                    <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" title="Kembali" class="btn btn-danger btn-block btn-flat">Back</a>
                  </div>
                </div>

              </div><!-- /.box-body -->
            </div> <!-- box-warning -->
          </div> <!-- col -->
       </div> <!-- row -->                     
    </div>
</section>

<script type="text/javascript">  
  $(function () {
    $('.select2').select2()
  })
</script>