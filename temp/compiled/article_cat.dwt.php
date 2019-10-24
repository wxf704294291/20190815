<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="<?php echo $this->_var['keywords']; ?>" />
<meta name="Description" content="<?php echo $this->_var['description']; ?>" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<?php echo $this->fetch('library/js_languages_new.lbi'); ?>
</head>

<body class="bg-ligtGary">
<?php echo $this->fetch('library/page_header_common.lbi'); ?>
<div class="content article-content">
	<div class="article-search-hd mb20">
    	<div class="w w1200">
            <div class="hd-tit"><?php echo $this->_var['lang']['article_help_center']; ?></div>
            <div class="hd-search">
                <form action="<?php echo $this->_var['search_url']; ?>" name="search_form" method="post" class="article_search">
                    <div class="f-search">
                        <input name="keywords" type="text" id="requirement" value="<?php echo $this->_var['search_value']; ?>" class="text" placeholder="<?php echo $this->_var['lang']['search_placeholder']; ?>" />
                        <input name="id" type="hidden" value="<?php echo $this->_var['cat_id']; ?>" />
                        <input name="cur_url" id="cur_url" type="hidden" value="" />
                        <a href="javascript:void(0);" class="ui-btn-submit" ectype="searchSubmit"><i class="iconfont icon-search"></i><?php echo $this->_var['lang']['search']; ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="w w1200 clearfix">
        <div class="article-side">
            <dl class="article-menu">
                <dt class="am-t"><a href="javascript:void(0);"><?php echo $this->_var['lang']['article_cat_list']; ?></a></dt>
                <dd class="am-c">
                    <?php $_from = $this->_var['sys_categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sys_cat');if (count($_from)):
    foreach ($_from AS $this->_var['sys_cat']):
?>
                    <div class="menu-item active">
                        <div class="item-hd"><a href="<?php if ($this->_var['sys_child_cat']['url']): ?><?php echo $this->_var['sys_child_cat']['url']; ?><?php else: ?>javascript:void(0);<?php endif; ?>"><?php echo $this->_var['sys_cat']['name']; ?></a><i class="iconfont icon-down"></i></div>
                        <?php $_from = $this->_var['sys_cat']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'sys_child_cat');$this->_foreach['cat'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['sys_child_cat']):
        $this->_foreach['cat']['iteration']++;
?>
                        <?php if ($this->_var['sys_child_cat']['children']): ?>
                        <ul class="item-bd">
                            <?php $_from = $this->_var['sys_child_cat']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sys_c_c_cat');if (count($_from)):
    foreach ($_from AS $this->_var['sys_c_c_cat']):
?>
                            <li><a href="<?php echo $this->_var['sys_c_c_cat']['url']; ?>"><?php echo $this->_var['sys_c_c_cat']['name']; ?></a></li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                        <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </dd>
                
                <dd class="am-c">
                    <?php $_from = $this->_var['custom_categories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'custom_cat');if (count($_from)):
    foreach ($_from AS $this->_var['custom_cat']):
?>
                    <div class="menu-item active">
                        <div class="item-hd"><a href="<?php echo $this->_var['custom_cat']['url']; ?>"><?php echo $this->_var['custom_cat']['name']; ?></a><i class="iconfont icon-up"></i></div>
                        <?php if ($this->_var['custom_cat']['children']): ?>
                        <ul class="item-bd" style="display:none;">
                            <?php $_from = $this->_var['custom_cat']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'custom_child_cat');if (count($_from)):
    foreach ($_from AS $this->_var['custom_child_cat']):
?>
                            <li><a href="<?php echo $this->_var['custom_child_cat']['url']; ?>"><?php echo $this->_var['custom_child_cat']['name']; ?></a></li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </dd>
            </dl>
            <?php if ($this->_var['related_goods']): ?>
            <div class="side-goods">
                <a href="javascript:;" class="prev"><span class="iconfont icon-left"></span></a>
                <a href="javascript:;" class="next"><span class="iconfont icon-right"></span></a>
                <div class="bd">
                    <?php $_from = $this->_var['related_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'related_goods');if (count($_from)):
    foreach ($_from AS $this->_var['related_goods']):
?>
                    <div class="item">
                        <div class="p-img"><a href="<?php echo $this->_var['related_goods']['url']; ?>" target="_blank"><img src="<?php echo $this->_var['related_goods']['goods_img']; ?>" alt=""></a></div>
                        <div class="p-name"><a href="<?php echo $this->_var['related_goods']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['related_goods']['goods_name']); ?>" target="_blank"><?php echo $this->_var['related_goods']['goods_name']; ?></a></div>
                        <div class="p-price">￥<?php echo $this->_var['related_goods']['shop_price']; ?></div>
                    </div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <div class="article-main">
            <div class="am-hd">
                <h2><?php echo $this->_var['cat_name']; ?></h2>
            </div>
            <div class="am-bd">
                <ul class="artilce-list">
                    <?php $_from = $this->_var['artciles_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'article');$this->_foreach['artcile'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['artcile']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['article']):
        $this->_foreach['artcile']['iteration']++;
?>
                    <li>
                        <h3><a href="<?php echo $this->_var['article']['url']; ?>" title="<?php echo htmlspecialchars($this->_var['article']['title']); ?>"><?php echo $this->_var['article']['short_title']; ?></a></h3>
                        <p><?php echo $this->_var['article']['description']; ?></p>
                    </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </div>
            <?php echo $this->fetch('library/pages.lbi'); ?>
        </div>
    </div>
</div>
<?php echo $this->fetch('library/page_footer.lbi'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'jquery.SuperSlide.2.1.1.js')); ?>
<script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/dsc-common.js"></script>
<script type="text/javascript">
	document.getElementById('cur_url').value = window.location.href;

	$(function(){
		$(".article-side .side-goods").slide({
			effect: 'leftLoop'
		});
		
		$("[ectype='searchSubmit']").on("click",function(){
			$(this).parents("form").submit();
		});
	});
</script>
</body>
</html>
