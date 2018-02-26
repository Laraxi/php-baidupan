<?php

namespace Home\Controller;

use Think\Controller;
use Think\Model;


class IndexController extends Controller
{
    public function index()
    {
        $ua = strtolower($_SERVER['HTTP_USER_AGENT']);
        $uachar = "/(nokia|sony|ericsson|mot|samsung|sgh|lg|philips|panasonic|alcatel|lenovo|cldc|midp|mobile)/i";
        $model = M('ShareList as sl');
        $filed = "sl.id as sl_id,sl.face,sl.face,sl.name,sl.number,sl.create_time,sl.link,u.*";
        $data['data'] = $model->field($filed)->join('left join bdp_user as u on u.id=sl.user_id')->select();
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