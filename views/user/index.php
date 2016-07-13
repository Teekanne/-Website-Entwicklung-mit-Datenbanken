
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
			<th><select style=width:13.3em; name="ROLE">
					<option value="Default">Default</option>
					<option value="User">User</option>
					<option value="Administrator">Administrator</option>
				</select></th>
		</tr>
		<tr>
			<th><label></label></th>
			<th><input id="change" type="submit" name="Benutzer anlegen" value="Registrieren"></th>
		</tr>
	</table>
</form>

<label id=overviewLabel>&nbsp;</label><br>

<table border='0'>
	<tr id="user">
		<th><label id="userLabel">ID</label></th>
		<th><label id="userLabel">&nbsp;&nbsp;Titel</label></th>
		<th><label id="userLabel">&nbsp;&nbsp;Vorname</label></th>
		<th><label id="userLabel">&nbsp;&nbsp;Nachname</label></th>
		<th><label id="userLabel">&nbsp;&nbsp;E-Mail</label></th>
		<th><label id="userLabel">&nbsp;&nbsp;Rolle</label></th>
		<th><label id="userLabel">&nbsp;&nbsp;Bearbeiten/Löschen</label></th>
	</tr>
    <?php
    foreach ($this->userList as $key => $value) {
        echo '<tr>';
        echo '<td>&nbsp;&nbsp;' . $value['ID'] . '</td>';
        echo '<td>&nbsp;&nbsp;' . $value['TITLE'] . '</td>';
        echo '<td>&nbsp;&nbsp;' . $value['FIRSTNAME'] . '</td>';
        echo '<td>&nbsp;&nbsp;' . $value['LASTNAME'] . '</td>';
        echo '<td>&nbsp;&nbsp;' . $value['EMAIL'] . '</td>';
        echo '<td>&nbsp;&nbsp;' . $value['ROLE'] . '</td>';


        echo '<td>     
                                  <label id="userLabel"><li><a href="' . URL . 'user/editUser/' . $value['ID'] . '">Edit&nbsp;&nbsp;&nbsp;&nbsp;</a></li>

				<li><a href="' . URL . 'user/delete/' . $value['ID'] . '">Delete</a></li></label></td>';
        echo '</tr>';

    }
    ?>  
</table>
</table>
