<table class="table table-bordered table-striped" style="width: 100%">
	<tr align="center">
		<td valign="top" colspan="3"><?=($dtdefault->FilePhoto!= null)? '<img src="'.base_url("uploads/photo/".$dtdefault->FilePhoto).'" width="170px" height="170px"></img>' : '<code>N/A</code>';?></td>
	</tr>
	<tr>
		<td valign="top" style="width:200px;color:#00008B">Perusahaan/Instansi</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getpersinstansi($dtdefault->FId_PershInstansi)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">NIPP</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->NIPP?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">NIK</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->NIK?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Nama Lengkap Tanpa Gelar</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->NamaLengkap_TanpaGelar?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Nama Lengkap Dengan Gelar</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->NamaLengkap_DgnGelar?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Nama Panggilan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->NamaPanggilan?></td>
	</tr>	
	<tr>
		<td valign="top" style="color:#00008B">Gelar</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getnamegelar($dtdefault->FKd_Gelar1)?></td>
	</tr>
	<?php
		if($dtdefault->FKd_Gelar2 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Gelar 2</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getnamegelar($dtdefault->FKd_Gelar2)?></td>
		</tr>
	<?php } ?>
	<?php
		if($dtdefault->FKd_Gelar3 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Gelar 3</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getnamegelar($dtdefault->FKd_Gelar3)?></td>
		</tr>
	<?php } ?>
	<?php
		if($dtdefault->FKd_Gelar4 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Gelar 4</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getnamegelar($dtdefault->FKd_Gelar4)?></td>
		</tr>
	<?php } ?>
	<?php
		if($dtdefault->FKd_Gelar5 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Gelar 5</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getnamegelar($dtdefault->FKd_Gelar5)?></td>
		</tr>
	<?php } ?>
	<tr>
		<td valign="top" style="color:#00008B">Sertifikasi</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getnamesertifikasi($dtdefault->FKd_Sertifikasi1)?></td>
	</tr>
	<?php
		if($dtdefault->FKd_Sertifikasi2 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Sertifikasi 2</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getnamesertifikasi($dtdefault->FKd_Sertifikasi2)?></td>
		</tr>
	<?php } ?>
	<?php
		if($dtdefault->FKd_Sertifikasi3 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Sertifikasi 3</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getnamesertifikasi($dtdefault->FKd_Sertifikasi3)?></td>
		</tr>
	<?php } ?>
	<?php
		if($dtdefault->FKd_Sertifikasi4 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Sertifikasi 4</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getnamesertifikasi($dtdefault->FKd_Sertifikasi4)?></td>
		</tr>
	<?php } ?>
	<?php
		if($dtdefault->FKd_Sertifikasi5 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Sertifikasi 5</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getnamesertifikasi($dtdefault->FKd_Sertifikasi5)?></td>
		</tr>
	<?php } ?>
	<?php
		if($dtdefault->FKd_Sertifikasi6 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Sertifikasi 6</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getnamesertifikasi($dtdefault->FKd_Sertifikasi6)?></td>
		</tr>
	<?php } ?>
	<?php
		if($dtdefault->FKd_Sertifikasi7 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Sertifikasi 7</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getnamesertifikasi($dtdefault->FKd_Sertifikasi7)?></td>
		</tr>
	<?php } ?>
	<?php
		if($dtdefault->FKd_Sertifikasi8 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Sertifikasi 8</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getnamesertifikasi($dtdefault->FKd_Sertifikasi8)?></td>
		</tr>
	<?php } ?>
	<?php
		if($dtdefault->FKd_Sertifikasi9 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Sertifikasi 9</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getnamesertifikasi($dtdefault->FKd_Sertifikasi9)?></td>
		</tr>
	<?php } ?>
	<tr>
		<td valign="top" style="color:#00008B">Kota Lahir</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Kota_Lahir?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tanggal Lahir</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_Lahir)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jenis Kelamin</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getjeniskelamin($dtdefault->FKd_JnsKelamin)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Agama</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getagama($dtdefault->FKd_Agama)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Alamat Rumah</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Alamat_Rumah?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Telp Rumah</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Telp_Rumah?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">No HP</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->No_HP?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Email Pribadi</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->eMail_Pribadi?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Strata Pendidikan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getstratapendidikan($dtdefault->Fkd_StrataPendidikanTerakhir)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Bidang Pendidikan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getbidangpendidikan($dtdefault->FKd_BidangPendidikan1)?></td>
	</tr>
	<?php
		if($dtdefault->FKd_BidangPendidikan2 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Bidang Pendidikan 2</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getbidangpendidikan($dtdefault->FKd_BidangPendidikan2)?></td>
		</tr>
	<?php } ?>
	<?php
		if($dtdefault->FKd_BidangPendidikan3 != null) { ?>
		<tr>
			<td valign="top" style="color:#00008B">Bidang Pendidikan 3</td>
			<td valign="top">:</td>
			<td valign="top" style="color:#9900cc"><?=getbidangpendidikan($dtdefault->FKd_BidangPendidikan3)?></td>
		</tr>
	<?php } ?>
	<tr>
		<td valign="top" style="color:#00008B">Bidang Unit Organisasi</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getbidangunitorganisasi($dtdefault->FKd_BidangUnitOrganisasi)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jabatan Bidang Unit Organisasi</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jabatan_NamaUnitOrganisasi?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Alamat Kantor</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Alamat_Kantor?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Telp Kantor</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Telp_Kantor?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Email Kantor</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->eMail_Kantor?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Keterangan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Keterangan;?></td>
	</tr>
</table>