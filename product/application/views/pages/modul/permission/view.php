<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="color:#00008B">Nama Permission</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->name?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Pada Menu</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getmenuname($dt->idmenu)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Slug code</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><code><?=$dt->label?></code></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Keterangan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->description?></td>
	</tr>
</table>