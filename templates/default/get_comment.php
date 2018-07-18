<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php foreach($query as $row){?>
<div style="margin-bottom:10px; border-bottom:1px dashed #ddd; padding-bottom:10px;">
<table width="100%" border="0" cellspacing="1" cellpadding="5">
  <tr>
    <td width="63%" align="left">用户：<?php echo $row->user_name;?></td>
    <td width="37%" align="right"><?php echo date('Y-m-d H:i:s',$row->create_date);?></td>
  </tr>
  <tr>
    <td colspan="2" align="left" style="line-height:22px"><?php echo format_textarea($row->content);?><br>
<?php if($row->reply){?>
<span style="color:#F30">[回复] &nbsp;<?php echo $row->reply;?></span>
<?php }?></td>
    </tr>
</table>
</div>
<?php }?>
<div class="ui-tx-page"> <?php echo $page_str;?> </div>
