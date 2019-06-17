<?php
namespace app\api\controller;

use think\Controller;
use think\Request;
use app\api\model\Articles;
use app\api\model\Members;
use think\facade\Cache;
use think\facade\Session;
use app\index\model\Mail;
use think\Db;
use app\api\controller\Response;

class Login extends Controller
{
    public function index()
    {
        if (!empty($_REQUEST))
        {
            $post = $_REQUEST;

//            return $post;
            $post['password'] = md5($post['password']);
            $member = Db::table('members')->where('email',$post['email'])->find();
            if ($member['status'] == 0)
            {
                if ($member['password'] === $post['password'])
                {
                    $token = md5($post['email'].$post['password'].time());
//                    Cache::store('redis')->set('token',$token,7200);
//                    $data = Cache::store('redis')->get('token');
                    if (Db::table('members')->where('email',$post['email'])->update(['token'=>$token,'update_time'=>time()]))
                    {
                        return Response::json('201','成功',$token);
                    }
                    else
                    {
                        return Response::json('500','不知道为什么没成功');
                    }
                }
                else
                {
                    //这里是密码不正确
                    return Response::json('400','密码不正确');
                }
            }
            else
            {
                //这里是账号未激活
                return Response::json('402','您的密码未激活');
            }
        }
        else
        {
            return Response::json('401','忘记传数据了');
        }
    }
    public function register()
    {
        $data=input('post.');
        $data['register_time']=date('Y-m-d H:i:s',time());
        $data['password']=md5($data['password']);
        $data['email'] = trim($data['email']); //邮箱
        $data['sex'] = $_POST['sex'];
        $data['phone'] = $_POST['phone'];
        $data['sex'] = $_POST['sex'];
        $regtime = time();
        $data['token'] = md5($regtime.$data['email']); //创建用于激活识别码
        $res=Db::name('members')->insert($data);
        Mail::send_email('账号激活',"请通过下面的地址激活账号:<a href='http://www.xunhaoxun.com/index/register/activation?id=$data[j_token]'>http://www.xunhaoxun.com/index/register/activation?id=$data[j_token]</a>",$data['email']);
        if($res){
//            $this->success('注册成功请前往邮箱激活','index');
            return Response::json('201','注册成功,请去邮箱激活');
        }
    }
    public function register_check(){
        $data=$_POST;
        $res=Db::name('members')->where($data)->find();
        if($res)
        {
            return Response::json('201','已存在');
        }
        else
        {
//            echo json_encode(['status'=>2,'msg'=>'OK']);
            return Response::json('201','不存在,可以使用');
        }
    }
}