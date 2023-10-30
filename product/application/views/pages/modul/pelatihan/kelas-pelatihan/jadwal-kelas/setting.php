<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<!--<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net/buttons.dataTables.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")?>">-->
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/style/print.min.css")?>">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$titlepage?>
    <small><?=$subtitlepage?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a ><?=$breadcrumb2?></a></li>
    <li class="active"><?=$breadcrumb3?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <?php if($this->session->flashdata('error')){ ?>
    <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
  <?php }else if($this->session->flashdata('success')){ ?>
    <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
  <?php } ?>

  <!-- Default box -->
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$titlebox?></h3>

      <div class="box-tools pull-right">
        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip" title="Kembali Ke Manage <?=$subtitlepage?>"><i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i> Refresh</button>
      </div>
    </div>
    <div class="box-body">
          <!-- Custom Tabs -->
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <?php
            if($this->session->userdata("tab_active")){
                $tab1 = '';
                $tab2 = 'active'; 
            }else{
                $tab1 = 'active';
                $tab2 = '';
            }
        ?>
      <li class="<?=$tab1?>"><a href="#tab_1" data-toggle="tab"><b>Informasi Kelas</b></a></li>
      <li class="<?=$tab2?>"><a href="#tab_2" data-toggle="tab"><b>Setting Jadwal & Materi & Instruktur</b></a></li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane <?=$tab1?>" id="tab_1">
		<table class="table table-bordered table-striped" style="width: 100%">
		    <tr>
        		<td valign="top" width="300" style="color:#00008B">Nama Kelas & Angkatan (Baku)</td>
        		<td valign="top" width="20">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->DescBaku_Kelas_n_Angkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Nama Kelas & Angkatan (Ketikan Bebas)</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->DescBebas_Kelas_n_Angkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Jenis Pelatihan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_JenisPelatihan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Perusahaan / Instansi</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_PershInstansi?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Angkatan Ke</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->No_Urut_Angkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Kode Singkatan Kelas tsb.</td>
        		<td valign="top">:</td>
        		<?php
                    $kode = "-";
                    if($dtdefault->KODE_Singkatan != null){
                        $kode = $dtdefault->KODE_Singkatan;
                    }
                ?>
        		<td valign="top" style="color:#9900cc"><?=$kode?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Kota Tempat Pelatihan</td>
        		<td valign="top">:</td>
        		<?php
                    $kota = "-";
                    if($dtdefault->Desc_KotaTraining != null){
                        $kota = $dtdefault->Desc_KotaTraining;
                    }
                ?>
        		<td valign="top" style="color:#9900cc"><?=$kota?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Lokasi Penyelenggaraan</td>
        		<td valign="top">:</td>
        		<?php
                    $lokasi = "-";
                    if($dtdefault->LokasiPenyelenggaraan != null){
                        $lokasi = $dtdefault->LokasiPenyelenggaraan;
                    }
                ?>
        		<td valign="top" style="color:#9900cc"><?=$lokasi?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Jumlah Peserta</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->Jml_Peserta?> Peserta</td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Tanggal Mulai</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_Mulai_Aktual)?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Tanggal Selesai</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_Selesai_Aktual)?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Lama Hari Pelatihan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$dtdefault->LamaHariPelatihan?> Hari</td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Status Kelas Saat ini</td>
        		<td valign="top">:</td>
        		<?php
        			$selesai = "";
        			if($dtdefault->Flag_Selesai == "B"){
        				$selesai = "Kelas Belum Dimulai";
        			}
        			elseif($dtdefault->Flag_Selesai == "L"){
        				$selesai = "Kelas Sedang Berlangsung";
        			}
        			elseif($dtdefault->Flag_Selesai == "E"){
        				$selesai = "Kelas Sudah Berakhir";
        			}
        			elseif($dtdefault->Flag_Selesai == "C"){
        				$selesai = "Kelas Sudah Ditutup";
        			}
        		?>
        		<td valign="top" style="color:#9900cc"><?=$selesai?></td>
        	</tr>
        </table>        
      </div> <!-- /.tab-pane 1 -->
      
      <div class="tab-pane <?=$tab2?>" id="tab_2">
        <div class="container-fluid">
            <?php //echo form_open($this->uri->segment(1).'/'.$this->uri->segment(2)."/store/".$id);?>
            <?php
                $count = (int)$dtdefault->LamaHariPelatihan;
                $cekdb = $this->db->where(array('FId_Kelas_n_Angkatan'=>$dtdefault->Id_Kelas_n_Angkatan))->order_by("No_Urut_Hari","ASC")->order_by("No_Urut_Sesi","ASC")->get("tre_pembukaankelas_n_angkatan_sesi");
                $cekdb1 = $this->db->select("any_value(No_Urut_Hari) as No_Urut_Hari")->where(array('FId_Kelas_n_Angkatan'=>$dtdefault->Id_Kelas_n_Angkatan))->group_by("No_Urut_Hari")->get("tre_pembukaankelas_n_angkatan_sesi");
                
            ?>
            <table class="" style="width:100%">
                <tr>
                    <td class="text-right">
                        <button type="button" class="btn btn-xs btn-primary" id="wordbtn"><i class="fa fa-file-word-o"></i> Jadwal</button>
                        <button type="button" class="btn btn-xs btn-default" id="printbtn"><i class="fa fa-print"></i> Print Jadwal</button>
                        <!--<a class="btn btn-xs btn-warning"><i class="fa fa-file-excel-o"></i>Excel Jadwal</a>-->
                        <?php if(accessperm('pengaturan-data-jadwal-kelas')){ ?>
                            <?php //if($dtdefault->Flag_Selesai == "B"){ ?>
                                <!--<button class="btn btn-xs btn-primary" type="button" id="pengaturanbtn" data-count="0"><i class="fa fa-cog"></i> Pengaturan Jadwal</button>-->
                                <button class="btn btn-xs btn-warning" type="button" id="pengaturanbtnpaket" data-count="0"><i class="fa fa-cog"></i> Pengaturan Jadwal</button>
                            <?php //} ?>
                        <?php } ?>
                    </td>
                </tr>
            </table>
            <hr/>
            <div id="view-jadwal">
                
                <style type="text/css">
                table.customTable {
                  width: 100%;
                  background-color: #FFFFFF;
                  border-collapse: separate;
                  border-width: 1px;
                  border-color: #000000;
                  border-style: solid;
                  color: #000000;
                }
                table.customTable td, table.customTable th {
                  border-width: 1px;
                  border-color: #000000;
                  border-style: solid;
                  padding: 5px;
                }
                
                table.customTable thead {
                  background-color: #F8F837;
                }
                * {
                  -webkit-print-color-adjust: exact !important;
                }
                @media print{
                    table.customTable {
                      width: 100% !important;
                      background-color: #FFFFFF !important;
                      border-collapse: separate !important;
                      border-width: 0px !important;
                      border-color: #000000 !important;
                      border-style: solid !important;
                      color: #000000 !important;
                    }
                    table.customTable td, table.customTable th {
                      border-width: 1px !important;
                      border-color: #000000 !important;
                      border-style: solid !important;
                      padding: 5px !important;
                    }
                    
                    table.customTable thead {
                      background-color: #F8F837 !important;
                      
                    }
                }
                </style>
                <table width="100%">
                    <tr>
                        <td valign="middle" class="text-right" width="300">
                            <img src="<?=base_url("assets/images/soppia.png")?>" width="70" height="70" />
                        </td>
                        <td valign="middle" class="text-center" width="700">
                            <center>
                                <b><?=strtoupper('Jadwal Pelatihan')?></b><br>
                                <b style="font-size:16px"><?=$dtdefault->Desc_JenisPelatihan?></b><br>
                                <?php
                                    $tgl1 = date("d",strtotime($dtdefault->Tgl_Mulai_Aktual));
                                    $tgl2 = tgl_indo($dtdefault->Tgl_Selesai_Aktual);
                                    $bulan1 = date("m",strtotime($dtdefault->Tgl_Mulai_Aktual));
                                    $bulan2 = date("m",strtotime($dtdefault->Tgl_Selesai_Aktual));
                                    if($bulan1 != $bulan2){
                                        $tgl1 = tgl_indo($dtdefault->Tgl_Mulai_Aktual);
                                    }
                                ?>
                                <b>Angkatan ke-<?=$dtdefault->No_Urut_Angkatan?> (Tanggal <?=$tgl1?> s/d <?=$tgl2?>)</b>
                            </center>
                        </td>
                        <td valign="middle" width="300" class="text-left">
                            <!--<img src="<?=base_url("assets/images/soppia.png")?>" width="50" height="50" />-->
                        </td>
                    </tr>
                </table>
                <?=br(1)?>
                <table class='customTable' width="100%" id="tampilan-jadwal">
                    <thead>
                        <tr>
                            <th class="text-center" width="50"><?=strtoupper('No')?></th>
                            <th class="text-center" width="200"><?=strtoupper('Hari/Tanggal')?></th>
                            <th class="text-center" width="160"><?=strtoupper('Waktu')?></th>
                            <th class="text-center" width="300"><?=strtoupper('Materi')?></th>
                            <th class="text-center" width="300"><?=strtoupper('Instruktur')?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         if($cekdb->num_rows()> 0  ){
                            for($i=1;$i<=$count;$i++){
                                $c[$i] = 0;
                            }
                            foreach($cekdb->result() as $vl){
                                $c[$vl->No_Urut_Hari] = $c[$vl->No_Urut_Hari]+1;
                            ?>
                            <tr>
                                <?php
                                    $countersesi = $this->db->where(array('No_Urut_Hari'=>$vl->No_Urut_Hari,'FId_Kelas_n_Angkatan'=>$vl->FId_Kelas_n_Angkatan))->get("tre_pembukaankelas_n_angkatan_sesi");
                                    
                                if($c[$vl->No_Urut_Hari] < 2){
                                    if($countersesi->num_rows()>0){
                                        $rowspan = $countersesi->num_rows();
                                ?>
                                    <td rowspan="<?=$rowspan?>" class="text-center" valign="top" >
                                        <?php
                                            if($c[$vl->No_Urut_Hari] > 1){
                                            }else{
                                             echo '<b>'.$vl->No_Urut_Hari.'</b>'; 
                                            }
                                        ?>
                                    </td>
                                    <td rowspan="<?=$rowspan?>" valign="top" >
                                        <?php
                                            $dayList = array(
                                                '1' => 'Minggu',
                                                '2' => 'Senin',
                                                '3' => 'Selasa',
                                                '4' => 'Rabu',
                                                '5' => 'Kamis',
                                                '6' => 'Jumat',
                                                '7' => 'Sabtu'
                                              ); 
                                             $dayval = array(
                                                '1' => 'Sun',
                                                '2' => 'Mon',
                                                '3' => 'Tue',
                                                '4' => 'Wed',
                                                '5' => 'Thu',
                                                '6' => 'Fri',
                                                '7' => 'Sat'
                                              );
                                              $vltgl = $vl->Tgl ;
                                		        if($vltgl != ''|| $vltgl != null){
                                                    $timestamp = strtotime($vltgl);
                                                    $day = date('D', $timestamp);
                                                    $hari = array_keys($dayval,$day);
                                                    $hari = $dayList[$hari[0]];        
                                		        }else{
                                		            $hari = null;
                                		        }
                                            if($c[$vl->No_Urut_Hari] > 1){
                                            }else{ 
                                                echo '<b>'.strtoupper($hari).'</b>'.br(1);
                                                echo '<b>'.strtoupper(tgl_indo($vl->Tgl)).'</b>';
    
                                            }
                                        ?>
                                    </td>
                                <?php
                                    }
                                }else{
                                ?>
                                <?php
                                }
                                ?>
                                
                                <?php
                                    if($c[$vl->No_Urut_Hari] > 1){
                                        $style= "border-top:0px solid;";
                                        if( $c[$vl->No_Urut_Hari] == $countersesi->num_rows() ){
                                            $style .= "";
                                        }else{
                                            $style .= "border-bottom:0px solid;";
                                        }
                                    }else{
                                        if( $c[$vl->No_Urut_Hari] == $countersesi->num_rows() ){
                                            $style = '';
                                        }else{
                                            $style ='border-bottom:0px solid';
                                        }
                                    }
                                ?>
                                <td class="text-center" valign="top" style="<?=$style?>" >
                                    <?php
                                      foreach ($FKd_Sesi_Satuan->result() as $data) {
                                        if($vl->FKd_Sesi_Satuan==$data->Kd_Sesi_Satuan){
                                            echo $data->Desc_Sesi;
                                        }
                                      }
                                    ?>
                                </td>
                                <td valign="top" style="<?=$style?>"  >
                                    <?php
                                      foreach ($FKd_Materi_n_Aktifitas->result() as $data) {
                                        if($vl->FKd_Materi_n_Aktifitas==$data->Kd_Materi_n_Aktifitas){
                                            if(strpos( $data->Desc_Materi_n_Aktifitas,"ujian")  !== false || strpos( $data->Desc_Materi_n_Aktifitas,"Ujian")  !== false ){
                                                echo '<b>'.$data->Desc_Materi_n_Aktifitas.'</b>';
                                            }else{
                                                echo $data->Desc_Materi_n_Aktifitas;
                                            }
                                        }
                                      }
                                    ?>
                                </td>
                                <td valign="top" style="<?=$style?>"  >
                                    <?php
                                      foreach ($FId_Instruktur->result() as $data) {
                                        if($vl->FId_Instruktur==$data->Id_Instruktur){
                                            echo $data->NamaLengkap_DgnGelar;
                                        }
                                      }
                                    ?>
                                </td>
                            </tr>
                            <?php
                            }
                         }
                        ?>
                    </tbody>
                </table>
                <?=br(1)?>
                <table width="100%">
                    <tr>
                        <td valign="middle" class="text-right" width="400">
                        </td>
                        <td valign="middle" class="text-center">
                            <?php
                            if($tgl_print->num_rows()>0){
                                    $tgl_printca = tgl_indo($tgl_print->row()->tgl_print);
                                }else{
                                    $tgl_printca = " ";
                                }
                            ?>
                            Jakarta, <?=$tgl_printca?>
                            <?=br(2)?>
                            Yayasan Pendidikan Internal Audit
                            <?=br(1)?>
                            <?php
                               $ttd = $this->db->where(array('idttd'=>'fb869e94-f617-11e8-9aa7-56000183db8e'))->get("mst_ttd")->row();
                            ?>
                            <?=$ttd->jabatan?>
                            <?=br(5)?>
                            <?=$ttd->nama?>
                            
                        </td>
                    </tr>
                </table>
            </div>
            
            <div id="form-settings-paket" class="hide">
                <div class="table-responsive">
                <?php echo form_open($this->uri->segment(1).'/'.$this->uri->segment(2)."/store/".$id);?>
                <table class='table' width="100%" >
                    <thead>
                        <tr>
                            <th width="50">No</th>
                            <th><?=nbs(3)?></th>
                            <th style="min-width:130">Tanggal Pelaksanaan</th>
                            <th><?=nbs(3)?></th>
                            <th><?=nbs(3)?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if($cekdb->num_rows()> 0){
                                for($i=1;$i<=$count;$i++){
                                $datatre = $this->db->where(array('No_Urut_Hari'=>$i,'FId_Kelas_n_Angkatan'=>$dtdefault->Id_Kelas_n_Angkatan))->get("tre_pembukaankelas_n_angkatan_sesi");
                                $datatrecount = $datatre->num_rows();
                                if($datatrecount>0){
                                    $datatre = $datatre->row();
                                    $nouruthari = $datatre->No_Urut_Hari; 
                                    $tgl = $datatre->Tgl; 
                                    $hari = $datatre->Hari; 
                                    $angkatankelas = $datatre->FId_Kelas_n_Angkatan; 
                                    $idpaket = $datatre->idpaket; 
                                }else{
                                    $nouruthari = $i; 
                                    $tgl = null; 
                                    $hari = null; 
                                    $angkatankelas = $dtdefault->Id_Kelas_n_Angkatan; 
                                    $idpaket = null; 
                                }
                        ?>
                                <tr>
                                    <td>
                                        <span class="badge bg-blue"><?=$i?></span>
                                        <input type="hidden" name="No_Urut_Hari[<?=$i?>]" id="No_Urut_Hari" value="<?=$nouruthari?>">
                                    </td>
                                    <td class='hariname'><?=$hari?></td>
                                    <td>
                                        <input type="hidden" name="kelaslama" value="<?=$angkatankelas?>">
                                        <input type="text" name="tgl[<?=$i?>]" class="form-control date" placeholder="Tanggal Pelaksanaan" id='tgl' value="<?=$tgl?>" >
                                    </td>
                                    <td>
                                        <select name="paket[<?=$i?>]" id="paket" class="form-control">
                                            <option value="">Pilih Paket</option>
                                            <?php
                                                $slc = ($idpaket == 'custom')?'selected':'';
                                            ?>
                                            <option value="custom" <?=$slc?>>Custom</option>
                                          <?php
                                            if($paket->num_rows()>0){
                                                foreach($paket->result() as $pkt){
                                                $slc = ($idpaket == $pkt->Kd_Paket_Sesi_Harian)?'selected':'';
                                            ?>
                                            <option value="<?=$pkt->Kd_Paket_Sesi_Harian?>" <?=$slc?>><?=$pkt->Desc_Paket_Sesi_Harian?></option>
                                            <?php
                                                }
                                            }else{
                                                
                                            }
                                          ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">
                                        <?php
                                            $hidetable = ($datatrecount>0)? '':'hide';
                                        ?>
                                        <table class='table-sesi-tamp table <?=$hidetable?>' width="100%" >
                                            <?php
                                                $showdatatre = $this->db->where(array('No_Urut_Hari'=>$i,'FId_Kelas_n_Angkatan'=>$dtdefault->Id_Kelas_n_Angkatan))->order_by("No_Urut_Sesi","ASC")->get("tre_pembukaankelas_n_angkatan_sesi");
                                                if($showdatatre->num_rows()>0){
                                                    foreach($showdatatre->result() as $key => $sdttre){
                                            ?>
                                                    <tr class="tamp-urutan<?=$sdttre->No_Urut_Hari?>">
                                                        <td style="padding:5px" >
                                                            <input type="hidden" name="id[<?=$sdttre->No_Urut_Hari?>][]" id="idpembukaankelas" value="<?=$sdttre->idpembukaankelasangkatan?>">
                                                            <input type="hidden" name="FId_Kelas_n_Angkatan[<?=$sdttre->No_Urut_Hari?>][]" value="<?=$sdttre->FId_Kelas_n_Angkatan?>">
                                                            <select name="FKd_Sesi_Satuan[<?=$sdttre->No_Urut_Hari?>][]" class="form-control select2" style="width: 100%;" >
                                                              <option value="" selected>Pilih Sesi</option>
                                                              <?php
                                                              foreach ($FKd_Sesi_Satuan->result() as $data) {
                                                                $slc = ($sdttre->FKd_Sesi_Satuan==$data->Kd_Sesi_Satuan)? 'selected':'';
                                                              ?>
                                                              <option value="<?=$data->Kd_Sesi_Satuan?>" <?=$slc?> ><?=$data->Desc_Sesi?></option>
                                                              <?php
                                                              }
                                                              ?>
                                                            </select>
                                                        </td>
                                                        <td style="padding:5px">
                                                            <select name="FKd_Materi_n_Aktifitas[<?=$sdttre->No_Urut_Hari?>][]" id="FKd_Materi_n_Aktifitas" class="form-control select2" style="width: 100%;" >
                                                              <option value="" selected>Pilih Materi</option>
                                                              <?php
                                                              $hideinstruktur = 0;
                                                              foreach ($FKd_Materi_n_Aktifitas->result() as $data) {
                                                                $slc = ($sdttre->FKd_Materi_n_Aktifitas==$data->Kd_Materi_n_Aktifitas)? 'selected':'';
                                                                if($sdttre->FKd_Materi_n_Aktifitas==$data->Kd_Materi_n_Aktifitas){
                                                                    if($data->Flag_Daftar_Nilai!="Y" && $data->Flag_Evaluasi_Instruktur	!="Y"){
                                                                        $hideinstruktur = $hideinstruktur + 1;
                                                                    }else{
                                                                        $hideinstruktur = $hideinstruktur + 0;
                                                                    }
                                                                }else{
                                                                    $hideinstruktur = $hideinstruktur + 0;
                                                                }
                                                                $datanotye = ($data->Flag_Daftar_Nilai!="Y" && $data->Flag_Evaluasi_Instruktur	!="Y")? 'notye':'';
                                                              ?>
                                                              <option value="<?=$data->Kd_Materi_n_Aktifitas?>" data-id="<?=$datanotye?>" <?=$slc?> ><?=$data->Desc_Materi_n_Aktifitas?></option>
                                                              <?php
                                                              }
                                                              $hideinstruktur = $hideinstruktur;
                                                              ?>
                                                            </select>
                                                        </td>
                                                        <td style="padding:5px">
                                                            <?php
                                                                $hideinstruktur = ($hideinstruktur > 0 ) ? 'hide':'';
                                                            ?>
                                                            <select name="FId_Instruktur[<?=$sdttre->No_Urut_Hari?>][]" class="form-control <?=$hideinstruktur?> select2" style="width: 100%;" >
                                                              <option value="" selected>Pilih Instruktur</option>
                                                              <?php
                                                              foreach ($FId_Instruktur->result() as $data) {
                                                                $slc = ($sdttre->FId_Instruktur==$data->Id_Instruktur)? 'selected':'';
                                                              ?>
                                                              <option value="<?=$data->Id_Instruktur?>" <?=$slc?> ><?=$data->NamaLengkap_DgnGelar?></option>
                                                              <?php
                                                              }
                                                              ?>
                                                            </select>
                                                        </td>
                                                        <td style="padding:5px">
                                                            <?php
                                                                if($key>0){
                                                                    $hide1 = 'hide';
                                                                    $hide2 = '';
                                                                }else{
                                                                    $hide1 = '';
                                                                    $hide2 = 'hide';
                                                                }
                                                            ?>
                                                            <button type="button" id="tambah-sesi-new" class="btn btn-default btn-sm <?=$hide1?>"><i class='fa fa-plus-circle'></i></button>
                                                            <button type="button" id="remove-sesi" class="btn btn-danger btn-sm <?=$hide2?>"><i class='fa fa-trash'></i></button>
                                                            <button type="button" id="up-btn" class="btn btn-success btn-xs "><i class='fa fa-arrow-circle-up'></i></button>
                                                            <button type="button" id="down-btn" class="btn btn-warning btn-xs "><i class='fa fa-arrow-circle-down'></i></button>
                                                        </td>
                                                    </tr>
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </table>
                                    </td>
                                </tr>
                        <?php
                                }
                            }else{
                        ?>
                        
                        <?php
                                for($i=1;$i<=$count;$i++){
                        ?>
                                <tr class="tamp-urutan<?=$i?>">
                                    <td>
                                        <span class="badge bg-blue"><?=$i?></span>
                                        <input type="hidden" name="No_Urut_Hari[<?=$i?>]" id="No_Urut_Hari" value="<?=$i?>">
                                    </td>
                                    <td class='hariname'></td>
                                    <td>
                                        <input type="hidden" name="kelaslama" value="<?=$dtdefault->Id_Kelas_n_Angkatan?>">
                                        <input type="text" name="tgl[<?=$i?>]" class="form-control date" placeholder="Tanggal Pelaksanaan" id='tgl' >
                                    </td>
                                    <td>
                                        <select name="paket[<?=$i?>]" id="paket" class="form-control">
                                            <option value="">Pilih Paket</option>
                                            <option value="custom">Custom</option>
                                          <?php
                                            if($paket->num_rows()>0){
                                                foreach($paket->result() as $pkt){
                                            ?>
                                            <option value="<?=$pkt->Kd_Paket_Sesi_Harian?>"><?=$pkt->Desc_Paket_Sesi_Harian?></option>
                                            <?php
                                                }
                                            }else{
                                                
                                            }
                                          ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"></td>
                                    <td colspan="2">
                                        <table class='table-sesi-tamp table hide' width="100%" >
                                            
                                        </table>
                                    </td>
                                </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>
                </table>
                <div class="form-group col-sm-12">
                    <div class="col-sm-3 pull-right">
                        <?php
                        
                        if($tgl_print->num_rows() > 0){
                            $tgl_printxa = $tgl_print->row()->tgl_print;
                        }else{
                            $tgl_printxa = date("Y-m-d");
                        }
                        
                        ?>
                        <input type="date" name="tgl_print" id="tgl_print" class="form-control" value="<?=$tgl_printxa?>">
                    </div>
                </div>
                <div class="form-group col-sm-12 "> 
                  <div class="col-sm-3 pull-right">
                    <button type="submit" title="Simpan Data" class="btn btn-block btn-flat btn-success">Save</button>
                  </div>
                  <div class="col-sm-3 pull-right">
                    <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" title="Kembali" class="btn btn-danger btn-block btn-flat">Back</a>
                  </div>
                </div>
                <?php echo form_close();?>
                </div>
            </div>
        </div>
      </div> <!-- /.tab-pane 2 -->
      
    </div> <!-- /.tab-content -->
  </div> <!-- nav-tabs-custom -->

    </div>
  </div>

</section>

<!--<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/dataTables.buttons.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.flash.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jszip.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/pdfmake.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/vfs_fonts.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.html5.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.print.min.js")?>"></script>-->
<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")?>"></script>
<script src="<?=base_url("assets/script/print.min.js")?>"></script>
<script src="<?=base_url("assets/script/FileSaver.js")?>"></script>
<script src="<?=base_url("assets/script/jquery.wordexport.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    //
    $.ajaxSetup({
      data: {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      }
    });
    /*
    $(document).on("click","#add-day",function(e){
        e.preventDefault();
        var harike = $(this).attr("data-kelas");
        var batas = '<?=$dtdefault->LamaHariPelatihan?>';
        f(harike == batas){
            alert("Maaf! Kelas ini dibuka hanya untuk <?=$dtdefault->LamaHariPelatihan?> Hari");
        }else{
            $("#modal-default").find(".modal-dialog").addClass("modal-lg");
            $("#modal-default").find(".modal-dialog .modal-content .modal-header .modal-title").html("Menambahkan Jadwal");
            $("#modal-default").find(".modal-dialog .modal-content .modal-body").load(_BASE_URL_+'/kelas-pelatihan/jadwal-kelas/load-setting/loadformhari/'+harike);
            $("#modal-default").find(".modal-dialog").addClass("animated bounceIn");
            $("#modal-default").modal("show"); 
        }
    });*/
    
    $(document).on("change","#paket",function(){
        var paketval = $(this).val();
        var tglval = $(this).parent().prev().find("#tgl").val();
        var noharival = $(this).parent().prev().prev().prev().find("#No_Urut_Hari").val();
        var kelas = $(this).parent().prev().find("input[name='kelaslama']").val();
        var tamp = $(this).parent().parent().next().find("td table");
        if(paketval == ''){
            $(this).parent().parent().next().find("td table").addClass("hide");
        }else if(tglval == ''){
            alert("Untuk menambahkan jam sesi baru mohon isi tanggal sesi terlebih dahulu");
            $(this).val("").change();
        }else{
            $(this).parent().parent().next().find("td table").removeClass("hide");
            $(this).parent().parent().next().find("td table").html("loading...");
            $.post("<?=base_url("/kelas-pelatihan/jadwal-kelas/loadsesi")?>", {paket: paketval, tgl:tglval, nohari:noharival, kelas:kelas}, function(result){
                tamp.html(result);
                $('.select2').select2();
            });
        }
        //console.log(tamp.html());
    });
    
    $(document).on("click","#up-btn",function(){
        $(this).parent().parent().insertBefore($(this).parent().parent().prev());
        $(this).parent().parent().parent().find("tr").find("#tambah-sesi-new").addClass("hide");
        $(this).parent().parent().parent().find("tr").find("#remove-sesi").removeClass("hide");
        $(this).parent().parent().parent().find("tr:first-child").find("#tambah-sesi-new").removeClass("hide");
        $(this).parent().parent().parent().find("tr:first-child").find("#remove-sesi").addClass("hide");
    });
    $(document).on("click","#down-btn",function(){
       $(this).parent().parent().insertAfter($(this).parent().parent().next());
        $(this).parent().parent().parent().find("tr").find("#tambah-sesi-new").addClass("hide");
        $(this).parent().parent().parent().find("tr").find("#remove-sesi").removeClass("hide");
        $(this).parent().parent().parent().find("tr:first-child").find("#tambah-sesi-new").removeClass("hide");
        $(this).parent().parent().parent().find("tr:first-child").find("#remove-sesi").addClass("hide");
    });
    
    $(document).ajaxComplete(function() {
        $('.date').datepicker({
          autoclose: true,
          format: 'yyyy-mm-dd',
          todayHighlight:true,
          startDate : '<?=$dtdefault->Tgl_Mulai_Aktual?>',
          endDate: '<?=$dtdefault->Tgl_Selesai_Aktual?>',
        });
        
        $('body').find('.select2.hide').next(".select2-container").hide();
        
        /*$(document).on("change","#tgl1",function(){
            var dt = $(this).val();
            var d = new Date(dt);
            var weekday = new Array(7);
            weekday[0] = "Minggu";
            weekday[1] = "Senin";
            weekday[2] = "Selasa";
            weekday[3] = "Rabu";
            weekday[4] = "Kamis";
            weekday[5] = "Jumat";
            weekday[6] = "Sabtu";
        
            var n = weekday[d.getDay()];
            $(this).parent().next().find(".hari").val(n);
        });*/
        /*$(document).on("change","#paket",function(){
           var thisval = $(this).val();
           var tgl1 = $('#tgl1').val();
           
           var hari = $('#hariday').val();
           var harike = $('#harike').val();
           if(tgl1 == ''){
                //alert("Untuk menambahkan jam sesi baru mohon isi tanggal sesi terlebih dahulu")
           }else{
               $("#sesi-table").load(_BASE_URL_+'/kelas-pelatihan/jadwal-kelas/load-setting/formsesi/'+thisval+'/'+tgl1+'/'+hari+'/'+harike);
               $("#modal-default").modal("hide"); 
           }
        });*/
    });
    $('.select2').select2();
   /* $(document).on("click","#pengaturanbtn",function(){
       var thisdata = $(this).attr("data-count");
       if(thisdata == "0"){
           $("body").find('.selecthide').val("").change();
           $("body").find('.selecthide').next().addClass("hide");
           $(this).removeClass("btn-primary");
           $(this).addClass("btn-info");
           $("#wordbtn").addClass("hide");
           $("#printbtn").addClass("hide");
           $("#pengaturanbtnpaket").addClass("hide");
           $("#view-jadwal").addClass("hide");
           $("#form-settings").removeClass("hide");
           $("#action-button").removeClass("hide");
           $(this).attr("data-count","1");
       }else{
           $(this).removeClass("btn-info");
           $(this).addClass("btn-primary");
           $("#wordbtn").removeClass("hide");
           $("#printbtn").removeClass("hide");
           $("#pengaturanbtnpaket").removeClass("hide");
           $("#view-jadwal").removeClass("hide");
           $("#form-settings").addClass("hide");
           $("#action-button").addClass("hide");
           $(this).attr("data-count","0");
       }
    });*/
    
    $(document).on("click","#pengaturanbtnpaket",function(){
       var thisdata = $(this).attr("data-count");
       if(thisdata == "0"){
           $("body").find('.selecthide').val("").change();
           $("body").find('.selecthide').next().addClass("hide");
           $(this).removeClass("btn-warning");
           $(this).addClass("btn-info");
           $("#wordbtn").addClass("hide");
           $("#printbtn").addClass("hide");
           $("#pengaturanbtn").addClass("hide");
           $("#view-jadwal").addClass("hide");
           $("#form-settings").addClass("hide");
           $("#action-button").addClass("hide");
           $("#form-settings-paket").removeClass("hide");
           $(this).attr("data-count","1");
           $('body').find('.select2.hide').next(".select2-container").hide();
       }else{
           $(this).removeClass("btn-info");
           $(this).addClass("btn-warning");
           $("#wordbtn").removeClass("hide");
           $("#printbtn").removeClass("hide");
           $("#pengaturanbtn").removeClass("hide");
           $("#view-jadwal").removeClass("hide");
           $("#form-settings").addClass("hide");
           $("#action-button").addClass("hide");
           $("#form-settings-paket").addClass("hide");
           $(this).attr("data-count","0");
       }
    });
    $(document).on("click","#printbtn",function(){
        
        printJS({
            printable: 'view-jadwal', 
            type: 'html', 
            css : [
                '<?=base_url('assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')?>',
                '<?=base_url('assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css')?>',
                '<?=base_url('assets/adminlte/dist/css/AdminLTE.min.css')?>',
                '<?=base_url('assets/adminlte/dist/css/skins/_all-skins.min.css')?>'
                ],
            
        });
    });
    $('.date').datepicker({
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight:true,
      startDate : '<?=$dtdefault->Tgl_Mulai_Aktual?>',
      endDate: '<?=$dtdefault->Tgl_Selesai_Aktual?>',
    });
    /*$(document).on("click","#tambah-sesi",function(){
        var tglval = $(this).parent().parent().find("#tgl").val();
        if(tglval == "" || tglval == null){
            alert("Untuk menambahkan jam sesi baru mohon isi tanggal sesi terlebih dahulu")
        }else{
            $(this).parent().parent().parent().find(".select2").each(function(index){
                if ($(this).data('select2')) {
                  $(this).select2('destroy');
                } 
            });
            var idtr = $(this).parent().parent().attr("class");
            //alert($("."+idtr).length);
            var thisclone = $(this).parent().parent().clone(true);
            
            //thisclone.find("td:first-child").html("");
            thisclone.find("span[class='badge bg-blue']").remove();
            thisclone.find("#No_Urut_Hari").remove();
            thisclone.find("#idpembukaankelas").val("");
            thisclone.find("#tgl").remove();
            thisclone.find(".hariname").html("");
            var nourutsesival = thisclone.find("#nourutsesi").val();
            var nourutsesidata = thisclone.find("#nourutsesi").attr("data");
            var nourutsesidata = $("input[data='"+nourutsesidata+"']").length;
            var nourutsesi = parseInt(nourutsesival)+parseInt(nourutsesidata);
            thisclone.find("#nourutsesi").val(nourutsesi);
            thisclone.find(".select2").val("").change();
            thisclone.find("button#tambah-sesi").addClass("hide");
            thisclone.find("button#remove-sesi").removeClass("hide");
            thisclone.insertAfter($("."+idtr+":last"));
            $('.select2').select2();  
            $('body').find('.select2.hide').next(".select2-container").hide();
        }
    });*/
    $(document).on("click","#tambah-sesi-new",function(){
        $(this).parent().parent().parent().find(".select2").each(function(index){
            if ($(this).data('select2')) {
              $(this).select2('destroy');
            } 
        });
        var idtr = $(this).parent().parent().attr("class");
        var thisclone = $(this).parent().parent().clone(true);
        thisclone.find("#idpembukaankelas").val("");
        thisclone.find(".select2").val("").change();
        thisclone.find("button#tambah-sesi-new").addClass("hide");
        thisclone.find("button#remove-sesi").removeClass("hide");
        thisclone.insertAfter($("."+idtr+":last"));
        $('.select2').select2();  
        $('body').find('.select2.hide').next(".select2-container").hide();
    });
    $(document).on("click","#remove-sesi",function(){
        var cek =  $(this).parent().parent().find("#idpembukaankelas").val();
        var remv = $(this).parent().parent();
        if(cek ==''){
            $(this).parent().parent().remove();
        }else{
            /*$.get("<?=base_url('kelas-pelatihan/jadwal-kelas/hapus/')?>"+cek, function( data ) {
                console.log(data);
                if(data == 'true'){
                    remv.remove();
                }else{
                    
                }
            });*/
            remv.remove();
        }
    });
    $(document).on("change","#tgl",function(){
        var dt = $(this).val();
        var d = new Date(dt);
        var weekday = new Array(7);
        weekday[0] = "Minggu";
        weekday[1] = "Senin";
        weekday[2] = "Selasa";
        weekday[3] = "Rabu";
        weekday[4] = "Kamis";
        weekday[5] = "Jumat";
        weekday[6] = "Sabtu";
    
        var n = weekday[d.getDay()];
        $(this).parent().prev().html(n);
    });
    $(document).on("change","#FKd_Materi_n_Aktifitas",function(){
       var thisval = $(this).val();
       var thisdata = $(':selected', this).data('id');
       //console.log(thisdata);
       //var urlacc = _BASE_URL_+'kelas-pelatihan/jadwal-kelas/cekmateri/'+thisval;
       var sthis = $(this).parent().next();
        //$.get( urlacc, function( data ) {
            //console.log(data);
            if(thisdata == 'notye'){
                sthis.find('.select2').val("").change();      
                sthis.find('.select2').addClass("hide");      
            }else{
                sthis.find('.select2').removeClass("hide");
            }
          
       // });
    });
    $(document).on("click","#wordbtn",function(){
        $("#view-jadwal").wordExport('<?=str_replace(" ","_",$dtdefault->Desc_JenisPelatihan)?>');
    });
  });
</script>