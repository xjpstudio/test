<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<link rel="stylesheet" href="{root_path}js/jquery/jquery-zoom/css/jquery.jqzoom.css" type="text/css" />
<link rel="stylesheet" href="{tpl_path}style/item.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="{tpl_path}style/user.css" />
<script type="text/javascript" src="{root_path}js/validator.js"></script>
<div class="wrap"> <?php echo get_ads(7);?> </div>
<div class="wrap">
  <div class="ui-tx-nav-bar" style="margin-bottom:10px; border-bottom:1px solid #E6E6E6"><a href="<?php echo ROOT_PATH;?>">首页</a> &gt; <a href="<?php echo my_site_url('sitemap');?>">商品分类</a><?php echo $nav;?> &gt; <?php echo $product->title;?></div>
</div>
<div class="wrap">
  <div class="goods_info">
    <div class="goods_info_l">
      <div class="ui-tx-small-pic-list">
        <ul>
          <li><a class="zoomThumbActive" href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '<?php echo base64_encode(get_real_path($product->big_pic_path));?>',largeimage: '<?php echo base64_encode(get_real_path($product->big_pic_path));?>'}"><img class="act base_load" width="60" height="60" rel="<?php echo base64_encode(get_real_path($product->big_pic_path));?>" alt="<?php echo $product->title;?>" /></a></li>
          <?php 
			  foreach($pic as $row){
			  ?>
          <li><a href='javascript:void(0);' rel="{gallery: 'gal1', smallimage: '<?php echo base64_encode(get_real_path($row->pic_path));?>',largeimage: '<?php echo base64_encode(get_real_path($row->pic_path));?>'}"><img class="base_load" rel="<?php echo base64_encode(get_real_path($row->pic_path));?>" width="60" height="60" alt="<?php echo $product->title;?>" /></a></li>
          <?php }?>
        </ul>
      </div>
      <div class="goods_info_img"> <a class="jqzoom" rel='gal1' href="<?php echo base64_encode(get_real_path($product->big_pic_path));?>"><img class="base_load" rel="<?php echo base64_encode(get_real_path($product->big_pic_path));?>" width="350" height="350" alt="<?php echo $product->title;?>" /></a> </div>
    </div>
    <div class="goods_info_r">
      <div class="goods_title"><a href="<?php echo site_url(CTL_FOLDER.'item/'.$product->id);?>"><?php echo $product->title;?></a></div>
      <img src="{tpl_path}images/baozhang.gif" />
      <ul>
      <?php if($product->dc_price > 0){?>
        <li class="price"><span class="discount">打折促销</span>：￥<b style="font-size:16px;"><?php echo $product->dc_price;?></b>元 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 原价：￥<font style=" text-decoration:line-through"><?php echo $product->shop_price;?></font> 元</li>
        <?php }else{?>
        <li class="price">价格：￥<b style="font-size:16px; color:#F00"><?php echo $product->shop_price;?></b> 元</li>
        <?php }?>
        <li>掌柜昵称：<?php echo $product->nick;?></li>
        <?php if($product->volume > 0){?>
        <li class="stocknum">最近成交：<b><?php echo $product->volume;?></b>笔</li>
        <?php }?>
        <li>浏览次数：<?php echo $product->hits;?> 次</li>
        <li class="price"><font color="#FF0000">温馨提示：实际成交价以淘宝上的价格为准。</font></li>
      </ul>
      <div class="go_buy"><div class="add_love" id="<?php echo $product->id;?>"><?php echo $product->love;?></div>
            <a href="<?php echo my_site_url(CTL_FOLDER.'clk/'.$product->id);?>" target="_blank" rel="nofollow"><img src="{tpl_path}images/go_buy.png" alt="购买商品" style="float:left;" /></a>
      <div class="clear"></div>
      </div>
      <div style="padding-top:15px; width:450px;" id="bdshare" class="bdshare_t bds_tools get-codes-bdshare"> <span class="bds_more">分享到：</span> <a class="bds_qzone">QQ空间</a> <a class="bds_tsina">新浪微博</a> <a class="bds_tqq">腾讯微博</a> <a class="bds_renren">人人网</a> <a class="bds_t163">网易微博</a></div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<div class="wrap">
  <div class="sidebar">
    <div class="end_ab_b">
      <h4 class="tit1">您或许还喜欢</h4>
      <ul class="imglist">
        <?php
	foreach($relate as $row){
	?>
        <li><a href="<?php echo my_site_url(CTL_FOLDER.'item/'.$row->id);?>"><img rel="<?php echo base64_encode(get_real_path($row->small_pic_path));?>" class="base_load" alt="<?php echo $row->title;?>" width="160" height="160" /></a>
          <p class="tc"><span class="cred fb"><?php if($row->dc_price > 0) echo format_curren($row->dc_price);else echo format_curren($row->shop_price);?></span>&nbsp;&nbsp;&nbsp;&nbsp;成交<span class="cblue fb"><?php echo $row->volume;?></span></p>
          <p class="tc"><a href="<?php echo my_site_url(CTL_FOLDER.'item/'.$row->id);?>" title="<?php echo $row->title;?>"><?php echo strcut($row->title,15);?></a></p>
        </li>
        <?php }?>
      </ul>
    </div>
  </div>
  <div class="main">
  <a name="item"></a>
    <ul class="ui-tx-tab-h" id="fix_bar">
      <li class="ui-tx-tab-h-active"><a href="#item">宝贝详情</a></li>
      <li><a href="#item">商品评论(<?php echo $com_num;?>)</a></li>
      <div class="clear"></div>
    </ul>
    <div class="ui-tx-product-content">
      <?php 
	if($props){
	?>
      <div class="ui-tx-props">
        <ul>
          <?php foreach($props as $k=>$v){
		if(is_array($v)) $v = implode(',',$v);
		?>
          <li title="<?php echo $v;?>"><?php echo $k;?>: <?php echo strcut($v,45);?></li>
          <?php }?>
          <div class="clear"></div>
        </ul>
      </div>
      <?php }?>
      <div style="padding:10px 0 10px 10px"><a data-type="10" biz-itemid="<?php echo $product->num_iid;?>" data-tmpl="720x220" data-tmplid="143" data-rd="1" data-style="2" href="#"></a></div>
      <div id="goods_desc" data-url="<?php echo my_site_url('ajax/get_desc/'.$product->id);?>">正努力加载商品描述...</div>
    </div>
    <div class="ui-tx-product-content">
    <?php if($this->config->item('com_is_open') == 2){?>
      <div class="ui-tx-tips-div" style="text-align:center">
          评论已关闭！
      </div>
    <?php }else{?>
    <div id="comment_form">
          <form action="<?php echo my_site_url('user/save_comment');?>" method="post" onsubmit="if(this.content.value == this.content.defaultValue) this.content.value = '';return Validator.Validate(this,3)">
            <textarea name="content" cols="70" rows="4" class="ui-tx-input" dataType="Limit" max="200" min="1" msg="填写有误" onblur="if(this.value == '') this.value = this.defaultValue;" onclick="if(this.value == this.defaultValue) this.value = '';" style="vertical-align:bottom; color:#999">你也可以随便来说点什么哦</textarea>
            <input type="submit" class="btn3" value="提交评论" style="vertical-align:bottom;" />
            <br>
            评论内容不超过200个字<?php if( ! $this->session->userdata('shop_user_name')){?>
            ，登录之后才能发布评论，请先<a href="<?php echo my_site_url(CTL_FOLDER.'login');?>?url=<?php echo urlencode(site_url('item/'.$product->id));?>" style="color:#F00">登录/注册</a>
            <?php }?>
            <input type="hidden" name="product_id" value="<?php echo $product->id;?>" />
            </form>
      </div>
    <?php }?>  
      <div id="comment_list">暂无评论...</div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('img.base_load').each(function(){
		$(this).attr('src',decode64($(this).attr('rel')));
	});
	$.get($('#goods_desc').attr('data-url'),function(msg){
		$('#goods_desc').html(msg);
		$("#goods_desc img").lazyload({
			placeholder : '{tpl_path}images/alpha.png',
			effect : "fadeIn"
		});
	});
	$('.ui-tx-tab-h li').each(function(i){
		$(this).click(function(){
			$(this).addClass('ui-tx-tab-h-active').siblings('li').removeClass('ui-tx-tab-h-active');
			$('.ui-tx-product-content').eq(i).show().siblings('.ui-tx-product-content').hide();
		});
	});
	$('.jqzoom').jqzoom({
		zoomType: 'standard',
		lens:true,
		preloadImages: false,
		alwaysOn:false,
		title:false,
		zoomWidth:350,
		zoomHeight:350
	});
	get_comment(1);
});
function get_comment(p)
{
	if( ! p) return;
	$('#comment_list').html('数据加载中...');
	$.ajax({
		url:'<?php echo my_site_url(CTL_FOLDER.'ajax/get_comment');?>',
		type:'POST',
		data:'curr_page='+p+'&product_id=<?php echo $product->id;?>',
		success:function(msg)
		{
			$('#comment_list').html(msg);
		}
	});
}
var FixedBox=function(el){
	this.element=el;
	this.BoxY=getXY(this.element).y;
}
FixedBox.prototype={
	setCss:function(){
		var windowST=(document.compatMode && document.compatMode!="CSS1Compat")? document.body.scrollTop:document.documentElement.scrollTop||window.pageYOffset;
		if(windowST>this.BoxY){
			this.element.style.cssText="position:fixed; top:0px;";
		}else{
			this.element.style.cssText="";
		}
	}
};

