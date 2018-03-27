<?php
// +----------------------------------------------------------------------
// | 全影集团 [ 纯粹、极致到零 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.7192.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wuzhenguo <wuzhenguook@gmail.com> <The Best Word!!!>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\common\controller\AdminInitialize;
use think\Db;
use app\admin\model\Templet;
use think\File;

class Index extends AdminInitialize
{
    public function index()
    {
        return view();
    }
    public function welcome(){
        return view();
    }
    //列表页面
    public function template_list(){
        $templetM = new Templet();
        $templet_list = $templetM->getAllTemplet();
        $this->assign('list',$templet_list);
        $this->assign('count',count($templet_list));
        return view();
    }
    //添加页面
    public function template_add(){
        $id = input('id',0,'int');
        $model_info = '';
        if ($id){
            $templetM = new Templet();
            $model_info = $templetM->getTemplateById($id);
        }
        $this->assign("info",$model_info);
        return view();
    }
    //展示页面
    public function template_show(){
        $id = input('id',0,'int');
        $templetM = new Templet();
        $template = $templetM->getTemplateById($id);
        $res = is_file(ROOT_PATH."public".DS."xml".DS.$template['model_num'].DS."ylsp_default.xml");
        if (!$res){
            $all_info = $templetM->getScenesAndImagesAndTextsOnlyByModelId($id);
            $bac = _getXML(0,$template['model_num'],0,$all_info);
        }
        $template['url'] = "/model/".$template['template'];
        $template['xml_url'] = "/xml/".$template['model_num']."/ylsp_default.xml";
        $this->assign('info',$template);
        return view();
    }
    //编辑页面
    public function template_edit(){
        $id = input('id',0,'int');
        $templetM = new Templet();
        $info = $templetM->getAllSceneByModelId($id);
        $this->assign('scenes',json_encode($info));
        $this->assign('modelid',$id);
        return view();
    }
    //情景
    public function scene(){
        $id = input('id',0,'int');
        $this->assign('modelid',$id);
        return view();
    }
    //添加场景
    public function add_scene(){
        $id = input('id',0,'int');
        if ($id) {
            $templetM = new Templet();
            $info = $templetM->getSceneById($id);
            $images = $templetM->getImagesBySceneId($id);
            $text = $templetM->getTextsBySceneId($id);
            $texts = explode(";",$text['text']);
            $info['real_img_num'] = count($images);
            $info['real_text_num'] = count($texts);
            $info['images'] = $images;
            $info['texts'] = $text['text'];
            $this->assign('info',$info);
//            var_exp($info,'info');
        }
        $this->assign('sceneid',$id);
        return view();
    }
    //模板保存上传验证
    public function upload(){
        $result = ['status'=>0,'message'=>"上传失败"];

//        $swf = request()->file('swf');
        $img = request()->file('img');
        //上传的素材
        $files = request()->file('file');
        $movie = request()->file('movie');
        $model_name = input('model_name','','string');
        $model_num = input('model_num',0,'int');
        $sort = input('sort',0,'int');
        $status = input('status','','string');
        $content = input('content','','string');
        $time = input('time','','string');
        $templateM = new Templet();
        $info = $templateM->getTemplateByNum($model_num);
        if ($info){
            $result['message'] = "编号已经存在";
            return json($result);
        }
//        var_exp($files);die();
        if (!$model_name || !$model_name || empty($img) || !$content || !$time){
            $result['message'] = "信息填写不完整";
            return json($result);
        }
        if($movie) {
            $path = ROOT_PATH . 'public' . DS . 'movie';
            $file_flg = $movie->check(["ext"=>'mp4,mov,avi']);
            if (!$file_flg){
                $result['message'] = "上传类型不对";
                return json($result);
            }
            $info = $movie->move($path,$model_num);

            $swf_savename = $info->getSaveName();
            $data['template'] = '/movie/'.$swf_savename;
        }else{
            $data['template'] = '/movie/'.$model_num.".mp4";
        }
        if($img) {
            $path = ROOT_PATH . 'public' . DS . 'images' . DS . $model_num . DS . "default";
            $file_flg = $img->check(["ext"=>'jpg,png,gif']);
            if (!$file_flg){
                $result['message'] = "上传类型不对";
                return json($result);
            }
            $info = $img->move($path,$model_num);

            $img_savename = $info->getSaveName();
        }
        if (!is_dir(ROOT_PATH . 'public' . DS . 'model' . DS . $model_num)) {
            mkdir(ROOT_PATH . 'public' . DS . 'model' . DS . $model_num);
        }
        if ($files) {
            $path = ROOT_PATH . 'public' . DS . 'model' . DS . $model_num;
            foreach ($files as $key=>$file) {
                $filename = $_FILES['file']['name'][$key];
                $name = explode('.',$filename);
                $info = $file->move($path,$name[0]);
            }
        }

        $url = DS . 'images' . DS . $model_num . DS . 'default' . DS;
        $data['model_name'] = $model_name;
        $data['model_num'] = $model_num;
        if ($status == 'on'){
            $data['status'] = 1;
        }else {
            $data['status'] = 0;
        }
        $data['create_time'] = time();
        $data['img'] = $url.$img_savename;
        $data['sort'] = $sort;
        $data['time'] = $time;
        $data['content'] = $content;
//        var_exp($data);die();
        $flg = $templateM->addOneTemplate($data);
        if ($flg){
            $result['status'] = 1;
            $result['message'] = "添加成功";
        }
        return json($result);
    }
    //编辑模板信息
    public function info_edit(){
        $result = ['status'=>0,'message'=>"上传失败"];

        $id = input('id',0,'int');
        $swf = request()->file('swf');
        $img = request()->file('img');
        $model_name = input('model_name','','string');
        $model_num = input('model_num',0,'int');
        $sort = input('sort',0,'int');
        $status = input('status','','string');
        $content = input('content','','string');
        $time = input('time','','string');
        $templateM = new Templet();
//        var_exp($swf,"swf");
//        var_exp($img,"img");
//        die();
        if (!$id){
            $result['message'] = "信息填写不完整";
            return json($result);
        }
        $url = DS . 'images' . DS . $model_num . DS . 'default' . DS;
        if($swf) {
            $path = ROOT_PATH . 'public' . DS . 'model';
            $file_flg = $swf->check(["ext"=>'swf']);
            if (!$file_flg){
                $result['message'] = "上传类型不对";
                return json($result);
            }
            $info = $swf->move($path,$model_num);

            $swf_savename = $info->getSaveName();
            $data['template'] = $swf_savename;
        }
        if($img) {
            $path = ROOT_PATH . 'public' . DS . 'images' . DS . $model_num . DS . "default";
            $file_flg = $img->check(["ext"=>'jpg,png,gif']);
            if (!$file_flg){
                $result['message'] = "上传类型不对";
                return json($result);
            }
            $info = $img->move($path);

            $img_savename = $info->getSaveName();
            $data['img'] = '/images/' .  $model_num . '/default/' . $img_savename;
        }

        $data['model_name'] = $model_name;
        $data['model_num'] = $model_num;
        if ($status == 'on'){
            $data['status'] = 1;
        }else {
            $data['status'] = 0;
        }
//        $data['create_time'] = time();

        $data['sort'] = $sort;
        $data['time'] = $time;
        $data['content'] = $content;
        $flg = $templateM->updateTemplateById($id,$data);
        var_exp($flg,"data");die();
        if ($flg){
            $result['status'] = 1;
            $result['message'] = "添加成功";
        }
        return json($result);
    }
    //编辑上下线功能
    public function edit(){
        $result = ['status'=>0,'message'=>"修改失败"];
        $id = input('id',0,'int');
        $is_done = input('is_done',0,'int');
        if (!$id){
            $result['message'] = "编号为空";
            return json($result);
        }
        $templateM = new Templet();
        $info = $templateM->getTemplateById($id);
        if ($is_done){
            if ($info['status']){
                $flg = $templateM->updateTemplateById($id,['status'=>0]);
                if ($flg){
                    $result['status'] = 1;
                    $result['message'] = "更新成功";
                }
            }else{
                $result['message'] = "已经下架";
            }
        }else{
            if ($info['status']){
                $result['message'] = "已经上线";
            }else{
                $flg = $templateM->updateTemplateById($id,['status'=>1]);
                if ($flg){
                    $result['status'] = 1;
                    $result['message'] = "更新成功";
                }
            }
        }

        return json($result);
    }

