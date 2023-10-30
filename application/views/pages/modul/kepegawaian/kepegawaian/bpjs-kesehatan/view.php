  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab"><b>Informasi Pegawai</b></a></li>
      <li><a href="#tab_2" data-toggle="tab"><b>BPJS Kesehatan</b></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
		<table class="table table-bordered table-striped" style="width: 100%">
		    <tr align="center">
        		<td valign="top" colspan="3"><?=($dtdefault->foto!= null)? '<img src="'.base_url("uploads/photo/pegawai/".$dtdefault->foto).'" width="170px" height="170px"></img>' : '<code>N/A</code>';?></td>
        	</tr>
			<tr>
        		<td valign="top" style="color:#00008B" width="200px">NIK</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->nik?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Nama Lengkap</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=$dtdefault->nama_pegawai?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Jenis Kelamin</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->jenis_kelamin?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Jabatan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->jabatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Kota Lahir</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->kota_lahir?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Tanggal Lahir</td>
        		<td valign="top">:</td>
        		<td valign="top"><?=tgl_indo($dtdefault->tgl_lahir)?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Alamat</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->alamat?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Strata Pendidikan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->strata_pendidikan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Bidang Pendidikan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->bidang_pendidikan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Jumlah Anak</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->jml_anak?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Email Pegawai</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->email?></td>
        	</tr>	
		</table>        
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="tab_2">
        <table class="table table-bordered table-striped" style="width: 100%">
        	<tr>
        		<td valign="top" style="color:#00008B" width="200px">Nomor BPJS</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->no_bpjs?></td>
        	</tr>	
        	<tr>
        		<td valign="top" style="color:#00008B">Nomor Kartu Keluarga</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->nomor_kk?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Keterangan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->keterangan?></td>
        	</tr>	
		</table>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
