<select name="labelmenu" class="form-control select2" style="width: 100%;">
  <option value="" readonly disabled selected>LABEL MENU</option>
  <?php
  foreach ($label->result() as $lb) {
  ?>
  <option value="<?=$lb->idlabelmenu?>" ><?=$lb->name?></option>
  <?php
  }
  ?>
</select>