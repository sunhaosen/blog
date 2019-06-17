<?php
namespace app\api\controller;

use think\Controller;
use app\api\model\Members;
use app\api\controller\Response;

class Member extends Controller
{
    public function index()
    {
        $token = $_GET['token'];
        if (empty($token))
        {
            return Response::json('401','');
        }
    }
}