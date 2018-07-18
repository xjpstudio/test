<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo $url;?>">采集规则列表</a> &gt; 采集规则修改</td>
  </tr>
</table>
<fieldset>
<legend>采集规则修改</legend>
<form action="<?php echo site_url(CTL_FOLDER."rule/save_record");?>" method="post" name="dialog_edit_form" id="dialog_edit_form">
  <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
    <tr>
      <td width="152"><font color="#FF0000">*</font>采集规则名称：</td>
      <td width="561"><input name="title" type="text" size="30" value="<?php echo $edit_data['title'];?>" dataType="Require" msg="该项必须填写" maxlength="50" />
      </td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>采集页面编码：</td>
      <td width="561"><input name="charset" type="text" size="10" value="<?php echo $edit_data['charset'];?>" dataType="Require" msg="该项必须填写" maxlength="20" />
        采集目标页面的编码，常见编码：gb2312,gbk,utf-8,big5,iso-8859-1,GB18030</td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>列表第一页：</td>
      <td width="561"><input name="f_url" type="text" size="60" value="<?php echo $edit_data['f_url'];?>" dataType="Require" msg="该项必须填写" maxlength="255" />
      </td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>列表分页(带标签)：</td>
      <td width="561"><input name="p_url" type="text" size="60" value="<?php echo $edit_data['p_url'];?>" dataType="Require" msg="该项必须填写" maxlength="255" />
        <br>
        比方腾讯新闻的分页地址为：http://news.qq.com/newsgn/gdxw/gedixinwen_2.htm 则填写
        http://news.qq.com/newsgn/gdxw/gedixinwen_{page}.htm &nbsp;&nbsp; 即把{page}替换掉链接中分页数字。</td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>分页总数：</td>
      <td width="561"><input name="page_total" type="text" size="5" value="<?php echo $edit_data['page_total'];?>" dataType="Int" msg="格式有误" maxlength="8" /></td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>分页步长：</td>
      <td width="561"><input name="page_step" type="text" size="5" value="<?php echo $edit_data['page_step'];?>" dataType="Int" msg="格式有误" maxlength="8" />
        一般填写 1 即可，步长 = 相邻两个页数之差。</td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>列表区开始标记：</td>
      <td width="561"><textarea dataType="Limit" max="500" min="1" msg="长度1-500" name="list_block_s" cols="50" rows="5"><?php echo $edit_data['list_block_s'];?></textarea>
        <br>
        简短，达到唯一性即可，不包含列表项在内，一般为包围列表项的开始标签。</td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>列表区结束标记：</td>
      <td width="561"><textarea dataType="Limit" max="500" min="1" msg="长度1-500" name="list_block_e" cols="50" rows="5"><?php echo $edit_data['list_block_e'];?></textarea>
        <br>
        简短，达到唯一性即可，不包含列表项在内，一般为包围列表项的结束标签。<br><input type="button" value="预抓取列表区内容" style="width:150px" onclick="get_block(this.form)" /></td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>列表项开始标记：</td>
      <td width="561"><textarea dataType="Limit" max="500" min="1" msg="长度1-500" name="list_link_s" cols="50" rows="5"><?php echo $edit_data['list_link_s'];?></textarea>
        <br>
        <b style="color:#009900">一般从”预抓取列表区内容“中取得</b>,简短，达到唯一性即可，不包含a标签在内，一般为包围a标签的开始标记。</td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>列表项结束标记：</td>
      <td width="561"><textarea dataType="Limit" max="500" min="1" msg="长度1-500" name="list_link_e" cols="50" rows="5"><?php echo $edit_data['list_link_e'];?></textarea>
        <br>
        <b style="color:#009900">一般从”预抓取列表区内容“中取得</b>,简短，达到唯一性即可，不包含a标签在内，一般为包围a标签的结束标记。<br><input type="button" value="预抓取列表项" style="width:150px" onclick="get_list(this.form)" /></td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>详细页面正文开始标记：</td>
      <td width="561"><textarea dataType="Limit" max="500" min="1" msg="长度1-500" name="detail_s" cols="50" rows="5"><?php echo $edit_data['detail_s'];?></textarea>
        <br>
        简短，达到唯一性即可，不包含正文部分，一般为包围正文的开始标记。</td>
    </tr>
    <tr>
      <td width="152"><font color="#FF0000">*</font>详细页面正文结束标记：</td>
      <td width="561"><textarea dataType="Limit" max="500" min="1" msg="长度1-500" name="detail_e" cols="50" rows="5"><?php echo $edit_data['detail_e'];?></textarea>
        <br>
        简短，达到唯一性即可，不包含正文部分，一般为包围正文的结束标记。</td>
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
	var charset = f.charset.value;
	var f_url = f.f_url.value;
	var list_block_s = f.list_block_s.value;
	var list_block_e = f.list_block_e.value;
	if( ! charset || ! f_url || ! list_block_s || ! list_block_e)
	{
		alert('采集页面编码、列表第一页、列表区开始标记、列表区结束标记必填');
		return ;
	}
	show_message('正在努力抓取，请稍等...',false);
	$.ajax({
		url:'<?php echo my_site_url(CTL_FOLDER.'ajax/get_block');?>',
		data:'charset='+charset+'&f_url='+encodeURIComponent(f_url)+'&list_block_s='+encodeURIComponent(list_block_s)+'&list_block_e='+encodeURIComponent(list_block_e),
		type:'POST',
		success:function(msg)
		{
			hide_message();
			openDialog('抓取效果',msg,700,400);
		}
	});
}
function get_list(f)
{
	var charset = f.charset.value;
	var f_url = f.f_url.value;
	var list_block_s = f.list_block_s.value;
	var list_block_e = f.list_block_e.value;
	var list_link_s = f.list_link_s.value;
	var list_link_e = f.list_link_e.value;
	if( ! charset || ! f_url || ! list_block_s || ! list_block_e || ! list_link_s || ! list_link_e)
	{
		alert('采集页面编码、列表第一页、列表区开始标记、列表区结束标记、列表项开始标记、列表项结束标记必填');
		return ;
	}
	show_message('正在努力抓取，请稍等...',false);
	$.ajax({
		url:'<?php echo my_site_url(CTL_FOLDER.'ajax/get_list');?>',
		data:'charset='+charset+'&f_url='+encodeURIComponent(f_url)+'&list_block_s='+encodeURIComponent(list_block_s)+'&list_block_e='+encodeURIComponent(list_block_e)+'&list_link_s='+encodeURIComponent(list_link_s)+'&list_link_e='+encodeURIComponent(list_link_e),
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
