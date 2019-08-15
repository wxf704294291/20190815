<?php

/**获取页面内容***/	
function get_content_list($title=null){
	if(!empty($title)){
	   $article_cat_id_sql='SELECT cat.cat_id FROM '.$GLOBALS['ecs']->table('article_cat').' AS cat where cat.cat_name="'.$title.'";';
	   $ad_position_id_sql='SELECT ad.position_id FROM '.$GLOBALS['ecs']->table('ad_position').' AS ad where ad.position_name="'.$title.'";';
	   $article_cat_id=$GLOBALS['db'] -> getOne($article_cat_id_sql);
	   $ad_position_id=$GLOBALS['db'] -> getOne($ad_position_id_sql);
	   $articles_sql='SELECT title,description,content FROM '.$GLOBALS['ecs']->table('article').' WHERE cat_id='.$article_cat_id.' ORDER BY sort_order ASC;';
	   $ads_sql='SELECT ad.ad_id,ad.ad_code FROM '.$GLOBALS['ecs']->table('ad_position').' AS adp,'.$GLOBALS['ecs']->table('ad').' AS ad WHERE adp.position_id='.$ad_position_id.' AND ad.position_id='.$ad_position_id.'; ';
	   
	   $articles=$GLOBALS['db']->getAll($articles_sql);
	   $ads=$GLOBALS['db']->getAll($ads_sql);
	   
	   return array('articles'=>$articles,'ads'=>$ads);
	}
	return;
	
	}

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
	
	/**保驰云诊断页面**/
	$title="保驰云诊断";
	$smarty->assign('page_title',$title);
	$contents_list=get_content_list($title);
	$articles=$contents_list['articles'];
	$ads=$contents_list['ads'];
	//合并$articles，$ads两个二维数组为一个二维数组
	if(!(empty($articles)&&empty($ads))){
		foreach($articles as $k => $v){
			$articles_list[]=array_merge($v,$ads[$k]);
		}
	}
	$smarty->assign('articles_list',$articles_list);
	$smarty->display('cloud_diagnostic.dwt');

	
?>