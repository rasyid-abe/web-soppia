<script type="text/javascript">
  
      function reverseNumber(input) {
       return [].map.call(input, function(x) {
          return x;
        }).reverse().join(''); 
      }
      
      function plainNumber(number) {
         return number.split('.').join('');
      }
      
      function splitInDots(input) {
        
        var value = input.value,
            plain = plainNumber(value),
            reversed = reverseNumber(plain),
            reversedWithDots = reversed.match(/.{1,3}/g).join('.'),
            normal = reverseNumber(reversedWithDots);
        
        //console.log(plain,reversed, reversedWithDots, normal);
        input.value = normal;
      }
    
</script>
<?php
$cekaddendum = $this->db->where(array("FId_ProformaKontrak"=>$this->uri->segment(3)))->get("mst_addendumkontrak");
if($cekaddendum->num_rows()>0){
  $count__ = 1;
}else{
  $count__ = 0;
}

$readonly__ = ($count__>0)? 'readonly':'';
?>
  <form action="<?=base_url('ajax/kontrakresmiupdate/'.$this->uri->segment(3)."/".$dtdefault->Id_KontrakResmi)?>" method="POST" enctype="multipart/form-data">
<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />    

  <div class="form-group col-sm-12">
    <div class="col-sm-6">
        <input type="hidden" name="FId_ProformaKontrak" class="form-control " id="FId_ProformaKontrak"  value="<?=$fid_proformakontrak->row()->Id_ProformaKontrak?>">
    </div>
    <div class="col-sm-6">
        <input type="hidden" name="FId_PershInstansi" class="form-control " id="FId_PershInstansi"  value="<?=$fid_pershinstansi->row()->Id_PershInstansi?>">
    </div>
  </div>

  <div class="form-group col-sm-12">
      <table class="table table-bordered table-striped" style="width: 100%">
        <tr>
          <td style="color:#00008B">Proforma Kontrak</td>
          <td>:</td>
          <td>
            <?=$fid_proformakontrak->row()->Desc_ProformaKontrak?>
          </td>
        </tr>
        <tr>
          <td style="color:#00008B">Perusahaan / Instansi</td>
          <td>:</td>
          <td>
            <?=$fid_pershinstansi->row()->Desc_PershInstansi?>
          </td>
        </tr>
      </table>
  </div>

  <div class="form-group col-sm-12">
    <hr style="margin:-10px;padding:5px 0px" />
  </div>

  <div class="form-group col-sm-12">
    <div class="col-sm-12" style="color:#00008B">
      Kontrak Resmi<br/>
      <textarea class="form-control" name="Desc_KontrakResmi" id="Desc_KontrakResmi" placeholder="Desc Kontrak Resmi" required><?=$dtdefault->Desc_KontrakResmi?></textarea>
    </div>
  </div>


  <div class="form-group col-sm-12">
    <div class="col-sm-6" style="color:#00008B">
      Nilai Rp<br/>
      <input type="text" class="form-control" name="Nilai_Rp" id="Nilai_Rp" placeholder="Nilai Rp" value="<?=str_replace(",",".",number_format($dtdefault->Nilai_Rp))?>"  onkeyup="splitInDots(this)" <?=$readonly__?> >
    </div>
  </div>

  <div class="form-group col-sm-12">
    <div class="col-sm-6" style="color:#00008B">
      Jumlah Peserta<br/>
      <input type="number" class="form-control" name="Rencana_JmlPeserta" id="Rencana_JmlPeserta" placeholder=" Jumlah Peserta" value="<?=$dtdefault->Rencana_JmlPeserta?>" >
    </div>
  </div>

  <div class="form-group col-sm-12">
    <div class="col-sm-6" style="color:#00008B">
      Tempat Pelaksanaan<br/>
      <input type="text" class="form-control" name="Rencana_TempatSelenggara" id="Rencana_TempatSelenggara" placeholder="Tempat Pelaksanaan" value="<?=$dtdefault->Rencana_TempatSelenggara?>" >
    </div>
  </div>
  <?php
    if($dtdefault->File_Lampiran != null){
  ?>
  <div class="form-group col-sm-12">
    <div class="col-sm-6">
      File Sebelumnya :<!-- <a href="<?=base_url('uploads/fileapps/kontrakresmi/'.$dtdefault->File_Lampiran)?>">File Lampiran</a>-->
      
      <?php
                if($dtdefault->File_Lampiran != null){
                    if( @unserialize($dtdefault->File_Lampiran) !=  false){
            ?>
                <div style="max-height:150px;overflow:auto">
                    <?php
                        if(count(unserialize($dtdefault->File_Lampiran)) > 0){
                            foreach(unserialize($dtdefault->File_Lampiran) as $val ){
                                
                                if($val == 'a:0:{}' || $val == null || $val == ''){
                                    
                                }else{
                    ?>
                                <button type="button" class="btn btn-xs btn-danger btn-delete-file-lampiran" data="<?=base_url('ajax/delete_file_kontrak_resmi/'.$dtdefault->Id_KontrakResmi.'/'.$val)?>"><i class="fa fa-trash"></i></button> <a href="<?=base_url('uploads/fileapps/kontrakresmi/'.$val)?>" download> <?=$val?></a> <input type="hidden" name="filesebelumnya[]" value="<?=$val?>" > <?=gettimefile($val)?> <br/> <br/>
                    <?php
                                }
                            }
                            
                        }
                    ?>
                </div>
            <?php
                    }else{
                        if($dtdefault->File_Lampiran != null && $dtdefault->File_Lampiran != 'a:0:{}'){
            ?>
                        <button type="button" class="btn btn-xs btn-danger btn-delete-file-lampiran" data="<?=base_url('ajax/delete_file_kontrak_resmi/'.$dtdefault->Id_KontrakResmi.'/'.$dtdefault->File_Lampiran)?>"><i class="fa fa-trash"></i></button>  <a href="<?=base_url('uploads/fileapps/kontrakresmi/'.$dtdefault->File_Lampiran)?>" download> <?=$dtdefault->File_Lampiran?></a> <?=gettimefile($dtdefault->File_Lampiran)?>
                        <input type="hidden" name="filesebelumnya[]" value="<?=$dtdefault->File_Lampiran?>" >
            <?php
                        }else{
                            echo 'belum ada data';
                        }
                    }
                }
            ?>
            
    </div>
  </div>
  <?php
    }
  ?>

  <div class="form-group col-sm-12">
    <hr style="margin-bottom:0;margin-top:0" />
  </div>

  <div class="form-group col-sm-12">
    <div class="col-sm-6" style="color:#00008B">
      <?=($dtdefault->File_Lampiran != null)? "Ganti File": "File"; ?>:<br/>
      <input type="file" class="form-control" name="File_Lampiran[]" id="File_Lampiran" placeholder="File Lampiran" multiple>
      <p class="pull-right" style="color:grey">File berupa: .jpg .pdf .doc .xls .txt (Max: 3 Mb)</p>
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
      <a class="btn btn-danger btn-block btn-flat close-edit-kontrakresmi">Back</a>
    </div>
  </div>
