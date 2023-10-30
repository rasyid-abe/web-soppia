<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="width:200px;color:#00008B">Instruktur</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
		$getinst = $this->db->where(array('Id_Instruktur'=>$dtdefault->FId_Instruktur))->get('mst_instruktur');
		if($getinst->num_rows()>0){
			$inst = $getinst->row()->NamaLengkap_DgnGelar;
			if($inst == ''){
				$inst = $getinst->row()->NamaLengkap_TanpaGelar;		
				if($inst == ''){
					$inst = $getinst->row()->NamaPanggilan;	
				}		
			}
		}else{
			$inst = '-';
		}
		echo $inst;
		?></td>
	</tr>
	<tr>
		<td valign="top" style="width:200px;color:#00008B">Materi</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
			$getmateri = $this->db->where(array('Kd_Materi_n_Aktifitas'=>$dtdefault->FKd_Materi_n_Aktifitas))->get("mst_materi_n_aktifitas");
			if($getmateri->num_rows()>0){
				$materi = $getmateri->row()->Desc_Materi_n_Aktifitas;
				if($materi == ''){
					$materi = $getmateri->row()->Singkatan;		
				}
			}else{
				$materi = '-';
			}
			echo $materi;			
		?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Sub Bab</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
		$getsubbab = $this->db->where(array('Kd_SubBab'=>$dtdefault->FKd_SubBab))->get('mst_materi_subbab');
		if($getsubbab->num_rows()>0){
			$subbab = $getsubbab->row()->Desc_SubBab;
		}else{
			$subbab = '-';
		}
		echo $subbab;
		?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Soal</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Isi_PertanyaanSoal?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Pilihan Jabawan A</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jawab_Point_a?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Pilihan Jabawan B</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jawab_Point_b?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Pilihan Jabawan C</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jawab_Point_c?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Pilihan Jabawan D</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jawab_Point_d?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Pilihan Jabawan E</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jawab_Point_e?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Jawaban Benar</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jawab_yg_Benar?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tingat Kesulitan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Tingkat_Kesulitan?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Penjelasan Jawaban</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Penjelasan_Jawaban?></td>
	</tr>	
	<tr>
		<td valign="top" style="color:#00008B">Lampiran Gambar</td>
		<td valign="top">:</td>
		<td valign="top" colspan="3"><?=($dtdefault->Path_FileLampiran!= null)? '<img src="'.base_url("uploads/soal/".$dtdefault->Path_FileLampiran).'" width="170px" height="170px"></img>' : '<code>N/A</code>';?></td>
	</tr>
</table>