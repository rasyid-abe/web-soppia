<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="color:#00008B">Nama Role/Peran</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->name?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Keterangan Role/Peran</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->description?></td>
	</tr>
</table>
<?php
    if($timelog->num_rows()>0){
?>
<hr/>
<table class="table table-bordered table-striped" style="width: 100%">
    <tr>
        <td colspan="2">
            <b>Waktu Akses Kesistem</b>
        </td>
    </tr>
    <?php
        if($timelog->row()->status == "Y"){
    ?>
	<tr>
		<td valign="top"  colspan="2" style="color:#9900cc">
		    Dapat Mengakses Sistem Setiap Saat dan kapanpun.
		</td>
	</tr>
	<?php
        }else if($timelog->row()->status == "HW"){
            $dayList = array(
            	'Sun' => 'Minggu',
            	'Mon' => 'Senin',
            	'Tue' => 'Selasa',
            	'Wed' => 'Rabu',
            	'Thu' => 'Kamis',
            	'Fri' => 'Jumat',
            	'Sat' => 'Sabtu'
            ); 
            foreach(unserialize($timelog->row()->day) as $key => $dy){
        ?>
    	<tr>
    		<td valign="top" style="color:#00008B">
    		    <?=$dayList[$dy]?>
    		</td>
    		<td valign="top" style="color:#9900cc">
    		    <?=unserialize($timelog->row()->time)[$key]["timestart"][$dy]?> - 
    		    <?=unserialize($timelog->row()->time)[$key]["timeend"][$dy]?>
    		</td>
    	</tr>
            
        <?php       
            }
        }else if($timelog->row()->status == "TW"){
        ?>
        <tr>
    		<td valign="top" style="color:#00008B">
    		    <?=tgl_indo($timelog->row()->datestart)?> - 
    		    <?=tgl_indo($timelog->row()->dateend)?>
    		</td>
    		<td valign="top" style="color:#9900cc">
    		    <?=unserialize($timelog->row()->time)[0]["timestart"]?> - 
    		    <?=unserialize($timelog->row()->time)[0]["timeend"]?>
    		</td>
    	</tr>
        <?php
        }else{
            
        }
	?>
</table>
<?php
    }else{
?>

<?php
    }
?>