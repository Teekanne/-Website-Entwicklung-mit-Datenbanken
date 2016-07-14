<?php
$deleteid = SESSION::get('DELETEID');
$deletetitle = Session::get('DELETETITTLE');
$deletefirstname =Session::get('DELETEFIRSTNAME');
$deletelastname = Session::get('DELETELASTNAME');
$deleteemail = Session::get('DELETEEMAIL');
$deleterole = Session::get('DELETEROLE');

echo "</br></br></br><label id='messageLabel'></br>Wollen Sie den User mit der ID:".$deleteid."(".$deletetitle." ".$deletefirstname." ".$deletelastname." ".$deleteemail.")</br> mit der Rolle:".$deleterole." wirklich löschen?</label></br></br></br>";
?>
</br>
</br>
<table border='0'>
	<tr>
		<td><form method="post" action="<?php echo URL; ?>user/delete">
		<input id='change' type="submit" name="userChange" value="Löschen">
		</form></td>
		<td><form method="post" action="<?php echo URL; ?>user/index">
		<input id='change' type="submit" name="userChange" value="Abbrechen">
		</form></td>
	</tr>
</table>
