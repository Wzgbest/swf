<?php
/**
 * Created by PhpStorm.
 * User: QYIT
 * Date: 2018/3/20
 * Time: 10:06
 */

namespace app\admin\model;


use app\common\model\AdminBase;

class CodeModel extends AdminBase
{
    public function __construct(){
        $this->table=config('database.prefix').'code';
        parent::__construct();
    }

    /**
     * 获取所有的激活码
     */
    public function getAllCode()
    {
        return $this->model->table($this->table)->select();
    }

    /**
     * 插入激活码
     */
    public function insertCode($data)
    {
        return $this->model->table($this->table)->insertAll($data);
    }

    /**
     * 查看code是否适用
     */
    public function getCodeInfoByCode($code)
    {
        $info = $this->model->table($this->table)->where(['code'=>$code,'status'=>0])->find();
        return $info;
    }

    /**
     * 跟新数据
     */
    public function updateCodeInfo($code,$data)
    {
        return $this->model->table($this->table)->where(['code'=>$code])->update($data);
    }
}