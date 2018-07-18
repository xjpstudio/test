<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<link rel="stylesheet" type="text/css" href="{tpl_path}style/user.css" />
<div class="wrap">
  <div class="user_top_nav">
    <div class="user_profile"><a href="<?php echo my_site_url('user');?>"><img src="{tpl_path}images/profile.png" alt="个人资料" /> 个人资料</a></div>
    <div class="user_comment user_nav_cur"><a href="<?php echo my_site_url('user/comment');?>"><img src="{tpl_path}images/comment.png" alt="我的评论" /> 我的评论</a></div>
    <div class="user_logout"><a href="<?php echo my_site_url('login/logout');?>"><img src="{tpl_path}images/logout.png" alt="退出登录" /> 退出登录</a></div>
    <div style="clear:both"></div>
  </div>
  <div class="user_main" style="height:auto; padding-bottom:10px">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" style=" margin-bottom:5px;">
      <tr>
        <td height="24" align="center" ><?php foreach($num as $row){?>
          <?php if($row->is_pass){?>
          <a href="<?php echo site_url(CTL_FOLDER."user/comment");?>?is_pass=1">已审核(<font style="color:#FF0000"><?php echo $row->num;?></font>)</a> &nbsp;&nbsp;&nbsp;&nbsp;
          <?php }else{?>
          <a href="<?php echo site_url(CTL_FOLDER."user/comment");?>?is_pass=0">等待审核(<font style="color:#FF0000"><?php echo $row->num;?></font>)</a> &nbsp;&nbsp;&nbsp;&nbsp;
          <?php } }?></td>
      </tr>
    </table>
    <table width="100%" border="0" cellpadding="5" cellspacing="0" style="margin:5px 0">
      <tbody>
        <?php foreach($query as $row){?>
        <tr>
          <td width="49%" height="25" align="left" bgcolor="#F0F0F0">状态：
            <?php if($row->is_pass) echo '<font color="#009900">已审核</font>'; else echo '<font color="#FF0000">等待审核</font>';?></td>
          <td width="51%" align="right" bgcolor="#F0F0F0">评论日期：<?php echo date('Y-m-d H:i:s',$row->create_date);?></td>
        </tr>
        <tr>
          <td height="25" colspan="2" align="left" style="line-height:25px">评论商品：<a href="<?php echo my_site_url(CTL_FOLDER.'item/'.$row->product_id);?>" target="_blank"><?php echo $row->title;?></a><br />
            评论内容：<?php echo format_textarea($row->content);?> <br />
            回复内容：<?php echo format_textarea($row->reply);?></td>
        </tr>
        <?php }?>
      </tbody>
    </table>
    <div class="ui-tx-page"><?php echo $paginate;?></div>
    <?php if( ! $query){?>
    <div style=" text-align:center; padding:10px; color:#F00; font-size:14px">您暂无发布任何评论...</div>
    <?php }?>
  </div>
</div>
<?php $this->load->view(TPL_FOLDER."footer");?>
