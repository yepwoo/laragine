<?php

namespace Yepwoo\Laragine\Generators\Payloads\Commands;

use Yepwoo\Laragine\Logic\FileManipulator;
use Yepwoo\Laragine\Logic\StringManipulator;
use Yepwoo\Laragine\Logic\Validations\UnitValidation;
use Yepwoo\Laragine\Processors\Factory;

class MakeUnit extends Base
{
    /**
     * module names (collection)
     *
     * @var
     */
    public $module_collection;

    /**
     * module dir
     *
     * @var
     */
    public $module_dir;

    /**
     * unit names (collection)
     *
     * @var
     */
    public $unit_collection;

    /**
     * init flag
     *
     * @var
     */
    public $init;

    /**
     * run the logic
     *
     * @return void
     */
    public function run()
    {
        $this->unit_collection   = StringManipulator::generate($this->args[0]);
        $this->module_collection = StringManipulator::generate($this->args[1]);
        $this->init              = $this->args[2];
        $this->module_dir        = $this->root_dir . '/' . $this->module_collection['studly'];
        $validation              = new UnitValidation($this->command);
        $validation->checkModule($this->module_dir)
                   ->checkUnit($this->module_dir, $this->unit_collection, $this->init)
                   ->checkAttributes($this->root_dir, $this->module_collection, $this->unit_collection);

        if ($validation->allow_proceed) {
            $this->publishUnit();
        }
    }

    /**
     * publish unit
     *
     * @return void
     */
    protected function publishUnit()
    {
        if($this->init) {
            $this->publishUnitInitCase();
        } else {
            $file_name = $this->unit_collection['studly'] . '.json';
            $data      = $this->root_dir . '/' .  $this->module_collection['studly'] . '/data/' . $file_name;

            $unit_data = [
                'module_dir'        => $this->module_dir,
                'module_collection' => $this->module_collection,
                'unit_collection'   => $this->unit_collection
            ];
            $processors = ['Resource', 'Request', 'Factory', 'Migration'];
            Factory::create($unit_data, $processors);
            $this->command->info(__('laragine::unit.success_init_not_executed'));
        }
    }

    /**
     * publish unit folders in init case
     *
     * @return void
     */
    private function publishUnitInitCase() {
        $source_dir        = __DIR__ . '/../../../Core/Module';
        $destination_dir   = $this->root_dir . '/'. $this->module_collection['studly'];
        $files             = config('laragine.module.unit_main_folders');

        $search = [
            'file'    => ['stub', 'Api', 'Web', 'Unit'],
            'content' => [
                '#UNIT_NAME#',
                '#MODULE_NAME#'
            ]
        ];

        $replace = [
            'file'    => ['php', '', '', $this->unit_collection['studly']],
            'content' => [
                $this->unit_collection['studly'],
                $this->module_collection['studly']
            ]
        ];

        FileManipulator::generate($source_dir, $destination_dir, $files, $search, $replace);
        $this->command->info(__('laragine::unit.success_init_executed'));
    }
}
