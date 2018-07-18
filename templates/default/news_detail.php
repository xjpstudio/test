<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<link rel="stylesheet" href="{tpl_path}style/news.css" type="text/css" />
<div class="wrap"> <?php echo get_ads(13);?> </div>
<div class="wrap"> 
  <!-- 当前位置 -->
  <div class="ui-tx-nav-bar"><a href="<?php echo ROOT_PATH;?>">首页</a> <?php echo $nav;?></div>
  <div class="news_main">
    <div class="news_left">
      <div class="news_detail">
        <div class="ui-tx-news-title"><?php echo $news->title;?></div>
        <div class="ui-tx-news-stitle">来源：<?php echo $news->source;?> &nbsp;&nbsp;&nbsp;&nbsp;作者：<?php echo $news->author;?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:fontZoom(16)">大</a> &nbsp; <a href="javascript:fontZoom(14)">中</a> &nbsp; <a href="javascript:fontZoom(12)">小</a>&nbsp;&nbsp;&nbsp;&nbsp;日期：<?php echo date('Y-m-d',$news->create_date);?>&nbsp;&nbsp;&nbsp;&nbsp;浏览：<span id="hits_num" data-url="<?php echo my_site_url(CTL_FOLDER.'ajax/add_news_hits');?>?id=<?php echo $news->id;?>">0</span> 次</div>
        <div class="ui-gb-reply">&nbsp;&nbsp;&nbsp;&nbsp;【导语】<?php echo $news->summary;?></div>
        <div id="ui-tx-content">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><?php echo $news->content;?></td>
            </tr>
          </table>
          <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare" style="width:100%; padding-top:10px"> <a class="bds_qzone"></a> <a class="bds_tsina"></a> <a class="bds_tqq"></a> <a class="bds_renren"></a> <a class="bds_t163"></a> <span class="bds_more"></span> <a class="shareCount"></a> </div>
        </div>
        <div class="ui-tx-top-s-border">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="50%" align="left">上一篇：<?php echo $content_link['prev'];?></td>
              <td  align="right">下一篇：<?php echo $content_link['next'];?></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="news_right">
      <div class="item itemr" style="margin-top:0">
        <h4>您或许会喜欢</h4>
        <ul class="pic_list" data-url="<?php echo my_site_url(CTL_FOLDER.'ajax/get_rgoods');?>">
          数据加载中...
        </ul>
      </div>
      <div class="adp"> <?php echo get_ads(15);?> </div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<div class="wrap" style=" padding-bottom:10px"> <?php echo get_ads(14);?> </div>
<script language="javascript">
$(function(){
	$.get($('#hits_num').attr('data-url')+'&t='+Math.random(),function(msg){
		$('#hits_num').html(msg);
	});
	$.get($('ul.pic_list').attr('data-url')+'?t='+Math.random(),function(msg){
		$('ul.pic_list').html(msg);
	});
})
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
