<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="color:#00008B">Name</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->Desc_Materi_n_Aktifitas?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Singkatan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->Singkatan?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Skor</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->Skor?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Daftar Nilai</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=($dt->Flag_Daftar_Nilai == "Y")? 'Ya':'Tidak';?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Evaluasi Instruktur</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=($dt->Flag_Evaluasi_Instruktur == "Y")? 'Ya':'Tidak'?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Menit per sesi</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->Menit_per_Sesi?></td>
	</tr>
</table>