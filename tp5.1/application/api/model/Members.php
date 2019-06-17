<?php
namespace app\api\model;

use think\Model;
use think\Db;
use think\facade\Session;
class Members extends Model
{
    public function login($post)
    {

        $member = Db::name('members')->where('email','=',$post['email'])->find();
        if ($member['status'] == 0)
        {
            if ($member)
            {
                if ($member['password'] == md5($post['password']))
                {
                    Session::set('id',$member['id']);
                    return 2;
                }
                else
                {
                    return 3;
                }
            }
            else
            {
                return 1;
            }
        }
        else if($member['status'] == 2)
        {
            return 4;
        }
    }

}