<?php

namespace Home\Controller;


use Think\Controller;
use Think\Model;

class ShareController extends Controller
{
    public function add()
    {
        if (!$data = S('share_add')) {
            ini_set('user_agent', 'Mozilla/5.0 (Linux; Android 4.2.1; en-us; Nexus 4 Build/JOP40D) AppleWebKit/535.19 (KHTML, like Gecko) Chrome/18.0.1025.166 Mobile Safari/535.19');
            if (!session('home_login_id')) $this->ajaxReturn(array('status' => 0, 'msg' => '请登录后再分享!'));
            $links = isset($_POST['short']) && $_POST['short'] != '' ? explode(",", trim($_POST['short'])) : "";
            foreach ($links as $value) {
                if (strpos($value, 'http') > 0) {
                    $value = explode('http', $value);
                    if ($value[1]) {
                        $value = 'http' . $value[1];
                    }
                }
            }
            $model = M('ShareList');
            $data['count_link'] = $model->where(array('link' => $value))->find();
            if ($data['count_link'] > 0) $this->ajaxReturn(array('status' => 0, 'msg' => '该链接已经存在!'));
            $data['content'] = file_get_contents($value);
            if ($data['content']) {
                $data['content'] = str_replace("'", "", $this->autoiconv($data['content']));
                $rule_group_member = 'FileUtils.g_name="@@@";FileUtils.u_avator_list';
                $rule_group_member_number = '<span id="group-user-num">@@@</span>';
                $rule_group_member_avatar = 'FileUtils.u_avator_list=JSON.parse(@@@);FileUtils.mobileModel="Android";';
                preg_match("/" . $this->restr($rule_group_member) . "/is", $data['content'], $regm);
                $group_member = $this->fstr(strip_tags($regm[1]), $this->restr($rule_group_member, 'f'));
                if (strpos($group_member, '*')) {
                    $group_member = str_replace("*", "-", $group_member);
                } else {
                    $len = strlen($group_member);
                    $group_member = substr($group_member, 0, ($len > 15 ? 6 : 3)) . "----" . substr($group_member, $len - ($len > 15 ? 6 : 3), $len);
                }
                preg_match("/" . $this->restr($rule_group_member_number) . "/is", $data['content'], $regm);
                $group_number = $this->fstr(strip_tags($regm[1]), $this->restr($rule_group_member_number, 'f'));
                preg_match("/" . $this->restr($rule_group_member_avatar) . "/is", $data['content'], $regm);
                $group_avatar = $this->fstr(strip_tags($regm[1]), $this->restr($rule_group_member_avatar, 'f'));
                $group_avatar = str_replace(array("\\", '("', '")'), array("", "", ""), $group_avatar);
                $rowjson = json_decode($group_avatar);
                $group_avatars = array();
                foreach ($rowjson as $value1) {
                    $group_avatars[] = $value1->photo;
                }
                $group_avatar_str = implode(",", $group_avatars);
                if ($group_member && $group_number > 0) {
                    $insert_arr = array(
                        'face' => $group_avatar_str,
                        'name' => $group_member,
                        'number' => $group_number,
                        'link' => $value,
                        'create_time' => time(),
                        'user_id' => session('home_login_id')
                    );
                    $data = $model->add($insert_arr);
                    if ($data) {
                        $this->ajaxReturn(array('status' => 200, 'msg' => '提交成功'));
                    }
                } else {
                    $this->ajaxReturn(array('status' => 0, 'msg' => '分享失败！请检查链接是否正确或重复'));
                }
            } else {
                $this->ajaxReturn(array('status' => 0, 'msg' => '分享失败！请检查链接是否正确或重复'));
            }

            S('share_add', $data, array('type' => 'file', 'expire' => 3600));

        }
    }

    public function jump()
    {
        if (!session('home_login_id'))
            $this->redirect('user/login');
        $id = intval($_GET['id']);
        $sql = "select sl.*,u.* from  bdp_share_list as sl left join bdp_user as u on sl.user_id= u.id where sl.id={$id} limit 1";
        $model = new Model();
        $info = $model->query($sql)[0];
        $user_id = session('home_login_id');
        $sql = "SELECT jump_count FROM bdp_user WHERE id = {$user_id} LIMIT 1";
        $jump_count = $model->query($sql)[0];
        $today = date("Ymd", time());
        if ($jump_count && $jump_count['jump_count'] != '') {
            $jump_count = explode(":", $jump_count['jump_count']);
            $jump_count = explode(":", $jump_count['jump_count']);
            $count = $jump_count[1] && $jump_count[0] == $today ? $jump_count[1] : 0;
            if ($count) {
                $sql = "UPDATE bdp_user SET jump_count='" . $today . ":" . ($count + 1) . "' WHERE id=" . $user_id;
                $model->execute($sql);
            }
        } else {
            $sql = "update bdp_user set jump_count = '" . $today . ":1' where id =" . $user_id;
            $model->execute($sql);
        }
        $this->assign('url', $info['link']);
        $this->display('index/walt');
    }

    public function autoiconv($str, $type = "gb2312//IGNORE")
    {
        if (preg_match("/^([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){1}/", $str) == true || preg_match("/([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){1}$/", $str) == true || preg_match("/([" . chr(228) . "-" . chr(233) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}[" . chr(128) . "-" . chr(191) . "]{1}){2,}/", $str) == true) {
            return $str;
        } else {
            return iconv($type, "utf-8", $str);
        }
    }

    public function restr($str, $filter = '')
    {
        if ($str != "" && $str != null) {
            if (strpos($str, '|||') > -1) {
                $stra = explode("|||", $str);
                $str = str_replace("@@@", "(.*?)", $stra[0]);
                $strf = $stra[1];
            } else {
                $str = str_replace("@@@", "(.*?)", $str);
            }
            $str = str_replace(array("/", "'", "&#39;"), array("\/", "", ""), $str);
        }
        return !$filter == 'f' ? $str : $strf;
    }

    public function fstr($str, $strf = '')
    {
        if ($str != "" && $str != null && $strf != "" && $strf != null) {
            if (strpos($strf, '$$$') > -1) {
                $strfa = explode("$$$", $strf);
                $strf1 = explode(",", $strfa[0]);
                $strf2 = explode(",", $strfa[1]);
                $str = str_replace($strf1, $strf2, $str);
            } else {
                $strf = explode(",", $strf);
                $str = str_replace($strf, array(), $str);
            }
        }
        $str = trim(str_replace(array("\n", "\r"), array("", ""), $str));
        return $str;
    }

    public function fchs($str, $strr = '')
    {
        $str = $strr ? rtrim($str, $strr) : $str;
        $str = trim(str_replace(array("&lt;", "&gt;", "&quot;", "&amp;", "&nbsp;", " ", "/"), array("", "", "", "", "", "", ""), $str));
        return preg_replace("/[\x80-\xff]/", "", $str);
    }

}