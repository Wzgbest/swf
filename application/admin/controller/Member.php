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
use app\admin\model\Member as MemberModel;

class Member extends AdminInitialize
{
    //列表页
    public function member_list(){
        $memberM = new MemberModel();
        $users = $memberM->getUsers();
        $this->assign('users',$users);
        $this->assign("count",count($users));
        return view();
    }
    //添加
    public function member_add(){
        return view();
    }
    //添加
    public function add(){
        $result = ['status'=>0,'message'=>"添加失败"];
        $name = input("username",'','string');
        $telphone = input("mobile",'','string');
        $email = input('email','','string');
        $password = input('password','','string');
        $time = time();
        $level = input('level',0,'int');
        $kt_time = input('kt_time');
        $dq_time = input('dq_time');
        $add_user = input('add_user','','string');
        $com_name = input('com_name','','string');

        $data = [];
        $data['name'] = $name;
        $data['create_time'] = $time;
        $data['telphone'] = $telphone;
        $data['email'] = $email;
        $data['password'] = md5($password);
        $data['level'] = $level;
        if ($kt_time) {
            $data['kt_time'] = strtotime($kt_time);
        }
        if ($dq_time){
            $data['dq_time'] = strtotime($dq_time);
            if (!$kt_time){
                $result['message'] = "请输入开通时间";
                return json($result);
            }
            if (strtotime($dq_time)<strtotime($kt_time)){
                $result['message'] = "请输入正确的起止时间";
                return json($result);
            }
        }
        if ($add_user){
            $data['add_user'] = $add_user;
        }
        if ($com_name){
            $data['com_name'] = $com_name;
        }

        $memberM = new MemberModel();
        $info = $memberM->getUserByPhone(['telphone'=>$telphone]);
//        var_exp($info);die();
        if (!empty($info)) {
            $result['message'] = "手机号已经存在";
            return json($result);
        }
        $info = $memberM->getUserByPhone(['name'=>$name]);
        if (!empty($info)) {
            $result['message'] = "用户名已存在";
            return json($result);
        }
        $id = $memberM->insertUser($data);
        if ($id){
            $result['status'] = 1;
            $result['message'] = "添加成功";
        }
        return json($result);
    }
    public function edit(){
        $result = ['status'=>0,'message'=>"修改失败"];
        $id = input('id',0,'int');
        $is_done = input('is_done',0,'int');
        if (!$id){
            $result['message'] = "编号为空";
            return json($result);
        }
        $memberM = new MemberModel();
        $info = $memberM->getUserById($id);
        if (empty($info)){
            $result['message'] = "不存在此用户";
            return json($result);
        }
        if ($is_done){
            if ($info['status']){
                $flg = $memberM->updateUserById($id,['status'=>0]);
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
                $flg = $memberM->updateUserById($id,['status'=>1]);
                if ($flg){
                    $result['status'] = 1;
                    $result['message'] = "更新成功";
                }
            }
        }

        return json($result);
    }
    //修改密码
    public function change_password(){
        $id = input('id',0,'int');
        if (!$id){
            exception("没有ID");
        }
        $memberM = new MemberModel();
        $user = $memberM->getUserById($id);
        $this->assign('info',$user);
        return view();
    }

    //修改密码
    public function reset_password(){
        $id = input('id',0,'int');
        $result = ['status'=>0,'message'=>"修改失败"];
        $password = input('newpassword','','string');
        $new_password = input('newpassword2','','string');
        if (!$id){
            $result['message'] = "id不能空";
            return json($result);
        }
        if ($password != $new_password){
            $result['message'] = "两次输入的密码不相同";
            return json($result);
        }
        $memberM = new MemberModel();
        $flg = $memberM->updateUserById($id,['password'=>md5($password)]);
        if ($flg){
            $result['status'] = 1;
            $result['message'] = "修改成功";
        }

        return json($result);
//        var_exp($param,"allinfo");
    }
    //删除
    public function delete(){
        $result = ['status'=>0,'message'=>"删除失败"];
        $id = input('id',0,'int');
        if (!$id){
            $result['message'] = "ID为空";
            return json($result);
        }

        $memberM = new MemberModel();
        $res = $memberM->deleteUserById($id);
        if ($res){
            $result['status'] = 1;
            $result['message'] = "删除成功";
        }

        return json($result);
    }

    /**
     * 用户编辑
     */
    public function memberEdit()
    {
        $id = input('id',0,'int');
        $mem = new MemberModel();
        $userinfo = $mem->getUserById($id);

        $this->assign('info',$userinfo);
        return view('member_edit');
    }

    /**
     * 编辑信息
     */
    public function update()
    {
        $id = input('id',0,'int');
        $name = input("username",'','string');
        $telphone = input("mobile",'','string');
        $email = input('email','','string');
        $time = time();
        $level = input('level',0,'int');
        $kt_time = input('kt_time');
        $dq_time = input('dq_time');
        $add_user = input('add_user','','string');
        $com_name = input('com_name','','string');

        $data = [];
        $data['name'] = $name;
        $data['create_time'] = $time;
        $data['telphone'] = $telphone;
        $data['email'] = $email;
        $data['level'] = $level;
        if ($kt_time) {
            $data['kt_time'] = strtotime($kt_time);
        }
        if ($dq_time){
            $data['dq_time'] = strtotime($dq_time);
            if (!$kt_time){
                $result['message'] = "请输入开通时间";
                return json($result);
            }
            if (strtotime($dq_time)<strtotime($kt_time)){
                $result['message'] = "请输入正确的起止时间";
                return json($result);
            }
        }
        if ($add_user){
            $data['add_user'] = $add_user;
        }
        if ($com_name){
            $data['com_name'] = $com_name;
        }

        $mem = new MemberModel();
        $res = $mem->updateUserById($id,$data);
        if ($res){
            $result['status'] = 1;
            $result['message'] = "跟新成功";
        }
        return json($result);
    }
}