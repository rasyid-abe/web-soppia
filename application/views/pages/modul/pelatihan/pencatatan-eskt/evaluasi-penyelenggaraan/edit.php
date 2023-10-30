<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")?>">
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

  <div class="row">
    <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->FId_InstrukturNgajar_diKelas)?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    
    
    <div class="col-sm-6">
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title"><?=$titlebox?></h3>
        </div>
        <div class="box-body">
            <div class="form-group col-sm-12">
              <div class="col-sm-4">
                <label>Nama Instruktur</label>
              </div>
              <div class="col-sm-8">
                <select name="FId_InstrukturNgajar_diKelas" class="form-control select2" style="width: 100%;">
                  <option value="" readonly disabled selected>Pilih Instruktur</option>
                  <?php
                  foreach ($FId_Instruktur->result() as $data) {
                    $slc = ($dtdefault->FId_InstrukturNgajar_diKelas==$data->Id_Instruktur)? 'selected':'';
                  ?>
                  <option value="<?=$data->Id_Instruktur?>" <?=$slc?> ><?=$data->NamaLengkap_DgnGelar?></option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>  

            <div class="form-group col-sm-12">
              <div class="col-sm-4">
                <label>Nama Peserta</label>
              </div>
              <div class="col-sm-8">
                <select name="FId_Peserta" class="form-control select2" style="width: 100%;">
                  <option value="" readonly disabled selected>Pilih Peserta</option>
                  <?php
                  foreach ($FId_Peserta->result() as $data) {
                    $slc = ($dtdefault->FId_Peserta==$data->Id_Peserta)? 'selected':'';
                  ?>
                  <option value="<?=$data->Id_Peserta?>" <?=$slc?> >Nama : <?=$data->NamaLengkap_TanpaGelar?> | NIK :  <?=$data->NIK?> | NIPP : <?=$data->NIPP?> </option>
                  <?php
                  }
                  ?>
                </select>
              </div>
            </div>     

            <div class="form-group col-sm-12">
              <div class="col-sm-4">
                <label>Jawaban Eval 1</label>
              </div>
              <div class="col-sm-8">
                <select name="Jwb_Eval[]" class="form-control select2" id="Jwb_Eval1" style="width: 100%;">
                  <option value="" readonly selected>Pilih Jawaban Eval 1</option>
                  <?php
                    $slc1 = ($dtdefault->Jwb_Eval1 == "T")? 'selected':'';
                    $slc2 = ($dtdefault->Jwb_Eval1 == "Y")? 'selected':'';
                    $slc3 = ($dtdefault->Jwb_Eval1 == "S")? 'selected':'';
                  ?>
                  <option value="T" <?=$slc1?> >Tidak</option>
                  <option value="Y" <?=$slc2?> >Ya</option>
                  <option value="S" <?=$slc3?> >Sangat Sesuai</option>
                </select>
              </div>
            </div> 

            <div class="form-group col-sm-12">
              <div class="col-sm-4">
                <label>Jawaban Eval 2</label>
              </div>
              <div class="col-sm-8">
                <select name="Jwb_Eval[]" class="form-control select2" id="Jwb_Eval2" style="width: 100%;">
                  <option value="" readonly selected>Pilih Jawaban Eval 2</option>

                  <?php
                    $slc1a = ($dtdefault->Jwb_Eval2 == "T")? 'selected':'';
                    $slc2a = ($dtdefault->Jwb_Eval2 == "S")? 'selected':'';
                  ?>
                  <option value="T"  <?=$slc1a?> >Terlalu Banyak Kuliah</option>
                  <option value="S"  <?=$slc2a?> >Seimbang</option>
                </select>
              </div>
            </div> 

            <div class="form-group col-sm-12">
              <div class="col-sm-4">
                <label>Saran Eval</label>
              </div>
              <div class="col-sm-8">
                <textarea class="form-control" name="Saran_Eval" id="Saran_Eval" placeholder="Saran Eval"><?=$dtdefault->Saran_Eval?></textarea>  
              </div>
            </div>   
        </div> <!-- box-body -->
      </div> <!-- box -->
    </div> <!-- col -->

    <div class="col-sm-6"> 
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Jawaban Evaluasi</h3>
          <div class="box-tools pull-right">
            <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                    title="Kembali Ke Manage <?=$subtitlepage?>">
              <i class="fa fa-arrow-circle-left"></i> Back</a>
            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
              <i class="fa fa-refresh"></i></button>
          </div>
        </div>
        <div class="box-body">
          <div class="box-body tamp-eval">
            <div class="form-group col-sm-12">
                <div class="col-sm-10">
                  <select name="Jwb_Eval[]" class="form-control select2" id="Jwb_Eval" style="width: 100%;">
                    <option value="" readonly selected>Pilih Jawaban Eval</option>
                    <option value="5" <?=($dtdefault->Jwb_Eval3 == "5")? 'selected' :'';?> >Sangat Baik</option>
                    <option value="4" <?=($dtdefault->Jwb_Eval3 == "4")? 'selected' :'';?> >Baik</option>
                    <option value="3" <?=($dtdefault->Jwb_Eval3 == "3")? 'selected' :'';?> >Cukup</option>
                    <option value="2" <?=($dtdefault->Jwb_Eval3 == "2")? 'selected' :'';?> >Kurang</option>
                    <option value="1" <?=($dtdefault->Jwb_Eval3 == "1")? 'selected' :'';?> >Kurang Sekali</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  
                </div>
              </div> 
            <div class="form-group col-sm-12">
                <div class="col-sm-10">
                  <select name="Jwb_Eval[]" class="form-control select2" id="Jwb_Eval" style="width: 100%;">
                    <option value="" readonly selected>Pilih Jawaban Eval</option>
                    <option value="5" <?=($dtdefault->Jwb_Eval4 == "5")? 'selected' :'';?> >Sangat Baik</option>
                    <option value="4" <?=($dtdefault->Jwb_Eval4 == "4")? 'selected' :'';?> >Baik</option>
                    <option value="3" <?=($dtdefault->Jwb_Eval4 == "3")? 'selected' :'';?> >Cukup</option>
                    <option value="2" <?=($dtdefault->Jwb_Eval4 == "2")? 'selected' :'';?> >Kurang</option>
                    <option value="1" <?=($dtdefault->Jwb_Eval4 == "1")? 'selected' :'';?> >Kurang Sekali</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  
                </div>
              </div> 
            <div class="form-group col-sm-12">
                <div class="col-sm-10">
                  <select name="Jwb_Eval[]" class="form-control select2" id="Jwb_Eval" style="width: 100%;">
                    <option value="" readonly selected>Pilih Jawaban Eval</option>
                    <option value="5" <?=($dtdefault->Jwb_Eval5 == "5")? 'selected' :'';?> >Sangat Baik</option>
                    <option value="4" <?=($dtdefault->Jwb_Eval5 == "4")? 'selected' :'';?> >Baik</option>
                    <option value="3" <?=($dtdefault->Jwb_Eval5 == "3")? 'selected' :'';?> >Cukup</option>
                    <option value="2" <?=($dtdefault->Jwb_Eval5 == "2")? 'selected' :'';?> >Kurang</option>
                    <option value="1" <?=($dtdefault->Jwb_Eval5 == "1")? 'selected' :'';?> >Kurang Sekali</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  
                </div>
              </div>  
              <div class="form-group col-sm-12">
                <div class="col-sm-10">
                  <select name="Jwb_Eval[]" class="form-control select2" id="Jwb_Eval" style="width: 100%;">
                    <option value="" readonly selected>Pilih Jawaban Eval</option>
                    <option value="5" <?=($dtdefault->Jwb_Eval6 == "5")? 'selected' :'';?> >Sangat Baik</option>
                    <option value="4" <?=($dtdefault->Jwb_Eval6 == "4")? 'selected' :'';?> >Baik</option>
                    <option value="3" <?=($dtdefault->Jwb_Eval6 == "3")? 'selected' :'';?> >Cukup</option>
                    <option value="2" <?=($dtdefault->Jwb_Eval6 == "2")? 'selected' :'';?> >Kurang</option>
                    <option value="1" <?=($dtdefault->Jwb_Eval6 == "1")? 'selected' :'';?> >Kurang Sekali</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  
                </div>
              </div>  
              <div class="form-group col-sm-12">
                <div class="col-sm-10">
                  <select name="Jwb_Eval[]" class="form-control select2" id="Jwb_Eval" style="width: 100%;">
                    <option value="" readonly selected>Pilih Jawaban Eval</option>
                    <option value="5" <?=($dtdefault->Jwb_Eval7 == "5")? 'selected' :'';?> >Sangat Baik</option>
                    <option value="4" <?=($dtdefault->Jwb_Eval7 == "4")? 'selected' :'';?> >Baik</option>
                    <option value="3" <?=($dtdefault->Jwb_Eval7 == "3")? 'selected' :'';?> >Cukup</option>
                    <option value="2" <?=($dtdefault->Jwb_Eval7 == "2")? 'selected' :'';?> >Kurang</option>
                    <option value="1" <?=($dtdefault->Jwb_Eval7 == "1")? 'selected' :'';?> >Kurang Sekali</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  
                </div>                
              </div>
              <div class="form-group col-sm-12">
                <div class="col-sm-10">
                  <select name="Jwb_Eval[]" class="form-control select2" id="Jwb_Eval" style="width: 100%;">
                    <option value="" readonly selected>Pilih Jawaban Eval</option>
                    <option value="5" <?=($dtdefault->Jwb_Eval8 == "5")? 'selected' :'';?> >Sangat Baik</option>
                    <option value="4" <?=($dtdefault->Jwb_Eval8 == "4")? 'selected' :'';?> >Baik</option>
                    <option value="3" <?=($dtdefault->Jwb_Eval8 == "3")? 'selected' :'';?> >Cukup</option>
                    <option value="2" <?=($dtdefault->Jwb_Eval8 == "2")? 'selected' :'';?> >Kurang</option>
                    <option value="1" <?=($dtdefault->Jwb_Eval8 == "1")? 'selected' :'';?> >Kurang Sekali</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  
                </div>                
              </div>
              <div class="form-group col-sm-12">
                <div class="col-sm-10">
                  <select name="Jwb_Eval[]" class="form-control select2" id="Jwb_Eval" style="width: 100%;">
                    <option value="" readonly selected>Pilih Jawaban Eval</option>
                    <option value="5" <?=($dtdefault->Jwb_Eval9 == "5")? 'selected' :'';?> >Sangat Baik</option>
                    <option value="4" <?=($dtdefault->Jwb_Eval9 == "4")? 'selected' :'';?> >Baik</option>
                    <option value="3" <?=($dtdefault->Jwb_Eval9 == "3")? 'selected' :'';?> >Cukup</option>
                    <option value="2" <?=($dtdefault->Jwb_Eval9 == "2")? 'selected' :'';?> >Kurang</option>
                    <option value="1" <?=($dtdefault->Jwb_Eval9 == "1")? 'selected' :'';?> >Kurang Sekali</option>
                  </select>
                </div>
                <div class="col-sm-2">
                  
                </div>                
              </div>

            <div class="col-sm-12"> 
              <div class="box">
                <div class="box-body"> 
                  <div class="form-group col-sm-12"> 
                    <div class="col-sm-4 pull-right">
                      <button type="submit" class="btn btn-block btn-flat btn-success">Save</button>
                    </div>
                    <div class="col-sm-4 pull-right">
                      <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-danger btn-block btn-flat">Back</a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
         
        </div> <!-- box-body -->
      </div> <!-- box -->
    </div> <!-- col -->

    </form>
  </div>
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
  
  $(document).on("click","#add-eval",function(){
      var counting  =  $(".tamp-eval").children().length;

      if(counting == 7 ){

      }else{
        var div = $(".tamp-eval").children(); 
        div.find(".select2").each(function(index){
            if ($(this).data('select2')) {
              $(this).select2('destroy');
            } 
        });
        var clonedt = $(this).parent().parent().clone(true);
        clonedt.find(".select").val();
        clonedt.find("#remove-eval").removeClass("hide");
        clonedt.find("#add-eval").addClass("hide");
        clonedt.appendTo('.tamp-eval');
        $('.select2').select2(); 
      }
    });
  $(document).on("click","#remove-eval",function(){
      $(this).parent().parent().remove();
    });
  });
</script>