<?php
// +----------------------------------------------------------------------
// | 全影集团 [ 纯粹、极致到零 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.7192.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wuzhenguo <wuzhenguook@gmail.com> <The Best Word!!!>
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\common\model\AdminBase;
use think\Db;

class User extends AdminBase{
    public function __construct(){
        $this->table=config('database.prefix').'admin';
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