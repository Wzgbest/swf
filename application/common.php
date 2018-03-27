<?php
// +----------------------------------------------------------------------
// | 全影集团 [ 纯粹、极致到零 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.7192.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wuzhenguo <wuzhenguook@gmail.com> <The Best Word!!!>
// +----------------------------------------------------------------------

use think\Db;
use think\Request;
// 应用公共文件

/**
 * 友好的输出值的代码
 * @param $val mixed 要输出代码的值名称
 * @param $valName string 名称标记
 * @param $exit boolean 是否退出程序
 * @param $hr boolean 是否显示分割线
 * @return string 返回字符串内容或直接退出
 * created by blu10ph
 * */
function var_exp($val,$valName='',$exit=false,$hr=true){
    $str = '';
    if($hr){
        $str .= "\r\n<hr/>\r\n";
    }
    if(!empty($valName)){
        $str .= $valName.':';
    }
    $str .= var_export($val, true);
    if($exit == 'return'){
        return $str;
    }else{
        echo $str;
        if($exit!=false){
            exit;
        }
    }
}
/**
 * 时间戳格式化
 *
 * @param $time int
 * @param $format string
 * @return string 完整的时间显示
 * @author huajie <banhuajie@163.com>
 */
function time_format($time = NULL, $format = 'Y-m-d H:i') {
    if (empty ( $time ))
        return '';

    $time = $time === NULL ? time() : intval ( $time );
    return date ( $format, $time );
}
function time_format_html5($time = NULL) {
    if (empty ( $time ))
        return '';
    $time = $time === NULL ? time() : intval ( $time );
    return time_format($time,'Y-m-d')."T".time_format($time,'H:i:s');
}
function minutes_format_html5($time = NULL) {
    if (empty ( $time ))
        return '';
    $time = $time === NULL ? time() : intval ( $time );
    return time_format($time,'Y-m-d')."T".time_format($time,'H:i');
}
function day_format($time = NULL, $format = 'Y-m-d') {
    return time_format ( $time, $format );
}
function hour_format($time = NULL) {
    return time_format ( $time, 'H:i' );
}
function time_offset($time = NULL) {
    if (empty ( $time ))
        return '00:00';

    $mod = $time % 60;
    $min = ($time - $mod) / 60;

    $mod < 10 && $mod = '0' . $mod;
    $min < 10 && $min = '0' . $min;

    return $min . ':' . $mod;
}
function time_diff_day_time($time = NULL,$now_time=NULL) {
    if(!$time){
        $time = 0;
    }
    if(!$now_time){
        $now_time = time();
    }
    $all_minute = round(($now_time-$time)/60);
    $minute = $all_minute%60;
    $hour = floor($minute/60);
    $day = floor($hour/24);
    return $day."天".$hour.":".$minute;
}
/**
 * 返回cooki
 */
function getUserByCooki($code){
    return cookie($code);
}
//设置coonkie
function setCooki($code,$account){
    cookie($code,$account);
}

//生成xml
function _getXML($uid,$model_num,$productid,$info){

    $result = ['status'=>0,'message'=>"生成失败"];
    $res = is_dir(ROOT_PATH."public".DS."xml".DS.$model_num);
    if (!$res){
        mkdir(ROOT_PATH."public".DS."xml".DS.$model_num);
    }
    $xml = '<?xml version="1.0" encoding="utf-8"?>'."\r\n";
    $xml .= '<bcaster>'."\r\n";
    if ($info){
        foreach ($info as $key => $value){
            if (!empty($value['images'])){
                foreach ($value['images'] as $k=>$img){
                    $img = $img['img'];
                }
            }else{
                $img = '';
            }
            if (!empty($value['texts'])) {
                foreach ($value['texts'] as $k=>$tx){
                    $text = $tx['text'];
                }
            }else{
                $text = '';
            }
            $xml .= '<item item_url="'.$img.'" link=""'.' itemtitle="'.$text.'"></item>'."\r\n";
        }
    }
    $xml .= '</bcaster>'."\r\n";
    if ($productid == 0){
        $file = fopen(ROOT_PATH."public".DS."xml".DS.$model_num.DS."ylsp_default.xml","w");
    }else{
        $file = fopen(ROOT_PATH."public".DS."xml".DS.$model_num.DS."ylsp_".$uid."_".$productid.".xml","w");
    }
    fwrite($file,$xml);
    fclose($file);
    if ($file){
        $result['status'] = 1;
        $result['message'] = "生成成功";
    }
    return $result;

}

