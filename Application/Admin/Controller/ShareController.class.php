<?php

namespace Admin\Controller;


class ShareController extends CommonController
{


    public function link()
    {
        $model = M('ShareList');
        $data = $model->select();
        $this->assign(array(
            'data' => $data
        ))->display();
    }

    public function del()
    {
        $id = $_GET['id'];
        if (empty($id)) $this->redirect('link');
        if (M('ShareList')->delete($id)) {
            $this->success('删除成功', U('link'));
        } else {
            $this->error('删除失败');
        }
    }


}