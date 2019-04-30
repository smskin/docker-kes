<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2019
 * Time: 14:30
 */

namespace App\Libraries\Kes\Models;

/**
 * Class ScanFileModel
 *
 * @OA\Schema(
 *     title="ScanFileModel",
 *     description="Scan file model",
 * )
 */
class ScanFileModel extends \stdClass
{
    /**
     * @OA\Property(
     *     title="isInfected",
     *     description="Status of object",
     *     type="boolean"
     * )
     *
     * @var bool
     */
    public $isInfected;

    /**
     * @OA\Property(
     *     title="data",
     *     description="Antivirus response",
     *     type="array",
     *     @OA\Items(ref="#/components/schemas/ScanFileDataItemModel")
     * )
     *
     * @var ScanFileDataItemModel[]
     */
    public $data;

    /**
     * @param bool $isInfected
     * @return ScanFileModel
     */
    final public function setIsInfected(bool $isInfected): ScanFileModel
    {
        $this->isInfected = $isInfected;
        return $this;
    }

    /**
     * @param ScanFileDataItemModel[] $data
     * @return ScanFileModel
     */
    final public function setData(array $data): ScanFileModel
    {
        $this->data = $data;
        return $this;
    }
}