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

  <!-- Default box -->
  <div class="box box-danger">
    <div class="box-header with-border">
      <h3 class="box-title">ID Kelas : <?=$kelas->nomor_kelas?> | <?=$kelas->DescBebas_Kelas_n_Angkatan?></h3>
      <div class="box-tools pull-right">
        <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                  title="Kembali Ke Manage <?=$subtitlepage?>">
            <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i> Refresh</button>
      </div>
    </div>
    <div class="box-body">
    <?php
      if($hasil->num_rows()>0){
    ?>
      <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered dt-table" style="width: 100%">
        <thead>
          <tr>
            <th width="20" class='text-center' rowspan="1">No</th>
            <th width="60" rowspan="1" >Foto</th>
            <th width="200" rowspan="1" style="width: 100px">NIPP</th>
            <th width="220" rowspan="1" style="width: 200px">Nama Peserta</th>
            <?php
              $getm = $this->db
              ->join("mst_materi_n_aktifitas",'mst_materi_n_aktifitas.Kd_Materi_n_Aktifitas = tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas','Left')
              ->where(array('FId_Kelas_n_Angkatan'=>$kelas->Id_Kelas_n_Angkatan,
                  'tre_pembukaankelas_n_angkatan_sesi.FKd_Materi_n_Aktifitas !=' =>'',
                  'tre_pembukaankelas_n_angkatan_sesi.FId_Instruktur !=' => ''
                ))
              ->get('tre_pembukaankelas_n_angkatan_sesi');
              $countmateri = array();
                if($getm->num_rows()>0){
                  foreach ($getm->result() as $key => $value) {
                    if(in_array($value->Kd_Materi_n_Aktifitas,$countmateri)){
                    }else{
                      array_push($countmateri,1);
                    }
                  }
                }else{

                }
              $countmateri = count($countmateri)*4;
            ?>

            <!-- <th width="220" colspan="<?=$countmateri?>">Materi</th> -->
            <?php
                  $materi = array();
                if($getm->num_rows()>0){
                ?>
             <?php
                  foreach ($getm->result() as $key => $value) {
                    if(in_array($value->Kd_Materi_n_Aktifitas,$materi)){

                    }else{
                ?>
                <th class='text-center' colspan="4" rowspan="1" width="100"><?=$value->Desc_Materi_n_Aktifitas?></th>
                <?php 
                      array_push($materi,$value->Kd_Materi_n_Aktifitas);
                    }
                  }
                ?>
             <?php
                }else{

                }
                ?>
            <th class="text-center" rowspan="1">Keterangan</th>
          </tr>
        </thead>
        <tbody>
            <?php 
          $no=1;
          foreach($hasil->result() as $data){ 
          $salah = array();
          $benar = array();
      ?>
            <tr>
                <td class='text-center' rowspan="1"><?=$no++?></td>
                <td class='text-center' rowspan="1"><?=($data->FilePhoto!= null)? '<img src="'.base_url("uploads/photo/".$data->FilePhoto).'" width="50px" height="50px"></img>' : '<code>N/A</code>';?></td>
                <td rowspan="1"><?=$data->NIPP?></td>
                <td rowspan="1">
                  <a href="<?=base_url('pbt/pengumuman-hasil/hasil-hh/'.$this->uri->segment(4).'/'.$data->Id_Peserta)?>"> 
                    <?=$data->NamaLengkap_DgnGelar?>
                  </a>
                </td>
                <?php
                  if(count($materi) >0 ){
                    foreach($materi as $mm){
                      $check = $this->db
                      ->where(array(
                        'FId_Kelas_n_Angkatan'=>$kelas->Id_Kelas_n_Angkatan,
                        'FId_Peserta'=>$data->Id_Peserta,
                        'FKd_Materi_n_Aktifitas'=>$mm
                        ))->get('tre_bukakelasangkatan_peserta_hasilujian');
                      if($check->num_rows()>0){
                    ?><?php
                      if($check->row()->Flag_LulusUjian1 == "Y"){
                        //echo "<span class='text-success'>&#10004;</span>";
                        array_push($benar, 1);
                      }else{
                        $findher = $this->db
                        ->where(array(
                          'FId_Kelas_n_Angkatan'=>$kelas->Id_Kelas_n_Angkatan,
                          'FId_Peserta'=>$data->Id_Peserta,
                          'FKd_Materi_n_Aktifitas'=>$mm,
                          ))->get('tre_bukakelasangkatan_peserta_hasilujian')->row();
                        if($findher->Flag_LulusHer1 == 'Y' && $findher->Flag_LulusHer1 != null ){

                          //echo "<span class='text-success'>&#10004;</span>";
                          array_push($benar, 1);

                        }else if($findher->Flag_LulusHer2 == 'Y'  && $findher->Flag_LulusHer1 != null ){
                          
                          //echo "<span class='text-success'>&#10004;</span>";
                          array_push($benar, 1);

                        }else if($findher->Flag_LulusExtraHer1 == 'Y'  && $findher->Flag_LulusExtraHer1 != null ){

                          //echo "<span class='text-success'>&#10004;</span>";
                          array_push($benar, 1);

                        }else if($findher->Flag_LulusExtraHer2 == 'Y' && $findher->Flag_LulusExtraHer2 != null){

                          //echo "<span class='text-success'>&#10004;</span>";
                          array_push($benar, 1);

                        }else{
                          //echo "<span class='text-danger'><b>&#10006;</b></span>";
                          array_push($salah, 1);  
                        }
                      }
                      ; ?>
                    <?php
                      }else{
                      ?>
                      <?php
                      }
                    }
                  }else{
                  }
                ?>
                 <?php
                  if(count($materi) >0 ){
                    foreach($materi as $mm){
                      $check = $this->db
                      ->where(array(
                        'FId_Kelas_n_Angkatan'=>$kelas->Id_Kelas_n_Angkatan,
                        'FId_Peserta'=>$data->Id_Peserta,
                        'FKd_Materi_n_Aktifitas'=>$mm
                        ))->get('tre_bukakelasangkatan_peserta_hasilujian');
                    ?>
                      <td valign="top" class="text-center" width="10"><?php
                            if($check->num_rows()>0){
                              if($check->row()->Flag_LulusUjian1 == "Y"){
                                //echo "<span class='text-success'>&#10004;</span>";
                                echo $check->row()->Hasil_Ujian1;
                              }else if($check->row()->Flag_LulusUjian1 == "N"){
                                //echo "<span class='text-danger'><b>&#10006;</b></span>";
                                echo $check->row()->Hasil_Ujian1;
                              }else{
                                //echo "&nbsp;";
                                echo "-";
                              }
                              //echo "<hr/>";

                            }else{
                                //echo "&nbsp;";
                                echo "-";
                              }
                      ?></td>
                      <td valign="top" class="text-center"  width="10"><?php
                            if($check->num_rows()>0){
                              if($check->row()->Flag_LulusHer1 == "Y"){
                                //echo "<span class='text-success'>&#10004;</span>";
                              echo $check->row()->Hasil_Her1;
                              }else if($check->row()->Flag_LulusHer1 == "N"){
                                //echo "<span class='text-danger'><b>&#10006;</b></span>";
                              echo $check->row()->Hasil_Her1;
                              }else{
                                //echo "&nbsp;";
                                echo "-";
                              }
                              //echo "<hr/>";;
                            }else{
                                //echo "&nbsp;";
                                echo "-";
                              }
                      ?></td>
                      <td valign="top" class="text-center"  width="10"><?php
                            if($check->num_rows()>0){
                              if($check->row()->Flag_LulusHer2 == "Y"){
                                //echo "<span class='text-success'>&#10004;</span>";
                              echo $check->row()->Hasil_Her2;
                              }else if($check->row()->Flag_LulusHer2 == "N"){
                                //echo "<span class='text-danger'><b>&#10006;</b></span>";
                              echo $check->row()->Hasil_Her2;
                              }else{
                                //echo "&nbsp;";
                                echo "-";
                              }
                              //echo "<hr/>";
                            }else{
                                //echo "&nbsp;";
                                echo "-";
                              }
                      ?></td>
                      <td valign="top" class="text-center"  width="10"><?php
                            if($check->num_rows()>0){
                              if($check->row()->Flag_LulusExtraHer1 == "Y"){
                                //echo "<span class='text-success'>&#10004;</span>";
                              echo $check->row()->Hasil_Extra_Her1;
                              }else if($check->row()->Flag_LulusExtraHer1 == "N"){
                                //echo "<span class='text-danger'><b>&#10006;</b></span>";
                              echo $check->row()->Hasil_Extra_Her1;
                              }else{
                                //echo "&nbsp;";
                                echo "-";
                              }
                              //echo "<hr/>";
                            }else{
                                //echo "&nbsp;";
                                echo "-";
                              }
                      ?></td>
                    <?php
                          }
                        }
                        
                    ?>
                <td rowspan="1" ><?php
                /*echo count($salah);
                echo count($benar);*/

                if($getm->num_rows()>0){


                  if( (count($salah)<= 0) && ( count($benar) == count($materi) ) ){
                    echo "Lulus";
                  }

                  if( count($salah)>0){
                    echo "Tidak Lulus";
                  } 

                }else{

                }



                ?></td>
            </tr>
            <?php } ?>
        </tbody>
      </table>
    </div>
    <?php
    }else{
    ?>

    <div class="alert alert-info">
        Saat ini belum ada data peserta untuk kelas ini!
    </div>

    <?php
    }
    ?>

    </div>
  </div>
