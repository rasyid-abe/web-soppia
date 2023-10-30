
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
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$titlebox?></h3>

      <div class="box-tools pull-right">
        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                title="Kembali Ke Manage <?=$subtitlepage?>">
          <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
    <div class="box-body">
      <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/store")?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />        
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Nama Holding Group<br/>
            <input type="text" class="form-control" name="name" id="name" placeholder="Name"  value="<?=$this->session->flashdata('oldinput')['name']?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Alamat Kantor<br/>
            <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat Kantor"  value="<?=$this->session->flashdata('oldinput')['alamat']?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Telp<br/>
            <input type="text" class="form-control" name="telp" id="telp" placeholder="Telp"  value="<?=$this->session->flashdata('oldinput')['telp']?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Fax<br/>
            <input type="text" class="form-control" name="fax" id="fax" placeholder="Fax"  value="<?=$this->session->flashdata('oldinput')['fax']?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Email<br/>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email"  value="<?=$this->session->flashdata('oldinput')['email']?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Kontrak Person<br/>
            <input type="text" class="form-control" name="kontak_person" id="kontak_person" placeholder="Kontak Person"  value="<?=$this->session->flashdata('oldinput')['kontak_person']?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            No Hp Person<br/>
            <input type="text" class="form-control" name="hp_kontak_person" id="hp_kontak_person" placeholder="HP Kontak Person"  value="<?=$this->session->flashdata('oldinput')['hp_kontak_person']?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Kode Singkat<br/>
            <input type="text" class="form-control" name="kode_singkat" id="kode_singkat" placeholder="Kode Singkat"  value="<?=$this->session->flashdata('oldinput')['kode_singkat']?>" >
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6">
            Keterangan Holding Group<br/>
            <textarea class="form-control" name="keterangan" id="keterangan"><?=$this->session->flashdata('oldinput')['keterangan']?></textarea>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <hr style="margin-bottom:0;margin-top:0" />
        </div>

        <div class="form-group col-sm-12"> 
          <div class="col-sm-2">
            <button type="submit" class="btn btn-block btn-flat">Save</button>
          </div>
          <div class="col-sm-2">
            <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-danger btn-block btn-flat">Back</a>
          </div>
        </div>

      </form>
    </div>

  </div>

</section>

<script type="text/javascript">  
  $(function () {
  });
</script>