<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" width="200px" style="color:#00008B">Nomor KTP</td>
		<td valign="top" width="20px">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->noktp?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Nama Anggota</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->nama_anggota?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Alamat</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->alamat?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Nomor HP</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->nohp?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tanggal Daftar</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->tgl_daftar)?></td>
	</tr>
</table>