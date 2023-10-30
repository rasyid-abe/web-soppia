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
    Penarikan / Entry Surat Placement
    <small>Data Penarikan Surat</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a>Konektifitas DS QIA</a></li>
    <li class="active">Penarikan Surat</li>
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
            <h3 class="box-title">Edit Penarikan / Entry Surat Placement</h3>
            <div class="box-tools pull-right">
              <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                      title="Kembali Ke Manage <?=$subtitlepage?>">
                <i class="fa fa-arrow-circle-left"></i> Back</a>
              <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                <i class="fa fa-refresh"></i> Refresh</button>
            </div>
          </div>

    <div class="box-body">
        <?php echo form_open_multipart($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->FId_Peserta);?>
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  
              
              <div class="form-group col-sm-12">
                <label class="col-sm-2 control-label">Nama Peserta</label>
                <div class="col-sm-10">
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" value="<?=$dtdefault->NamaLengkap_TanpaGelar?>" readonly>
                </div>
                </div>
              </div> 

              <div class="form-group col-sm-12">
                <label class="col-sm-2 control-label">Nomor Surat Placement</label>
                <div class="col-sm-10">
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-folder"></i>
                  </div>
                  <input type="text" class="form-control" placeholder="Nomor Surat" name="No_Surat_Placement" id="No_Surat_Placement" value="<?=$dtdefault->No_Surat_Placement?>" required>
                </div>
                </div>
              </div> 
              
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Tanggal Surat Placement</label>
                </div>
                <div class="col-sm-10">
                    <input type="date" class="form-control" name="Tgl_SuratPlacement" placeholder="Tanggal Surat Placement" id="Tgl_SuratPlacement" value="<?=$dtdefault->Tgl_SuratPlacement?>" required>
                </div>
              </div> 

              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Ditempatkan Ditingkatan Kelas</label>
                </div>
                <div class="col-sm-10">
                  <select name="Ditempatkan_diTingkatanKelas" class="form-control select2" style="width: 100%;">
                    <?php
                       $slc1 = ($dtdefault->Ditempatkan_diTingkatanKelas=="A")? 'selected':'';
                       $slc2 = ($dtdefault->Ditempatkan_diTingkatanKelas=="B")? 'selected':'';
                       $slc3 = ($dtdefault->Ditempatkan_diTingkatanKelas=="C")? 'selected':'';
                       $slc4 = ($dtdefault->Ditempatkan_diTingkatanKelas=="D")? 'selected':'';
                       $slc5 = ($dtdefault->Ditempatkan_diTingkatanKelas=="E")? 'selected':'';
                       $slc6 = ($dtdefault->Ditempatkan_diTingkatanKelas=="AA")? 'selected':'';
                       $slc7 = ($dtdefault->Ditempatkan_diTingkatanKelas=="BB")? 'selected':'';
                       $slc8 = ($dtdefault->Ditempatkan_diTingkatanKelas=="CC")? 'selected':'';
                       $slc9 = ($dtdefault->Ditempatkan_diTingkatanKelas==null)? 'selected':'';
                    ?>
                    <option value=""<?=$slc9?>>Pilih</option>  
                    <option value="A"<?=$slc1?>>Dasar 1</option>                
                    <option value="B"<?=$slc2?>>Dasar 2</option>                
                    <option value="C"<?=$slc3?>>Lanjutan 1</option>                
                    <option value="D"<?=$slc4?>>Lanjutan 2</option>                
                    <option value="E"<?=$slc5?>>Manajerial</option>                
                    <option value="AA"<?=$slc6?>>DASAR</option>                
                    <option value="BB"<?=$slc7?>>LANJUTAN</option>                
                    <option value="CC"<?=$slc8?>>MANAJERIAL</option>               
                  </select>
                </div>
              </div>

            <div class="tamp">
                
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Syarat Placement</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control syaratp" placeholder="Syarat Placement" name="Syarat_Placement[]" id="Syarat_Placement_1" value="<?=$dtdefault->Syarat_Placement_1?>" >
                </div>
                <div class="col-sm-2">
                    <button type="button" id="add-syarat" class="btn btn-xs" title="Tambah"><i class="fa fa-plus"></i></button>
                    <button type="button" id="remove-syarat" class="btn btn-xs btn-danger hide" title="Hapus"><i class="fa fa-trash"></i></button>
                </div>
              </div>
            
              <?php
                if($dtdefault->Syarat_Placement_2 != null){ ?>
                
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Syarat Placement</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control syaratp" placeholder="Syarat Placement 2" name="Syarat_Placement[]" id="Syarat_Placement_2" value="<?=$dtdefault->Syarat_Placement_2?>" >
                </div>
                <div class="col-sm-2">
                    <button type="button" id="remove-syarat" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                </div>
              </div>
              <?php } ?>

              <?php
                if($dtdefault->Syarat_Placement_3 != null){ ?>
                
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Syarat Placement</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control syaratp" placeholder="Syarat Placement 3" name="Syarat_Placement[]" id="Syarat_Placement_3" value="<?=$dtdefault->Syarat_Placement_3?>" >
                </div>
                <div class="col-sm-2">
                    <button type="button" id="remove-syarat" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                </div>
              </div>
              <?php } ?>

              <?php
                if($dtdefault->Syarat_Placement_4 != null){ ?>
                
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Syarat Placement</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control syaratp" placeholder="Syarat Placement 4" name="Syarat_Placement[]" id="Syarat_Placement_4" value="<?=$dtdefault->Syarat_Placement_4?>" >
                </div>
                <div class="col-sm-2">
                    <button type="button" id="remove-syarat" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                </div>
              </div>
              <?php } ?>

              <?php
                if($dtdefault->Syarat_Placement_5 != null){ ?>
                
              <div class="form-group col-sm-12">
                <div class="col-sm-2">
                  <label>Syarat Placement</label>
                </div>
                <div class="col-sm-8">
                  <input type="text" class="form-control syaratp" placeholder="Syarat Placement 5" name="Syarat_Placement[]" id="Syarat_Placement_5" value="<?=$dtdefault->Syarat_Placement_5?>" >
                </div>
                <div class="col-sm-2">
                    <button type="button" id="remove-syarat" class="btn btn-xs btn-danger" title="Hapus"><i class="fa fa-trash"></i></button>
                </div>
              </div>
              <?php } ?>
            </div> <!--tamp-->
            
              <div class="form-group col-sm-12">
                <label class="col-sm-2 control-label">File Surat Placement</label>
                <div class="col-sm-10">
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-folder"></i>
                  </div>
                  <input type="file" class="form-control" placeholder="File Surat Placement" name="Path_SuratPlacement[]" id="Path_SuratPlacement" multiple="multiple">
                </div>
                <p class="pull-left" style="color:grey">File berupa: .jpg .pdf .doc .xls .txt (Max: 3 Mb)</p> <br>
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    <?php
                      if($dtdefault->Path_SuratPlacement != null){
                        $data = $dtdefault->Path_SuratPlacement;
                        if(file_exists("./uploads/fileapps/dsqia/".$data)){
                          echo '<p> <a href="'.base_url("./uploads/fileapps/dsqia/".$data).'" download > <i class="fa fa-download"></i> download file</a> <button type="button" data="'.$data.'" class="btn btn-danger btn-xs" id="delete-file-placement"> <i class="fa fa-trash"></i> </button> </p> ';
                        }else{
                          $data = explode(',',$data);
                          $rs = '';
                          foreach ($data as $key => $value) {
                            $dt = $this->db->where(array('idmeta'=>$value,'sourcefile'=>'penarikan_placement'))->get('meta_file_new')->row();
                            $rs .= '<p> <a href="'.base_url("./uploads/fileapps/dsqia/".$dt->namefile).'" download > <i class="fa fa-download"></i> download file '.($dt->namefile).'</a> <button type="button" data="'.$value.'" class="btn btn-danger btn-xs" id="delete-file-placement"> <i class="fa fa-trash"></i> </button> </p>';
                          }
                          echo $rs;
                        }
                      }else{
                        echo '<code>N/A</code>';
                      }
                    ?>
                    <br>
                  </div>
                </div>
              </div>

              <div class="box-body">
                <?php //echo form_open_multipart($this->uri->segment(1).'/'.$this->uri->segment(2)."/store");?>
                <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  

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
            </div> <!-- box-warning -->
          </div> <!-- col -->
       </div> <!-- row -->                     
    </div>
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();

    $('.date').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight:true,
    });
    
    $(document).on("click","#add-syarat",function(){
      var counting  =  $(".tamp").children().length;

      if(counting == 5 ){

      }else{
        var div = $(".tamp").children(); 
        var clonedt = $(this).parent().parent().clone(true);
        clonedt.find("#remove-syarat").removeClass("hide");
        clonedt.find("#add-syarat").addClass("hide");
        clonedt.find(".syaratp").val('');
        clonedt.appendTo('.tamp');
      }
    });
    
    $(document).on("click","#remove-syarat",function(){
        $(this).parent().parent().remove();
    });

    $(document).on("click",'#delete-file-placement',function(){
        var _data = $(this).attr("data");
        var self = $(this);
        $.getJSON('<?=base_url("konektifitas-ds-qia/Penarikan_surat/getjson")?>',{ data : _data,peserta:'<?=$dtdefault->FId_Peserta?>'},function(data){
          if(data.status == true){
            self.next().remove();
            self.prev().remove();
            self.remove();
          }
        });
    });

    
  });
</script>