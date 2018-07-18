<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：广告管理 </td>
  </tr>
</table>
<table width="100%" cellspacing="0" class="widefat">
  <thead>
    <tr id="trth">
      <th width="40%">缩略图</th>
      <th width="24%">广告标题</th>
      <th width="13%">尺寸(像素)</th>
      <th width="17%">位置说明</th>
      <th width="6%">操作</th>
    </tr>
  </thead>
  <tfoot>
  </tfoot>
  <tbody id="check_box_id">
    <?php foreach($query->result() as $row) {?>
    <tr>
      <td><?php 
		if($row->is_pic==1)
		{
			?>
        <img src="{tpl_path}images/loading.gif" rel="<?php echo get_real_path($row->file_path);?>" border="0" class="loading_300"  />
        <?php
		}
		else
		{
			echo "无缩略图";
		}
		?>      </td>
      <td><?php echo $row->title;?></td>
      <td><?php 
		echo $row->width." X ".$row->height;
		?>      </td>
      <td><?php echo $row->remark;?></td>
      <td><a href="<?php echo site_url(CTL_FOLDER."ads/edit_record/".$row->id);?>">修改</a></td>
    </tr>
    <?php }?>
  </tbody>
</table>
<script language="javascript">
$(function(){
	$(".loading_300").each(function(){
		LoadImage($(this),$(this).attr("rel"),300);
	});
});
</script>
<?php $this->load->view(TPL_FOLDER."footer");?>
