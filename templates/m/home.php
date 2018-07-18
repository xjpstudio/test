<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<div class="viewport" style="padding-top:50px">
  <div class="scroll relative">
    <div class="scroll_box" id="scroll_img">
      <ul class="scroll_wrap">
        <?php foreach(get_cache('focus') as $row){?>
        <li><a href="<?php echo $row->hplink;?>" target="_blank"><img class="focus_img" alt="<?php echo $row->title;?>" src="<?php echo get_real_path($row->pic_path);?>" /></a></li>
        <?php }?>
      </ul>
    </div>
    <ul class="scroll_position" id='scroll_position'>
      <?php $i = 1;
	foreach(get_cache('focus') as $row){?>
      <li <?php if($i == 1) echo 'class="on"';?>><a href="javascript:void(0);"></a></li>
      <?php $i++;}?>
    </ul>
  </div>
</div>
<div class="viewport">
  <div class="row_con">
    <h2>最新推荐<a href="<?php echo my_site_url(CTL_FOLDER.'search');?>" style="float:right; font-size:12px; font-weight:normal">更多+</a></h2>
    <?php foreach($top_product as $row){
		$img_url = get_real_path($row->small_pic_path);
		$img_url = preg_replace('/\_\d+x\d+\./i','_100x100.',$img_url);
	?>
    <dl class="list">
      <dt><a rel="nofollow" href="<?php echo my_site_url('clk/'.$row->id);?>" target="_blank"><img src="<?php echo $img_url;?>" alt="<?php echo $row->title;?>" width="100" /></a></dt>
      <dd>
        <p><a rel="nofollow" href="<?php echo my_site_url('clk/'.$row->id);?>" target="_blank"><?php echo $row->title;?></a> </p>
        <?php if($row->dc_price > 0){?>
        <span>¥<?php echo $row->dc_price;?></span> <del><?php echo $row->shop_price;?></del>
        <?php }else{?>
        <span>¥<?php echo $row->shop_price;?></span>
        <?php }?>
        <br>
        <?php if($row->volume > 0){?>
        <b>已售 <font style="color:#090"><?php echo $row->volume;?></font> 件</b>
        <?php }?>
        <a rel="nofollow" href="<?php echo my_site_url('clk/'.$row->id);?>" target="_blank" class="btn">去购买</a> </dd>
    </dl>
    <?php }?>
  </div>
</div>
<script type="text/javascript" src="{tpl_path}js/hhSwipe.js"></script> 
<script>
var bullets = document.getElementById('scroll_position').getElementsByTagName('li');
var slider = Swipe(document.getElementById('scroll_img'),{
	auto: 5000,
	continuous: true,
	callback: function(pos) {
		var i = bullets.length;
		while (i--) {
			bullets[i].className = ' ';
		}
		bullets[pos].className = 'on';
	}
});
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
