  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab">Proforma Kontrak</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
		<table class="table table-bordered table-striped" style="width: 100%">			
			<tr>
				<td valign="top" style="width:200px">Perusahaan / Instansi</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_PershInstansi?></td>
			</tr>			
			<tr>
				<td valign="top">Proforma Kesepakatan Pelatihan</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_ProformaKontrak?></td>
			</tr>	
			<tr>
				<td valign="top">Nilai (Rp)</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc">Rp. <?=number_format($dtdefault->Nilai_Rp)?></td>
			</tr>				
			<tr>
				<td valign="top">Rencana Jumlah Peserta</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Rencana_JmlPeserta?></td>
			</tr>	
			<tr>
				<td valign="top">Rencana Tempat Pelatihan</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Rencana_TempatSelenggara?></td>
			</tr>			
		</table>        
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
