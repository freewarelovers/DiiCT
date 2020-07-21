<?php
class Site {

  public static $name = 'DiiCT';
  public static $slogan = 'Open Live Multilingual Dictionary';
  public static $url = 'https://diict.com/';

  public static $email_admin = 'admin@example.com';
  public static $email_postmaster = 'noreply@diict.com';

  public static $request = '';
  public static $args = array();
  public static $headers = array();
  public static $content = '';
  public static $showads = true;

  public static $meta_title = 'DiiCT'; // Maximum 70 symbols for Google
  public static $meta_description = ''; // Maximum 150???????
  public static $meta_keywords = 'dictionary'; // Maximum 1024???????
  public static $meta_robots = 'index,follow,noarchive';
  
  public static $analytics = '<script async src="https://www.googletagmanager.com/gtag/js?id=UA-2783203-19"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag(\'js\', new Date());
gtag(\'config\', \'UA-2783203-19\');
</script>
';
  
  // On 15.01.2020 replaced the old AdSense code with this one
  public static $adsense = '<script data-ad-client="ca-pub-0113441673686829" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
';

  public static $ad_728x90 = '
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- diict_728x90 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-0113441673686829"
     data-ad-slot="6366737199"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
';
  public static $ad_336x280 = '
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- diict_336x280 -->
<ins class="adsbygoogle"
     style="display:inline-block;width:336px;height:280px"
     data-ad-client="ca-pub-0113441673686829"
     data-ad-slot="7250885484"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>
';

  public static function redirect($destination) {
    //self::$ads[] = "HTTP/1.1 301 Moved Permanently";
    header( "HTTP/1.1 301 Moved Permanently" );
    header( "Location: $destination" );
    die("Page moved permanently to $destination");
  }

  public static function redirectTemp($destination) {
    header( "Location: $destination" );
    die("Page moved temporarily to $destination");
  }

  public static function notFound() {
    header("HTTP/1.1 404 Not Found");
    die("<!DOCTYPE HTML PUBLIC \"-//IETF//DTD HTML 2.0//EN\">\n<html><head>\n<title>404 Not Found</title>\n</head><body>\n<h1>Not Found</h1>\n<p>The requested URL {$_SERVER["REQUEST_URI"]} was not found on this server.</p>\n<hr>\n</body></html>\n"); //{$_SERVER["SERVER_SIGNATURE"]}\n
  }

  public static function log() {
    $date = date("Ymd");
    $date_ym = date("Ym");
    $time = date("H:i:s");
    $query = $_SERVER['REQUEST_URI'];
    $domain = $_SERVER['HTTP_HOST'];
    $ip = $_SERVER['REMOTE_ADDR'];
    $host = gethostbyaddr($ip);
    $agent = $_SERVER['HTTP_USER_AGENT'];
    $root = $_SERVER['DOCUMENT_ROOT'];
    if ($host==$ip) $m_host = 'no_host';
    else $m_host=$host;
    if (isset($_SERVER['HTTP_REFERER'])) $ref = $_SERVER['HTTP_REFERER'];
    else $ref='no_ref';
    $file = $root.'/logs/notfound_'.$date_ym.'.txt';
    $fh = fopen($file, 'a');
    $line = "$date|$time|$query|$domain|$ip|$m_host|$ref|$agent\n";
    fwrite($fh, $line);
    fclose($fh);
  }

  public static function head() {
    self::$content = '<!DOCTYPE html>
<html lang="en">
<head>
';

self::$content .= '<title>'.self::$meta_title.'</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="'.self::$meta_description.'" />
<meta name="keywords" content="'.self::$meta_keywords.'" />
<meta name="robots" content="'.self::$meta_robots.'" />
<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />
<link rel="search" type="application/opensearchdescription+xml" title="DiiCT Search" href="/search/diictsearch.xml" />
';

if (Site::$showads) {
  self::$content .= self::$analytics;
  self::$content .= self::$adsense;
}

self::$content .= '</head>
<body>
';
  }

  public static function foot() {
    self::$content .= '
<p style="text-align: center; margin-bottom: 0; padding-bottom: 0;"><font size="-2" color="grey">&copy;2009-'.date("Y").' <a href="'.self::$url.'">DiiCT</a></font></p>
</body>
</html>
';
  }

  public static function output() {
    foreach (self::$headers as $header) {
      header($header);
    }
    print(self::$content);
  }
}
?>
