
<h1>User</h1>

<form method="post" action="<?php echo URL; ?>user/create">
    <label>Titel</label><input type="text" name="TITLE" /><br />
    <label>Vorname</label><input type="text" name="FIRSTNAME" /><br />
    <label>Nachname</label><input type="text" name="LASTNAME" /><br />
     <label>E-Mail</label><input type="text" name="EMAIL" /><br />
    <label>Passwort</label><input type="text" name="PASSWORD" /><br />
    <label>Role</label>
    <select name="ROLE">
        <option value="Default">Default</option>
        <option value="Administrator">Administrator</option>
        <option value="User">User</option>
    </select><br />
    <label>FK_STATE</label><input type="text" name="FK_STATE" /><br />
    <label>FK_DEPARTMENT</label><input type="text" name="FK_DEPARTMENT" /><br />
    <label>FK_ROLE</label><input type="text" name="FK_ROLE" /><br />

    <label>&nbsp;</label><input type="submit" />
</form>

<hr />

<table>
    <?php
    foreach ($this->userList as $key => $value) {
        echo '<tr>';
        echo '<td>' . $value['ID'] . '</td>';
        echo '<td>' . $value['TITLE'] . '</td>';
        echo '<td>' . $value['FIRSTNAME'] . '</td>';
        echo '<td>' . $value['LASTNAME'] . '</td>';
        echo '<td>' . $value['EMAIL'] . '</td>';
        echo '<td>' . $value['ROLE1'] . '</td>';
        echo '<td>
				<a href="' . URL . 'user/edit/' . $value['ID'] . '">Edit</a> 
				<a href="' . URL . 'user/delete/' . $value['ID'] . '">Delete</a></td>';
        echo '</tr>';
    }
    //print_r($this->userList);
    ?>
</table>