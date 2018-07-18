<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php foreach($query as $row){
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
