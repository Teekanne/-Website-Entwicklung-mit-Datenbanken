
<?php
$titleEdit = Session::get('TITLEEDIT');
$firstnameEdit =Session::get('FIRSTNAMEEDIT');
$lastnameEdit = Session::get('LASTNAMEEDIT');
$emailEdit = Session::get('EMAILEDIT');
$passwordEdit =Session::get('PASSWORDEDIT');
?>
<form method="post" action="<?php echo URL; ?>Account/editAccount">
    <h1>Hier können Sie ihre Daten verwalten</h1></br>
    <input name="titel" type="text" value="<?php echo $titleEdit ?>" placeholder="Titel"></br>
    <input name="vorname" type="text" value="<?php echo $firstnameEdit ?>" pattern=".{0}|.{2,20}" required title="Ihr Name muss mindestens zwei maximal 20 Zeichen lang sein"  placeholder="Vorname"></br>
    <input name="nachname" type="text" value="<?php echo $lastnameEdit ?>" pattern=".{0}|.{2,20}" required title="Ihr Nachname muss mindestestens zwei maximal 20 Zeichen lang sein" placeholder="Nachname"></br>
    <input name="e-mail" type="email" value="<?php echo $emailEdit ?>" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail"></br>
    <input name="e-mailConfirmation" value="<?php echo $emailEdit ?>" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail bestätigen"></br>
    <input name="oldPasswordConfirmation" type="password"pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein"  placeholder="Ihr altes Passwort" > </br>
    <input name="password" type="password"pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein"  placeholder="Neues Passwortn" ></br>
    <input name="passwordConfirmation" type="password"pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein"  placeholder="Neues Passwort bestätigen" ></br>
    <input type="submit" name="userChange" value="Bearbeiten">
</form>
