<?php

if (count(Site::$args) != 1) Site::notFound();

Site::$meta_title = 'Stabilization | '.Site::$name;
$content = '';
$message_error = '';
$message_success = '';

if (isset($_POST['submitted'])) {
  $message_success = "*MAGIC*";
  print_r($_POST);
}

$content .= '<h1 style="text-align: center; margin-bottom: 0; padding-bottom: 0;">Stabilization</h1>';

if ($message_error) $content .= '<center><p style="color:red;">'.$message_error.'</p></center>';

if ($message_success) $content .= '<center><p style="color:green;">'.$message_success.'</p></center>';

$content .= '<center>
<form name="stabilize" action="/stabilize" method="post">
<p>Choose a language to stabilize: <select name="language">';
$languages = Database::query("SELECT * FROM languages WHERE active IS NOT null ORDER BY popularity");
while ($lang = mysql_fetch_assoc($languages)) {
  $content .= '<option value="'.$lang['domain'].'">'.$lang['language'].'</option>';
}

$content .= '</select></p>
<input type="submit" name="submitted" value="Submit">
</form>
</center>
';

// Output
Site::head();
Site::$content .= $content;
Site::foot();

?>
