<?php
if($jenis == "IHT"){
?>
<div class="col-sm-4">
  <label>Pilih No Proforma <span style="color:red">*</span></label>
</div>
<div class="col-sm-8">
  <select name="no_proforma" class="form-control select2" id="no_proforma" style="width: 100%;" required>
    <option value="" selected>Pilih No Proforma</option>
    <?php
        foreach($dt->result() as $data){
    ?>
        <option title="<?=$data->Desc_ProformaKontrak?>" value="<?=$data->Id_ProformaKontrak?>" >Proforma Kontrak Nomor <?=$data->No_ProformaKontrak?></option>
    <?php
        }
    ?>
  </select>
</div>
<?php
}elseif($jenis == "NONIHT"){
?>
<div class="col-sm-4">
  <label>Pilih SK Pembukaan Kelas Reguler <span style="color:red">*</span></label>
</div>
<div class="col-sm-8">
  <select name="sk_pembukaankelas" class="form-control select2" id="sk_pembukaankelas" style="width: 100%;" required>
    <option value="" selected>Pilih SK Pembukaan Kelas Reguler</option>
    <?php
        foreach($dt->result() as $data){
    ?>
        <option title="<?=$data->Desc_DokBukaKlsReguler?>" value="<?=$data->Id_DokBukaKlsReguler?>" >SK Kelas Reguler Nomor <?=$data->No_Klsreguler?></option>
    <?php
        }
    ?>
  </select>
</div>
<?php
}
?>


