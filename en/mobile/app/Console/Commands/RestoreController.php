<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class RestoreController extends Command
{
    
    protected $signature = 'app:rectl';

    
    protected $description = 'restore all controller';

    
    public function handle()
    {
        $path = base_path('app/Modules');
        $files = glob($path . '/*/Controllers/*');
        foreach ($files as $file) {
            $name = basename($file, '.php');
            $content = file_get_contents($file);
            $content = str_replace(' extends', 'Controller extends', $content);
            file_put_contents($file, $content);
            rename($file, dirname($file) . '/' . $name . 'Controller.php');
        }
    }
}
