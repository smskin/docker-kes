<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2019
 * Time: 11:36
 */

namespace App\Libraries\Kes;

use App\Exceptions\ValidationException;
use App\Libraries\Kes\Models\ScanFileDataItemModel;
use App\Libraries\Kes\Models\ScanFileModel;

class ScanFile
{
    public const RowScannedObjects = 0;
    public const RowTotalDeletedObjects = 1;
    public const RowInfectedObjectsAndOtherObjects = 2;
    public const RowDisinfectedObjects = 3;
    public const RowMovedToStorage = 4;
    public const RowRemovedObjects = 5;
    public const RowNotDisinfectedObjects = 6;
    public const RowScanErrors = 7;
    public const RowPasswordProtectedObjects = 8;
    public const RowSkipped = 9;

    /**
     * @var string
     */
    protected $path;
    protected $program = '/opt/kaspersky/kesl/bin/kesl-control --scan-file %s';

    /**
     * @return ScanFileModel
     * @throws ValidationException
     */
    final public function execute(): ScanFileModel
    {
        if (!file_exists($this->path)){
            throw new ValidationException('File not exists');
        }

        $output = $this->run();
        $data = $this->parse($output);

        return (new ScanFileModel())
            ->setIsInfected($this->isInfected($data))
            ->setData($data);
    }

    private function run(): array
    {
        exec(sprintf($this->program,$this->path),$output);
        return $output;
    }

    private function parse(array $output): array
    {
        $result = [];
        foreach ($output as $row){
            $params = explode(':',$row);
            $result[] = (new ScanFileDataItemModel())
                ->setParam(trim($params[0]))
                ->setCount((int) $params[1]);
        }
        return $result;
    }

    private function isInfected(array $data): bool
    {
        return $data[self::RowInfectedObjectsAndOtherObjects]->count > 0;
    }

    /**
     * @param string $path
     * @return ScanFile
     */
    final public function setPath(string $path): ScanFile
    {
        $this->path = $path;
        return $this;
    }
}