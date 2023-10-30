<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="color:#00008B">Full Name</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt1->fullname?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Username</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->username?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Password</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$this->encryption->decrypt($dt->password)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Email</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dt->email?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Role/Peran</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=getrolename($dt->iduser)?></td>
	</tr>
</table>