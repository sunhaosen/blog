<?php

namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\model\Articles;
use think\facade\Cache;
use app\api\controller\Response;
use app\api\model\Members;
use app\api\model\Comments;
use think\Db;

class Index extends Controller
{
    protected $beforeActionList = [
        'token_time' => ['only'=>'create,member_info,create_blog,create_comment,member_info,member_article,member_like,member_collect,member_attention,member_fans'],
    ];
    /*
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function index()
    {
        //
        $data = Articles::all();
        if ($data)
        {
            return Response::json('200','成功',$data);
        }
        else
        {
            return Response::json('500','出了点小问题');
        }
    }
    /*
     * 用户信息
     * */
    public function member_info()
    {
        $token = $_GET['token'];
        $member = Members::where('token',$token)->find();
        if ($member)
        {
            return Response::json('201','返回用户信息成功',$member);
        }
        else
        {
            return Response::json('500','出了点小错');
        }
    }
    /*
     * 用户发过的文章
     * */
    public function member_article()
    {
        $token = $_GET['token'];
        $member = Members::where('token',$token)->find();
        $data = Articles::where('user_id',$member['id'])->all();
        return Response::json('201','返回用户发过的文章成功',$data);
    }
    /*
     * 用户点赞的文章
     * */
    public function member_like()
    {
        $token = $_GET['token'];
        $member = Members::where('token',$token)->find();
        $data = Db::table('like')->where('user_id',$member['id'])->all();
        return Response::json('201','返回用户点赞过的文章成功',$data);
    }
    /*
     * 用户收藏的文章
     * */
    public function member_collect()
    {
        $token = $_GET['token'];
        $member = Members::where('token',$token)->find();
        $data = Db::table('collect')->where('user_id',$member['id'])->all();
        return Response::json('201','返回用户收藏的文章成功',$data);
    }
    /*
     * 用户的关注
     * */
    public function member_attention()
    {
        $token = $_GET['token'];
        $member = Members::where('token',$token)->find();
        $data = Db::table('fans')->where('fans_id',$member['id'])->column('user_id');
        return Response::json('201','返回用户关注的用户id',$data);
    }
    /*
     * 用户的粉丝
     * */
    public function member_fans()
    {
        $token = $_GET['token'];
        $member = Members::where('token',$token)->find();
        $user_id = Db::table('fans')->where('user_id',$member['id'])->all();
        return Response::json('201','返回用户的粉丝id',$data);
    }
    /*
     * 用户写过的评论
     * */
    public function member_comment()
    {
        $token = $_GET['token'];
        $member = Members::where('token',$token)->find();
        $data = Comments::where('user_id',$member['id'])->all();
        return Response::json('201','返回用户写过的评论成功',$data);
    }
    /*
     * 发博文
     * */
    public function create_blog()
    {
        $token = $_GET['token'];
        $title = $_POST['tile'];
        $type = $_POST['type'];
        $contents = $_POST['contents'];
        $user_id = Members::where('token',$token)->column('id');
        $create_at = date("Y-m-d H:i:s",time());
        $data = ['title'=>$title,'contents'=>$contents,'type'=>$type,'user_id'=>$user_id,'create_at'=>$create_at];
        if (Db::name('articles')->data($data)->insert())
        {
            return Response::json('201','博文发表成功,等待管理员审核');
        }
        else
        {
            return Response::json('401','出了点小问题');
        }
    }
    /*
     * 文章的评论
     * */
    public function comment_list()
    {
        $article_id = $_POST['article_id'];
        if (empty($article_id))
        {
            return Response::json('401','没传文章id');
        }
        else
        {
            $comments = Comments::where('article_id',$article_id)->all();
            return Response::json('201','本文章的所有评论',$comments);
        }
    }
    /*
     * 发评论
     * */
    public function create_comment()
    {
        $token = $_GET['token'];
        $user_id = Members::where('token',$token)->column('id');
        $article_id = $_POST['article_id'];
        $comment = $_POST['comment'];
        $create_at = date("Y-m-d H:i:s",time());
        $data = ['user_id'=>$user_id,'article'=>$article_id,'comment'=>$comment,'create_at'=>$create_at];
        if (Db::name('comments')->data($data)->insert())
        {
            return Response::json('201','评论成功');
        }
        else
        {
            return Response::json('401','出了点小问题');
        }
    }
    /*
     * 点赞
     * */
    public function like()
    {
        $token = $_GET['token'];
        $article_id = $_POST['article_id'];
        $member = Members::where('token',$token)->find();
        $like = Db::table('like')->where('user_id',$member['id'])->find();
        if ($like['title_id'] == $article_id)
        {
//            Db::table('like')->where('');
//            return Response::json();
        }
    }
    /*
     * 收藏
     * */
    public function collect()
    {

    }
    /*
     * 关注
     * */
    public function attention()
    {
        $token = $_GET['token'];
        $member = Members::where('token',$token)->find();

    }
    /*
     * 显示创建资源表单页.
     *
     * @return \think\Response
     */
    public function create()
    {
        //

    }

    /*
     * 保存新建的资源
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        //
    }

    /*
     * 显示指定的资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function read($id)
    {
        //
    }

    /*
     * 显示编辑资源表单页.
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function edit($id)
    {
        //
    }

    /*
     * 保存更新的资源
     *
     * @param  \think\Request  $request
     * @param  int  $id
     * @return \think\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /*
     * 删除指定资源
     *
     * @param  int  $id
     * @return \think\Response
     */
    public function delete($id)
    {
        //
    }
    /*
     * 验证token过期时间
     * $member 单条用户数据
     */
    public function token_time()
    {
//        $token = $_GET['token'];
        if (empty($_GET['token']))
        {
            //这里没接到token
            return Response::json('401','没接到token');
        }
        else
        {
            $token = $_GET['token'];
            $member = Members::where('token',$token)->find();
            if ($member)
            {
                if ($member['update_time']+60*60*2 > time())
                {
                    //这里执行后边的方法
                }
                else
                {
                    return Response::json('401','token已过期,请重新登录');
                }
            }
            else
            {
                return Response::json('401','token错误');
            }
        }
    }
}
