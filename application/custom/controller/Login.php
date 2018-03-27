<?php
// +----------------------------------------------------------------------
// | 全影集团 [ 纯粹、极致到零 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.7192.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wuzhenguo <wuzhenguook@gmail.com> <The Best Word!!!>
// +----------------------------------------------------------------------
namespace app\custom\controller;

use think\Db;
use think\Controller;
use app\custom\model\User as UserModel;

class Login extends Controller
{
    public function index()
    {
        return view();
    }

    /**
     * 登录验证
     * @return mixed
     * created by messhair
     */
    public function verifyLogin(){
        $req_reg= ["status"=>0,"message"=>"登录失败"];

        $input = input('param.');
        $account = trim($input['account']);
        $psw = trim($input['psw']);
        $code = trim($input['code']);
        $ip = $this->request->ip();
        $time = time();
        $result = $this->_checkPasswordAndCode($account,$psw,$code);
        if(!$result["status"]){
            $req_reg["message"] = $result["message"];
            return json($req_reg);
        }
        $userM = new UserModel();
        $data['logintime'] = $time;
        $data['loginip'] = $ip;
        $flg = $userM->updateUserInfo($result['data']['id'],$data);
        if (!$flg){
            $req_reg["message"] = "保存登录信息失败";
            return json($req_reg);
        }
        setCooki("custom",$result['data']['id']."_".$result['data']['name']);
//        $this->redirect('admin/index/index');
        $req_reg['status'] = 1;
        $req_reg['message'] = "登陆成功";
        return json($req_reg);

    }

    //退出登录
    public function logout(){
        setCooki("custom",null);
        $this->redirect('custom/login/index');
    }

    //验证账号密码
    private function _checkPasswordAndCode($account,$password,$code){
        $info = ['status'=>0,'message'=>"验证失败"];
        if (!$account || !$password || !$code){
            $info['message'] = "信息不能为空";
            return $info;
        }
        $userM = new UserModel();
        $userInfo = $userM->getUserByName($account);
        if (empty($userInfo)){
            $info['message'] = "没有该用户";
            return $info;
        }
        if (md5($password) != $userInfo['password']){
            $info['message'] = "密码不正确";
            return $info;
        }
        if(!captcha_check($code)){
            $info['message'] = "验证码错误";
            return $info;
        }
        if (!$userInfo['status']){
            $info['message'] = "您的账号无效，请联系管理员";
            return $info;
        }
        $info['status'] = 1;
        $info['message'] = "验证成功";
        $info['data'] = $userInfo;
        return $info;
    }

}