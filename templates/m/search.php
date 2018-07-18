<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<div class="viewport" style="padding-top:50px">
  <div class="row_con">
    <h2>商品搜索</h2>
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
  </div>
  <?php if( ! $query){?>
  <div id="tips_msg" style="display:block"><?php echo '没有数据...';?></div>
  <?php }else{?>
  <div id="tips_msg"></div>
  <?php }?>
</div>
<?php if($query){?>
<script language="javascript">
var page=2;
var loaded = true;
function scroll_load()
{
  var top = $("#tips_msg").offset().top;
  if(loaded && $(this).scrollTop() + $(window).height() + 100 >= $(document).height())
  {
	 $("#tips_msg").html("正在努力加载数据...").show();
	 $.ajax(
	 {
		 type: "GET",
		 dataType: "text",
		 url: "<?php echo site_url(CTL_FOLDER.'ajax/get_product');?>",
		 data: "q=<?php if(isset($get['q']) && ! empty($get['q'])) echo urlencode($get['q']);?>&cid=<?php if(isset($get['cid']) && ! empty($get['cid'])) echo $get['cid'];?>&page="+page,
		 success: function(msg)
		 {
			if(msg == "nodata")
			{
				$("#tips_msg").html("没有数据了...");
				loaded=false;
			}
			else
			{
				page++;
				$("#tips_msg").hide();
				$(msg).appendTo('div.row_con');
			}
		 }
	  }
	);
  }
}
$(window).scroll(scroll_load);
</script>
<?php }?>
<?php $this->load->view(TPL_FOLDER."footer");?>
