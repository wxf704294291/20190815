<?php	
	/*
	*2019-5-16
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
	
	/**页面内容**/
	$aticle_sql = "SELECT title,keywords,description,content,file_url FROM fly_article WHERE article_id=68;";
	$article_res = $db->getRow($aticle_sql );
	$smarty->assign('article',$article_res);
	

	
	$smarty->display('about_us.dwt');