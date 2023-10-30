<table class="table table-bordered table-striped" style="width: 100%">

	<tr>
		<td valign="top" style="color:#00008B" width="200px">Kategori AT dan Inventaris</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
		        $data = $dtdefault->FId_ATnInvent;
        	    $getno = '' ;
        	    if($data != null || $data != ''){
        	        $getno = $this->db->where(array("Id_AT_n_Invent"=>$data))->get("mst_at_n_invent");
        	        $getno = $getno->row()->no_at_inv;
        	    }else{
        	        $getno = "<code>N/A</code>";
        	    }
        	    echo $getno;
		?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">No AT dan Inventaris</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?php
        	    $getflag = '' ;
        	    if($data != null || $data != ''){
        	        $getflag = $this->db->where(array("Id_AT_n_Invent"=>$data))->get("mst_at_n_invent");
        	        $getflag = $getflag->row()->Flag_AT_or_Inv;
        	        if($getflag == "INV"){
        	            $getflag = "INVENTARIS";
        	        }else{
        	            $getflag = "AKTIVA TETAP";
        	        }
        	    }else{
        	        $getflag = "<code>N/A</code>";
        	    }
        	    echo $getflag;
		?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Nama Barang</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc">
		    <?php
            	    $getnamabarang = '' ;
            	    if($data != null || $data != ''){
            	        $getnamabarang = $this->db->where(array("Id_AT_n_Invent"=>$data))->get("mst_at_n_invent");
            	        $getnamabarang = $getnamabarang->row()->Desc_AT_n_Invent;
            	    }else{
            	        $getnamabarang = "<code>N/A</code>";
            	    }
            	    echo $getnamabarang;
            	
		    ?>
		</td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Penanggung Jawab</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->PenanggungJwb?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tanggal Pinjam</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_TransaksiAwal)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Tanggal Kembali</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=tgl_indo($dtdefault->Tgl_TransaksiAkhir)?></td>
	</tr>
	<tr>
		<td valign="top" style="color:#00008B">Keterangan</td>
		<td valign="top">:</td>
		<td valign="top" style="color:#9900cc"><?=$dtdefault->Keterangan?></td>
	</tr>
</table>