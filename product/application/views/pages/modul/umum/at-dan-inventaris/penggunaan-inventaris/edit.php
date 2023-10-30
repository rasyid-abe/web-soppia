<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
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
    <br>
    <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
  <?php }else if($this->session->flashdata('success')){ ?>
    <br>
    <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
  <?php } ?>

  <!-- Default box -->
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

        <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2).'/update/'.$dtdefault->Id_TransEksploit_ATnInven_t)?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  

         <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
          No AT dan Inventaris
            <br/>
            <select class="form-control select2" name="no_at_n_invetaris" id="no_at_n_invetaris" required>
              <option value="" selected> Pilih No AT dan Inventaris </option>
              <?php
                foreach($at_inv->result() as $atinv){
                    $slc = ($atinv->Id_AT_n_Invent == $dtdefault->FId_ATnInvent)? 'selected':'';
                ?>
                  <option value="<?=$atinv->Id_AT_n_Invent?>" <?=$slc?> ><?=$atinv->no_at_inv?> <?=($atinv->Desc_AT_n_Invent != null || $atinv->Desc_AT_n_Invent != '')? ' | '.$atinv->Desc_AT_n_Invent:''; ?></option>
                <?php
                }
              ?>
              
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
            Deskripsi Penggunaan 
            <br/>
            <textarea class="form-control" name="desc_transaksi" id="desc_transaksi" placeholder="Deskripsi Penggunaan" ><?=$dtdefault->Desc_Transaksi?></textarea>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Penanggung Jawab 
            <br/>
            <input type="text" class="form-control" name="penggung_jawab" id="penggung_jawab" placeholder="Penanggung Jawab" value="<?=$dtdefault->PenanggungJwb?>"  >
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
          Tanggal Peminjaman
            <br/>
            <input type="date" class="form-control" name="tgl_pinjam" id="date" placeholder="Tanggal Pembelian" value="<?=$dtdefault->Tgl_TransaksiAwal?>"  >
          </div>
        </div>


        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Tanggal Kembali
            <br/>
            <input type="date" class="form-control" name="tgl_kembali" id="date" placeholder="Tanggal Kembali" value="<?=$dtdefault->Tgl_TransaksiAkhir?>" >
          </div>
        </div>
   
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Keterangan
            <br/>
            <textarea rows="5" cols="77px" name="keterangan" id="keterangan"><?=$dtdefault->Keterangan?></textarea>
          </div>
        </div>
   

        <div class="form-group col-sm-12">
          <hr style="margin-bottom:0;margin-top:0" />
        </div>

        <div class="form-group col-sm-12"> 
          <div class="col-sm-2">
            <button type="submit" class="btn btn-block btn-flat">Update</button>
          </div>
          <div class="col-sm-2">
            <a href="" class="btn btn-danger btn-block btn-flat">Back</a>
          </div>
        </div>

      </form>

    </div>

  </div>

</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
  });
</script>