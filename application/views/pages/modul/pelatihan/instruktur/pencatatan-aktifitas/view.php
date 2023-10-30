<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="color:#00008B;width:200px">Nama Instruktur</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->NamaLengkap_DgnGelar?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jenis Kegiatan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->optional?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Deskripsi Kegiatan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_Aktifitas?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tanggal</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tanggal)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jam Mulai</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jam_Mulai?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jam Berakhir</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jam_Berakhir?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Keterangan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Keterangan_Aktifitas?></td>
	</tr>
</table>