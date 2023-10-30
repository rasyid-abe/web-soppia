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
<div class="box" style="border:0px solid;margin:0px;padding: 0">
  <div class="box-body">
    <form action="<?=base_url('ajax/addendumstore/'.$this->uri->segment(3))?>" method="POST" enctype="multipart/form-data" id="form-add-iht">
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
          Addendum<br/>
          <textarea class="form-control" name="Desc_KontrakResmi" id="Desc_KontrakResmi" placeholder="Desc Addendum"  required><?=$this->session->flashdata('oldinput')['Desc_KontrakResmi']?></textarea>
        </div>
      </div>

      <div class="form-group col-sm-12">
        <div class="col-sm-6" style="color:#00008B">
          Nilai Rp<br/>
          <input type="text" class="form-control" name="Nilai_Rp" id="Nilai_Rp" onkeyup="splitInDots(this)" placeholder="Nilai Rp" value="<?=$this->session->flashdata('oldinput')['Nilai_Rp']?>" >
        </div>
      </div>

      <div class="form-group col-sm-12">
        <div class="col-sm-6" style="color:#00008B">
          Jumlah Peserta<br/>
          <input type="number" class="form-control" name="Rencana_JmlPeserta" id="Rencana_JmlPeserta" placeholder=" Jumlah Peserta" value="<?=$this->session->flashdata('oldinput')['Rencana_JmlPeserta']?>" >
        </div>
      </div>

      <div class="form-group col-sm-12">
        <div class="col-sm-6" style="color:#00008B">
          Tempat Pelaksanaan<br/>
          <input type="text" class="form-control" name="Rencana_TempatSelenggara" id="Rencana_TempatSelenggara" placeholder="Tempat Pelaksanaan" value="<?=$this->session->flashdata('oldinput')['Rencana_TempatSelenggara']?>" >
        </div>
      </div>

      <div class="form-group col-sm-12">
        <hr style="margin-bottom:0;margin-top:0" />
      </div>

      <div class="form-group col-sm-12">
        <div class="col-sm-6" style="color:#00008B">
          <input type="file" class="form-control" name="File_Lampiran[]" id="File_Lampiran" placeholder="File Lampiran" multiple >
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
      </div>

    </form>
  </div>
</div>

<script type="text/javascript">

  $(function(){
      
    var _Desc_KontrakResmi = $.session.get('Desc_KontrakResmi');
    var _Nilai_Rp = $.session.get('Nilai_Rp');
    var _Rencana_JmlPeserta = $.session.get('Rencana_JmlPeserta');
    var _Rencana_TempatSelenggara = $.session.get('Rencana_TempatSelenggara');
    
    function findandadd(vardata,idhtml){
        if(vardata != null || vardata != ''){
            var _find = $("body").find("#form-add-iht").children().find("#"+idhtml).length;
            if(_find > 0){
                $("#"+idhtml).each( function() {
                  $(this).val($.session.get(idhtml));
                });
            }
        } 
    }
    
    findandadd(_Desc_KontrakResmi,'Desc_KontrakResmi');
    findandadd(_Nilai_Rp,'Nilai_Rp');
    findandadd(_Rencana_JmlPeserta,'Rencana_JmlPeserta');
    findandadd(_Rencana_TempatSelenggara,'Rencana_TempatSelenggara');
      
   /* $(document).on('change',"#File_Lampiran",function() {
      var file = this.files[0];
      var imagefile = file.type;
     var match= ["application/vnd.ms-excel","application/vnd.openxmlformats-officedocument.spreadsheetml.sheet","text/plain","application/vnd.openxmlformats-officedocument.presentationml.presentation","application/vnd.ms-powerpoint","application/pdf","text/csv","application/vnd.openxmlformats-officedocument.wordprocessingml.document","application/msword"];
      if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])|| (imagefile==match[3])|| (imagefile==match[4])|| (imagefile==match[5])|| (imagefile==match[6])|| (imagefile==match[7])  || (imagefile==match[8]) ))
      { 
        msg = "Extensi yang diizinkan adalah \"xls|ppt|pptx|pdf|csv|txt|text|doc|docx|xlsx|word\"";
        alert(msg);
        $(this).val(null);
      }else 
      if(file.size > 100000000 || file.fileSize > 100000000){
        msg = "Ukuran File Terlalu Besar! Ukuran Maksimal 10";
        alert(msg);
        $(this).val(null);
      }else{

      }
    });*/
    
    $(document).on("submit","#form-add-iht",function(e){
        $.session.remove('Desc_KontrakResmi');
        $.session.remove('Nilai_Rp');
        $.session.remove('Rencana_JmlPeserta');
        $.session.remove('Rencana_TempatSelenggara');
        return true;
    });
    
    $(document).on("keyup","#Desc_KontrakResmi",function(){
        $.session.set('Desc_KontrakResmi', $(this).val());
    });
    $(document).on("keyup","#Nilai_Rp",function(){
        $.session.set('Nilai_Rp', $(this).val());
    });
    $(document).on("keyup","#Rencana_JmlPeserta",function(){
        $.session.set('Rencana_JmlPeserta', $(this).val());
    });
    $(document).on("keyup","#Rencana_TempatSelenggara",function(){
        $.session.set('Rencana_TempatSelenggara', $(this).val());
    });
  });

</script>