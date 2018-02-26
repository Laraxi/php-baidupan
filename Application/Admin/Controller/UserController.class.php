<?php

namespace Admin\Controller;


class UserController extends CommonController
{

    const password = '******';

    public function index()
    {
        $data = M('User')->where(array('status' => 1))->select();
        $this->assign(array(
            'data' => $data
        ))->display();
    }

    public function add()
    {
        if (IS_POST) {
            $model = M('User');
            $username = $_POST['username'];
            $password = $_POST['password'];
            $re_password = $_POST['re_password'];
            if (!$username || !$password || !$re_password) $this->error('数据为必填项');
            if ($password != $re_password) $this->error('两次密码不一致');
            if ($model->where(array('username' => $username))->find()) $this->error('用户名已经存在');

            $data = array(
                'username' => $username,
                'password' => md5($password),
                'reg_time' => time(),
            );
            $res = $model->add($data);
            if ($res > 1) {
                $this->success('新增成功', U('index'));
            } else {
                $this->error('新增失败');
            }
        } else {
            $this->display();
        }
    }


    public function edit($id)
    {
        $model = M('User');
        if (IS_POST) {
            $model = M('User');
            $username = $_POST['username'];
            $password = $_POST['password'];
            $re_password = $_POST['re_password'];
            if (!$username || !$password || !$re_password) $this->error('数据为必填项');

            if (!empty($password) && $password) {
                $data = array(
                    'username' => $username,
                    'password' => md5($password)
                );
                if ($model->where(array('id' => $id))->save($data) !== false) {
                    $this->success('修改成功', U('index'));
                } else {
                    $this->error('修改失败');
                }
            }


        } else {
            if (empty($id)) $this->redirect('index');
            $info = $model->where(array('id' => $id))->find();

            $this->assign(array(
                'info' => $info,
                'password' => self::password
            ))->display();
        }
    }


    public function del($id)
    {
        if (empty($id)) $this->redirect('index');
        $res = M('User')->where(array('id' => $id))->delete();
        if (!$res) {
            $this->error('删除失败');
        } else {
            $this->success('删除成功');
        }

    }


}