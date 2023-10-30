<?php
	if($dtdefault->num_rows() > 0){
		$dtdefault = $dtdefault->row();
		?>
		<table class="table table-bordered table-striped" style="width: 100%">
			<tr align="center">
				<td valign="top" colspan="3"><?=($dtdefault->foto != null)? '<img src="'.base_url("uploads/photo/pegawai/".$dtdefault->foto).'" width="170px" height="170px"></img>' : '<code>N/A</code>';?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Nama Lengkap</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->nama_pegawai?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Jadwal Senin</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->jadwal_senin_security ?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Jadwal Selasa</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->jadwal_selasa_security?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Jadwal Rabu</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->jadwal_rabu_security?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Jadwal Kamis</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->jadwal_kamis_security?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Jadwal Jum'at</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->jadwal_jumat_security?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Jadwal Sabtu</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->jadwal_sabtu_security?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Jadwal Minggu</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->jadwal_minggu_security?></td>
			</tr>
		</table>
		<?php
	} else {
		echo "<h4 class='text-center'> Data Jadwal Belum Tersedia </h4>";
		echo $dtdefault->row('nama_pegawai');
	}
?>
