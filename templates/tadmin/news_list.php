<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."news");?>">全部文章</a> </td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:solid 1px #3C4952; margin-bottom:5px; margin-top:5px">
  <tr>
    <td width="457" height="24" align="left" ><?php $this->load->view(TPL_FOLDER.'search');?></td>
    <td width="300" align="right" ><a href="<?php echo site_url(CTL_FOLDER."news/add_record_view");?>"><img src="{tpl_path}images/add.png"> 添加文章</a> | <a href="<?php echo site_url(CTL_FOLDER."news_catalog");?>"><img src="{tpl_path}images/default_icon.gif" border="0"> 管理分类</a></td>
  </tr>
</table>
<form method="post" name="list_form" id="list_form">
  <table width="100%" cellspacing="0" class="widefat">
    <thead>
      <tr id="trth">
        <th width="3%"><input type="checkbox" onclick="check_box(this.form.rd_id)" /></th>
        <th width="11%">缩略图</th>
        <th width="29%" id="title">标题</th>
        <th width="12%">所属分类</th>
        <th width="8%">点击数</th>
        <th width="10%">发布日期</th>
        <th width="10%">排序</th>
        <th width="17%">操作</th>
      </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody id="check_box_id">
      <?php foreach($query as $row) {?>
      <tr>
        <td class="rdId"><input name="rd_id[]" type="checkbox" id="rd_id" value="<?php echo $row->id;?>"></td>
        <td><img src="{tpl_path}images/loading.gif" rel="<?php echo get_real_path($row->pic_path);?>" border="0" class="jq_pic_loading"  /></td>
        <td><div class="celltext"><?php echo $row->title;?></div></td>
        <td><?php echo $row->cat_name;?></td>
        <td><?php echo $row->hits;?></td>
        <td><?php echo date("Y-m-d",$row->create_date);?></td>
        <td><input name="sort<?php echo $row->id;?>" value="<?php echo $row->seqorder;?>" type="text" title="数字越大越靠前" size="2" maxlength="10" dataType="Integer" msg="排序号必须为数字"></td>
        <td><a href="<?php echo site_url(CTL_FOLDER."news/edit_record/".$row->id);?>?url=<?php echo get_curren_url();?>">修改</a> | <a href="<?php echo site_url(CTL_FOLDER."news/edit_copy_record/".$row->id);?>?url=<?php echo get_curren_url();?>">复制</a>
          <?php if( ! $row->is_create){?>
          | <a href="javascript:make_html(<?php echo $row->id;?>);" title="生成静态页面">生成</a>
          <?php }?> | <a href="<?php echo create_link($row->id);?>" target="_blank">查看</a></td>
      </tr>
      <?php }?>
    </tbody>
  </table>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td style="padding-top:5px"><input type="checkbox" onclick="check_box(this.form.rd_id)" />
        全选 <select name="action_url" id="action_url" onchange="to_catalog_onChange()">
          <option value="" style="color:#FF0000">-选择操作-</option>
          <option value="<?php echo site_url(CTL_FOLDER."news/del_record");?>">删除</option>
          <option value="<?php echo site_url(CTL_FOLDER."news/sort_record");?>">排序</option>
          <option value="<?php echo site_url(CTL_FOLDER."news/to_catalog");?>">转移到分类</option>
        </select>
        &nbsp; <span style="display:none" id="to_catalog_span">
        <select name="to_catalog_id" id="to_catalog_id">
          <option value="" style="color:#FF0000">-选择要转到的分类-</option>
          <?php foreach($catalog_list as $row) {?>
          <option value="<?php echo $row->queue;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
          <?php }?>
        </select>
        &nbsp;</span>
        <input type="button" name="submit_list_button" class="button-style2" onclick="submit_list_form(this.form,this)" id="submit_list_button" value="执行操作" />
        <img src="{tpl_path}images/notice.gif"  title="操作步骤：在左边勾选要操作的记录-->选择需要执行的操作-->点击“执行操作”按钮-->完成" /> </td>
      <td align="right"><?php echo $paginate;?></td>
    </tr>
  </table>
</form>
<script language="javascript">
$(function(){
	$("div.celltext").edit_table({
		param:{'table':'shop_news'}
	});
});
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
