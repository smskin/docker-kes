<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2019
 * Time: 14:28
 */

namespace App\Libraries\Kes\Models;

/**
 * Class AppInfoModel
 *
 * @OA\Schema(
 *     title="AppInfoModel",
 *     description="App info model",
 * )
 */
class AppInfoModel extends \stdClass
{
    /**
     * @OA\Property(
     *     title="data",
     *     description="Antivirus response",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/AppInfoDataItemModel")
     * )
     *
     * @var AppInfoDataItemModel[]
     */
    public $data;

    /**
     * @param AppInfoDataItemModel[] $data
     * @return AppInfoModel
     */
    final public function setData(array $data): AppInfoModel
    {
        $this->data = $data;
        return $this;
    }
}