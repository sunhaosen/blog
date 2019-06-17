<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admins;
use think\facade\Session;
use think\facade\Request;
use think\Db;
class Login extends Controller
{
	public function login()
	{
	    Session::delete('admin_id');
		return $this->fetch('login/login');
	}
	public function logindo()
	{
        $data = $_POST;
        $data['password'] = md5($data['password']);
        $res = Admins::where('name',$data['name'])->where('password',$data['password'])->find();
        if ($res)
        {
            $admin_id = $res['id'];
            $data=Db::table('admins')
                ->alias('a')
                ->join('role_user r_u','a.id=r_u.user_id')
                ->join('roles r','r_u.role_id=r.id')
                ->join('permission_role p_r','r.id=p_r.role_id')
                ->join('permissions p','p_r.permission_id=p.id')
                ->where('a.id',$admin_id)
                ->column('p.name');
            Session::set('gather',$data);
            Session::set('admin_id',$res['id']);
            return $this->success('登录成功','index/index');
        }
        else
        {
            return $this->error('用户名或密码错误');
        }


	}
}