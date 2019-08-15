<?php	
	/*
	*2019-5-16
	*/
	define('IN_ECS', true);
	require dirname(__FILE__) . '/includes/init.php';
	require ROOT_PATH . '/includes/lib_area.php';
	require ROOT_PATH . 'includes/cls_json.php';
    require ROOT_PATH . 'includes/lib_order.php';
	
	$area_info = get_area_info($province_id);
	$where = 'regionId = \'' . $province_id . '\'';
	$date = array('parent_id');
	$region_id = get_table_date('region_warehouse', $where, $date, 2);
	$smarty->assign('province_row', get_region_info($province_id));
	$smarty->assign('city_row', get_region_info($city_id));
	$smarty->assign('district_row', get_region_info($district_id));
	$province_list = get_warehouse_province();
	$smarty->assign('province_list', $province_list);
	$city_list = get_region_city_county($province_id);
	$smarty->assign('city_list', $city_list);
	$district_list = get_region_city_county($city_id);
	$smarty->assign('district_list', $district_list);
	$smarty->assign('open_area_goods', $GLOBALS['_CFG']['open_area_goods']);
	assign_template();
	$smarty->assign('ur_here', $position['ur_here']);
	$categories_pro = get_category_tree_leve_one();
	$smarty->assign('categories_pro', $categories_pro);
	$smarty->assign('helps', get_shop_help());
	
	/****软件下载页面*****/
    $software_sql='SELECT software_id,software_name,software_version,software_size,create_time,software_article_link,sort_number FROM fly_software_download ORDER BY sort_number ASC;';
    $software_list=$GLOBALS['db']->getAll($software_sql);
	$smarty->assign('software_list',$software_list);
	$smarty->assign('page_title','软件下载');
	
	/*****请求获取下载链接****/
	if ($_REQUEST['act'] == 'getDownloadLink'){
		$software_id=json_str_iconv(trim($_GET['software_id']));   
		$json = new JSON();
		$sql='SELECT software_url FROM fly_software_download WHERE software_id='.$software_id.';';
		$download_link=$GLOBALS['db']->getOne($sql);
		$result = array('error' => 0, 'message' => '', 'download_link' => $download_link);
		die($json->encode($result));  
	}
	
	$smarty->display('software_download.dwt');
	
	
	
	?>