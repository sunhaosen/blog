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
class Role extends Base
{
    public function index()
    {
        $data = Roles::all();
        return $this->fetch('admin-role',['data'=>$data]);
    }
    public function permission_add()
    {
        $id = $_GET['id'];
        $data = Permissions::all();
//        var_dump($data);exit()
        return $this->fetch('permission-add',['data'=>$data,'id'=>$id]);
    }
    public function permission_add_do()
    {
//        $data = $_POST;
        $r_id = $_POST['id'];
        $per_id = $_POST['data'];
        foreach ($per_id as $key=>$value)
        {
            $arr[$key]['permission_id'] = $value;
            $arr[$key]['role_id'] = $r_id;
        }
        Db::name('permission_role')->insertAll($arr, true);
        return $this->index();
    }
    public function admin_role_add()
    {
        return $this->fetch('admin-role-add');
    }
}