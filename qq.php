<?php
/****
*   文件作用 使用QQ登录ECshop
*   申请APPID的地址： http://connect.opensns.qq.com/apply
*/
define('IN_ECS', true);
require(dirname(__FILE__) . '/includes/init.php');
include_once(ROOT_PATH . 'includes/lib_transaction.php');
include_once(ROOT_PATH . 'includes/lib_passport.php');

function check_user($username){

    $sql = "SELECT user_id FROM " . $GLOBALS['ecs']->table("users"). " WHERE user_name='$username'";
    $row = $GLOBALS['db']->getRow($sql);
    if (!empty($row)){
        return true;
    }else{
        return false;
    }
}


$qq_oauth_config = array(
    'oauth_consumer_key'=>'你的ID', // 这里输入在QQ网站申请到的APP ID
    'oauth_consumer_secret'=>'你的KEY', //这里输入在QQ网站申请到的APP KEY
    'oauth_callback'=>"http://www.nnjdgo.com/qq.php?act=reg", // 这里要把demo1.nnjdgo.com 修改为你的域名
    'oauth_request_token_url'=>"http://openapi.qzone.qq.com/oauth/qzoneoauth_request_token",
    'oauth_authorize_url'=>'http://openapi.qzone.qq.com/oauth/qzoneoauth_authorize',
    'oauth_request_access_token_url'=>'http://openapi.qzone.qq.com/oauth/qzoneoauth_access_token',
    'user_info_url' => 'http://openapi.qzone.qq.com/user/get_user_info',
);

$action = isset($_GET['act']) ? $_GET['act'] : '';
$qq = new qq_oauth($qq_oauth_config);

switch($action){
    //用户登录 Step1：请求临时token
    case 'login':
        $token = $qq->oauth_request_token();
        $_SESSION['oauth_token_secret'] = $token['oauth_token_secret'];
        $qq->authorize($token['oauth_token']);
    break;
    //Step4：Qzone引导用户跳转到第三方应用
    case 'reg':
        $qq->register_user();
        $access_token = $qq->request_access_token();
        if($token = $qq->save_access_token($access_token)){
            $_SESSION['oauth_token'] = $token['oauth_token'];
            $_SESSION['oauth_token_secret'] = $token['oauth_token_secret'];
            $_SESSION['openid'] = $token['openid'];
            header('Content-Type: text/html; charset=utf-8');
            $user_info = json_decode($qq->get_user_info());
            $nickname = $user_info->nickname;//通过api返回的qq昵称

            if($user_info->ret!=0){
                exit("登录发生错误".$user_info->msg);
            } else {
               //$username='qq'.$_SESSION['openid'];
               $username = ''.$nickname ;
			   $password=time();//随便弄个密码
			   $email=$_SESSION['openid'].'@qq.com';//没有返回邮箱
			   $back_act ="user.php";
       /* 检测用户名 */
       if (check_user($username)!==false){//账号存在直接完成登录
		$GLOBALS['user']->set_session($username);
		$GLOBALS['user']->set_cookie($username);
		header("Location: user.php\n");
		exit;
       }else{//账号不存在就完成注册并自动登录
		$reg_date = time();
		$password =md5($password);
		$GLOBALS['db']->query('INSERT INTO ' . $GLOBALS['ecs']->table("users") . "(`email`, `user_name`, `password`, `reg_time`, `last_login`, `last_ip`) VALUES ('$email', '$username', '$password', '$reg_date', '$reg_date', '$ip')");//账号不存在 就写入数据库 并登陆
		$GLOBALS['user']->set_session($username);
		$GLOBALS['user']->set_cookie($username);
		header("Location: user.php\n");
		exit;
       }
       //$user_info->figureurl'
   		}
	}
    break;
    default :
}
class qq_oauth{
    private $config;
    function __construct($config){
        $this->config = $config;
    }
    function C($name){
        return isset($this->config[$name]) ?  $this->config[$name] : FALSE;
    }
    function build_request_uri($url,$params=array(),$oauth_token_secret=''){
        $oauth_consumer_key = $this->C('oauth_consumer_key');
        $oauth_consumer_secret = $this->C('oauth_consumer_secret');

        $params = array_merge(array(
            'oauth_version'=>'1.0',
            'oauth_signature_method'=>'HMAC-SHA1',
            'oauth_timestamp'=>time(),
            'oauth_nonce'=>rand(1000,99999999),
            'oauth_consumer_key'=>$oauth_consumer_key,
        ),$params);
        $encode_params = $params;
        ksort($encode_params);
        $oauth_signature = 'GET&'.urlencode($url).'&'.urlencode(http_build_query($encode_params));
        $oauth_signature = base64_encode(hash_hmac('sha1',$oauth_signature,$oauth_consumer_secret.'&'.$oauth_token_secret,true));
        $params['oauth_signature'] = $oauth_signature;
        return $url.'?'.http_build_query($params);
    }
    function check_callback(){
        if(isset($_GET['oauth_token']))
            if(isset($_GET['openid']))
                if(isset($_GET['oauth_signature']))
                    if(isset($_GET['timestamp']))
                        if(isset($_GET['oauth_vericode']))
                            return true;
        return false;
    }

    function get_contents($url){
        $curl = curl_init();
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_URL,$url);
        return curl_exec($curl);
    }
    function oauth_request_token(){
        $url = $this->build_request_uri($this->C('oauth_request_token_url'));
        $tmp_oauth_token = $this->get_contents($url);
        parse_str($tmp_oauth_token);
        if(isset($error_code)) exit($error_code);
        return array(
            'oauth_token'=>$oauth_token,
            'oauth_token_secret'=>$oauth_token_secret
        );
    }
    function authorize($oauth_token){
        $str = "HTTP/1.1 302 Found";
        header($str);
        $url = $this->C('oauth_authorize_url');
        $query_strings = http_build_query(array(
            'oauth_consumer_key'=>$this->C('oauth_consumer_key'),
            'oauth_token'=>$oauth_token,
            'oauth_callback'=>$this->C('oauth_callback'),
        ));
        header('Location: '.$url.'?'.$query_strings);
    }
    function register_user(){
        if($this->check_callback()){
            //校验签名
            $signature = base64_encode(hash_hmac('sha1',$_GET['openid'].$_GET['timestamp'],$this->C('oauth_consumer_secret'),true));
            if(!empty($_GET['oauth_signature']) && $signature==$_GET['oauth_signature']){
                $_SESSION['oauth_token'] = $_GET['oauth_token'];
                $_SESSION['oauth_vericode'] = $_GET['oauth_vericode'];
                return;
            }
        }
        //校验未通过
        exit('UNKNOW REQUEST');
    }
    function request_access_token(){
        $url = $this->build_request_uri($this->C('oauth_request_access_token_url'),array(
            'oauth_token'=>$_SESSION['oauth_token'],
            'oauth_vericode'=>$_SESSION['oauth_vericode']
        ),$_SESSION['oauth_token_secret']);
        return $this->get_contents($url);
    }
    function save_access_token($access_token_str){
        parse_str($access_token_str,$access_token_arr);
        if(isset($access_token_arr['error_code'])){
            return FALSE;
        } else {
            return $access_token_arr;
        }
    }
    function get_user_info(){
        $url = $this->build_request_uri($this->C('user_info_url'),array(
            'oauth_token'=>$_SESSION['oauth_token'],
            'openid'=>$_SESSION['openid'],
        ),$_SESSION['oauth_token_secret']);
        return $this->get_contents($url);
    }
}
?>
