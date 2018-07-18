<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<link rel="stylesheet" type="text/css" href="{tpl_path}style/user.css" />
<script type="text/javascript" src="{root_path}js/validator.js"></script>
<div class="wrap">
  <div class="login_left" style="padding-top:15px; height:400px">
    <h2>登录</h2>
    <form method="post" action="<?php echo site_url(CTL_FOLDER.'login/check_user_login');?>">
      <table width="98%" border=0 cellpadding=5 cellspacing=5 style=" line-height:25px">
        <tbody>
          <tr>
            <td width="14%" align=left>用户名：</td>
            <td width="86%" align="left"><input type="text" name="user_name" style="width:200px" maxlength="16" class="ui-tx-input" dataType="Require" msg="该项必填" /></td>
          </tr>
          <tr>
            <td align=left>密 &nbsp; 码：</td>
            <td align="left"><input type="password" style="width:200px" name="password" class="ui-tx-input" maxlength="20" dataType="Require" msg="该项必填" /></td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">
             <input type="button" class="btn3" value="登录" onclick="subForm(this.form,this)" />
              <?php if(isset($url)){?><input type="hidden" value="<?php echo $url;?>" name="url" /><?php }?></td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left">
            您也可以用以下方式登录：<br /><a href="<?php echo my_site_url(CTL_FOLDER.'qq_login');?>" target="_blank"><img src="{tpl_path}images/qq_icn.gif" style="vertical-align:middle" alt="qq账号登录" /> QQ账号登录</a> &nbsp;&nbsp;  &nbsp;&nbsp;
            <a href="<?php echo my_site_url(CTL_FOLDER.'tb_login');?>" target="_blank"><img src="{tpl_path}images/tb_login.gif" style="vertical-align:middle" alt="淘宝账号登录" /> 淘宝账号登录</a></td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
  <div class="login_right" style="padding-top:15px">
    <h2>注册</h2>
   <form method="post" action="<?php echo site_url(CTL_FOLDER.'login/save_reg');?>">
      <table width="90%" border=0 cellpadding=5 cellspacing=5  style=" line-height:25px">
        <tbody>
          <tr>
            <td width="22%" align=left valign="top">用户名：</td>
            <td width="78%" align="left"><input type="text" name="user_name" maxlength="16" class="ui-tx-input" dataType="Username"  style="width:200px" msg="用户名有误" /><br />长度：2-16位,支持 中文、字母、数字、下划线</td>
          </tr>
          <tr>
            <td align=left>设置密码：</td>
            <td align="left"><input type="password" name="password1"  style="width:200px" class="ui-tx-input" maxlength="20" dataType="Require" msg="密码必填" /></td>
          </tr>
          <tr>
            <td align=left>再次输入密码：</td>
            <td align="left"><input type="password"  style="width:200px" name="repassword1" class="ui-tx-input" maxlength="20" dataType="Repeat" to="password1" msg="<br>两次输入的密码不一致" /></td>
          </tr>
          <tr>
            <td align="left">&nbsp;</td>
            <td align="left"><input type="button" class="btn4" value="注册" onclick="subForm(this.form,this)" />
              <?php if(isset($url)){?><input type="hidden" value="<?php echo $url;?>" name="url" /><?php }?>
              </td>
          </tr>
        </tbody>
      </table>
    </form>
  </div>
  <div class="clear"></div>
</div>
<?php $this->load->view(TPL_FOLDER."footer");?>
