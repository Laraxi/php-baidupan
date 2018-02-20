<?php

namespace Home\Controller;


class ShareController extends CommonController
{

    public function add()
    {
        // 1 检查是否有没有登录
        if (!session('home_login_id')) {
            $this->ajaxReturn(array(
                'status' => 202,
                'msg' => '你未登录，请先登录哦!'
            ));
        }
        //接收用户传递来的数据进行合法校验
        print_r($_POST);
    }

    public function test()
    {
//        $this->ajaxReturn(array(
//            'status' => '1',
//            'message' => '测试'
//        ));
    }


}