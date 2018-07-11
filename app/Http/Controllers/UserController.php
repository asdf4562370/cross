<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Users;
class UserController extends Controller
{
    public function model(){
        /*$info = Users::find(2);
       echo $info['username'];
       $info->username='xiaohong';
       echo $info['username'];
       $info->save();*/         //更新，参数填主键id

        /*$deUser=new users;
       $deUser->destroy(2);*/   //删除，参数填主键id

        /*$deleterow=new users;
        $deleterow->where('id','1')->delete();*/ //通过查询条件删除模型

        /*$info=users::find(['1','2']);
        echo $info;*/              //打印主键id为1和2的模型

        /*$max=users;;where(uid,1)->max('price');*/   //
        /*$user=new users;
        $user->name=$request->name;
        $user->save();*/        //请求验证



    }
}
