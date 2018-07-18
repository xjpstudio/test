<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php echo '<?xml version="1.0" encoding="utf-8" ?>';?>
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84">
<url>
<loc><?php echo base_url();?></loc>
</url>
<?php foreach($product as $row){?>
<url>
<loc><?php echo site_url(CTL_FOLDER.'item/'.$row->id);?></loc>
<lastmod><?php echo date("Y-m-d",$row->create_date);?></lastmod>
</url>
<?php }?>
</urlset>
