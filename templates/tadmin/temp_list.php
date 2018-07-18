<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."product/temp");?>">全部待审核商品</a></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="border-bottom:solid 1px #3C4952; margin-bottom:5px; margin-top:5px">
  <tr>
    <td width="66%" height="24" align="left" ><form method="get">
        <input type="text" name="s_keyword" id="s_keyword" size="15" maxlength="50">
        &nbsp;
        <select name="cid" style="width:150px">
          <option value="">-选择类目-</option>
          <?php foreach(get_cache('catalog') as $row) {?>
          <option value="<?php echo $row->id;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
          <?php }?>
        </select>
        &nbsp;
        <input type="submit" name="s_sb" value="搜索" class="button-style2">
      </form>
      &nbsp; <a href="?" style="color:#F00">全部</a></td>
    <td width="34%" align="right"><a href="javascript:void(0)" onclick="if(confirm('确定要删除这些未审核的商品吗?')) document.location.href='<?php echo my_site_url(CTL_FOLDER.'product/clear_temp');?>'"><img src="{tpl_path}images/icon_trash.gif" /> 一键清空</a></td>
  </tr>
</table>
<form method="post" name="list_form" id="list_form">
  <table width="100%" cellspacing="0" class="widefat">
    <thead>
      <tr id="trth">
        <th width="3%"><input type="checkbox" onclick="check_box(this.form.rd_id)" /></th>
        <th width="9%">缩略图</th>
        <th width="31%">商品标题</th>
        <th width="11%">所属分类</th>
        <th width="12%">价格(￥)</th>
        <th width="6%">销量</th>
        <th width="12%">掌柜</th>
        <th width="11%">提交日期</th>
        <th width="5%">操作</th>
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
        <td><?php echo get_product_cat_name($row->catalog_id);?></td>
        <td><?php echo $row->shop_price;?>/<?php echo $row->dc_price;?></td>
        <td><?php echo $row->volume;?></td>
        <td><?php echo $row->nick;?></td>
        <td><?php echo date('Y-m-d',$row->create_date);?></td>
        <td><a href="<?php echo $row->click_url;?>" target="_blank">查看</a></td>
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
          <option value="<?php echo site_url(CTL_FOLDER."product/pass");?>">审核通过</option>
          <option value="<?php echo site_url(CTL_FOLDER."product/del_record_temp");?>">删除</option>
        </select>
        <input type="button" name="submit_list_button" class="button-style2" onclick="submit_list_form(this.form,this)" id="submit_list_button" value="执行操作" /></td>
      <td align="right"><?php echo $paginate;?></td>
    </tr>
  </table>
</form>
<?php $this->load->view(TPL_FOLDER."footer");?>
