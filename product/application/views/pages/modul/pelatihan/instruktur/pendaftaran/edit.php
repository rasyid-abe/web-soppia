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
  <div class="box" style="border-top:0px solid">
    <div class="box-header with-border">
      <h3 class="box-title">Edit Instruktur</h3>

      <div class="box-tools pull-right">
        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                title="Kembali Ke Manage <?=$subtitlepage?>">
          <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i></button>
      </div>
    </div>
  </div>
  <div class="row">
    <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->Id_Instruktur)?>" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    
    
    <div class="col-sm-6"> 
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Foto</h3>
        </div>
        <div class="box-body">     

          <div class="col-sm-12 col-md-12">
            <div class="col-sm-12 col-md-12 p-5">
              <center>
              <?php
                if($dtdefault->FilePhoto != '' || $dtdefault->FilePhoto != null){
              ?>
                <img src="<?=base_url('./uploads/photo/'. $dtdefault->FilePhoto)?>" class="mx-auto img-circle" width='170px' height="170px" id='displayavatar'>
              <?php
                }else{
              ?>
                <img src="<?=base_url('assets/images/default-50x50.gif')?>" class="mx-auto img-circle" width='170px' height="170px" id='displayavatar'>
              <?php
                }
              ?>
              </center>
              <br/>
              <br/>
              <div class="form-group" align="center">
                <label for="avatar"></label>
                <input type="file" name="avatar" id="avatar">
                <p class="pull-right" style="color:grey">File berupa .png/ .jpg/ .jpeg (Max: 3Mb)</p>
              </div>
            </div>
          </div>

        </div>
      </div>

      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Data Diri</h3>
        </div>
        <div class="box-body">

          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              NIIS<br/>
              <input type="text" class="form-control" name="niis" id="niis" placeholder="Nomer Induk Instruktur YPIA" value="<?=$dtdefault->NIIS?>"  required="required"  >
            </div>
          </div>
          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              NIK<br/>
              <input type="text" class="form-control" name="nik" id="nik" placeholder="Nomer Induk Kependudukan" value="<?=$dtdefault->NIK?>"  required="required" >
            </div>
          </div>
          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Nama Lengkap (tanpa gelar)<br/>
              <input type="text" class="form-control" name="nl_no_g" id="nl_no_g" placeholder="Nama lengkap (tanpa gelar)" value="<?=$dtdefault->NamaLengkap_TanpaGelar?>" >
            </div>
          </div>
          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Nama Lengkap (dengan gelar)<br/>
              <input type="text" class="form-control" name="nl_w_g" id="nl_w_g" placeholder="Nama lengkap (dengan gelar)" value="<?=$dtdefault->NamaLengkap_DgnGelar?>" >
            </div>
          </div>
          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Nama Panggilan<br/>
              <input type="text" class="form-control" name="np" id="np" placeholder="Nama Panggilan" value="<?=$dtdefault->NamaPanggilan?>" >
            </div>
          </div>


          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Kota Lahir<br/>
              <input type="text" class="form-control" name="kotalahir" id="kotalahir" placeholder="Kota Lahir" value="<?=$dtdefault->Kota_Lahir?>" >
            </div>
          </div>     

          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Tanggal Lahir<br/>
              <input type="text" class="form-control date" name="tgllahir" id="tgllahir" placeholder="Tanggal Lahir" value="<?=$dtdefault->Tgl_Lahir?>"  required="required"  >
            </div>    
          </div>

          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Jenis Kelamin<br/>
              <select name="jeniskelamin" class="form-control select2" id="jeniskelamin" style="width: 100%;">
                <option value="" readonly selected>Pilih Jenis Kelamin</option>
                <?php
                foreach ($jeniskelamin->result() as $jk) {
                  $slc = ($dtdefault->FKd_JnsKelamin==$jk->Kd_JnsKelamin)? 'selected':'';
                ?>
                <option value="<?=$jk->Kd_JnsKelamin?>" <?=$slc?> ><?=$jk->Desc_JnsKelamin?></option>
                <?php
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Agama<br/>
              <select name="agama" class="form-control select2" id="agama" style="width: 100%;">
                <option value="" readonly selected>Pilih Agama</option>
                <?php
                foreach ($agama->result() as $agm) {
                  $slc = ($dtdefault->FKd_Agama==$agm->Kd_Agama)? 'selected':'';
                ?>
                <option value="<?=$agm->Kd_Agama?>" <?=$slc?> ><?=$agm->Desc_Agama?></option>
                <?php
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Alamat Rumah<br/>            
              <input type="text" class="form-control" name="alamatrumah" id="alamatrumah" placeholder="Alamat Rumah" value="<?=$dtdefault->Alamat_Rumah?>" >
            </div>  
          </div>  
          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Telp Rumah<br/>            
              <input type="text" class="form-control" name="telprumah" id="telprumah" placeholder="Telp Rumah" value="<?=$dtdefault->Telp_Rumah?>" >
            </div>
          </div>

          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              No HP<br/>            
              <input type="text" class="form-control" name="nohp" id="nohp" placeholder="No HP" value="<?=$dtdefault->No_HP?>" >
            </div> 
          </div>  
          <div class="form-group col-sm-12"> 
            <div class="col-sm-12" style="color:#00008B">
              Email Pribadi<br/>
              <input type="email" class="form-control" name="emailpribadi" id="emailpribadi" placeholder="Email Pribadi" value="<?=$dtdefault->eMail_Pribadi?>" >
            </div>
          </div>
        </div>        
      </div>   
    </div>


    <div class="col-sm-6">   
      
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Gelar</h3>
        </div>
        <div class="box-body tamp-gelar">
            
            <?php
                $data = @unserialize($dtdefault->gelar);
                if ($data !== false) {
                    foreach (unserialize($dtdefault->gelar) as $keyglr => $ggl){
            ?>
            
                <div class="form-group col-sm-12">
                  <div class="col-sm-10">
                    <select name="gelar[]" class="form-control select2" id="gelar" style="width: 100%;">
                      <option value="" readonly selected>Pilih Gelar</option>
                      <?php
                      foreach ($gelar->result() as $gelar1) {
                        $slc = ($ggl ==$gelar1->Kd_JnsGelar)? 'selected':'';
                      ?>
                      <option value="<?=$gelar1->Kd_JnsGelar?>" <?=$slc?> ><?=$gelar1->Desc_JnsGelar?></option>
                      <?php
                      }
                      ?>
                    </select>
                  </div>
                  <div class="col-sm-2">
                    <?php
                        if($keyglr == 0){ $hidea = ''; }else{ $hidea = 'hide'; };
                    ?>
                    <button type="button" id="add-gelar" class="btn btn-xs <?=$hidea?>" title="Tambah"><i class="fa fa-plus"></i></button>
                    <?php
                        if($keyglr == 0){ $hide = 'hide'; }else{ $hide = ''; };
                    ?>
                    <button type="button" id="remove-gelar" class="btn btn-xs btn-danger <?=$hide?>" title="Hapus"><i class="fa fa-trash"></i></button>
                  </div>
                </div>
            <?php
                    }
                }
            ?>

        </div>
      </div>  
    
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Sertifikasi</h3>
        </div>
        <div class="box-body tamp-sertifikasi">
            <?php
                $dataxx = @unserialize($dtdefault->sertifikasi);
                if ($dataxx !== false) {
                    foreach (unserialize($dtdefault->sertifikasi) as $keysst => $sst){
            ?>
          <div class="form-group col-sm-12">
            <div class="col-sm-10">
              <select name="sertifikasi[]" class="form-control select2" id="sertifikasi" style="width: 100%;">
                <option value="" readonly selected>Pilih Sertifikasi </option>
                <?php
                foreach ($sertifikasi->result() as $sertifikasi1) {
                  $slc = ($sst == $sertifikasi1->Kd_Sertifikasi)? 'selected':'';
                ?>
                <option value="<?=$sertifikasi1->Kd_Sertifikasi?>" <?=$slc?> ><?=$sertifikasi1->Desc_Sertifikasi?></option>
                <?php } ?>
              </select>
            </div>
            <div class="col-sm-2">
                <?php
                    if($keysst == 0){ $hidesst = ''; }else{ $hidesst = 'hide'; };
                ?>
                <button type="button" id="add-sertifikasi" class="btn btn-xs <?=$hidesst?>" title="Tambah"><i class="fa fa-plus"></i></button>
                <?php
                    if($keysst == 0){ $hidessta = 'hide'; }else{ $hidessta = ''; };
                ?>
                <button type="button" id="remove-sertifikasi" class="btn btn-xs btn-danger <?=$hidessta?>" title="Hapus"><i class="fa fa-trash"></i></button>
            </div>        
          </div>  
            <?php
                    }
                }
            ?>
          
              
        </div>
      </div>
    </div>


    <div class="col-sm-6"> 
      
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Jenjang Pendidikan</h3>
        </div>
        <div class="box-body">     

          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Strata Pendidikan<br/>
              <select name="stratapendidikan" class="form-control select2" id="stratapendidikan" style="width: 100%;">
                <option value="" readonly selected>Pilih Strata Pendidikan</option>
                <?php
                foreach ($stratapendidikan->result() as $stp) {
                  $slc = ($dtdefault->FKd_StrataPendidikanTerakhir==$stp->Kd_StrataPendidikan)? 'selected':'';
                ?>
                <option value="<?=$stp->Kd_StrataPendidikan?>" <?=$slc?> ><?=$stp->Desc_StrataPendidikan?></option>
                <?php
                }
                ?>
              </select>
            </div>
          </div>

              <div class="form-group col-sm-12 tamp-bidangpendidikan">          
                <div class="col-sm-12" style="color:#00008B">
                  Bidang Pendidikan<br/>
                  <div class="row">
                      
            <?php
                $dataxxzz = @unserialize($dtdefault->bidangpendidikan);
                if ($dataxxzz !== false) {
                    foreach (unserialize($dtdefault->bidangpendidikan) as $keypddk => $pddk){
            ?>
                    <div>
                      <div class="col-sm-10">
                        <select name="bidangpendidikan[]" class="form-control select2" id="bidangpendidikan" style="width: 100%;">
                          <option value="" readonly selected>Pilih Bidang Pendidikan</option>
                          <?php
                          foreach ($bidangpendidikan->result() as $bdp1) {
                            $slc = ($pddk == $bdp1->Kd_BidangPendidikan)? 'selected':'';
                          ?>
                          <option value="<?=$bdp1->Kd_BidangPendidikan?>" <?=$slc?> ><?=$bdp1->Desc_BidangPendidikan?></option>
                          <?php } ?>
                        </select>
                      </div>                
                      <div class="col-sm-2"> 
                        <?php
                            if($keypddk == 0){ $hidepddka = ''; }else{ $hidepddka = 'hide'; };
                        ?>
                        <button type="button" id="add-bidangpendidikan" class="btn btn-xs <?=$hidepddka?>" title="Tambah"><i class="fa fa-plus"></i></button>
                        <?php
                            if($keypddk == 0){ $hidepddk = 'hide'; }else{ $hidepddk = ''; };
                        ?>
                          <button type="button" id="remove-bidangpendidikan" class="btn btn-xs btn-danger <?=$hidepddk?>" title="Hapus"><i class="fa fa-trash"></i></button>   
                      </div><br/><br/>
                    </div>
                    
            <?php
                    }
                }
            ?>

                  </div>            
                </div>
    
              </div>
        </div>
      </div>


    </div>

    <div class="col-sm-6"> 
      <div class="box box-warning">
        <div class="box-header with-border">
          <h3 class="box-title">Perusahaan/Instantsi</h3>
        </div>
        <div class="box-body">
          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Perusahaan/Instansi<br/>
              <select name="perusahaaninstansi" class="form-control select2" id="perusahaaninstansi" style="width: 100%;">
                <option value="" readonly selected>Pilih Perusahaan/Instansi</option>
                <?php
                foreach ($perusahaaninstansi->result() as $perinst) {
                  $slc = ($dtdefault->FId_PershInstansi==$perinst->Id_PershInstansi)? 'selected':'';
                ?>
                <option value="<?=$perinst->Id_PershInstansi?>" data-name="<?=$perinst->Desc_PershInstansi?>" data-alamat="<?=$perinst->Alamat_Utama_Kantor?>" data-telp="<?=$perinst->Telp?>" data-email="<?=$perinst->email?>"  <?=$slc?> ><?=$perinst->Desc_PershInstansi?></option>
                <?php
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Nama Perusahaan/Instansi<br/>            
              <input type="text" class="form-control" name="namaperusahaaninstansi" id="namaperusahaaninstansi" placeholder="Nama Perusahaan /Instansi" value="<?=$dtdefault->NamaPershInstansi?>" >
            </div>
          </div>

          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Alamat Kantor<br/>            
              <textarea class="form-control" name="alamatkantor" id="alamatkantor" placeholder="Alamat Kantor"><?=$dtdefault->Alamat_Kantor?></textarea>
            </div>
          </div>
          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Telp Kantor<br/>            
              <input type="text" class="form-control" name="telpkantor" id="telpkantor" placeholder="Telp Kantor" value="<?=$dtdefault->Telp_Kantor?>" >
            </div>
          </div>

          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Email Kantor<br/>            
              <input type="email" class="form-control" name="emailkantor" id="emailkantor" placeholder="Email Kantor" value="<?=$dtdefault->eMail_Kantor?>" >
            </div>
          </div>

          <div class="form-group col-sm-12">
            <hr style="margin-bottom:0;margin-top:0" />
          </div>
          
          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Bidang Unit Organisasi<br/>
              <select name="bidangunitorganisasi" class="form-control select2" id="bidangunitorganisasi" style="width: 100%;">
                <option value="" readonly selected>Pilih Bidang Unit Organisasi</option>
                <?php
                foreach ($bidangunitorganisasi->result() as $bdgunorg) {
                  $slc = ($dtdefault->FKd_BidangUnitOrganisasi==$bdgunorg->Kd_BidangUnitOrganisasi)? 'selected':'';
                ?>
                <option value="<?=$bdgunorg->Kd_BidangUnitOrganisasi?>" <?=$slc?> ><?=$bdgunorg->Desc_BidangUnitOrganisasi?></option>
                <?php
                }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group col-sm-12">
            <div class="col-sm-12" style="color:#00008B">
              Jabatan di Organisasi<br/>            
              <input type="text" class="form-control" name="jabatanunitorganisasi" id="jabatanunitorganisasi" placeholder="Jabatan di Organisasi" value="<?=$dtdefault->Jabatan_NamaUnitOrganisasi?>" >
            </div>
          </div>

          <div class="form-group col-sm-12">          
            <div class="col-sm-12" style="color:#00008B">
              Keterangan<br/>
              <textarea class="form-control" name="keterangan" id="keterangan" placeholder="keterangan" ><?=$dtdefault->Keterangan?></textarea>
            </div>
          </div>

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
    </div>

    </form>
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
    $(document).on("change","#perusahaaninstansi",function(){
      var namepers = $(this).find(':selected').attr("data-name");
      var alamatpers = $(this).find(':selected').attr("data-alamat");
      var telppers = $(this).find(':selected').attr("data-telp");
      var emailpers = $(this).find(':selected').attr("data-email");
    
      $("#namaperusahaaninstansi").val(namepers);
      $("#alamatkantor").val(alamatpers);
      $("#telpkantor").val(telppers);
      $("#emailkantor").val(emailpers);
    });
    
    var _gelar = [];
    
    $(document).on("change",'#gelar.select2',function(){
        var _thisval = $(this).val();
        _gelar.push(_thisval);
    });

    $(document).on("click","#add-gelar",function(){
      var counting  =  $(".tamp-gelar").children().length;

      if(counting == 5555555555555555 ){

      }else{
        var div = $(".tamp-gelar").children(); 
        div.find(".select2").each(function(index){
            if ($(this).data('select2')) {
              $(this).select2('destroy');
            } 
        });
        var clonedt = $(this).parent().parent().clone(true);
        var _counting = _gelar.length;
        for(var _i = 0;_i<_counting;_i++){
            clonedt.find(".select2 option[value='"+_gelar[_i]+"']").remove();
        }
        clonedt.find(".select").val();
        clonedt.find("#remove-gelar").removeClass("hide");
        clonedt.find("#add-gelar").addClass("hide");
        clonedt.appendTo('.tamp-gelar');
        $('.select2').select2(); 
      }
    });

    $(document).on("click","#remove-gelar",function(){
      $(this).parent().parent().remove();
    });
    
    var _sertifikasi = [];
    
    $(document).on("change",'#sertifikasi.select2',function(){
        var _thisval = $(this).val();
        _sertifikasi.push(_thisval);
    });

    $(document).on("click","#add-sertifikasi",function(){
      var counting  =  $(".tamp-sertifikasi").children().length;

      if(counting == 99999999999999999 ){

      }else{
        var div = $(".tamp-sertifikasi").children(); 
        div.find(".select2").each(function(index){
            if ($(this).data('select2')) {
              $(this).select2('destroy');
            } 
        });
        var clonedt = $(this).parent().parent().clone(true);
        var _counting = _sertifikasi.length;
        for(var _i = 0;_i<_counting;_i++){
            clonedt.find(".select2 option[value='"+_sertifikasi[_i]+"']").remove();
        }
        clonedt.find(".select").val();
        clonedt.find("#remove-sertifikasi").removeClass("hide");
        clonedt.find("#add-sertifikasi").addClass("hide");
        clonedt.appendTo('.tamp-sertifikasi');
        $('.select2').select2(); 
      }
    });

    $(document).on("click","#remove-sertifikasi",function(){
      $(this).parent().parent().remove();
    });
    
    var _bidangpendidikan = [];
    
    $(document).on("change",'#bidangpendidikan.select2',function(){
        var _thisval = $(this).val();
        _bidangpendidikan.push(_thisval);
    });

    $(document).on("click","#add-bidangpendidikan",function(){
      var counting  =  $(".tamp-bidangpendidikan").children().length;

      if(counting == 3333333333333333333333333 ){

      }else{
        var div = $(".tamp-bidangpendidikan").children(); 
        div.find(".select2").each(function(index){
            if ($(this).data('select2')) {
              $(this).select2('destroy');
            } 
        });
        var clonedt = $(this).parent().parent().clone(true);
        var _counting = _bidangpendidikan.length;
        for(var _i = 0;_i<_counting;_i++){
            clonedt.find(".select2 option[value='"+_bidangpendidikan[_i]+"']").remove();
        }
        clonedt.find(".select").val();
        clonedt.find("#remove-bidangpendidikan").removeClass("hide");
        clonedt.find("#add-bidangpendidikan").addClass("hide");
        clonedt.appendTo('.tamp-bidangpendidikan');
        $('.select2').select2(); 
      }
    });

    $(document).on("click","#remove-bidangpendidikan",function(){
      $(this).parent().parent().remove();
    });

    $(document).on('change',"#avatar",function() {
      var file = this.files[0];
      var imagefile = file.type;
      var match= ["image/jpeg","image/png","image/jpg"];
      if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
      { 
        msg = "<code>Extensi yang diizinkan adalah <i>jpeg, png, jpg</i></code>";
        alertcustom(msg);
        $(this).val(null);
      }else if(file.size > 1000000 || file.fileSize > 1000000){
        msg = "<code>Ukuran File Terlalu Besar! Ukuran Maksimal 1MB</code>";
        alertcustom(msg);
        $(this).val(null);
      }else{
        var reader = new FileReader();
        reader.onload = imageIsLoaded;
        reader.readAsDataURL(this.files[0]);
      }
    });

    $(document).on('change',"#avatar",function() {
      var file = this.files[0];
      var imagefile = file.type;
      var match= ["image/jpeg","image/png","image/jpg"];
      if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
      { 
        msg = "<code>Extensi yang diizinkan adalah <i>jpeg, png, jpg</i></code>";
        alertcustom(msg);
        $(this).val(null);
      }else if(file.size > 1000000 || file.fileSize > 1000000){
        msg = "<code>Ukuran File Terlalu Besar! Ukuran Maksimal 1MB</code>";
        alertcustom(msg);
        $(this).val(null);
      }else{
        var reader = new FileReader();
        reader.onload = imageIsLoadedlogo;
        reader.readAsDataURL(this.files[0]);
      }
    });

    function imageIsLoaded(e) {
      $('#displayavatar').attr('src', e.target.result);
    };

    function alertcustom(msg){
      $("#modal-default").find(".modal-dialog .modal-content .modal-header .modal-title").html("Oopss..");
      $("#modal-default").find(".modal-dialog .modal-content .modal-body").html(msg);
      $("#modal-default").find(".modal-dialog").addClass("animated bounceIn");
      $("#modal-default").modal("show");
    }
    
  });
</script>