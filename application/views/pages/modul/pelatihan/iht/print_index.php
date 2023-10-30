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


    <script language="javascript" type="text/javascript">
        jQuery(function($) {  
          // Function available at https://gist.github.com/sixlive/55b9630cc105676f842c  
          $.fn.printDiv = function() {
            var printContents = $(this).html();
            var originalContents = $('body').html();
            $('body').html(printContents);
            $('body').addClass('js-print');
            window.print();
            $('body').html(originalContents);
            $('body').removeClass('js-print');
          };
        
          // Print
          $('[data-print]').click(function() {
              $('[data-print-content]').printDiv();
          });
        });
    </script>


<section class="content">

  <?php if($this->session->flashdata('error')){ ?>
    <br>
    <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
  <?php }else if($this->session->flashdata('success')){ ?>
    <br>
    <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
  <?php } ?>

  <!-- Default box -->
  <div class="box box-primary">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$titlebox?></h3>

      <div class="box-tools pull-right">
        <a href="<?=base_url('iht/proforma-kontrak')?>" class="btn btn-box-tool"><i class="fa fa-arrow-circle-left"></i> Kembali</a>
        <button type="button" class="btn btn-box-tool" data-print>
          <i class="fa fa-print"></i> Print</button>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i> Refresh</button>
      </div>
    </div>
    
    <div class="box-body">
        
        <div id="print-area-custom" data-print-content>
            <div class="row">
                <div class='col-sm-12'>
                    <center>
                        <br/>
                        <img src="<?=base_url("assets/images/soppia.png")?>" width="80">
                        <h3>Yayasan Pendidikan Internal Audit</h3>
                    </center>
                    <hr/>
                </div>
                <div class='col-sm-12'>
                    <style>
                        .borderless td, .borderless th {
                            border: none !important;
                        }
                    </style>
                    <table class="table borderless">
                        <tr>
                            <td valign="top" width='200'><b>Perusahaan</b></td>
                            <td valign="top" width='10'>:</td>
                            <td valign="top"><?=$proforma->row()->Desc_PershInstansi?></td>
                        </tr>
                        <tr>
                            <td valign="top"><b>Group Holding</b></td>
                            <td valign="top">:</td>
                            <td valign="top"><?=($proforma->row()->Desc_GrupPershInstansi)? $proforma->row()->Desc_GrupPershInstansi :'-';?></td>
                        </tr>
                        <tr>
                            <td valign="top"><b>No Telp</b></td>
                            <td valign="top">:</td>
                            <td valign="top"><?=($proforma->row()->Telp)? $proforma->row()->Telp :'-';?></td>
                        </tr>
                        <tr>
                            <td valign="top"><b>Email</b></td>
                            <td valign="top">:</td>
                            <td valign="top"><?=($proforma->row()->email)? $proforma->row()->email :'-';?></td>
                        </tr>
                    </table>
                    <hr/>
                </div>
                
                
                <div class='col-sm-12'>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>RINCIAN PROFORMA</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-sm-12">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td valign="top" width="300"><b>Deskripsi</b></td>
                                <td valign="top" width="200"><b>Nilai</b></td>
                                <td valign="top"><b>Jumlah Peserta</b></td>
                                <td valign="top"><b>Tempat Penyelenggaraan</b></td>
                            </tr>
                            <tr>
                                <td valign="top"><?=($proforma->row()->Desc_ProformaKontrak)? $proforma->row()->Desc_ProformaKontrak : '-';?></td>
                                <td valign="top"><?=($proforma->row()->Nilai_Rp)? "Rp ".number_format($proforma->row()->Nilai_Rp,2,',','.') : '-';?></td>
                                <td valign="top"><?=($proforma->row()->Rencana_JmlPeserta)? $proforma->row()->Rencana_JmlPeserta : '-';?> orang</td>
                                <td valign="top"><?=($proforma->row()->Rencana_TempatSelenggara)? $proforma->row()->Rencana_TempatSelenggara : '-';?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
                    if($kontrakresmi->num_rows()>0){
                ?>
                <div class='col-sm-12'>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>RINCIAN KONTRAK RESMI</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-sm-12">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td valign="top"  width="300"><b>Deskripsi</b></td>
                                <td valign="top" width="200"><b>Nilai</b></td>
                                <td valign="top"><b>Jumlah Peserta</b></td>
                                <td valign="top"><b>Tempat Penyelenggaraan</b></td>
                            </tr>
                            <tr>
                                <td valign="top"><?=($kontrakresmi->row()->Desc_KontrakResmi)? $kontrakresmi->row()->Desc_KontrakResmi : '-';?></td>
                                <td valign="top"><?=($kontrakresmi->row()->Nilai_Rp)? "Rp ".number_format($kontrakresmi->row()->Nilai_Rp,2,',','.') : '-';?></td>
                                <td valign="top"><?=($kontrakresmi->row()->Rencana_JmlPeserta)? $kontrakresmi->row()->Rencana_JmlPeserta : '-';?> orang</td>
                                <td valign="top"><?=($kontrakresmi->row()->Rencana_TempatSelenggara)? $kontrakresmi->row()->Rencana_TempatSelenggara : '-';?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
                    }
                ?>  
                
                
                <?php
                    if($addendum->num_rows()>0){
                ?>
                <div class='col-sm-12'>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>RINCIAN ADDENDUM</th>
                            </tr>
                        </thead>
                    </table>
                </div>
                <div class="col-sm-12">
                    <table class="table table-striped">
                        <tbody>
                            <tr>
                                <td valign="top" width="300"><b>Deskripsi</b></td>
                                <td valign="top" width="200"><b>Nilai</b></td>
                                <td valign="top"><b>Jumlah Peserta</b></td>
                                <td valign="top"><b>Tempat Penyelenggaraan</b></td>
                            </tr>
                            <?php
                                foreach($addendum->result() as $addendum){
                            ?>
                                <tr>
                                    <td valign="top"><?=($addendum->Desc_AddKontrak)? $addendum->Desc_AddKontrak : '-';?></td>
                                    <td valign="top"><?=($addendum->Nilai_Rp)? "Rp ".number_format($addendum->Nilai_Rp,2,',','.') : '-';?></td>
                                    <td valign="top"><?=($addendum->Rencana_JmlPeserta)? $addendum->Rencana_JmlPeserta : '-';?> orang</td>
                                    <td valign="top"><?=($addendum->Rencana_TempatSelenggara)? $addendum->Rencana_TempatSelenggara : '-';?></td>
                                </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?php
                    }
                ?>  
                
                
            </div>
        </div>
        
    </div>

  </div>

</section>