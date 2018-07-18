<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo $url;?>">U站采集规则列表</a> &gt; 采集规则修改</td>
  </tr>
</table>
<fieldset>
<legend>采集规则修改</legend>
<form action="<?php echo site_url(CTL_FOLDER."u_rule/save_record");?>" method="post" name="dialog_edit_form" id="dialog_edit_form">
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
    <tr>
      <td width="152"><font color="#FF0000">*</font>采集规则名称：</td>
      <td width="561"><input name="title" type="text" size="30" value="<?php echo $edit_data['title'];?>" dataType="Require" msg="该项必须填写" maxlength="50" />
      </td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>列表第一页：</td>
      <td width="561"><input name="f_url" type="text" size="60" dataType="Require" msg="该项必须填写" maxlength="255" value="<?php echo $edit_data['f_url'];?>" /> 
      &nbsp;&nbsp; <a href="http://bbs.soke5.com/thread-29-1-1.html" target="_blank" style=" color:#06F">查看地址获取教程</a><br>
      例如：http://zhe800.uz.taobao.com/d/taofushi?tag_id=2
      </td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>列表分页(带标签)：</td>
      <td width="561"><input name="p_url" type="text" size="60" dataType="Require" msg="该项必须填写" maxlength="255" value="<?php echo $edit_data['p_url'];?>" /> 
      &nbsp;&nbsp; <a href="http://bbs.soke5.com/thread-29-1-1.html" target="_blank" style=" color:#06F">查看地址获取教程</a><br>
      例如：http://zhe800.uz.taobao.com/list.php?page={page}&tag_id=2，这里的{page} 就是分页值标签。</td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>分页总数：</td>
      <td width="561"><input name="page_total" type="text" size="5" value="<?php echo $edit_data['page_total'];?>" dataType="Int" msg="格式有误" maxlength="8" /> &nbsp; <input type="button" value="预抓取数据" style="width:100px" onclick="get_block(this.form)" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="rd_id" type="hidden" value="<?php echo $edit_data['id'];?>" />
        <input name="url" type="hidden" value="<?php echo $url;?>" />
        <input type="button" name="sbmit" onclick="subForm(this.form,this)" value="修改" class="button-style2" />
      </td>
    </tr>
  </table>
</form>
</fieldset>
<script language="javascript">
function get_block(f)
{
	var f_url = f.f_url.value;
	if(f_url == '')
	{
		alert('列表第一页地址必填');
		return ;
	}
	show_message('正在努力抓取，请稍等...',false);
	$.ajax({
		url:'<?php echo my_site_url(CTL_FOLDER.'ajax/get_u_block');?>',
		data:'f_url='+encodeURIComponent(f_url),
		type:'POST',
		success:function(msg)
		{
			hide_message();
			openDialog('抓取效果',msg,700,400);
		}
	});
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
