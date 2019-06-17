<?php
namespace app\index\controller;

use think\Db;
use think\Controller;
use think\facade\Session;
use app\index\model\Members;
use app\index\model\Articles;
use app\index\model\Comments;
class Index extends Controller
{
    //首页
    public function index()
    {
        $id = Session::get('id');
        $name = Members::where('id',$id)->find();
        $data = Articles::all();
        return $this->fetch('index',['name'=>$name,'data'=>$data]);
    }
    //列表页
    public function list()
    {
        $id = Session::get('id');
        $name = Members::where('id',$id)->find();
        $data = Articles::all();
        return $this->fetch('list',['data'=>$data,'name'=>$name]);
    }
    //博文详情页
    public function show()
    {
        $id = Session::get('id');
        //name是前台展示的登录的用户名
        $name = Members::where('id',$id)->find();
        $id = $_GET['id'];
        $data = Articles::where('id',$id)->find();
        //name2是前台展示的文章来源
        $name2 = Members::where('id',$data['user_id'])->column('name');
        $comments = Comments::where('article_id',$id)->all();
        $article = Articles::all();
        return $this->fetch('show',['name'=>$name,'data'=>$data,'comment'=>$comments,'article'=>$article,'name2'=>$name2['0']]);
    }
    public function add()
    {
        $id = Session::get('id');
        return $this->fetch('add',['id'=>$id]);
    }
    public function add_do()
    {
        $id = Session::get('id');
        $post = $_POST;
        $data = ['title'=>$post['title'],'type'=>$post['type'],'contents'=>$post['contents'],'user_id'=>$id];
        if (Db::name('articles')->data($data)->insert())
        {
            echo json_encode(array("status" => 1, "msg" =>'博文提交成功,请等待审核'));
//            return $this->add();
        }
        else
        {
            echo json_encode(array("status" => 2, "msg" =>'提交失败,请重试!'));
//            return $this->error('发表失败');
        }
    }
    public function comment_do()
    {
        if (!Session::get('id'))
        {
            echo json_encode(array("status" => 1, "msg" =>'请登录后评论'));
        }
        else
        {
            $user_id = Session::get('id');
            $post = $_POST;
            $time = date("Y-m-d H:i:s",time());
            $data = ['user_id'=>$user_id,'article_id'=>$post['article_id'],'comment'=>$post['comment'],'create_at'=>$time];
            if (Db::name('comments')->data($data)->insert())
            {
                echo json_encode(array("status" => 2, "msg" =>'评论成功'));
            }

        }
    }
}
