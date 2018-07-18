<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<link rel="stylesheet" type="text/css" href="{tpl_path}style/list.css" />
<div id="content">
  <div class="wrap" style=" padding-top:5px"> <?php echo get_ads(5);?> </div>
  <div class="wrap">
    <div class="ui-tx-nav-bar"><a href="<?php echo ROOT_PATH;?>">首页</a> &gt; <a href="<?php echo my_site_url('sitemap');?>">商品分类</a><?php echo $nav;?>&nbsp;&nbsp;&nbsp;&nbsp;搜索到相关商品 <b class="cred"><?php echo format_num($total);?> </b>件</div>
    <div class="list_left">
      <h3>商品分类</h3>
      <ul class="sideCategory clearfix">
        <?php foreach(get_cache('catalog') as $row){
			if($row->parent_id == 0){
		?>
        <li><a href="?cid=<?php echo $row->id;?>" title="<?php echo $row->cat_name;?>"><?php echo strcut($row->cat_name,15);?></a></li>
        <?php }}?>
      </ul>
      <div class="ads"><?php echo get_ads(16);?></div>
      <div class="ads"><?php echo get_ads(17);?></div>
      <div class="ads"><?php echo get_ads(18);?></div>
      <div class="ads" style="margin-bottom:5px"><?php echo get_ads(19);?></div>
      <h3>最新资讯</h3>
      <ul class="sideCategory clearfix">
        <?php foreach($news as $row){?>
        <li><a href="<?php echo create_link($row->id);?>" target="_blank" title="<?php echo $row->title;?>"><?php echo strcut($row->title,10);?></a></li>
        <?php }?>
      </ul>
    </div>
    <div class="main">
      <div class="condition">
        <ul>
          <?php $cids = create_query('cid');
	  if($cids) $cids = '&'.$cids;
	if(isset($subc) && $subc){?>
          <li class="clearfix">
            <label>商品分类：</label>
            <div class="ly_list">
              <?php foreach($subc as $row){?>
              <a href="?cid=<?php echo $row->id;?><?php echo $cids;?>" <?php if(isset($get['cid']) && $row->id == $get['cid']){?> class="onbg"<?php }?>><?php echo $row->cat_name;?></a>
              <?php }?>
            </div>
          </li>
          <?php }?>
          <?php $cids = create_query('p');
	  if($cids) $cids = '&'.$cids; ?>
          <li class="clearfix">
            <label>价格范围：</label>
            <div class="ly_list"> <a href="?p=0<?php echo $cids;?>" <?php if( ! (isset($get['p']) && $get['p'])){?> class="onbg"<?php }?>>不限</a>
              <?php foreach($this->config->item('price_range') as $v){?>
              <a href="?p=<?php echo $v['id'];?><?php echo $cids;?>" <?php if(isset($get['p']) && $v['id'] == $get['p']){?> class="onbg"<?php }?>><?php echo $v['t'];?></a>
              <?php }?>
            </div>
          </li>
          <?php 
	  $cids = create_query('sorts');
	  if($cids) $cids = '&'.$cids;
	  ?>
          <li class="clearfix">
            <label>商品排序：</label>
            <div class="ly_list"> <a href="?sorts=<?php echo $cids;?>" <?php if( ! isset($get['sorts']) || ! $get['sorts']){?> class="onbg"<?php }?>>不限</a>
              <?php if(isset($get['sorts']) && $get['sorts'] == 'pd'){?>
              <a>价格由高到低 <img src="{tpl_path}images/sort_down_on.gif" alt="价格由高到低" /></a>
              <?php }else{?>
              <a title="价格由高到低" href="?sorts=pd<?php echo $cids;?>">价格由高到低 <img src="{tpl_path}images/sort_down.gif" alt="价格由高到低" /> </a>
              <?php }?>
              <?php if(isset($get['sorts']) && $get['sorts']== 'p'){?>
              <a>价格由低到高 <img src="{tpl_path}images/sort_up_on.gif" alt="价格由低到高" /></a>
              <?php }else{?>
              <a title="价格由低到高" href="?sorts=p<?php echo $cids;?>">价格由低到高 <img src="{tpl_path}images/sort_up.gif" alt="价格由低到高" /> </a>
              <?php }?>
              <?php if(isset($get['sorts']) && $get['sorts'] == 'd'){?>
              <a>销量由高到低 <img src="{tpl_path}images/sort_down_on.gif" alt="销量由高到低" /></a>
              <?php }else{?>
              <a title="销量由高到低" href="?sorts=d<?php echo $cids;?>">销量由高到低 <img src="{tpl_path}images/sort_down.gif" alt="销量由高到低" /> </a>
              <?php }?>
            </div>
          </li>
          <li class="clearfix">
            <label>商品搜索：</label>
            <div class="ly_list">
              <form action="<?php echo my_site_url(CTL_FOLDER.'search');?>" onsubmit="return check_goods_search(this)" style="display:inline">
                关键词：
                <input type="text" name="q" class="tx-input"  maxlength="50" size="30" <?php if(isset($get['q'])){?> value="<?php echo $get['q'];?>"<?php }?>  />
                &nbsp; 
                价格：
                <input type="text" name="sp" class="tx-input"  maxlength="10" size="5" <?php if(isset($get['sp'])){?> value="<?php echo $get['sp'];?>"<?php }?>  />
                -
                <input type="text" name="ep" class="tx-input"  maxlength="10" size="5"  <?php if(isset($get['ep'])){?> value="<?php echo $get['ep'];?>"<?php }?> />
                &nbsp;
                <input type="image" src="{tpl_path}images/ss.gif" alt="搜索" style="vertical-align: middle"/>
                <?php if(isset($get['cid'])){?>
                <input type="hidden" name="cid" value="<?php echo $get['cid'];?>" />
                <?php }?>
                <?php if(isset($get['sorts'])){?>
                <input type="hidden" name="sorts" value="<?php echo $get['sorts'];?>" />
                <?php }?>
                <?php if(isset($get['p'])){?>
                <input type="hidden" name="p" value="<?php echo $get['p'];?>" />
                <?php }?>
              </form>
            </div>
          </li>
        </ul>
      </div>
      <div class="ui-tx-page"><?php echo $paginate;?></div>
      <div class="pptm-right-sale clearfix">
        <ul class="sale-list">
          <?php foreach($query as $row){?>
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
              <a title="<?php echo $row->title;?>" class="info" rel="nofollow" href="<?php echo my_site_url('clk/'.$row->id);?>" target="_blank"><?php echo strcut($row->title,60);?></a> </div>
          </li>
          <?php }else{?>
          <li><a title="<?php echo $row->title;?>" class="pro" href="<?php echo my_site_url('item/'.$row->id);?>" target="_blank"> <img rel="<?php echo base64_encode(get_real_path($row->small_pic_path));?>" class="loading_230" alt="<?php echo $row->title;?>" width="230" height="230" /></a>
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
        </ul>
        <?php if( ! $query){?>
        <div style="text-align:center; padding:10px; color:#F00; font-size:14px">很抱歉，没有你要找的商品。</div>
        <?php }?>
      </div>
      <div class="ui-tx-page"><?php echo $paginate;?></div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<script language="javascript">
function check_goods_search(o)
{
	var p_s = o.sp.value;
	var p_e = o.ep.value;
	var reg = new RegExp(/^\d+(\.\d+)?$/);
	if(p_s != '')
	{
		if( ! reg.test(p_s))
		{
			alert('起始价格有误，请重新填写');
			return false;
		}
	}
	if(p_e != '')
	{
		if( ! reg.test(p_e))
		{
			alert('结束价格有误，请重新填写');
			return false;
		}
	}
	if(p_s != '' && p_e != '')
	{
		if(parseInt(p_s) > parseInt(p_e))
		{
			alert('起始价格不能大于结束价格');
			return false;
		}
	}
}
$(function(){
	$('img.loading_230').each(function(){
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
