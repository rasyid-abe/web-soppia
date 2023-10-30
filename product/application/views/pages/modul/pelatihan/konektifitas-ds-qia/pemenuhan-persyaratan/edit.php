<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/plugins/iCheck/all.css")?>">
<style>
    label{
        color:#00008B;
    }
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$titlepage?> Placement
    <small><?=$subtitlepage?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a >Konektifitas DS QIA</a></li>
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
            <h3 class="box-title"><?=$titlebox?> Placement</h3>
            <div class="box-tools pull-right">
              <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                      title="Kembali Ke Manage <?=$subtitlepage?>">
                <i class="fa fa-arrow-circle-left"></i> Back</a>
              <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                <i class="fa fa-refresh"></i> Refresh</button>
            </div>
          </div>

    <div class="box-body">
        <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->FId_Peserta)?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />  
        
              <div class="form-group col-sm-12">
                <label class="col-sm-2 control-label">NIPP Peserta</label>
                <div class="col-sm-10">
                  <div class="input-group">
                  <div class="input-group-addon">
                    <i class="fa fa-user"></i>
                  </div>
                  <input type="text" class="form-control" value="<?=$dtdefault->NIPP?>" readonly>
                </div>
                </div>
              </div>
              
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
              <?php 
                if($dtdefault->Syarat_Placement_1 == null){ ?>
              <div class="row">
                  <div class="col-md-12">
                      <div class="alert alert-warning alert-dismissible" align="center">
                        <b><i class="icon fa fa-warning"></i> Belum ada persyaratan dari DS-QIA</b>
                      </div>
                  </div>
              </div>
              <?php
                } elseif($dtdefault->Syarat_Placement_1 != null) {
              ?>
              <div class="row">
                  <div class="col-md-6">
                      <?php
                        if($dtdefault->Syarat_Placement_1 != null){ ?>  
                        
                      <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Pemenuhan Syarat 1</label>
                          <p style="color: grey"><?=$dtdefault->Syarat_Placement_1?></p>
                        </div>
                        <div class="col-sm-8">
                          <select name="Flag_Syarat_Placement1_Dipenuhi" class="form-control select2" style="width: 100%;">
                            <?php
                               $slc1 = ($dtdefault->Flag_Syarat_Placement1_Dipenuhi=="Y")? 'selected':'';
                               $slc2 = ($dtdefault->Flag_Syarat_Placement1_Dipenuhi=="N")? 'selected':'';
                               $slc4 = ($dtdefault->Flag_Syarat_Placement1_Dipenuhi==null)? 'selected':'';
                            ?>
                            <option value=""<?=$slc4?>>Pilih</option>               
                            <option value="N"<?=$slc2?>>Belum Dipenuhi</option>                
                            <option value="Y"<?=$slc1?>>Sudah Dipenuhi</option>           
                          </select>
                        </div>
                      </div>
                      <?php } ?>
                      
                      <?php
                        if($dtdefault->Syarat_Placement_2 != null){ ?>  
                        
                      <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Pemenuhan Syarat 2</label>
                          <p style="color: grey"><?=$dtdefault->Syarat_Placement_2?></p>
                        </div>
                        <div class="col-sm-8">
                          <select name="Flag_Syarat_Placement2_Dipenuhi" class="form-control select2" style="width: 100%;">
                            <?php
                               $slc1 = ($dtdefault->Flag_Syarat_Placement2_Dipenuhi=="Y")? 'selected':'';
                               $slc2 = ($dtdefault->Flag_Syarat_Placement2_Dipenuhi=="N")? 'selected':'';
                               $slc4 = ($dtdefault->Flag_Syarat_Placement2_Dipenuhi==null)? 'selected':'';
                            ?>
                            <option value=""<?=$slc4?>>Pilih</option>               
                            <option value="N"<?=$slc2?>>Belum Dipenuhi</option>                
                            <option value="Y"<?=$slc1?>>Sudah Dipenuhi</option>           
                          </select>
                        </div>
                      </div>
                      <?php } ?>
                      
                      <?php
                        if($dtdefault->Syarat_Placement_3 != null){ ?>  
                        
                      <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Pemenuhan Syarat 3</label>
                          <p style="color: grey"><?=$dtdefault->Syarat_Placement_3?></p>
                        </div>
                        <div class="col-sm-8">
                          <select name="Flag_Syarat_Placement3_Dipenuhi" class="form-control select2" style="width: 100%;">
                            <?php
                               $slc1 = ($dtdefault->Flag_Syarat_Placement3_Dipenuhi=="Y")? 'selected':'';
                               $slc2 = ($dtdefault->Flag_Syarat_Placement3_Dipenuhi=="N")? 'selected':'';
                               $slc4 = ($dtdefault->Flag_Syarat_Placement3_Dipenuhi==null)? 'selected':'';
                            ?>
                            <option value=""<?=$slc4?>>Pilih</option>               
                            <option value="N"<?=$slc2?>>Belum Dipenuhi</option>                
                            <option value="Y"<?=$slc1?>>Sudah Dipenuhi</option>           
                          </select>
                        </div>
                      </div>
                      <?php } ?>
                      
                      <?php
                        if($dtdefault->Syarat_Placement_4 != null){ ?>  
                        
                      <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Pemenuhan Syarat 4</label>
                          <p style="color: grey"><?=$dtdefault->Syarat_Placement_4?></p>
                        </div>
                        <div class="col-sm-8">
                          <select name="Flag_Syarat_Placement4_Dipenuhi" class="form-control select2" style="width: 100%;">
                            <?php
                               $slc1 = ($dtdefault->Flag_Syarat_Placement4_Dipenuhi=="Y")? 'selected':'';
                               $slc2 = ($dtdefault->Flag_Syarat_Placement4_Dipenuhi=="N")? 'selected':'';
                               $slc4 = ($dtdefault->Flag_Syarat_Placement4_Dipenuhi==null)? 'selected':'';
                            ?>
                            <option value=""<?=$slc4?>>Pilih</option>               
                            <option value="N"<?=$slc2?>>Belum Dipenuhi</option>                
                            <option value="Y"<?=$slc1?>>Sudah Dipenuhi</option>           
                          </select>
                        </div>
                      </div>
                      <?php } ?>
                      
                      <?php
                        if($dtdefault->Syarat_Placement_5 != null){ ?>  
                        
                      <div class="form-group col-sm-12">
                        <div class="col-sm-4">
                          <label>Pemenuhan Syarat 5</label>
                          <p style="color: grey"><?=$dtdefault->Syarat_Placement_5?></p>
                        </div>
                        <div class="col-sm-8">
                          <select name="Flag_Syarat_Placement5_Dipenuhi" class="form-control select2" style="width: 100%;">
                            <?php
                               $slc1 = ($dtdefault->Flag_Syarat_Placement5_Dipenuhi=="Y")? 'selected':'';
                               $slc2 = ($dtdefault->Flag_Syarat_Placement5_Dipenuhi=="N")? 'selected':'';
                               $slc4 = ($dtdefault->Flag_Syarat_Placement5_Dipenuhi==null)? 'selected':'';
                            ?>
                            <option value=""<?=$slc4?>>Pilih</option>               
                            <option value="N"<?=$slc2?>>Belum Dipenuhi</option>                
                            <option value="Y"<?=$slc1?>>Sudah Dipenuhi</option>           
                          </select>
                        </div>
                      </div>
                      <?php } ?>
                      
                 </div>
                 <div class="col-md-6">
                     <?php
                        if($dtdefault->Syarat_Placement_1 != ""){ ?>  
                        
                      <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">File Lampiran 1</label>
                        <div class="col-sm-8">
                          <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-folder"></i>
                          </div>
                            <input type="file" class="form-control" name="Path_LampPemenuhanSyarat1">
                        </div>
                        <p class="pull-right" style="color:grey">File berupa: .jpg .pdf .doc .xls .txt (Max: 3 Mb)</p>
                        </div>
                      </div> 
                      <?php } ?>
                      
                      <?php
                        if($dtdefault->Path_LampPemenuhanSyarat1 != "Belum Ada Data" and $dtdefault->Path_LampPemenuhanSyarat1 != ""){ ?>  
                        
                      <div class="form-group col-sm-12" style="margin-top:-15px;margin-bottom:30px">
                        <label class="col-sm-4 control-label"></label>
                        <div class="col-sm-8">
                          <div class="input-group pull-right">
                          <b>File Lampiran 1 Sebelumnya : </b>
                          <a href="<?=base_url('uploads/fileapps/dsqia/'.$dtdefault->Path_LampPemenuhanSyarat1)?>"> <i class="fa fa-download"></i> Download</a>
                        </div>
                        </div>
                      </div> 
                      <?php } ?>
                      
                      <?php
                        if($dtdefault->Syarat_Placement_2 != ""){ ?>  
                        
                     <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">File Lampiran 2</label>
                        <div class="col-sm-8">
                          <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-folder"></i>
                          </div>
                            <input type="file" class="form-control" name="Path_LampPemenuhanSyarat2">
                        </div>
                        <p class="pull-right" style="color:grey">File berupa: .jpg .pdf .doc .xls .txt (Max: 3 Mb)</p>
                        </div>
                      </div> 
                      <?php } ?>
                      
                      <?php
                        if($dtdefault->Path_LampPemenuhanSyarat2 != "Belum Ada Data" and $dtdefault->Path_LampPemenuhanSyarat2 != ""){ ?>  
                        
                      <div class="form-group col-sm-12" style="margin-top:-15px;margin-bottom:30px">
                        <label class="col-sm-4 control-label"></label>
                        <div class="col-sm-8">
                          <div class="input-group pull-right">
                          <b>File Lampiran 2 Sebelumnya : </b>
                          <a href="<?=base_url('uploads/fileapps/dsqia/'.$dtdefault->Path_LampPemenuhanSyarat2)?>"> <i class="fa fa-download"></i> Download</a>
                        </div>
                        </div>
                      </div> 
                      <?php } ?>
                      
                      <?php
                        if($dtdefault->Syarat_Placement_3 != ""){ ?>  
                        
                     <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">File Lampiran 3</label>
                        <div class="col-sm-8">
                          <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-folder"></i>
                          </div>
                          <input type="file" class="form-control" name="Path_LampPemenuhanSyarat3">
                        </div>
                        <p class="pull-right" style="color:grey">File berupa: .jpg .pdf .doc .xls .txt (Max: 3 Mb)</p>
                        </div>
                      </div> 
                      <?php } ?>
                      
                      <?php
                        if($dtdefault->Path_LampPemenuhanSyarat3 != "Belum Ada Data" and $dtdefault->Path_LampPemenuhanSyarat3 != ""){ ?>  
                        
                      <div class="form-group col-sm-12" style="margin-top:-15px;margin-bottom:30px">
                        <label class="col-sm-4 control-label"></label>
                        <div class="col-sm-8">
                          <div class="input-group pull-right">
                          <b>File Lampiran 3 Sebelumnya : </b>
                          <a href="<?=base_url('uploads/fileapps/dsqia/'.$dtdefault->Path_LampPemenuhanSyarat3)?>"> <i class="fa fa-download"></i> Download</a>
                        </div>
                        </div>
                      </div> 
                      <?php } ?>
                     
                     <?php
                        if($dtdefault->Syarat_Placement_4 != ""){ ?>  
                        
                     <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">File Lampiran 4</label>
                        <div class="col-sm-8">
                          <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-folder"></i>
                          </div>
                            <input type="file" class="form-control" name="Path_LampPemenuhanSyarat4">
                        </div>
                        <p class="pull-right" style="color:grey">File berupa: .jpg .pdf .doc .xls .txt (Max: 3 Mb)</p>
                        </div>
                     </div> 
                     <?php } ?>
                     
                     <?php
                        if($dtdefault->Path_LampPemenuhanSyarat4 != "Belum Ada Data" and $dtdefault->Path_LampPemenuhanSyarat4 != ""){ ?>  
                        
                      <div class="form-group col-sm-12" style="margin-top:-15px;margin-bottom:30px">
                        <label class="col-sm-4 control-label"></label>
                        <div class="col-sm-8">
                          <div class="input-group pull-right">
                          <b>File Lampiran 4 Sebelumnya : </b>
                          <a href="<?=base_url('uploads/fileapps/dsqia/'.$dtdefault->Path_LampPemenuhanSyarat4)?>"> <i class="fa fa-download"></i> Download</a>
                        </div>
                        </div>
                      </div> 
                      <?php } ?>
                     
                     <?php
                        if($dtdefault->Syarat_Placement_5 != ""){ ?>  
                        
                     <div class="form-group col-sm-12">
                        <label class="col-sm-4 control-label">File Lampiran 5</label>
                        <div class="col-sm-8">
                          <div class="input-group">
                          <div class="input-group-addon">
                            <i class="fa fa-folder"></i>
                          </div>
                            <input type="file" class="form-control" name="Path_LampPemenuhanSyarat5">
                        </div>
                        <p class="pull-right" style="color:grey">File berupa: .jpg .pdf .doc .xls .txt (Max: 3 Mb)</p>
                        </div>
                     </div> 
                     <?php } ?>
                     
                     <?php
                        if($dtdefault->Path_LampPemenuhanSyarat5 != "Belum Ada Data" and $dtdefault->Path_LampPemenuhanSyarat5 != ""){ ?>  
                        
                      <div class="form-group col-sm-12" style="margin-top:-15px;margin-bottom:30px">
                        <label class="col-sm-4 control-label"></label>
                        <div class="col-sm-8">
                          <div class="input-group pull-right">
                          <b>File Lampiran 5 Sebelumnya : </b>
                          <a href="<?=base_url('uploads/fileapps/dsqia/'.$dtdefault->Path_LampPemenuhanSyarat5)?>"> <i class="fa fa-download"></i> Download</a>
                        </div>
                        </div>
                      </div> 
                      <?php } ?>
                     
                 </div>
              </div>
              
              <div class="row">
                  <div class="form-group col-sm-12">
                      <div class="col-sm-12">
                        <!-- checkbox -->
                          <div class="form-group">
                            <label style="margin-left:17px">
                            <?php
                                $centang = "";
                                if($dtdefault->Flag_SebabTerkunci == "N"){ 
                                    $centang = "checked";
                                }
                            ?> 
                              <input type="checkbox" class="flat-red" name="terpenuhi" <?=$centang?>/>
                              Semua syarat sudah terpenuhi
                            </label>
                          </div>
                      </div> <!--col-5-->
                  </div> <!--col-12-->
              </div> <!--row-->
              <?php
                }
              ?>
                
              <div class="box-body">
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
              </form>
            </div> <!-- box-warning -->
          </div> <!-- col -->
       </div> <!-- row -->                     
    </div>
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/plugins/iCheck/icheck.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
    
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })
  });
  
</script>