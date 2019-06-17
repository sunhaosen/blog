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
use app\admin\controller\Base;
use think\Db;
class Admin extends Base
{
    public function index()
    {
        $data = Admins::all();
        return $this->fetch('admin-list',['data'=>$data]);
    }
    public function add()
    {
        $role = Roles::all();
        return $this->fetch('admin-add',['role'=>$role]);
    }
    public function add_do()
    {
        $name = $_POST['name'];
        $password = md5($_POST['password']);
        $adminRole = $_POST['adminRole'];
        $data = ['name'=>$name,'password'=>$password];
        $res = Db::table('admins')->insert($data);
        if ($res)
        {
            $user_id = Admins::where('name',$name)->value('id');
            $role_id = Roles::where('description',$adminRole)->value('id');
            $data2 = ['user_id'=>$user_id,'role_id'=>$role_id];
            $res2 = Db::table('role_user')->insert($data2);
            if ($res2)
            {
                return $this->success('添加成功','admin/index');
            }
            else
            {
                return $this->error('管理员添加成功,但角色分配失败','admin/index');
            }
        }
        else
        {
            return $this->error('添加失败','admin/index');
        }


    }
    public function role_add()
    {
        $id = $_GET['id'];
        $data = Roles::all();
        return $this->fetch('role-add',['data'=>$data,'id'=>$id]);
    }
    public function role_add_do()
    {
        $r_id = $_POST['id'];
        $role_id = $_POST['data'];
        foreach ($role_id as $key=>$value)
        {
            $arr[$key]['role_id'] = $value;
            $arr[$key]['user_id'] = $r_id;
        }
        Db::name('role_user')->insertAll($arr, true);
        return $this->index();
    }
}