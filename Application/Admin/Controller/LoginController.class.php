<?php

namespace Admin\Controller;

use Think\Controller;

class LoginController extends Controller
{
    public function index()
    {
        if ($_POST) {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (mb_strlen($username, 'utf-8') < 1) {
                $this->error('用户名不为空');
            }
            if (mb_strlen($password, 'utf-8') < 1) {
                $this->error('密码不为空');
            }
            $model = M('Admin');
            $user = $model->where(['username' => $username])->find();
            if (!$user || $user['password'] != md5($password)) {
                $this->error('用户名或者密码不正确');
            }
            if ($user['status'] == 2) {
                $this->error('当前用户已锁定，请联系管理员');
            }
            $model->login_time = time();
            $model->save();
            session('admin_login', $user);
            $this->success('登陆成功', U('index/index'));

        } else {
            $this->display();
        }
    }

    public function logout()
    {
        session('admin_login', null);
        $this->redirect('index');
    }


}