</section>
<style type="text/css">
  @media print {
    table.dataTable thead .sorting:after{
      opacity: 0 !important;
    }
 }

</style>

<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/dataTables.buttons.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.flash.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/jszip.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/pdfmake.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/vfs_fonts.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.html5.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/datatables.net/js/buttons.print.min.js")?>"></script>

<script type="text/javascript">  
  $(function () {
    $.ajaxSetup({
      data: {
          '<?php echo $this->security->get_csrf_token_name(); ?>' : '<?php echo $this->security->get_csrf_hash(); ?>'
      }
    });

    $('table.dt-table').DataTable({
      "dom": 'Bfrtip',
      "buttons": [      
       /* { extend: 'copy', text: '<i class="fa fa-copy"></i> Copy','className':'btn btn-sm btn-default',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }},*/
        { extend: 'excel', text: '<i class="fa fa-save"></i> Excel',title:'ID Kelas : <?=$kelas->nomor_kelas?> | <?=$kelas->DescBebas_Kelas_n_Angkatan?>','className':'btn btn-sm btn-success',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        } },
        /*{ extend: 'csv', text: '<i class="fa fa-save"></i> Csv',title:'ID Kelas : <?=$kelas->nomor_kelas?> | <?=$kelas->DescBebas_Kelas_n_Angkatan?>','className':'btn btn-sm btn-success',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        }  },
        { extend: 'pdfHtml5',customize: function ( win ) {
          //$(win.document.body).find( 'thead' ).html("").append($('.dt-table thead').html());
          console.log(win);
        }, text: '<i class="fa fa-save"></i> Pdf' ,title:'ID Kelas : <?=$kelas->nomor_kelas?> | <?=$kelas->DescBebas_Kelas_n_Angkatan?>','className':'btn btn-sm btn-danger',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        } },*/
        { extend: 'print',customize: function ( win ) {
          $(win.document.body).find( 'thead' ).html("").append($('.dt-table thead').html());
      }, text: '<i class="fa fa-print"></i> Print',title:'ID Kelas : <?=$kelas->nomor_kelas?> | <?=$kelas->DescBebas_Kelas_n_Angkatan?>' ,'className':'btn btn-sm btn-info',init: function(api, node, config) {
           $(node).removeClass('dt-button')
        } },
      ],
      'paging'      : false,
    });

  })  
</script>