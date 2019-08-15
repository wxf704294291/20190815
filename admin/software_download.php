<?php
function get_software_list()
{
	$result = get_filter();//获取过滤器

	if ($result === false) {
		$filter = array();//创建一个空的过滤器
		$filter['sort_by'] = empty($_REQUEST['sort_by']) ? 'software_id' : trim($_REQUEST['sort_by']); //排序规则
		$filter['sort_order'] = empty($_REQUEST['sort_order']) ? 'DESC' : trim($_REQUEST['sort_order']);//排序序号
		$sql = 'SELECT COUNT(*) FROM ' . $GLOBALS['ecs']->table('software_download'); //获取当前表的记录数
		$filter['record_count'] = $GLOBALS['db']->getOne($sql); //得到记录数值
		$filter = page_and_size($filter);//确定页面大小
		//查询记录
		$sql = 'SELECT software_id,software_name,software_version,software_size,create_time,software_url,software_article_link,sort_number' . ' FROM ' . $GLOBALS['ecs']->table('software_download') . ' ORDER by ' . $filter['sort_by'] . ' ' . $filter['sort_order'];
		set_filter($filter, $sql);//将查询到的记录存入过滤器中
	}
	else {
		$sql = $result['sql'];
		$filter = $result['filter'];
	}
    //选择限制，用于分页
	$res = $GLOBALS['db']->selectLimit($sql, $filter['page_size'], $filter['start']);
	$list = array();//定义当前页记录

	//获取当前记录
	while ($rows = $GLOBALS['db']->fetchRow($res)) {
		/*
		if (empty($rows['software_url'])) {
			$rows['software_url'] = 'wwww.flyobd.com';
		}
		else {
			if ((strpos($rows['link_logo'], 'http://') === false) && (strpos($rows['link_logo'], 'https://') === false)) {
				$rows['link_logo'] = '../' . $rows['link_logo'];
			}
		}*/

		$list[] = $rows;
	}
    //返回当前记录
	return array('list' => $list, 'filter' => $filter, 'page_count' => $filter['page_count'], 'record_count' => $filter['record_count']);
}

define('IN_ECS', true);
require dirname(__FILE__) . '/includes/init.php';
include_once ROOT_PATH . 'includes/cls_image.php';
$image = new cls_image($_CFG['bgcolor']);
$exc = new exchange($ecs->table('software_download'), $db, 'software_id', 'software_name');

if (empty($_REQUEST['act'])) {
	$_REQUEST['act'] = 'list';
}
else {
	$_REQUEST['act'] = trim($_REQUEST['act']);
}

