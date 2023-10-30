<?php
	if(accessperm('melihat-data-proforma-kontrak')){ 
		if($kontrakresmi->num_rows()>0){
?>	
	<div class="box">
		<div class="box-header with-border">
			<div class="box-title">		
		        <?php
		           if(accessperm('merubah-data-kontrak-spk-resmi')){ 
		        ?>
		            <a data-href="<?=base_url("ajax/kontrakresmiedit/".$proforma->row()->Id_ProformaKontrak."/".$kontrakresmi->row()->Id_KontrakResmi)?>" class="btn btn-box-tool call-edit-kontrak-resmi-form" data-toggle="tooltip" title="Edit Data"> <i class="fa fa-pencil"></i> Edit Data</a>
		        <?php
		           }else{
		        ?>
		          <a class="btn btn-box-tool" data-toggle="tooltip" title="No Access"><i class="fa fa-pencil"></i> No Access</a>
		        <?php
		           }		          
		        ?>
		       <!--   <?php if(accessperm('mengimport-data-kontrak-spk-resmi')){ ?>        
		          <a href="" class="btn btn-box-tool" data-toggle="tooltip" title="Import Data"> <i class="fa fa-file-text"></i> Import Data</a>
		        <?php }else{?>
		          <a class="btn btn-box-tool" data-toggle="tooltip" title="No Access"><i class="fa fa-file-text"></i> No Access</a>
		        <?php }?> -->
			</div>
		</div>

		<div class="show-kontrakresmi">
			<div class="box-body" id="tampil">
				<table class="table table-bordered table-striped" style="width: 100%">			
		          <tr>
		            <td valign="top" style="color:#00008B">Proforma Kontrak Pelatihan</td>
		            <td valign="top">:</td>
		            <td valign="top" style="color:#9900cc"><?=$kontrakresmi->row()->Desc_ProformaKontrak?></td>
		          </tr>
		          <tr>
		            <td valign="top" style="color:#00008B">Perusahaan / Instansi</td>
		            <td valign="top">:</td>
		            <td valign="top" style="color:#9900cc"><?=$kontrakresmi->row()->Desc_PershInstansi?></td>
		          </tr>
				</table>
				<br/>
				<table class="table table-bordered table-striped" style="width: 100%">
		          <tr>
		            <td valign="top" colspan="3" class="text-right">
		              <?php
		              if(accessperm('menghapus-data-kontrak-spk-resmi')){
		                   $cekaddendum = $this->db->where(array("FId_ProformaKontrak"=>$proforma->row()->Id_ProformaKontrak))->get("mst_addendumkontrak");
		                  if($cekaddendum->num_rows()>0){
		                      $btn = '';
		                  }else{
		                    $btn = "<a href='".base_url("ajax/deletekontrakresmi/".$proforma->row()->Id_ProformaKontrak."/".$kontrakresmi->row()->Id_KontrakResmi)."' class='btn btn-sm btn-danger delete-data' data-toggle='tooltip' title='Delete Data'> <i class='fa fa-trash'></i> Delete </a>"; 
		                  }
		              }else{
		                $btn .= "<a class='btn btn-box-tool' data-toggle='tooltip' title='No Access'> <i class='fa fa-trash'></i> No Access </a>";
		              }
		              echo $btn;
		              ?>
		            </td>
		          </tr>
		          <tr>
		            <td valign="top" style="color:#00008B">Kontrak Resmi</td>
		            <td valign="top">:</td>
		            <td valign="top" style="color:#9900cc"><?=$kontrakresmi->row()->Desc_KontrakResmi?></td>
		          </tr>
		          <tr>
		            <td valign="top" style="color:#00008B">Nilai Rp</td>
		            <td valign="top">:</td>
		            <td valign="top" style="color:#9900cc">Rp. <?=number_format($kontrakresmi->row()->Nilai_Rp)?></td>
		          </tr>
		          <tr>
		            <td valign="top" style="color:#00008B">Rencana Jumlah Peserta</td>
		            <td valign="top">:</td>
		            <td valign="top" style="color:#9900cc"><?=$kontrakresmi->row()->Rencana_JmlPeserta?></td>
		          </tr>
		          <tr>
		            <td valign="top" style="color:#00008B">Rencana Tempat</td>
		            <td valign="top">:</td>
		            <td valign="top" style="color:#9900cc"><?=$kontrakresmi->row()->Rencana_TempatSelenggara?></td>
		          </tr>
		          <tr>
		            <td valign="top" style="color:#00008B">File Lampiran</td>
		            <td valign="top">:</td>
		            <td valign="top" style="color:#9900cc">
		                <?php
                            $proforma = $kontrakresmi->row();
                            if($proforma->File_Lampiran!=null){
                                if( @unserialize($proforma->File_Lampiran) !=  false){
                        ?>
                            <div style="max-height:150px;overflow:auto">
                                <?php
                                    foreach(unserialize($proforma->File_Lampiran) as $val ){
                                        if($val == 'a:0:{}' || $val == null || $val == ''){
                                            
                                        }else{
                                ?>
                                        <a href="<?=base_url('uploads/fileapps/kontrakresmi/'.$val)?>" download> <?=$val?></a>  <?=gettimefile($val)?> <br/> <br/>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        <?php
                                }else{
                                    if($proforma->File_Lampiran != null && $proforma->File_Lampiran != 'a:0:{}' ){
                        ?>
                                    <a href="<?=base_url('uploads/fileapps/kontrakresmi/'.$proforma->File_Lampiran)?>" download> <?=$proforma->File_Lampiran?></a>  <?=gettimefile($proforma->File_Lampiran)?>
                        <?php
                                    }
                                }
                            }
                        ?>
		            </td>
		          </tr>
		        </table>
	        </div>

			<div class="box-body hide" id="edit">
				
			</div>
        </div>
    </div>

	<div class="box">
	  <div class="box-header  with-border">
	    <h3 class="box-title">Accounting Jurnal</h3>
	  </div>
	  <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <table class="table table-bordered table-striped" style="width: 100%">
                    <thead>
                        <tr>
                          <td valign="top">Deskripsi</td>
                          <td valign="top">Status</td>
                          <td valign="top">Nilai</td>
                        </tr>
                    <thead>
               <?php
                foreach($acc_jur->result() as $accj){
                    if($accj->Flag_D_or_K == "D"){
                ?>
                    <tr class="success">
                      <td valign="top"><?php
                        $desc = $this->db->where(array("idproforma"=>$accj->FId_Proforma,"Flag_GrupAccount"=>"A","Flag_Proforma_or_Kelas"=>"P"))->get("mst_subaccount_soppia");
                        echo $desc->row()->Desc_Account;
                      ?></td>
                      <td valign="top">DEBIT</td>
                      <td valign="top"><?=number_format($accj->Nilai_Rps)?></td>
                    </tr>
                <?php
                    }
                }
               ?>
               </table>
               </div>
               <div class="col-sm-6">
                <table class="table table-bordered table-striped" style="width: 100%">
                    <thead>
                        <tr>
                          <td valign="top">Deskripsi</td>
                          <td valign="top">Status</td>
                          <td valign="top">Nilai</td>
                        </tr>
                    <thead>
               <?php
                foreach($acc_jur->result() as $accj){
                    if($accj->Flag_D_or_K == "K"){
                ?>
                    <tr class="warning">
                      <td valign="top"><?php
                        $desc = $this->db->where(array("idproforma"=>$accj->FId_Proforma,"Flag_GrupAccount"=>"R","Flag_Proforma_or_Kelas"=>"P"))->get("mst_subaccount_soppia");
                        echo $desc->row()->Desc_Account;
                      ?></td>
                      <td valign="top">KREDIT</td>
                      <td valign="top"><?=number_format($accj->Nilai_Rps)?></td>
                    </tr>
                <?php
                    }
                }
               ?>
               </table>
           </div>
       </div>
  </div>
	</div>
<?php
		}else{
?>
	<div class="box">

		<div class="box-header with-border">
			<div class="box-title">				
		        <?php
		          if($kontrakresmi->num_rows() <= 0){
		           if(accessperm('menambahkan-data-kontrak-spk-resmi')){ 
		        ?>
		            <a data-href="<?=base_url($this->uri->segment(1)."/".$this->uri->segment(2)."add/".$this->uri->segment(3))?>" class="btn btn-box-tool call-add-kontrak-resmi-form" data-toggle="tooltip" title="Add Kontrak Resmi"> <i class="fa fa-plus-circle"></i> Add Kontrak Resmi</a>
		        <?php 
		            }else{
		        ?>
		          <a class="btn btn-box-tool" data-toggle="tooltip" title="No Access"><i class="fa fa-plus-circle"></i> No Access</a>
		        <?php 
		            }
		          }
		        ?><!-- 
		         <?php if(accessperm('mengimport-data-kontrak-spk-resmi')){ ?>        
		          <a href="" class="btn btn-box-tool" data-toggle="tooltip" title="Import Data"> <i class="fa fa-file-text"></i> Import Data</a>
		        <?php }else{?>
		          <a class="btn btn-box-tool" data-toggle="tooltip" title="No Access"><i class="fa fa-file-text"></i> No Access</a>
		        <?php }?> -->
			</div>
		</div>
		<div class="box-body add-box-body">
		<?php
			if($this->session->flashdata("error")){				
				if( ($this->session->flashdata("active") == "kontrakresmi")){

				}
			}else{
		?>
	        <div class="alert alert-info alert-dismissible">
	          <a href="#" class="close" data-dismiss="alert" aria-label="close" style="text-decoration: none">&times;</a>
	          <strong>Maaf !</strong> Saat ini belum ada Kontrak SPK Resmi yang terkait proforma "<?=ucfirst($proforma->row()->Desc_ProformaKontrak)?>", anda dapat menambahkan data kontrak resmi terkait proforma "<?=ucfirst($proforma->row()->Desc_ProformaKontrak)?>" dengan mengklik tombol <kbd><i class="fa fa-plus-circle"></i> Add Kontrak Resmi</kbd>. 
	        </div>
		<?php
			}
		?>

        </div>
      </div>
<?php
		}
	}
?>
<script type="text/javascript">
	$(function(){
		$(document).on("click",".call-add-kontrak-resmi-form",function(){
			$(".add-box-body").html("");
			var link = $(this).attr("data-href");
			$(".add-box-body").load(link);
		});
		$(document).on("click",".call-edit-kontrak-resmi-form",function(){
			$(".show-kontrakresmi").find("#tampil").addClass("hide");
			var link = $(this).attr("data-href");
			$(".show-kontrakresmi #edit").load(link);
			$(".show-kontrakresmi").find("#edit").removeClass("hide");
		})
	});
</script>