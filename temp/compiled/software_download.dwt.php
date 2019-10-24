<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="Keywords" content="" />
<meta name="Description" content="" />

<title><?php echo $this->_var['page_title']; ?></title>



<link rel="shortcut icon" href="favicon.ico" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_var['site_domain']; ?>themes/<?php echo $GLOBALS['_CFG']['template']; ?>/css/baochi.css" />
<?php echo $this->fetch('library/js_languages_new.lbi'); ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'transport.js')); ?>
</head>

<body class="merchants bg-ligtGary">
<?php echo $this->fetch('library/page_header_common.lbi'); ?>
<div class="container settled-container">
    <div style="width:100%;height:238px;background:url(data/afficheimg/software_download.jpg)"></div>
	<div class="w w1200">
        <div class="software_list">
		    <ul id="software_title">
			   <li>序&nbsp;&nbsp;&nbsp;&nbsp;号</li>
			   <li>软件名称</li>
			   <li>软件版本号</li>
			   <li>软件大小</li>
			   <li>更新时间</li>
			   <li>详情</li>
			   <li>下载</li>
			</ul>
        	<table cellpadding="10px" cellspacing="0" frame="above">
			   <?php $_from = $this->_var['software_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'software');if (count($_from)):
    foreach ($_from AS $this->_var['software']):
?>
				<tr>
				   <td width="14%" style="border-bottom:#808080 solid 1px;">[<?php echo $this->_var['software']['sort_number']; ?>]</td>
				   <td width="14%" style="border-bottom:#808080 solid 1px;"><?php echo $this->_var['software']['software_name']; ?></td>
				   <td width="14%" style="border-bottom:#808080 solid 1px;"><?php echo $this->_var['software']['software_version']; ?></td>
				   <td width="14%" style="border-bottom:#808080 solid 1px;"><?php echo $this->_var['software']['software_size']; ?></td>
				   <td width="14%" style="border-bottom:#808080 solid 1px;"><?php echo $this->_var['software']['create_time']; ?></td>
				   <td width="14%" style="border-bottom:#808080 solid 1px;">
					   <div>
						  <a style="color:#2d3947;" href="<?php echo $this->_var['software']['software_article_link']; ?>" onclick="getHrefValue()">查看详情</a>
					   </div>
				   </td>
				   <td width="14%" style="border-bottom:#808080 solid 1px;">
					   <div>
						  <a style="color:#2d3947;" href="javascript:void(0)" onclick="getDownloadLink(event)">下载</a>  
						  <input type="hidden" name="software_download_link" value="<?php echo $this->_var['software']['software_id']; ?>">
					   </div>
				   </td>
				</tr>
				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
			</table>
        </div>
    </div>
</div>	

<script type="text/javascript">

function getDownloadLink(evt){
	var user_id = "<?php echo $this->_var['user_id']; ?>"
	if(user_id > 0){
		 var software_id=$(evt.target).next().val();
	     Ajax.call('software_download.php?act=getDownloadLink', 'software_id=' + software_id,getResult,'GET','JSON');
	}else{
	   window.location.href='user.php?act=login';
	}
}

function getResult(result){
	window.open(result.download_link);
}

</script>
 <?php echo $this->fetch('library/page_footer.lbi'); ?>
<script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/dsc-common.js"></script>
<script type="text/javascript" src="themes/<?php echo $GLOBALS['_CFG']['template']; ?>/js/jquery.purebox.js"></script>
</body>
</html>

