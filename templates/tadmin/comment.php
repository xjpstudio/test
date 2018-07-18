<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."product");?>">全部商品</a> &gt; 商品评论 </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:solid 1px #3C4952; margin-bottom:5px; margin-top:5px">
  <tr>
    <td height="24" align="center" ><?php foreach($num as $row){?>
      <?php if($row->is_pass){?>
      <a href="<?php echo site_url(CTL_FOLDER."comment");?>?is_pass=1">已审核(<font style="color:#FF0000"><?php echo $row->num;?></font>)</a> |
      <?php }else{?>
      <a href="<?php echo site_url(CTL_FOLDER."comment");?>?is_pass=0">未审核(<font style="color:#FF0000"><?php echo $row->num;?></font>)</a> |
      <?php } }?> &nbsp; <a href="?">全部评论</a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href="javascript:void(0)" onclick="if(confirm('确定要删除所有评论吗?')) document.location.href='<?php echo my_site_url(CTL_FOLDER.'comment/clear');?>'"><img src="{tpl_path}images/icon_trash.gif" /> 一键清空</a></td>
  </tr>
</table>
<form method="post" name="list_form" id="list_form">
  <table width="100%" border="0" cellpadding="5" cellspacing="0" style="margin:5px 0">
   <tbody id="check_box_id">
   <?php foreach($query as $row){?>
    <tr>
      <td width="23%" height="25" align="left" bgcolor="#F0F0F0"><input name="rd_id[]" type="checkbox" id="rd_id" value="<?php echo $row->id;?>"> <b><?php echo $row->user_name;?></b></td>
      <td width="21%" align="center" bgcolor="#F0F0F0"><?php echo $row->ip_address;?></td>
      <td width="13%" align="right" bgcolor="#F0F0F0"><?php if($row->is_pass) echo '<font color="#009900">已审核</font>'; else echo '<font color="#FF0000">未审核</font>';?></td>
      <td width="17%" align="right" bgcolor="#F0F0F0"><?php echo date('Y-m-d H:i:s',$row->create_date);?></td>
      <td width="7%" align="right" bgcolor="#F0F0F0"><a href="<?php echo site_url(CTL_FOLDER."comment/reply_comment/".$row->id);?>?url=<?php echo get_curren_url();?>" style="color:#F00">回复</a></td>
    </tr>
    <tr>
      <td height="25" colspan="5" align="left" style="line-height:25px"> 评论商品：<a href="<?php echo my_site_url('item/'.$row->product_id);?>" target="_blank"><?php echo $row->title;?></a><br />
        评论内容：<?php echo format_textarea($row->content);?> <br />
        回复内容：<?php echo format_textarea($row->reply);?></td>
    </tr>
     <?php }?>
    </tbody>
  </table>
  <?php if( ! $query){?>
  <div style="text-align: center; color:#F00; font-size:14px; padding:10px">暂无任何评论...</div>
  <?php }?>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="padding-top:5px"><input type="checkbox" onclick="check_box(this.form.rd_id)" /> 全选 <select name="action_url" id="action_url">
          <option value="" style="color:#FF0000">-选择操作-</option>
          <option value="<?php echo site_url(CTL_FOLDER."comment/del_comment");?>">删除</option>
          <option value="<?php echo site_url(CTL_FOLDER."comment/pass");?>">审核通过</option>
        </select>
        <input type="button" name="submit_list_button" class="button-style2" onclick="submit_list_form(this.form,this)" id="submit_list_button" value="执行操作" />
         </td>
      <td align="right"><?php echo $paginate;?></td>
    </tr>
  </table>
</form>
<?php $this->load->view(TPL_FOLDER."footer");?>
