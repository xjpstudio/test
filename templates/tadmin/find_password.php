<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" Content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=7" />
<Title>找回管理员密码</Title>
<link href="{tpl_path}style/login_style.css" rel="stylesheet" />
<script type="text/javascript" src="{root_path}js/validator.js"></script>
<script language="javascript">
window.onload = function(){document.getElementById('user_name').focus();}
</script>
</head>

<body>
<div class="bg2">
  <div style="padding-top:100px; width:228px; margin:0 auto;">
    <form method="post" action="<?php echo site_url(CTL_FOLDER."login/send_password"); ?>" onsubmit="return Validator.Validate(this,1)">
      <table width="228" border="0" cellpadding="0" cellspacing="0" style="background:url({tpl_path}images/forget_bg.gif) no-repeat">
        <tr>
          <td width="79" height="32"></td>
          <td width="149" height="32"><input name="user_name" id="user_name" type="text" class="login-kk01" dataType="Require" msg="管理员账号必填" maxlength="30"/></td>
        </tr>
        <tr>
          <td height="7" colspan="2"></td>
        </tr>
        <tr>
          <td width="79" height="32"></td>
          <td height="32"><input name="email" type="text" class="login-kk01" dataType="Email" msg="管理员邮箱有误" maxlength="100"/></td>
        </tr>
        <tr>
          <td height="7" colspan="2"></td>
        </tr>
      </table>
      <table width="228" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td height="58" align="left" valign="bottom"><div style="padding-left:53px">
              <input type="image" src="{tpl_path}images/bat-login3.gif" title="找回密码" alt="找回密码" width="124" height="45" /></div></td>
        </tr>
      </table>
    </form>
  </div>
  <div id="bottom"><a href="<?php echo ROOT_PATH;?>">前台首页</a> | <a href="<?php echo site_url(CTL_FOLDER."login");?>">管理员登录</a> | 技术支持：<a href="http://bbs.soke5.com/" target="_blank">搜客淘宝客</a></div>
</div>
</body>
</html>
