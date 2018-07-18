<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<style type="text/css">
.cat_box {
	width:970px;
	margin:0 auto;
	clear:both;
	overflow:hidden;
	background:#F8F8F8;
	padding:10px;
	margin-bottom:10px
}
.cat_box .cat_name {
	font-weight:bold;
	font-size:14px;
	width:80px;
	float:left;
	line-height:25px;
}
.cat_box .cat_list {
	width:880px;
	float: right;
}
.cat_box .cat_list a {
	line-height:25px;
	margin-right:10px;
	font-size:14px
}
.shop_b_nav{ height:25px; line-height:25px; font-weight:bold; font-size:14px}
.shop_b{ border:1px solid #CBCBCB; width:988px;margin:0 auto; margin-bottom:20px; background:#FFF}
.shop_b ul{ margin:0; padding:0; list-style:none}
.shop_b ul li{ border-right:1px solid #CBCBCB; border-bottom:1px solid #CBCBCB; padding:10px; text-align:center; line-height:20px; width:120px; height:120px; float: left; display:inline; overflow:hidden}
.shop_b ul li img{ margin-bottom:7px}
</style>
<?php $shop = get_cache('shop');?>
<div class="wrap"> <?php echo get_ads(39);?> </div>
<div class="wrap">
  <div class="ui-tx-nav-bar" style="margin-bottom:10px"><a href="<?php echo ROOT_PATH;?>">首页</a> &gt; 店铺导航</div>
</div>
<div class="wrap">
  <div class="cat_box" id="fix_bar">
    <div class="cat_name">店铺分类：</div>
    <div class="cat_list">
      <?php $i = 1;foreach($shop as $row){?>
      <a href="#b<?php echo $i;?>"><?php echo $row['cat_name'];?></a>
      <?php $i++;}?>
    </div>
    <div class="clear"></div>
  </div>
  <?php $i = 1;foreach($shop as $row){?>
  <a name="b<?php echo $i;?>"></a>
  <div class="shop_b_nav"><?php echo $row['cat_name'];?></div>
  <div class="shop_b">
  <ul>
  <?php $j = 1;foreach($row['items'] as $row1){?>
  <li <?php if($j % 7 == 0){?>style="border-right:none;width:122px"<?php }?>>
  <a title="<?php echo $row1->title;?>" target="_blank" href="<?php echo my_site_url('shop/'.$row1->id);?>"><img rel="<?php echo base64_encode(get_real_path($row1->pic_path));?>" class="loading_80" alt="<?php echo $row1->title;?>" width="80" height="80" /><br><?php echo $row1->title;?></a>
  </li>
  <?php $j++;}?>
  </ul>
  <div class="clear"></div>
  </div>
  <?php $i++;}?>
</div>
<script language="javascript">
$(function(){
	$('img.loading_80').each(function(){
		$(this).attr('src',decode64($(this).attr('rel')));
	});
});
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
<script type="text/javascript" src="{tpl_path}js/base64.js"></script>
<?php $this->load->view(TPL_FOLDER."footer");?>
