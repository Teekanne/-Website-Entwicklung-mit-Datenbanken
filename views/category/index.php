<?php 
    /**
     * Creating a default-category for new users
     */
    $sumMainCategories = Category::CountFirstLevelCategories($_SESSION["ID"]);

    if($sumMainCategories == 0){
        Category::Add("Default", null, $_SESSION["ID"]);
    }

    /**
     * Creating a new category
     */
    if(isset($_POST["createCategory"])){
        if(isset($_POST["mainCategory"])){
            $mainCategory = Category::Load($_POST["category"]);
        }else {
            $mainCategory = null;
        }
        
        if(strlen($_POST["createCategory"])>2){
            Category::Add($_POST["createCategory"], $mainCategory, $_SESSION["ID"]);
        }
    /**
     * Deleting an existing category
     */
    }elseif(isset($_POST["deleteCategory"])){
        $tempCat = Category::Load(($_POST["category"]));
        
        if($sumMainCategories == 1 && $tempCat->__get("level") == 1){
            echo "<br><label id='messageLabel'>Kategorie konnte nicht entfernt werden. Eine Haupt-Kategorie muss mindestens bestehend bleiben.</label></br>";
        }else{
            Category::Delete($_POST["category"]);
            echo "<br><label id='messageLabel'>Die Kategorie " . $_POST["category"] . " wurde entfernt.</label></br>";
        }
    }
    
    /**
     * Error-message
     */
    if(!isset($_SESSION["ID"])){
        echo "<br><br><br><label id='messageLabel'>Du bist nicht eingeloggt. :-(</label></br></br></br>";
    }else {
?>

<h3>Kategorie entfernen</h3>
<form method="POST" action="">
        <table border='0'>
        <tr>
            <td class='cells'>
                <?php Category::ShowSelectBoxWithCategories($_SESSION["ID"], true, true); ?>
            </td>
            <td class='cells'>
                &nbsp;&nbsp;&nbsp;&nbsp;<input id="categorySub" type="submit" name="deleteCategory" value="Entfernen" onClick="return confirm('Möchtest du die Kategorie wirklich mit allen anhängten Quizes entfernen?')"/>
            </td>
        </tr>
        </table>
		
		
</form>

<label id=overviewLabel>&nbsp;</label><br>
<h3>Kategorien hinzufügen</h3>
<form method="POST" action="">
        <table border='0'>
        <tr>
            <td class='cells'>
                <input type="text" name="createCategory" placeholder="Neue Wunschkategorie" />
            </td>
            <td class='cells'>
                <input id="categorySub" type="submit" value="Hinzufügen"/>
            </td>
        </tr>
        <tr>
            <td>
                <div id="categories" style='visibility:hidden'>
                    <?php Category::ShowSelectBoxWithCategories($_SESSION["ID"], false, true); ?>
                <div>
            </td>
            <td>
                <input id="cbSub" type="checkbox" name="mainCategory" onclick="hide('categories');"/><label class="radioLabel">Als Unterkategorie</label>
            </td>
        </tr>
        </table>
</form>

<?php } ?>
