<?php

if (count(Site::$args) != 1) Site::notFound();

Site::$meta_robots = 'noindex,nofollow,noarchive';

Site::$meta_title = 'Add to '.Site::$name;
$content = '';
$message_error = '';
$message_success = '';

if (isset($_POST['submitted'])) {
  $lang1 = mysql_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '{$_POST['languages'][0]}' AND active IS NOT null"));
  $lang2 = mysql_fetch_assoc(Database::query("SELECT * FROM languages WHERE domain = '{$_POST['languages'][1]}' AND active IS NOT null"));
  $lang1_table = $_POST['languages'][0].'__words';
  $lang2_table = $_POST['languages'][1].'__words';
  $word1_found = mysql_fetch_assoc(Database::query("SELECT * FROM $lang1_table WHERE word LIKE BINARY '{$_POST['words'][0]}'"));
  $word2_found = mysql_fetch_assoc(Database::query("SELECT * FROM $lang2_table WHERE word LIKE BINARY '{$_POST['words'][1]}'"));
  if (!$word1_found) {
    Database::query("INSERT INTO $lang1_table SET word = '{$_POST['words'][0]}'");
    $word1_found = mysql_fetch_assoc(Database::query("SELECT * FROM $lang1_table WHERE word LIKE BINARY '{$_POST['words'][0]}'"));
    $message_success .= 'Word <b>'.$word1_found['word'].'</b> has been added to <b>'.$_POST['languages'][0].'</b>-dict<br />';
  }
  if (!$word2_found) {
    Database::query("INSERT INTO $lang2_table SET word = '{$_POST['words'][1]}'");
    $word2_found = mysql_fetch_assoc(Database::query("SELECT * FROM $lang2_table WHERE word LIKE BINARY '{$_POST['words'][1]}'"));
    $message_success .= 'Word <b>'.$word2_found['word'].'</b> has been added to <b>'.$_POST['languages'][1].'</b>-dict<br />';
  }
  if ($lang1['lid'] < $lang2['lid']) {
    $trans_table = 'trans__'.$lang1['domain'].'_'.$lang2['domain'];
    $trans_found = mysql_fetch_assoc(Database::query("SELECT * FROM $trans_table WHERE wid1 = '{$word1_found['wid']}' AND wid2 = '{$word2_found['wid']}'"));
    if (!$trans_found) {
      Database::query("INSERT INTO $trans_table SET wid1 = '{$word1_found['wid']}', wid2 = '{$word2_found['wid']}'");
      $message_success .= 'Translation between <b>'.$word1_found['word'].'</b> and <b>'.$word2_found['word'].'</b> has been added<br />';
    }
  } else {
    $trans_table = 'trans__'.$lang2['domain'].'_'.$lang1['domain'];
    $trans_found = mysql_fetch_assoc(Database::query("SELECT * FROM $trans_table WHERE wid1 = '{$word2_found['wid']}' AND wid2 = '{$word1_found['wid']}'"));
    if (!$trans_found) {
      Database::query("INSERT INTO $trans_table SET wid1 = '{$word2_found['wid']}', wid2 = '{$word1_found['wid']}'");
      $message_success .= 'Translation between <b>'.$word2_found['word'].'</b> and <b>'.$word1_found['word'].'</b> has been added<br />';
    }
  }
}

$content .= '<h1 style="text-align: center; margin-bottom: 0; padding-bottom: 0;">ADD</h1>';

if ($message_error) $content .= '<center><p style="color:red;">'.$message_error.'</p></center>';

if ($message_success) $content .= '<center><p style="color:green;">'.$message_success.'</p></center>';

// Build a combo [BEGIN]
$combo = '<p>Language: <select name="languages[]">';
$languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
while ($lang = mysql_fetch_assoc($languages)) {
  $combo .= '<option value="'.$lang['domain'].'">'.$lang['language'].'</option>';
}
$combo .= '</select> Word: <input type="text" name="words[]" maxlength="50" /></p>';
// Build a combo [END]

$content .= '<center>
<form name="add" action="/add" method="post">
<div name="combos" id="combos">';

//$content .= $combo."\n";
//$content .= $combo."\n";

$content .= '<p>Language: <select name="languages[]">';
$languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
while ($lang = mysql_fetch_assoc($languages)) {
  $content .= '<option value="'.$lang['domain'].'"';
  if ($lang['domain'] == 'pl') $content .= ' selected="selected"';
  $content .= '>'.$lang['language'].'</option>';
}
$content .= '</select> Word: <input type="text" name="words[]" maxlength="50" /></p>';

$content .= '<p>Language: <select name="languages[]">';
$languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
while ($lang = mysql_fetch_assoc($languages)) {
  $content .= '<option value="'.$lang['domain'].'"';
  if ($lang['domain'] == 'ru') $content .= ' selected="selected"';
  $content .= '>'.$lang['language'].'</option>';
}
$content .= '</select> Word: <input type="text" name="words[]" maxlength="50" /></p>';

$content .= '
</div>
<input type="submit" name="submitted" value="Submit">
<!-- <input type="button" value="+ Add Combo" onclick="add_combo()" /> -->
<script type="text/javascript">
function add_combo() {
  /*
  if(document.createElement) {
    var tr = document.createElement("tr");
    var td1 = document.createElement("td");
    var td2 = document.createElement("td");
    var input = document.createElement("input");
    td1.innerHTML = "Upload screenshot:";
    input.name = "screenshots[]";
    input.type = "file";
    td2.appendChild(input);
    tr.appendChild(td1);
    tr.appendChild(td2);
    document.getElementById("screenshotstbl").appendChild(tr);
  } else {
    document.getElementById("screenshotstbl").innerHTML += \'<tr><td>Upload screenshot:</td><td><input name="screenshots[]" type="file" /></td></tr>\';
  }
  */
  document.getElementById("combos").innerHTML += \''.$combo.'\';
}
</script>
</form>
</center>
';

// Output
Site::head();
Site::$content .= $content;
Site::foot();

?>
