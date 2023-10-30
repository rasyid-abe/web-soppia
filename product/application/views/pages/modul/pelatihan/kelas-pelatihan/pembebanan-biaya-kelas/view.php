  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab">Informasi Kelas</a></li>
      <li><a href="#tab_2" data-toggle="tab">Pembebanan Biaya</a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
		<table class="table table-bordered table-striped" style="width: 100%">
			<tr>
				<td valign="top" style="width:200px">Kelas & Angkatan</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->DescBaku_Kelas_n_Angkatan?></td>
			</tr>	
			<tr>
				<td valign="top">Kode Singkatan</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->KODE_Singkatan?></td>
			</tr>
			<tr>
				<td valign="top">Lokasi</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->LokasiPenyelenggaraan?></td>
			</tr>				
			<tr>
				<td valign="top">Jumlah Peserta</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Jml_Peserta?> Peserta</td>
			</tr>	
			<tr>
				<td valign="top">Tanggal Mulai</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Tgl_Mulai_Aktual?></td>
			</tr>
			<tr>
				<td valign="top">Tanggal Selesai</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Tgl_Selesai_Aktual?></td>
			</tr>	
			<tr>
				<td valign="top">Lama Hari</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->LamaHariPelatihan?> Hari</td>
			</tr>			
		</table>        
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="tab_2">
        <table class="table table-bordered table-striped" style="width: 100%">
			<tr>
				<td valign="top" style="200px">Tanggal Transaksi</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Tgl_Transaksi?></td>
			</tr>
			<tr>
				<td valign="top">Deskripsi Transaksi</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_Transaksi?></td>
			</tr>
			<tr>
				<td valign="top">Sub Account</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_Account?></td>
			</tr>
			<tr>
				<td valign="top">Debet / Kredit</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Flag_D_or_K?></td>
			</tr>
			<tr>
				<td valign="top">Nilai (Rp)</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc">Rp. <?=number_format($dtdefault->Nilai_Rp)?></td>
			</tr>
			<tr>
				<td valign="top">Proforma / Kelas</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Flag_Proforma_or_Kelas?></td>
			</tr>
			<tr>
				<td valign="top">Deskripsi Proforma</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_ProformaKontrak?></td>
			</tr>
			<tr>
				<td valign="top">Perusahaan / Instansi</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_PershInstansi?></td>
			</tr>
			<tr>
				<td valign="top">Keterangan</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Keterangan?></td>
			</tr>
		</table>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
