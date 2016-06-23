
<form method="post" action="<?php echo URL; ?>user/create">
    <h2>Einen neuen Benutzer erstellen</h2>
	<table>
		<tr>
			<th><label></label></th>
			<th><input name="titel" type="text"  placeholder="Titel"></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><input name="vorname" type="text" pattern=".{0}|.{2,20}" required title="Ihr Name muss mindestens zwei maximal 20 Zeichen lang sein"  placeholder="Vorname"></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><input name="nachname" type="text" pattern=".{0}|.{2,20}" required title="Ihr Nachname muss mindestestens zwei maximal 20 Zeichen lang sein" placeholder="Nachname"></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><input name="e-mail" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail"></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><input name="e-mailConfirmation" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail bestätigen"></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><input name="password" type="password" pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein" placeholder="Passwort"></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><input name="passwordConfirmation" type="password"pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein"  placeholder="Passwort bestätigen"></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><label id ="role">Rolle</label></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><select name="ROLE">
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

<hr />

<table>
	<tr id="user">
		<th><label>ID</label></th>
		<th><label>Titel</label></th>
		<th><label>Vorname</label></th>
		<th><label>Nachname</label></th>
		<th><label>E-Mail</label></th>
		<th><label>Rolle</label></th>
		<th><label>Bearbeiten/Löschen</label></th>
	</tr>
    <?php
    foreach ($this->userList as $key => $value) {
        echo '<tr>';
        echo '<td>' . $value['ID'] . '</td>';
        echo '<td>' . $value['TITLE'] . '</td>';
        echo '<td>' . $value['FIRSTNAME'] . '</td>';
        echo '<td>' . $value['LASTNAME'] . '</td>';
        echo '<td>' . $value['EMAIL'] . '</td>';
        echo '<td>' . $value['ROLE'] . '</td>';
        echo '<td>
				<a href="' . URL . 'user/edit/' . $value['ID'] . '">Edit</a> 
				<a href="' . URL . 'user/delete/' . $value['ID'] . '">Delete</a></td>';
        echo '</tr>';
    }
    //print_r($this->userList);
    ?>
</table>
</table>
