<table class="table table-bordered table-striped" style="width: 100%">
    <tr>
		<td valign="top" style="color:#00008B" width="200px">Kategori AT dan Inventaris</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
		    if($dt->Flag_AT_or_Inv != null || $dt->Flag_AT_or_Inv != "" ){
                if($dt->Flag_AT_or_Inv == "AT"){
                   $Flag_AT_or_Inv  = "Aktiva Tetap";
                }else{
                   $Flag_AT_or_Inv = "Inventory";
                }
            }else{
                $Flag_AT_or_Inv = "";
            }
            echo $Flag_AT_or_Inv;
		?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">No AT dan Inventaris</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->no_at_inv?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Nama Barang</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->Desc_AT_n_Invent?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tanggal Beli</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dt->Tgl_Pengadaan)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Harga Barang</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc">Rp. <?=number_format($dt->Harga_Perolehan_Rp)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Bukti Pembelian (jpg/jpeg/png)</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
		    if($dt->bukti != null){
		    ?>
		    <a href="<?=base_url("uploads/fileapps/".$dt->bukti)?>" download>Download Bukti Pembelian</a><br/>
		    <img src="<?=base_url("uploads/fileapps/".$dt->bukti)?>" style="width:130px;height:130px">
		    <?php
		    }
		?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Keterangan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
		    echo $dt->Keterangan;
		?></td>
	</tr>
</table>