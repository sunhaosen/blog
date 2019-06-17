<?php
namespace app\index\controller;
use think\Controller;
use app\index\model\Members;
use app\index\model\Articles;
use app\index\model\Comments;
use think\facade\Session;
use think\Db;

class Member extends Controller
{
    public function index()
    {
        $id = $_GET['id'];
        $data = Members::where('id',$id)->find();
        $num = Articles::where('user_id',$id)->count();
        $num2 = Comments::where('user_id',$id)->count();
        return $this->fetch('member',['data'=>$data,'num'=>$num,'num2'=>$num2]);
    }
    public function blog_list()
    {
        $user_id = Session::get('id');
        $data = Articles::where('user_id',$user_id)->paginate(2);
        return $this->fetch('blog_list',['data'=>$data]);
    }
    public function comment_list()
    {
        $user_id = Session::get('id');
        $data = Comments::where('user_id',$user_id)->paginate(2);

        return $this->fetch('comment_list',['data'=>$data]);
    }


}