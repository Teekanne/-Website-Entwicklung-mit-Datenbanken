<?php
//include ("../../../models/user_model.php");

$titleEdit = Session::get('TITLEEDIT');
$firstnameEdit =Session::get('FIRSTNAMEEDIT');
$lastnameEdit = Session::get('LASTNAMEEDIT');
$emailEdit = Session::get('EMAILEDIT');
$roleEdit = Session::get('ROLEEDIT');



?>


<form method="post" action="<?php echo URL; ?>user/create">
    <h2>Einen bestehenden Benutzer beabreiten</h2>
	<table border = '0'>
		<tr>
			<th><label></label></th>
			<th><input name="titel" type="text" value="<?php echo $titleEdit ?>" placeholder="Titel"></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><input name="vorname" type="text" value="<?php echo $firstnameEdit ?>" pattern=".{0}|.{2,20}" required title="Ihr Name muss mindestens zwei maximal 20 Zeichen lang sein"  placeholder="Vorname"></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><input name="nachname" type="text" value="<?php echo $lastnameEdit ?>" pattern=".{0}|.{2,20}" required title="Ihr Nachname muss mindestestens zwei maximal 20 Zeichen lang sein" placeholder="Nachname"></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><input name="e-mail" type="email" value="<?php echo $emailEdit ?>" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail"></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><input name="e-mailConfirmation" value="<?php echo $emailEdit ?>" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail bestätigen"></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><label id = "role">Role</label></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><select style=width:13.3em; name="ROLE" value="<?php echo $roleEdit ?>">
				<option value="Default">Default</option>
				<option value="User">User</option>
				<option value="Administrator">Administrator</option>
			</select></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><input type="submit" name="Benutzer anlegen" value="Registrieren"></th>
		</tr>
	</table>
</form>
