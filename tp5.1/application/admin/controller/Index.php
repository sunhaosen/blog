<?php
namespace app\admin\controller;
use think\Controller;
use app\admin\model\Admins;
use app\admin\model\Roles;
use think\facade\Session;
use app\admin\model\Permissions;
use app\admin\model\User;
use app\admin\model\Articles;
use app\admin\model\Comments;
use think\Db;
class Index extends Base
{
    //首页展示方法
    public function index()
	{
	    $id = Session::get('admin_id');
	    $data = Admins::where('id',$id)->find();
        $role = Db::table('admins')
            ->alias('a')
            ->join('role_user r_u','a.id=r_u.user_id')
            ->join('roles r','r_u.role_id=r.id')
            ->where('a.id',$id)
            ->column('description');
		return $this->fetch('index',['name'=>$data['name'],'role'=>$role]);
	}
	public function main()
    {
        return $this->fetch('main');
    }
	//我的桌面
	public function welcome()
	{
		return $this->fetch();		
	}
	//文章列表
	public function article_list()
	{
		return $this->fetch('article-list');
	}
	//跳转到登录页面
	public function login()
    {
        return redirect('/admin/login/login');
    }
    //角色添加页面
    public function admin_role_add()
    {
        return $this->fetch('admin-role-add');
    }

    public function member_show()
    {
        $name = $_POST;
        print_r($name);
        exit;
    }
    //用户添加页面
    public function member_add()
    {
        return $this->fetch('member-add');
    }
    public function comment_list()
    {
        $data = Comments::all();
        return $this->fetch('comment-list',['data'=>$data]);
    }
    public function system_shielding()
    {
        return $this->fetch('system-shielding');
    }

}