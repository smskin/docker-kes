<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2019
 * Time: 14:30
 */

namespace App\Libraries\Kes\Models;

/**
 * Class ScanFileDataItemModel
 *
 * @OA\Schema(
 *     title="ScanFileDataItemModel",
 *     description="Scan file data item model",
 * )
 */
class ScanFileDataItemModel
{
    /**
     * @OA\Property(
     *     title="param",
     *     description="param",
     *     type="string"
     * )
     *
     * @var string
     */
    public $param;

    /**
     * @OA\Property(
     *     title="count",
     *     description="count",
     *     type="integer"
     * )
     *
     * @var int
     */
    public $count;

    /**
     * @param string $param
     * @return ScanFileDataItemModel
     */
    final public function setParam(string $param): ScanFileDataItemModel
    {
        $this->param = $param;
        return $this;
    }

    /**
     * @param int $count
     * @return ScanFileDataItemModel
     */
    final public function setCount(int $count): ScanFileDataItemModel
    {
        $this->count = $count;
        return $this;
    }
}