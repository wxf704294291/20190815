<?php

namespace App\Extensions;

use App\Models\ImService;


class WorkerEvent
{
    
    private $port = '';

    
    private $root_path = '';

    
    private $listen_route = '';

    
    private $listen_ip = '0.0.0.0';

    
    private $context;

    
    public $timer_expire;

    
    public $is_ssl = false;

    
    public function __construct()
    {
        $c = require_once base_path('config/chat.php');
        if (!isset($c['listen_route']) || empty($c['listen_route'])) {
            die(' listen_route need to be configured ');
        }
        if (!isset($c['root_path']) || empty($c['root_path'])) {
            die(' root_path need to be configured ');
        }
        if (!isset($c['port']) || empty($c['port'])) {
            die(' port need to be configured ');
        }

        $this->root_path = $c['root_path'];
        $this->port = $c['port'];
        if (isset($c['listen_route']) && !empty($c['listen_route'])) {
            $this->listen_route = $c['listen_route'];
        }
        if (isset($c['listen_ip']) && !empty($c['listen_ip'])) {
            $this->listen_ip = $c['listen_ip'];
        }
        if (stripos($this->root_path, 'https') === 0) {
            $this->is_ssl = true;
        }
        if ($this->is_ssl) {
            $this->setpem($c['local_cert'], $c['local_pk']);
        }
        $this->timer_expire = 10;
        unset($c);
    }

    
    public function changeServiceStatus()
    {
        ImService::whereRaw('1=1')->update(['chat_status' => 0]);
    }
    
    
    public function setPort($port = null)
    {
        if (!is_null($port)) {
            $this->port = $port;
        }
    }

    
    public function getPort()
    {
        return $this->port;
    }

    
    public function getListenRoute()
    {
        return $this->listen_route;
    }

    
    public function getListenIp()
    {
        return $this->listen_ip;
    }

    
    public function db($data, $path)
    {
        $ch = curl_init($path);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }

    
    public function checkUser($id)
    {
        $this->db(array('id' => $id), $this->dbconnPath);
    }

    
    public function customerLogin($id, $status)
    {
        $url = $this->root_path . 'mobile/index.php?r=chat/admin/changelogin';
        $this->db(array('id' => $id, 'status' => $status), $url);
    }

    
    public function sendmsg($connection, $data, $type = '')
    {
        $connection->send(json_encode($data));
        $url = $this->root_path . 'mobile/index.php?r=chat/admin/storagemessage';
        $data['user_type'] = $connection->userType;
        $data['to_id'] = $connection->uid;
        $this->db($data, $url);
    }

    
    public function savemsg($data)
    {
        $url = $this->root_path . 'mobile/index.php?r=chat/admin/storagemessage';
        $data['to_id'] = empty($data['to_id']) ? 0 : $data['to_id'];
        $this->db($data, $url);
    }

    
    public function sendinfo($connection, $data, $type = '')
    {
        $connection->send(json_encode($data));
    }

    
    public function changemsginfo($data)
    {
        $url = $this->root_path . 'mobile/index.php?r=chat/admin/changemsginfo';

        $this->db($data, $url);
    }

    
    public function getreply($data)
    {
        $url = $this->root_path . 'mobile/index.php?r=chat/admin/getreply';

        return $this->db($data, $url);
    }

    
    public function getcontext()
    {
        return $this->context;
    }

    
    public function closeolddialog()
    {
        $url = $this->root_path . 'mobile/index.php?r=chat/admin/closeolddialog';

        return $this->db(['close_all_dialog' => 'close_all_dialog'], $url);
    }

    
    public function setpem($cert, $pk)
    {
        $this->context = array(
            'ssl' => array(
                
                'local_cert' => $cert, 
                'local_pk' => $pk,
                'verify_peer' => false,
            )
        );
    }
}
