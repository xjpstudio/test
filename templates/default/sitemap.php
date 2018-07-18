<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<link rel="stylesheet" type="text/css" href="{tpl_path}style/sitemap.css" />
<div class="wrap"> <?php echo get_ads(6);?> </div>
<div class="wrap">
  <div class="ui-tx-nav-bar"><a href="<?php echo ROOT_PATH;?>">首页</a><?php echo $nav;?></div>
</div>
<div class="wrap">
  <div class="sitemap_main">
    <div class="list-box">
      <table width="97%" border="0" cellspacing="0" cellpadding="0" style="margin:0 auto">
        <tr>
          <td class="sm_title">商品分类</td>
        </tr>
        <tr>
          <td class="sm_body"><?php foreach(get_cache('catalog') as $row){?>
            <a href="<?php echo my_site_url('search');?>?cid=<?php echo $row->id;?>" target="_blank" title="<?php echo $row->cat_name;?>"><?php echo $row->cat_name;?></a>
            <?php }?></td>
        </tr>
        <tr>
          <td class="sm_title">文章分类</td>
        </tr>
        <tr>
          <td class="sm_body"><?php foreach(get_cache('ncatalog') as $row){?>
            <a href="<?php echo create_link('p'.$row->id);?>" target="_blank" title="<?php echo $row->cat_name;?>"><?php echo $row->cat_name;?></a>
            <?php }?></td>
        </tr>
        <tr>
          <td class="sm_title">随机店铺</td>
        </tr>
        <tr>
          <td class="sm_body"><?php foreach($shop as $row){?>
            <a href="<?php echo my_site_url('shop/'.$row->id);?>" target="_blank" title="<?php echo $row->title;?>"><?php echo $row->title;?></a>
            <?php }?></td>
        </tr>
        <tr>
          <td class="sm_title">随机商品</td>
        </tr>
        <tr>
          <td class="sm_body"><?php foreach($product as $row){?>
            <a href="<?php echo my_site_url('item/'.$row->id);?>" target="_blank" title="<?php echo $row->title;?>"><?php echo $row->title;?></a>
            <?php }?></td>
        </tr>
        <tr>
          <td class="sm_title">随机文章</td>
        </tr>
        <tr>
          <td class="sm_body"><?php foreach($news as $row){?>
            <a href="<?php echo create_link($row->id);?>" target="_blank" title="<?php echo $row->title;?>"><?php echo $row->title;?></a>
            <?php }?></td>
        </tr>
      </table>
    </div>
  </div>
</div>
<?php $this->load->view(TPL_FOLDER."footer");?>
