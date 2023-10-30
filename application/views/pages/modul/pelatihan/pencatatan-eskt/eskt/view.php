<?php
    $saran = "";
    $komplain = "";
    $tl1 = "";
    $tl2 = "";
    
    if($dtdefault->Isi_Saran==null) {
        $saran = "-";
    } else $saran = $dtdefault->Isi_Saran;
    
    if($dtdefault->Isi_Komplain==null) {
        $komplain = "-";
    } else $komplain = $dtdefault->Isi_Komplain;
    
    if($dtdefault->Isi_TL_yg_sudah_dilakukan==null) {
        $tl1 = "Belum Ada Tindak Lanjut";
    } else $tl1 = $dtdefault->Isi_TL_yg_sudah_dilakukan;
    
    if($dtdefault->Isi_TL_yg_akan_dilakukan==null) {
        $tl2 = "Belum Ada Tindak Lanjut";
    } else $tl2 = $dtdefault->Isi_TL_yg_akan_dilakukan;
?>
<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" width="200px" style="color:#00008B">Nama Peserta</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->NamaLengkap_DgnGelar?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Isi Saran</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$saran?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Isi Komplain</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$komplain?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tindak Lanjut Yang Sudah Dilakukan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$tl1?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tindak Lanjut Yang Akan Dilakukan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$tl2?></td>
	</tr>
</table>