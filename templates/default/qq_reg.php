<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<link rel="stylesheet" href="{tpl_path}style/item.css" type="text/css" />
<link rel="stylesheet" type="text/css" href="{tpl_path}style/user.css" />
<script type="text/javascript" src="{root_path}js/validator.js"></script>
<div class="wrap">
  <div class="ui-tx-tab-h" style="width:100%">
    <ul>
      <li class="ui-tx-tab-h-active">完善账号信息</li>
      <li>绑定账号</li>
    </ul>
  </div>
  <div class="tab_block" style="height:350px">
    <form method="post" action="<?php echo my_site_url(CTL_FOLDER.'qq_login/add_user');?>">
      <table width="100%" border="0" cellspacing="0" cellpadding="5" style="margin-top:10px">
        <tr>
          <td colspan="2" align="center"><img src="{tpl_path}images/common/tips.jpg" style="vertical-align:middle" /> 第一次使用QQ号码登录，必须完成以下操作才会登录成功。</td>
        </tr>
        <tr>
          <td width="28%" align="right"><font color="#FF0000">*</font>用户名：</td>
          <td width="72%"><input value="<?php echo $nick;?>" type="text" name="user_name" maxlength="16" style="width:200px" class="ui-tx-input" dataType="Username" msg="<br>填写有误" />
            长度：3-16位，由字母(a-z)、数字(0-9)、( _ )、中文 线组成</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="button" onclick="subForm(this.form,this)" class="btn3" value="确定" /></td>
        </tr>
      </table>
    </form>
  </div>
  <div class="tab_block" style="display:none;height:350px">
    <form method="post" action="<?php echo my_site_url(CTL_FOLDER.'qq_login/bind_user');?>">
      <table width="100%" border="0" cellspacing="0" cellpadding="5" style="margin-top:10px">
        <tr>
          <td colspan="2" align="center"><img src="{tpl_path}images/common/tips.jpg" style="vertical-align:middle" /> 第一次使用QQ号码登录，必须完成以下操作才会登录成功。</td>
        </tr>
        <tr>
          <td width="29%" align="right"><font color="#FF0000">*</font>用户名：</td>
          <td width="71%"><input type="text" name="user_name" maxlength="16" class="ui-tx-input" dataType="Username" msg="用户名必填" style="width:200px" /></td>
        </tr>
        <tr>
          <td width="29%" align="right"><font color="#FF0000">*</font>密 码：</td>
          <td width="71%"><input type="password" name="password" class="ui-tx-input" maxlength="20"  style="width:200px" dataType="Require" msg="密码必填" /></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input type="button" onclick="subForm(this.form,this)" class="btn4" value="绑定账号" /></td>
        </tr>
      </table>
    </form>
  </div>
  <div class="clear"></div>
</div>
<script language="javascript">
$(function(){
	$('.ui-tx-tab-h li').each(function(i){
		$(this).click(function(){
			$(this).addClass('ui-tx-tab-h-active').siblings('li').removeClass('ui-tx-tab-h-active');
			$('div.tab_block').eq(i).show().siblings('div.tab_block').hide();
		});
	});
});
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
