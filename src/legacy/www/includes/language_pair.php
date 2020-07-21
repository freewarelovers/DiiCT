<?php

if (count(Site::$args) > 2) Site::notFound();

$path = Site::$args[0];
if (!((strlen($path) == 5) && ($path[2] == '-'))) Site::notFound();

$lang1 = $path[0].$path[1];
$lang2 = $path[3].$path[4];

$language1 = mysqli_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '$lang1' AND active IS NOT null"));
$language2 = mysqli_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '$lang2' AND active IS NOT null"));

if (!($language1 && $language2)) Site::notFound();

$content = '';

if (count(Site::$args) == 2) { // If a word in a language pair is requested, e.g. diict.com/en-ru/dog
  $p_word = str_replace('_',' ',urldecode(trim(Site::$args[1])));
  $p_word_sql = mysqli_real_escape_string(Database::$mysqli, $p_word);
  //TODO: if ($p_word == '') Site::redirect(Site::$url.$language['domain']); // diict.com/en/ -> diict.com/en
  $old_q = " value=\"$p_word\"";
  Site::$meta_title = $p_word.' | Online '.$language1['language'].'-'.$language2['language'].' Dictionary | '.Site::$name;
  Site::$meta_description = "$p_word - translation of $p_word from {$language1['language']} to {$language2['language']} at DiiCT.com - a free dict";
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
    if ($lang['domain'] == $language1['domain']) $content .= ' selected="selected"';
    $content .= '>'.$lang['language'].'</option>';
  }
  $content .= '</select></td>
<td width="30">To</td><td><select name="to">
<option value="all">all</option>';
  $languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
  while ($lang = mysqli_fetch_assoc($languages)) {
    $content .= '<option value="'.$lang['domain'].'"';
    if ($lang['domain'] == $language2['domain']) $content .= ' selected="selected"';
    $content .= '>'.$lang['language'].'</option>';
  }
  $content .= '</select></td></tr>
</table>
</center>
</form>
';
  $lang1_table = $language1['domain'].'__words';
  $word1_found = mysqli_fetch_assoc(Database::query("SELECT * FROM $lang1_table WHERE word = '$p_word_sql'"));
  $term1_found_url = str_replace(' ','_',$word1_found['word']);
  if ($word1_found) {
    $lang2_table = $language2['domain'].'__words';
    $content .= '<br \><br \><center><table border="0" cellspacing="2" cellpadding="3" width="600"><tr bgcolor="#d3dce3"><th align="center" width="50%"><b>'.$language1['language'].'</b></th><th align="center" width="50%"><b>'.$language2['language'].'</b></th></tr>';
    if ($language1['lid'] < $language2['lid']) {
      $trans_table = 'trans__'.$language1['domain'].'_'.$language2['domain'];
      $trans_found = Database::query("SELECT * FROM $trans_table WHERE wid1 = '{$word1_found['wid']}'");
        while ($trans = mysqli_fetch_assoc($trans_found)) {
          $word2_found = mysqli_fetch_assoc(Database::query("SELECT * FROM $lang2_table WHERE wid = '{$trans['wid2']}'"));
          $term2_found_url = str_replace(' ','_',$word2_found['word']);
          $content .= "<tr><td><a href=\"/{$language1['domain']}-{$language2['domain']}/$term1_found_url\">{$word1_found['word']}</a></td><td><a href=\"/{$language2['domain']}-{$language1['domain']}/$term2_found_url\">{$word2_found['word']}</a></td></tr>";
        }
    } else {
      $trans_table = 'trans__'.$language2['domain'].'_'.$language1['domain'];
      $trans_found = Database::query("SELECT * FROM $trans_table WHERE wid2= '{$word1_found['wid']}'");
        while ($trans = mysqli_fetch_assoc($trans_found)) {
          $word2_found = mysqli_fetch_assoc(Database::query("SELECT * FROM $lang2_table WHERE wid = '{$trans['wid1']}'"));
          $term2_found_url = str_replace(' ','_',$word2_found['word']);
          $content .= "<tr><td><a href=\"/{$language1['domain']}-{$language2['domain']}/$term1_found_url\">{$word1_found['word']}</a></td><td><a href=\"/{$language2['domain']}-{$language1['domain']}/$term2_found_url\">{$word2_found['word']}</a></td></tr>";
        }
    }
    $content .= '</table></center>';
  } else {
    $content .= '<p style="color:red; text-align:center;">The word <b>'.$p_word.'</b> has not been found in the '.$language1['language'].' language.</p>';
  }

} else { // If language pair homepage is requested, e.g. diict.com/en-ru
  Site::$meta_title = 'Free Online '.$language1['language'].'-'.$language2['language'].' Dictionary | '.Site::$name;
  Site::$meta_description = "Free Online {$language1['language']}-{$language2['language']} Dictionary at DiiCT.com - an online multilingual free dict";
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
    if ($lang['domain'] == $language1['domain']) $content .= ' selected="selected"';
    $content .= '>'.$lang['language'].'</option>';
  }
  $content .= '</select></td>
<td width="30">To</td><td><select name="to">
<option value="all">all</option>';
  $languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
  while ($lang = mysqli_fetch_assoc($languages)) {
    $content .= '<option value="'.$lang['domain'].'"';
    if ($lang['domain'] == $language2['domain']) $content .= ' selected="selected"';
    $content .= '>'.$lang['language'].'</option>';
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
