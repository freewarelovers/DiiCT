<?php

/*
/ This file simply lists already generated sitemap files from the "service/sitemaps/" directory.
*/

if (count(Site::$args) != 1) Site::notFound();

$sitemap_dir = HTTP_DIR.'/service/sitemaps/';

$files_smap = array();

$dir_handle = opendir($sitemap_dir);
while($file = readdir($dir_handle)) {
	if (($file != '.') && ($file != '..') && (strlen($file) == 14)) $files_smap[] = $file;
}
closedir($dir_handle);

sort($files_smap);

Site::$headers[] = 'Content-Type: text/xml; charset=utf-8';
Site::$content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<sitemapindex xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n                            http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd\">\n";

for ($i = 0; $i < count($files_smap); $i++) {
  Site::$content .= "<sitemap>\n\t<loc>".Site::$url.'sitemaps/'.$files_smap[$i]."</loc>\n</sitemap>\n";
}

Site::$content .= "</sitemapindex>\n";

?>
