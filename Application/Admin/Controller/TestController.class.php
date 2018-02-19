<?php

namespace Admin\Controller;

use Think\Model;

class TestController extends CommonController
{
    public $type = null;

    public function __construct()
    {
        parent::__construct();
        $this->type = 'index';
    }

    public function index()
    {
        $model = M('Test');
        $count = $model->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count, 5);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $Page->setConfig('header', '<span class="rows">共<b>%TOTAL_ROW%</b>条记录 第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</span>');
        $Page->setConfig('prev', '上一页');
        $Page->setConfig('next', '下一页');
        $Page->setConfig('last', '末页');
        $Page->setConfig('first', '首页');
        $Page->setConfig('theme', '%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $show = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $data = $model->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign('type', $this->type)
            ->assign('data', $data)
            ->assign('show', $show)->display();
    }

    public function add()
    {
        if ($_POST) {
//            var_dump($_FILES['logo']['error']);exit;
            $name = $_POST['name'];
            $content = $_POST['content'];
            if (mb_strlen($name, 'utf-8') < 1) {
                $this->error('测试名称不为空');
            }
            if (mb_strlen($content, 'utf-8') < 1) {
                $this->error('测试内容不为空');
            }
            $model = M('Test');
            if ($_FILES['logo']['error'] == 0) {

                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 3145728;// 设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath = './Uploads/'; // 设置附件上传根目录
                $upload->savePath = ''; // 设置附件上传（子）目录
                // 上传文件
                $info = $upload->upload();
                if (!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {// 上传成功 获取上传文件信息
                    foreach ($info as $file) {
                        $_POST['logo'] = $file['savepath'] . $file['savename'];
                    }
                }
            }
            $data = $model->add($_POST);
            if ($data > 1) {
                $this->success('新增成功', U('index'));
            } else {
                $this->error('新增失败');
            }

        } else {
            $this->assign('type', $this->type)->display();
        }
    }


    public function edit()
    {
        $id = $_GET['id'];
        $model = M('Test');
        $info = $model->find($id);
        if ($_POST) {

            if ($_FILES['logo']['error'] == 0) {

                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = 3145728;// 设置附件上传大小
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath = './Uploads/'; // 设置附件上传根目录
                $upload->savePath = ''; // 设置附件上传（子）目录
                // 上传文件
                $info = $upload->upload();
                if (!$info) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {// 上传成功 获取上传文件信息
                    foreach ($info as $file) {
                        $_POST['logo'] = $file['savepath'] . $file['savename'];
                    }
                }
            }
            $data = $model->save($_POST);
            if ($data !== false) {
                $this->success('更新成功', U('index'));
            } else {
                $this->error('更新失败');
            }
        } else {
            $this->assign('type', $this->type)
                ->assign('info', $info)->display();
        }

    }

    public function del()
    {
        $id = $_GET['id'];
        if (empty($id)) {
            $this->redirect('index');
        }
        $id = M('Test')->where(['id' => $id])->delete();
        if ($id > 0) {
            $this->success('删除成功', U('index'));
        } else {
            $this->error('删除失败');
        }
    }

    public function welcome()
    {
        $this->display();
    }
}