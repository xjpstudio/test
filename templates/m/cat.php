<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $this->load->view(TPL_FOLDER."header");?>
<div class="viewport" style="padding-top:50px">
  <ul class="new-category-lst">
  <?php $catalog1 = $catalog2 = get_cache('catalog');
  foreach($catalog1 as $row1){
		if($row1->parent_id == 0){
	?>
    <li class="new-category-li"><a href="<?php echo my_site_url(CTL_FOLDER.'search');?>?cid=<?php echo $row1->id;?>" class="new-category-a"><span class="icon"></span><?php echo $row1->cat_name;?></a>
    <?php if($row1->is_has_chd == 1){?>
      <ul class="new-category2-lst">
        <li class="new-category2-li" > 
        <?php foreach($catalog2 as $row2){
			if($row2->parent_id == $row1->id){
		?>
        <a href='<?php echo my_site_url(CTL_FOLDER.'search');?>?cid=<?php echo $row2->id;?>' class="new-category2-a"><?php echo $row2->cat_name;?></a>
        <?php }}?>
        </li>
      </ul>
    <?php }?>  
    </li>
    <?php }}?>
  </ul>
</div>
<?php $this->load->view(TPL_FOLDER."footer");?>
