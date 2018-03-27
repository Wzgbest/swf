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

class Templet extends CustomBase
{

    /**
     * Templet constructor.
     */
    public function __construct()
    {
        $this->table=config('database.prefix').'model';
        parent::__construct();
    }
    //模板列表
    public function getAllTemplate(){
        return $this->model->table($this->table)->where(['status'=>1])->order('id desc')->select();
    }
    //根据id获取
    public function getTemplateById($id){
        return $this->model->table($this->table)->where(['id'=>$id])->find();
    }
    //会员的使用的模板
    public function getUserTemplate($uid){
        $map['pr.userid'] = $uid;
        $map['pr.status'] = ['neq',2];
        $info = $this->model->table($this->dbprefix."products")->alias('pr')
            ->join($this->dbprefix."model md",'md.id = pr.modelid','LEFT')
            ->where($map)
            ->field("pr.*,md.model_name,md.model_num,md.img")
            ->order('pr.id desc')
            ->select();

        return $info;
    }

    //会员删除
    public function deleteUserTemplate($ids){
        $map['id'] = ['in',$ids];
        return $this->model->table($this->dbprefix."products")->where($map)->update(['status'=>2]);
    }

    //根据id获取
    public function getProductById($id){
        $info = $this->model->table($this->dbprefix.'products')->alias('pr')
            ->join($this->dbprefix.'model md','md.id = pr.modelid',"LEFT")
            ->where(['pr.id'=>$id])
            ->field("pr.*,md.model_name,md.model_num,md.template")
            ->find();

        return $info;
    }
    //获取图片
    public function getImgByIdAndUid($pid,$uid){
        return $this->model->table($this->dbprefix."images")->where(['productid'=>$pid,'userid'=>$uid])->select();
    }
    //获取视频
    public function getTextByIdAndUid($pid,$uid){
        return $this->model->table($this->dbprefix."text")->where(['productid'=>$pid,'userid'=>$uid])->find();
    }
    /**
     * 新添加方法
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
    //获取所有的场景
    public function getImagesAndTextByModelId($modelid){
        $scenes = $this->model->table($this->dbprefix."scene")->where(['modelid'=>$modelid])->field("id")->select();
        $ids = [];
        foreach ($scenes as $scene) {
            $ids[] = $scene['id'];
        }
        $images = $this->model->table($this->dbprefix."default_images")->where("sceneid",'in',$ids)->select();
        $text = $this->model->table($this->dbprefix."default_texts")->where("sceneid",'in',$ids)->select();
        $data['images'] = $images;
        $data['text'] = $text;
        return $data;
    }
    //根据imgid获取modelid
    public function getModelByImgId($id){
        $info = $this->model->table($this->dbprefix."images")->alias("img")
            ->join($this->dbprefix."scene sc","img.sceneid = sc.id","LEFT")
            ->join($this->dbprefix."model mo","mo.id = sc.modelid","LEFT")
            ->where(['img.id'=>$id])
            ->field("mo.model_num")
            ->find();
        return $info;
    }
    //跟新上下线关系
    //更新信息
    public function updateProductById($id,$data){
        return $this->model->table($this->dbprefix."products")->where(['id'=>$id])->update($data);
    }

}