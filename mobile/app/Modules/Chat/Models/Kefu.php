<?php

namespace App\Modules\Chat\Models;

use App\Models\Goods;
use App\Models\ImDialog;
use App\Models\SellerShopinfo;
use App\Models\OssConfigure;
use App\Models\User;
use App\Models\AdminUser;
use App\Models\ImService;
use App\Models\ImMessage;
use App\Models\ImConfigure;
use Think\Model;
use Think\Upload;

class Kefu extends Model
{
    public static $pre = '{pre}';

    public function __construct()
    {
        parent::__construct();
        $config = load_config(ROOT_PATH . 'config/chat.php');
    }

    
    public static function getAdmin($admin = 0)
    {
        if (empty($admin)) {
            return;
        }

        $adminUser = AdminUser::where('user_id', $admin)
            ->with(['Service' => function ($query) {
                $query->addSelect('id', 'user_id', 'login_time')->where('status', 1);
            }])
            ->first()
            ->toArray();
        return $adminUser;
    }

    
    public static function getService($id)
    {
        $service = ImService::where('user_id', $id)
            ->where('status', 1)
            ->select('id', 'nick_name', 'chat_status')
            ->first();
        if ($service) {
            return $service->toArray();
        }
    }

    
    public static function getServiceById($id)
    {
        $service = ImService::where('id', $id)
            ->where('status', 1)
            ->select('id', 'nick_name', 'chat_status', 'user_id')
            ->first();
        if ($service) {
            return $service->toArray();
        }
    }

    
    public static function getServiceList($ruId, $sid)
    {
        if (empty($ruId) && $ruId !== 0) {
            return;
        }

        $adminUser = AdminUser::where('ru_id', $ruId)
            ->select(['user_id'])
            ->with(['Service' => function ($query) {
                $query->where('status', 1);
            }])
            ->get()
            ->toArray();

        foreach ($adminUser as $k => $v) {
            if ($v['service']['id'] == $sid) {
                unset($adminUser[$k]);
                continue;
            }
        }

        $adminUser = array_map(function ($v) {
            if (!empty($v['service'])) {
                $v['id'] = $v['service']['id'];
                $v['name'] = $v['service']['nick_name'];
            }
            unset($v['service']);
            unset($v['user_id']);
            return $v;
        }, $adminUser);

        return $adminUser;
    }

    
    public static function getWait($ru_id = 0)
    {
        $waitMessage = ImDialog::select('id', 'customer_id', 'services_id', 'origin', 'goods_id', 'store_id', 'start_time')
            ->where('services_id', 0)
            ->where('store_id', $ru_id)
            ->where('status', 1)
            ->orderby('start_time', 'DESC')
            ->groupby('customer_id')
            ->get()
            ->toArray();

        $total = 0;

        $waitMessageDataList = array();
        foreach ($waitMessage as $k => $v) {
            $waitMessage[$k]['add_time'] = date('Y-m-d H:i:s', $v['start_time']);
            $waitMessage[$k]['origin'] = str_replace(1, 'PC', str_replace(2, 'mobile', $v['origin']));
            $res = ImMessage::where('from_user_id', $v['customer_id'])
                ->where('to_user_id', 0)
                ->where('status', 1)
                ->orderby('add_time', 'desc')
                ->get()
                ->toArray();

            if (empty($res)) {
                unset($waitMessage[$k]);
                continue;
            }

            
            $message = array();
            foreach ($res as $rk => $rv) {
                array_push($message, htmlspecialchars_decode($rv['message']));
            }
            $waitMessageDataList[$v['customer_id']] = array_reverse($message);
            $temp = $res[count($res) - 1];
            unset($res);
            $res = $temp;

            $waitMessage[$k]['num'] = ImMessage::where('from_user_id', $v['customer_id'])
                ->where('to_user_id', 0)
                ->where('status', 1)
                ->orderby('add_time', 'desc')
                ->count();
            $total += $waitMessage[$k]['num'];

            $waitMessage[$k]['fid'] = $res['from_user_id'];
            $waitMessage[$k]['message'] = htmlspecialchars_decode($res['message']);
            $waitMessage[$k]['message_list'] = $message;
            $waitMessage[$k]['dialog_id'] = $res['dialog_id'];

            $res = User::where('user_id', $v['customer_id'])
                ->select('user_name', 'user_picture')
                ->first();
            if (!empty($res)) {
                $res = $res->toArray();
			}

            $waitMessage[$k]['user_name'] = $res['user_name'];
            $waitMessage[$k]['avatar'] = self::format_pic($res['user_picture']);
        }

        if (empty($waitMessage)) {
            $waitMessage[0] = array(
                'id' => '',
                'message' => '',
                'goods_id' => '',
                'store_id' => '',
                'user_name' => '',
                'avatar' => ''
            );
        }

        return array(
            'waitMessage' => $waitMessage,
            'waitMessageDataList' => $waitMessageDataList,
            'total' => $total
        );
    }

    
    public static function userInfo($uid)
    {
        $res = User::where('user_id', $uid)
            ->select('user_name', 'user_picture')
            ->first();
        if (!empty($res)) {
            $res = $res->toArray();
            $res['avatar'] = self::format_pic($res['user_picture']);
        } else {
            $res['user_name'] = '';
            $res['avatar'] = '';
        }
        return $res;
    }

    
    public static function getChatLog($service)
    {
        $messageList = ImDialog::select('id', 'customer_id', 'services_id', 'origin', 'goods_id', 'store_id', 'status')
            ->where('services_id', $service['id'])
            ->orderby('start_time', 'DESC')
            ->get()
            ->toArray();

        
        $temp = [];
		

        foreach ($messageList as $k => $v) {
            if (in_array($v['customer_id'], $temp)) {
                unset($messageList[$k]);
                continue;
            }
            $temp[] = $v['customer_id'];
        }

        $rootPath = rtrim(dirname(__ROOT__), '/');

        foreach ($messageList as $k => $v) {
            
            $res = ImMessage::where('dialog_id', $v['id'])
                ->select('message', "add_time", "user_type", "status")
                ->orderby('add_time', 'DESC')
                ->first();

            if (empty($res)) {
                continue;
            }
            $res = $res->toArray();
            $messageList[$k]['message'] = htmlspecialchars_decode($res['message']);
            $messageList[$k]['add_time'] = date('Y-m-d H:i:s', $res['add_time']);
            $messageList[$k]['origin'] = ($v['origin'] == 1) ? 'PC' : 'Phone';
            $messageList[$k]['user_type'] = $res['user_type'];
            $messageList[$k]['status'] = ($v['status'] == 1) ? '未结束' : '结束';
            $messageList[$k]['goods']['goods_name'] = '';
            $messageList[$k]['goods']['shop_price'] = '';
            $messageList[$k]['goods']['goods_thumb'] = '';
            $res = ImMessage::where('dialog_id', $v['id'])
                ->where('status', 1)
                ->select('message')
                ->orderby('add_time', 'DESC')
                ->get()
                ->toArray();

            if (!empty($res)) {
                $temp = [];
                foreach ($res as $msg) {
                    $temp[] = htmlspecialchars_decode($msg['message']);
                }
                $messageList[$k]['message'] = $temp;
                $messageList[$k]['message_sum'] = count($temp);
            }

            if ($messageList[$k]['goods_id'] > 0) {
                $res = Goods::where('goods_id', $v['goods_id'])
                    ->select('goods_name', 'goods_thumb', 'shop_price')
                    ->first();
				$oss_configure= OssConfigure::where('id', 1)            
                   ->select('id', 'endpoint')
                   ->first();
				if (!empty($oss_configure)) {
					$oss_configure = $oss_configure->toArray();
				}
                if (!empty($res)) {
                    $res = $res->toArray();
                    $messageList[$k]['goods']['goods_id'] = $v['goods_id'];
                    $messageList[$k]['goods']['goods_name'] = $res['goods_name'];
                    $messageList[$k]['goods']['shop_price'] = '￥' . $res['shop_price'];
                    $messageList[$k]['goods']['url'] = $rootPath . '/goods.php?id=' . $v['goods_id'];
					if(!$oss_configure){
					$messageList[$k]['goods']['goods_thumb'] =$oss_configure['endpoint'].self::format_goods_pic($res['goods_thumb']);
					}else{
						$messageList[$k]['goods']['goods_thumb'] ="/".self::format_goods_pic($res['goods_thumb']);
					}
                    
                }
            }

            //用户属性
            $res = User::where('user_id', $v['customer_id'])
                ->select('user_name', 'user_picture')
                ->first();
            if (!empty($res)) {
                $res = $res->toArray();
                $messageList[$k]['user_name'] = $res['user_name'];
                $messageList[$k]['user_picture'] = self::format_pic($res['user_picture']);
            }
            if (empty($res['user_name'])) {
                unset($messageList[$k]);
            }
        }
			//print_r($messageList);die;
		
        if (empty($messageList)) {
            $messageList[0] = array(
                'id' => '',
                'customer_id' => '',
                'services_id' => '',
                'origin' => '',
                'goods_id' => '',
                'store_id' => '',
                'message' => '',
                'add_time' => '',
                'user_name' => '',
                'user_picture' => '',
            );
        }
        return $messageList;
    }

    
    public static function changeMessageStatus($serviceId, $customId)
    {
        ImMessage::where(['from_user_id' => $serviceId, 'to_user_id' => $customId])
            ->orWhere(['to_user_id' => $serviceId, 'from_user_id' => $customId])
            ->update(['status' => 0]);
    }

    
    public static function getHistory($uid, $tid, $keyword = '', $time = '', $page = 1, $size = 20)
    {
        $start = ($page - 1) * $size;

        
        $where = "((from_user_id = {$uid} AND to_user_id = {$tid}) OR (from_user_id = {$tid} AND to_user_id = {$uid}))";

        if (!empty($keyword)) {
            $where .= " AND (message like '%{$keyword}%')";
        }

        if (!empty($time)) {
            $nowtime = strtotime($time);
            $tomotime = $nowtime + 3600 * 24;
            $where .= " AND (add_time > {$nowtime} AND add_time < {$tomotime})";
        }

        $count = $model = M('im_message')
            ->where($where)->count();

        
        $list = M('im_message')
            ->where($where)
            ->order('add_time DESC, id DESC')
            ->field('id, message, add_time, from_user_id, user_type')
            ->limit($start, $size);

        $list = $list->select();

        foreach ($list as $k => $v) {
            if ($v['user_type'] == 1) {
                $res = ImService::where('id', $v['from_user_id'])
                    ->pluck('nick_name')
                    ->toArray();

                $list[$k]['from_user_id'] = $res[0];
            } elseif ($v['user_type'] == 2) {
                $res = User::where('user_id', $v['from_user_id'])
                    ->pluck('user_name')
                    ->toArray();

                $list[$k]['from_user_id'] = $res[0];
            }
            $list[$k]['message'] = htmlspecialchars_decode($v['message']);
            $list[$k]['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
        }
        return ['list' => $list, 'total' => ceil($count / $size)];
    }

    
    public static function getSearchHistory($mid)
    {
        $message = ImMessage::where('id', $mid)
            ->select('from_user_id', 'to_user_id')
            ->first()
            ->toArray();

        $list = ImMessage::where('id', '<', $mid)
            ->where(['from_user_id' => $message['to_user_id'], 'to_user_id' => $message['from_user_id']])
            ->orWhere(['from_user_id' => $message['from_user_id'], 'to_user_id' => $message['to_user_id']])
            ->select()
            ->get()
            ->toArray();

        foreach ($list as $k => $v) {
            if ($v['user_type'] == 1) {
                $res = ImService::where('id', $v['from_user_id'])
                    ->pluck('nick_name')
                    ->toArray();

                $list[$k]['from_user_id'] = $res[0];
            } elseif ($v['user_type'] == 2) {
                $res = User::where('user_id', $v['from_user_id'])
                    ->pluck('user_name')
                    ->toArray();

                $list[$k]['from_user_id'] = $res[0];
            }
            $list[$k]['message'] = htmlspecialchars_decode($v['message']);
            $list[$k]['add_time'] = date('Y-m-d H:i:s', $v['add_time']);
            
            if ($mid == $v['id']) {
                $list[$k]['current'] = 1;
            }
        }

        return ['list' => $list];
    }

    
    public static function getReply($id, $type)
    {
        $reply = ImConfigure::where('ser_id', $id)
            ->where('type', $type)
            ->select('id', 'type', 'is_on', 'content');

        if ($type == 1) {
            $reply = $reply->get();
        } elseif ($type == 2 || $type == 3) {
            $reply = $reply->first();
        }
        if ($reply) {
            return $reply->toArray();
        }
    }

    
    public static function isDialog($data)
    {
        $dialog = ImDialog::where('customer_id', $data['customer_id'])
            ->where('services_id', $data['services_id'])
            ->where('goods_id', $data['goods_id'])
            ->where('store_id', $data['store_id'])
            ->orderby('id', 'DESC')
            ->where('status', 1)
            ->limit(1)
            ->get();
        $dialog = $dialog[0];

        if (!empty($dialog)) {
            $id = $dialog->id;
            $dialog->end_time = time();
            $dialog->save();
            return $id;
        }

        return false;
    }

    
    public static function addDialog($data)
    {
        $dialog = new ImDialog();
        $dialog->customer_id = $data['customer_id'];
        $dialog->services_id = $data['services_id'];
        $dialog->goods_id = $data['goods_id'];
        $dialog->store_id = $data['store_id'];
        $dialog->start_time = $data['start_time'];
        $dialog->origin = $data['origin'];
        $dialog->save();

        return $dialog->id;
    }

    
    public static function getRecentDialog($fid, $cid)
    {
        $dialog = ImDialog::where('customer_id', $cid)
            ->where('services_id', $fid)
            ->orderby('id', 'DESC')
            ->limit(1)
            ->get();
        $dialog = $dialog[0];
        return $dialog->toArray();
    }

    
    public static function updateDialog($cusId, $serId)
    {
        
        ImMessage::where('from_user_id', $cusId)->where('to_user_id', '')->where('user_type', 2)->update(['to_user_id' => $serId, 'status' => 0]);

        
        $dialog = ImDialog::where('customer_id', $cusId)
            ->where('services_id', 0)
            ->get();
        foreach ($dialog as $item) {
            $item->services_id = $serId;
            $item->end_time = time();
            $item->save();
        }
    }

    
    public static function closeWindow($uid, $tid)
    {
        ImDialog::where('customer_id', $tid)
            ->where('services_id', $uid)
            ->orderby('start_time', 'DESC')
            ->update(['end_time' => time(), 'status' => 2]);
    }

    
    public static function closeOldWindow($expire)
    {
        $dialog = ImDialog::where('end_time', '<', time() - $expire)
            ->where('status', 1)
            ->where('end_time', '>', 0)
            ->where('services_id', '<>', 0)
            ->distinct()
            ->orderby('start_time', 'DESC')
            ->get();

        $temp = [];
        foreach ($dialog as $k => $v) {
            $v->status = 2;
            $v->end_time = time();
            $v->save();
            if (isset($temp[$v->customer_id])) {
                continue;
            }

            $temp[$v->customer_id] = array(
                'cid' => $v->customer_id,
                'ssid' => $v->services_id,
                'sid' => $v->store_id
            );
        }

        return $temp;
    }

    
    public static function getGoods($gid)
    {
        $goods = Goods::select('goods_id', 'goods_name', 'goods_thumb', 'shop_price')
            ->where('goods_id', $gid)
            ->first()
            ->toArray();
        
		$oss_configure= OssConfigure::where('id', 1)            
                   ->select('id', 'endpoint')
                   ->first()->toArray();
		
                 if($oss_configure){
					$goods['goods_thumb'] =$oss_configure['endpoint'].self::format_goods_pic($goods['goods_thumb']);
					}else{
						$goods['goods_thumb'] ="/".self::format_goods_pic($goods['goods_thumb']);
					}
		
        

        return $goods;
    }

    
    public static function getStoreInfo($sid)
    {
        $store = SellerShopinfo::select('shop_name', 'logo_thumb')
            ->where('ru_id', $sid)
            ->first();

        if (!empty($store)) {
            $store = $store->toArray();
            if (empty($store['logo_thumb'])) {
                $store['logo_thumb'] = self::format_pic('', 'service');
            }
            return $store;
        }

        return [
            'shop_name' => '',
            'logo_thumb' => self::format_pic('', 'service')
        ];
    }

    
    public static function getServiceReply($serviceId)
    {
        $conf = ImConfigure::where('ser_id', $serviceId)
            ->where('is_on', 1)
            ->where('type', 2)
            ->first();

        if (!empty($conf)) {
            return $conf->content;
        }
    }

    
    public static function format_goods_pic($pic)
    {
        $rootPath = rtrim(dirname(__ROOT__), '/');

        if (empty($pic)) {
            return rtrim(__ROOT__, '/') . '/public/img/no_image.jpg';
        }

        return $pic;
    }

    
    public static function format_pic($pic, $who = '')
    {
        $rootPath = rtrim(dirname(__ROOT__), '/');

        if (strpos($pic, 'http') !== false) {
            return $pic;
        }

        if (empty($pic)) {
            if ($who == 'service') {
                $pic = 'service.png';
            } else {
                $pic = 'avatar.png';
            }
            return __ROOT__ . '/public/assets/chat/images/' . $pic;
        }

        return $rootPath . '/' . $pic;
    }

    
    public static function upload($savePath = '', $hasOne = false, $size = 2, $thumb = false)
    {
        $config = array(
            'maxSize' => $size * 1024 * 1024, 
            'rootPath' => dirname(ROOT_PATH) . '/',
            'savePath' => rtrim($savePath, '/') . '/', 
            'exts' => array('jpg', 'gif', 'png', 'jpeg', 'bmp', 'mp3', 'amr', 'mp4'),
            'autoSub' => false,
            'thumb' => $thumb
        );

        $up = new Upload($config);
        

        $result = $up->upload();

        if (!$result) {
            
            return array(
                'error' => 1,
                'message' => $up->getError()
            );
        } else {
            
            $res = array(
                'error' => 0
            );
            if ($hasOne) {
                $info = reset($result);
                $res['url'] = $info['savepath'] . $info['savename'];
            } else {
                foreach ($result as $k => $v) {
                    $result[$k]['url'] = $v['savepath'] . $v['savename'];
                }
                $res['url'] = $result;
            }
            return $res;
        }
    }
}
