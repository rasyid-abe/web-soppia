<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" width="200px">Nama Instruktur</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getnamainstruktur($dtdefault->FId_InstrukturNgajar_diKelas)?></td>
	</tr>
	<tr>
		<td valign="top">Nama Peserta</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getnamapeserta($dtdefault->FId_Peserta)?></td>
	</tr>
	<tr>
		<td valign="top">Jawaban Eval 1</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
		if($dtdefault->Jwb_Eval1 == "T"){
			echo "Tidak";
		}else if($dtdefault->Jwb_Eval1 == "Y"){
			echo "Ya";
		}else if($dtdefault->Jwb_Eval1 == "S"){
			echo "Sangat Sesuai";
		}else{
			echo "<code>N/A</code>";
		}
		?></td>
	</tr>
	<tr>
		<td valign="top">Jawaban Eval 2</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
			if($dtdefault->Jwb_Eval2 == "T"){
				echo "Terlalu Banyak Kuliah";
			}else{
				echo "Seimbang";
			}
		?></td>
	</tr>
	<tr>
		<td valign="top">Jawaban Eval 3</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc">
			<?php
				echo getjwbeval($dtdefault->Jwb_Eval3);
			?>
		</td>
	</tr>
	<tr>
		<td valign="top">Jawaban Eval 4</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getjwbeval($dtdefault->Jwb_Eval4)?></td>
	</tr>
	<tr>
		<td valign="top">Jawaban Eval 5</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getjwbeval($dtdefault->Jwb_Eval5)?></td>
	</tr>
	<tr>
		<td valign="top">Jawaban Eval 6</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getjwbeval($dtdefault->Jwb_Eval6)?></td>
	</tr>
	<tr>
		<td valign="top">Jawaban Eval 7</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getjwbeval($dtdefault->Jwb_Eval7)?></td>
	</tr>	
	<tr>
		<td valign="top">Jawaban Eval 8</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getjwbeval($dtdefault->Jwb_Eval8)?></td>
	</tr>	
	<tr>
		<td valign="top">Jawaban Eval 9</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getjwbeval($dtdefault->Jwb_Eval9)?></td>
	</tr>	
	<tr>
		<td valign="top">Saran Eval</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Saran_Eval;?></td>
	</tr>
</table>