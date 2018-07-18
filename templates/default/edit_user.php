<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<link rel="stylesheet" type="text/css" href="{tpl_path}style/user.css" />
<script type="text/javascript" src="{root_path}js/validator.js"></script>
<div class="wrap">
  <div class="user_top_nav">
    <div class="user_profile user_nav_cur"><a href="<?php echo my_site_url('user');?>"><img src="{tpl_path}images/profile.png" alt="个人资料" /> 个人资料</a></div>
    <div class="user_comment"><a href="<?php echo my_site_url('user/comment');?>"><img src="{tpl_path}images/comment.png" alt="我的评论" /> 我的评论</a></div>
    <div class="user_logout"><a href="<?php echo my_site_url('login/logout');?>"><img src="{tpl_path}images/logout.png" alt="退出登录" /> 退出登录</a></div>
    <div style="clear:both"></div>
  </div>
  <div class="user_main">
    <form method="post" action="<?php echo site_url(CTL_FOLDER.'user/save_edit_user');?>">
      <table width="100%" border="0" cellspacing="0" cellpadding="5" style="margin:10px 0">
      <tr>
        <td width="12%" align="left">新密码：</td>
        <td width="88%"><input type="text" style="width:200px" name="password" class="ui-tx-input" maxlength="20" /> 不修改请留空</td>
      </tr>
        <tr>
          <td width="12%" align="left"><font color="#FF0000">*</font>邮箱：</td>
          <td width="88%"><input type="text" name="email" class="ui-tx-input" maxlength="50" style="width:200px" dataType="Email" msg="邮箱格式有误" value="<?php echo $user->email;?>" /></td>
        </tr>
        <tr>
          <td align="left">QQ：</td>
          <td align="left"><input name="qq" type="text" class="ui-tx-input" value="<?php echo $user->qq;?>" style="width:200px" maxlength="20" /></td>
        </tr>
        <tr>
          <td align="left">旺旺</td>
          <td align="left"><input name="wangwang" type="text" class="ui-tx-input" value="<?php echo $user->wangwang;?>" style="width:200px" maxlength="30" /></td>
        </tr>
        <tr>
          <td align="left">&nbsp;</td>
          <td><input type="button" class="btn3" value="修改" onclick="subForm(this.form,this)" />
            &nbsp;&nbsp;
            <input type="button" onclick="document.location.href='<?php echo site_url(CTL_FOLDER.'user');?>'" class="btn4" value="返回" /></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<?php $this->load->view(TPL_FOLDER."footer");?>