    //删除
    public function delete(){
        $result = ['status'=>0,'message'=>"删除失败"];
        $ids = input('ids/a');

        if (empty($ids)){
            $result['message'] = "信息为空";
            return json($result);
        }
        $templateM = new Templet();

        $res = $templateM->deleteTemplateById($ids);
        if ($res){
            $result['status'] = 1;
            $result['message'] = "删除成功";
        }

        return json($result);
    }

    //场景上传
    public function scene_upload(){
        $result = ['status'=>0,'message'=>"场景保存失败"];

        $modelid = input('modelid',0,'int');
        $scene_name = input('scene_name','','string');
        $img_num = input('img_num',0,'int');
        $text_num = input('text_num',0,'int');
        $sort = input('sort',0,'int');

        if (!$modelid || !$scene_name) {
            $result['message'] = "模板标识为空或无场景名称";
            return json($result);
        }
        $data['modelid'] = $modelid;
        $data['text_num'] = $text_num;
        $data['img_num'] = $img_num;
        $data['sort'] = $sort;
        $data['scene_name'] = $scene_name;
        $data['create_time'] = time();
        $templetM = new Templet();
        $res = $templetM->addScene($data);
        if ($res){
            $result['status'] = 1;
            $result['message'] = "保存成功";
        }
        return json($result);
    }
    //删除场景
    public function scene_delete(){
        $result = ['status'=>0,'message'=>"删除失败"];
        $id = input('id',0,'int');
        if (!$id) {
            $result['message'] = "id不能为空";
            return json($result);
        }
        $templetM = new Templet();
        $res = $templetM->deleteSceneById($id);
        if ($res) {
            $result['status'] = 1;
            $result['message'] = "删除成功";
        }

        return json($result);
    }

