<style>
    label {
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
        <div class="box box-success">
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
                  <label>Nama Pegawai</label>
                </div>
                <div class="col-sm-10">
                  <select name="id_pegawai" class="form-control select2" style="width: 100%;">
                    <option value="" readonly disabled selected>Pilih Pegawai</option>
                    <?php
                    foreach ($pegawai->result() as $data) {
                      $slc = ($this->session->flashdata('oldinput')['id_pegawai']==$data->id_pegawai)? 'selected':'';
                    ?>
                    <option value="<?=$data->id_pegawai?>" <?=$slc?> ><?=$data->nama_pegawai?></option>
                    <?php
                    }
                    ?>
                  </select>
                </div>
              </div>
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Nomor BPJS</label>
              <div class="col-sm-10">
                <input type="number" min="0" class="form-control" name="no_bpjs" placeholder="Nomor BPJS" value="<?=$this->session->flashdata('oldinput')['no_bpjs']?>" >
              </div>
            </div>
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Nomor KK</label>
              <div class="col-sm-10">
                <input type="number" min="0" class="form-control" name="nomor_kk" placeholder="Nomor Kartu Keluarga" value="<?=$this->session->flashdata('oldinput')['nomor_kk']?>" >
              </div>
            </div>
            
            <div class="form-group col-sm-12">
              <label class="col-sm-2 control-label">Keterangan</label>
              <div class="col-sm-10">
                <textarea class="form-control" name="keterangan" placeholder="Keterangan Lembur"><?=$this->session->flashdata('oldinput')['keterangan']?></textarea>
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
