<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<script type="text/javascript" src="{root_path}js/My97DatePicker/WdatePicker.js" charset="gb2312"></script>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."user");?>">全部会员</a></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:solid 1px #3C4952; margin-bottom:5px; margin-top:5px">
  <tr>
    <td width="56%" height="24" align="left" ><form method="get">
        <input type="text" name="s_keyword" id="s_keyword" size="10">
        &nbsp;从
        <input type="text" name="s_date" id="s_date" size="15" onClick="WdatePicker({'dateFmt':'yyyy-MM-dd HH:mm:ss'})">
        &nbsp;到
        <input type="text" name="e_date" id="e_date" size="15" onClick="WdatePicker({'dateFmt':'yyyy-MM-dd HH:mm:ss'})">
        &nbsp;
        <input type="submit" name="s_sb" value="搜索" class="button-style2">
      </form></td>
  </tr>
</table>
<form method="post" name="list_form" id="list_form">
  <table width="100%" cellspacing="0" class="widefat">
    <thead>
      <tr>
        <th width="3%"><input type="checkbox" onclick="check_box(this.form.rd_id)" /></th>
        <th width="11%">用户名</th>
        <th width="16%">邮箱</th>
        <th width="11%">QQ</th>
        <th width="13%">旺旺</th>
        <th width="9%">评论数</th>
        <th width="10%">注册日期</th>
        <th width="11%">最近登录</th>
        <th width="10%">登录次数</th>
        <th width="6%">操作</th>
      </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody id="check_box_id">
      <?php foreach($query as $row) {?>
      <tr>
        <td><input name="rd_id[]" type="checkbox" id="rd_id" value="<?php echo $row->id;?>"></td>
        <td><?php echo $row->user_name;?></td>
        <td><?php echo $row->email;?></td>
        <td><?php echo $row->qq;?></td>
        <td><?php echo $row->wangwang;?></td>
        <td><a href="<?php echo my_site_url(CTL_FOLDER.'comment');?>?user_id=<?php echo $row->id;?>"><?php echo $row->com_num;?></a></td>
        <td><?php echo date("Y-m-d",$row->create_date);?></td>
        <td><?php echo date("Y-m-d H:i:s",$row->last_login_time);?></td>
        <td><?php echo $row->login_times;?></td>
        <td><a href="javascript:show_detail(<?php echo $row->id;?>);">详情</a></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" >
    <tr>
      <td style="padding-top:5px"><input type="checkbox" onclick="check_box(this.form.rd_id)" />
        全选
        <select name="action_url" id="action_url">
          <option value="" style="color:#FF0000">-选择操作-</option>
          <option value="<?php echo site_url(CTL_FOLDER."user/del_record");?>">删除</option>
        </select>
        &nbsp;
        <input type="button" name="submit_list_button" class="button-style2" onclick="submit_list_form(this.form,this)" id="submit_list_button" value="执行操作" /></td>
      <td align="right"><?php echo $paginate;?></td>
    </tr>
  </table>
</form>
<div id="dialog_add" style="display:none; position:relative"></div>
<script language="javascript">
function RqData(){
	$('#dialog_add').dialog({  
		hide:'',      
		autoOpen:false,
		width:680,
		height:300,  
		modal:true, //蒙层  
		title:'会员详情', 
		close: function(){ 
			$(this).dialog('destroy');
		},  
		overlay: {  
			opacity: 0.5, 
			background: "black"
		},  
		buttons:{  
			'关闭':function(){$(this).dialog("close");},
			'修改':function(){subuserform();}
		}
	});
	$('#dialog_add').dialog('open');
}
function subuserform()
{
	var theform = document.getElementById("userform");
	if( ! Validator.Validate(theform,3) ) return ;
	theform.submit();
}
function show_detail(id)
{
	show_message('数据处理中，请稍等...',false);
	$.ajax({
		type:"POST",
		url:"<?php echo site_url(CTL_FOLDER."user/get_record");?>",
		data:"rd_id="+id,
		success:function(msg){
			$("#dialog_add").html(msg);
			RqData();
			hide_message();
		},
		error:function(){
			$("#ui-tx-mark-message").html("数据请求失败");
			setTimeout(function(){hide_message(); }, 2000); 
		}
	});
	return ;
}
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
