<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    if(!$this->agent->is_mobile())
    {    
        //echo $this->contents_model->loadSlider();
    }    
    //echo $this->contents_model->loadMainMenu();
    //$mostRead = $this->visitor_model->drawMostRead($this->visitor_model->mostRead());
    //$mostRead = $this->visitor_model->drawAllMostRead(4);
    $conf = new conf();
    if($conf->home_page!='home' and trim($conf->home_page)!='')
	    redirect($conf->home_page);
?>
<div class="row" >
    <div class="col-sm-2" >
        <div class="hs-margin-up-down hs-gray hs-padding hs-border" >
              امکانات
        </div>
        <div class="hs-margin-up-down hs-padding hs-border" >
            <ul class="nav nav-pills nav-stacked">
            <?php
                echo $menu_links;
            ?>
            </ul>
        </div>
    </div>
    <div class="col-sm-8" >
        <div class="hs-margin-up-down" >
       <?php
            //echo $this->contents_model->loadHome();
            echo $msg;
        ?>
        </div>
    </div>
    
    <div class="col-sm-2"  >
        <div class="hs-margin-up-down hs-gray hs-padding hs-border" >
            ورود کد ملی
        </div>
        <div>
            <?php echo form_open('home',array('id'=>'frm1'));  ?>
            <input type="number" name="s_code_melli" class="form-control" >
            <button class="form-control btn btn-default hs-margin-up-down" >
                جستجوی سریع
            </button>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
