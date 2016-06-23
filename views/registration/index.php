<div class="registration">
    <form action="registration/reg" method="post">
          <h2>Registrierung</h2></br>
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
				<th><input name="e-mail" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail*"></th>
			</tr>
			<tr>
				<th><label></label></th>
				<th><input name="e-mailConfirmation" type="email" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" required title="Bitte geben Sie eine E-Mail Adresse in einem gültigen Format ein" placeholder="E-Mail bestätigen"></th>
			</tr>
			<tr>
				<th><label></label></th>
				<th><input name="password" type="password" pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein" placeholder="Passwort" ></th>
			</tr>
			<tr>
				<th><label></label></th>
				<th><input name="passwordConfirmation" type="password"pattern=".{0}|.{8,20}" required title="Ihr passwort muss min. 8 max 20 Stellen lang sein"  placeholder="Passwort bestätigen" ></th>
			</tr>
			<tr>
				<th><label></label></th>
				<th><input type="submit" name="Registrieren" value="Registrieren"></th>
			</tr>
        </table>
		 <p id="registrate">* Nur HS E-Mail Adresse</p></br>
    </form>
</div>
