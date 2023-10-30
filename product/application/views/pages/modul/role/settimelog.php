<link rel="stylesheet" href="<?=base_url("assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css")?>">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")?>">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    <?=$titlepage?>
    <small><?=$subtitlepage?></small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?=base_url("dashboard")?>"><i class="fa fa-dashboard"></i> <?=$breadcrumb1?></a></li>
    <li class="active"><?=$breadcrumb2?></li>
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
  <div class="box box-success">
    <div class="box-header with-border">
      <h3 class="box-title"><?=$titlebox?></h3>

      <div class="box-tools pull-right">
        <a href="<?=base_url($this->uri->segment(1))?>" class="btn btn-box-tool" data-toggle="tooltip"
                title="Kembali Ke Manage <?=$subtitlepage?>">
          <i class="fa fa-arrow-circle-left"></i> Back</a>
        <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
          <i class="fa fa-refresh"></i> Refresh</button>
      </div>
    </div>
    <div class="box-body">
        <div class="alert alert-info alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-info"></i> Info!</h4>
            Fitur ini berfungsi untuk mengatur role tertentu dapat mengakses sitem sopia (login) pada ketentuan (hari dan waktu),(tanggal dan waktu) yang sudah ditetapkan/diatur oleh role super adminsitrator
        </div>
        <form action="<?=base_url('role/settimeaccessprosesya/');?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
        <input type="hidden" name="idrole" value="<?=$dt->idrole?>" />
        
            <div class="col-sm-6">
                
                <select class="form-control" name="waktu" id="waktu">
                    <?php
                        if($ceklogtime->num_rows()>0){
                            $slc1 = ($ceklogtime->row()->status == "TW")? 'selected':'';
                            $slc2 = ($ceklogtime->row()->status == "HW")? 'selected':'';
                            $slc3 = ($ceklogtime->row()->status == "Y")? 'selected':'';
                            $twhide = ($slc1 != '')? '':'hide';
                            $hwhide = ($slc2 != '')? '':'hide';
                            $yahide = ($slc3 != '')? '':'hide';
                        }else{
                            $slc1 = "";
                            $slc2 = "selected";
                            $slc3 = "";
                            $twhide = 'hide';
                            $hwhide = '';
                            $yahide = 'hide';
                        }
                    ?>
                    <option value="TW" <?=$slc1?> >Set Tanggal Dan Waktu</option>
                    <option value="HW" <?=$slc2?> >Set Hari Dan Waktu</option>
                    <option value="Y"  <?=$slc3?> >Set Setiap Saat</option>
                </select>
                
            </div>
            <div class="col-sm-2">
                <button type="submit" class="btn btn-sm btn-success btn-ya-ya <?=$yahide?> ">Simpan <i class="fa fa-clock-o"></i></button>
            </div>
        </form>
        <br/>
        <br/>
        <form action="<?=base_url('role/settimeaccessproseshw/');?>" method="POST">
        <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
        <input type="hidden" name="idrole" value="<?=$dt->idrole?>" />
        <table class="table table-bordered table-striped  <?=$hwhide?> " id="show-set-hw" style="width: 100%">
            <thead>
                <tr>
                    <th width="50">&nbsp;</th>
                    <th width="150">Hari</th>
                    <th>Waktu</th>
                </tr>
            </thead>
            <tbody>
                    <?php
                        $day = 7;
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
                      
                        for($i=1;$i<=7;$i++){
                            if($ceklogtime->num_rows() > 0 && $ceklogtime->row()->day != null ){
                                $check = ( in_array($dayval[$i],unserialize($ceklogtime->row()->day) ) )? 'checked':'';
                                $timeno  = array_search( $dayval[$i],unserialize($ceklogtime->row()->day) );
                                $starttime = ( in_array( $dayval[$i],unserialize($ceklogtime->row()->day) ) )? (unserialize($ceklogtime->row()->time)[$timeno]['timestart'][unserialize($ceklogtime->row()->day)[$timeno]]):'08:00';
                                $endtime = ( in_array( $dayval[$i],unserialize($ceklogtime->row()->day) ) )? (unserialize($ceklogtime->row()->time)[$timeno]['timeend'][unserialize($ceklogtime->row()->day)[$timeno]]):'17:00';
                            }else{
                                $check = '';
                                $starttime = '08.00';
                                $endtime = '17.00';
                            }
                    ?>
                        <tr>
                            <td class="text-center"> <label><input type="checkbox" name="centang[]" value="<?=$dayval[$i]?>" <?=$check?> ></label> </td>
                            <td><?=$dayList[$i]?> </td>
                            <td>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">Dari Jam</span>
                                        <input class="form-control timepicker" name="timestart[<?=$dayval[$i]?>]" id="timestart" value="<?=$starttime?>" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="input-group">
                                        <span class="input-group-addon">Sampai Jam</span>
                                        <input class="form-control timepicker" name="timeend[<?=$dayval[$i]?>]" id="timeend" value="<?=$endtime;?>" />
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
                            
                        }
                    ?>
                    <tr>
                        <td colspan="3">
                            <button type="submit" class="btn btn-sm btn-success">Simpan <i class="fa fa-clock-o"></i></button>
                        </td>
                    </tr>
            </tbody>
        </table>
        </form>
        
        <table class="table table-bordered table-striped <?=$twhide?> " id="show-set-tw" style="width: 100%">
            <thead>
                <tr>
                    <th width="150">Tanggal</th>
                    <th width="150">Waktu</th>
                </tr>
            </thead>
            <tbody>
                <form action="<?=base_url('role/settimeaccessprosestw/');?>" method="POST">
                    <?php
                        if($ceklogtime->num_rows() > 0 && $ceklogtime->row()->datestart != null ){
                            $datestart = date("d/m/Y",strtotime( $ceklogtime->row()->datestart ));
                            $dateend = date("d/m/Y",strtotime( $ceklogtime->row()->dateend ));
                            $range = $datestart.' - '.$dateend;
                            $timestart = unserialize($ceklogtime->row()->time)[0]['timestart'];
                            $timeend = unserialize($ceklogtime->row()->time)[0]['timeend'];
                        }else{
                            $range = null;
                            $timestart = '08:00';
                            $timeend = '17:00';
                        }
                    ?>
                    <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />
                    <input type="hidden" name="idrole" value="<?=$dt->idrole?>" />
                    <tr>
                        <td>
                            <input class="form-control rangepicker" name="range" id="range"/>
                        </td>
                        <td>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon">Dari Jam</span>
                                    <input class="form-control timepicker" name="timestart" id="timestart" value="<?=$timestart?>" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <span class="input-group-addon">Sampai Jam</span>
                                    <input class="form-control timepicker" name="timeend" id="timeend" value="<?=$timeend?>" />
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="btn btn-sm btn-success">Simpan <i class="fa fa-clock-o"></i></button>
                        </td>
                    </tr>
                </form>
            </tbody>
        </table>
    </div>

  </div>

