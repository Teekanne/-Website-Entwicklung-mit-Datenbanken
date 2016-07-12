    
<h2>Passwort vergessen</h2>

<form action="<?php echo URL; ?>passwordlost/generateKey" method="post">
    <table id = "passwordlostTable" border='0'>
        <tr>
            <th><label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;e-mail</label></th>
            <th><input name="login" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail*"/></th>
        </tr>

        <tr>
			<th><label></label></th>
            <th><input id="change" type="submit" /></th>
        </tr>
    </table>
</form>

<form action="" method="post">
    <table border='0' id ="passwordrestTable">
        <tr>
            <th><label>e-mail</label></th>
            <th><input type="text" name="login" /></th>
        </tr>
        <tr>
            <th><label>key</label></th>
            <th><input type="text" name="key" /></th>
        </tr>
        <tr>
            <th><label>Passwort</label></th>
            <th><input type="text" name="password" /></th>
        </tr>
        <tr>
            <th><label>Passwort</label></th>
            <th><input type="text" name="passwordconfirmation" /></th>
        </tr>
        <tr>
			<th><label></label></th>
            <th><input id="change" type="submit" /></th>
        </tr>


    </table>
</form>
