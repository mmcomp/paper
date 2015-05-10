<?php
class Profile_model extends CI_Model {
    public $user;
    public function loadUser($user_id)
    {
        $this->user = new user_class($user_id);
        return($this->user);
    }
    public function auth($user,$pass)
    {
        $this->user = new user_class;
        $this->user->auth($user, $pass);
    }
    public function add($data)
    {
        $out = -1;
        $my = new mysql_class;
        $tarikh_p = $data['sal'].'/'.$data['mah'].'/'.$data['rooz'];
        $tarikh = $this->inc_model->jalaliToMiladi($tarikh_p);
        $data["tarikh_tavalod"] = $tarikh;
        unset($data["sal"]);
        unset($data["mah"]);
        unset($data["rooz"]);
        unset($data["pass2"]);
        $data['user'] = $data['code_melli'];
        $q = '';
        $f = '';
        $v = '';
        $my->ex_sql("select user,code_melli from user where user='".$data['user']."' or code_melli='".$data['code_melli']."'",$qq);
        if(isset($qq[0]))
        {
            $tuser = $qq[0]['user'];
            $tcode = $qq[0]['code_melli'];
            if($tuser == $data['user'])
                $out += -10;
            if($tcode == $data['code_melli'])
                $out += -100;
        }
        else
        {
            foreach($data as $key=>$value)
            {
                $f .= (($f=='')?'':',')."`$key`";
                $v .= (($v=='')?'':',')."'$value'";
            }
            if($f!='')
            {
                $q = "insert into `user` ($f) values ($v)";
                $ln = $my->ex_sqlx($q,FALSE);
                $out = $my->insert_id($ln);
                $my->close($ln);
            }
        }
        return($out);
    }
    public function edit($user_id,$data)
    {
        $my = new mysql_class;
        $update_qu='';
        foreach($data as $key=>$value)
        {
            if(!($key=='code_melli' || $key=='rooz' || $key=='mah'  || $key=='sal' || $key=='pass2' || $key=='pass_emza2' ))
            {    
                if($key=='pass')
                {    
                    if($value!='')
                    {    
                        $update_qu.= ($update_qu==''?'':',')."`$key`='$value'";
                    }    
                }
                else if($key=='pass_emza')
                {    
                    if($value!='')
                    {    
                        $update_qu.= ($update_qu==''?'':',')."`$key`='$value'";
                    }    
                }
                else
                {
                    $update_qu.= ($update_qu==''?'':',')."`$key`='$value'";
                }    
            } 
        }
        $tarikh_p = $data['sal'].'/'.$data['mah'].'/'.$data['rooz'];
        $tarikh = $this->inc_model->jalaliToMiladi($tarikh_p);
        if($update_qu!='')
        {
            $q = "update `user` set $update_qu,tarikh_tavalod='$tarikh' where id=$user_id";
            //echo $q;
            $my->ex_sqlx($q);
        }
    }
    public function loadMenu()
    {
        $menu_and_paper = array(
            1 => array(
                "کارتابل" => site_url()."paper_cartable/normal",
                "ثبت نامه جدید" => site_url()."paper_new",
                "نامه های ارسالی" => site_url()."paper_cartable/sent",
                "بایگانی" => site_url()."paper_cartable/archive",
                "پیشنویس ها" => site_url()."paper_cartable/pishnevis",
                "پروفایل" => site_url()."profile",
                "مدیریت کاربران"=> site_url()."user_edit"
            ),
            2 => array(
                "کارتابل" => site_url()."paper_cartable/normal",
                "ثبت نامه جدید" => site_url()."paper_new",
                "نامه های ارسالی" => site_url()."paper_cartable/sent",
                "بایگانی" => site_url()."paper_cartable/archive",
                "پیشنویس ها" => site_url()."paper_cartable/pishnevis",
                "پروفایل" => site_url()."profile"        
            ),
            3 => array(
                "کارتابل" => site_url()."paper_cartable/normal",
                "ثبت نامه جدید" => site_url()."paper_new",
                "نامه های ارسالی" => site_url()."paper_cartable/sent",
                "بایگانی" => site_url()."paper_cartable/archive",
                "پیشنویس ها" => site_url()."paper_cartable/pishnevis",
                "پروفایل" => site_url()."profile"        
            )
        );
        $menu_no_paper = array(
            1 => array(
                "پروفایل" => site_url()."profile",
                "مدیریت کاربران"=> site_url()."user_edit"
            ),
            2 => array(
                "پروفایل" => site_url()."profile"        
            ),
            3 => array(
                "پروفایل" => site_url()."profile"        
            )
        );
        $conf = new conf();
        if($conf->hasPaper===TRUE)
            $m = $menu_and_paper[$this->user->group_id];
        else
            $m = $menu_no_paper[$this->user->group_id];
        return($m);
    }
} 