<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019-12-12
 * Time: 20:50
 */

namespace App\Phphub\Core;


interface CreatorListener
{
    public function creatorFailed($errors);
    public function creatorSucceed($model);
}