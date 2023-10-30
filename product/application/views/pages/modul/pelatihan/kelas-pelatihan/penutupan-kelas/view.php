<table class="table table-bordered table-striped" style="width: 100%">
		    <tr>
        		<td valign="top" width="200px" style="color:#00008B">Nama Kelas & Angkatan (Baku)</td>
        		<td valign="top" width="20px">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->DescBaku_Kelas_n_Angkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Nama Kelas & Angkatan (Ketikan Bebas)</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->DescBebas_Kelas_n_Angkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Jenis Pelatihan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_JenisPelatihan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Perusahaan / Instansi</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_PershInstansi?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Angkatan Ke</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->No_Urut_Angkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Kode Singkatan Kelas tsb.</td>
        		<td valign="top">:</td>
        		<?php
                    $kode = "-";
                    if($dtdefault->KODE_Singkatan != null){
                        $kode = $dtdefault->KODE_Singkatan;
                    }
                ?>
        		<td valign="top" style="color:#9900cc"><?=$kode?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Kota Tempat Pelatihan</td>
        		<td valign="top">:</td>
        		<?php
                    $kota = "-";
                    if($dtdefault->Desc_KotaTraining != null){
                        $kota = $dtdefault->Desc_KotaTraining;
                    }
                ?>
        		<td valign="top" style="color:#9900cc"><?=$kota?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Lokasi Penyelenggaraan</td>
        		<td valign="top">:</td>
        		<?php
                    $lokasi = "-";
                    if($dtdefault->LokasiPenyelenggaraan != null){
                        $lokasi = $dtdefault->LokasiPenyelenggaraan;
                    }
                ?>
        		<td valign="top" style="color:#9900cc"><?=$lokasi?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Jumlah Peserta</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jml_Peserta?> Peserta</td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Tanggal Mulai</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_Mulai_Aktual)?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Tanggal Selesai</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_Selesai_Aktual)?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Lama Hari Pelatihan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->LamaHariPelatihan?> Hari</td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Status Kelas Saat ini</td>
        		<td valign="top">:</td>
        		<?php
        			$selesai = "";
        			if($dtdefault->Flag_Selesai == "B"){
        				$selesai = "Kelas Belum Dimulai";
        			}
        			elseif($dtdefault->Flag_Selesai == "L"){
        				$selesai = "Kelas Sedang Berlangsung";
        			}
        			elseif($dtdefault->Flag_Selesai == "E"){
        				$selesai = "Kelas Sudah Berakhir";
        			}
        			elseif($dtdefault->Flag_Selesai == "C"){
        				$selesai = "Kelas Sudah Ditutup";
        			}
        		?>
        		<td valign="top" style="color:#9900cc"><?=$selesai?></td>
        	</tr>
        </table>  