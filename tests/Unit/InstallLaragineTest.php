<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\TestCase;

class InstallLaragineTest extends TestCase
{
    // make sure we're starting from a clean state
    function test_the_install_command_create_core_folder() {
//        Artisan::call("laragine:install");

        $this->assertTrue(base_path('core'));
//        if(!File::exists(base_path().'/core')) {
//            // path does not exist
//            echo json_encode("exist");
//            exit;
    }

}
