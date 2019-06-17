<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Members;
use think\facade\Session;
class Login extends Controller
{
    public function index()
    {
        Session::delete('id');
        return $this->fetch('login');
    }
    public function login_check()
    {
        $post = input('post.');
        unset($post['/index/login/login_check_html']);
//        var_dump($post);exit;
        $obj = new Members();
        $res = $obj->login($post);
        if ($res == 1)
        {
            echo json_encode(array("status" => 1, "msg" =>'用户名错误'));
        }
        else if ($res == 2)
        {
            echo json_encode(array("status" => 2, "msg" =>'验证成功'));
        }
        else if ($res == 3)
        {
            echo json_encode(array("status" => 3, "msg" =>'密码错误'));
        }
        else if ($res == 4)
        {
            echo json_encode(array("status" => 4, "msg" =>'用户未激活'));
        }
    }
}