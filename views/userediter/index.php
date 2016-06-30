<?php
//include ("../../../models/user_model.php");

$titleEdit = Session::get('TITLEEDIT');
$firstnameEdit =Session::get('FIRSTNAMEEDIT');
$lastnameEdit = Session::get('LASTNAMEEDIT');
$emailEdit = Session::get('EMAILEDIT');
$roleEdit = Session::get('ROLEEDIT');



?>


<form method="post" action="<?php echo URL; ?>user/create">
    <h1>Einen bestehenden Benutzer beabreiten</h1></br>
    <input name="titel" type="text" value="<?php echo $titleEdit ?>" placeholder="Titel"></br>
    <input name="vorname" type="text" value="<?php echo $firstnameEdit ?>" pattern=".{0}|.{2,20}" required title="Ihr Name muss mindestens zwei maximal 20 Zeichen lang sein"  placeholder="Vorname"></br>
    <input name="nachname" type="text" value="<?php echo $lastnameEdit ?>" pattern=".{0}|.{2,20}" required title="Ihr Nachname muss mindestestens zwei maximal 20 Zeichen lang sein" placeholder="Nachname"></br>
    <input name="e-mail" type="email" value="<?php echo $emailEdit ?>" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail"></br>
    <input name="e-mailConfirmation" value="<?php echo $emailEdit ?>" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail bestätigen"></br>
       <label>Role</label>
    <select name="ROLE" value="<?php echo $roleEdit ?>">
        <option value="Default">Default</option>
        <option value="User">User</option>
        <option value="Administrator">Administrator</option>
    </select><br />
    <input type="submit" name="Benutzer anlegen" value="Registrieren">
</form>