<?php
/**
 * Created by PhpStorm.
 * User: QYIT
 * Date: 2018/1/20
 * Time: 14:09
 */

namespace app\custom\controller;


use app\common\controller\CustomInitialize;
use app\custom\model\Templet;
use app\custom\model\Save as SaveModel;
use think\Db;

class Owntemplate extends CustomInitialize
{
    public function index(){
        $templetM = new Templet();
        $templet_list = $templetM->getUserTemplate($this->c_uid);
//        var_exp($templet_list,"sql");die();
        $this->assign('list',$templet_list);
        $this->assign('count',count($templet_list));
        return view('my_template');
    }
    //删除
    public function delete(){
        $result = ['status'=>0,'message'=>"删除失败"];
        $ids = input('ids/a');
        if (empty($ids)){
            $result['message'] = "无法识别模板id";
            return json($result);
        }
        $templateM = new Templet();
        $res = $templateM->deleteUserTemplate($ids);
        if ($res){
            $result['status'] = 1;
            $result['message'] = "删除成功";
        }

        return json($result);
    }

    //展示
    public function my_template_show()
    {
        $id = input('id', 0, 'int');

        $templateM = new Templet();
        $templateInfo = $templateM->getProductById($id);
        //判断是否存在该文件，为了以防修改后文件不修改所以每次都要重新写入
//        $res = is_file(ROOT_PATH . "public" . DS . "xml" . DS . $templateInfo['model_num'] . DS . "ylsp_".$this->c_uid."_".$id.".xml");
//        if (!$res) {
        //生成xml
        $all_info = $templateM->getScenesAndImagesAndTextsByModelId($templateInfo['modelid'], $id);
        _getXML($this->c_uid, $templateInfo['model_num'], $id, $all_info);
//        }
        $templateInfo['xml_url'] = "/xml/" . $templateInfo['model_num'] . "/ylsp_" . $this->c_uid . "_" . $id . ".xml";
        $this->assign('template', $templateInfo);

        return view();
    }

    //编辑
    public function my_template_eidt()
    {
        $id = input('id', 0, 'int');
        $templateM = new Templet();
        $product_info = $templateM->getProductById($id);
        $scenes = $templateM->getScenesAndImagesAndTextsByModelId($product_info['modelid'], $id);
        $this->assign('scenes', $scenes);
        return view();
    }

    //上线下线跟新方法
    public function edit_isline(){
        $result = ['status'=>0,'message'=>"修改失败"];
        $id = input('id',0,'int');
        $is_done = input('is_done',0,'int');
        if (!$id){
            $result['message'] = "编号为空";
            return json($result);
        }
        $templateM = new Templet();
        $info = $templateM->getProductById($id);
//        var_exp($info);die();
        if ($is_done){
            if ($info['status']){
                $flg = $templateM->updateProductById($id,['status'=>0]);
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
                $flg = $templateM->updateProductById($id,['status'=>1]);
                if ($flg){
                    $result['status'] = 1;
                    $result['message'] = "更新成功";
                }
            }
        }

        return json($result);
    }

}