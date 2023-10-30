<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="color:#00008B">Tanggal Ujian</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_Ujian)?></td>
	</tr>	
	<tr>
		<td valign="top" style="color:#00008B">Kelas</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
			$getkls = $this->db->where(array('Id_Kelas_n_Angkatan'=>$dtdefault->FId_Kelas_n_Angkatan))->get('trm_pembukaankelas_n_angkatan');
				if($getkls->num_rows()>0){
					$kls = 'No Kelas: '.$getkls->row()->nomor_kelas;
					$kls .= '<br/>Nama Kelas : '.$getkls->row()->DescBebas_Kelas_n_Angkatan;
				}else{
					$kls = '-';
				}
			echo  $kls;
		?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Materi</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
			$getmtr = $this->db->where(array('Kd_Materi_n_Aktifitas'=>$dtdefault->FKd_Materi_n_Aktifitas))->get('mst_materi_n_aktifitas');
				if($getmtr->num_rows()>0){
					$mtr = $getmtr->row()->Desc_Materi_n_Aktifitas;
				}else{
					$mtr = '-';
				}
			echo  $mtr;
		?></td>
	</tr>	
	<tr>
		<td valign="top" style="color:#00008B">Skor Benar</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Skor_Benar?></td>
	</tr>	
	<tr>
		<td valign="top" style="color:#00008B">Skor Salah</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Skor_Salah?></td>
	</tr>	
	<tr>
		<td valign="top" style="color:#00008B">Skor Default</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Skor_Default?></td>
	</tr>	
	<tr>
		<td valign="top" style="color:#00008B">Pengumuman Hasil Ujian</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
			if($dtdefault->Flag_HasilTayangLangsung == "Y"){
				echo 'Hasil Ujian Tayang Langsung begitu ujian selesai';
			}else{
				echo 'Hasil ujian diumumkan kemudian';
			}
			?>
		</td>
	</tr>	
	<tr>
		<td valign="top" style="color:#00008B">Bisa Mundur Soal ?</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
		if($dtdefault->Flag_BisaMundur == 'Y'){
			echo 'Peserta ujian bisa mundur/ melihat soal sebelumnya ';
		}else{
			echo 'Tidak bisa mundur';
		}
		?></td>
	</tr>	
	<tr>
		<td valign="top" style="color:#00008B">Batasan Jumlah Soal</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
		if($dtdefault->Flag_JmlSoalTakTerbatas == "Y"){
			echo "Jumlah soal tak terbatas (akan keluar terus sepanjang range waktu)";
		}else{
			echo "Jumlah soal dibatasi sejumlah tertentu";
		}
		?></td>
	</tr>	
	<?php
		if($dtdefault->Flag_JmlSoalTakTerbatas == "N"){
	?>	
	<tr>
		<td valign="top" style="color:#00008B">Jumlah Soal Ujian</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jml_SoalUjian?></td>
	</tr>
	<?php
		}
	?>
	<tr>
		<td valign="top" style="color:#00008B">Beda Presentasi Antar Bab</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
			if($dtdefault->Flag_BedaPersentaseAntarBab == "N"){
				echo "Antar bab jumlah soalnya dianggap sama";
			}else{
				echo "Antar bab memiliki perbedaan persentase jumlah soalnya";
			}
		?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Durasi Ujian</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Lama_WaktuUjian?> /Menit</td>
	</tr>	
	<tr>
		<td valign="top" style="color:#00008B">Status Pengumuman Hasil Ujian</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
		if($dtdefault->Flag_TelahDiumumkan == 'N'){
			echo "Belum Diumumkan";
		}else{
			echo "Sudah Diumumkan";
		}?></td>
	</tr>	
	<tr>
		<td valign="top" style="color:#00008B">Tanggal Pengumuman</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_pengumuman)?></td>
	</tr>	
</table>