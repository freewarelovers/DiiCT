<?php

if (count(Site::$args) > 2) Site::notFound();

$path = Site::$args[0];
$language = mysqli_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '$path' AND active IS NOT null"));

if (!$language) Site::notFound();

$content = '';

if (count(Site::$args) == 2) { // If a word in a language is requested, e.g. diict.com/en/dog
  if (!Site::$args[1]) Site::redirect(Site::$url.$language['domain']); // diict.com/en/ -> diict.com/en
  //if (trim(Site::$args[1]) !== Site::$args[1]) Site::redirect(Site::$url.$language['domain'].'/'.trim(Site::$args[1])); // diict.com/en/ dog -> diict.com/en/dog
  $p_word = str_replace('_',' ',trim(urldecode(Site::$args[1])));
  $p_word_sql = mysqli_real_escape_string(Database::$mysqli, $p_word);
  $old_q = " value=\"$p_word\"";
  Site::$meta_title = "$p_word | Online {$language['language']} Dictionary | ".Site::$name;
  Site::$meta_description = "$p_word - translation of $p_word from {$language['language']} at DiiCT.com - a free multilingual online dict";
  $content .= '<h1 style="text-align: center; margin-bottom: 0; padding-bottom: 0;"><a href="/" style="text-decoration: none; color: #696969;">DiiCT</a></h1>
<p style="text-align: center; margin-top: 0; padding-top: 0;"><font size="-2" color="grey">Open Live Multilingual Dictionary</font></p>

<form name="search" action="/" method="post">
<center>
<table border="0" cellspacing="0" cellpadding="0">
<tr><td width="75" style="font-size: 120%;">Search:</td>

<td><input type="text" name="q" id="word" size="24" style="font-size: 120%;"'.$old_q.' /></td><td><input type="submit" value="Submit" style="font-size: 120%;" /></td></tr>
</table>

<table border="0" cellspacing="0" cellpadding="5">
<tr><td width="50">From</td><td><select name="from">
<option value="detect">detect</option>';
  $languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
  while ($lang = mysqli_fetch_assoc($languages)) {
    $content .= '<option value="'.$lang['domain'].'"';
    if ($lang['domain'] == $path) $content .= ' selected="selected"';
    $content .= '>'.$lang['language'].'</option>';
  }
  $content .= '</select></td>
<td width="30">To</td><td><select name="to">
<option value="all" selected="selected">all</option>';
  $languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
  while ($lang = mysqli_fetch_assoc($languages)) {
    $content .= '<option value="'.$lang['domain'].'">'.$lang['language'].'</option>';
  }
  $content .= '</select></td></tr>

</table>
</center>
</form>
';
  $lang1_table = $language['domain'].'__words';
  $word1_found = mysqli_fetch_assoc(Database::query("SELECT * FROM $lang1_table WHERE word = '$p_word_sql'"));
  if ($word1_found) {
    $content .= '<center><table border="0" cellspacing="2" cellpadding="3" width="728"><tr bgcolor="#d3dce3"><th align="center" width="50%"><b>Language</b></th><th align="center" width="50%"><b>Translation</b></th></tr>';
    $languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
    while ($lang = mysqli_fetch_assoc($languages)) {
      //echo('while:'.$lang['domain'].', base:'.$language['domain']);
      if ($lang['domain'] != $language['domain']) {
        if ($language['domain'] < $lang['domain']) {
          // if our base language domain (in URL) is alphabetically earlier that the iterated domain
          $trans_table = 'trans__'.$language['domain'].'_'.$lang['domain'];
          $lang2_table = $lang['domain'].'__words';
          $result = Database::query("SHOW TABLES LIKE '$trans_table'");
          if (!(mysqli_num_rows($result) > 0)) continue;
          $trans_found = Database::query("SELECT * FROM $trans_table WHERE wid1 = '{$word1_found['wid']}'");
          while ($trans = mysqli_fetch_assoc($trans_found)) {
            $word2_found = mysqli_fetch_assoc(Database::query("SELECT * FROM $lang2_table WHERE wid = '{$trans['wid2']}'"));
            $term2_found_url = str_replace(' ','_',$word2_found['word']);
            $content .= "<tr><td>{$lang['language']}</td><td><a href=\"/{$lang['domain']}/$term2_found_url\">{$word2_found['word']}</a></td></tr>";
          }
        } else {
          $trans_table = 'trans__'.$lang['domain'].'_'.$language['domain'];
          $lang2_table = $lang['domain'].'__words';
          $result = Database::query("SHOW TABLES LIKE '$trans_table'");
          if (!(mysqli_num_rows($result) > 0)) continue;
          $trans_found = Database::query("SELECT * FROM $trans_table WHERE wid2 = '{$word1_found['wid']}'");
          while ($trans = mysqli_fetch_assoc($trans_found)) {
            $word2_found = mysqli_fetch_assoc(Database::query("SELECT * FROM $lang2_table WHERE wid = '{$trans['wid1']}'"));
            $term2_found_url = str_replace(' ','_',$word2_found['word']);
            $content .= "<tr><td>{$lang['language']}</td><td><a href=\"/{$lang['domain']}/$term2_found_url\">{$word2_found['word']}</a></td></tr>";
          }
        }
        //$content .= "<p>Searching in $lang_table</p>";
        
      }
    }
    $content .= '</table></center>';
  } else {
    $content .= '<p style="color:red; text-align:center;">The word <b>'.$p_word.'</b> has not been found in the '.$language['language'].' language.</p>';
  }

} else { // If language homepage is requested, e.g. diict.com/en
  Site::$meta_title = 'Free Online '.$language['language'].' Dictionary | '.Site::$name;
  Site::$meta_description = "Free Online {$language['language']} Dictionary at DiiCT.com - an online multilingual free dict";
  $content .= '<h1 style="text-align: center; margin-bottom: 0; padding-bottom: 0;"><a href="/" style="text-decoration: none; color: #696969;">DiiCT</a></h1>
<p style="text-align: center; margin-top: 0; padding-top: 0;"><font size="-2" color="grey">Open Live Multilingual Dictionary</font></p>

<form name="search" action="/" method="post">
<center>
<table border="0" cellspacing="0" cellpadding="0">
<tr><td width="75" style="font-size: 120%;">Search:</td>

<td><input type="text" name="q" id="word" size="24" style="font-size: 120%;" /></td><td><input type="submit" value="Submit" style="font-size: 120%;" /></td></tr>
</table>

<table border="0" cellspacing="0" cellpadding="5">
<tr><td width="50">From</td><td><select name="from">
<option value="detect">detect</option>';
  $languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
  while ($lang = mysqli_fetch_assoc($languages)) {
    $content .= '<option value="'.$lang['domain'].'"';
    if ($lang['domain'] == $path) $content .= ' selected="selected"';
    $content .= '>'.$lang['language'].'</option>';
  }
  $content .= '</select></td>
<td width="30">To</td><td><select name="to">
<option value="all" selected="selected">all</option>';
  $languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
  while ($lang = mysqli_fetch_assoc($languages)) {
    $content .= '<option value="'.$lang['domain'].'">'.$lang['language'].'</option>';
  }
  $content .= '</select></td></tr>

</table>
</center>
</form>
';

}

// Output
Site::head();
Site::$content .= $content;
Site::foot();

?>
