<?php
// +----------------------------------------------------------------------
// | 全影集团 [ 纯粹、极致到零 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.7192.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wuzhenguo <wuzhenguook@gmail.com> <The Best Word!!!>
// +----------------------------------------------------------------------
namespace app\common\controller;

use think\Controller;
use think\Request;
use think\View;

class CustomInitialize extends Controller
{
    protected $c_uid;

    public function _initialize()
    {
        $account = getUserByCooki("custom");
//        var_exp($account,'$account',1);
        if (!$account) {
            $this->_redirectToLogin();
        }
        $info = explode("_",$account);
        $this->c_uid = $info[0];
    }
    private function _redirectToLogin(){
//        $module = $this->request->module();
        $this->redirect('custom/login/index');
    }
}