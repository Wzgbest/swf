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
 * Date: 2018/3/1
 * Time: 14:30
 */

namespace app\api\controller;

use app\admin\model\Templet;

class Api
{
    public $file_arr = [];
    /**
     * nodejs 接口
     */
    public function getProgram(){
        $result = ['status'=>0,'message'=>"No Program"];
        //查询用户产品表是否有可以渲染的视频
        $tem = new Templet();
        $info = $tem->getProduct();
//        var_exp($info,'info');
        if (empty($info)) {
            return json($result);
        }
        //如果有可以渲染的视频查询所有的素材
        $source = $tem->getScenesAndImagesAndTextsByModelId($info['modelid'],$info['id']);
        $music = $tem->getBgm($info['id']);
        $assets = [];
        $title = '';

        //添加图片素材
        $i = 1;
        foreach ($source as $key=>$value) {
            foreach ($value['images'] as $k=>$v) {
                $data1['type'] = "image";
                $img_ex = pathinfo($v['img'],PATHINFO_EXTENSION);
                $data1['name'] = "photo".$i.".".$img_ex;
                $data1['src'] = "http://".$_SERVER['HTTP_HOST'].$v['img'];
                $data1['filters'] = [['name'=>'cover','params'=>[intval($v['width']),intval($v['height'])]]];
                array_push($assets,$data1);
                ++$i;
            }
            foreach ($value['texts'] as $k=>$v) {
                $title .= "'".$v['text']."',";
            }
        }

        //添加文字素材
        if (!empty($title)) {
            $js = "var title = [" . $title . "];" . "\r\n";
            $js .= "function getTrack(num) {" . "\r\n";
            $js .= "return title[num];" . "\n";
            $js .= "}";
            if (!is_dir(ROOT_PATH."public".DS."js".DS.$info['model_num'])) {
                mkdir(ROOT_PATH."public".DS."js".DS.$info['model_num']);
            }
            $file = fopen(ROOT_PATH."public".DS."js".DS.$info['model_num'].DS."quanying_".$info['userid']."_".$info['id'].".js","w");
            $flg = fwrite($file,$js);
            if ($flg) {
                $data['type'] = "script";
                $data['name'] = "data.js";
                $data['src'] = "http://".$_SERVER['HTTP_HOST']."/js/".$info['model_num']."/quanying_".$info['userid']."_".$info['id'].".js";
                array_push($assets,$data);
            }
            fclose($file);
        }

        //添加模板和视频素材
        $dirArray = [];
        if (is_dir(ROOT_PATH."public".DS."model".DS.$info['model_num'])) {
            $dirArray = $this->getPHPFile(ROOT_PATH."public".DS."model".DS.$info['model_num']);
        }
        foreach ($dirArray as $dir) {
            $extention = pathinfo($dir,PATHINFO_EXTENSION);
            $dirname = pathinfo($dir,PATHINFO_DIRNAME);
            if ($extention == 'mp3' && !empty($music)){
                continue;
            }
            if ($extention == 'mp4' || $extention == 'mov' || $extention == 'avi' || $extention == 'mp3') {
                $data['type'] = "audio";
            }
            if ($extention == 'aepx') {
                $data['type'] = "project";
            }
            if ($extention == 'jpg' || $extention == "png" || $extention == "ai" || $extention == "psd" || $extention == 'JPG' || $extention == 'PNG' || $extention == "AI" || $extention == "PSD") {
                $data['type'] = "image";
            }
            $data['name'] = pathinfo($dir,PATHINFO_BASENAME);
//            $data['src'] = "http://".$_SERVER['HTTP_HOST']."/model/".$info['model_num']."/".$data['name'];
            $data['src'] = str_replace(ROOT_PATH."public".DS."model".DS.$info['model_num'],"http://".$_SERVER['HTTP_HOST']."/model/".$info['model_num'],$dirname)."/".$data['name'];
            array_push($assets,$data);
        }

        //背景音乐
        if (!empty($music)){
            $data['type'] = "audio";
            $data['name'] = "audio.mp3";
            $data['src'] = "http://".$_SERVER['HTTP_HOST'].$music['msc'];
            array_push($assets,$data);
        }

        //获取帧数
        $time = explode('分',$info['time']);
        $duration = ($time[0] * 60 + str_replace('秒','',$time[1])) * 25;

        $result['data']['assets'] = $assets;
        $result['data']['duration'] = $duration;
        $result['data']['product_id'] = $info['id'];
        $result['status'] = 1;
        $result['message'] = "SUCCESS";
//        var_exp($result);die();
        return json($result);
    }
    /**
     * 完成视频渲染之后跟新数据库
     */
    public function updateProgram() {
        $id = input('id',0,'int');
//        $av_id = input('av_id','','string');
        $av_link = input('av_link','','string');
        $error = input('error',0,'int');
        $tem = new Templet();
        if ($error)
        {
            $data['status'] = 4;
            $res = $tem->updateProductById($id,$data);
            return json(['message'=>'RENDER ERROR','status'=>1]);
        }else{
            //        return json($id);
            if (!$id) {
                return json(['message'=>"NO Id",'statas'=>0]);
            }

//            $data['av_id'] = $av_id;
            $data['av_link'] = $av_link;
            $data['status'] = 3;
            $data['update_time'] = time();
            $res = $tem->updateProductById($id,$data);
//        return $res;
            if (!$res) {
                return json(['message'=>'UPDATE ERROR','status'=>0]);
            }

            return json(['message'=>'UPDATE SUCCESS','status'=>1,'error'=>$error]);
        }
    }

    /**
     * @return \think\response\Json
     * @throws \think\Exception
     * @throws \think\exception 添加到队列更新
     */
    public function addQueue()
    {
        $id = input('id',0,'int');
        $uid = input('uid','','string');

        $tem = new Templet();
        $data['status'] = 5;
        $data['av_id'] = $uid;
        $data['update_time'] = time();
        $res = $tem->updateProductById($id,$data);
        if (!$res) {
            return json(['message'=>'UPDATE ERROR','status'=>0]);
        }

        return json(['message'=>'UPDATE SUCCESS','status'=>1]);
    }


    /**
     * 获取目录下的所有文件
     */
    function getPHPFile($path){
        $dir = opendir($path);
        while(($d = readdir($dir)) == true){
            //不让.和..出现在读取出的列表里
            if($d == '.' || $d == '..'){
                continue;
            }
            //判断如果是目录，继续读取
            if(is_dir($path.'/'.$d)){
                $this->getPHPFile($path.'/'.$d);
            }else{
                $this->file_arr[] = "{$path}/{$d}";
            }
        }
        return $this->file_arr;
    }
}