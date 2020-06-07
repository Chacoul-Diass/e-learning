<?php include("inc/db.php")?>
    <div id="bodyright">
<?php
if (isset($_GET['modifier_lang'])) {
    echo modifier_lang();
}else {
    ?>
    <h3>Voir Langages</h3>
    <div id="add">
        <details>
            <summary>Ajouter Langages</summary>
            <form method="post" enctype="multipart/form-data">
                <input type="text" name="lang_name" placeholder="Entrer le Nom du Langage Ici"/>
                <center><button name="add_lang">Ajouter Langage</button></center>
            </form>
        </details>
        <table cellspacing="0">
            <tr>
                <th>N°</th>
                <th>Langage</th>
                <th>Action</th>
            </tr>
            <?php
            echo view_lang();
            ?>
        </table>
    </div>
    </div>

    <?php
    echo add_lang();}
?>