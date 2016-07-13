<?php
$deleteid = SESSION::get('DELETEID');
$deletetitle = Session::get('DELETETITTLE');
$deletefirstname =Session::get('DELETEFIRSTNAME');
$deletelastname = Session::get('DELETELASTNAME');
$deleteemail = Session::get('DELETEEMAIL');
$deleterole = Session::get('DELETEROLE');

echo "<font color='#FFFF00'>Wollen Sie den User mit der ID:".$deleteid."(".$deletetitle." ".$deletefirstname." ".$deletelastname." ".$deleteemail.") mit der Rolle:".$deleterole." wirklich löschen?</font>";
?>
</br>   
<form method="post" action="<?php echo URL; ?>user/delete">
<input id="change" type="submit" name="userChange" value="Löschen">
</form>
<form method="post" action="<?php echo URL; ?>user/index">
<input id="change" type="submit" name="userChange" value="Abbrechen">
</form>
//