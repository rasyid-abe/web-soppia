<section class="content-header">
  <h1>
    Laporan Biaya dan Pendapatan Kelas IHT
    <small>Data Laporan</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a><?=$breadcrumb2?></a></li>
    <li class="active">Data Laporan</li>
  </ol>
</section>

<section class="content">

  <?php if($this->session->flashdata('error')){ ?>
    <br>
    <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
  <?php }else if($this->session->flashdata('success')){ ?>
    <br>
    <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
  <?php } ?>

  <!-- Default box -->
  <div class="box" style="border-top:0px solid">
    <div class="box-header with-border">
      <h3 class="box-title">Manage Laporan Biaya dan Pendapatan Kelas IHT</h3>

      <div class="box-tools pull-right">
        <a href="<?=base_url($this->uri->segment(1).'/laporan-project-kelas')?>" class="btn btn-box-tool" data-toggle="tooltip" title="Kembali Ke Manage Laporan Kelas"> <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i> Refresh</button>
      </div>
    </div>
    <div class="box-body">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab"><b>Informasi Kelas IHT</b></a></li>
              <li><a href="#tab_2" data-toggle="tab"><b>Laporan Biaya dan Pendapatan Kelas</b></a></li>
            </ul>
            <div class="tab-content">
            <?php $data = $kelas->row();?>
              <div class="tab-pane active" id="tab_1">
                 <table class="table table-bordered table-striped" style="width: 100%">
		    <tr>
        		<td valign="top" width="300" style="color:#00008B">Nama Kelas & Angkatan (Baku)</td>
        		<td valign="top" width="20">:</td>
        		<td valign="top" style="color:#9900cc"><?=$data->DescBaku_Kelas_n_Angkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Nama Kelas & Angkatan (Ketikan Bebas)</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$data->DescBebas_Kelas_n_Angkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Jenis Pelatihan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$data->Desc_JenisPelatihan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Perusahaan / Instansi</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$data->Desc_PershInstansi?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Angkatan Ke</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$data->No_Urut_Angkatan?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Kode Singkatan Kelas tsb.</td>
        		<td valign="top">:</td>
        		<?php
                    $kode = "-";
                    if($data->KODE_Singkatan != null){
                        $kode = $data->KODE_Singkatan;
                    }
                ?>
        		<td valign="top" style="color:#9900cc"><?=$kode?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Kota Tempat Pelatihan</td>
        		<td valign="top">:</td>
        		<?php
                    $kota = "-";
                    if($data->Desc_KotaTraining != null){
                        $kota = $data->Desc_KotaTraining;
                    }
                ?>
        		<td valign="top" style="color:#9900cc"><?=$kota?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Lokasi Penyelenggaraan</td>
        		<td valign="top">:</td>
        		<?php
                    $lokasi = "-";
                    if($data->LokasiPenyelenggaraan != null){
                        $lokasi = $data->LokasiPenyelenggaraan;
                    }
                ?>
        		<td valign="top" style="color:#9900cc"><?=$lokasi?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Jumlah Peserta</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$data->Jml_Peserta?> Peserta</td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Tanggal Mulai</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=tgl_indo($data->Tgl_Mulai_Aktual)?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Tanggal Selesai</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=tgl_indo($data->Tgl_Selesai_Aktual)?></td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Lama Hari Pelatihan</td>
        		<td valign="top">:</td>
        		<td valign="top" style="color:#9900cc"><?=$data->LamaHariPelatihan?> Hari</td>
        	</tr>
        	<tr>
        		<td valign="top" style="color:#00008B">Status Kelas Saat ini</td>
        		<td valign="top">:</td>
        		<?php
        			$selesai = "";
        			if($data->Flag_Selesai == "B"){
        				$selesai = "Kelas Belum Dimulai";
        			}
        			elseif($data->Flag_Selesai == "L"){
        				$selesai = "Kelas Sedang Berlangsung";
        			}
        			elseif($data->Flag_Selesai == "E"){
        				$selesai = "Kelas Sudah Berakhir";
        			}
        			elseif($data->Flag_Selesai == "C"){
        				$selesai = "Kelas Sudah Ditutup";
        			}
        		?>
        		<td valign="top" style="color:#9900cc"><?=$selesai?></td>
        	</tr>
        </table>  
              </div> <!-- /.tab-pane -->
              
              <div class="tab-pane" id="tab_2">
                <div class="container-fluid">    
                    <div class="col-md-6">
                        <div class="box box-success">
                        <div class="box-header with-border">
                          <i class="fa fa-sign-out"></i>
                          <h3 class="box-title">Transaksi Debet</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <dl>
                            <dd class="pull-right" style="color:#9900cc">
                                <?php
                                  foreach ($debet->result() as $d) { ?>
                                    <?="<span class='pull-right'>Rp. ".number_format($d->Nilai_Rps)."</span><br/>"?>  
                                <?php } ?>
                            </dd>
                            <dd class="pull-left" style="color:#00008B">
                                <?php
                                  foreach ($debet->result() as $d) { ?>
                                    <?=$d->Desc_Transaksi. " : <br/>"?>  
                                <?php } ?>
                            </dd>
                          </dl>
                        </div> <!-- /.box-body -->
                      </div> <!-- /.box -->
                    </div> <!-- /.col -->
                    
                    <div class="col-md-6">
                        <div class="box box-success">
                        <div class="box-header with-border">
                          <i class="fa fa-sign-in"></i>
                          <h3 class="box-title">Transaksi Kredit</h3>
                        </div>
                        
                        <!-- /.box-header -->
                        <div class="box-body">
                          <dl>
                            <dd class="pull-right" style="color:#9900cc">
                                <?php
                                  foreach ($kredit->result() as $k) { ?>
                                    <?="<span class='pull-right'>Rp. ".number_format($k->Nilai_Rps)."</span><br/>"?>  
                                <?php } ?>
                            </dd>
                            <dd class="pull-left" style="color:#00008B">
                                <?php
                                  foreach ($kredit->result() as $k) { ?>
                                    <?=$k->Desc_Transaksi. " : <br/>"?>  
                                <?php } ?>
                            </dd>
                          </dl>
                        </div> <!-- /.box-body -->
                      </div> <!-- /.box -->
                    </div> <!-- /.col -->
                    
                    <div class="col-md-12">
                        <div class="box" style="border-top:0px solid">
                        <div class="box-header with-border">
                          <h3 class="box-title pull-right" ><b>Total Kredit (Rp.)</b></h3>
                        </div>
                        <?php
                          $totalk = 0;
                          $nilair = 0;
                          foreach ($debet->result() as $d) {
                            $nilair += $d->Nilai_Rps;
                          } 
                          foreach ($kredit->result() as $k) {
                            $totalk += $k->Nilai_Rps;
                          } 
                        ?>
                        <!-- /.box-header -->
                        <div class="box-body">
                          <dl>
                            <dd class="pull-right">
                                <?="<b class='pull-right'>Rp. ".number_format($totalk)."</b><br/> <hr/>"?>
                                <?php
                                  foreach ($debet->result() as $d) { ?>
                                    <?="<b class='pull-right'>Rp. ".number_format($d->Nilai_Rps)."</b><br/>"?>  
                                <?php } ?>
                                <hr style="border: 1px solid red;">
                                <?="<b style='font-size:26px'>Rp. ".number_format($totalk - $nilair)."</b>"?>
                            </dd>
                          </dl>
                        </div> <!-- /.box-body -->
                      </div> <!-- /.box -->
                    </div> <!-- /.col -->
                </div>
              </div> <!-- /.tab-pane -->
            </div> <!-- /.tab-content -->
          </div> <!-- nav-tabs-custom -->
    </div>
  </div>
</section>
