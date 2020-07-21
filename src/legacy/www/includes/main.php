<?php

$message_info = '';
$message_error = '';
$content = '';
$content2 = '';
$old_q = '';

if (isset($_POST['q']) && !isset($_POST['from']) && !isset($_POST['to'])) {
  $_POST['from'] = 'detect';
  $_POST['to'] = 'all';
}

if (isset($_POST['q']) && isset($_POST['from']) && isset($_POST['to'])) {
  if (trim($_POST['q'])) {
    $p_from = mysqli_real_escape_string(Database::$mysqli, $_POST['from']);
    $p_to = mysqli_real_escape_string(Database::$mysqli, $_POST['to']);
    $p_q = mysqli_real_escape_string(Database::$mysqli, trim($_POST['q']));
    $p_q_url = str_replace(' ','_',$p_q);
    $old_q = " value=\"$p_q\"";
    if (($p_from == 'detect') && ($p_to == 'all')) {
      // from <b>detect</b> to <b>all</b>';
      $languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
      $languages_detected = array();
      $word_detected = '';
      while ($lang = mysqli_fetch_assoc($languages)) {
        $lang_table = $lang['domain'].'__words';
        $word_found = mysqli_fetch_assoc(Database::query("SELECT * FROM $lang_table WHERE word = '$p_q'"));
        if ($word_found) {
          $languages_detected[] = $lang;
          $word_detected = $word_found['word'];
        }
      }
      if (count($languages_detected) <= 0) {
        $message_error = 'The term <b>'.$p_q.'</b> has not been found in any language.';
      } elseif (count($languages_detected) == 1) {
        $word_found_url = str_replace(' ','_',$word_detected);
        Site::redirect(Site::$url.$languages_detected[0]['domain'].'/'.$word_found_url);
      } else {
        // ex. width="600"
        $message_info = 'The word <b>'.$p_q.'</b> has been found in <b>'.count($languages_detected).'</b> languages';
        $content2 .= '<center><table border="0" cellspacing="2" cellpadding="3" width="728"><tr bgcolor="#d3dce3"><th align="center" width="50%"><b>Language</b></th><th align="center" width="50%"><b>Word</b></th></tr>';
        for ($i = 0; $i < count($languages_detected); $i++) {
          $lang_table = $languages_detected[$i]['domain'].'__words';
          $word_found = mysqli_fetch_assoc(Database::query("SELECT * FROM $lang_table WHERE word = '$p_q'"));
          $content2 .= "<tr><td>{$languages_detected[$i]['language']}</td><td><a href=\"/{$languages_detected[$i]['domain']}/{$word_found['word']}\">{$word_found['word']}</a></td></tr>";
        }
        $content2 .= '</table></center>';
      }
    } elseif ($p_from == 'detect') {
      //TODO: 'from <b>detect</b> to a <b>language</b>';
    } elseif ($p_to == 'all') {
      // 'from a <b>language</b> to <b>all</b>';
      $lang1 = $p_from;
      $language1 = mysqli_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '$lang1' AND active IS NOT null"));
      if ($language1) {
        $lang1_table = $language1['domain'].'__words';
        $word1_found = mysqli_fetch_assoc(Database::query("SELECT * FROM $lang1_table WHERE word = '$p_q'"));
        if ($word1_found) {
          $word1_found_url = str_replace(' ','_',$word1_found['word']);
          Site::redirect(Site::$url.$language1['domain'].'/'.$word1_found_url);
        } else {
          $message_error = 'The word <b>'.$p_q.'</b> has not been found in the '.$language1['language'].' language.';
        }
      } else {
        $message_error = 'Unknown language (210)';
      }
    } else {
      // 'from a <b>language</b> to a <b>language</b>';
      $lang1 = $p_from;
      $lang2 = $p_to;
      $language1 = mysqli_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '$lang1' AND active IS NOT null"));
      $language2 = mysqli_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '$lang2' AND active IS NOT null"));
      if ($language1 && $language2) {
        $lang1_table = $language1['domain'].'__words';
        $word1_found = mysqli_fetch_assoc(Database::query("SELECT * FROM $lang1_table WHERE word = '$p_q'"));
        if ($word1_found) {
          $word1_found_url = str_replace(' ','_',$word1_found['word']);
          Site::redirect(Site::$url.$language1['domain'].'-'.$language2['domain'].'/'.$word1_found_url);
        } else {
          $message_error = 'The word <b>'.$p_q.'</b> has not been found in the '.$language1['language'].' language.';
        }
      } else {
        $message_error = 'Error has occured (211)';
      }
    }
  }
}

// TODO: Generate languages list
$content .= '<h1 style="text-align: center; margin-bottom: 0; padding-bottom: 0;"><a href="/" style="text-decoration: none; color: #696969;">DiiCT</a></h1>
<p style="text-align: center; margin-top: 0; padding-top: 0;"><font size="-2" color="grey">Open Live Multilingual Dictionary</font></p>

<form name="search" action="/" method="post">
<table border="0" cellspacing="0" cellpadding="0">
<tr><td width="75" style="font-size: 120%;">Search:</td>

<td><input type="text" name="q" id="word" size="24" style="font-size: 120%;"'.$old_q.' /></td><td><input type="submit" value="Submit" style="font-size: 120%;" /></td></tr>
</table>

<table border="0" cellspacing="0" cellpadding="5">

<tr><td width="50">From</td><td><select name="from">
<option value="detect" selected="selected">detect</option>';
  //$languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
  $languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY language");
  while ($lang = mysqli_fetch_assoc($languages)) {
    $content .= '<option value="'.$lang['domain'].'">'.$lang['language'].'</option>';
  }
  $content .= '</select></td>
<td width="30">To</td><td><select name="to">
<option value="all" selected="selected">all</option>';
  //$languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
  $languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY language");
  while ($lang = mysqli_fetch_assoc($languages)) {
    $content .= '<option value="'.$lang['domain'].'">'.$lang['language'].'</option>';
  }
  $content .= '</select></td></tr>

</table>
</form>
';

if ($message_error) {
  $content .= '<p style="color:red; text-align:center;">'.$message_error.'</p>';
}

if ($message_info) {
  $content .= "\n<p style=\"text-align:center;\">$message_info</p>\n";
}

if ($content2) {
  $content .= $content2;
}

Site::$meta_title = 'DiiCT.com - Free Online Multilingual Dictionary';
Site::$meta_description = 'Free Online Multilingual Dict. Search in English, German, French, Russian, Polish and Armenian';

// Output
Site::head();
Site::$content .= $content;
Site::foot();

?>
