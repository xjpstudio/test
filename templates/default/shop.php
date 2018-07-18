<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<style type="text/css">
.shop_top {
	width:968px;
	margin:0 auto;
	margin-bottom:15px;
	padding:10px;
	border-top-width:3px;
}
.shop_top .lpic {
	width:150px;
	float:left;
	overflow:hidden;
	text-align:center
}
.shop_top .lpic a{ font-size:14px}
.shop_top .relate_shop {
	width:724px;
	float: right;
	overflow:hidden;
}
#shop_items_nav {
	padding:0px;
	width:100%;
	height:25px;
	font-weight:bold;
	border-bottom:2px solid #FF6F02
}
#shop_items_nav li {
	line-height:25px;
	height:25px;
	vertical-align:middle;
	width:90px;
	text-align:center;
	overflow:hidden;
	color: #FFF;
	background:#FF6F02;
	margin-bottom:10px
}
.sale-list {
	width:990px;
	padding-top:5px;
}
.sale-list li {
	float:left;
	margin:5px 5px 10px 5px;
	display:inline;
	position:relative;
	border:1px solid #DFDFDF;
	padding:7px;
	text-align:center;
	width:220px;
	height:280px;
	overflow:hidden
}
.sale-list li.bd {
	border:1px solid #999;
}
.sale-list .pro {
	display:block;
	width:220px;
	height:220px;
	overflow:hidden;
}
.sale-list .desc {
	width:220px;
	overflow:hidden;
	color:#000000;
}
.sale-list .volume {
	background:rgba(135, 113, 90, 0.8);
	background:transparent\9;
filter:progid:DXImageTransform.Microsoft.gradient(startcolorstr=#C887715a, endcolorstr=#C887715a);
*zoom:1;
	width:220px;
	height:23px;
	overflow:hidden;
	position:absolute;
	top:204px;
	left:7px;
	color:#FFF
}
.sale-list .price {
	line-height:23px;
	width:220px;
	height:23px;
	overflow:hidden;
	padding-left:3px;
	text-overflow:ellipsis;
	white-space:nowrap;
	color:#000000;
	text-decoration:none;
	display:block;
	margin-top:5px
}
.sale-list .price .h {
	color:#F00;
	font-weight:bold
}
.sale-list .price .lt {
	text-decoration:line-through
}
.sale-list .info {
	line-height:23px;
	width:220px;
	height:23px;
	overflow:hidden;
	padding-left:3px;
	text-overflow:ellipsis;
	white-space:nowrap;
	color:#000000;
	text-decoration:none;
	display:block;
}
</style>
<div class="wrap"> <?php echo get_ads(39);?> </div>
<div class="wrap">
  <div class="ui-tx-nav-bar" style="margin-bottom:10px"><a href="<?php echo ROOT_PATH;?>">首页</a> &gt; <a href="<?php echo my_site_url('shops');?>">店铺导航</a> &gt; <?php echo $shop->title;?></div>
</div>
<div class="wrap">
  <div class="shop_top">
    <div class="lpic"><a title="<?php echo $shop->title;?>" data-type="1" data-style="2" biz-sellerid="<?php echo $shop->sid;?>" data-tmpl="140x190" data-tmplid="3" rel="nofollow" href="#"></a></div>
      <div class="relate_shop"><a data-type="12" data-style="2" biz-sellerid="<?php echo $shop->sid;?>" rel="nofollow" href="#" data-tmpl="720x200" data-tmplid="145"></a>
      </div>
    <div class="clear"></div>
  </div>
  <ul id="shop_items_nav">
    <li>店铺商品</li>
  </ul>
  <ul class="sale-list">
    <?php foreach($query as $row){?>
    <?php if($this->config->item('rd_type') == 1){?>
    <li><a title="<?php echo $row->title;?>" class="pro" rel="nofollow" href="<?php echo my_site_url('clk/'.$row->id);?>" target="_blank"><img rel="<?php echo base64_encode(get_real_path($row->small_pic_path));?>" class="loading_220" alt="<?php echo $row->title;?>" width="220" height="220" /></a>
      <?php if($row->volume > 0){?>
            <div class="volume">月售 <?php echo $row->volume;?></div>
            <?php }?>
      <div class="desc">
        <?php if($row->dc_price > 0){?>
        <p class="price"><span class="lt">￥<?php echo $row->shop_price;?></span>&nbsp;&nbsp; 折扣价：<span class="h">￥<?php echo $row->dc_price;?></span></p>
        <?php }else{?>
        <p class="price">价格：<span class="h">￥<?php echo $row->shop_price;?></span></p>
        <?php }?>
        <a title="<?php echo $row->title;?>" class="info" rel="nofollow" href="<?php echo my_site_url('clk/'.$row->id);?>" target="_blank"><?php echo strcut($row->title,60);?></a> </div>
    </li>
    <?php }else{?>
    <li><a title="<?php echo $row->title;?>" class="pro" href="<?php echo my_site_url('item/'.$row->id);?>" target="_blank"> <img rel="<?php echo base64_encode(get_real_path($row->small_pic_path));?>" class="loading_220" alt="<?php echo $row->title;?>" width="220" height="220" /></a>
    <?php if($row->volume > 0){?>
            <div class="volume">月售 <?php echo $row->volume;?></div>
            <?php }?>
      <div class="desc">
        <?php if($row->dc_price > 0){?>
        <p class="price"><span class="lt">￥<?php echo $row->shop_price;?></span>&nbsp;&nbsp; 折扣价：<span class="h">￥<?php echo $row->dc_price;?></span></p>
        <?php }else{?>
        <p class="price">价格：<span class="h">￥<?php echo $row->shop_price;?></span></p>
        <?php }?>
        <a class="info" href="<?php echo my_site_url('item/'.$row->id);?>" target="_blank" title="<?php echo $row->title;?>"><?php echo strcut($row->title,60);?></a> </div>
    </li>
    <?php }?>
    <?php }?>
    <div class="clear"></div>
  </ul>
  <?php if( ! $query){?>
  <div style="text-align:center; padding:10px; color:#F00; font-size:14px">很抱歉，该店铺暂无商品。</div>
  <?php }?>
  <div class="ui-tx-page" style="text-align: center"><?php echo $paginate;?></div>
</div>
<script language="javascript">
$(function(){
	$('img.loading_220').each(function(){
		$(this).attr('src',decode64($(this).attr('rel')));
	});
	$('ul.sale-list li').hover(function(){
		$(this).addClass('bd');
	},function(){
		$(this).removeClass('bd');
	});
});
</script> 
<script type="text/javascript" src="{tpl_path}js/base64.js"></script>
<?php $this->load->view(TPL_FOLDER."footer");?>
