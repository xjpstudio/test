<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
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
    <p><?php echo $this->config->item('sys_site_copyright');?> <?php if($this->config->item('sys_is_power') == 1) echo APP_POWER;?> <?php echo html_entity_decode($this->config->item('sys_tongji'),ENT_QUOTES);?>
    </p>
  </div>
</div>
<script language="javascript">
$(function(){
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
});
</script>
<script type="text/javascript" src="{root_path}js/djin.js"></script>
<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6688813" ></script>
<script type="text/javascript" id="bdshell_js"></script>
<script type="text/javascript">
document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
</script>
</body>
</html>