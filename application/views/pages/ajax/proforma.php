<?php
 if(accessperm('melihat-data-proforma-kontrak')){ 
?>
<table class="table table-bordered table-striped" style="width: 100%">
<tr>
  <td valign="top" style="color:#00008B">Proforma Kontrak Pelatihan</td>
  <td valign="top">:</td>
  <td valign="top" style="color:#9900cc"><?=$proforma->row()->Desc_ProformaKontrak?></td>
</tr>
<tr>
  <td valign="top" style="color:#00008B">Nomor Proforma Kontrak</td>
  <td valign="top">:</td>
  <td valign="top" style="color:#9900cc"><?=$proforma->row()->No_ProformaKontrak?></td>
</tr>
<tr>
  <td valign="top" style="color:#00008B">Perusahaan / Instansi</td>
  <td valign="top">:</td>
  <td valign="top" style="color:#9900cc"><?=$proforma->row()->Desc_PershInstansi?></td>
</tr>
<tr>
  <td valign="top" style="color:#00008B">Nilai Rp</td>
  <td valign="top">:</td>
  <td valign="top" style="color:#9900cc">Rp. <?=number_format($proforma->row()->Nilai_Rp)?></td>
</tr>
<tr>
  <td valign="top" style="color:#00008B">Rencana Jumlah Peserta</td>
  <td valign="top">:</td>
  <td valign="top" style="color:#9900cc"><?=$proforma->row()->Rencana_JmlPeserta?></td>
</tr>
<tr>
  <td valign="top" style="color:#00008B">Rencana Tempat Penyelenggaraan</td>
  <td valign="top">:</td>
  <td valign="top" style="color:#9900cc"><?=$proforma->row()->Rencana_TempatSelenggara?></td>
</tr>
<tr>
  <td valign="top" style="color:#00008B">File Lampiran </td>
  <td valign="top">:</td>
  <td valign="top" style="color:#9900cc">
      <?php
                $proforma = $proforma->row();
                if($proforma->File_Lampiran!=null){
                    if( @unserialize($proforma->File_Lampiran) !=  false){
            ?>
                <div style="max-height:150px;overflow:auto">
                    <?php
                        foreach(unserialize($proforma->File_Lampiran) as $val ){
                            if($val == 'a:0:{}'){
                                
                            }else{
                    ?>
                            <a href="<?=base_url('uploads/fileapps/proformakontrak/'.$val)?>" download> <?=$val?></a> <?=gettimefile($val)?> <br/> <br/>
                    <?php
                            }
                        }
                    ?>
                </div>
            <?php
                    }else{
                        if($proforma->File_Lampiran != null && $proforma->File_Lampiran != 'a:0:{}' ){
            ?>
                        <a href="<?=base_url('uploads/fileapps/proformakontrak/'.$proforma->File_Lampiran)?>" download> <?=$proforma->File_Lampiran?></a> <?=gettimefile($proforma->File_Lampiran)?>
            <?php
                        }
                    }
                }
            ?>
      
  </td>
</tr>
</table>

<div class="box">
  <div class="box-header  with-border">
    <h3 class="box-title">Accounting Jurnal</h3>
  </div>
  <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-bordered table-striped" style="width: 100%">
                    <thead>
                        <tr>
                          <td valign="top">Deskripsi</td>
                          <td valign="top">Status</td>
                          <td valign="top">Nilai</td>
                        </tr>
                    <thead>
               <?php
                foreach($acc_jur->result() as $accj){
                    if($accj->Flag_D_or_K == "D"){
                ?>
                    <tr class="success">
                      <td valign="top"><?php
                        $desc = $this->db->where(array("idproforma"=>$accj->FId_Proforma,"Flag_GrupAccount"=>"A","Flag_Proforma_or_Kelas"=>"P"))->get("mst_subaccount_soppia");
                        echo $desc->row()->Desc_Account;
                      ?></td>
                      <td valign="top">DEBIT</td>
                      <td valign="top"><?=number_format($accj->Nilai_Rps)?></td>
                    </tr>
                <?php
                    }
                }
               ?>
               </table>
               </div>
               <div class="col-sm-6">
                <table class="table table-bordered table-striped" style="width: 100%">
                    <thead>
                        <tr>
                          <td valign="top">Deskripsi</td>
                          <td valign="top">Status</td>
                          <td valign="top">Nilai</td>
                        </tr>
                    <thead>
               <?php
                foreach($acc_jur->result() as $accj){
                    if($accj->Flag_D_or_K == "K"){
                ?>
                    <tr class="warning">
                      <td valign="top"><?php
                        $desc = $this->db->where(array("idproforma"=>$accj->FId_Proforma,"Flag_GrupAccount"=>"R","Flag_Proforma_or_Kelas"=>"P"))->get("mst_subaccount_soppia");
                        echo $desc->row()->Desc_Account;
                      ?></td>
                      <td valign="top">KREDIT</td>
                      <td valign="top"><?=number_format($accj->Nilai_Rps)?></td>
                    </tr>
                <?php
                    }
                }
               ?>
               </table>
           </div>
       </div>
  </div>
</div>
<?php
  }else{
    echo "Anda tidak memiliki akses untuk melihat ini!";
  }
?>
