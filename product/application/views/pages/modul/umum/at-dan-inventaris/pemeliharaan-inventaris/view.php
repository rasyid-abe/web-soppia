<table class="table table-bordered table-striped" style="width: 100%">

	<tr>
		<td valign="top" style="color:#00008B">Kategori AT dan Inventaris</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=($dtdefault->Flag_AT_or_Inv == "AT")?'Aktiva Tetap':'Inventory';?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">No AT dan Inventaris</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->no_at_inv?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Nama Barang</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_AT_n_Invent?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Deskripsi Pemeliharaan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_Transaksi?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Penanggung Jawab</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->PenanggungJwb?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tanggal/Jam</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_TransaksiAwal)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Biaya</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=number_format($dtdefault->Nilai_Rp)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Keterangan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Keterangan?></td>
	</tr>
</table>