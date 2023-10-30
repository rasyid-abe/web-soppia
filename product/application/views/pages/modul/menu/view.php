<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="color:#00008B">Nama Menu</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->name?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Parent Menu</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getmenuname($dt->parent)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Url</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->url?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Icon</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=($dt->icon =='' || $dt->icon == null)?'':'<i class="'.$dt->icon.'"></i>';?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Label</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getlabelname($dt->labelmenu)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Aktif</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=($dt->active == '1')?'Ya':'Tidak';?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Keterangan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->description?></td>
	</tr>
</table>