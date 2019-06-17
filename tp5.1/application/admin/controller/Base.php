<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/14
 * Time: 10:31
 */
namespace app\admin\controller;
use think\Controller;
use think\facade\Session;
use think\facade\Request;
use app\admin\model\Admins;
class Base extends Controller
{
    protected $request;
    public function __construct( $request = null)
    {

        parent::__construct($request);
        //直接实例化request类方便后期调用
        $this->request = $request;
        if(!Session::get("admin_id")){
            $this->success('请登录','login/login');
        }
        else
        {
            $id = Session::get('admin_id');
            $action=strtolower(Request::controller().'/'.Request::action());
            $gather = Session::get('gather');
            if (!in_array($action,$gather))
            {
                echo $action;
                exit('没权限');
            }
        }
    }
}