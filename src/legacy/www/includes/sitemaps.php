<?php

/*
* This file displays a single secondary sitemap file
*/

// TODO: Secure?

if (count(Site::$args) != 2) Site::notFound();

$file_req = Site::$args[1];

if (!$file_req) Site::notFound();

$sitemap_dir = HTTP_DIR.'/service/sitemaps/';
$file_path = $sitemap_dir.$file_req;

if (!file_exists($file_path)) Site::notFound();

Site::$headers[] = 'Content-Type: text/xml; charset=utf-8';
if (!(Site::$content = file_get_contents($file_path))) Site::notFound();

?>
