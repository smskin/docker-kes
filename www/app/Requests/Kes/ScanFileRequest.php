<?php

/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2019
 * Time: 12:13
 */

namespace App\Requests\Kes;

use App\Exceptions\ValidationException;
use App\Libraries\Kes\Models\ScanFileModel;
use App\Libraries\Kes\ScanFile;

class ScanFileRequest
{
    /**
     * @var array
     */
    protected $file;

    /**
     * @return ScanFileModel
     * @throws ValidationException
     */
    final public function execute(): ScanFileModel
    {
        $this->fillInput();
        $path = $this->file['tmp_name'];
        $result =(new ScanFile())
            ->setPath($path)
            ->execute();
        @unlink($path);
        return $result;
    }

    /**
     * @throws ValidationException
     */
    private function fillInput(): void
    {
        /** @noinspection GlobalVariableUsageInspection */
        if (!array_key_exists('file',$_FILES)){
            throw new ValidationException('File in required field');
        }
        /** @noinspection GlobalVariableUsageInspection */
        $this->file = $_FILES['file'];
    }
}