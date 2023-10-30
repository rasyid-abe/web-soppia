<div class="row">
    <div class="form-group col-sm-4">
      <label for="tgl1">Tanggal Pelaksanaan</label>
      <input type="text" class="form-control date" id="tgl1" placeholder="Tanggal Pelaksanaan" name="tgl[]">
      <input type="hidden" class="form-control" id="harike" placeholder="Hari Ke" name="harike" value="<?=$hari?>">
    </div>
    <div class="form-group col-sm-4">
      <label for="hari">Hari</label>
      <input type="hidden" class="form-control hari" id="hariday" placeholder="Hari" name="hari[]" >
      <input type="text" class="form-control hari" placeholder="Hari" readonly>
    </div>
    <div class="form-group col-sm-4">
      <label for="paket">Paket</label>
      <select name="paket" id="paket" class="form-control">
          <option value="">Pilih Paket</option>
          <option value="custom">Custom</option>
          <?php
            if($paket->num_rows()>0){
                foreach($paket->result() as $pkt){
            ?>
            <option value="<?=$pkt->Kd_Paket_Sesi_Harian?>"><?=$pkt->Desc_Paket_Sesi_Harian?></option>
            <?php
                }
            }else{
                
            }
          ?>
      </select>
    </div>
</div>