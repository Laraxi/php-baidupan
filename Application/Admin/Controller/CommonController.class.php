<?php

namespace Admin\Controller;

use Think\Controller;

class CommonController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        if (session('admin_login')['id'] < 1) {
            $this->error('你未登录，请先去登陆',U('login/index'));
        }
    }


}