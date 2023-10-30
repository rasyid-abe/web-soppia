<div class="container-fluid" style="margin:0;padding: 0">
	<div class="form-group col-sm-12">
	  <div class="col-sm-12">
	    <input name="text" class="form-control" name="labelmenu" id="labelmenu-modal" placeholder="Name" required>
	  </div>
	</div>

	<div class="form-group col-sm-12"> 
	  <div class="col-sm-12">
	    <button type="button" class="btn btn-block btn-flat save-labelmenu-modal">Save</button>
	  </div>
	</div>
	<br/>
	<?php if($data !=null) {?>
	<div class="form-group col-sm-12"> 
	  <div class="col-sm-12">
	    <div class="alert alert-danger"> Gagal! Data tersebut sudah ada!</div>
	  </div>
	</div>
	<?php } ?>
</div>