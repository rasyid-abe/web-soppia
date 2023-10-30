<div class="form-group col-sm-12">
  <div class="col-sm-6">
    Perusahaan / Instansi<br/>
    <select name="FId_PershInstansi" class="form-control select2" style="width: 100%;">
      <option value="" readonly disabled selected>Pilih Perusahaan / Instansi</option>
      <?php
      foreach ($pers->result() as $fid) {
        $slc = ($profor->FId_PershInstansi==$fid->Id_PershInstansi)? 'selected':'readonly disabled';
      ?>
      <option value="<?=$fid->Id_PershInstansi?>" <?=$slc?> ><?=$fid->Desc_PershInstansi?></option>
      <?php
      }
      ?>
    </select>
  </div>
</div>       

<div class="form-group col-sm-12">
  <div class="col-sm-6" style="color:#00008B">
    Nilai Rp<br/>
    <input type="number" class="form-control" name="Nilai_Rp" id="Nilai_Rp" placeholder="Nilai Rp" value="<?=$profor->Nilai_Rp?>" >
  </div>
</div>

<div class="form-group col-sm-12">
  <div class="col-sm-6" style="color:#00008B">
    Jumlah Peserta<br/>
    <input type="number" class="form-control" name="Rencana_JmlPeserta" id="Rencana_JmlPeserta" placeholder=" Jumlah Peserta" value="<?=$profor->Rencana_JmlPeserta?>" >
  </div>
</div>

<div class="form-group col-sm-12">
  <div class="col-sm-6" style="color:#00008B">
    Tempat Pelaksanaan<br/>
    <input type="text" class="form-control" name="Rencana_TempatSelenggara" id="Rencana_TempatSelenggara" placeholder="Tempat Pelaksanaan" value="<?=$profor->Rencana_TempatSelenggara?>" >
  </div>
</div>

<div class="form-group col-sm-12">
  <div class="col-sm-6" style="color:#00008B">
    File Sebelumnya : <a href="<?=base_url('uploads/fileapps/proformakontrak/'.$profor->File_Lampiran)?>" download> <?=$profor->File_Lampiran?></a>
    <input type="hidden" name="filesebelumnya" value="<?=$profor->File_Lampiran?>" >
  </div>
</div>

<div class="form-group col-sm-12">
  <hr style="margin-bottom:0;margin-top:0" />
</div>

<div class="form-group col-sm-12">
  <div class="col-sm-6" style="color:#00008B">
    Ganti File :<br/>
    <input type="file" class="form-control" name="File_Lampiran" id="File_Lampiran" placeholder="File Lampiran" >
  </div>
</div>