<?php

namespace App\Http\Controllers\Api\users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;

class registerController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'password' => 'required|min:6|confirmed',
            'code'=>'required',
        ], [
            'name.required' => '用户名不能为空',
            'name.max' => '用户名最大长度不能超过50',
            'password.required' => '密码不能为空',
            'password.min' => '密码不能少于6个字节',
            'password.confirmed' => '两次输入的密码不一致',
            'code.required'=>'验证码不能为空',
        ]);
        if ($validator->fails()) {
            $valimsg = $validator->messages();
            if ($valimsg->has('name')) {
                $code = 1001;
                $info = $valimsg->first('name');
            } else if ($valimsg->has('password')) {
                $code = 1002;
                $info = $valimsg->first('password');
            } else {
                $code = 1003;
                $info = '未知错误';
            }
        } else {
            $name = $request->input('name');
            $password = $request->input('password');
            $userObj = user::where(['name' => $name])->first();
            if (!$userObj->is_null()) {
                $code = 1004;
                $info = '该用户已经存在';
            } else {
                $theObj = User::create([
                    'name' => $name,
                    'password' => $password,
                ]);
                if ($theObj) {
                    $code = 200;
                    $info = "注册成功";
                } else {
                    $code = 1005;
                    $info = "注册失败";
                }
            }
        }

        return response()->json(compact('code','info'));
    }

    public function login(Request $request){

    }
}