//生成xml
function _writeXML($uid,$model_num,$productid,$info){
    $result = ['status'=>0,'message'=>"生成失败"];
    $res = is_dir(ROOT_PATH."public".DS."xml".DS.$model_num);
    if (!$res){
        mkdir(ROOT_PATH."public".DS."xml".DS.$model_num);
    }
    $xml = '<?xml version="1.0" encoding="utf-8"?>'."\r\n";
    $xml .= '<xml>'."\r\n";
    if ($info){
        foreach ($info as $key => $value){
            $xml .= '<scene'.$key.'>'."\r\n";
            if ($value['images']){
                foreach ($value['images'] as $k=>$img){
                    $xml .= '<img>'.$img['img'].'</img>'."\r\n";
                }
            }
            if ($value['texts']) {
                foreach ($value['texts'] as $k=>$tx){
                    $xml .= '<text>'.$tx['text'].'</text>'."\r\n";
                }
            }
            $xml .= '</scene'.$key.'>'."\r\n";
        }
    }
    $xml .= '</xml>'."\r\n";
    if ($productid == 0){
        $file = fopen(ROOT_PATH."public".DS."xml".DS.$model_num.DS."ylsp_default.xml","w");
    }else{
        $file = fopen(ROOT_PATH."public".DS."xml".DS.$model_num.DS."ylsp_".$uid."_".$productid.".xml","w");
    }
    fwrite($file,$xml);
    fclose($file);
    if ($file){
        $result['status'] = 1;
        $result['message'] = "生成成功";
    }
    return $result;

}

function _getXMLFor4($uid,$name,$imgs=[],$texts = [],$mvs = []){
    $result = ['status'=>0,'message'=>"生成失败"];
    $num = count($imgs);
    $text_num = count($texts);
    $xml = '<?xml version="1.0" encoding="utf-8"?>'."\r\n";
    $xml .= '<data>'."\r\n".'<channel>'."\r\n";
    if ($imgs){
        foreach ($imgs as $key => $value){
            if ($key <= $text_num-1){
                $text = $texts[$key];
            }else{
                $text = '';
            }
            $xml .= '<item>'."\r\n";
            $xml .= '<link>'.''.'</link>'."\n";
            $xml .= '<image>'.$value['img'].'</image>'."\n";
            $xml .= '<title>'.$text.'</title>'."\n";
            $xml .= '</item>'."\r\n";
        }
    }
    $xml .= '</channel>'."\r\n";
    $xml .= '<config>
        <roundCorner>0</roundCorner>
        <autoPlayTime>4</autoPlayTime>
        <isHeightQuality>false</isHeightQuality>
        <blendMode>normal</blendMode>
        <transDuration>1</transDuration>
        <windowOpen>_blank</windowOpen>
        <btnSetMargin>auto 5 5 auto</btnSetMargin>
        <btnDistance>20</btnDistance>
        <titleBgColor>0xff6600</titleBgColor>
        <titleTextColor>0xffffff</titleTextColor>
        <titleBgAlpha>.75</titleBgAlpha>
        <titleMoveDuration>1</titleMoveDuration>
        <btnAlpha>.7</btnAlpha>
        <btnTextColor>0xffffff</btnTextColor>
        <btnDefaultColor>0x1B3433</btnDefaultColor>
        <btnHoverColor>0xff9900</btnHoverColor>
        <btnFocusColor>0xff6600</btnFocusColor>
        <changImageMode>hover</changImageMode>
        <isShowBtn>true</isShowBtn>
        <isShowTitle>true</isShowTitle>
        <scaleMode>noBorder</scaleMode>
        <transform>bottom</transform>
        <isShowAbout>false</isShowAbout>
        <titleFont>微软雅黑</titleFont>
    </config>'."\r\n";
    $xml .= '</data>';
    $file = fopen(ROOT_PATH."public".DS."xml".DS.$name."_".$uid.".xml","w");
    fwrite($file,$xml);
    fclose($file);
    if ($file){
        $result['status'] = 1;
        $result['message'] = "生成成功";
    }
    return $result;
}

