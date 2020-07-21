<?php
class Database {

  //public static $server = 'localhost';
  public static $server = '127.0.0.1';
  public static $username = 'usename';
  public static $password = 'paasword';
  public static $dbname = 'diict';

  public static $mysqli = '';


  public static function init() {
    self::$mysqli = new mysqli(self::$server, self::$username, self::$password, self::$dbname);
	self::$mysqli->set_charset('utf8');
  }

  public static function query($query) {
    if (self::$mysqli == '') self::init();
    //if (self::$link == '') self::init();
    ////return mysql_query($query);
    //$result = mysql_query($query);
	$result = self::$mysqli->query($query);
    if ($result) return $result;
    //else die('Invalid query: ' . mysql_error());
  }
}
?>
