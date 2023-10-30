<!-- =============================================== -->

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?=base_url('assets/images/avatar04.png')?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?=ucfirst(fullname())?></p>
        <a><i class="fa fa-circle text-success  animated infinite pulse"></i> Online</a>
        <a href="<?=base_url('profil')?>"><i class="fa fa-user"></i> Profil</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
     <?php
      foreach ($label->result() as $lbl) {
        $namelabel = $this->db->where(array('idlabelmenu'=>$lbl->labelmenu))->get("labelmenu");
        if($namelabel->num_rows()>0){
          $ceklblvmn = $this->db->where(array('labelmenu'=>$lbl->labelmenu,'kategori !='=>'sub'))->get("menu");
          
          if($ceklblvmn->num_rows() <= 0 ){

          }else{
            $tglandpar = $this->db
            ->where(array(
              'labelmenu'=>$lbl->labelmenu,
              'active'=>'1',
            ))->order_by("urutan","ASC")->get('menu');
            $cax = 0;
              foreach ($tglandpar->result() as $tglpr) {
                  if( checkaccessmenu($this->session->userdata('username'),$tglpr->idmenu) ){
                      if($tglpr->parent == null || $tglpr->parent ==''){
                          $cax = $cax+1;
                      }else{
                          $cax = $cax+0;
                      }
                  }else{
                      $cax = $cax+0; 
                  }
              }
              $cax = $cax;
              //echo $cax;
            if($cax != 0){
      ?>
      <li class="header"><?=$namelabel->row()->name?></li>
      <?php
            }
          }
        }//LABEL
        $tglandpar = $this->db
        ->where(array(
          'labelmenu'=>$lbl->labelmenu,
          'active'=>'1',
        ))->order_by("urutan","ASC")->get('menu');
          foreach ($tglandpar->result() as $tglpr) {
            $url = ($tglpr->url != null || $tglpr->url != '')? 'href="'.base_url($tglpr->url).'"' :'href="#"';
            $class = ($tglpr->url != null || $tglpr->url != '')? '' :'treeview';
            $checkpar = ($tglpr->url != null || $tglpr->url != '')? 'parentnochild' : 'parentwithchild';
            $actparent = (parentactivemenu( $tglpr->idmenu,$this->uri->segment(1) ))? 'active':'';
      ?>
      <?php 
          if( checkaccessmenu($this->session->userdata('username'),$tglpr->idmenu) ){
            if($tglpr->parent == null || $tglpr->parent ==''){
      ?>
        <li class="<?=$class.' '.$actparent?>  ">
          <a <?=$url?> style="display: block"  ><i class="<?=$tglpr->icon?>"></i> <span data-toggle="popover" data-placement="top" data-trigger="hover" data-content="<?=$tglpr->description?>" title="Keterangan" ><?=$tglpr->name?></span>
            <?php
              if($checkpar =='parentwithchild'){
            ?>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            <?php
              }//CHECKPAR 
            ?>
          </a>
          <?php
          if($checkpar == "parentwithchild"){
          ?>
            <ul class="treeview-menu">
              <?php
                $getchild = $this->db->where(array(
                  'parent'=>$tglpr->idmenu,
                  'active'=>'1',
                ))->order_by('urutan','ASC')->get("menu");
                foreach ($getchild->result() as $child) {
                  //$classchld = ($tglpr->url != null || $tglpr->url != '')? '' :'treeview';
                  //$urlchild = ($child->kategori != 'sub')? 'href="'.base_url($child->url).'"':'href="'.base_url('submenu/index/'.$child->idmenu).'"';
                  $urlchild = ($child->kategori != 'sub')? 'href="'.base_url($child->url).'"':'href="#"';
                  $ckkzz = ($this->db->where(array('parent'=>$child->idmenu))->get("menu")->num_rows() < 1 ) ? 'parentnochild' : 'parentwithchild';
                  $classchld = ($this->db->where(array('parent'=>$child->idmenu))->get("menu")->num_rows() < 1 ) ? '' :'treeview';
                  $actchild = (childactivemenu( $child->idmenu,$this->uri->segment(1) ))? 'active':'';
                  if( checkaccessmenu($this->session->userdata('username'),$child->idmenu) ){
              ?>
              <li class="<?=$classchld?> <?=$actchild?>"><a <?=$urlchild?> style="padding-left:30px;" ><i class="<?=$child->icon?>"></i> <span data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?=$child->description?>" title="Keterangan" ><?=$child->name?></span>
                <?php
                  if($ckkzz =='parentwithchild'){
                ?>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                <?php
                  }//CHECKPAR 
                ?>
              </a>
               <?php
                  if($ckkzz =='parentwithchild'){
                ?>
                <ul class="treeview-menu">
                  <?php
                    $getchildxx = $this->db->where(array(
                      'parent'=>$child->idmenu,
                      'active'=>'1',
                    ))->order_by("urutan","ASC")->get("menu");
                    foreach ($getchildxx->result() as $childxx) {
                      $actchildxx = (childactivemenu( $childxx->idmenu,$this->uri->segment(1) ))? 'active':'';
                      if( checkaccessmenu($this->session->userdata('username'),$childxx->idmenu) ){
                  ?>
                      <li class="<?=$actchildxx?>"><a href="<?=base_url($childxx->url)?>" style="padding-left:30px;" ><i class="<?=$childxx->icon?>"></i> <span data-toggle="popover" data-trigger="hover" data-placement="top" data-content="<?=$childxx->description?>" title="Keterangan" ><?=$childxx->name?> </span></a></li>
                      <?php
                        }
                      }
                      ?>
                </ul>
                <?php
                  }
                ?>
              </li>
              <?php
                  }//checkaccessmenu
                }//FOREACH GETCHILD
              ?>
            </ul>
          <?php
          }// CHECKPAR
          ?>
        </li>
      <?php
            }//checkparentnullempty
          }//checkaccessmenu
          }//tglandpar
        }//label
      ?>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>

<!-- =============================================== -->