<?php
/**
 * // +----------------------------------------------------------------------
 * // | 全心服务 影响未来
 * // +----------------------------------------------------------------------
 * // | Copyright (c) 2018 www.7192.com All rights reserved.
 * // +----------------------------------------------------------------------
 * // | Author: wuzhenguo <wuzhenguook@gmail.com> <The Best Word!!!>
 * // +----------------------------------------------------------------------
 */

/**
 * Created by PhpStorm.
 * User: QYIT
 * Date: 2018/3/6
 * Time: 10:02
 */

namespace app\index\model;


use app\common\model\CustomBase;

class Member extends CustomBase
{
    /**
     * Templet constructor.
     */
    public function __construct()
    {
        $this->table=config('database.prefix').'users';
        parent::__construct();
    }
    /**
     * @param //根据名字获取信息
     */
    public function getUserByName($account){
        return $this->model->table($this->table)->where(['name'=>$account])->find();
    }

    /**
     * @param //跟新用户信息
     * */
    public function updateUserInfo($uid,$data){
        return $this->model->table($this->table)->where(['id'=>$uid])->update($data);
    }
}