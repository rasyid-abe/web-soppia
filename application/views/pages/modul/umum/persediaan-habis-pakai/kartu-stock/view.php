<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="color:#00008B" width="200px">Deskripsi Habis Pakai</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_Consumables?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tanggal</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_PengadaanPertama)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Lokasi Simpan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_Lokasi_Simpan?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Saldo</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc">Rp. <?=number_format($dtdefault->Saldo)?></td>
	</tr>
</table>