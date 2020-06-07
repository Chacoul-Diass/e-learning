<?php include("inc/db.php")?>
<div id="bodyright">
    <?php
        if (isset($_GET['modifier_sous_cat'])){
            echo modifier_sous_cat();
        }else{
    ?>
    <h3>Voir Toutes Sous-Catégories</h3>
    <div id="add">
        <details>
            <summary>Ajouter Sous-Catégorie</summary>
            <form method="post" enctype="multipart/form-data">
                <select name="cat_id">
                    <option value="">Sélectionnez Une Catégorie</option>
                    <?php
                        echo  select_cat();
                    ?>
                </select>
                <input type="text" name="sous_cat_name" placeholder="Entrer le Nom de la Catégorie Ici"/>
                <center><button name="add_sous_cat">Ajouter Sous-Catégorie</button></center>
            </form> 
        </details>
        <table cellspacing="0">
            <tr>
                <th>N°</th>
                <th>Sous-Catégorie</th>
                <th>Catégorie</th>
                <th>Action</th>
            </tr>
            <?php
                echo view_sous_cat();
            ?>
        </table>
    </div>
    <?php }?>
</div>

<?php 
    echo add_sous_cat();
?>