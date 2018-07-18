<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<link rel="stylesheet" type="text/css" href="{tpl_path}style/user.css" />
<div class="wrap">
  <div class="user_top_nav">
    <div class="user_profile user_nav_cur"><a href="<?php echo my_site_url('user');?>"><img src="{tpl_path}images/profile.png" alt="个人资料" /> 个人资料</a></div>
    <div class="user_comment"><a href="<?php echo my_site_url('user/comment');?>"><img src="{tpl_path}images/comment.png" alt="我的评论" /> 我的评论</a></div>
    <div class="user_logout"><a href="<?php echo my_site_url('login/logout');?>"><img src="{tpl_path}images/logout.png" alt="退出登录" /> 退出登录</a></div>
    <div style="clear:both"></div>
  </div>
  <div class="user_main">
  <table width="100%" border="0" cellspacing="0" cellpadding="5" style="line-height:25px">
  <tr>
    <td width="22%" rowspan="3" align="center" valign="middle"><img src="{tpl_path}images/user_header.png" /></td>
    <td width="43%"><strong>用户名：</strong><strong style="color:#C30"><?php echo $this->session->userdata('shop_user_name');?></strong></td>
    <td width="35%"><strong>邮箱：</strong><?php echo $user->email;?></td>
  </tr>
  <tr>
    <td><strong>QQ：</strong><?php echo $user->qq;?></td>
    <td><strong>旺旺：</strong><?php echo $user->wangwang;?></td>
  </tr>
  <tr>
    <td><strong>登录次数：</strong> <?php echo $user->login_times;?> 次</td>
    <td><strong>上次登录：</strong> <?php echo date('Y-m-d H:i:s',$this->session->userdata('shop_last_login_time'));?></td>
  </tr>
  <tr>
    <td align="center" valign="middle">&nbsp;</td>
    <td><strong>注册日期：</strong> <?php echo date('Y-m-d',$user->create_date);?></td>
    <td><a href="<?php echo my_site_url('user/edit_user');?>" style="color:#06F">修改个人资料</a></td>
  </tr>
  </table>
  </div>
</div>
<?php $this->load->view(TPL_FOLDER."footer");?>
