<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2019
 * Time: 12:13
 */

namespace App\Requests\Kes;

use App\Libraries\Kes\AppInfo;
use App\Libraries\Kes\Models\AppInfoModel;

class AppInfoRequest
{
    final public function execute(): AppInfoModel
    {
        return (new AppInfo())
            ->execute();
    }
}