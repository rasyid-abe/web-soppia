<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="width:200px;color:#00008B">Proforma Kontrak Pelatihan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_ProformaKontrak?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Perusahaan/Instansi</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_PershInstansi?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Nilai Rp</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc">Rp. <?=number_format($dtdefault->Nilai_Rp)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Rencana Jumlah Peserta</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Rencana_JmlPeserta?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Rencana Tempat Penyelenggaraan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Rencana_TempatSelenggara?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">File Lampiran</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc">
		    
		    
            <?php
                if($dtdefault!=null){
                    if( @unserialize($dtdefault->File_Lampiran) !=  false){
            ?>
                <div style="max-height:150px;overflow:auto">
                    <?php
                        foreach(unserialize($dtdefault->File_Lampiran) as $val ){
                            
                                if($val == 'a:0:{}' || $val == null || $val == ''){
                                
                            }else{
                    ?>
                             <a href="<?=base_url('uploads/fileapps/proformakontrak/'.$val)?>" download> <?=$val?></a> <?=gettimefile($val)?> <br/> <br/>
                    <?php
                            }
                        }
                    ?>
                </div>
            <?php
                    }else{
                        if($dtdefault->File_Lampiran != null && $dtdefault->File_Lampiran != 'a:0:{}' ){
            ?>
                        <a href="<?=base_url('uploads/fileapps/proformakontrak/'.$dtdefault->File_Lampiran)?>" download> <?=$dtdefault->File_Lampiran?></a> <?=gettimefile($dtdefault->File_Lampiran)?>
            <?php
                        }
                    }
                }
            ?>
		<?php
		    /*if(file_exists(base_url('uploads/fileapps/proformakontrak/'.$dtdefault->File_Lampiran))){
		        echo '<a href="'.base_url('uploads/fileapps/proformakontrak/'.$dtdefault->File_Lampiran).'" download><i class="fa fa-download"></i> File Lampiran</a>';
		    }else{
		        echo 'Saat ini belum ada file!';
		    }*/
	    ?>
	    </td>
	</tr>
</table>