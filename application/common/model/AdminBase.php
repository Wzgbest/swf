<?php
// +----------------------------------------------------------------------
// | 全影集团 [ 纯粹、极致到零 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.7192.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wuzhenguo <wuzhenguook@gmail.com> <The Best Word!!!>
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Db;

class AdminBase
{
    protected $model;
    public $table;
    protected $dbprefix;

    /**
     * 数据库分库访问基类
     * @param null $corp_id
     * created by messhair
     */
    public function __construct()
    {
        $this->model = Db::connect();
        $this->dbprefix = config('database.prefix');
    }
}