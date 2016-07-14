
<?php
$titleEdit = Session::get('TITLEEDIT');
$firstnameEdit =Session::get('FIRSTNAMEEDIT');
$lastnameEdit = Session::get('LASTNAMEEDIT');
$emailEdit = Session::get('EMAILEDIT');
$passwordEdit =Session::get('PASSWORDEDIT');
?>
<form method="post" action="<?php echo URL; ?>account/editAccount">
    <h2>Hier können Sie ihre Daten verwalten</h2>
	<table border='0'>
		<tr>
			<td><label></label></td>
			<td><input name="titel" type="text" value="<?php echo $titleEdit ?>" placeholder="Titel"></td>
		</tr>
		<tr>
			<td><label></label></td>
			<td><input name="vorname" type="text" value="<?php echo $firstnameEdit ?>" pattern=".{0}|.{2,20}" required title="Ihr Name muss mindestens zwei maximal 20 Zeichen lang sein"  placeholder="Vorname"></td>
		</tr>
		<tr>
			<td><label></label></td>
			<td><input name="nachname" type="text" value="<?php echo $lastnameEdit ?>" pattern=".{0}|.{2,20}" required title="Ihr Nachname muss mindestestens zwei maximal 20 Zeichen lang sein" placeholder="Nachname"></td>
		</tr>
		<tr>
			<td><label></label></td>
			<td><input name="e-mail" type="email" value="<?php echo $emailEdit ?>" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail"></td>
		</tr>
		<tr>
			<td><label></label></td>
			<td><input name="e-mailConfirmation" value="<?php echo $emailEdit ?>" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail bestätigen"></td>
		</tr>
		<tr>
			<td><label></label></td>
			<td><input name="oldPasswordConfirmation" type="password"pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein"  placeholder="Ihr altes Passwort" ></td>
		</tr>
		<tr>
			<td><label></label></td>
			<td><input name="password" type="password"pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein"  placeholder="Neues Passwort" ></td>
		</tr>
		<tr>
			<td><label></label></td>
			<td><input name="passwordConfirmation" type="password"pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein"  placeholder="Neues Passwort bestätigen" ></td>
		</tr>
		<tr>
			<td><label></label></td>
			<td><input id="change" type="submit" name="userChange" value="Bearbeiten"></td>
		</tr>
	</table>
</form>
