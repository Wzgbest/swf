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

class Member extends AdminBase
{
    public function __construct(){
        $this->table=config('database.prefix').'users';
        parent::__construct();
    }
    //获取列表
    public function getUsers(){
        return $this->model->table($this->table)->select();
    }
    //添加一条记录
    public function insertUser($data){
        return $this->model->table($this->table)->insertGetId($data);
    }
    //根据id获取
    public function getUserById($id){
        return $this->model->table($this->table)->where(['id'=>$id])->find();
    }
    //更新信息
    public function updateUserById($id,$data){
        return $this->model->table($this->table)->where(['id'=>$id])->update($data);
    }
    //删除
    public function deleteUserById($id){
        return $this->model->table($this->table)->where(['id'=>$id])->delete();
    }

    /**
     * 查找用户 通过手机号
     */
    public function getUserByPhone($map)
    {
        return $this->model->table($this->table)->where($map)->find();
    }
}