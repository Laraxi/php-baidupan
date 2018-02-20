<?php

namespace Home\Controller;

use Think\Controller;

class UserController extends Controller
{
    public function index()
    {
        $this->display();
    }


    public function login()
    {
        if ($_POST) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (mb_strlen($username, 'utf-8') < 1) $this->error('用户名不为空');
            if (mb_strlen($password, 'utf-8') < 1) $this->error('密码不为空');
            $model = M('User');
            $user = $model->where(array('username' => $username))->find();
            if (!$user || $user['password'] != md5($password)) $this->error('用户或者密码不正确');
            session('home_login_id', $user['id']);
            session('home_login_username', $user['username']);
            $model->login_time = time();
            $model->save();
            $this->success('登录成功', U('index/index'));
        } else {
            $this->display();
        }

    }


    public function register()
    {
        if ($_POST) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $re_password = $_POST['re_password'];
            if (mb_strlen($username, 'utf-8') < 1) $this->error('用户名不为空');
            if (!preg_match('/^[a-zA-Z0-9]{3,10}$/', $username)) $this->error('用户名必须是字母数字并且长度必须为3到10位');
            if (mb_strlen($password, 'utf-8') < 1) $this->error('密码不为空');
            if (mb_strlen($re_password, 'utf-8') < 1) $this->error('确认密码不为空');
            if ($password != $re_password) $this->error('两次密码不一致');
            $model = M('User');
            $user = $model->where(array('username' => $username))->find();
            if ($user) $this->error('用户名已经存在，请你换一个用户名');
            $data = array(
                'username' => $username,
                'password' => md5($password),
                'reg_time' => time(),
            );
            $res = $model->add($data);
            if ($res > 1) {
                $this->success('注册成功', U('login'));
            } else {
                $this->error('注册失败');
            }
        } else {
            $this->display();
        }
    }


    public function logout()
    {
        session('home_login_id',null);
        session('home_login_username',null);
        $this->redirect('index/index');
    }


}