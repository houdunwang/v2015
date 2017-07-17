<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    //不允许批量添加的字段
    protected $guarded = [];
}
