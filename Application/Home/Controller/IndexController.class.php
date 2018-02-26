<?php

namespace Home\Controller;

use Think\Controller;
use Think\Model;


class IndexController extends Controller
{

    public function index()
    {

        echo 111;exit;

        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        $uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";
        $model = M('ShareList as sl');
        $data['data'] = $model->field('sl.*,u.*')->join('left join bdp_user as u on u.id=sl.user_id')->select();
        $data['count'] = $model->join('left join bdp_user as u on u.id=sl.user_id')->count();
        $data['info'] = $model->find();
        foreach ($data['data'] as $key => $value) {
            $data['data'][$key]['face'] = explode(',', $value['face']);
        }
        if ($ua == '' || preg_match($uachar, $ua)) {
            $this->assign(array(
                'data' => $data['data'],
                'count' => $data['count'],
                'info' => $data['info']
            ))->display('m_index');
        } else {
            $this->assign(array(
                'data' => $data['data'],
                'count' => $data['count'],
                'info' => $data['info']
            ))->display();

        }
    }

}