</section>

<script src="<?=base_url("assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/moment/min/moment.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")?>"></script>
<script type="text/javascript">  
  $(function () {
    $(document).on("change","#waktu",function(){
      var thisval = $(this).val();
      if(thisval == "Y"){
          $("#show-set-hw").addClass("hide");
          $("#show-set-tw").addClass("hide");
          $(".btn-ya-ya").removeClass("hide");
      }else if(thisval == "HW"){
          $("#show-set-hw").removeClass("hide");
          $("#show-set-tw").addClass("hide");
          $(".btn-ya-ya").addClass("hide");
      }else if(thisval == "TW"){
          $("#show-set-hw").addClass("hide");
          $(".btn-ya-ya").addClass("hide");
          $("#show-set-tw").removeClass("hide");
      }
    });
    $('.timepicker').timepicker({
        showInputs: false,
        showSeconds: false,
        showMeridian: false,
        maxHours:24
    });
    $('.rangepicker').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        }
    });
    
        <?php
            if( $ceklogtime->num_rows() > 0 && $ceklogtime->row()->datestart != null ){
                $datestart = date("d/m/Y",strtotime( $ceklogtime->row()->datestart ));
                $dateend = date("d/m/Y",strtotime( $ceklogtime->row()->dateend ));
        ?>
        $('.rangepicker').data('daterangepicker').setStartDate('<?=$datestart?>');
        $('.rangepicker').data('daterangepicker').setEndDate('<?=$dateend?>');
        <?php } ?>
  });
</script>