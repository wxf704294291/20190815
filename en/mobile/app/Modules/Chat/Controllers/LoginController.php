<?php

namespace App\Modules\Chat\Controllers;

use Think\Verify;
use App\Modules\Base\Controllers\FrontendController;

class LoginController extends FrontendController
{
    public function _initialize()
    {
        session('[start]');
    }

    
    public function actionIndex()
    {
        if (is_mobile_browser() && IS_GET) {
            $this->redirect(url('chat/adminp/mobile'));
        }
        
        if (IS_POST) {
            $input = $this->checkSignInData();

            $username = $input['username'];
            $password = $input['password'];
            $remember = $input['remember'];

            $ec_salt = M('admin_user')->field('ec_salt')->where(['user_name' => $username])->find();
            $ec_salt = $ec_salt['ec_salt'];

            $field = 'user_id, user_name, password, last_login, action_list, last_login,suppliers_id,ec_salt';
            if (!empty($ec_salt)) {
                $row = M('admin_user')->field($field)->where(['user_name' => $username, 'password' => md5(md5($password) . $ec_salt)])->find();
            } else {
                $row = M('admin_user')->field($field)->where(['user_name' => $username, 'password' => md5($password)])->find();
            }

            
            if ($row) {
                
                $service = M('im_service')->where(['user_id' => $row['user_id'], 'status' => 1])->find();
                



                if (empty($service) || empty($service['id'])) {
                    $this->ajaxReturn(['code' => 1, 'msg' => '该账号没有客服权限']);
                }

                $this->set_kefu_session($row['user_id'], $service['id'], $service['nick_name'], $service['login_time']);

                
                if ($remember === '1') {
                    $time = time() + 3600 * 24 * 7;
                    setcookie('ECSCP[kefu_id]', $service['id'], $time);
                    setcookie('ECSCP[kefu_token]', md5($row['password'] . C('hash_code')), $time);
                }

                
                $result = ['code' => 0, 'msg' => '登录成功'];
                if (is_mobile_browser()) {

                    
                    $result['token'] = $this->tokenEncode([
                        'id' => strtoupper(bin2hex(base64_encode($service['id']))),
                        'expire' => local_gettime() + 3600,   
                        'hash' => md5(C('DB_HOST') . C('DB_USER') . C('DB_PWD'). C('DB_NAME'))
                    ]);
                }

                $this->ajaxReturn($result);
            } else {
                $this->ajaxReturn(['code' => 1, 'msg' => '用户名或密码错误']);
            }
        }
        $this->display('admin.login');
    }

    
    public function actionLogout()
    {
        $id = (int)$_SESSION['kefu_id'];   

        $data['chat_status'] = 0;   
        M('im_service')->where('id=' . $id . "  AND status = 1")->save($data);

        $_SESSION['kefu_admin_id'] = '';
        $_SESSION['kefu_id'] = '';
        $_SESSION['kefu_name'] = '';
        $_SESSION['last_check'] = ''; 

        
        setcookie('ECSCP[kefu_id]', '', time() - 1);
        setcookie('ECSCP[kefu_token]', '', time() - 1);

        $this->redirect('index');
    }

    
    public function actionCaptcha()
    {
        $params = array(
            'fontSize' => 14, 
            'length' => 4, 
            'useNoise' => false, 
            'fontttf' => '4.ttf',
            'bg' => array(255, 255, 255)
        );
        $verify = new Verify($params);
        $verify->entry();
    }

    
    private function checkSignInData()
    {
        $username = I('username', '');
        $password = I('password', '');
        $catpcha = I('catpcha', '');
        $remember = I('remember', '');

        $result = array('code' => 0, 'msg' => '');
        
        if (empty($username)) {
            $result['code'] = 1;
            $result['msg'] = '用户名为空';
            $this->ajaxReturn($result);
        }

        
        if (empty($password)) {
            $result['code'] = 1;
            $result['msg'] = '密码为空';
            $this->ajaxReturn($result);
        }


        
        if (!is_mobile_browser()) {
            
            if (empty($catpcha)) {
                $result['code'] = 1;
                $result['msg'] = '验证码为空';
                $this->ajaxReturn($result);
            }

            
            $verify = new Verify();
            $res = $verify->check($catpcha);
            if (!$res) {
                $result['code'] = 1;
                $result['msg'] = '验证码错误';
                $this->ajaxReturn($result);
            }
        }

        return [
            'username' => $username,
            'password' => $password,
            'remember' => $remember
        ];
    }

    
    private function set_kefu_session($admin_id, $user_id, $username, $last_time)
    {
        $_SESSION['kefu_admin_id'] = $admin_id;
        $_SESSION['kefu_id'] = $user_id;
        $_SESSION['kefu_name'] = $username;
        $_SESSION['last_check'] = $last_time; 
    }

    
    private function tokenEncode($data)
    {
        $token = serialize(base64_encode(json_encode($data)));
        return $token;
    }
}
