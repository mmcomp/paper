<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $msg = '';
    $user_id1 = $user_id;
    if(trim($p1)!='')
        $user_id1 = (int)$p1;
    if(isset($_REQUEST['s_user_id']))
    {
        $user_id1 = (int)$_REQUEST['s_user_id'];
    }
    if($this->input->post('fname')!==FALSE)
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('fname', 'نام ', 'required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('lname', 'نام خانوادگی ', 'required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('email', 'نشانی ایمیل', 'required|valid_email');
        $this->form_validation->set_rules('mob', 'تلفن همراه', 'required|is_natural');
        $this->form_validation->set_rules('tell', 'تلفن ثابت', 'required|is_natural');
        if($this->form_validation->run()!==FALSE)
        {
            $this->profile_model->edit($user_id1,$_REQUEST);
            $msg="<div class='alert alert-success' >
                ذخیره سازی با موفقیت انجام شد
                  </div>";
        }
    } 
    $this->profile_model->loadUser($user_id1);
    $user_obj = $this->profile_model->user;
    $men = $this->profile_model->loadMenu();
    $menu_links = '';
    foreach($men as $title=>$href)
    {
        $tmp = explode('/', $href);
        $active = ($tmp[2]==$page_addr);
        $active2 = TRUE;
        if(isset($tmp[3]) && trim($p1)!='' && $tmp[3]!=$p1)
            $active2 = FALSE;
        $active = ($active & $active2);
        $menu_links .= "<li role='presentation'".(($active)?" class='active'":"")."><a href='$href'>$title</a></li>";
    }
       
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
<!--</div>
<div class="row" >-->
    <!--
    <div class="col-sm-8 col-sm-offset-2  hs-border hs-default hs-padding hs-margin-up-down" >
        فرم ثبت نام
    </div>
    -->
    <?php echo form_open('',array('id'=>'frm_profile'))  ?>
    <div class="col-sm-10" >
        <div  class="hs-margin-up-down hs-gray hs-padding hs-border mm-negative-margin" >
            پروفایل
        </div>
        <?php echo $msg.validation_errors(); ?>
        <div class="col-sm-6  hs-margin-up-down" >
            نام:
            <input class="form-control" name="fname" id="fname" placeholder="نام" value="<?php echo $user_obj->fname; ?>" >
        </div>
        <div class="col-sm-6 hs-margin-up-down" >
            نام خانوادگی:
            <input class="form-control" name="lname" id="lname" placeholder="نام خانوادگی" value="<?php echo $user_obj->lname; ?>" >
        </div>

        <div class="col-sm-6  hs-margin-up-down" >
            کد ملی (نام کاربری):
            <input readonly="readonly" class="form-control" name="code_melli" id="code_melli" placeholder="کد ملی (نام کاربری)" value="<?php echo $user_obj->code_melli; ?>" >
        </div>
        <div class="col-sm-6  hs-margin-up-down datetime" >
            <div>
                تاریخ تولد:
            </div>
            <select class="form-inline hs-little-select" name="rooz" id="rooz"  >
                <option value="0" >
                    روز
                </option>
                <?php
                    echo $this->inc_model->genOption(1,31,$user_obj->rooz);
                ?>
            </select>
            /
            <select class="form-inline hs-little-select" name="mah" id="mah" >
                <option value="0" >
                    ماه
                </option>
                <?php
                    echo $this->inc_model->genOption(1,12,$user_obj->mah);
                ?>
            </select>
            /
            <select class="form-inline hs-little-select" name="sal" id="sal" style="width:62px">
                <option value="0" >
                    سال
                </option>
                <?php
                    echo $this->inc_model->genOption(1300,95,$user_obj->sal);
                ?>
            </select>
        </div>
        <div class="hs-margin-up-down" style="margin-right:15px;" >
            درصورت خالی گذاشتن ، رمز عبور بدون تغییر باقی خواهد ماند
        </div>
        <div class="col-sm-6 hs-margin-up-down" >
            رمز عبور:
            <input type="password" class="form-control" name="pass" id="pass" placeholder="رمز عبور" >
        </div>
        <div class="col-sm-6  hs-margin-up-down" >
            تکرار رمز عبور:
            <input type="password" class="form-control" name="pass2" id="pass2" placeholder="تکرار رمز عبور" >
        </div>
        <div class="hs-margin-up-down" style="margin-right:15px;" >
            درصورت خالی گذاشتن ، رمز امضای دیجیتال بدون تغییر باقی خواهد ماند
        </div>
        <div class="col-sm-6 hs-margin-up-down" >
            رمز امضا دیجیتال :
            <input type="password" class="form-control" name="pass_emza" id="pass" placeholder="رمز امضا دیجیتال" >
        </div>
        <div class="col-sm-6  hs-margin-up-down" >
            تکرار رمز امضا دیجیتال :
            <input type="password" class="form-control" name="pass_emza2" id="pass2" placeholder="تکرار رمز امضا دیجیتال" >
        </div>
        <div class="col-sm-6  hs-margin-up-down" >
            شغل:
            <select class="form-control" name="shoghl_id" id="shoghl_id" >
                <option value="0" >
                    انتخاب شغل
                </option>
                <?php
                    echo shoghl_class::loadAll(TRUE,$user_obj->shoghl_id);
                ?>
            </select>
        </div>
        <div class="col-sm-6  hs-margin-up-down datetime" >
            تحصیلات:
            <select class="form-control" name="tahsilat_id" id="tahsilat_id" >
                <option value="0" >
                    انتخاب تحصیلات
                </option>
                <?php
                    echo tahsilat_class::loadAll(TRUE,$user_obj->tahsilat_id);
                ?>
            </select>    
        </div>
        <div class="col-sm-6  hs-margin-up-down" >
            گروه خونی:
            <select class="form-control" name="grooh_khooni_id" id="grooh_khooni_id"  >
                <option value="0" >
                    گروه خونی
                </option>
                <?php
                    echo grooh_khooni_class::loadAll(TRUE,$user_obj->grooh_khooni_id);
                ?>
            </select>
        </div>
        <div class="col-sm-6  hs-margin-up-down" >
            تلفن ثابت:
            <input type="number" class="form-control" name="tell" id="tell" placeholder="تلفن ثابت" value="<?php echo $user_obj->tell; ?>">
        </div>
        <div class="col-sm-6 hs-margin-up-down" >
            تلفن همراه:
            <input type="number" class="form-control" name="mob" id="mob" placeholder="تلفن همراه" value="<?php echo $user_obj->mob; ?>">
        </div>
        <div class="col-sm-6 hs-margin-up-down" >
            نشانی ایمیل:
            <input class="form-control" name="email" id="email" placeholder="نشانی ایمیل" value="<?php echo $user_obj->email; ?>">
        </div>
        <div class="col-sm-12 hs-margin-up-down" >
            نشانی:
            <textarea class="form-control" rows="5" name="address" id="address" placeholder="نشانی" ><?php echo $user_obj->address; ?></textarea>
        </div>
        <div class="col-sm-6  hs-margin-up-down" >
            <button class="btn hs-btn-default" >ویرایش</button>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>