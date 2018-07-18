<?php
 if ( !defined('BASEPATH')) exit('No direct script access allowed');;echo '';$this->load->view(TPL_FOLDER."header");;echo '<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="';echo $url;;echo '">U站采集规则列表</a> &gt; 添加采集规则</td>
  </tr>
</table>
<fieldset>
<legend>添加规则</legend>
<form action="';echo site_url(CTL_FOLDER."u_rule/save_copy_record");;echo '" method="post" name="dialog_edit_form" id="dialog_edit_form">
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
    <tr>
      <td width="152"><font color="#FF0000">*</font>采集规则名称：</td>
      <td width="561"><input name="title" type="text" size="30" value="';echo $edit_data['title'];;echo '" dataType="Require" msg="该项必须填写" maxlength="50" />
      </td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>列表第一页：</td>
      <td width="561"><input name="f_url" type="text" size="60" dataType="Require" msg="该项必须填写" maxlength="255" value="';echo $edit_data['f_url'];;echo '" /> 
      &nbsp;&nbsp; <a href="http://bbs.soke5.com/thread-29-1-1.html" target="_blank" style=" color:#06F">查看地址获取教程</a><br>
      例如：http://zhe800.uz.taobao.com/d/taofushi?tag_id=2
      </td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>列表分页(带标签)：</td>
      <td width="561"><input name="p_url" type="text" size="60" dataType="Require" msg="该项必须填写" maxlength="255" value="';echo $edit_data['p_url'];;echo '" /> 
      &nbsp;&nbsp; <a href="http://bbs.soke5.com/thread-29-1-1.html" target="_blank" style=" color:#06F">查看地址获取教程</a><br>
      例如：http://zhe800.uz.taobao.com/list.php?page={page}&tag_id=2，这里的{page} 就是分页值标签。</td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>分页总数：</td>
      <td width="561"><input name="page_total" type="text" size="5" value="';echo $edit_data['page_total'];;echo '" dataType="Int" msg="格式有误" maxlength="8" /> &nbsp; <input type="button" value="预抓取数据" style="width:100px" onclick="get_block(this.form)" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="url" type="hidden" value="';echo $url;;echo '" />
        <input type="button" name="sbmit" onclick="subForm(this.form,this)" value="添加" class="button-style" />
      </td>
    </tr>
  </table>
</form>
</fieldset>
<script language="javascript">
function get_block(f)
{
	var f_url = f.f_url.value;
	if(f_url == \'\')
	{
		alert(\'列表第一页地址必填\');
		return ;
	}
	show_message(\'正在努力抓取，请稍等...\',false);
	$.ajax({
		url:\'';echo my_site_url(CTL_FOLDER.'ajax/get_u_block');;echo '\',
		data:\'f_url=\'+encodeURIComponent(f_url),
		type:\'POST\',
		success:function(msg)
		{
			hide_message();
			openDialog(\'抓取效果\',msg,700,400);
		}
	});
}
</script>
';$this->load->view(TPL_FOLDER."footer");?>