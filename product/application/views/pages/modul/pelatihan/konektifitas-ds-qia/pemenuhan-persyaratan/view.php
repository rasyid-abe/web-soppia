  <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#tab_1" data-toggle="tab"><b>Informasi Peserta</b></a></li>
      <li><a href="#tab_2" data-toggle="tab"><b>Pemenuhan Persyaratan Placement</b></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane active" id="tab_1">
		<table class="table table-bordered table-striped" style="width: 100%">
			<tr>
				<td valign="top" style="color:#00008B">Nama Peserta</td>
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
            if($dtdefault->Syarat_Placement_1 == null){ ?>
        
            <table class="table table-bordered table-striped" style="width: 100%">
                <tr>
    				<td colspan="3" style="color:#9900cc" align="center">- <b><i>Belum ada persyaratan</i></b> - </td>
    			</tr>
    		</table>
        <?php
            } elseif($dtdefault->Syarat_Placement_1 != null) { ?>
        
        <table class="table table-bordered table-striped" style="width: 100%">
            <?php
                if($dtdefault->Syarat_Placement_1 != null){ ?>
            <tr>
				<td valign="top" style="color:#00008B">Syarat Placement 1</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Syarat_Placement_1?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Pemenuhan Syarat 1</td>
				<td valign="top">:</td>
				<?php
				    $flag1 = "";
				    if($dtdefault->Flag_Syarat_Placement1_Dipenuhi == 'N'){
				        $flag1 = "Belum Dipenuhi";
				    } 
				    elseif ($dtdefault->Flag_Syarat_Placement1_Dipenuhi == 'Y') {
				        $flag1 = "Sudah Dipenuhi";
				    }
				?>
				<td valign="top" style="color:#9900cc"><?=$flag1?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Path Lampiran 1</td>
				<td valign="top">:</td>
				<?php
				    $file1 = '<a href="'.base_url('uploads/fileapps/dsqia/'.$dtdefault->Path_LampPemenuhanSyarat1).'" download><i class="fa fa-download"></i> Download</a>';
				    if($dtdefault->Path_LampPemenuhanSyarat1 == "Belum Ada Data" or $dtdefault->Path_LampPemenuhanSyarat1 == null){
				        $file1 = '<code>N/A</code>';
				    }
				?>
				<td valign="top"><?=$file1?></td>
			</tr>
			<?php } ?>
			
			<?php
                if($dtdefault->Syarat_Placement_2 != null){ ?>
			<tr>
				<td valign="top" style="color:#00008B">Syarat Placement 2</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Syarat_Placement_2?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Pemenuhan Syarat 2</td>
				<td valign="top">:</td>
				<?php
				    $flag2 = "";
				    if($dtdefault->Flag_Syarat_Placement2_Dipenuhi == 'N'){
				        $flag2 = "Belum Dipenuhi";
				    } 
				    elseif ($dtdefault->Flag_Syarat_Placement2_Dipenuhi == 'Y') {
				        $flag2 = "Sudah Dipenuhi";
				    }
				?>
				<td valign="top" style="color:#9900cc"><?=$flag2?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Path Lampiran 2</td>
				<td valign="top">:</td>
				<?php
				    $file2 = '<a href="'.base_url('uploads/fileapps/dsqia/'.$dtdefault->Path_LampPemenuhanSyarat2).'" download><i class="fa fa-download"></i> Download</a>';
				    if($dtdefault->Path_LampPemenuhanSyarat2 == "Belum Ada Data" or $dtdefault->Path_LampPemenuhanSyarat2 == null){
				        $file2 = '<code>N/A</code>';
				    }
				?>
				<td valign="top"><?=$file2?></td>
			</tr>
			<?php } ?>
			
			<?php
                if($dtdefault->Syarat_Placement_3 != null){ ?>
			<tr>
				<td valign="top" style="color:#00008B">Syarat Placement 3</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Syarat_Placement_3?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Pemenuhan Syarat 3</td>
				<td valign="top">:</td>
				<?php
				    $flag3 = "";
				    if($dtdefault->Flag_Syarat_Placement3_Dipenuhi == 'N'){
				        $flag3 = "Belum Dipenuhi";
				    } 
				    elseif ($dtdefault->Flag_Syarat_Placement3_Dipenuhi == 'Y') {
				        $flag3 = "Sudah Dipenuhi";
				    }
				?>
				<td valign="top"><?=$flag3?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Path Lampiran 3</td>
				<td valign="top">:</td>
				<?php
				    $file3 = '<a href="'.base_url('uploads/fileapps/dsqia/'.$dtdefault->Path_LampPemenuhanSyarat3).'" download><i class="fa fa-download"></i> Download</a>';
				    if($dtdefault->Path_LampPemenuhanSyarat3 == "Belum Ada Data" or $dtdefault->Path_LampPemenuhanSyarat3 == null){
				        $file3 = '<code>N/A</code>';
				    }
				?>
				<td valign="top"><?=$file3?></td>
			</tr>
			<?php } ?>
			
			<?php
                if($dtdefault->Syarat_Placement_4 != null){ ?>
			<tr>
				<td valign="top" style="color:#00008B">Syarat Placement 4</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Syarat_Placement_4?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Pemenuhan Syarat 4</td>
				<td valign="top">:</td>
				<?php
				    $flag4 = "";
				    if($dtdefault->Flag_Syarat_Placement4_Dipenuhi == 'N'){
				        $flag4 = "Belum Dipenuhi";
				    } 
				    elseif ($dtdefault->Flag_Syarat_Placement4_Dipenuhi == 'Y') {
				        $flag4 = "Sudah Dipenuhi";
				    }
				?>
				<td valign="top"><?=$flag4?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Path Lampiran 4</td>
				<td valign="top">:</td>
				<?php
				    $file4 = '<a href="'.base_url('uploads/fileapps/dsqia/'.$dtdefault->Path_LampPemenuhanSyarat4).'" download><i class="fa fa-download"></i> Download</a>';
				    if($dtdefault->Path_LampPemenuhanSyarat4 == "Belum Ada Data" or $dtdefault->Path_LampPemenuhanSyarat4 == null){
				        $file4 = '<code>N/A</code>';
				    }
				?>
				<td valign="top"><?=$file4?></td>
			</tr>
			<?php } ?>
			
			<?php
                if($dtdefault->Syarat_Placement_5 != null){ ?>
			<tr>
				<td valign="top" style="color:#00008B">Syarat Placement 5</td>
				<td valign="top">:</td>
				<td valign="top" style="color:#9900cc"><?=$dtdefault->Syarat_Placement_5?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Pemenuhan Syarat 5</td>
				<td valign="top">:</td>
				<?php
				    $flag5 = "";
				    if($dtdefault->Flag_Syarat_Placement5_Dipenuhi == 'N'){
				        $flag5 = "Belum Dipenuhi";
				    } 
				    elseif ($dtdefault->Flag_Syarat_Placement5_Dipenuhi == 'Y') {
				        $flag5 = "Sudah Dipenuhi";
				    }
				?>
				<td valign="top"><?=$flag5?></td>
			</tr>
			<tr>
				<td valign="top" style="color:#00008B">Path Lampiran 5</td>
				<td valign="top">:</td>
				<?php
				    $file5 = '<a href="'.base_url('uploads/fileapps/dsqia/'.$dtdefault->Path_LampPemenuhanSyarat5).'" download><i class="fa fa-download"></i> Download</a>';
				    if($dtdefault->Path_LampPemenuhanSyarat5 == "Belum Ada Data" or $dtdefault->Path_LampPemenuhanSyarat5 == null){
				        $file5 = '<code>N/A</code>';
				    }
				?>
				<td valign="top"><?=$file5?></td>
			</tr>
			<?php } ?>
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
