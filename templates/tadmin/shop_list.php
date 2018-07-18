<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."shop");?>">全部店铺</a></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:solid 1px #3C4952; margin-bottom:5px; margin-top:5px">
  <tr>
    <td width="65%" height="24" align="left" ><form method="get">
        <input type="text" name="s_keyword" id="s_keyword" size="15" maxlength="50">
        &nbsp;
        <select name="cid" style="width:180px">
          <option value="">-选择类目-</option>
          <?php foreach($shop_catalog as $row) {?>
          <option value="<?php echo $row->id;?>"><?php echo $row->cat_name;?></option>
          <?php }?>
        </select>
        &nbsp;
        <input type="submit" name="s_sb" value="搜索" class="button-style2">
      </form>
      &nbsp; <a href="?" style="color:#F00">全部</a></td>
    <td width="35%" align="left"><a href="<?php echo my_site_url(CTL_FOLDER.'shop_catalog/re_cache');?>"><img src="{tpl_path}images/refresh.jpg"  /> 更新缓存</a> | <a href="<?php echo site_url(CTL_FOLDER."shop/shop_add");?>"><img src="{tpl_path}images/add.png" /> 添加店铺</a></td>
  </tr>
</table>
<form method="post" name="list_form" id="list_form">
  <table width="100%" cellspacing="0" class="widefat">
    <thead>
      <tr id="trth">
        <th width="4%"><input type="checkbox" onclick="check_box(this.form.rd_id)" /></th>
        <th width="17%">缩略图</th>
        <th width="30%">店铺标题</th>
        <th width="15%">店铺分类</th>
        <th width="14%">排序</th>
        <th width="20%">操作</th>
      </tr>
    </thead>
    <tfoot>
    </tfoot>
    <tbody id="check_box_id">
      <?php foreach($query as $row) {?>
      <tr>
        <td class="rdId"><input name="rd_id[]" type="checkbox" id="rd_id" value="<?php echo $row->id;?>"></td>
        <td><img src="{tpl_path}images/loading.gif" rel="<?php echo get_real_path($row->pic_path);?>" border="0" class="jq_pic_loading"  /></td>
        <td><?php echo $row->title;?></td>
        <td><?php echo $row->cat_name;?></td>
        <td><input name="sort<?php echo $row->id;?>" value="<?php echo $row->seqorder;?>" type="text" size="2" maxlength="10" dataType="Integer" msg="排序号必须为数字" title="数字越大越靠前" /></td>
        <td><a href="<?php echo site_url(CTL_FOLDER."shop/shop_edit");?>?id=<?php echo $row->id;?>&url=<?php echo get_curren_url();?>">修改</a> | <a href="<?php echo my_site_url(CTL_FOLDER.'shop/shop_move/'.$row->id);?>">采集</a> | <a href="<?php echo my_site_url('shop/'.$row->id);?>" target="_blank">站内</a> | <a href="<?php echo $row->shop_url;?>" target="_blank">淘宝</a></td>
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
          <option value="<?php echo site_url(CTL_FOLDER."shop/sort_record");?>">排序</option>
          <option value="<?php echo site_url(CTL_FOLDER."shop/del_record");?>">删除</option>
        </select>
        <input type="button" name="submit_list_button" class="button-style2" onclick="submit_list_form(this.form,this)" id="submit_list_button" value="执行操作" /></td>
      <td align="right"><?php echo $paginate;?></td>
    </tr>
  </table>
</form>
<?php $this->load->view(TPL_FOLDER."footer");?>
