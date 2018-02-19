<?php

namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{
    /**
     *  'id' => string '1' (length=1)
     * 'username' => string 'admin' (length=5)
     * 'password' => string 'e10adc3949ba59abbe56e057f20f883e' (length=32)
     * 'status' => string '1' (length=1)
     * 'login_time' => string '0' (length=1)
     */

    public function __construct()
    {
        parent::__construct();
        if (session('admin_login')['id'] < 1) {
            $this->error('你未登录，请先去登陆',U('login/index'));
        }
    }


}