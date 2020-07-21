<?php

/*
* This script generates sitemaps when CRON touches it.
*/

// Protect from external initiation
if ($_SERVER['SERVER_ADDR'] != $_SERVER['REMOTE_ADDR']) die();

$main_url = 'http://diict.com/';

$server = 'localhost';
$username = 'username';
$password = 'password';
$dbname = 'diict';
$dblink = '';

$sitemap_dir = HTTP_DIR.'/service/sitemaps/';
$sitemap_lim = 50000;
$sitemap_tmp = '';
$sitemap_urls = 0;
$sitemap_files = 1;

$files_new = array();
$files_old = array();

$dir_handle = opendir($sitemap_dir);

while($file = readdir($dir_handle)) {
	if (($file != '.') && ($file != '..')) $files_old[] = $file;
}

closedir($dir_handle);

///////////////////////////////////////////////////////////////////

$dblink = mysql_connect($server, $username, $password);
mysql_set_charset('utf8');
mysql_select_db($dbname);

start_new();

// Main page
$sitemap_tmp .= "<url><loc>".$main_url."</loc></url>\n";
$sitemap_urls++;

// Language homepages
$languages = mysql_query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
while ($language = mysql_fetch_assoc($languages)) {
  $sitemap_tmp .= "<url><loc>".$main_url.$language['domain']."</loc></url>\n";
  $sitemap_urls++;
}

// Language pairs homepages
$languages1 = mysql_query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
while ($language1 = mysql_fetch_assoc($languages1)) {
  $languages2 = mysql_query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
  while ($language2 = mysql_fetch_assoc($languages2)) {
    if ($language1['domain'] != $language2['domain']) {
      $sitemap_tmp .= "<url><loc>".$main_url.$language1['domain'].'-'.$language2['domain']."</loc></url>\n";
      $sitemap_urls++;
    }
  }
}

// Language words
$languages = mysql_query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
while ($language = mysql_fetch_assoc($languages)) {
  $words_table = $language['domain'].'__words';
  $words = mysql_query("SELECT * FROM $words_table");
  while ($word = mysql_fetch_assoc($words)) {
    if ($sitemap_urls >= $sitemap_lim) {
      finalize_current();
      start_new();
    }
    $sitemap_tmp .= "<url><loc>".$main_url.$language['domain'].'/'.urlencode(str_replace(' ','_',stripslashes($word['word'])))."</loc></url>\n";
    $sitemap_urls++;
  }
}

// TODO: Language pair words

finalize_current();

// Delete old sitemaps (and some other junk if existed)
for ($i = 0; $i < count($files_old); $i++) {
  unlink($sitemap_dir.$files_old[$i]);
}

// Name temp sitemap files properly
for ($i = 0; $i < count($files_new); $i++) {
  rename($sitemap_dir.$files_new[$i], $sitemap_dir.str_replace('_tmp_','sitemap',$files_new[$i]));
}

function finalize_current()
{
  global $sitemap_tmp, $sitemap_files, $sitemap_dir, $files_new, $sitemap_files, $sitemap_urls;
  $sitemap_tmp .= "</urlset>\n";
  if (intval($sitemap_files) > 99) $tempfile = '_tmp_'.intval($sitemap_files).'.xml';
  elseif (intval($sitemap_files) > 9) $tempfile = '_tmp_0'.intval($sitemap_files).'.xml';
  else $tempfile = '_tmp_00'.intval($sitemap_files).'.xml';
  file_put_contents($sitemap_dir.$tempfile, $sitemap_tmp);
  $files_new[] = $tempfile;
  $sitemap_files++;
  $sitemap_tmp = '';
  $sitemap_urls = 0;
}

function start_new()
{
  global $sitemap_tmp;
  $sitemap_tmp = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\"\n        xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n        xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9\n                            http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">\n";
}

?>
