<?php
/**
 * Created by PhpStorm.
 * User: QYIT
 * Date: 2018/1/20
 * Time: 15:33
 */

namespace app\index\model;


use app\common\model\CustomBase;

class Template extends CustomBase
{
    /**
     * Templet constructor.
     */
    public function __construct()
    {
        $this->table=config('database.prefix').'model';
        parent::__construct();
    }
    //根据id获取
//    public function getProductById($id)
//    {
//        $info = $this->model->table($this->table)->alias('pr')
//            ->join($this->dbprefix.'model md','md.id = pr.modelid',"LEFT")
//            ->where(['pr.id'=>$id])
//            ->field("pr.*,md.model_name,md.model_num,md.template")
//            ->find();
//
//        return $info;
//    }

    //获取列表
//    public function getProductList()
//    {
//        return $this->model->table($this->table)->where(['status'=>1])->select();
//    }

    /**
     * 获取模板列表
     */
    //模板列表
    public function getAllTemplate($map,$limit){
        return $this->model->table($this->table)->where($map)->order('id desc')->paginate($limit);
    }

    /**
     * 根据id获取模板
     */
    public function getTemplateById($id){
        return $this->model->table($this->table)->where(['id'=>$id])->find();
    }

    /**
     * 获取可以修改图片和文字的多少和位置
     */
    public function getEditNumByModelId($id){
        $img_num = $this->model->table($this->dbprefix."scene")->where(['modelid'=>$id])->column('img_num');
        $text_num = $this->model->table($this->dbprefix."scene")->where(['modelid'=>$id])->column('text_num');
        return ['img_num'=>$img_num,'text_num'=>$text_num];
    }

    /**
     * 保存用户视频
     */
    public function saveProduct($data){
        return $this->model->table($this->dbprefix."products")->insertGetId($data);
    }

    /**
     * 获取所有的场景 图片 文字
     */
    public function getImagesAndTextByModelId($modelid){
        $scenes = $this->model->table($this->dbprefix."scene")->where(['modelid'=>$modelid])->field("id")->select();
        $ids = [];
        foreach ($scenes as $scene) {
            $ids[] = $scene['id'];
        }
        $images = $this->model->table($this->dbprefix."default_images")->where("sceneid",'in',$ids)->order('sceneid,sort')->select();
        $text = $this->model->table($this->dbprefix."default_texts")->where("sceneid",'in',$ids)->order('sceneid,sort')->select();
        $data['images'] = $images;
        $data['text'] = $text;
        return $data;
    }

    /**
     * 将默认的场景图片全部保存了客户的图片表中
     */
    public function saveAllImage($data){
        return $this->model->table($this->dbprefix."images")->insertAll($data);
    }

    /**
     * 将默认的文字存储到客户的文字存储表中
     */
    //存储文字
    public function saveText($data){
        return $this->model->table($this->dbprefix."text")->insertAll($data);
    }

    /**
     * 获取用户所有的图片和文字场景
     */
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
     * 根据imgid获取model
     */
    public function getModelByImgId($id){
        $info = $this->model->table($this->dbprefix."images")->alias("img")
            ->join($this->dbprefix."scene sc","img.sceneid = sc.id","LEFT")
            ->join($this->dbprefix."model mo","mo.id = sc.modelid","LEFT")
            ->where(['img.id'=>$id])
            ->field("img.*,mo.model_num")
            ->find();
        return $info;
    }

    /**
     * 跟新图片信息
     */
    public function updateImgByImgId($img_id,$data){
        return $this->model->table($this->dbprefix."images")->where(['id'=>$img_id])->update($data);
    }

    /**
     * 跟新文字信息
     */
    public function updateTextByTextId($text_id,$data){
        return $this->model->table($this->dbprefix."text")->where(['id'=>$text_id])->update($data);
    }

    /**
     * 用户的视频
     */
    public function getUserTemplate($uid,$status,$where=[],$limit=''){
        $map['pr.userid'] = $uid;
        $map['pr.status'] = ['between',$status];
        $info = $this->model->table($this->dbprefix."products")->alias('pr')
            ->join($this->dbprefix."model md",'md.id = pr.modelid','LEFT')
            ->where($map)
            ->where($where)
            ->field("pr.*,md.model_name,md.model_num,md.img,md.time")
            ->order('pr.update_time desc,pr.id desc')
            ->paginate($limit);

        return $info;
    }

