<?php
/**
 * Created by PhpStorm.
 * User: QYIT
 * Date: 2018/3/27
 * Time: 14:46
 */

namespace app\admin\controller;


use app\admin\model\CatesModel;
use app\common\controller\AdminInitialize;

class Cates extends AdminInitialize
{
    /**
     * 分类列表
     */
    public function index()
    {
        $cate = new CatesModel();
        $cates = $cate->getAllCates();

        $this->assign('count',count($cates));
        $this->assign('cates',$cates);
        return view();
    }

    /**
     * 分类添加编辑页面
     */
    public function cateAdd()
    {
        $id = input('id',0,'int');
        if ($id){
            $cat = new CatesModel();
            $cate = $cat->getOneCateById($id);
        }
        $this->assign('cate',isset($cate));
        return view('cate_add');
    }

    /**
     * 分类添加
     */
    public function add()
    {
        $result = ['status'=>0,'message'=>"添加失败"];
        $name = input('catename','','string');
        $pid = input('pid',0,'int');
        $status = input('status',0,'int');
        $sort = input('sort',0,'int');
        $cate = new CatesModel();
        $data['name'] = $name;
        $data['pid'] = $pid;
        $data['status'] = $status;
        $data['sort'] = $sort;
        $data['create_time'] = time();
        $res = $cate->insertOneCate($data);

        if ($res){
            $result['status'] = 1;
            $result['message'] = "添加成功";
        }
        return json($result);
    }

    /**
     * 编辑
     */
    public function edit()
    {
        $result = ['status'=>0,'message'=>"跟新失败"];
        $id = input('id',0,'int');
        $pid = input('pid',0,'int');
        $name = input('catename','','string');
        $sort = input('sort',0,'int');
        $is_done = input('is_done',0,'int');
        $status = input('status',0,'int');

        if ($is_done && !$status){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }
        if ($pid){
            $data['pid'] = $pid;
        }
        if ($name){
            $data['name'] = $name;
        }
        if ($sort){
            $data['sort'] = $sort;
        }

        $cate = new CatesModel();
        $res = $cate->updateOneCateById($id,$data);
        if ($res){
            $result['status'] = 1;
            $result['message'] = "跟新成功";
        }

        return json($result);
    }

    /**
     * 删除分类
     */
    public function delete()
    {
        $id = input('id',0,'int');

        $cate = new CatesModel();
        //查找是否有子类
        $info = $cate->getChildCatesByPid($id);
        if (!empty($info)){
            return json(['status'=>0,'message'=>"请删除子类后再操作"]);
        }

        $flg = $cate->deleteCateById($id);
        if ($flg)
        {
            return json(['status'=>1,'message'=>"删除成功"]);
        }
        return json(['status'=>0,'message'=>"删除失败"]);
    }
}