<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * 与模型关联的数据表
     *
     * @var string
     */
    protected $table = 'ferret_images';

    /**
     * 隐藏的属性
     * 隐藏 软删除、创建、更新时间
     *
     * @author daidh
     * @var array
     */
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
}