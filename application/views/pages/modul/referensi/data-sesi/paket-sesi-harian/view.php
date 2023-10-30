<table class="table table-bordered table-striped" style="width: 100%">
	<tr>
		<td valign="top" style="color:#00008B">Nama Paket Sesi harian</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Desc_Paket_Sesi_Harian?></td>
	</tr>
</table>
<hr/>
<table class="table table-bordered table-striped" style="width: 100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Jam Sesi</th>
        </tr>
    </thead>
    <?php
        if($sesi->num_rows()>0){
            $i=1;
            foreach($sesi->result() as $ss){
        ?>
            <tr>
                <td width="20"><?=$i?></td>
                <td><?php
                
                $dtpktharian = $this->db->where(array("Kd_Sesi_Satuan"=>$ss->FKd_Sesi_Satuan))->get("ref_sesi_satuan");
                if($dtpktharian->num_rows()>0){
                    echo $dtpktharian->row()->Desc_Sesi;
                }else{
                    
                }
                ?></td>
            </tr>
        <?php
            $i++;
            }
        }else{
        ?>
        <tr>
            <td colspan="2" class="text-center">Sesi Belum ada</td>
        </tr>
        <?php
        }
    ?>  
</table>