    //场景素材图片上传
    function scene_img_upload(){
        $result = ['status'=>0,'message'=>"上传失败"];

        $img = request()->file('file');
        $sceneid = input('sceneid',0,'int');
        //判断是否为空
        if (empty($img)){
            $result['message'] = "图片信息为空";
            return json($result);
        }
        $templetM = new Templet();
        $scene_info = $templetM->getSceneById($sceneid);
        if ($img){
            $path = ROOT_PATH."public".DS."images".DS.$scene_info['model_num'].DS."default";
            $res = $img->check(["ext"=>"jpg,png,gif","size"=>2097152]);
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
        //保存图片表信息
        $image['sceneid'] = $sceneid;
        $image['img'] = "/images/".$scene_info['model_num']."/default/". $savename;

        list($width, $height) = getimagesize(ROOT_PATH."public".DS."images".DS.$scene_info['model_num'].DS."default".DS.$savename);
        $this->adminSmallImg(ROOT_PATH."public".DS."images".DS.$scene_info['model_num'].DS."default".DS.$savename,300,200);
        $this->imgReset(ROOT_PATH."public".DS."images".DS.$scene_info['model_num'].DS."default".DS.$savename,1920,1080);

        $image['width'] = $width;
        $image['height'] = $height;
        $img_info = $templetM->getImgSortBySceneId($sceneid);
        if (!empty($img_info)){
            $image['sort'] = $img_info['sort'] + 1;
        }else{
            $image['sort'] = 1;
        }
        $res = $templetM->saveImage($image);

        if (!$res){
            $result['message'] = "存储图片失败";
            return json($result);
        }

        $result['status'] = 1;
        $result['message'] = "保存成功";
        return json($result);
    }

    /**
     * @return \think\response\图片处理
     */
    /**
     * @return \think\response\保存缩略图
     */
    public function adminSmallImg($uploadedfile,$nwidth,$nheight)
    {
        $ext1 = pathinfo($uploadedfile,PATHINFO_EXTENSION);
        // Create an Image from it so we can do the resize
        if ($ext1 == 'jpg') {
            $src = imagecreatefromjpeg($uploadedfile);
        }else{
            $src = imagecreatefrompng($uploadedfile);
        }
        // Capture the original size of the uploaded image
        list($width, $height) = getimagesize($uploadedfile);
        // For our purposes, I have resized the image to be
        // 600 pixels wide, and maintain the original aspect
        // ratio. This prevents the image from being "stretched"
        // or "squashed". If you prefer some max width other than
        // 600, simply change the $newwidth variable
        $newwidth = $nwidth;
        $newheight = $nheight;
        $tmp = imagecreatetruecolor($newwidth, $newheight);
        // this line actually does the image resizing, copying from the original
        // image into the $tmp image
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        // now write the resized image to disk. I have assumed that you want the
        // resized, uploaded image file to reside in the ./images subdirectory.
        $filename_arr = explode('.',$uploadedfile);
        $f_count = count($filename_arr);
        $filename = str_replace('.'.$filename_arr[$f_count-1],'_'.$nwidth.$nheight.'.'.$ext1,$uploadedfile);
        if ($ext1 == 'jpg') {
            imagejpeg($tmp, $filename, 90);
        }else{
            imagepng($tmp, $filename, 9);
        }
        imagedestroy($src);
        imagedestroy($tmp);
    }

    /**
     * @return \think\response\重回图片
     */
    public function imgReset($uploadedfile,$nwidth,$nheight)
    {
        $src = imagecreatefromjpeg($uploadedfile);
        list($width, $height) = getimagesize($uploadedfile);

        $newwidth = $nwidth;
        $newheight = $nheight;
        $tmp = imagecreatetruecolor($newwidth, $newheight);

        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        imagejpeg($tmp, $uploadedfile, 90);
        imagedestroy($src);
        imagedestroy($tmp);
    }

    //场景素材编辑保存
    public function upload_text(){
        $result = ['status'=>0,'message'=>"保存成功"];
        $sceneid = input('sceneid',0,'int');
        $scene_name = input('scene_name','','string');
        $text_add = input('text_add','','string');
//        var_exp($text_add,'post');die();
        if (!$sceneid) {
            $result['message'] = "场景id为空";
            return json($result);
        }
        $templetM = new Templet();
        //判断文字是否超出或者不够
        $info = $templetM->getSceneById($sceneid);
        $texts = explode(';',$text_add);
        if ($text_add == ''){
            $post_num = 0;
        }else{
            $post_num = count($texts);
        }
        if ($info['text_num'] != $post_num) {
            $result['message'] = "输入的文字数量与设置不符";
            return json($result);
        }

        $data['sceneid'] = $sceneid;
        $data['text'] = $text_add;
        $data['sort'] = 1;
        $text_info = $templetM->getTextsBySceneId($sceneid);
        if ($text_info) {
            $res = $templetM->updateText($text_info['id'],$data);
        }else if ($text_add != ''){
            $res = $templetM->saveText($data);
        }else{
            $result['status'] = 1;
            $result['message'] = "保存成功";
        }
        if (isset($res)) {
            $result['status'] = 1;
            $result['message'] = "保存成功";
        }
        return json($result);
    }

}