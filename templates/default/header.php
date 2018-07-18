<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<title><?php echo $site_title;?></title>
<link href="<?php echo ROOT_PATH;?>favicon.ico" type="image/x-icon" rel="icon" />
<link href="<?php echo ROOT_PATH;?>favicon.ico" type="image/x-icon" rel="shortcut icon" />
<?php if(isset($page_keyword) && $page_keyword!=''){?>
<meta name="keywords" content="<?php echo $page_keyword;?>"/>
<?php }else{?>
<meta name="keywords" content="<?php echo $this->config->item("sys_site_keyword");?>"/>
<?php }?>
<?php if(isset($page_description) && $page_description!=''){?>
<meta name="description" content="<?php echo $page_description;?>"/>
<?php }else{?>
<meta name="description" content="<?php echo $this->config->item("sys_site_description");?>"/>
<?php }?>
<script language="javascript">window.onerror = function(){return true;}</script>
<link rel="stylesheet" type="text/css" href="{tpl_path}style/style.css" />
<script type="text/javascript" src="{root_path}js/jquery/jquery.js"></script>
<script type="text/javascript" src="{tpl_path}js/function.js"></script>
<script language="javascript">
var onerror_pic_path="{tpl_path}images/common/none.gif";
var pic_loading_path="{tpl_path}images/common/loading.gif";
var js_root_path="<?php echo my_site_url();?>";
function check_submit(f)
{
	if(f.q.value == '' || f.q.value == f.q.defaultValue)
	{
		alert('请输入搜索关键字');
		return false;
	}
}
</script>
</head>

<body>
<div id="site-nav">
  <div id="sn-bd">
    <div class="sn-container">
      <ul class="sn-quick-menu">
        <li style="float:left; padding-right:0"> 分享到： </li>
        <li style="float:left">
          <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare"><a class="bds_qzone"></a> <a class="bds_tsina"></a> <a class="bds_tqq"></a> <a class="bds_renren"></a> <a class="bds_t163"></a><a class="bds_taobao"></a><a class="bds_kaixin001"></a><a class="bds_tsohu"></a><span class="bds_more" style="vertical-align: middle"></span></div>
        </li>
		<li><a href="<?php echo my_site_url('m/home');?>">手机版</a> </li>
        <li><a href="javascript:void(0)" onclick="AddFavorite('<?php echo base_url();?>', '<?php echo $this->config->item('sys_site_name');?>')">收藏本站</a> </li>
        <li><a href="javascript:void(0)" onclick="SetHome(this,'<?php echo base_url();?>')">设为主页</a> </li>
        <li><a href="<?php echo my_site_url('sitemap');?>">网站地图</a></li>
        <li><a href="<?php echo my_site_url('app');?>" style="color:#F00">商家报名</a> </li>
        <script language="javascript">document.write("<script src='<?php echo my_site_url(CTL_FOLDER.'top_login_bar');?>?rnd="+Math.random()+"'></s"+"cript>");</script>
      </ul>
    </div>
  </div>
</div>
<div id="header">
  <div class="headerLayout">
    <div class="headerCon">
      <div id="mallLogo"> <a href="<?php echo base_url();?>"><img alt="<?php echo $this->config->item('sys_site_name');?>" src="<?php echo get_real_path($this->config->item('sys_site_logo'));?>" /></a></div>
      <div id="mallSearch">
          <form class="clearfix" onsubmit="return check_submit(this)" action="<?php echo site_url(CTL_FOLDER.'search');?>">
            <fieldset>
              <div class="mallSearch-input clearfix">
                <input type="text" name="q" id="mq" maxlength="50" value="请输入搜索关键字" onblur="if(this.value == '') this.value = this.defaultValue;" onclick="if(this.value == this.defaultValue) this.value = '';" />
                <button type="submit">搜索</button>
              </div>
            </fieldset>
          </form>
		  
      </div>
	  	  <div id="mallLorignt">
	  
	  </div>
    </div>
  </div>
</div>
<div id="mallNav">
  <div class="mallNav-con" id="J_MallNavCon">
    <div id="mallCate">
      <h2 class="mcate-hd"> <a href="<?php echo site_url(CTL_FOLDER.'sitemap');?>" title="商品分类"><i></i>所有商品分类</a></h2>
    </div>
    <div id="mallTextNav" class="clearfix">
      <ul class="mallNav-main" id="J_MallNavMain">
        <li><a href="<?php echo base_url();?>">首页 Hi</a> </li>
        <?php 
		  $i = 1;
		  $top_nav = get_cache('top_nav');
		  foreach($top_nav as $row){
		  ?>
        <li<?php if($i == count($top_nav) || $i == 10){?> class="mallNav-last"<?php }?>><a title="<?php echo $row['title'];?>" href="<?php echo $row['url'];?>" target="<?php echo $row['target'];?>"><?php echo $row['title'];?></a></li>
        <?php 
		  if($i >= 9) break;
		  $i++;
		  }?>
      </ul>
    </div>
  </div>
</div>
