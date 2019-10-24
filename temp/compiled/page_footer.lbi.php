<div class="footer-new">    
    <div class="footer-new-con">
    	<div class="fnc-warp">
            <div class="help-list">
			    
			    <div class="help-item">
                    <h3>技术支持</h3>
                    <ul>
					    <li><a href="#">王工:13302450710</a></li>					
						<li><a href="#">刘工:13302450703</a></li>
						<li><a href="#">吴工:18565814015</a></li>
                    </ul>
                </div>
                <div class="help-item">
                    <h3>QQ技术交流群</h3>
                    <ul>
						<li><a href="#">J2534群: 87810643</a></li>
						<li><a href="#">TM100群: 668105728</a></li>
						<li><a href="#">终结者群: 631609714</a></li>
                    </ul>
                </div>
				<div class="help-item">
                    <h3>帮助中心</h3>
                    <ul>
						<li><a href="#">话题专区</a></li>
						<li><a href="#">内容专区</a></li>
						<li><a href="#">视频专区</a></li>
                    </ul>
                </div>
				<div class="help-item">
                    <h3>会员中心</h3>
                    <ul>
						<li><a href="#">我的订单</a></li>
						<li><a href="#">我的收藏</a></li>
						<li><a href="#">我的话题</a></li>
                    </ul>
                </div>
				<div class="help-item">
                    <h3>推广分红</h3>
                    <ul>
						<li><a href="#">项目介绍</a></li>
						<li><a href="#">产品中心</a></li>
						<li><a href="#">我的推广</a></li>
                    </ul>
                </div>
				
            </div>
            <div class="qr-code">
                <div class="qr-item qr-item-first">
                    <div class="code_img"><img src="<?php echo $this->_var['site_domain']; ?><?php echo $this->_var['ecjia_qrcode']; ?>"></div>
                    <div class="code_txt">官方微信公众号</div>
                </div>
                <div class="qr-item">
                    <div class="code_img"><img src="<?php echo $this->_var['site_domain']; ?><?php echo $this->_var['ectouch_qrcode']; ?>"></div>
                    <div class="code_txt">手机商城</div>
                </div>
            </div>
    	</div>
    </div>
    <div class="footer-new-bot">
    	<div class="w w1200">
            <?php if ($this->_var['navigator_list']['bottom']): ?> 
            <p class="copyright_links">
                <?php $_from = $this->_var['navigator_list']['bottom']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav_0_25322000_1571880516');$this->_foreach['nav_bottom_list'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nav_bottom_list']['total'] > 0):
    foreach ($_from AS $this->_var['nav_0_25322000_1571880516']):
        $this->_foreach['nav_bottom_list']['iteration']++;
