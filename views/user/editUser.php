<form method="post" action="<?php echo URL; ?>user/create">
    <h1>Einen bestehenden Benutzer beabreiten</h1></br>
    <input name="titel" type="text" value="" placeholder="Titel"></br>
    <input name="vorname" type="text" pattern=".{0}|.{2,20}" required title="Ihr Name muss mindestens zwei maximal 20 Zeichen lang sein"  placeholder="Vorname"></br>
    <input name="nachname" type="text" pattern=".{0}|.{2,20}" required title="Ihr Nachname muss mindestestens zwei maximal 20 Zeichen lang sein" placeholder="Nachname"></br>
    <input name="e-mail" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail"></br>
    <input name="e-mailConfirmation" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail bestätigen"></br>
    <input name="password" type="password" pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein" placeholder="Passwort" ></br>
    <input name="passwordConfirmation" type="password"pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein"  placeholder="passwort bestätigen" ></br>
    <label>Role</label>
    <select name="ROLE">
        <option value="Default">Default</option>
        <option value="User">User</option>
        <option value="Administrator">Administrator</option>
    </select><br />
    <input type="submit" name="Benutzer anlegen" value="Registrieren">

</form>