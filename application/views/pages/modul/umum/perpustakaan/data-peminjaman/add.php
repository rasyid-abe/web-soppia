<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<style>
    label{
         color:#00008B
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
        <div class="box box-danger">
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
            <?php echo form_open_multipart($this->uri->segment(1).'/'.$this->uri->segment(2)."/store");?>
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  
           
            <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Nama Anggota</label>
                </div>
                <div class="col-sm-10">
                  <select name="id_anggota" class="form-control select2" style="width: 100%;" required>
                    <option value="" readonly disabled selected>Pilih Anggota</option>
                    <?php
                    foreach ($id_anggota->result() as $data) {
                      $slc = ($this->session->flashdata('oldinput')['id_anggota']==$data->id_anggota)? 'selected':'';
                    ?>
                    <option value="<?=$data->id_anggota?>" <?=$slc?> ><?=$data->nama_anggota?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Judul Buku</label>
                </div>
                <div class="col-sm-10">
                  <select name="id_buku" class="form-control select2" style="width: 100%;" required>
                    <option value="" readonly disabled selected>Pilih Buku</option>
                    <?php
                    foreach ($id_buku->result() as $data) {
                      $slc = ($this->session->flashdata('oldinput')['id_buku']==$data->id_buku)? 'selected':'';
                    ?>
                    <option value="<?=$data->id_buku?>" <?=$slc?> ><?=$data->judul_buku?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Jumlah Pinjam</label>
              <div class="col-sm-10">
                <input type="number" min="1" class="form-control" name="jml_pinjam" id="jml_pinjam" placeholder="Jumlah Pinjam Buku" value="<?=$this->session->flashdata('oldinput')['jml_pinjam']?>" required>
              </div>
            </div>
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Tanggal Pinjam</label>
              <div class="col-sm-10">
                <input type="date" class="form-control" name="tgl_pinjam" id="tgl_pinjam" placeholder="Tanggal Pinjam Buku" value="<?=date('Y-m-d')?>" readonly >
              </div>
            </div>
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Tanggal Kembali</label>
              <div class="col-sm-10">
                <input type="date" class="form-control" name="tgl_kembali" id="tgl_kembali" placeholder="Tanggal Kembali Buku" value="<?=$this->session->flashdata('oldinput')['tgl_kembali']?>" required>
              </div>
            </div>

            <div class="form-group col-sm-12">
              <hr style="margin-bottom:0;margin-top:0" />
            </div>

            <div class="form-group col-sm-12"> 
              <div class="col-sm-3 pull-right">
                <button type="submit" title="Simpan Data" class="btn btn-block btn-flat btn-success">Save</button>
              </div>
              <div class="col-sm-3 pull-right">
                <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" title="Kembali" class="btn btn-danger btn-block btn-flat">Back</a>
              </div>
            </div>

          </div><!-- /.box-body -->
        </div> <!-- box-success -->
      </div> <!-- col -->
    </div> <!-- row -->
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
  });
</script>