//添加事件
function addEvent(elm, evType, fn, useCapture) {
	if (elm.addEventListener) {
		elm.addEventListener(evType, fn, useCapture);
	return true;
	}else if (elm.attachEvent) {
		var r = elm.attachEvent('on' + evType, fn);
		return r;
	}
	else {
		elm['on' + evType] = fn;
	}
}
//获取元素的XY坐标；
function getXY(el) {
	return document.documentElement.getBoundingClientRect && (function() {//取元素坐标，如元素或其上层元素设置position relative
		var pos = el.getBoundingClientRect();
		return { x: pos.left + document.documentElement.scrollLeft, y: pos.top + document.documentElement.scrollTop };
	})() || (function() {
		var _x = 0, _y = 0;
		do {
			_x += el.offsetLeft;
			_y += el.offsetTop;
		} while (el = el.offsetParent);
		return { x: _x, y: _y };
	})();
}
//实例化；
var divA=new FixedBox(document.getElementById("fix_bar"));
addEvent(window,"scroll",function(){
	divA.setCss();
});
</script> 
<script src="{tpl_path}js/lazy_load.js" type="text/javascript"></script>
<script src="{root_path}js/jquery/jquery-zoom/js/jquery.jqzoom-core.js" type="text/javascript" charset="gb2312"></script> 
<script type="text/javascript" src="{tpl_path}js/base64.js"></script>
<?php $this->load->view(TPL_FOLDER."footer");?>
