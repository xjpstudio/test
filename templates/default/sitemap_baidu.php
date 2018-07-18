<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php echo '<?xml version="1.0" encoding="utf-8" ?>';?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
       http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php foreach($product as $row){?>
<url>
<loc><?php echo site_url(CTL_FOLDER.'item/'.$row->id);?></loc>
<priority>1.00</priority>
<lastmod><?php echo date("Y-m-d",$row->create_date);?></lastmod>
<changefreq>daily</changefreq>
</url>
<?php }?>
</urlset>