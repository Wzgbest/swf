<?php
namespace app\custom\controller;

use app\common\controller\CustomInitialize;
use app\custom\model\Save as SaveModel;
use app\custom\model\Templet;
use app\admin\model\Templet as AdminTemp;
use think\Db;

class Index extends CustomInitialize
{
    public function index(){
        return view();
    }
    public function welcome(){
        return view();
    }
    //素材上传页面
    public function template_add(){
        $id = input('id',0,'int');
        $saveM = new SaveModel();
        //查看所有的数据输出到前台
        $templeteM = new Templet();
        Db::startTrans();
        try{
            //保存模板到用户的账号下
            $product['userid'] = $this->c_uid;
            $product['modelid'] = $id;
            $product['create_time'] = time();
            $productid = $saveM->saveProduct($product);
            if (!$productid) {
                $result = '保存用户模板失败';
                exception("保存用户模板失败");
            }
            $model_scene = $templeteM->getImagesAndTextByModelId($id);
            $images = $model_scene['images'];
            $text = $model_scene['text'];
            if (!empty($images)) {
                $image['productid'] = $productid;
                $image['userid'] = $this->c_uid;
                foreach ($images as $key=>$value){
                    $image['img'] = $value['img'];
                    $image['create_time'] = time();
                    $image['sceneid'] = $value['sceneid'];
                    $image['sort'] = $value['sort'];
                    $data_images[] = $image;
                }
                $res = $saveM->saveAllImage($data_images);
                if (!$res){
                    $result = '保存用户默认图片失败';
                    exception("保存用户默认图片失败");
                }
            }

            if (!empty($text)){
                foreach ($text as $k=>$item) {
                    $zi = explode(';',$item['text']);
                    $ll['userid'] = $this->c_uid;
                    $ll['productid'] = $productid;
                    $ll['sceneid'] = $item['sceneid'];
                    if ($item['text'] != ''){
                        foreach ($zi as $key=>$v) {
                            $ll['text'] = $v;
                            $ll['sort'] = $key + 1;
                            $texts[] = $ll;
                        }
                    }
                }
                $res = $saveM->saveText($texts);
                if (!$res){
                    $result = '保存用户默认文字失败';
                    exception("保存用户默认文字失败");
                }
            }

            Db::commit();
        }catch (\Exception $e){
            Db::rollback();
            return $result;
        }
        $scenes = $templeteM->getScenesAndImagesAndTextsByModelId($id,$productid);
        $this->assign('scenes',$scenes);
        $this->assign('modelid',$id);
        return view();
    }

    //列表页面
    public function template_list()
    {
        $templetM = new Templet();
        $templet_list = $templetM->getAllTemplate();
        $this->assign('list', $templet_list);
        $this->assign('count', count($templet_list));
        return view();
    }
    //展示页面
    public function template_show()
    {
        $id = input('id', 0, 'int');
        $templetM = new Templet();
        $template = $templetM->getTemplateById($id);
        $admin_templeteM = new AdminTemp();
        $res = is_file(ROOT_PATH . "public" . DS . "xml" . DS . $template['model_num'] . DS . "ylsp_default.xml");
        if (!$res) {
            $all_info = $admin_templeteM->getScenesAndImagesAndTextsOnlyByModelId($id);
            $bac = _getXML(0, $template['model_num'], 0, $all_info);
        }
        $num = $admin_templeteM->getEditNumByModelId($id);
        $template['url'] = "/model/" . $template['template'];
        $template['xml_url'] = "/xml/" . $template['model_num'] . "/ylsp_default.xml";
        $template['img_num'] = array_sum($num['img_num']);
        $template['text_num'] = array_sum($num['text_num']);
//        var_exp($template);
        $this->assign('info', $template);
        return view();
    }
    //上传
    public function upload(){
        $result = ['status'=>0,'message'=>"上传失败"];

        $img = request()->file('file');
        $img_id = input('img_id',0,'int');
//        var_exp($img_id,"img");die();
        //判断是否为空
        if (!$img){
            $result['message'] = "信息为空";
            return json($result);
        }
        $templetM = new Templet();
        $model = $templetM->getModelByImgId($img_id);
        if ($img){
            $path = ROOT_PATH."public".DS."images".DS.$model['model_num'].DS.$this->c_uid;
            $res = $img->check(["ext"=>"jpg,png,gif","size"=>1048500]);
            if ($res){
                $info = $img->move($path);
            }else{
                $result['message'] = "格式错误";
                return json($result);
            }
            if ($info === false){
                $result['message'] = "图片上传失败";
                return json($result);
            }
            $savename = $info->getSaveName();
        }
        $saveM = new SaveModel();
        $data['is_edit'] = 1;
        $data['img'] = "/images/".$model['model_num']."/".$this->c_uid."/".$savename;
        $res = $saveM->updateImgByImgId($img_id,$data);
        if ($res){
            $result['status'] = 1;
            $result['message'] = "保存成功";
        }
        return json($result);
    }

    //保存信息
    public function save_text(){
        $result = ['status'=>0,'message'=>"保存失败"];

        $textid = input('id',0,'int');
        $texts = input('text','','string');
//        var_exp($texts);die();
        if (!$textid || !$texts){
            $result['message'] = "参数为空";
            return json($result);
        }
        $saveM = new SaveModel();
        $data['text'] = $texts;
        $res = $saveM->updateTextByTextId($textid,$data);
        if ($res){
            $result['message'] = "更新成功";
            $result['status'] = 1;
        }

        return json($result);
    }
}