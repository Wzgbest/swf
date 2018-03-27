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

class Templet extends AdminBase
{
    public function __construct(){
        $this->table=config('database.prefix').'model';
        parent::__construct();
    }
    //获取所有模板
    public function getAllTemplet(){
        $map['status'] = ['neq','2'];
        return $this->model->table($this->table)->where($map)->order('create_time desc')->select();
    }
    //添加模板
    public function addOneTemplate($data){
        return $this->model->table($this->table)->insertGetId($data);
    }
    //根据编号查找
    public function getTemplateByNum($num){
        return $this->model->table($this->table)->where(['model_num'=>$num])->find();
    }
    //根据id查找
    public function getTemplateById($id){
        return $this->model->table($this->table)->where(['id'=>$id])->find();
    }
    //更新信息
    public function updateTemplateById($id,$data){
        return $this->model->table($this->table)->where(['id'=>$id])->update($data);
    }
    //删除
    public function deleteTemplateById($ids){
        $map['id'] = ['in',$ids];
        return $this->model->table($this->table)->where($map)->update(['status'=>2]);
    }
    /**
     * =====================
     * =====================场景相关方法
     */
    //添加场景
    public function addScene($data){
        $res = $this->model->table($this->dbprefix.'scene')->insertGetId($data);
        return $res;
    }
    //获取该模板所有的场景
    public function getAllSceneByModelId($modelid){
        $info = $this->model->table($this->dbprefix.'scene')->where(['modelid'=>$modelid])->select();
        return $info;
    }
    //根据id获取场景
    public function getSceneById($id){
        $info = $this->model->table($this->dbprefix.'scene')->alias('sc')
            ->join($this->dbprefix."model mo","mo.id = sc.modelid","LEFT")
            ->where(['sc.id'=>$id])
            ->field("sc.*,mo.model_name,mo.model_num")
            ->find();
        return $info;
    }
    //根据id获取场景图片
    public function getImagesBySceneId($id){
        $info = $this->model->table($this->dbprefix.'default_images')->alias('sc')
            ->where(['sceneid'=>$id])
            ->order('sort,id')
            ->select();
        return $info;
    }
    //根据id获取场景文字
    public function getTextsBySceneId($id){
        $info = $this->model->table($this->dbprefix.'default_texts')->alias('sc')
            ->where(['sceneid'=>$id])
            ->order('sort,id')
            ->find();
        return $info;
    }
    //根据场景id删除场景
    public function deleteSceneById($id){
        return $this->model->table($this->dbprefix.'scene')->where(['id'=>$id])->delete();
    }
    //根据场景id查找最后一个排序数值
    public function getImgSortBySceneId($id){
        $info = $this->model->table($this->dbprefix.'default_images')->where(['sceneid'=>$id])->order("sort desc")->find();
        return $info;
    }
    //查询模板所有场景及素材
    public function getScenesAndImagesAndTextsOnlyByModelId($modelid){
        $scenes = $this->model->table($this->dbprefix."scene")->where(['modelid'=>$modelid])->select();
        foreach ($scenes as $k=>$v) {
            $images = $this->model->table($this->dbprefix."default_images")->where(['sceneid'=>$v['id']])->order("id")->select();
            $scenes[$k]['images'] = $images;
            $texts = $this->model->table($this->dbprefix."default_texts")->where(['sceneid'=>$v['id']])->find();
            if ($texts['text']){
                $datas = [];
                $tt = explode(';',$texts['text']);
                foreach ($tt as $t){
                    $data['text'] = $t;
                    $datas[] = $data;
                }
                $scenes[$k]['texts'] = $datas;
            }else{
                $scenes[$k]['texts'] = [];
            }

        }
        return $scenes;
    }
    //获取模板可以修改的地方
    public function getEditNumByModelId($id){
        $img_num = $this->model->table($this->dbprefix."scene")->where(['modelid'=>$id])->column('img_num');
        $text_num = $this->model->table($this->dbprefix."scene")->where(['modelid'=>$id])->column('text_num');
        return ['img_num'=>$img_num,'text_num'=>$text_num];
    }
    /**
     * ==================场景方法结束
     */
    //保存照片
    //存储图片
    public function saveImage($data){
        return $this->model->table($this->dbprefix."default_images")->insertGetId($data);
    }
    //保存场景文字用；分割
    public function saveText($data){
        return $this->model->table($this->dbprefix."default_texts")->insertGetId($data);
    }
    //跟新场景文字用；分割
    public function updateText($id,$data){
        return $this->model->table($this->dbprefix."default_texts")->where(['id'=>$id])->update($data);
    }

    /**
     * 查询一条可以渲染的产品
     */
    public function getProduct(){
        $info = $this->model->table($this->dbprefix."products")->alias('pr')
            ->join($this->dbprefix."model md",'md.id = pr.modelid','LEFT')
            ->where(['pr.status'=>1])
            ->field("pr.id,pr.userid,pr.modelid,pr.status,md.model_num,md.time")
//            ->order('update_time desc')
            ->find();
        return $info;
    }
    /**
     * 获取用户可以渲染的用户的素材
     */
    //查询模板所有场景及素材
    public function getScenesAndImagesAndTextsByModelId($modelid,$productid){
        $scenes = $this->model->table($this->dbprefix."scene")->where(['modelid'=>$modelid])->order('sort')->select();
        foreach ($scenes as $k=>$v) {
            $images = $this->model->table($this->dbprefix."images")->where(['sceneid'=>$v['id'],'productid'=>$productid])->order("sort")->select();
            $scenes[$k]['images'] = $images;
            $texts = $this->model->table($this->dbprefix."text")->where(['sceneid'=>$v['id'],'productid'=>$productid])->order('sort')->select();
            $scenes[$k]['texts'] = $texts;
        }
        return $scenes;
    }

    /**
     * @param $id
     * @param $data
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOExceptions 跟新产品表
     */
    public function updateProductById($id,$data){
        return $this->model->table($this->dbprefix."products")->where(['id'=>$id])->update($data);
    }

    /**
     * 获取背景音乐
     */
    public function getBgm($productid)
    {
        return $this->model->table($this->dbprefix.'music')->where(['productid'=>$productid])->find();
    }
}