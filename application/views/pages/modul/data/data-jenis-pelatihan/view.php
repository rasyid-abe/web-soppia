<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="color:#00008B">Nama Jenis Pelatihan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->Desc_JenisPelatihan?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tingkatan Pelatihan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
		    $status_pel = $dt->status_pel;
            if($status_pel == 'dsr1'){$tingkatan = "Dasar I";}
            else if($status_pel == 'dsr2'){$tingkatan = "Dasar II";}
            else if($status_pel == 'DSR'){$tingkatan = "DASAR";}
            else if($status_pel == 'lnjt1'){$tingkatan = "Lanjutan I";}
            else if($status_pel == 'lnjt2'){$tingkatan = "Lanjutan II";}
            else if($status_pel == 'LNJT'){$tingkatan = "LANJUTAN";}
            else if($status_pel == 'mnj'){$tingkatan = "Manajerial";}
            else if($status_pel == 'MNJT'){$tingkatan = "MANAJERIAL";}else{ $tingkatan = ""; }
            echo $tingkatan;
		?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Kelompok Pelatihan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->Desc_KelompokPelatihan?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">IHT</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=($dt->Flag_IHT == "Y")? 'Ya':'Tidak';?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">QIA</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=($dt->Flag_QIA == "Y")? 'Ya':'Tidak'?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Default Awal QIA</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=($dt->Flag_DefaultAwalQIA == "Y")? 'Ya':'Tidak'?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jenis Pelatihan I</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->Desc_JnsPelatihan1?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jenis Pelatihan II</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->Desc_JnsPelatihan2?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jenis Pelatihan III</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->Desc_JnsPelatihan3?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Kode Singkat</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->KODE_Singkatan?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Keterangan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->Keterangan?></td>
	</tr>
</table>