?>
                <a href="<?php echo $this->_var['nav_0_25322000_1571880516']['url']; ?>"<?php if ($this->_var['nav_0_25322000_1571880516']['opennew'] == 1): ?> target="_blank" <?php endif; ?>><?php echo $this->_var['nav_0_25322000_1571880516']['name']; ?></a>
                <?php if (! ($this->_foreach['nav_bottom_list']['iteration'] == $this->_foreach['nav_bottom_list']['total'])): ?> 
                <span class="spacer"></span>
                <?php endif; ?> 
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
            </p>
            <?php endif; ?>
            
            <?php if ($this->_var['img_links'] || $this->_var['txt_links']): ?>
            <p class="copyright_links">
                <?php $_from = $this->_var['img_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
                    <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><img src="<?php echo $this->_var['link']['logo']; ?>" alt="<?php echo $this->_var['link']['name']; ?>" border="0" /></a>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    
                <?php if ($this->_var['txt_links']): ?>
                <?php $_from = $this->_var['txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');$this->_foreach['nolink'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nolink']['total'] > 0):
    foreach ($_from AS $this->_var['link']):
        $this->_foreach['nolink']['iteration']++;
?>
                    <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><?php echo $this->_var['link']['name']; ?></a>
                    <?php if (! ($this->_foreach['nolink']['iteration'] == $this->_foreach['nolink']['total'])): ?> 
                    <span class="spacer"></span>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </p>
            <?php endif; ?>
            <br><p>返修地址：广东省深圳市南山区粤海街道5号动漫园1栋405，吕小姐：收, 手机号码：18948327861</p><br>
            <?php if ($this->_var['icp_number']): ?>
            <p><span>©&nbsp;2019-2020&nbsp;深圳市硕泰昌科技有限公司&nbsp;版权所有&nbsp;&nbsp;</span><span><?php echo $this->_var['lang']['icp_number']; ?>:</span><a href="http://www.miibeian.gov.cn/" target="_blank"><?php echo $this->_var['icp_number']; ?></a></p>
            <?php endif; ?>
            
            <?php if ($this->_var['partner_img_links'] || $this->_var['partner_txt_links']): ?>
            <p class="copyright_auth">
                <?php $_from = $this->_var['partner_img_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['link']):
?>
                <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>"><img src="<?php echo $this->_var['link']['logo']; ?>" alt="<?php echo $this->_var['link']['name']; ?>" border="0" /></a>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php if ($this->_var['txt_links']): ?>
                <?php $_from = $this->_var['partner_txt_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'link');$this->_foreach['nolink'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['nolink']['total'] > 0):
    foreach ($_from AS $this->_var['link']):
        $this->_foreach['nolink']['iteration']++;
?>
                <a href="<?php echo $this->_var['link']['url']; ?>" target="_blank" title="<?php echo $this->_var['link']['name']; ?>" class="mr0"><?php echo $this->_var['link']['name']; ?></a>
                <?php if (! ($this->_foreach['nolink']['iteration'] == $this->_foreach['nolink']['total'])): ?> 
                | 
                <?php endif; ?> 
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
            </p>    
            <?php else: ?>
            <p class="copyright_auth">&nbsp;</p>
            <?php endif; ?>
            
            <?php if ($this->_var['stats_code']): ?>
            	<p style="display:none;"><?php echo $this->_var['stats_code']; ?></p>
            <?php endif; ?>
        </div>
    </div>
    
    
    <div class="hide" id="pd_coupons">
        <span class="success-icon m-icon"></span>
        <div class="item-fore">
            <h3><?php echo $this->_var['lang']['Coupon_redemption_succeed']; ?></h3>
            <div class="txt ftx-03"><?php echo $this->_var['lang']['coupons_prompt']; ?></div>
        </div>
    </div>
    
    
    <div class="hidden">
        <input type="hidden" name="seller_kf_IM" value="<?php echo $this->_var['shop_information']['is_IM']; ?>" rev="<?php echo $this->_var['site_domain']; ?>" ru_id="<?php echo empty($this->_var['merchant_id']) ? '0' : $this->_var['merchant_id']; ?>" />
        <input type="hidden" name="seller_kf_qq" value="<?php echo $this->_var['basic_info']['kf_qq']; ?>" />
        <input type="hidden" name="seller_kf_tel" value="<?php echo $this->_var['basic_info']['kf_tel']; ?>" />
        <input type="hidden" name="user_id" ectype="user_id" value="<?php if ($this->_var['user_id']): ?><?php echo $this->_var['user_id']; ?><?php else: ?><?php echo empty($_SESSION['user_id']) ? '0' : $_SESSION['user_id']; ?><?php endif; ?>" />
    </div>
</div>

<?php if ($this->_var['site_domain']): ?>
<script type="text/jscript" src="<?php echo $this->_var['site_domain']; ?>js/suggest.js"></script>
<script type="text/jscript" src="<?php echo $this->_var['site_domain']; ?>js/scroll_city.js"></script>
<script type="text/jscript" src="<?php echo $this->_var['site_domain']; ?>js/utils.js"></script>
<?php else: ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'suggest.js,scroll_city.js,utils.js')); ?>
<?php endif; ?>

<?php if ($this->_var['site_domain']): ?>
<?php if ($this->_var['area_htmlType'] != 'goods' && $this->_var['area_htmlType'] != 'exchange'): ?>
	<script type="text/javascript" src="<?php echo $this->_var['site_domain']; ?>js/warehouse_area.js"></script>
<?php else: ?>
	<script type="text/javascript" src="<?php echo $this->_var['site_domain']; ?>js/warehouse.js"></script>
<?php endif; ?>
<?php else: ?>
<?php echo $this->smarty_insert_scripts(array('files'=>'warehouse.js,warehouse_area.js')); ?>
<?php endif; ?>

<?php if ($this->_var['suspension_two']): ?>
<script>var seller_qrcode='<img src="<?php echo $this->_var['site_domain']; ?><?php echo $this->_var['seller_qrcode_img']; ?>" alt="<?php echo $this->_var['seller_qrcode_text']; ?>" width="164" height="164">'; //by wu</script>
<?php echo $this->_var['suspension_two']; ?>
<?php endif; ?>