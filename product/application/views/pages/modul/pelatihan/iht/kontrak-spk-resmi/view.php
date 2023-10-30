<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="width:200px;color:#00008B">Kontrak Resmi</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_KontrakResmi?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Proforma Kesepakatan Pelatihan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_ProformaKontrak?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Perusahaan/Instansi</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_PershInstansi?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Nilai Rp</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Nilai_Rp?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jumlah Peserta</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Rencana_JmlPeserta?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Rencana Tempat Penyelenggaraan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Rencana_TempatSelenggara?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">File Lampiran</td>
		<td valign="top">:</td>
		<td valign="top"><?='<a href="'.base_url('uploads/fileapps/'.$dtdefault->File_Lampiran).'" download><i class="fa fa-download"></i> File Lampiran</a>'?></td>
	</tr>
</table>