    /**
     * 获取某个视频
     */
    public function getOneById($id)
    {
        $product = $this->model->table($this->dbprefix."products")->alias('pr')
            ->join($this->dbprefix."model md",'md.id = pr.modelid','LEFT')
            ->where(['pr.id'=>$id])
            ->field("pr.*,md.model_name,md.model_num,md.img,md.time")
            ->find();
        return $product;
    }

    /**
     * 跟新用户视频的状态
     */
    public function upOneById($id,$data)
    {
        $product = $this->model->table($this->dbprefix.'products')->where(['id'=>$id])->update($data);
        return $product;
    }

    /**
     * 查询是否有为编辑的图片
     */
    public function findNoEditImg($productid)
    {
        $info = $this->model->table($this->dbprefix.'images')->where(['productid'=>$productid,'is_edit'=>0])->find();
        return $info;
    }

    /**
     * 获取某个分类已经完成的视频数量
     */
    public function getCountByCateAndUser($uid,$cate)
    {
        $info = $this->model->table($this->dbprefix.'products')->where(['userid'=>$uid,'cate'=>$cate,'status'=>3])->count();
        return $info;
    }

    /**
     * 获取图片根据路劲
     */
    public function getOneImage($map)
    {
        return $this->model->table($this->dbprefix.'images')->where($map)->find();
    }

    /**
     * 获取用户公共上传的图片
     */
    public function getAllPubliceImg($uid)
    {
        $images = $this->model->table($this->dbprefix.'publice_images')->where(['userid'=>$uid])->order('id desc')->select();
        return $images;
    }

    /**
     * 添加公共图片
     */
    public function addImgToPub($uid,$img)
    {
        $data['userid'] = $uid;
        $data['img'] = $img;
        $res = $this->model->table($this->dbprefix.'publice_images')->where(['userid'=>$uid])->insertGetId($data);

        return $res;
    }

    /**
     * 删除公共图片
     */
    public function delOnePubImg($id)
    {
        return $this->model->table($this->dbprefix.'publice_images')->where(['id'=>$id])->delete();
    }

    /**
     * 跟新公共图片
     */
    public function updatePublicImg($imgid,$data)
    {
        return $this->model->table($this->dbprefix."publice_images")->where(['id'=>$imgid])->update($data);
    }

    /**
     * 获取一个公共图片信息
     */
    public function getOnePublicImg($imgid)
    {
        return $this->model->table($this->dbprefix.'publice_images')->where(['id'=>$imgid])->find();
    }

    /**
     * 获取一个产品的所有图片
     */
    public function getAllOldImg($productid)
    {
        $img_arr = $this->model->table($this->dbprefix.'images')->where(['productid'=>$productid])->order('sceneid,sort')->select();

        return $img_arr;
    }

    /**
     * 查看所有的音乐
     */
    public function getUserAllMusic($uid)
    {
        $music = $this->model->table($this->dbprefix.'public_music')->where(['userid'=>$uid])->select();

        return $music;
    }

    /**
     * 查找库中的音乐
     */
    public function getOneMusicById($id)
    {
        return $this->model->table($this->dbprefix.'public_music')->where(['id'=>$id])->find();
    }

    /**
     * 保存模板音乐
     */
    public function addProductBgmById($data)
    {
        return $this->model->table($this->dbprefix.'music')->insertGetId($data);
    }

    /**
     * 上传公共音乐
     */
    public function userAddPublicMusic($data)
    {
        return $this->model->table($this->dbprefix.'public_music')->insertGetId($data);
    }

    /**
     * 查找product背景音乐是否存在
     */
    public function getProductBgm($productid)
    {
        return $this->model->table($this->dbprefix.'music')->where(['productid'=>$productid])->find();
    }

    /**
     * 跟新背景音乐
     */
    public function updateProductBgmById($productid,$data)
    {
        return $this->model->table($this->dbprefix.'music')->where(['productid'=>$productid])->update($data);
    }

    /**
     * 删除背景音
     */
    public function deletBgmById($id)
    {
        return $this->model->table($this->dbprefix.'public_music')->where(['id'=>$id])->delete();
    }

    /**
     * 删除已经填加的背景音乐
     */
    public function deletProductBgm($productid)
    {
        return $this->model->table($this->dbprefix.'music')->where(['productid'=>$productid])->delete();
    }

    /**
     * 获取所有的公共音乐
     */
    public function getAllPubliceMusic()
    {
        return $this->model->table($this->dbprefix.'public_music')->where(['userid'=>0])->select();
    }
}