<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/select2/dist/css/select2.min.css")?>">
<link rel="stylesheet" href="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css")?>">
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
        <br>
        <div class="alert alert-danger"><?=$this->session->flashdata('error')?></div>
    <?php }else if($this->session->flashdata('success')){ ?>
        <br>
        <div class="alert alert-success"><?=$this->session->flashdata('success')?></div>
    <?php } ?>

    <!-- Default box -->
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title"><?=$titlebox?></h3>

            <div class="box-tools pull-right">
                <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-box-tool" data-toggle="tooltip"
                    title="Kembali Ke Manage <?=$subtitlepage?>">
                    <i class="fa fa-arrow-circle-left"></i> Back
                </a>
                <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Refresh Page" onclick='location.reload();'>
                    <i class="fa fa-refresh"></i> Refresh
                </button>
            </div>
        </div>
    </div>
    <div class="row">
        <form action="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2)."/update/".$dtdefault->id_jadwal_pegawai_security)?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>" />

            <div class="col-sm-6">
                <div class="box" style="border-top:0px solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Jadwal Kerja</h3>
                    </div>
                    <div class="box-body">

                        <div class="col-sm-12 col-md-12">
                            <div class="col-sm-12 col-md-12 p-5">
                                <div class="form-group col-sm-12">
                                    <div class="col-sm-12" style="color:#00008B">
                                        Jadwal Senin<br/>
                                        <select class="form-control" name="senin">
                                            <?php if($dtdefault->jadwal_senin_security == null){ ?>
                                                <option value="">Pilih</option>
                                            <?php } else { ?>
                                                <option><?=$dtdefault->jadwal_senin_security?></option>
                                                <option value="">Pilih</option>
                                            <?php } ?>
                                            <?php foreach ($shifting as $row) { ?>
                                                <option><?= $row->shift_jadwal; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-12" style="color:#00008B">
                                        Jadwal Selasa<br/>
                                        <select class="form-control" name="selasa">
                                            <?php if($dtdefault->jadwal_selasa_security == null){ ?>
                                                <option value="">Pilih</option>
                                            <?php } else { ?>
                                                <option><?=$dtdefault->jadwal_selasa_security?></option>
                                                <option value="">Pilih</option>
                                            <?php } ?>
                                            <?php foreach ($shifting as $row) { ?>
                                                <option><?= $row->shift_jadwal; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-12" style="color:#00008B">
                                        Jadwal Rabu<br/>
                                        <select class="form-control" name="rabu">
                                            <?php if($dtdefault->jadwal_rabu_security == null){ ?>
                                                <option value="">Pilih</option>
                                            <?php } else { ?>
                                                <option><?=$dtdefault->jadwal_rabu_security?></option>
                                                <option value="">Pilih</option>
                                            <?php } ?>
                                            <?php foreach ($shifting as $row) { ?>
                                                <option><?= $row->shift_jadwal; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-12" style="color:#00008B">
                                        Jadwal Kamis<br/>
                                        <select class="form-control" name="kamis">
                                            <?php if($dtdefault->jadwal_kamis_security == null){ ?>
                                                <option value="">Pilih</option>
                                            <?php } else { ?>
                                                <option><?=$dtdefault->jadwal_kamis_security?></option>
                                                <option value="">Pilih</option>
                                            <?php } ?>
                                            <?php foreach ($shifting as $row) { ?>
                                                <option><?= $row->shift_jadwal; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-12" style="color:#00008B">
                                        Jadwal Jum'at<br/>
                                        <select class="form-control" name="jumat">
                                            <?php if($dtdefault->jadwal_jumat_security == null){ ?>
                                                <option value="">Pilih</option>
                                            <?php } else { ?>
                                                <option><?=$dtdefault->jadwal_jumat_security?></option>
                                                <option value="">Pilih</option>
                                            <?php } ?>
                                            <?php foreach ($shifting as $row) { ?>
                                                <option><?= $row->shift_jadwal; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-12" style="color:#00008B">
                                        Jadwal Sabtu<br/>
                                        <select class="form-control" name="sabtu">
                                            <?php if($dtdefault->jadwal_sabtu_security == null){ ?>
                                                <option value="">Pilih</option>
                                            <?php } else { ?>
                                                <option><?=$dtdefault->jadwal_sabtu_security?></option>
                                                <option value="">Pilih</option>
                                            <?php } ?>
                                            <?php foreach ($shifting as $row) { ?>
                                                <option><?= $row->shift_jadwal; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-sm-12">
                                    <div class="col-sm-12" style="color:#00008B">
                                        Jadwal Minggu<br/>
                                        <select class="form-control" name="minggu">
                                            <?php if($dtdefault->jadwal_minggu_security == null){ ?>
                                                <option value="">Pilih</option>
                                            <?php } else { ?>
                                                <option><?=$dtdefault->jadwal_minggu_security?></option>
                                                <option value="">Pilih</option>
                                            <?php } ?>
                                            <?php foreach ($shifting as $row) { ?>
                                                <option><?= $row->shift_jadwal; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="form-group col-sm-12">
                                <hr style="margin-bottom:0;margin-top:0" />
                            </div>

                            <div class="col-sm-4">
                                <button type="submit" class="btn btn-block btn-flat">Save</button>
                            </div>

                            <div class="col-sm-4">
                                <a href="<?=base_url($this->uri->segment(1).'/'.$this->uri->segment(2))?>" class="btn btn-danger btn-block btn-flat">Back</a>
                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </form>
    </div>
</section>

<script src="<?=base_url("assets/adminlte/bower_components/select2/dist/js/select2.full.min.js")?>"></script>
<script src="<?=base_url("assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js")?>"></script>
<script type="text/javascript">
$(function () {
    $('.select2').select2();
    $('.date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        todayHighlight:true,
    });
});
</script>
