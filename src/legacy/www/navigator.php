<?php
class Navigator {

  public static function parseRequest() {
    Site::$request = $_SERVER['REQUEST_URI'];
    // Added on 12.01.2020 to fix the query string bug! (e.g. https://diict.com/?utm_source=analytics_test&utm_medium=referral)
    $path_without_query = Site::$request;
    if (!empty($_SERVER['QUERY_STRING'])) {
      $path_without_query = explode('?', Site::$request)[0];
    }
    Site::$args = explode('/', $path_without_query);
    //Site::$args = explode('/',Site::$request);
    array_shift(Site::$args);
    //if (strstr(Site::$args[0],'search?')) Site::$args[0] = "search";
	}

  // Goes thru 3 stages: 1. Check in pages, 2. Check in languages, 3. Check in dictionaries
  public static function navigate() {
    self::parseRequest();
    date_default_timezone_set('America/New_York');

    $path = Site::$args[0];
    //$page = mysql_fetch_assoc(Database::query("SELECT * FROM pages WHERE path = '$path'")); // WHERE exclude_sitemap IS NULL
    $page = mysqli_fetch_assoc(Database::query("SELECT * FROM pages WHERE path = '$path'"));

    if ($page) {
      require_once "./includes/{$page['file']}";
    } else {
      //$language = mysql_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '$path' AND active IS NOT null"));
      $language = mysqli_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '$path' AND active IS NOT null"));
      if ($language) {
        require_once "./includes/language.php";
      } else {
        if ((strlen($path) == 5) && ($path[2] == '-')) {
          $lang1 = $path[0].$path[1];
          $lang2 = $path[3].$path[4];
          if ($lang1 == $lang2) {
            if (isset(Site::$args[1])) Site::redirect(Site::$url.$lang1.'/'.Site::$args[1]);
            else Site::redirect(Site::$url.$lang1);
          }
          //$language1 = mysql_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '$lang1' AND active IS NOT null"));
          //$language2 = mysql_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '$lang2' AND active IS NOT null"));
          $language1 = mysqli_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '$lang1' AND active IS NOT null"));
          $language2 = mysqli_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '$lang2' AND active IS NOT null"));
          if ($language1 && $language2) require_once "./includes/language_pair.php";
          else Site::notFound();
        } else Site::notFound();
      }
    }
  }

}
?>
