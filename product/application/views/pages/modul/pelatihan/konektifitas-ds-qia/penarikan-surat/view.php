  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab"><b>Informasi Peserta</b></a></li>
      <li><a href="#tab_2" data-toggle="tab"><b>Penarikan Surat Placement</b></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
		<table class="table table-bordered table-striped" style="width: 100%">
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
        <?php
            if($dtdefault->No_Surat_Placement == null){ ?>
        
            <table class="table table-bordered table-striped" style="width: 100%">
                <tr>
    				<td colspan="3" style="color:#9900cc" align="center">- <b><i>Belum ada penarikan surat</i></b> - </td>
    			</tr>
    		</table>
        <?php
            } elseif($dtdefault->Syarat_Placement_1 != null) { ?>
         
        <table class="table table-bordered table-striped" style="width: 100%">
            <?php
                $ket = "";
                if($dtdefault->Flag_SuratPlacement_TelahTerbit == "N"){
                    $ket = "Belum Terbit";
                }
                if($dtdefault->Flag_SuratPlacement_TelahTerbit == "Y"){
                    $ket = "Sudah Terbit";
                }
            ?>
			<tr>
				<td valign="top" style="color:#00008B;width:200px">Status Surat Placement</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$ket?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Tanggal Penarikan / Entry</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_Tarik_SuratPlacement)?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Nomor Surat Placement</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->No_Surat_Placement?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Tanggal Surat Placement</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_SuratPlacement)?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Ditempatkan Ditingkatan Kelas</td>
				<td valign="top">:</td>
				<?php
					$ket2 = "";
					if($dtdefault->Ditempatkan_diTingkatanKelas == "A"){
						$ket2 = "Dasar 1";
					}
					elseif($dtdefault->Ditempatkan_diTingkatanKelas == "B"){
						$ket2 = "Dasar 2";
					}
					elseif($dtdefault->Ditempatkan_diTingkatanKelas == "C"){
						$ket2 = "Lanjutan 1";
					}
					elseif($dtdefault->Ditempatkan_diTingkatanKelas == "D"){
						$ket2 = "Lanjutan 2";
					}
					elseif($dtdefault->Ditempatkan_diTingkatanKelas == "E"){
						$ket2 = "Manajerial";
					}
					elseif($dtdefault->Ditempatkan_diTingkatanKelas == "AA"){
						$ket2 = "DASAR";
					}
					elseif($dtdefault->Ditempatkan_diTingkatanKelas == "BB"){
						$ket2 = "LANJUTAN";
					}
					elseif($dtdefault->Ditempatkan_diTingkatanKelas == "CC"){
						$ket2 = "MANAJERIAL";
					}
				?>
				<td valign="top" style="color:#9900cc"><?=$ket2?></td>
			</tr>
			<?php
                if($dtdefault->Syarat_Placement_1 != null){ ?>
			<tr>
				<td valign="top" style="color:#00008B">Syarat Placement 1</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Syarat_Placement_1?></td>
			</tr>
			<?php } ?>
			
			<?php
                if($dtdefault->Syarat_Placement_2 != null){ ?>
			<tr>
				<td valign="top" style="color:#00008B">Syarat Placement 2</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Syarat_Placement_2?></td>
			</tr>
			<?php } ?>
			
			<?php
                if($dtdefault->Syarat_Placement_3 != null){ ?>
			<tr>
				<td valign="top" style="color:#00008B">Syarat Placement 3</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Syarat_Placement_3?></td>
			</tr>
			<?php } ?>
			
			<?php
                if($dtdefault->Syarat_Placement_4 != null){ ?>
			<tr>
				<td valign="top" style="color:#00008B">Syarat Placement 4</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Syarat_Placement_4?></td>
			</tr>
			<?php } ?>
			
			<?php
                if($dtdefault->Syarat_Placement_5 != null){ ?>
			<tr>
				<td valign="top" style="color:#00008B">Syarat Placement 5</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Syarat_Placement_5?></td>
			</tr>
			<?php } ?>
			<tr>
				<td valign="top" style="color:#00008B">File Surat Placement</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc">
				    <?php
            		    
            		    if($dtdefault->Path_SuratPlacement != null){
		                    $data = $dtdefault->Path_SuratPlacement;
		                    if(file_exists("./uploads/fileapps/dsqia/".$data)){
		                      echo '<a href="'.base_url("./uploads/fileapps/dsqia/".$data).'" download > <i class="fa fa-download"></i> download file</a>';
		                    }else{
		                      $data = explode(',',$data);
		                      $rs = '';
		                      foreach ($data as $key => $value) {
		                        $dt = $this->db->where(array('idmeta'=>$value,'sourcefile'=>'penarikan_placement'))->get('meta_file_new')->row();
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
		<?php
            }
        ?>
      </div>
      <!-- /.tab-pane -->
    </div>
    <!-- /.tab-content -->
  </div>
  <!-- nav-tabs-custom -->
