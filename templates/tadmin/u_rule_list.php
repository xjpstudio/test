<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."u_rule");?>">U站采集规则列表</a> </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin-bottom:5px; margin-top:5px">
  <tr>
    <td width="367" align="center" ><a href="<?php echo site_url(CTL_FOLDER."u_rule/add_record_view");?>"><img src="{tpl_path}images/add.png"> 添加采集规则</a> &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; <a href="<?php echo site_url(CTL_FOLDER."product");?>"><img src="{tpl_path}images/default_icon.gif" border="0"> 查看已采集商品</a></td>
  </tr>
</table>
<form method="post" name="list_form" id="list_form">
  <table width="100%" cellspacing="0" class="widefat">
    <thead>
      <tr>
        <th width="3%"><input type="checkbox" onclick="check_box(this.form.rd_id)" /></th>
        <th width="20%">规则名称</th>
        <th width="52%">采集网址</th>
        <th width="11%">总页数</th>
        <th width="14%">操作</th>
      </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody id="check_box_id">
      <?php foreach($query as $row) {?>
      <tr>
        <td><input name="rd_id[]" type="checkbox" id="rd_id" value="<?php echo $row->id;?>"></td>
        <td><?php echo $row->title;?></td>
        <td><?php echo $row->f_url;?></td>
        <td><?php echo $row->page_total;?></td>
        <td><a href="<?php echo site_url(CTL_FOLDER."u_rule/edit_record/".$row->id);?>?url=<?php echo get_curren_url();?>">修改</a> | <a href="<?php echo site_url(CTL_FOLDER."u_rule/edit_copy_record/".$row->id);?>?url=<?php echo get_curren_url();?>">复制</a> | <a href="<?php echo site_url(CTL_FOLDER."u_rule/caiji/".$row->id);?>">采集</a></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="padding-top:5px"><input type="checkbox" onclick="check_box(this.form.rd_id)" />
        全选
        <select name="action_url" id="action_url">
          <option value="" style="color:#FF0000">-选择操作-</option>
          <option value="<?php echo site_url(CTL_FOLDER."u_rule/del_record");?>">删除</option>
        </select>
        <input type="button" name="submit_list_button" class="button-style2" onclick="submit_list_form(this.form,this)" id="submit_list_button" value="执行操作" />
      </td>
      <td align="right"><?php echo $paginate;?></td>
    </tr>
  </table>
</form>
<?php $this->load->view(TPL_FOLDER."footer");?>
