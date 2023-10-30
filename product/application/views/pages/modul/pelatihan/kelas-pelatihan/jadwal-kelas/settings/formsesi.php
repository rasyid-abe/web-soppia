<?php
    if($paket != 'custom'){
        $getdetailpaket = $this->db->where("FKd_Paket_Sesi_Harian",$paket)->get("ref_detil_paket_sesi_harian");
        if($getdetailpaket->num_rows()>0){
            foreach($getdetailpaket->result() as $key => $gdpk){
?>
<tr class="tamp-urutan<?=$harike?>">
    <td style="padding:5px" >
        <input type="hidden" name="FId_Kelas_n_Angkatan[<?=$harike?>][]" value="<?=$idkelas?>">
        <select name="FKd_Sesi_Satuan[<?=$harike?>][]" class="form-control select2" style="width: 100%;" >
          <option value="" selected>Pilih Sesi</option>
          <?php
          foreach ($FKd_Sesi_Satuan->result() as $data) {
            $slc = ($gdpk->FKd_Sesi_Satuan==$data->Kd_Sesi_Satuan)? 'selected':'';
          ?>
          <option value="<?=$data->Kd_Sesi_Satuan?>" <?=$slc?> ><?=$data->Desc_Sesi?></option>
          <?php
          }
          ?>
        </select>
    </td>
    <td style="padding:5px">
        <select name="FKd_Materi_n_Aktifitas[<?=$harike?>][]" id="FKd_Materi_n_Aktifitas" class="form-control select2" style="width: 100%;" >
          <option value="" selected>Pilih Materi</option>
          <?php
          foreach ($FKd_Materi_n_Aktifitas->result() as $data) {
            $slc = ($this->session->flashdata('oldinput')['FKd_Materi_n_Aktifitas']==$data->Kd_Materi_n_Aktifitas)? 'selected':'';
            $datanotye = ($data->Flag_Daftar_Nilai!="Y" && $data->Flag_Evaluasi_Instruktur	!="Y")? 'notye':'';
          ?>
          <option value="<?=$data->Kd_Materi_n_Aktifitas?>" data-id="<?=$datanotye?>" <?=$slc?> ><?=$data->Desc_Materi_n_Aktifitas?></option>
          <?php
          }
          ?>
        </select>
    </td>
    <td style="padding:5px">
        <select name="FId_Instruktur[<?=$harike?>][]" class="form-control select2" style="width: 100%;" >
          <option value="" selected>Pilih Instruktur</option>
          <?php
          foreach ($FId_Instruktur->result() as $data) {
            $slc = ($this->session->flashdata('oldinput')['FId_Instruktur']==$data->Id_Instruktur)? 'selected':'';
          ?>
          <option value="<?=$data->Id_Instruktur?>" <?=$slc?> ><?=$data->NamaLengkap_DgnGelar?></option>
          <?php
          }
          ?>
        </select>
    </td>
    <td style="padding:5px">
        <?php
            if($key>0){
                $hide1 = 'hide';
                $hide2 = '';
            }else{
                $hide1 = '';
                $hide2 = 'hide';
            }
        ?>
        <button type="button" id="tambah-sesi-new" class="btn btn-default btn-sm <?=$hide1?>"><i class='fa fa-plus-circle'></i></button>
        <button type="button" id="remove-sesi" class="btn btn-danger btn-sm <?=$hide2?>"><i class='fa fa-trash'></i></button>
        <button type="button" id="up-btn" class="btn btn-success btn-xs "><i class='fa fa-arrow-circle-up'></i></button>
        <button type="button" id="down-btn" class="btn btn-warning btn-xs "><i class='fa fa-arrow-circle-down'></i></button>
    </td>
</tr>
<?php   
            }
        }else{
?>
<tr class="tamp-urutan<?=$harike?>">
    <td style="padding:5px" >
        <input type="hidden" name="FId_Kelas_n_Angkatan[<?=$harike?>][]" value="<?=$idkelas?>">
        <select name="FKd_Sesi_Satuan[<?=$harike?>][]" class="form-control select2" style="width: 100%;" >
          <option value="" selected>Pilih Sesi</option>
          <?php
          foreach ($FKd_Sesi_Satuan->result() as $data) {
            $slc = ($this->session->flashdata('oldinput')['FKd_Sesi_Satuan']==$data->Kd_Sesi_Satuan)? 'selected':'';
          ?>
          <option value="<?=$data->Kd_Sesi_Satuan?>" <?=$slc?> ><?=$data->Desc_Sesi?></option>
          <?php
          }
          ?>
        </select>
    </td>
    <td style="padding:5px">
        <select name="FKd_Materi_n_Aktifitas[<?=$harike?>][]" id="FKd_Materi_n_Aktifitas" class="form-control select2" style="width: 100%;" >
          <option value="" selected>Pilih Materi</option>
          <?php
          foreach ($FKd_Materi_n_Aktifitas->result() as $data) {
            $slc = ($this->session->flashdata('oldinput')['FKd_Materi_n_Aktifitas']==$data->Kd_Materi_n_Aktifitas)? 'selected':'';
            $datanotye = ($data->Flag_Daftar_Nilai!="Y" && $data->Flag_Evaluasi_Instruktur	!="Y")? 'notye':'';
          ?>
          <option value="<?=$data->Kd_Materi_n_Aktifitas?>" data-id="<?=$datanotye?>" <?=$slc?> ><?=$data->Desc_Materi_n_Aktifitas?></option>
          <?php
          }
          ?>
        </select>
    </td>
    <td style="padding:5px">
        <select name="FId_Instruktur[<?=$harike?>][]" class="form-control select2" style="width: 100%;" >
          <option value="" selected>Pilih Instruktur</option>
          <?php
          foreach ($FId_Instruktur->result() as $data) {
            $slc = ($this->session->flashdata('oldinput')['FId_Instruktur']==$data->Id_Instruktur)? 'selected':'';
          ?>
          <option value="<?=$data->Id_Instruktur?>" <?=$slc?> ><?=$data->NamaLengkap_DgnGelar?></option>
          <?php
          }
          ?>
        </select>
    </td>
    <td style="padding:5px">
        <button type="button" id="tambah-sesi-new" class="btn btn-default btn-sm "><i class='fa fa-plus-circle'></i></button>
        <button type="button" id="remove-sesi" class="btn btn-danger btn-sm hide"><i class='fa fa-trash'></i></button>
        <button type="button" id="up-btn" class="btn btn-success btn-xs "><i class='fa fa-arrow-circle-up'></i></button>
        <button type="button" id="down-btn" class="btn btn-warning btn-xs "><i class='fa fa-arrow-circle-down'></i></button>
    </td>
</tr>
<?php
        }
    }else{
?>
<tr class="tamp-urutan<?=$harike?>">
    <td style="padding:5px" >
        <input type="hidden" name="FId_Kelas_n_Angkatan[<?=$harike?>][]" value="<?=$idkelas?>">
        <select name="FKd_Sesi_Satuan[<?=$harike?>][]" class="form-control select2" style="width: 100%;" >
          <option value="" selected>Pilih Sesi</option>
          <?php
          foreach ($FKd_Sesi_Satuan->result() as $data) {
            $slc = ($this->session->flashdata('oldinput')['FKd_Sesi_Satuan']==$data->Kd_Sesi_Satuan)? 'selected':'';
          ?>
          <option value="<?=$data->Kd_Sesi_Satuan?>" <?=$slc?> ><?=$data->Desc_Sesi?></option>
          <?php
          }
          ?>
        </select>
    </td>
    <td style="padding:5px">
        <select name="FKd_Materi_n_Aktifitas[<?=$harike?>][]" id="FKd_Materi_n_Aktifitas" class="form-control select2" style="width: 100%;" >
          <option value="" selected>Pilih Materi</option>
          <?php
          foreach ($FKd_Materi_n_Aktifitas->result() as $data) {
            $slc = ($this->session->flashdata('oldinput')['FKd_Materi_n_Aktifitas']==$data->Kd_Materi_n_Aktifitas)? 'selected':'';
            $datanotye = ($data->Flag_Daftar_Nilai!="Y" && $data->Flag_Evaluasi_Instruktur	!="Y")? 'notye':'';
          ?>
          <option value="<?=$data->Kd_Materi_n_Aktifitas?>" data-id="<?=$datanotye?>" <?=$slc?> ><?=$data->Desc_Materi_n_Aktifitas?></option>
          <?php
          }
          ?>
        </select>
    </td>
    <td style="padding:5px">
        <select name="FId_Instruktur[<?=$harike?>][]" class="form-control select2" style="width: 100%;" >
          <option value="" selected>Pilih Instruktur</option>
          <?php
          foreach ($FId_Instruktur->result() as $data) {
            $slc = ($this->session->flashdata('oldinput')['FId_Instruktur']==$data->Id_Instruktur)? 'selected':'';
          ?>
          <option value="<?=$data->Id_Instruktur?>" <?=$slc?> ><?=$data->NamaLengkap_DgnGelar?></option>
          <?php
          }
          ?>
        </select>
    </td>
    <td style="padding:5px">
        <button type="button" id="tambah-sesi-new" class="btn btn-default btn-sm "><i class='fa fa-plus-circle'></i></button>
        <button type="button" id="remove-sesi" class="btn btn-danger btn-sm hide"><i class='fa fa-trash'></i></button>
        <button type="button" id="up-btn" class="btn btn-success btn-xs "><i class='fa fa-arrow-circle-up'></i></button>
        <button type="button" id="down-btn" class="btn btn-warning btn-xs "><i class='fa fa-arrow-circle-down'></i></button>
    </td>
</tr>
<?php
    }
?>