<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<form action="<?php echo site_url(CTL_FOLDER.'user/save_record');?>" method="post" id="userform">
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
    <tr>
      <td width="111">用户名：</td>
      <td width="282"><?php echo $edit_data['user_name'];?></td>
      <td width="80">邮箱：</td>
      <td width="258"><input type="text" name="email" value="<?php echo $edit_data['email'];?>" maxlength="50" dataType="Email" msg="email格式有误" require="false" class="inputstyle" /></td>
    </tr>
    <tr>
      <td width="111">QQ：</td>
      <td width="282"><input type="text" name="qq" value="<?php echo $edit_data['qq'];?>" maxlength="20" class="inputstyle"/></td>
      <td width="80">旺旺：</td>
      <td width="258"><input class="inputstyle" type="text" name="wangwang" value="<?php echo $edit_data['wangwang'];?>" maxlength="30"/></td>
    </tr>
    <tr>
      <td style="color:#F00">密码：</td>
      <td><input class="inputstyle" type="text" name="password" value="" maxlength="20"/>
        不修改请留空</td>
      <td width="80">登录IP：</td>
      <td width="258"><?php echo $edit_data['last_login_ip'];?></td>
    </tr>
    <tr>
      <td width="111">注册日期：</td>
      <td width="282"><?php echo date("Y-m-d H:i:s",$edit_data['create_date']);?></td>
      <td>登录次数：</td>
      <td><?php echo $edit_data['login_times'];?></td>
    </tr>
    <tr>
      <td>最近登录时间：</td>
      <td><?php echo date("Y-m-d H:i:s",$edit_data['last_login_time']);?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <input type="hidden" name="rd_id" value="<?php echo $edit_data['id'];?>" />
</form>
