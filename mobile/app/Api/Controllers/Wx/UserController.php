<?php
//zend websc在线更新版         
namespace App\Api\Controllers\Wx;

class UserController extends \App\Api\Controllers\Controller
{
	private $userService;
	private $authService;

	public function __construct(\App\Services\UserService $userService, \App\Services\AuthService $authService)
	{
		$this->userService = $userService;
		$this->authService = $authService;
	}

	public function login(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('userinfo' => 'required', 'code' => 'required'));

		if (false === ($result = $this->authService->loginMiddleWare($request->all()))) {
			return array('登录失败', 1);
		}

		return json_encode($result);
	}

	public function index(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array());
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args['uid'] = $uid;
		$args['list'] = $request->get('list');
		$userCenterData = $this->userService->userCenter($args);
		return $this->apiReturn($userCenterData);
	}

	public function orderList(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('page' => 'required|integer', 'size' => 'required|integer', 'status' => 'required|integer', 'type' => 'required|string'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$orderList = $this->userService->orderList(array_merge(array('uid' => $uid), $request->all()));
		return $this->apiReturn($orderList);
	}

	public function orderDetail(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer'));
		$args['order_id'] = $request->get('id');
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args['uid'] = $uid;
		$order = $this->userService->orderDetail($args);
		return $this->apiReturn($order);
	}

	public function orderAppraise(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array());
		$args = $request->all();
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args['uid'] = $uid;
		$order = $this->userService->orderAppraise($args);
		return $this->apiReturn($order);
	}

	public function orderAppraiseDetail(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('oid' => 'required|integer', 'gid' => 'required|integer'));
		$args = $request->all();
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args['uid'] = $uid;
		$order = $this->userService->orderAppraiseDetail($args);
		return $this->apiReturn($order);
	}

	public function orderAppraiseAdd(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('gid' => 'required|integer', 'oid' => 'required|integer', 'content' => 'required', 'rank' => 'required|integer'));
		$args = $request->all();
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args['uid'] = $uid;
		$res = $this->userService->orderAppraiseAdd($args);
		return $this->apiReturn($res);
	}

	public function orderCancel(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer'));
		$args['order_id'] = $request->get('id');
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args['uid'] = $uid;
		$res = $this->userService->orderCancel($args);

		if (0 < $res['error']) {
			return $this->apiReturn($res['msg'], 1);
		}

		return $this->apiReturn($res);
	}

	public function orderConfirm(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer'));
		$args['order_id'] = $request->get('id');
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args['uid'] = $uid;
		$res = $this->userService->orderConfirm($args);
		return $this->apiReturn($res);
	}

	public function orderLogistics(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('relname' => 'required|string', 'order_sn' => 'required|string'));
		$args = $request->all();
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$res = $this->userService->logistics($args);
		return $this->apiReturn($res);
	}

	public function addressList(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array());
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$address = $this->userService->userAddressList($uid);
		return $this->apiReturn($address);
	}

	public function addressChoice(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['uid'] = $uid;
		$res = $this->userService->addressChoice($args);
		return $this->apiReturn($res, $res ? 0 : 1);
	}

	public function addressAdd(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('consignee' => 'required|string', 'province' => 'required|integer', 'city' => 'required|integer', 'district' => 'required|integer', 'address' => 'required|string', 'mobile' => 'required|size:11'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['uid'] = $uid;
		$address = $this->userService->addressAdd($args);
		return $this->apiReturn($address);
	}

	public function addressDetail(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['uid'] = $uid;
		$address = $this->userService->addressDetail($args);
		return $this->apiReturn($address);
	}

	public function addressUpdate(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer', 'consignee' => 'required|string', 'province' => 'required|integer', 'city' => 'required|integer', 'district' => 'required|integer', 'address' => 'required|string', 'mobile' => 'required|size:11'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['uid'] = $uid;
		$address = $this->userService->addressUpdate($args);
		return $this->apiReturn($address);
	}

	public function addressDelete(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['uid'] = $uid;
		$address = $this->userService->addressDelete($args);
		return $this->apiReturn($address);
	}

	public function account(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array());
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$userInfo = $this->userService->userAccount($uid);
		return $this->apiReturn($userInfo);
	}

	public function accountDetail(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('page' => 'required|integer', 'size' => 'required|integer'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['user_id'] = $uid;
		$list = $this->userService->accountDetail($args);
		return $this->apiReturn($list);
	}

	public function deposit(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('amount' => 'required|integer', 'user_note' => 'required|string'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['uid'] = $uid;
		$args['payment'] = '微信';
		$res = $this->userService->deposit($args);
		return $this->apiReturn($res);
	}

	public function accountLog(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('page' => 'required|integer', 'size' => 'required|integer'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['user_id'] = $uid;
		$list = $this->userService->accountLog($args);
		return $this->apiReturn($list);
	}

	public function collectGoods(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('page' => 'required|integer', 'size' => 'required|integer'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['user_id'] = $uid;
		$list = $this->userService->collectGoods($args);
		return $this->apiReturn($list);
	}

	public function collectAdd(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['uid'] = $uid;
		$res = $this->userService->collectAdd($args);
		return $this->apiReturn($res, $res == 1 ? 0 : 1);
	}

	public function collectStore(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$res = $this->userService->collectStore($uid);
		return $res;
	}

	public function conpont(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('type' => 'required|integer'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['user_id'] = $uid;
		$list = $this->userService->myConpont($args);
		return $this->apiReturn($list);
	}

	public function uploadFile(\Illuminate\Http\Request $request)
	{
		$file = $request->file('file');
		$destinationPath = '../resources/uploads';
		$path = $file->move($destinationPath, $file->getClientOriginalName());
		return $this->apiReturn(json_encode($path));
	}

	public function invoiceDetail(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array());
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args['uid'] = $uid;
		$invoice = $this->userService->invoiceDetail($args);
		return $this->apiReturn($invoice);
	}

	public function invoiceAdd(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('company_name' => 'required|string', 'company_address' => 'required|string', 'tax_id' => 'required|string', 'company_telephone' => 'required|size:11', 'bank_of_deposit' => 'required|string', 'bank_account' => 'required|string', 'consignee_name' => 'required|string', 'consignee_mobile_phone' => 'required|size:11', 'province' => 'required|integer', 'city' => 'required|integer', 'district' => 'required|integer', 'country' => 'required|integer', 'consignee_address' => 'required|string'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['uid'] = $uid;
		$invoice = $this->userService->invoiceAdd($args);
		return $this->apiReturn($invoice);
	}

	public function invoiceUpdate(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['uid'] = $uid;
		$invoice = $this->userService->invoiceUpdate($args);
		return $this->apiReturn($invoice);
	}

	public function invoiceDelete(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array('id' => 'required|integer'));
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$args = $request->all();
		$args['uid'] = $uid;
		$invoice = $this->userService->invoiceDelete($args);
		return $this->apiReturn($invoice);
	}

	public function funds(\Illuminate\Http\Request $request)
	{
		$this->validate($request, array());
		$uid = $this->authService->authorization();
		if (isset($uid['error']) && 0 < $uid['error']) {
			return $this->apiReturn($uid, 1);
		}

		$funds = $this->userService->funds($uid, $request->get('list'));
		return $this->apiReturn($funds);
	}
}

?>