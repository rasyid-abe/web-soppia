  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab"><b>Informasi Peserta</b></a></li>
      <li><a href="#tab_2" data-toggle="tab"><b>Permohonan Placement</b></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
		<table class="table table-bordered table-striped" style="width: 100%">
		    <tr align="center">
        		<td valign="top" colspan="3"><?=($dtdefault->FilePhoto!= null)? '<img src="'.base_url("uploads/photo/".$dtdefault->FilePhoto).'" width="170px" height="170px"></img>' : '<code>N/A</code>';?></td>
        	</tr>
        	<tr>
				<td valign="top" style="color:#00008B;width:200px">NIK Peserta</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->NIK?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B;width:200px">Nama Peserta</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->NamaLengkap_TanpaGelar?></td>
			</tr>	
			<tr>
				<td valign="top" style="color:#00008B">Nama Perusahaan</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->NamaPershInstansi?></td>
			</tr>				
			<tr>
				<td valign="top" style="color:#00008B">Nama Jabatan</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Jabatan_NamaUnitOrganisasi?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Alamat Kantor</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Alamat_Kantor?></td>
			</tr>	
			<tr>
				<td valign="top" style="color:#00008B">Nomor HP</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->No_HP?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Email Peserta</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->eMail_Pribadi?></td>
			</tr>	
		</table>        
      </div>
      <!-- /.tab-pane -->
      <div class="tab-pane" id="tab_2">
        <table class="table table-bordered table-striped" style="width: 100%">
			<tr>
				<td valign="top" style="color:#00008B">Pernah Pelatihan QIA</td>
				<td valign="top">:</td>
				<?php
					$ket = "";
					if($dtdefault->Flag_PernahPelatihanQIASebelumnya == "Y"){
						$ket = "Pernah Ikut Pelatihan";
					}
					elseif($dtdefault->Flag_PernahPelatihanQIASebelumnya == "N"){
						$ket = "Belum Pernah Ikut Pelatihan";
					}
				?>
				<td valign="top" style="color:#9900cc"><?=$ket?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Kelas QIA</td>
				<td valign="top">:</td>
				<?php
					$ket2 = "";
					if($dtdefault->StatusKelasQIA_SaatIni == "Z"){
						$ket2 = "---";
					}
					elseif($dtdefault->StatusKelasQIA_SaatIni == "A"){
						$ket2 = "Dasar 1";
					}
					elseif($dtdefault->StatusKelasQIA_SaatIni == "B"){
						$ket2 = "Dasar 2";
					}
					elseif($dtdefault->StatusKelasQIA_SaatIni == "C"){
						$ket2 = "Lanjutan 1";
					}
					elseif($dtdefault->StatusKelasQIA_SaatIni == "D"){
						$ket2 = "Lanjutan 2";
					}
					elseif($dtdefault->StatusKelasQIA_SaatIni == "E"){
						$ket2 = "Manajerial";
					}
					elseif($dtdefault->StatusKelasQIA_SaatIni == "AA"){
						$ket2 = "DASAR";
					}
					elseif($dtdefault->StatusKelasQIA_SaatIni == "BB"){
						$ket2 = "LANJUTAN";
					}
					elseif($dtdefault->StatusKelasQIA_SaatIni == "CC"){
						$ket2 = "MANAJERIAL";
					}
				?>
				<td valign="top" style="color:#9900cc"><?=$ket2?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Tanggal Kirim CV</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_Kirim_CV)?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Path CV Peserta</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc">
				    <?php            		    
		                  if($dtdefault->Path_CV_Peserta != null){
		                    $data = $dtdefault->Path_CV_Peserta;
		                    if(file_exists("./uploads/fileapps/dsqia/".$data)){
		                      echo '<a href="'.base_url("./uploads/fileapps/dsqia/".$data).'" download > <i class="fa fa-download"></i> download file</a>';
		                    }else{
		                      $data = explode(',',$data);
		                      $rs = '';
		                      foreach ($data as $key => $value) {
		                        $dt = $this->db->where(array('idmeta'=>$value,'sourcefile'=>'pengantar_placement'))->get('meta_file_new')->row();
		                        $rs .= '<a href="'.base_url("./uploads/fileapps/dsqia/".$dt->namefile).'" download > <i class="fa fa-download"></i> download file '.($key+1).'</a><br/>';
		                      }
		                      echo $rs;
		                    }
		                  }else{
		                    echo '<code>N/A</code>';
		                  }
            	    ?>
				</td>
			</tr>
		</table>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
