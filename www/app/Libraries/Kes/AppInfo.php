<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30.04.2019
 * Time: 11:58
 */

namespace App\Libraries\Kes;

use App\Libraries\Kes\Models\AppInfoDataItemModel;
use App\Libraries\Kes\Models\AppInfoModel;

class AppInfo
{
    protected $program = '/opt/kaspersky/kesl/bin/kesl-control --app-info';

    final public function execute(): AppInfoModel
    {
        $output = $this->run();
        $data = $this->parse($output);
        return (new AppInfoModel())
            ->setData($data);
    }

    private function run(): array
    {
        exec($this->program,$output);
        return $output;
    }

    private function parse(array $output): array
    {
        $result = [];
        foreach ($output as $row){
            /** @noinspection NotOptimalRegularExpressionsInspection */
            preg_match('/(.*): (.*)/i',$row,$matches);
            $name = trim(@$matches[1]);
            $value = trim(@$matches[2]);
            if (!$name && !$value){
                continue;
            }
            $result[] = (new AppInfoDataItemModel())
                ->setParam($name)
                ->setValue($value);
        }
        return $result;
    }
}