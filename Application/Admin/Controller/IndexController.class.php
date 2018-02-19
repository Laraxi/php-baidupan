<?php

namespace Admin\Controller;


class IndexController extends CommonController
{
    /**
     *  'id' => string '1' (length=1)
        'username' => string 'admin' (length=5)
        'password' => string 'e10adc3949ba59abbe56e057f20f883e' (length=32)
        'status' => string '1' (length=1)
        'login_time' => string '0' (length=1)
     */
    public function index()
    {
//        var_dump(session('admin_login')['id']);
        $this->display();
    }


    public function welcome()
    {
        $this->display();
    }




}