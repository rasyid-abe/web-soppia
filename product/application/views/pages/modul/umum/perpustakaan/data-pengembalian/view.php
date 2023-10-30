<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" width="200px" style="color:#00008B">Nama Anggota</td>
		<td valign="top" width="20px">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->nama_anggota?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Judul Buku</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->judul_buku?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jumlah Buku</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->jml_pinjam?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tanggal Pinjam</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->tgl_pinjam)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jadwal Kembali</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->tgl_kembali)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tanggal Kembali</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->tanggal_kembali)?></td>
	</tr>
</table>