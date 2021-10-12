<?php

namespace Yepwoo\Laragine\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Yepwoo\Laragine\Tests\TestCase;

class InstallLaragineTest extends TestCase
{
    // make sure we're starting from a clean state
    function test_the_install_command_create_core_folder() {

        // make sure we're starting from a clean state
        if(File::exists(base_path('core'))) {
            File::deleteDirectory(base_path('core'));
        }

        Artisan::call("laragine:install");
        $this->assertTrue(File::exists(base_path('core')));
    }

    function test_when_a_core_folder_is_exist_users_can_choose_to_override_it() {

        // If core folder doesn't exist, run the command to create it
        if(!File::exists(base_path('core'))) {
            Artisan::call("laragine:install");
        } 

        // We have already a 'core' folder, let's run the command again
        $command = $this->artisan('laragine:install');

        // We expect a warning that our configuration file exists
        $command->expectsConfirmation(
            "The core folder already exists, do you want to override it?", 'yes'
        );
        
        // We should see a message that our file was not overwritten
        $command->expectsOutput("The installation done successfully!");
    }

    function test_when_a_core_folder_is_exist_users_can_choose_to_not_override_it() {

        // If core folder doesn't exist, run the command to create it
        if(!File::exists(base_path('core'))) {
            Artisan::call("laragine:install");
        } 

        // We have already a 'core' folder, let's run the command again
        $command = $this->artisan('laragine:install');

        // We expect a warning that our configuration file exists
        $command->expectsConfirmation(
            "The core folder already exists, do you want to override it?", 'no'
        );
        
        // We should see a message that our file was not overwritten
        $command->expectsOutput("Existing core folder was not overwritten");
    }

}
