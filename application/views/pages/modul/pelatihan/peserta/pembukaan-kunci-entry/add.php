<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")?>">
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
    <?php
      $cekfind = $this->db->where(array("Id_Peserta"=>$dtdefault->Id_Peserta))->get("mst_peserta_logbukakuncian");
    ?>
      <form action="<?=base_url('peserta/pembukaan-kunci-entry/save-buka-kuncian/'.$dtdefault->Id_Peserta)?>" method="POST">
      <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    
        
            <!--<div class="form-group col-sm-12">
              <div class="col-sm-4 text-right">
                Flag Daftar Kelas/ Daftar Data
              </div>  
              <div class="col-sm-6">
                <select name="flagdddk" class="form-control select2" id="flagdddk" style="width: 100%;">
                  <option value="" readonly selected>Pilih Daftar Kelas/Daftar Data</option>
                  <?php
                    if($cekfind->num_rows()>0){
                     $slc1 = ($cekfind->row()->Flag_DaftarData_or_DaftarKelas =="D")? 'selected':'';
                     $slc2 = ($cekfind->row()->Flag_DaftarData_or_DaftarKelas =="K")? 'selected':'';
                    }else{
                     $slc1 = ($dtdefault->Flag_SebabTerkunci =="D")? 'selected':'';
                     $slc2 = ($dtdefault->Flag_SebabTerkunci =="K")? 'selected':'';                      
                    }
                  ?>
                  <option value="D" <?=$slc1?> >Pendaftaran Data Calon Peserta</option>
                  <option value="K" <?=$slc2?> >Pendaftaran ke Kelas</option>
                </select>
              </div> 
            </div>--> 
            <input type="hidden" name="flagdddk" class="form-control " id="flagdddk" value="<?=$dtdefault->Flag_SebabTerkunci?>"  >

      <?php
      $sudah1 = '';
      if(accessperm('membuka-form-data-kuncian-entry-pejabat-1')){ ?>
          <?php
            if($cekfind->num_rows()>0){
                $sudah1 = $sudah1;
                if($cekfind->row()->Alasan_Pembukaan_Kuncian_Pejabat1 != null){
                    $sudah1 = 'sudah';
                }else{
                    $sudah1 = '';
                }
                $sudah1 = $sudah1;
            }else{
                $sudah1 = '';
            }
            $sudah1 = $sudah1;
          ?>

            <div class="form-group col-sm-12">
              <div class="col-sm-4 text-right" style="color:#00008B">
                Nama Pejabat Pembuka Kuncian 1
              </div>
              <div class="col-sm-6">
              <?php
              $pejabat1 = ($cekfind->num_rows()>0)? ( ($cekfind->row()->Pejabat_Pembuka_Kunci1 != null || $cekfind->row()->Pejabat_Pembuka_Kunci1 != '')? $cekfind->row()->Pejabat_Pembuka_Kunci1:$this->session->userdata("username") ) : $this->session->userdata("username");
              ?>
                <input type="hidden" class="form-control" name="pejabat1" id="pejabat1" placeholder="Nama Pejabat 1" value="<?=$pejabat1?>"  >
                <input type="text" class="form-control" placeholder="Nama Pejabat 1" value="<?=$pejabat1?>"  readonly >
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-4 text-right" style="color:#00008B">
                Alasan Pejabat 1 Membuka Kuncian
              </div>
              <div class="col-sm-6">
              <?php
              $alasan1 = ($cekfind->num_rows()>0)? $cekfind->row()->Alasan_Pembukaan_Kuncian_Pejabat1 : $this->session->flashdata('oldinput')['alasan1'];
              ?>
                <textarea class="form-control" name="alasan1" placeholder="Alasan"><?=$alasan1?></textarea>
              </div>
            </div>

      <?php
            
        }
        $sudah1 = $sudah1;
        ?>

      <?php
      $sudah2 = '';
      if(accessperm('membuka-form-data-kuncian-entry-pejabat-2')){ ?>
      
      <?php
            if($cekfind->num_rows()>0){
                $sudah2 = $sudah2;
                if($cekfind->row()->Alasan_Pembukaan_Kuncian_Pejabat2 != null){
                    $sudah2 = 'sudah';
                }else{
                    $sudah2 = '';
                }
                $sudah2 = $sudah2;
            }else{
                $sudah2 = '';
            }
            $sudah2 = $sudah2;
      ?>

            <div class="form-group col-sm-12">
              <div class="col-sm-4 text-right" style="color:#00008B">
                Nama Pejabat Pembuka Kuncian 2
              </div>
              <div class="col-sm-6">
              <?php
              $pejabat2 = ($cekfind->num_rows()>0)? ( ($cekfind->row()->Pejabat_Pembuka_Kunci2 != null || $cekfind->row()->Pejabat_Pembuka_Kunci2 != '')? $cekfind->row()->Pejabat_Pembuka_Kunci2:$this->session->userdata("username") ) : $this->session->userdata("username");
              ?>
                <input type="hidden" class="form-control" name="pejabat2" id="pejabat2" placeholder="Nama Pejabat 2" value="<?=$pejabat2?>"  >
                <input type="text" class="form-control" placeholder="Nama Pejabat 2" value="<?=$pejabat2?>"  readonly >
              </div>
            </div>

            <div class="form-group col-sm-12">
              <div class="col-sm-4 text-right" style="color:#00008B">
                Alasan Pejabat 2 Membuka Kuncian
              </div>
              <div class="col-sm-6">
              <?php
              $alasan2 = ($cekfind->num_rows()>0)? $cekfind->row()->Alasan_Pembukaan_Kuncian_Pejabat2 : $this->session->flashdata('oldinput')['alasan2'];
              ?>
                <textarea class="form-control" name="alasan2" placeholder="Alasan"><?=$alasan2?></textarea>
              </div>
            </div>


      <?php
            
      }
      
            $sudah2 = $sudah2;
      ?>
    <?php if(accessperm('membuka-form-data-kuncian-entry-pejabat-1') || accessperm('membuka-form-data-kuncian-entry-pejabat-2') ){ ?>
    <?php
       /* if($sudah1 =='sudah' && $sudah2 =='sudah'){
            
        }else{
                if(accessperm('membuka-form-data-kuncian-entry-pejabat-1') || accessperm('membuka-form-data-kuncian-entry-pejabat-2')){*/
    ?>
          <div class="form-group col-sm-12"> 
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
              <button type="submit" class="btn btn-block btn-flat">Submit</button>
            </div>
            <div class="col-sm-4">
              <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-danger btn-block btn-flat">Back</a>
            </div>
          </div>
    <?php 
               /* }*/
            
            
                //if(accessperm('membuka-form-data-kuncian-entry-pejabat-2')){
                
    ?>
         <!-- <div class="form-group col-sm-12"> 
            <div class="col-sm-4">
            </div>
            <div class="col-sm-4">
              <button type="submit" class="btn btn-block btn-flat">Submit</button>
            </div>
            <div class="col-sm-4">
              <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-danger btn-block btn-flat">Back</a>
            </div>
          </div>-->
    <?php
                //}
            
        //}
    } ?>
      </form>
    </div>
  </div>
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $('.select2').select2();
    
  });
</script>