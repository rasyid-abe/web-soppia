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
     
       <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/store")?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" /> 

          <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           ID Pegawai
            <br/>
            <select class="form-control" name="id_pegawai" id="holdinggroup">
              <option value="" selected >Pilih ID Pegawai </option>
            <?php
                foreach($Fid_pegawai->result() as $data){
                    $slc = ($this->session->flashdata('oldinput')['Fid_pegawai']==$data->id_pegawai)? 'selected':'';
            ?>
              <option value="<?=$data->id_pegawai?>" <?=$slc?> ><?=$data->nik?> || <?=$data->nama_pegawai?></option>
              <?php
                }
              ?>
            </select>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Nama Pegawai
            <br/>
            <input type="text" class="form-control" id="pegawai" placeholder="Nama Pegawai"  value=""  readonly>
          </div>
        </div>

        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
          Tanggal Mulai Pembinaan
            <br/>
            <input type="date" class="form-control" name="tgl_awal" id="tgl_awal" placeholder="Tanggal Mulai Pembinaan"  value=""  required>
          </div>
        </div>
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
          Tanggal Akhir Pembinaan
            <br/>
            <input type="date" class="form-control" name="tgl_akhir" id="tgl_akhir" placeholder="Tanggal Akhir Pembinaan"  value=""  required>
          </div>
        </div>


        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Penanggung Jawab
            <br/>
            <input type="text" class="form-control" name="penanggung_jawab" id="penanggung_jawab" placeholder="Penggung Jawab Pembinaan"  value="" >
          </div>
        </div>
        
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
            No HP Penanggung Jawab 
            <br/>
            <input type="text" class="form-control" name="hp_kontak_person" id="hp_kontak_person" placeholder="HP Kontak Person"  value="" >
          </div>
        </div>
        
      
        <div class="form-group col-sm-12">
          <div class="col-sm-6" style="color:#00008B">
           Keterangan
            <br/>
            <textarea rows="5" cols="77px" name="keterangan" value="keterangan"> </textarea>
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
      $.ajaxSetup({
      data: {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      }
    });
    $('#holdinggroup').change(function(){
        $.ajax({
            type:'POST',
            url:'<?=base_url('kepegawaian/pembinaan-pegawai/datapegawai')?>',
            data:{nik:$('#holdinggroup').val()},
            datatype:'application/json',
            success:function (data){
             data = JSON.parse(data);
             if(data.status == true){
                $("#pegawai").val(data.nama);
             }else{
                $("#pegawai").val('');
             }
            
            }
        }); 
        
    });
  });
  
</script>