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
 * Date: 2018/3/20
 * Time: 10:01
 */

namespace app\admin\controller;


use app\admin\model\CodeModel;
use app\common\controller\AdminInitialize;

class Code extends AdminInitialize
{
    /**
     * 列表页
     */
    public function index()
    {
        $code = new CodeModel();
        $list = $code->getAllCode();
        $this->assign('code',$list);
        $this->assign('count',count($list));
        return view();
    }

    /**
     * 生成激活码
     */
    public function addCode()
    {
        $result = ['status'=>0,'message'=>"失败"];
        $code_arr = [];
        for ($i = 0; $i < 100; $i++){
            $time = time();
            $rand = rand(100000,999999);
            $data['code'] = $rand.substr($time,6,3);
            $data['create_time'] = $time;
            array_push($code_arr,$data);
        }
        $code = new CodeModel();
        $res = $code->insertCode($code_arr);
        if ($res) {
            $result['status'] = 1;
            $result['message'] = "成功";
        }

        return json($result);
    }
}