</form>


<script type="text/javascript">
  $(function(){
    $(document).on("click",".close-edit-kontrakresmi",function(){
      
      $(".show-kontrakresmi").find("#tampil").removeClass("hide");
      $(".show-kontrakresmi").find("#edit").addClass("hide");
    });
    
     $(document).on("click",".btn-delete-file-lampiran",function(){
        var _url = $(this).attr("data");
        var _this = $(this);
        $.get(_url,function(data){
            _this.next().next().next().remove();
            _this.next().next().remove();
            _this.next().remove();
            _this.remove();
        })
    });

    /*$(document).on('change',"#File_Lampiran",function() {
      var file = this.files[0];
      var imagefile = file.type;
      var match= ["application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","text/plain","application/vnd.openxmlformats-officedocument.presentationml.presentation","application/vnd.ms-powerpoint","application/pdf","text/csv","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/msword"];
      if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])|| (imagefile==match[3])|| (imagefile==match[4])|| (imagefile==match[5])|| (imagefile==match[6])|| (imagefile==match[7])  || (imagefile==match[8]) ))
      { 
        msg = "Extensi yang diizinkan adalah \"xls|ppt|pptx|pdf|csv|txt|text|doc|docx|xlsx|word\"";
        alert(msg);
        $(this).val(null);
      }else if(file.size > 10000000 || file.fileSize > 10000000){
        msg = "Ukuran File Terlalu Besar! Ukuran Maksimal 1MB";
        alert(msg);
        $(this).val(null);
      }else{

      }
      });*/
  });
</script>

