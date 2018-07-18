<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0" >
  <tr>
    <td width="3%" align="left" ><img src="{tpl_path}images/forward.jpg" /></td>
    <td width="97%" align="left" >您现在的位置：店铺设置-按店铺采集商品</td>
  </tr>
</table>
<div class="ui-tx-tips-div" style="text-align:left">提示：<br>
  请填写要采集的淘宝或天猫店铺网址(以 http:// 开头)和对应的店铺掌柜账号，然后点击 下一步。<br>
</div>
<form method="post" action="<?php echo site_url(CTL_FOLDER.'shop_move/save_shop');?>">
  <table width="100%" border="0" cellspacing="0" cellpadding="5" style="margin:10px 0">
    <tr>
      <td width="18%" align=left><font style="color: #ff0000">*</font>店铺掌柜账号：</td>
      <td width="82%" align="left"><input type="text" name="nick" value="<?php echo $shop_config['nick'];?>" maxlength="50" size="20" dataType="Require" msg="该项必填，如果不懂填写，请看上面的教程" /></td>
    </tr>
    <tr>
      <td align=left><font style="color: #ff0000">*</font>淘宝店铺网址：</td>
      <td align="left"><input type="text" name="shop_url" value="<?php echo $shop_config['shop_url'];?>" size="70" dataType="Require" msg="该项必填，如果不懂填写，请看上面的教程" /></td>
    </tr>
    <tr>
      <td align=left><font style="color: #ff0000">*</font>其他设置：</td>
      <td align="left">折扣百分数：
        <input type="text" name="discount" size="3" maxlength="2" value="<?php echo $shop_config['discount'];?>" dataType="Custom" regexp="^[1-9]\d*$" msg="折扣百分数填写有误" />
      %  用于淘宝价格的基础上生成折扣价，范围1-99&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<label><input <?php if($shop_config['is_w'] == '1'){?> checked="checked"<?php }?> type="checkbox" name="is_w" value="1" />伪原创</label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="button" type="button" onclick="subForm(this.form,this)" class="button-style" value="下一步" /></td>
    </tr>
  </table>
</form>
<?php $this->load->view(TPL_FOLDER."footer");?>
