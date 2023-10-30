<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
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
            <div class="form-group col-sm-12" align="center">
                <h3><img src="<?=base_url()?>/assets/images/soppia.png" width="70" height="70" /> <b>YAYASAN PENDIDIKAN INTERNAL AUDIT (YPIA)</b> <img src="<?=base_url()?>/assets/images/dsqia.png" width="70" height="70" /></h3>
            </div>
            
            <div class="form-group col-sm-12">
                <hr style="margin-bottom:0;margin-top:0" />
            </div>
            
            <form action="<?=base_url($this->uri->segment(1)."/".$this->uri->segment(2)."/update/".$dtdefault->Id_Soal)?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" /> 
            <div class="form-group col-sm-6">
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Nama Instruktur</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <select  class="form-control select2" name="instruktur" required>
                          <option value="" selected readonly>Pilih Instruktur</option>
                          <?php
                            foreach ($instruktur->result() as $data) {
                              $slcb1 = ( $dtdefault->FId_Instruktur == $data->Id_Instruktur)? 'selected':'';
                          ?>
                              <option value="<?=$data->Id_Instruktur?>" <?=$slcb1?> ><?=$data->NamaLengkap_DgnGelar?></option>
                          <?php
                            }
                          ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Materi Pelatihan</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <select  class="form-control select2" name="materipel" required>
                          <option value="" selected readonly>Materi dan Aktifitas</option>
                          <?php
                            foreach ($materi->result() as $data) {
                              $slcb1 = ( $dtdefault->FKd_Materi_n_Aktifitas == $data->Kd_Materi_n_Aktifitas)? 'selected':'';
                          ?>
                              <option value="<?=$data->Kd_Materi_n_Aktifitas?>" <?=$slcb1?> ><?=$data->Desc_Materi_n_Aktifitas?></option>
                          <?php
                            }
                          ?>
                        </select>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Materi Sub Bab</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <select  class="form-control select2" name="subbabm" required>
                          <option value="" selected readonly>Materi Sub Bab</option>
                          <?php
                            foreach ($subbab->result() as $data) {
                              $slcb1 = (  $dtdefault->FKd_SubBab == $data->Kd_SubBab)? 'selected':'';
                          ?>
                              <option value="<?=$data->Kd_SubBab?>" <?=$slcb1?> ><?=$data->Desc_SubBab?></option>
                          <?php
                            }
                          ?>
                     </select>
                  </div>   
                </div> 
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Isi Pertanyaan</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <textarea class="form-control" name="Isi_PertanyaanSoal" id="Isi_PertanyaanSoal" placeholder="Isi Pertanyaan" required><?=$dtdefault->Isi_PertanyaanSoal?></textarea>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Tingkat Kesulitan</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <select  class="form-control select2" name="Tingkat_Kesulitan" required>
                          <option value="" selected readonly>Pilih</option>
                          <option value="Sangat Mudah" <?=($dtdefault->Tingkat_Kesulitan == 'Sangat Mudah')?'selected':'';?> >Sangat Mudah</option>
                          <option value="Mudah" <?=($dtdefault->Tingkat_Kesulitan == 'Mudah')?'selected':'';?> >Mudah</option>
                          <option value="Sulit" <?=($dtdefault->Tingkat_Kesulitan == 'Sulit')?'selected':'';?> >Sulit</option>
                          <option value="Sangat Sulit" <?=($dtdefault->Tingkat_Kesulitan == 'Sangat Sulit')?'selected':'';?> >Sangat Sulit</option>
                     </select>
                  </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Jawaban Yang Benar</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <textarea class="form-control" name="Jawab_yg_Benar" id="Jawab_yg_Benar" placeholder="Jawaban Yang Benar" required><?=$dtdefault->Jawab_yg_Benar?></textarea>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Penjelasan Jawaban</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <textarea class="form-control" name="Penjelasan_Jawaban" id="Penjelasan_Jawaban" placeholder="Penjelasan Jawaban" required><?=$dtdefault->Penjelasan_Jawaban?></textarea>
                    </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>File sebelumnya</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <?=($dtdefault->Path_FileLampiran!= null)? '<img src="'.base_url("uploads/soal/".$dtdefault->Path_FileLampiran).'" width="170px" height="170px"></img>' : '<code>N/A</code>';?>
                  </div>
                </div>
            </div> <!--row-6-->
            
            <div class="form-group col-sm-6">
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>File Lampiran (isi jika ingin menganti file sebelumnya)</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <input type="file" class="form-control" name="Path_FileLampiran" />
                      <p class="pull-right" style="color:grey">FIle berupa .png/ .jpg/ .jpeg</p>
                  </div>
                </div>
                <div class="form-group col-sm-12">
                    <div class="col-sm-4">
                      <label>Point Jawaban</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <select class="form-control select2 point" name="Flag_4PointJwb" required>
                          <option value="" selected readonly>Pilih</option>
                          <option value="1" <?=($dtdefault->Flag_4PointJwb == '1')?'selected':'';?> >1</option>
                          <option value="2" <?=($dtdefault->Flag_4PointJwb == '2')?'selected':'';?> >2</option>
                          <option value="3" <?=($dtdefault->Flag_4PointJwb == '3')?'selected':'';?> >3</option>
                          <option value="4" <?=($dtdefault->Flag_4PointJwb == '4')?'selected':'';?> >4</option>
                          <option value="5" <?=($dtdefault->Flag_4PointJwb == '5')?'selected':'';?> >5</option>
                     </select>
                  </div>
                </div>
                <div class="form-group col-sm-12 point-a">
                    <div class="col-sm-4">
                      <label>Jawaban Point A</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <textarea class="form-control" name="Jawab_Point_a" id="Jawab_Point_a" placeholder="Jawaban Point A"><?=$dtdefault->Jawab_Point_a?></textarea>
                    </div>
                </div>
                <div class="form-group col-sm-12 point-b">
                    <div class="col-sm-4">
                      <label>Jawaban Point B</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <textarea class="form-control" name="Jawab_Point_b" id="Jawab_Point_b" placeholder="Jawaban Point B"><?=$dtdefault->Jawab_Point_b?></textarea>
                    </div>
                </div>
                <div class="form-group col-sm-12 point-c">
                    <div class="col-sm-4">
                      <label>Jawaban Point C</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <textarea class="form-control" name="Jawab_Point_c" id="Jawab_Point_c" placeholder="Jawaban Point C"><?=$dtdefault->Jawab_Point_c?></textarea>
                    </div>
                </div>
                <div class="form-group col-sm-12 point-d">
                    <div class="col-sm-4">
                      <label>Jawaban Point D</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <textarea class="form-control" name="Jawab_Point_d" id="Jawab_Point_d" placeholder="Jawaban Point D"><?=$dtdefault->Jawab_Point_d?></textarea>
                    </div>
                </div>
                <div class="form-group col-sm-12 point-e">
                    <div class="col-sm-4">
                      <label>Jawaban Point E</label>
                    </div>
                    <div class="col-sm-1">
                      <label>:</label>
                    </div>
                    <div class="col-sm-7">
                      <textarea class="form-control" name="Jawab_Point_e" id="Jawab_Point_e" placeholder="Jawaban Point E"><?=$dtdefault->Jawab_Point_e?></textarea>
                    </div>
                </div>
            </div> <!--row-6--> <br/><br/>
              
            <div class="form-group col-sm-12"> 
              <div class="col-sm-3 pull-right">
                <button type="submit" title="Simpan Data" class="btn btn-block btn-flat btn-success" 
                onclick="return confirm('Apakah Anda yakin dengan data tersebut ?')"><i class="fa fa-save"></i> Update</button>
              </div>
            </div>
            </form>
            <div class="form-group col-sm-12">
              <hr style="margin-bottom:0;margin-top:0" />
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
<script>
    $(document).ready(function(){
      $(".point-a,.point-b,.point-c,.point-d,.point-e").hide();
        var showpoint = '<?=$dtdefault->Flag_4PointJwb?>';
        if(showpoint == '1'){
          $(".point-a").show();
          $(".point-b,.point-c,.point-d,.point-e").hide();
        }else if(showpoint == '2'){
          $(".point-a,.point-b").show();
          $(".point-c,.point-d,.point-e").hide();
        }else if(showpoint == '3'){
          $(".point-a,.point-b,.point-c").show();
          $(".point-d,.point-e").hide();
        }else if(showpoint == '4'){
          $(".point-a,.point-b,.point-c,.point-d").show();
          $(".point-e").hide();
        }else if(showpoint == '5'){
          $(".point-a,.point-b,.point-c,.point-d,.point-e").show();          
        }else{

        }
        $(".point").on("change",function(){
             if($(this).val()=="1"){
                $(".point-a").show();
                $(".point-b").hide();
                $(".point-c").hide();
                $(".point-d").hide();
                $(".point-e").hide();
                $(".point-b,.point-c,.point-d,.point-e").find('textarea').val(""); 
             }
             else if($(this).val()=="2"){
                $(".point-a").show();
                $(".point-b").show();
                $(".point-c").hide();
                $(".point-d").hide();
                $(".point-e").hide();
                $(".point-c,.point-d,.point-e").find('textarea').val("");             
             }
             else if($(this).val()=="3"){
                $(".point-a").show();
                $(".point-b").show();
                $(".point-c").show();
                $(".point-d").hide();
                $(".point-e").hide();
                $(".point-d,.point-e").find('textarea').val("");
             }
             else if($(this).val()=="4"){
                $(".point-a").show();
                $(".point-b").show();
                $(".point-c").show();
                $(".point-d").show();
                $(".point-e").hide();
                $(".point-e").find('textarea').val("");
             }
             else if($(this).val()=="5"){
                $(".point-a").show();
                $(".point-b").show();
                $(".point-c").show();
                $(".point-d").show();
                $(".point-e").show();
                //.find('textarea').val("");
             }else{
              $(".point-a,.point-b,.point-c,.point-d,.point-e").find('textarea').val("");

             }
          });
    });
  </script>