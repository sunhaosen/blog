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
use app\admin\model\Members;
use app\admin\controller\Base;
use app\admin\model\Ads;
class Ad extends Base
{
    public function index()
    {
        $ads = Ads::all();
        return $this->fetch('ad-list',['ads'=>$ads]);
    }
}