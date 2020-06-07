<?php include("inc/db.php")?>
<div id="bodyright">
    <?php
    if (isset($_GET['modifier_cat'])) {
        echo modifier_cat();
    }else {
    ?>
    <h3>Toutes FAQs</h3>
    <div id="add">
        <details style="width: 20%">
            <summary>Ajouter FAQs</summary>
            <form method="post" enctype="multipart/form-data">
                <input type="text" name="qsn" placeholder="Entrer La Question Ici"/>
                <textarea name="rep" placeholder="Entrer Votre Reponse Ici"></textarea>
                <center><button name="add_faqs">Ajouter FAQs</button></center>
            </form>
        </details><br/>
        <?php
            echo view_faqs();
        ?>
    </div>
</div>

<?php
echo add_faqs();}
?>
