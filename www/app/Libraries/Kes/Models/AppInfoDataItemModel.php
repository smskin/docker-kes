<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2019
 * Time: 14:29
 */

namespace App\Libraries\Kes\Models;

/**
 * Class AppInfoDataItemModel
 *
 * @OA\Schema(
 *     title="AppInfoDataItemModel",
 *     description="App info data item model",
 * )
 */
class AppInfoDataItemModel
{
    /**
     * @OA\Property(
     *     title="param",
     *     description="Parameter",
     *     type="string"
     * )
     *
     * @var string
     */
    public $param;

    /**
     * @OA\Property(
     *     title="value",
     *     description="Value",
     *     type="string"
     * )
     *
     * @var string
     */
    public $value;

    /**
     * @param string $param
     * @return AppInfoDataItemModel
     */
    final public function setParam(string $param): AppInfoDataItemModel
    {
        $this->param = $param;
        return $this;
    }

    /**
     * @param string $value
     * @return AppInfoDataItemModel
     */
    final public function setValue(string $value): AppInfoDataItemModel
    {
        $this->value = $value;
        return $this;
    }
}