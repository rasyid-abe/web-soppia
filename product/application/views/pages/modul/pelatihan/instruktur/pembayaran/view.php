<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="color:#00008B">Nama Instruktur</td>
		<td valign="top">:</td>
		<?php
		    $inst = "--";
		    if($dtdefault->NamaLengkap_DgnGelar != null){
		        $inst = $dtdefault->NamaLengkap_DgnGelar;
		    }
		?>
		<td valign="top" style="color:#9900cc"><?=$inst?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Kelas Pelatihan</td>
		<td valign="top">:</td>
		<?php
		    $kelass = "--";
		    if($dtdefault->DescBebas_Kelas_n_Angkatan != null){
		        $kelass = $dtdefault->DescBebas_Kelas_n_Angkatan;
		    }
		?>
		<td valign="top" style="color:#9900cc"><?=$kelass?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Deskripsi Materi</td>
		<td valign="top">:</td>
		<?php
		    $matt = "--";
		    if($dtdefault->Desc_Materi_n_Aktifitas != null){
		        $matt = $dtdefault->Desc_Materi_n_Aktifitas;
		    }
		?>
		<td valign="top" style="color:#9900cc"><?=$matt?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tanggal Mengajar</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_Mengajar)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jam Mulai</td>
		<td valign="top">:</td>
		<?php
		    $jamaw = "--";
		    if($dtdefault->Jam_Mulai != null){
		        $jamaw = $dtdefault->Jam_Mulai;
		    }
		?>
		<td valign="top" style="color:#9900cc"><?=$jamaw?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jam Berakhir</td>
		<td valign="top">:</td>
		<?php
		    $jamak = "--";
		    if($dtdefault->Jam_Berakhir != null){
		        $jamak = $dtdefault->Jam_Berakhir;
		    }
		?>
		<td valign="top" style="color:#9900cc"><?=$jamak?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jumlah Jam</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jml_SesiJamLat?> Jam</td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jumlah Biaya</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc">Rp. <?=number_format($dtdefault->Jumlah_Bayar)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Status Bayar</td>
		<td valign="top">:</td>
		<?php
		    $byr = "";
		    if($dtdefault->Flag_SudahDibayar == "N"){
		        $byr = "Belum Dibayar";
		    } else $byr = "Sudah Dibayar";
		?>
		<td valign="top" style="color:#9900cc"><?=$byr?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tanggal Bayar</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_Dibayar)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Keterangan</td>
		<td valign="top">:</td>
		<?php
		    $ket = "--";
		    if($dtdefault->Keterangan != null){
		        $ket = $dtdefault->Keterangan;
		    }
		?>
		<td valign="top" style="color:#9900cc"><?=$ket?></td>
	</tr>
</table>