<?php
/**
 * Created by PhpStorm.
 * User: QYIT
 * Date: 2018/3/27
 * Time: 15:02
 */

namespace app\admin\model;


use app\common\model\AdminBase;

class CatesModel extends AdminBase
{
    public function __construct(){
        $this->table=config('database.prefix').'cates';
        parent::__construct();
    }

    /**
     * 获取所有的数据
     */
    public function getAllCates($map=[])
    {
        return $this->model->table($this->table)->field("id,pid,name,create_time,sort,status")->where($map)->select();
    }

    /**
     * 获取一个分类
     */
    public function getOneCateById($id)
    {
        return $this->model->table($this->table)->field("id,pid,name,create_time,sort,status")->where(['id'=>$id])->find();
    }

    /**
     * 添加分类
     */
    public function insertOneCate($data)
    {
        return $this->model->table($this->table)->insertGetId($data);
    }

    /**
     * 跟新数据
     */
    public function updateOneCateById($id,$data)
    {
        return $this->model->table($this->table)->where(['id'=>$id])->update($data);
    }

    /**
     * 查找子类
     */
    public function getChildCatesByPid($pid)
    {
        return $this->model->table($this->table)->where(['pid'=>$pid])->select();
    }

    /**
     * 删除分类
     */
    public function deleteCateById($id)
    {
        return $this->model->table($this->table)->where(['id'=>$id])->delete();
    }
}