if ($_REQUEST['act'] == 'list') {
	$smarty->assign('ur_here', '软件列表');
	$smarty->assign('action_link', array('text' => '新增软件', 'href' => 'software_download.php?act=add'));
	$smarty->assign('full_page', 1);
	$softwares_list = get_software_list(); //获取列表
	$smarty->assign('softwares_list', $softwares_list['list']); //设置列表请求参数
	$smarty->assign('filter', $softwares_list['filter']);
	$smarty->assign('record_count', $softwares_list['record_count']); //记录数
	$smarty->assign('page_count', $softwares_list['page_count']);  //页面总大小
	$sort_flag = sort_flag($softwares_list['filter']); //排序标志
	$smarty->assign($sort_flag['tag'], $sort_flag['img']);
	assign_query_info();
	$smarty->display('software_download.dwt');
}
else if ($_REQUEST['act'] == 'query') {
	$links_list = get_links_list();
	$smarty->assign('links_list', $links_list['list']);
	$smarty->assign('filter', $links_list['filter']);
	$smarty->assign('record_count', $links_list['record_count']);
	$smarty->assign('page_count', $links_list['page_count']);
	$sort_flag = sort_flag($links_list['filter']);
	$smarty->assign($sort_flag['tag'], $sort_flag['img']);
	make_json_result($smarty->fetch('software_download.dwt'), '', array('filter' => $links_list['filter'], 'page_count' => $links_list['page_count']));
}
else if ($_REQUEST['act'] == 'add') {
	admin_priv('softwaredownload');
	$smarty->assign('ur_here', '填写新增软件信息');
	$smarty->assign('action_link', array('href' => 'software_download.php?act=list', 'text' => '新增软件'));
	$smarty->assign('action', 'add');
	$smarty->assign('form_act', 'insert');
	assign_query_info();
	$smarty->display('software_info.dwt');
}
else if ($_REQUEST['act'] == 'insert') {
	$link_logo = '';
	$show_order = (!empty($_POST['show_order']) ? intval($_POST['show_order']) : 0);
	$link_name = (!empty($_POST['link_name']) ? sub_str(trim($_POST['link_name']), 250, false) : '');

	if ($exc->num('link_name', $link_name) == 0) {
		if ((isset($_FILES['link_img']['error']) && ($_FILES['link_img']['error'] == 0)) || (!isset($_FILES['link_img']['error']) && isset($_FILES['link_img']['tmp_name']) && ($_FILES['link_img']['tmp_name'] != 'none'))) {
			$img_up_info = @basename($image->upload_image($_FILES['link_img'], 'afficheimg'));
			$link_logo = DATA_DIR . '/afficheimg/' . $img_up_info;
		}

		if (!empty($_POST['url_logo'])) {
			if ((strpos($_POST['url_logo'], 'http://') === false) && (strpos($_POST['url_logo'], 'https://') === false)) {
				$link_logo = 'http://' . trim($_POST['url_logo']);
			}
			else {
				$link_logo = trim($_POST['url_logo']);
			}
		}

		if (((isset($_FILES['upfile_flash']['error']) && (0 < $_FILES['upfile_flash']['error'])) || (!isset($_FILES['upfile_flash']['error']) && isset($_FILES['upfile_flash']['tmp_name']) && ($_FILES['upfile_flash']['tmp_name'] == 'none'))) && empty($_POST['url_logo'])) {
			$link_logo = '';
		}

		if ((strpos($_POST['link_url'], 'http://') === false) && (strpos($_POST['link_url'], 'https://') === false)) {
			$link_url = 'http://' . trim($_POST['link_url']);
		}
		else {
			$link_url = trim($_POST['link_url']);
		}

		get_oss_add_file(array($link_logo));
		$sql = 'INSERT INTO ' . $ecs->table('friend_link') . ' (link_name, link_url, link_logo, show_order) ' . 'VALUES (\'' . $link_name . '\', \'' . $link_url . '\', \'' . $link_logo . '\', \'' . $show_order . '\')';
		$db->query($sql);
		admin_log($_POST['link_name'], 'add', 'friendlink');
		clear_cache_files();
		$link[0]['text'] = $_LANG['continue_add'];
		$link[0]['href'] = 'friend_link.php?act=add';
		$link[1]['text'] = $_LANG['back_list'];
		$link[1]['href'] = 'friend_link.php?act=list';
		sys_msg($_LANG['add'] . '&nbsp;' . stripcslashes($_POST['link_name']) . ' ' . $_LANG['attradd_succed'], 0, $link);
	}
	else {
		$link[] = array('text' => $_LANG['go_back'], 'href' => 'javascript:history.back(-1)');
		sys_msg($_LANG['link_name_exist'], 0, $link);
	}
}
else if ($_REQUEST['act'] == 'edit') {
	admin_priv('friendlink');
	$sql = 'SELECT link_id, link_name, link_url, link_logo, show_order ' . 'FROM ' . $ecs->table('friend_link') . ' WHERE link_id = \'' . intval($_REQUEST['id']) . '\'';
	$link_arr = $db->getRow($sql);

	if (!empty($link_arr['link_logo'])) {
		$type = 'img';
		$link_logo = $link_arr['link_logo'];
	}
	else {
		$type = 'chara';
		$link_logo = '';
	}

	$link_arr['link_name'] = sub_str($link_arr['link_name'], 250, false);
	$smarty->assign('ur_here', $_LANG['edit_link']);
	$smarty->assign('action_link', array('href' => 'friend_link.php?act=list&' . list_link_postfix(), 'text' => $_LANG['list_link']));
	$smarty->assign('form_act', 'update');
	$smarty->assign('action', 'edit');
	$smarty->assign('type', $type);
	$smarty->assign('link_logo', $link_logo);
	$smarty->assign('link_arr', $link_arr);
	assign_query_info();
	$smarty->display('link_info.dwt');
}
else if ($_REQUEST['act'] == 'update') {
	$id = (!empty($_REQUEST['id']) ? intval($_REQUEST['id']) : 0);
	$show_order = (!empty($_POST['show_order']) ? intval($_POST['show_order']) : 0);
	$link_name = (!empty($_POST['link_name']) ? trim($_POST['link_name']) : '');
	if ((isset($_FILES['link_img']['error']) && ($_FILES['link_img']['error'] == 0)) || (!isset($_FILES['link_img']['error']) && isset($_FILES['link_img']['tmp_name']) && ($_FILES['link_img']['tmp_name'] != 'none'))) {
		$img_up_info = @basename($image->upload_image($_FILES['link_img'], 'afficheimg'));
		$link_logo = ', link_logo = ' . '\'' . DATA_DIR . '/afficheimg/' . $img_up_info . '\'';
		$linklogo_img = DATA_DIR . '/afficheimg/' . $img_up_info;
	}
	else if (!empty($_POST['url_logo'])) {
		$link_logo = ', link_logo = \'' . $_POST['url_logo'] . '\'';
		$linklogo_img = $_POST['url_logo'];
	}
	else {
		$link_logo = ', link_logo = \'\'';
		$linklogo_img = '';
	}

	if (!empty($img_up_info)) {
		$old_logo = $db->getOne('SELECT link_logo FROM ' . $ecs->table('friend_link') . ' WHERE link_id = \'' . $id . '\'');
		if ((strpos($old_logo, 'http://') === false) && (strpos($old_logo, 'https://') === false)) {
			$img_name = basename($old_logo);
			@unlink(ROOT_PATH . DATA_DIR . '/afficheimg/' . $img_name);
			get_oss_del_file(array(DATA_DIR . '/afficheimg/' . $img_name));
		}
	}

	if ((strpos($_POST['link_url'], 'http://') === false) && (strpos($_POST['link_url'], 'https://') === false)) {
		$link_url = 'http://' . trim($_POST['link_url']);
	}
	else {
		$link_url = trim($_POST['link_url']);
	}

	get_oss_add_file(array($linklogo_img));
	$sql = 'UPDATE ' . $ecs->table('friend_link') . ' SET ' . 'link_name = \'' . $link_name . '\', ' . 'link_url = \'' . $link_url . '\' ' . $link_logo . ',' . 'show_order = \'' . $show_order . '\' ' . 'WHERE link_id = \'' . $id . '\'';
	$db->query($sql);
	admin_log($_POST['link_name'], 'edit', 'friendlink');
	clear_cache_files();
	$link[0]['text'] = $_LANG['back_list'];
	$link[0]['href'] = 'friend_link.php?act=list&' . list_link_postfix();
	sys_msg($_LANG['edit'] . '&nbsp;' . stripcslashes($_POST['link_name']) . '&nbsp;' . $_LANG['attradd_succed'], 0, $link);
}
else if ($_REQUEST['act'] == 'delPic') {
	check_authz_json('friendlink');
	$id = intval($_GET['link_id']);
	$result = array('error' => 0, 'content' => '');
	$link_logo = $exc->get_name($id, 'link_logo');
	get_oss_del_file(array($link_logo));
	@unlink(ROOT_PATH . $link_logo);
	$sql = ' UPDATE ' . $ecs->table('friend_link') . ' SET ' . ' link_logo = \'\' ' . ' WHERE link_id = \'' . $id . '\' ';

	if (!$db->query($sql)) {
		$result['error'] = 1;
	}

	make_json_result($result);
	exit();
}
else if ($_REQUEST['act'] == 'edit_show_order') {
	check_authz_json('friendlink');
	$id = intval($_POST['id']);
	$order = json_str_iconv(trim($_POST['val']));

	if (!preg_match('/^[0-9]+$/', $order)) {
		make_json_error(sprintf($_LANG['enter_int'], $order));
	}
	else if ($exc->edit('show_order = \'' . $order . '\'', $id)) {
		clear_cache_files();
		make_json_result(stripslashes($order));
	}
}
else if ($_REQUEST['act'] == 'remove') {
	check_authz_json('friendlink');
	$id = intval($_GET['id']);
	$link_logo = $exc->get_name($id, 'link_logo');
	get_oss_del_file(array($link_logo));
	@unlink(ROOT_PATH . $link_logo);
	$exc->drop($id);
	clear_cache_files();
	admin_log('', 'remove', 'friendlink');
	$url = 'friend_link.php?act=query&' . str_replace('act=remove', '', $_SERVER['QUERY_STRING']);
	ecs_header('Location: ' . $url . "\n");
	exit();
}

?>
