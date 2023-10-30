<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="width:220px;color:#00008B">SK Pembukaan Kelas Reguler</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_DokBukaKlsReguler?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Rencana Tempat Penyelenggaraan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Rencana_TempatSelenggara?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">File Lampiran</td>
		<td valign="top">:</td>
		<td valign="top">
		    
		<?php
                            
                            if($dtdefault->File_Lampiran!=null){
                                if( @unserialize($dtdefault->File_Lampiran) !=  false){
                        ?>
                            <div style="max-height:150px;overflow:auto">
                                <?php
                                    foreach(unserialize($dtdefault->File_Lampiran) as $val ){
                                    if($val == 'a:0:{}' || $val == null || $val == ''){
                                            
                                        }else{
                                ?>
                                        <a href="<?=base_url('uploads/fileapps/non-iht/'.$val)?>" download> <?=$val?></a> <br/> <br/>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        <?php
                                }else{
                                    if($dtdefault->File_Lampiran != null && $dtdefault->File_Lampiran != 'a:0:{}' ){
                        ?>
                                    <a href="<?=base_url('uploads/fileapps/non-iht/'.$dtdefault->File_Lampiran)?>" download> <?=$dtdefault->File_Lampiran?></a>
                        <?php
                                    }
                                }
                            }
                        ?>
		    
		</td>
	</tr>
</table>