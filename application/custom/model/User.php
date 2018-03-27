<?php
// +----------------------------------------------------------------------
// | 全影集团 [ 纯粹、极致到零 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.7192.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wuzhenguo <wuzhenguook@gmail.com> <The Best Word!!!>
// +----------------------------------------------------------------------

namespace app\custom\model;

use app\common\model\CustomBase;
use think\Db;

class User extends CustomBase{
    public function __construct(){
        $this->table=config('database.prefix').'users';
        parent::__construct();
    }

    //根据名字获取信息
    public function getUserByName($account){
        return $this->model->table($this->table)->where(['name'=>$account])->find();
    }
    //跟新用户信息
    public function updateUserInfo($uid,$data){
        return $this->model->table($this->table)->where(['id'=>$uid])->update($data);
    }
}