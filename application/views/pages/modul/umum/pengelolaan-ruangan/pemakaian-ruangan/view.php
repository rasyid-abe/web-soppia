  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab"><b>Informasi Ruangan</b></a></li>
      <li><a href="#tab_2" data-toggle="tab"><b>Informasi Pemakaian</b></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
		<table class="table table-bordered table-striped" style="width: 100%">
        	<tr>
        		<td valign="top" style="color:#00008B" width="200px">Nama Ruangan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_RuangLantai?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Nomor Lantai</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->No_Lantai?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Keterangan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->Keterangan?></td>
        	</tr>
		</table>        
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="tab_2">
        <table class="table table-bordered table-striped" style="width: 100%">
			<tr>
        		<td valign="top" style="color:#00008B" width="200px">Tanggal Mulai</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->tgl_mulai)?></td>
        	</tr>	
        	<tr>
        		<td valign="top" style="color:#00008B">Tanggal Selesai</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->tgl_selesai)?></td>
        	</tr>	
        	<tr>
        		<td valign="top" style="color:#00008B">Penanggung Jawab</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->petugas?></td>
        	</tr>	
        	<tr>
        		<td valign="top" style="color:#00008B">Keterangan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->keterangan_pakai?></td>
        	</tr>	
		</table>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
