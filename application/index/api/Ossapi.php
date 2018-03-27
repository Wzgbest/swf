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
 * Date: 2018/3/21
 * Time: 17:20
 */

namespace app\index\api;

use \DateTime;

class Ossapi
{
    private $id = 'LTAIfjdMZsrYEEmY';
    private $key = 'rTKYFTnczjqd3I2t6UlBDPXQCG7jcD';
    private $host = 'http://spxm.oss-cn-beijing.aliyuncs.com';
    /**
     * @return \think\response\Json 设置上传的参数
     */
    public function webUpload()
    {
        $id= $this->id;
        $key= $this->key;
        $host = $this->host;

        $now = time();
        $expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = $this->gmt_iso8601($end);

        $dir = 'spxm/';

        //最大文件大小.用户可以自己设置
        $condition = array(0=>'content-length-range', 1=>0, 2=>1048576000);
        $conditions[] = $condition;

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $start = array(0=>'starts-with', 1=>'$key', 2=>$dir);
        $conditions[] = $start;


        $arr = array('expiration'=>$expiration,'conditions'=>$conditions);
        //echo json_encode($arr);
        //return;
        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $string_to_sign = $base64_policy;
        $signature = base64_encode(hash_hmac('sha1', $string_to_sign, $key, true));

        $response = array();
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;

        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;
//        echo json_encode($response);
//        return json(['host'=>'/index/member/saveImage/img_id/','dir'=>'/images/']);
        return json_encode($response);
    }

    public function gmt_iso8601($time) {
        $dtStr = date("c", $time);
        $mydatetime = new DateTime($dtStr);
        $expiration = $mydatetime->format(DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);
        return $expiration."Z";
    }
}