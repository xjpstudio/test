<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<script language="javascript">
var isMobile = {
	Android: function() {
		return navigator.userAgent.match(/Android/i) ? true : false;
	},
	BlackBerry: function() {
		return navigator.userAgent.match(/BlackBerry/i) ? true : false;
	},
	iOS: function() {
		return navigator.userAgent.match(/iPhone|iPad|iPod/i) ? true : false;
	},
	Windows: function() {
		return navigator.userAgent.match(/IEMobile/i) ? true : false;
	},
	any: function() {
		return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Windows());
	}
};
if( isMobile.any() ) 
{
	document.location.href='<?php echo site_url('m/home');?>';
}
</script>
<link rel="stylesheet" type="text/css" href="{tpl_path}style/index.css" />
<style type="text/css">
.shop_b{ border:1px solid #CBCBCB;margin:0 auto; margin-bottom:10px; margin-left:6px; background:#FFF}
.shop_b ul{ margin:0; padding:0; list-style:none}
.shop_b ul li{ border-left:1px solid #CBCBCB;  border-bottom:1px solid #CBCBCB; padding:10px; text-align:center; line-height:20px; width:104px; height:116px; float: left; display:inline; overflow:hidden}
.shop_b ul li img{ margin-bottom:6px}
</style>
<div id="content">
  <div class="pptm-content clearfix"> 
    <!--左边内容 -->
    <div class="pptm-layout-left">
      <div class="pptm-fixed-content">
        <div class="category">
          <div class="menu">
            <ul>
              <?php 
			$hot_cat = $hot_cat1 = get_cache('catalog');
			$i = 1;
			foreach($hot_cat as $row){
				if($row->parent_id == 0){
			?>
              <li class="item <?php if(($i+1) % 2 == 0){?> cur<?php }?>">
                <h3 class="item-hd"> <a href="<?php echo my_site_url('search');?>?cid=<?php echo $row->id;?>" title="<?php echo $row->cat_name;?>"><?php echo $row->cat_name;?></a> </h3>
                <p class="item-col itemCol1">
                  <?php $j = 1;
				foreach($hot_cat1 as $row1){
					if($row1->parent_id == $row->id){
				?>
                  <a href="<?php echo my_site_url('search');?>?cid=<?php echo $row1->id;?>" title="<?php echo $row1->cat_name;?>"><?php echo strcut($row1->cat_name,4);?></a>
                  <?php if($j >= 8) break;
				$j++;}}?>
                </p>
              </li>
              <?php $i++;}}?>
            </ul>
            <s class="menuMask"></s> </div>
            <div class="pptm-left-notice clearfix">
            <div class="ads"><?php echo get_ads(1);?></div>
            <div class="ads"><?php echo get_ads(2);?></div>
            <div class="ads"><?php echo get_ads(3);?></div>
            <div class="ads"><?php echo get_ads(4);?></div>
	
             </div>
          
        </div>
      </div>
    </div>
    <!-- 右边内容 -->
	<div class="pptm-layout-right1111">
    <div class="pptm-layout-right" style="padding-bottom:10px">
      <div id="slideshow" rel="auto-play">
        <div class="img"> <span>
          <?php foreach(get_cache('focus') as $row){?>
          <a href="<?php echo en_url($row->hplink);?>" target="_blank"><img border="0" alt="<?php echo $row->title;?>" src="<?php echo get_real_path($row->pic_path);?>" width="815" height="350" /></a>
          <?php }?>
          </span>
          <div class="pattern"></div>
          <div class="subpattern"></div>
        </div>
      </div>
     
    </div>
	<!-- 右右边内容 -->
	
	 <div class="pptm-left-notice clearfix">
           
            <div class="tab_info_focus" style="margin-top:5px">
              <h2 class="tabtitle"><span style="float:left">女装搭配</span></h2>
              <div class="tabcont">
                <ul>
                  <?php 
	foreach($news as $row){
	?>
                  <li><a href="<?php echo create_link($row->id);?>" target="_blank" title="<?php echo $row->title;?>"><b>·</b><?php echo strcut($row->title,23);?></a></li>
                  <?php }?>
                </ul>
              </div>
            </div>
   </div>
 </div>
 <div class="pptm-layout-right1111">
      <?php foreach($rdata as $v){?>
      <?php if(isset($v['item']['cat']) && $v['item']['cat'] == 2){?>
      <div class="pptm-right-sale clearfix">
        <div>
          <h3><?php echo $v['item']['title'];?></h3>
          <span class="more"><a href="<?php echo my_site_url(CTL_FOLDER.'shops');?>">更多...</a></span>
          <div class="clear"></div>
        </div>
        <div class="shop_b">
  <ul>
  <?php $j = 1;foreach($v['items'] as $row1){?>
  <li <?php if($j % 6 == 0){?>style="border-right:none;width:113px"<?php }?>>
  <a title="<?php echo $row1->title;?>" target="_blank" href="<?php echo my_site_url('shop/'.$row1->id);?>"><img rel="<?php echo base64_encode(get_real_path($row1->pic_path));?>" class="loading_80" alt="<?php echo $row1->title;?>" width="80" height="80" /><br><?php echo $row1->title;?></a>
  </li>
  <?php $j++;}?>
  </ul>
  <div class="clear"></div>
  </div>
      </div>
      <?php }else{?>
      <div class="pptm-right-sale clearfix">
        <div>
          <h3><?php echo $v['item']['title'];?></h3>
          <span class="more"><a href="<?php echo my_site_url(CTL_FOLDER.'search');?>?cid=<?php echo $v['item']['cid'];?>&q=<?php echo urlencode($v['item']['q']);?>&sp=<?php echo $v['item']['sp'];?>&ep=<?php echo $v['item']['ep'];?>&sorts=<?php echo $v['item']['sorts'];?>">更多...</a></span>
          <div class="clear"></div>
        </div>
        <ul class="sale-list">
          <?php foreach($v['items'] as $row){?>
          <?php if($this->config->item('rd_type') == 1){?>
          <li><a title="<?php echo $row->title;?>" class="pro" rel="nofollow" href="<?php echo my_site_url('clk/'.$row->id);?>" target="_blank"><img rel="<?php echo base64_encode(get_real_path($row->small_pic_path));?>" class="loading_230" alt="<?php echo $row->title;?>" width="230" height="230" /></a>
          <?php if($row->volume > 0){?>
            <div class="volume">月售 <?php echo $row->volume;?></div>
            <?php }?>
            <div class="desc">
            <?php if($row->dc_price > 0){?>
              <p class="price"><span class="lt">￥<?php echo $row->shop_price;?></span>&nbsp;&nbsp; 折扣价：<span class="h">￥<?php echo $row->dc_price;?></span></p>
              <?php }else{?>
              <p class="price">价格：<span class="h">￥<?php echo $row->shop_price;?></span></p>
              <?php }?>
              <a class="info" rel="nofollow" href="<?php echo my_site_url('clk/'.$row->id);?>" target="_blank" title="<?php echo $row->title;?>"><?php echo strcut($row->title,60);?></a> </div>
          </li>
          <?php }else{?>
          <li><a class="pro" title="<?php echo $row->title;?>" href="<?php echo my_site_url(CTL_FOLDER.'item/'.$row->id);?>" target="_blank"> <img rel="<?php echo base64_encode(get_real_path($row->small_pic_path));?>" class="loading_230" alt="<?php echo $row->title;?>" width="230" height="230" /></a>
          <?php if($row->volume > 0){?>
            <div class="volume">月售 <?php echo $row->volume;?></div>
            <?php }?>
            <div class="desc">
            <?php if($row->dc_price > 0){?>
              <p class="price"><span class="lt">￥<?php echo $row->shop_price;?></span>&nbsp;&nbsp; 折扣价：<span class="h">￥<?php echo $row->dc_price;?></span></p>
              <?php }else{?>
              <p class="price">价格：<span class="h">￥<?php echo $row->shop_price;?></span></p>
              <?php }?>
              <a class="info" href="<?php echo my_site_url(CTL_FOLDER.'item/'.$row->id);?>" target="_blank" title="<?php echo $row->title;?>"><?php echo strcut($row->title,60);?></a> </div>
          </li>
          <?php }?>
          <?php }?>
        </ul>
      </div>
      <?php }}?>
    </div>
    <div class="clear"></div>
  </div>
  <div class="clear"></div>
</div>
<div id="footer">
  <div id="copyright">
    <p> <a href="<?php echo base_url();?>">首页</a>
      <?php 
		  $i = 1;
		  foreach(get_cache('bot_nav') as $row){?>
      | <a title="<?php echo $row['title'];?>" href="<?php echo $row['url'];?>" target="<?php echo $row['target'];?>"><?php echo $row['title'];?></a>
      <?php 
		  if($i >= 20) break;
		  $i++;
		  }?>
    </p>
    <p><strong>友情链接：</strong>
      <?php foreach(get_cache('link') as $row){?>
      <a href="<?php echo $row->hplink;?>" target="_blank" title="<?php echo $row->title;?>"><?php echo $row->title;?></a>
      <?php }?>
    </p>
    <p><?php echo $this->config->item('sys_site_copyright');?>
      技术支持：<a href="http://bbs.soke5.com/" target="_blank">搜客淘宝客</a>
      <?php echo html_entity_decode($this->config->item('sys_tongji'),ENT_QUOTES);?> </p>
  </div>
</div>
<script language="javascript">
$(function(){
	$('li.item').hover(function(){
		$(this).addClass('hover');
	},function(){
		$(this).removeClass('hover');
	});
	$('img.loading_80').each(function(){
		$(this).attr('src',decode64($(this).attr('rel')));
	});
	$('img.loading_230').each(function(){
		$(this).attr('src',decode64($(this).attr('rel')));
	});
	var $backToTopTxt = "返回顶部";
	var $backToTopEle = $('<div class="backToTop"></div>').appendTo($("body")).text($backToTopTxt).attr("title", $backToTopTxt).click(function(){$("html, body").animate({ scrollTop: 0 }, 500);}); 				    var $backToTopFun = function() {
		var st = $(document).scrollTop();
		var winh = $(window).height();
		(st > 0)? $backToTopEle.show(): $backToTopEle.hide();    
		//IE6下的定位
		if (!window.XMLHttpRequest) {
			$backToTopEle.css("top", st + winh - 166);    
		}
	};
	$(window).bind("scroll", $backToTopFun);
	$(function() { $backToTopFun(); });
	$.get('<?php echo ROOT_PATH;?>task/cscvach56756_bat.php?t='+Math.random());
});
</script> 
<script type="text/javascript" src="{root_path}js/djin.js"></script>
<script type="text/javascript" src="{tpl_path}js/jquery.slider.js"></script> 
<script type="text/javascript" src="{tpl_path}js/base64.js"></script> 
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6688813" ></script> 
<script type="text/javascript" id="bdshell_js"></script> 
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
</body>
</html>