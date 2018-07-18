<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php foreach($query as $row){?>
<li class="clearfix"><a title="<?php echo $row->title;?>" href="<?php echo my_site_url('item/'.$row->id);?>" target="_blank"><img src="<?php echo get_real_path($row->small_pic_path);?>" width="70" height="70" alt="<?php echo $row->title;?>"  /></a>
  <p>价格：<?php if($row->dc_price > 0) echo format_curren($row->dc_price); else echo format_curren($row->shop_price);?><br><a title="<?php echo $row->title;?>" href="<?php echo my_site_url('item/'.$row->id);?>" target="_blank"><?php echo strcut($row->title,30);?></a></p>
</li>
<?php }?>
