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

class Save extends CustomBase{
    public function __construct(){
        parent::__construct();
    }
    //查询产品
    public function getProductInfo($uid,$modelid){
        return $this->model->table($this->dbprefix."products")->where(['userid'=>$uid,'modelid'=>$modelid,'status'=>0])->find();
    }
    //保存用户产品
    public function saveProduct($data){
        return $this->model->table($this->dbprefix."products")->insertGetId($data);
    }
    //存储图片
    public function saveAllImage($data){
        return $this->model->table($this->dbprefix."images")->insertAll($data);
    }
    //存储文字
    public function saveText($data){
        return $this->model->table($this->dbprefix."text")->insertAll($data);
    }
    //跟新图片信息
    public function updateImgByImgId($img_id,$data){
        return $this->model->table($this->dbprefix."images")->where(['id'=>$img_id])->update($data);
    }
    //跟新文字信息
    public function updateTextByTextId($text_id,$data){
        return $this->model->table($this->dbprefix."text")->where(['id'=>$text_id])->update($data);
    }
    //更新信息
    public function updateProductInfo($productid,$data){
        return $this->model->table($this->dbprefix."products")->where(['id'=>$productid])->update($data);
    }
    //更新文字
    public function updateTextInfo($uid,$productid,$data){
        return $this->model->table($this->dbprefix."text")->where(['userid'=>$uid,'productid'=>$productid])->update($data);
    }
    //查询文字
    public function getProductText($uid,$productid){
        return $this->model->table($this->dbprefix."text")->where(['userid'=>$uid,'productid'=>$productid])->find();
    }
}