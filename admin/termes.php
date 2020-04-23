<?php include("inc/db.php")?>
    <div id="bodyright">
<?php
if (isset($_GET['modifier_cat'])) {
    echo modifier_cat();
}else {
    ?>
    <h3>Toutes T&C</h3>
    <div id="add">
        <details>
            <summary>Ajouter Nouveau T&C</summary>
            <form method="post" enctype="multipart/form-data">
                <select name="pour_qui" required>
                    <option value="">Selctionner Terme Pour</option>
                    <option value="Etudiant">Etudiant</option>
                    <option value="Professeur">Professeur</option>
                </select>
                <input type="text" name="term" placeholder="Entrer le Nom du Terme Ici"/>
                <center><button name="add_term">Ajouter T&C</button></center>
            </form>
        </details>
        <table style="width: 98%" cellspacing="0">
            <tr>
                <th>N°</th>
                <th>Termes</th>
                <th>Pour Qui</th>
                <th>Action</th>
            </tr>
            <?php
            echo view_term();
            ?>
        </table>
    </div>
    </div>

    <?php
    echo add_term();}
?>