<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="color:#00008B">Nama Paket Sesi Satuan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_Sesi?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Flag Ramadhan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=($dtdefault->Flag_Ramadhan=="Y")?'Ya':'Tidak';?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Flag Jumat</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=($dtdefault->Flag_Jumat=="Y")?'Ya':'Tidak';?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Flag Rehat Lunch</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=($dtdefault->Flag_RehatLunch=="Y")?'Ya':'Tidak';?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Keterangan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Keterangan?></td>
	</tr>
</table>