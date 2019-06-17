<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use app\index\model\Mail;
class Register extends Controller
{
    public function index()
    {
        return $this->fetch('register');
    }
    public function register_check(){
        $data=$_POST;
        $res=Db::name('members')->where($data)->find();
        if($res){
            echo json_encode(['status'=>1,'msg'=>'已经存在']);
        }else{
            echo json_encode(['status'=>2,'msg'=>'OK']);
        }
    }
    public function register_add()
    {
        $data=input('post.');
        $data['register_time']=date('Y-m-d H:i:s',time());
        $data['password']=md5($data['password']);
        $data['email'] = trim($data['email']); //邮箱
        $regtime = time();
        $data['token'] = md5($regtime.$data['email']); //创建用于激活识别码
        $res=Db::name('members')->insert($data);
        Mail::send_email('账号激活',"请通过下面的地址激活账号:<a href='http://www.xunhaoxun.com/index/register/activation?id=$data[j_token]'>http://www.xunhaoxun.com/index/register/activation?id=$data[j_token]</a>",$data['email']);
        if($res){
            $this->success('注册成功请前往邮箱激活','index');
        }
    }
    public function activation()
    {
        $data=input('get.');
        if(!empty($data)){
            $sql=Db::name('members')->where('token',$data['id'])->find();
            if($data['id']==$sql['token']){
                Db::name('members')->where('id',$sql['id'])->update(['status'=>0]);
                Db::name('activation')->insert(['user_id'=>$sql['id'],'message'=>'激活成功']);
                $this->success('激活成功');
            }else{
                Db::name('activation')->insert(['user_id'=>$sql['id'],'message'=>'激活失败']);
            }
        }else{
            return view('index/error');
        }

    }
}