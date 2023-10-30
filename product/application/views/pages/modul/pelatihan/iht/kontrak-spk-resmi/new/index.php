<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net/buttons.dataTables.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")?>">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$titlepage?>
    <small><?=$subtitlepage?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li><a><?=$breadcrumb2?></a></li>
    <li class="active"><?=$breadcrumb3?></li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

  <?php if($this->session->flashdata('error')){ ?>
    <br>
    <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
  <?php }else if($this->session->flashdata('success')){ ?>
    <br>
    <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
  <?php } ?>

  <div class="box" style="border-top:0px solid">
    <div class="box-header with-border">
        <h3 class="box-title">&nbsp;</h3>
        <div class="box-tools pull-right">
          <a href="<?=base_url($this->uri->segment(1).'/proforma-kontrak')?>" class="btn btn-box-tool" data-toggle="tooltip" title="Kembali Ke Manage proforma Kontrak"><i class="fa fa-arrow-circle-left"></i> Back</a>
          <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
            <i class="fa fa-refresh"></i></button>
        </div>
    </div>
    <div class="box-body">
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs tab-inisiasi">
          <li class="active"><a data-href="" data-toggle="tab" id="tabname" aria-expanded="true" style="cursor: pointer">Proforma</a></li>
          <li class=""><a data-href="" data-toggle="tab" id="tabname" aria-expanded="false" style="cursor: pointer">Kontrak Resmi</a></li>
          <li class=""><a data-href="" data-toggle="tab" id="tabname" aria-expanded="false" style="cursor: pointer">Addendum 1</a></li>      
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="tab_1">
            <table class="table table-bordered table-striped" style="width: 100%">
            <tr>
              <td valign="top">Proforma Kesepakatan Kontrak</td>
              <td valign="top">:</td>
              <td valign="top"><?=$nameproforma->row()->Desc_ProformaKontrak?></td>
            </tr>
            <tr>
              <td valign="top">Perusahaan / Instansi</td>
              <td valign="top">:</td>
              <td valign="top"><?=$nameproforma->row()->Desc_PershInstansi?></td>
            </tr>
            <tr>
              <td valign="top">Nilai Rp</td>
              <td valign="top">:</td>
              <td valign="top">Rp. <?=number_format($nameproforma->row()->Nilai_Rp)?></td>
            </tr>
            <tr>
              <td valign="top">Rencana Jumlah Peserta</td>
              <td valign="top">:</td>
              <td valign="top"><?=$nameproforma->row()->Rencana_JmlPeserta?></td>
            </tr>
            <tr>
              <td valign="top">Rencana Tempat Penyelenggaraan</td>
              <td valign="top">:</td>
              <td valign="top"><?=$nameproforma->row()->Rencana_TempatSelenggara?></td>
            </tr>
            <tr>
              <td valign="top">File Lampiran</td>
              <td valign="top">:</td>
              <td valign="top"><?=($nameproforma->row()->File_Lampiran == null )? '' : '<a href="'.base_url('uploads/fileapps/proformakontrak/'.$nameproforma->row()->File_Lampiran).'" download><i class="fa fa-download"></i> File Lampiran</a>'?></td>
            </tr>
          </table>
          </div>
          <!-- /.tab-pane -->
        </div>
        <!-- /.tab-content -->
      </div>
    </div>
  </div>

</section>

<script type="text/javascript">
  $(function(){
    $(document).on("click",".add-tab-inisiasi-pelatihan",function(){
      var sizetab = $(".tab-inisiasi").children().length;
      var tablist = $(this).parent().prev().clone(true);
      tablist.find("a").html("Addendum "+(sizetab-2));
      tablist.find("a").attr("aria-expanded","false");
      tablist.attr("class","");
      tablist.appendTo(".tab-inisiasi");
    });
    $(document).on("click","#tabname",function(){
     $("#tab_1").html("");
    });
  })

</script>