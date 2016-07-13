    
<h2>Passwort vergessen</h2>

<form action="<?php echo URL; ?>passwordlost/generateKey" method="post">
    <table id = "passwordlostTable" border='0'>
        <tr>
            <th><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;E-Mail</label></th>
            <th><input name="login" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail*"/></th>
        </tr>

        <tr>
			<th><label></label></th>
            <th><input value="Passwort vergessen" id="change" type="submit" /></th>
        </tr>
    </table>
</form>

<form action="<?php echo URL; ?>passwordlost/newPassword" method="post">
    <table id ="passwordrestTable">
        <tr>
            <th><label>E-Mail</label></th>
            <th><input name="login" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail*"/></th>
        </tr>
        <tr>
            <th><label>Key</label></th>
            <th><input type="text" name="key" pattern=".{0}|.{4,20}" required title="Geben Sie einen gültigen Schlüssel ein." placeholder="Resetkey"/></th>
        </tr>
        <tr>
            <th><label>Passwort</label></th>
            <th><input name="password" type="password" pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein" placeholder="Passwort" /></th>
        </tr>
        <tr>
            <th><label>Passwort</label></th>
            <th><input name="passwordconfirmation" type="password" pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein"  placeholder="Passwort bestätigen" /></th>
        </tr>
        <tr>
			<th><label></label></th>
            <th><input value="Passwort setzen" id="change" type="submit" /></th>
        </tr>


    </table>
</form>
