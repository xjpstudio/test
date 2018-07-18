<form>
  <input type="text" name="s_keyword" size="15" maxlength="50">&nbsp;<select name="s_catalog_id">
    <option value="">-选择分类-</option>
    <?php foreach($catalog_list as $row) {?>
    <option value="<?php echo $row->id;?>"><?php echo str_repeat("&nbsp;&nbsp;&nbsp;&nbsp;",$row->deep_id).$row->cat_name;?></option>
    <?php }?>
  </select>&nbsp;<input type="submit" value="搜索" class="button-style2">
</form>
