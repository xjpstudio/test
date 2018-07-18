<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：<a href="<?php echo site_url(CTL_FOLDER."product");?>">全部商品</a> &gt; <a href="<?php echo $url;?>">商品评论</a> &gt; 回复评论 </td>
  </tr>
</table>
<fieldset>
<legend>评价解释</legend>
  <form action="<?php echo site_url(CTL_FOLDER."comment/save_reply_comment");?>" method="post">
    <table width="100%"  border="0" cellpadding="3" cellspacing="0" >
      <tr>
        <td>解释内容：</td>
        <td><textarea name="reply" class="ui-tx-input" cols="50" rows="5"><?php echo $query->reply;?></textarea></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="button" onclick="subForm(this.form,this)" name="sbmit" value="确定" class="ui-tx-button2" /></td>
      </tr>
    </table>
    <input name="id" type="hidden" value="<?php echo $query->id;?>" />
    <input name="url" type="hidden" value="<?php echo $url;?>" />
  </form>
</fieldset>
<?php $this->load->view(TPL_FOLDER."footer");?>