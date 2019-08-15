<?php	
	/*
	*2019-1-16
	*新添加防伪码查询页面
	*分页显示需要修改
	*string($safe_code) 
	*return int($res)
	*输出页面至 anti_fake.dwt
	*/
	define('IN_ECS', true);
	require dirname(__FILE__) . '/includes/init.php';
	require ROOT_PATH . '/includes/lib_area.php';
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
	/********/
	$smarty->assign('page_title', '防伪查询');
	$smarty->assign('keywords', '防伪查询');
	$smarty->assign('description', '防伪查询');
	/*广告位大小*/
	$config_pso = "select ad_width,ad_height from fly_ad_position where position_id = 347";
	$config_res = $db->getRow($config_pso);
	$smarty->assign('config_res', $config_res);
	/*广告图地址*/
	$ad_sql = "SELECT * FROM fly_ad where position_id = 347";
	$ad_res = $db->getRow($ad_sql);
	$smarty->assign('ad_res', $ad_res);
	$smarty->display('anti_fake.dwt');