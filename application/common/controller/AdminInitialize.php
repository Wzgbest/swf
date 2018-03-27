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
use app\admin\model\User as UserModel;
use think\Request;
use think\View;

class AdminInitialize extends Controller
{
    protected $uid;

    public function _initialize()
    {
        $account = getUserByCooki("swf");
//        var_exp($account,'$account',1);
        if (!$account) {
            $this->_redirectToLogin();
        }
        $userM = new UserModel();
        $userInfo = $userM->getUserByName($account);
        $this->uid = $userInfo['id'];
    }
    private function _redirectToLogin(){
//        $module = $this->request->module();
        $this->redirect('admin/login/index');
    }
}