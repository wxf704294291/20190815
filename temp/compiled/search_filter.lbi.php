<div class="filter-wrap">
    <div class="filter-sort">
        <a href="search.php?keywords=<?php echo $this->_var['pager']['search']['keywords']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&price_min=<?php echo $this->_var['pager']['search']['price_min']; ?>&price_max=<?php echo $this->_var['pager']['search']['price_max']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=goods_id&is_ship=<?php echo $this->_var['pager']['search']['is_ship']; ?>&order=<?php if ($this->_var['pager']['search']['sort'] == 'goods_id' && $this->_var['pager']['search']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?><?php if ($this->_var['cou_id']): ?>&cou_id=<?php echo $this->_var['cou_id']; ?><?php endif; ?>" class="<?php if ($this->_var['pager']['search']['sort'] == 'goods_id'): ?>curr<?php endif; ?>"><?php echo $this->_var['lang']['default']; ?><i class="iconfont <?php if ($this->_var['pager']['search']['sort'] == 'goods_id' && $this->_var['pager']['search']['order'] == 'DESC'): ?>icon-arrow-down<?php else: ?>icon-arrow-up<?php endif; ?>"></i></a>
        <a href="search.php?keywords=<?php echo $this->_var['pager']['search']['keywords']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&price_min=<?php echo $this->_var['pager']['search']['price_min']; ?>&price_max=<?php echo $this->_var['pager']['search']['price_max']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=sales_volume&is_ship=<?php echo $this->_var['pager']['search']['is_ship']; ?>&order=<?php if ($this->_var['pager']['search']['sort'] == 'sales_volume' && $this->_var['pager']['search']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?><?php if ($this->_var['cou_id']): ?>&cou_id=<?php echo $this->_var['cou_id']; ?><?php endif; ?>" class="<?php if ($this->_var['pager']['search']['sort'] == 'sales_volume'): ?>curr<?php endif; ?>"><?php echo $this->_var['lang']['sales_volume']; ?><i class="iconfont <?php if ($this->_var['pager']['search']['sort'] == 'sales_volume' && $this->_var['pager']['search']['order'] == 'DESC'): ?>icon-arrow-down<?php else: ?>icon-arrow-up<?php endif; ?>"></i></a>
        <a href="search.php?keywords=<?php echo $this->_var['pager']['search']['keywords']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&price_min=<?php echo $this->_var['pager']['search']['price_min']; ?>&price_max=<?php echo $this->_var['pager']['search']['price_max']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=last_update&is_ship=<?php echo $this->_var['pager']['search']['is_ship']; ?>&order=<?php if ($this->_var['pager']['search']['sort'] == 'last_update' && $this->_var['pager']['search']['order'] == 'DESC'): ?>ASC<?php else: ?>DESC<?php endif; ?><?php if ($this->_var['cou_id']): ?>&cou_id=<?php echo $this->_var['cou_id']; ?><?php endif; ?>" class="<?php if ($this->_var['pager']['search']['sort'] == 'last_update'): ?>curr<?php endif; ?>"><?php echo $this->_var['lang']['is_new']; ?><i class="iconfont <?php if ($this->_var['pager']['search']['sort'] == 'last_update' && $this->_var['pager']['search']['order'] == 'DESC'): ?>icon-arrow-down<?php else: ?>icon-arrow-up<?php endif; ?>"></i></a>
        <a href="search.php?keywords=<?php echo $this->_var['pager']['search']['keywords']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&price_min=<?php echo $this->_var['pager']['search']['price_min']; ?>&price_max=<?php echo $this->_var['pager']['search']['price_max']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=comments_number&is_ship=<?php echo $this->_var['pager']['search']['is_ship']; ?>&order=<?php if ($this->_var['pager']['search']['sort'] == 'comments_number' && $this->_var['pager']['search']['order'] == 'ASC'): ?>DESC<?php else: ?>ASC<?php endif; ?><?php if ($this->_var['cou_id']): ?>&cou_id=<?php echo $this->_var['cou_id']; ?><?php endif; ?>#goods_list" class="<?php if ($this->_var['pager']['search']['sort'] == 'comments_number'): ?>curr<?php endif; ?>"><?php echo $this->_var['lang']['Comment_number']; ?><i class="iconfont <?php if ($this->_var['pager']['search']['sort'] == 'comments_number' && $this->_var['pager']['search']['order'] == 'DESC'): ?>icon-arrow-down<?php else: ?>icon-arrow-up<?php endif; ?>"></i></a>
        <a href="search.php?keywords=<?php echo $this->_var['pager']['search']['keywords']; ?>&display=<?php echo $this->_var['pager']['display']; ?>&price_min=<?php echo $this->_var['pager']['search']['price_min']; ?>&price_max=<?php echo $this->_var['pager']['search']['price_max']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=shop_price&is_ship=<?php echo $this->_var['pager']['search']['is_ship']; ?>&order=<?php if ($this->_var['pager']['search']['sort'] == 'shop_price' && $this->_var['pager']['search']['order'] == 'ASC'): ?>DESC<?php else: ?>ASC<?php endif; ?><?php if ($this->_var['cou_id']): ?>&cou_id=<?php echo $this->_var['cou_id']; ?><?php endif; ?>" class="<?php if ($this->_var['pager']['search']['sort'] == 'shop_price'): ?>curr<?php endif; ?>"><?php echo $this->_var['lang']['price']; ?><i class="iconfont <?php if ($this->_var['pager']['search']['sort'] == 'shop_price' && $this->_var['pager']['search']['order'] == 'DESC'): ?>icon-arrow-down<?php else: ?>icon-arrow-up<?php endif; ?>"></i></a>
    </div>
    <div class="filter-range">
        <div class="fprice">
            <form method="GET" class="sort" name="listform" action="">
                <div class="fP-box">
                    <input type="text" name="price_min" class="f-text price-min" autocomplete="off" maxlength="6" id="price-min" placeholder="￥" value="<?php if ($this->_var['price_min']): ?><?php echo $this->_var['price_min']; ?><?php endif; ?>">
                    <span>&nbsp;~&nbsp;</span>
                    <input type="text" name="price_max" class="f-text price-max" autocomplete="off" maxlength="6" id="price-max" value="<?php if ($this->_var['price_max']): ?><?php echo $this->_var['price_max']; ?><?php endif; ?>" placeholder="￥">
                </div>
                <div class="fP-expand">
                    <a class="ui-btn-s ui-btn-clear" href="javascript:void(0);" id="clear_price"><?php echo $this->_var['lang']['clear']; ?></a>
                    <a href="javascript:void(0);" class="ui-btn-s ui-btn-s-primary ui-btn-submit"><?php echo $this->_var['lang']['assign']; ?></a>
                </div>
                <input type="hidden" name="keywords" value="<?php echo $this->_var['pager']['search']['keywords']; ?>" />
                <input type="hidden" name="display" value="<?php echo $this->_var['pager']['display']; ?>" id="display" />
                <input type="hidden" name="is_ship" value="<?php echo $this->_var['pager']['search']['is_ship']; ?>" />
                <input type="hidden" name="sort" value="<?php echo $this->_var['pager']['search']['sort']; ?>" />
                <input type="hidden" name="order" value="<?php echo $this->_var['pager']['search']['order']; ?>" />
            </form> 
        </div>
        
        <div class="fcheckbox">
                <div class="checkbox_items">
                <div class="checkbox_item <?php if ($this->_var['pager']['search']['is_ship'] == 'is_shipping'): ?>checkbox-checked<?php endif; ?>">
                    <input type="checkbox" name="fk-type" class="ui-checkbox" value="" id="store-checkbox-011" <?php if ($this->_var['pager']['search']['is_ship'] == 'is_shipping'): ?>checked="checked"<?php endif; ?>>
                    <label class="ui-label" for="store-checkbox-011"><?php echo $this->_var['lang']['Free_shipping']; ?></label>
                    <i id="input-i1" rev="search.php?keywords=<?php echo $this->_var['pager']['search']['keywords']; ?><?php if ($this->_var['cou_id']): ?>&cou_id=<?php echo $this->_var['cou_id']; ?><?php endif; ?>&display=<?php echo $this->_var['pager']['display']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=<?php echo $this->_var['pager']['search']['sort']; ?>&is_ship=is_shipping<?php if ($this->_var['pager']['search']['self_support'] == 1): ?>&is_self=1<?php endif; ?><?php if ($this->_var['pager']['search']['have'] == 1): ?>&have=1<?php endif; ?>"></i>
                    <i id="input-i2" rev="search.php?keywords=<?php echo $this->_var['pager']['search']['keywords']; ?><?php if ($this->_var['cou_id']): ?>&cou_id=<?php echo $this->_var['cou_id']; ?><?php endif; ?>&display=<?php echo $this->_var['pager']['display']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=<?php echo $this->_var['pager']['search']['sort']; ?>&order=<?php echo $this->_var['pager']['search']['order']; ?><?php if ($this->_var['pager']['search']['self_support'] == 1): ?>&is_self=1<?php endif; ?><?php if ($this->_var['pager']['search']['have'] == 1): ?>&have=1<?php endif; ?>"></i>
                </div>
                <div class="checkbox_item <?php if ($this->_var['pager']['search']['self_support'] == 1): ?>checkbox-checked<?php endif; ?>">
                    <input type="checkbox" name="fk-type" class="ui-checkbox" value="" id="store-checkbox-012" <?php if ($this->_var['pager']['search']['self_support'] == 1): ?>checked="checked"<?php endif; ?>>
                    <label class="ui-label" for="store-checkbox-012"><?php echo $this->_var['lang']['Self_goods']; ?></label>
                    <i id="input-i1" rev="search.php?keywords=<?php echo $this->_var['pager']['search']['keywords']; ?><?php if ($this->_var['cou_id']): ?>&cou_id=<?php echo $this->_var['cou_id']; ?><?php endif; ?>&display=<?php echo $this->_var['pager']['display']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=<?php echo $this->_var['pager']['search']['sort']; ?>&is_self=1<?php if ($this->_var['pager']['search']['is_ship'] == 'is_shipping'): ?>&is_ship=is_shipping<?php endif; ?><?php if ($this->_var['pager']['search']['have'] == 1): ?>&have=1<?php endif; ?>"></i>
                    <i id="input-i2" rev="search.php?keywords=<?php echo $this->_var['pager']['search']['keywords']; ?><?php if ($this->_var['cou_id']): ?>&cou_id=<?php echo $this->_var['cou_id']; ?><?php endif; ?>&display=<?php echo $this->_var['pager']['display']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=<?php echo $this->_var['pager']['search']['sort']; ?>&order=<?php echo $this->_var['pager']['search']['order']; ?><?php if ($this->_var['pager']['search']['is_ship'] == 'is_shipping'): ?>&is_ship=is_shipping<?php endif; ?><?php if ($this->_var['pager']['search']['have'] == 1): ?>&have=1<?php endif; ?>"></i>
                </div>
                <div class="checkbox_item <?php if ($this->_var['pager']['search']['have'] == 1): ?>checkbox-checked<?php endif; ?>">
                    <input type="checkbox" name="fk-type" class="ui-checkbox" value="" id="store-checkbox-012" <?php if ($this->_var['pager']['search']['have'] == 1): ?>checked="checked"<?php endif; ?>>
                    <label class="ui-label" for="store-checkbox-013"><?php echo $this->_var['lang']['Only_have_inventory']; ?></label>
                    <i id="input-i1" rev="search.php?keywords=<?php echo $this->_var['pager']['search']['keywords']; ?><?php if ($this->_var['cou_id']): ?>&cou_id=<?php echo $this->_var['cou_id']; ?><?php endif; ?>&display=<?php echo $this->_var['pager']['display']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=<?php echo $this->_var['pager']['search']['sort']; ?>&have=1<?php if ($this->_var['pager']['search']['is_ship'] == 'is_shipping'): ?>&is_ship=is_shipping<?php endif; ?><?php if ($this->_var['pager']['search']['self_support'] == 1): ?>&is_self=1<?php endif; ?>"></i>
                    <i id="input-i2" rev="search.php?keywords=<?php echo $this->_var['pager']['search']['keywords']; ?><?php if ($this->_var['cou_id']): ?>&cou_id=<?php echo $this->_var['cou_id']; ?><?php endif; ?>&display=<?php echo $this->_var['pager']['display']; ?>&price_min=<?php echo $this->_var['price_min']; ?>&price_max=<?php echo $this->_var['price_max']; ?>&page=<?php echo $this->_var['pager']['page']; ?>&sort=<?php echo $this->_var['pager']['search']['sort']; ?>&order=<?php echo $this->_var['pager']['search']['order']; ?><?php if ($this->_var['pager']['search']['is_ship'] == 'is_shipping'): ?>&is_ship=is_shipping<?php endif; ?><?php if ($this->_var['pager']['search']['self_support'] == 1): ?>&is_self=1<?php endif; ?>"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="filter-right">
        <?php if (! $this->_var['category_load_type']): ?>
        <div class="button-page">
            <span class="pageState"><span><?php echo $this->_var['pager']['page']; ?></span>/<?php echo $this->_var['pager']['page_count']; ?></span>
            <a href="<?php if ($this->_var['pager']['page_prev']): ?><?php echo $this->_var['pager']['page_prev']; ?><?php else: ?>javascript:void(0);<?php endif; ?>"<?php if ($this->_var['pager']['page_prev']): ?> class="page page_prev"<?php endif; ?> title="<?php echo $this->_var['lang']['page_prev']; ?>"><i class="iconfont icon-left"></i></a>
            <a href="<?php if ($this->_var['pager']['page_next']): ?><?php echo $this->_var['pager']['page_next']; ?><?php else: ?>javascript:void(0);<?php endif; ?>"<?php if ($this->_var['pager']['page_next']): ?> class="page page_next"<?php endif; ?> title="<?php echo $this->_var['lang']['page_next']; ?>"><i class="iconfont icon-right"></i></a>
        </div>
        <?php endif; ?>
        <?php if ($this->_var['dwt_filename'] != 'history_list'): ?> 
        <div class="styles">
            <ul class="items" ectype="fsortTab">
                <li class="item current" data-type="large"><a href="javascript:void(0)" title="<?php echo $this->_var['lang']['big_pic']; ?><?php echo $this->_var['lang']['pattern']; ?>"><span class="iconfont icon-switch-grid"></span><?php echo $this->_var['lang']['big_pic']; ?></a></li>
                <li class="item" data-type="samll"><a href="javascript:void(0)" title="<?php echo $this->_var['lang']['Small_pic']; ?><?php echo $this->_var['lang']['pattern']; ?>"><span class="iconfont icon-switch-list"></span><?php echo $this->_var['lang']['Small_pic']; ?></a></li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</div>