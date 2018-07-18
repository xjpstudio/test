<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<link rel="stylesheet" href="{tpl_path}style/news.css" type="text/css" />
<div class="wrap"> <?php echo get_ads(11);?> </div>
<div class="wrap">
  <div class="ui-tx-nav-bar"><a href="<?php echo ROOT_PATH;?>">首页</a> <?php echo $nav;?></div>
  <div class="news_main">
    <div class="news_left">
      <div class="list-box">
       <?php 
	   $i = 1;
	foreach($news as $row){
	?>
        <div class="list-item <?php if($i == 1){?>first<?php }?>">
          <h3><a target="_blank" href="<?php echo create_link($row->id);?>"><?php echo $row->title;?></a></h3>
          <ul>
            <li>点击数：<em><?php echo $row->hits;?>次</em></li>
            <li>发表时间：<?php echo date('Y-m-d',$row->create_date);?></li>
          </ul>
          <p class="abstract"><?php echo strcut($row->summary,100);?> <a target="_blank" href="<?php echo create_link($row->id);?>">查看全文</a></p>
          <?php if($row->pic_path){?>
          <div class="pic"><a target="_blank" href="<?php echo create_link($row->id);?>"><img border="0" src="{tpl_path}images/common/loading.gif" class="loading_500" rel="<?php echo base64_encode(get_real_path($row->pic_path));?>" /></a></div>
          <?php }?>
        </div>
        <?php $i++;}?>
         <?php if( ! $news){?><p style="text-align:center; padding:10px">暂无...</p><?php }?>
      </div>
      <div class="ui-tx-page"><?php echo $paginate;?></div>
    </div>
    <div class="news_right">
      <div class="item itemr" style="margin-top:0">
        <h4>您或许会喜欢</h4>
        <ul class="pic_list" data-url="<?php echo my_site_url(CTL_FOLDER.'ajax/get_rgoods');?>">
          数据加载中...
        </ul>
      </div>
      <div class="adp">
      <?php echo get_ads(21);?>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<div class="wrap" style=" padding-bottom:10px"> <?php echo get_ads(12);?> </div>
<script language="javascript">
$(function(){
	$.get($('ul.pic_list').attr('data-url')+'?t='+Math.random(),function(msg){
		$('ul.pic_list').html(msg);
	});
	$("img.loading_500").each(function(){
		LoadImage($(this),decode64($(this).attr('rel')),500);
	});
});
</script>
<script type="text/javascript" src="{tpl_path}js/base64.js"></script>
<?php $this->load->view(TPL_FOLDER."footer");?>
