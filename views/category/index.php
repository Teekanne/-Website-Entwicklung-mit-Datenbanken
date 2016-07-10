<?php 
    include("public/php/LoadClasses.php"); 
    
    if(isset($_POST["createCategory"])){
        if(isset($_POST["mainCategory"])){
            $mainCategory = Category::Load($_POST["category"]);
        }else {
            $mainCategory = null;
        }
        Category::Add($_POST["createCategory"], $mainCategory, $_SESSION["ID"]);
    }elseif(isset($_POST["deleteCategory"])){
        if(Category::CountFirstLevelCategories() == 1){
            echo "Kategorie konnte nicht entfernt werden. Eine Haupt-Kategorie muss mindestens bestehend bleiben.";
        }else{
            Category::Delete($_POST["category"]);
            echo "Die Kategorie " . $_POST["category"] . " wurde entfernt.";
        }
    }
    
?>

<h3>Kategorie entfernen</h3>
<form method="POST" action="">
        <table table border='0'>
        <tr>
            <td class='cells'>
                <?php Category::ShowSelectBoxWithCategories($_SESSION["ID"], true); ?>
            </td>
            <td class='cells'>
                <input type="submit" name="deleteCategory" value="Entfernen" onClick="return confirm('Möchtest du die Kategorie wirklich mit allen anhängten Quizes entfernen?')"/>
            </td>
        </tr>
        </table>
</form>


<h3>Kategorien hinzufügen</h3>
<form method="POST" action="">
        <table table border='0'>
        <tr>
            <td class='cells'>
                <input type="text" name="createCategory" placeholder="Neue Wunschkategorie" />
            </td>
            <td class='cells'>
                <input type="submit" value="Hinzufügen"/>
            </td>
        </tr>
        <tr>
            <td>
                <input type="checkbox" name="mainCategory" onclick="hide('categories');" checked/><label class="radioLabel">Als Unterkategorie anlegen</label>
            </td>
            <td>
                <div id="categories">
                    <?php Category::ShowSelectBoxWithCategories($_SESSION["ID"], false); ?>
                <div>
            </td>
        </tr>
        </table>
</form>