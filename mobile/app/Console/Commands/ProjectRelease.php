<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;


class ProjectRelease extends Command
{
    
    protected $signature = 'app:lite {type=free}'; 

    
    protected $description = 'release the project';

    
    private $base_path = '';

    
    public function handle()
    {
        $type = $this->argument('type');
        $this->base_path = base_path();

        
        $free = [
            'app/Plugins/connect/facebook.php',
            'app/Plugins/payment/paypal.php',
            'resources/docs/*',
            'resources/electron/*',
            'resources/program/*',
            'resources/vuejs/*',
            'tests/*',
            '.bowerrc',
            '.gitattributes',
            '.gitignore',
            'bower.json',
            'CHANGELOG.md',
            'composer.json',
            'package.json',
            'README.md',
            'webpack.mix.js',
        ];

        
        $basic = [
            'app/Plugins/Wechat/*',
            'app/Plugins/payment/wxpay.php',
            'app/Extensions/WxHongbao.php',
            'app/Extensions/Wxapp.php',
            'database/*',
            'public/css/console_wechat.css',
            'public/css/console_wechat_seller.css',
            'public/assets/wechat/*',
            'public/fonts/wechat/*',
            'public/css/wechat/*',
            'public/css/wechat.css',
            'public/css/wechat.min.css',
            'artisan',
            'respond_wxh5.php',
            'resources/views/respond/index.wxh5.html*',
        ];

        
        $advanced = [
            'app/Console/Commands/CustomerService.php',
            'app/Modules/Chat/Controllers/Admin.php',
            'app/Modules/Chat/Controllers/Index.php',
            'app/Modules/Chat/Controllers/Login.php',
            'app/Modules/Chat/Models/Kefu.php',
            'app/Modules/Chat/Views/*',
            'app/Modules/Drp/*',
            'app/Modules/Team/*',
            'app/Modules/Touchim/*',
            'app/Extensions/WorkerEvent.php',
            'public/css/console_team.css',
            'public/css/team.css',
            'public/css/team.min.css',
            'resources/views/touchim/*',
        ];

        if ($type == 'free') {
            $allfile = array_merge($free, $basic, $advanced);
        } elseif ($type == 'basic') {
            $allfile = array_merge($free, $advanced);
        } else {
            $allfile = $free;
        }


        foreach ($allfile as $vo) {
            $this->delete($vo);
        }


        $docs_file = glob($this->base_path . '/app/Modules/*/Docs');
        foreach ($docs_file as $vo) {
            $this->del_dir($vo);
        }
    }


    private function delete($file = '')
    {
        $suffix = substr($file, -2);
        if ($suffix == '/*') {
            $this->del_dir($this->base_path . '/' . substr($file, 0, -1));
        } elseif ($suffix == '_*') {
            $this->del_pre($this->base_path . '/' . substr($file, 0, -1));
        } else {
            @unlink($this->base_path . '/' . $file);
        }
    }


    private function del_dir($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }
        $handle = opendir($dir);
        while (($file = readdir($handle)) !== false) {
            if ($file != "." && $file != "..") {
                is_dir("$dir/$file") ? $this->del_dir("$dir/$file") : @unlink("$dir/$file");
            }
        }
        if (readdir($handle) == false) {
            closedir($handle);
            @rmdir($dir);
        }
    }


    private function del_pre($files)
    {
        $dir = dirname($files);
        
        $handle = opendir($dir);
        
        while (($file = readdir($handle)) !== false) {
            if ($file != "." && $file != "..") {
                $prefix = basename($files);
                $FP = stripos($file, $prefix);
                if ($FP === 0) {
                    @unlink($dir . '/' . $file);
                }
            }
        }
        closedir($handle);
    }
}
