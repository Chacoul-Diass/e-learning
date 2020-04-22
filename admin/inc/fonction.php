<?php
    function add_lang(){
        include("inc/db.php");
        if(isset($_POST['add_lang'])) {
            $lang_name=$_POST['lang_name'];

            /** @var TYPE_NAME $con */
            $check= $con->prepare("select * from lang where lang_name='$lang_name'");
            $check->setFetchMode(PDO::FETCH_ASSOC);
            $check->execute();
            $count=$check->rowCount();

            if($count==1){
                echo"<script>alert('Catégorie Déjà Ajoutée')</script>";
                echo"<script>window.open('index.php?lang','_self')</script>";
            }else{
                $add_lang=$con->prepare("insert into lang(lang_name)values('$lang_name')");
                if($add_lang->execute()){
                    echo"<script>alert('Catégorie Ajoutée Avec Succès')</script>";
                    echo"<script>window.open('index.php?lang','_self')</script>";
                } else {
                    echo"<script>alert('Catégorie Non Ajoutée)</script>";
                    echo"<script>window.open('index.php?lang','_self')</script>";
                }
            }
        }
    }

    function modifier_lang(){
        include("inc/db.php");
        if(isset($_GET['modifier_lang'])) {
            $id=$_GET['modifier_lang'];

            /** @var TYPE_NAME $con */
            $get_cat=$con->prepare("select * from lang where lang_id='$id'");
            $get_cat->setFetchMode(PDO::FETCH_ASSOC);
            $get_cat->execute();
            $row=$get_cat->fetch();

            echo "<h3>Modifier Langage</h3>
                    <form id='modifier_form' method='post' enctype='multipart/form-data'>
                        <input type='text' name='l_name' value='".$row['lang_name']."' placeholder='Entrer le Nom du Lanage Ici'/>
                        <center><button name='modifier_lang'>Modifier Langage</button></center>
                    </form>";

            if (isset($_POST['modifier_lang'])){
                $cat_name=$_POST['l_name'];

                /** @var TYPE_NAME $con */
                $check= $con->prepare("select * from lang where lang_name='$cat_name'");
                $check->setFetchMode(PDO::FETCH_ASSOC);
                $check->execute();
                $count=$check->rowCount();

                if($count==1){
                    echo"<script>alert('Langage Déjà Ajouté')</script>";
                    echo"<script>window.open('index.php?lang','_self')</script>";
                }else{
                    $up=$con->prepare("update lang set lang_name='$cat_name' where lang_id='$id'");
                    if($up->execute()){
                        echo"<script>alert('Langage Modifié Avec Succès')</script>";
                        echo"<script>window.open('index.php?lang','_self')</script>";
                    } else {
                        echo"<script>alert('Langage Non Modifié)</script>";
                        echo"<script>window.open('index.php?lang','_self')</script>";
                    }
                }
            }
        }
    }

    function view_lang(){
        include("inc/db.php");
        /** @var TYPE_NAME $con */
        $get_lang=$con->prepare("select * from lang");
        $get_lang->setFetchMode(PDO::FETCH_ASSOC);
        $get_lang->execute();
        $i=1;
        while($row=$get_lang->fetch()):
            echo "<tr>
                        <td>".$i++."</td>
                        <td>".$row['lang_name']."</td>
                        <td>
                            <a href='index.php?lang&modifier_lang=".$row['lang_id']."'><i class='far fa-edit'></i></a>    
                            <a style='#f00' href='index.php?lang&supp_lang=".$row['lang_id']."'><i class='far fa-trash-alt'></i></a>
                        </td>
                      </tr>";
        endwhile;

        if(isset($_GET['supp_lang'])){
            $id=$_GET['supp_lang'];

            $supp=$con->prepare("delete  from lang where lang_id='$id'");
            if ($supp->execute()){
                echo "<script>alert('Langage Supprimé Avec Succès')</script>";
                echo"<script>window.open('index.php?lang','_self')</script>";
            }else{
                echo "<script>alert('Langage Non Supprimé Avec Succès')</script>";
                echo"<script>window.open('index.php?lang','_self')</script>";
            }
        }
    }

    function add_cat(){
        include("inc/db.php");
        if(isset($_POST['add_cat'])) {
             $cat_name=$_POST['cat_name'];

            /** @var TYPE_NAME $con */
            $check= $con->prepare("select * from cat where cat_name='$cat_name'");
            $check->setFetchMode(PDO::FETCH_ASSOC);
            $check->execute();
            $count=$check->rowCount();

            if($count==1){
                echo"<script>alert('Catégorie Déjà Ajoutée')</script>";
                echo"<script>window.open('index.php?cat','_self')</script>";
            }else{
                $add_cat=$con->prepare("insert into cat(cat_name)values('$cat_name')");
                if($add_cat->execute()){
                    echo"<script>alert('Catégorie Ajoutée Avec Succès')</script>";
                    echo"<script>window.open('index.php?cat','_self')</script>";
                } else {
                    echo"<script>alert('Catégorie Non Ajoutée)</script>";
                    echo"<script>window.open('index.php?cat','_self')</script>";
                }
            }
        }   
    }

    function modifier_cat(){
        include("inc/db.php");
        if(isset($_GET['modifier_cat'])) {
            $id=$_GET['modifier_cat'];

            /** @var TYPE_NAME $con */
            $get_cat=$con->prepare("select * from cat where cat_id='$id'");
            $get_cat->setFetchMode(PDO::FETCH_ASSOC);
            $get_cat->execute();
            $row=$get_cat->fetch();

            echo "<h3>Modifier Catégorie</h3>
                <form id='modifier_form' method='post' enctype='multipart/form-data'>
                    <input type='text' name='cat_name' value='".$row['cat_name']."' placeholder='Entrer le Nom de la Catégorie Ici'/>
                    <center><button name='modifier_cat'>Modifier Catégorie</button></center>
                </form>";

                if (isset($_POST['modifier_cat'])){
                    $cat_name=$_POST['cat_name'];

                    /** @var TYPE_NAME $con */
                    $check= $con->prepare("select * from cat where cat_name='$cat_name'");
                    $check->setFetchMode(PDO::FETCH_ASSOC);
                    $check->execute();
                    $count=$check->rowCount();

                    if($count==1){
                        echo"<script>alert('Catégorie Déjà Ajoutée')</script>";
                        echo"<script>window.open('index.php?cat','_self')</script>";
                    }else{
                        $up=$con->prepare("update cat set cat_name='$cat_name' where cat_id='$id'");
                        if($up->execute()){
                            echo"<script>alert('Catégorie Modifiée Avec Succès')</script>";
                            echo"<script>window.open('index.php?cat','_self')</script>";
                        } else {
                            echo"<script>alert('Catégorie Non Modifiée)</script>";
                            echo"<script>window.open('index.php?cat','_self')</script>";
                        }
                    }
                }
        }
    }

    function view_cat(){
        include("inc/db.php");
        /** @var TYPE_NAME $con */
        $get_cat=$con->prepare("select * from cat");
        $get_cat->setFetchMode(PDO::FETCH_ASSOC);
        $get_cat->execute();
        $i=1;
        while($row=$get_cat->fetch()):
            echo "<tr>
                    <td>".$i++."</td>
                    <td>".$row['cat_name']."</td>
                    <td>
                        <a  href='index.php?cat&modifier_cat=".$row['cat_id']."' title='Modifier'><i class='far fa-edit'></i></a>
                        <a style='color: #f00' href='index.php?cat&supp_cat=".$row['cat_id']."' title='Supprimer'><i class='far fa-trash-alt'></i></a>
                    </td>
                  </tr>";
        endwhile;

        if(isset($_GET['supp_cat'])){
            $id=$_GET['supp_cat'];

            $supp=$con->prepare("delete  from cat where cat_id='$id'");
            if ($supp->execute()){
                echo "<script>alert('Catégorie Supprimée Avec Succès')</script>";
                echo"<script>window.open('index.php?cat','_self')</script>";
            }else{
                echo "<script>alert('Catégorie Non Supprimée Avec Succès')</script>";
                echo"<script>window.open('index.php?cat','_self')</script>";
            }
        }
    }

    function add_sous_cat(){
        include("inc/db.php");
        if(isset($_POST['add_sous_cat'])) {
            $cat_name=$_POST['sous_cat_name'];
            $cat_id=$_POST['cat_id'];

            /** @var TYPE_NAME $con */
            $check= $con->prepare("select * from sous_cat where sous_cat_name='$cat_name'");
            $check->setFetchMode(PDO::FETCH_ASSOC);
            $check->execute();
            $count=$check->rowCount();

            if($count==1){
                echo"<script>alert('Sous-Catégorie Déjà Ajoutée')</script>";
                echo"<script>window.open('index.php?sous_cat','_self')</script>";
            }else{
                $add_sous_cat=$con->prepare("insert into sous_cat(sous_cat_name,cat_id)values('$cat_name','$cat_id')");
                if($add_sous_cat->execute()){
                    echo"<script>alert('Sous-Catégorie Ajoutée Avec Succès')</script>";
                    echo"<script>window.open('index.php?sous_cat','_self')</script>";
                } else {
                    echo"<script>alert('Sous-Catégorie Non Ajoutée )</script>";
                    echo"<script>window.open('index.php?sous_cat','_self')</script>";
                }
            }
        }
    }

    function modifier_sous_cat(){
    include("inc/db.php");
    if(isset($_GET['modifier_sous_cat'])) {
        $id=$_GET['modifier_sous_cat'];

        /** @var TYPE_NAME $con */
        $get_cat=$con->prepare("select * from sous_cat where sous_cat_id='$id'");
        $get_cat->setFetchMode(PDO::FETCH_ASSOC);
        $get_cat->execute();
        $row=$get_cat->fetch();

        $cat_id=$row['cat_id'];
        $get_c=$con->prepare("select * from cat where cat_id='$cat_id'");
        $get_c->setFetchMode(PDO:: FETCH_ASSOC);
        $get_c->execute();
        $row_cat=$get_c->fetch();

        echo "<h3>Modifier Sous-Catégorie</h3>
                <form id='modifier_form' method='post' enctype='multipart/form-data'>
                    <select name='cat_id'>
                       <option value='".$row_cat['cat_id']."'>".$row_cat['cat_name']."</option>";
                       echo select_cat();
                echo"</select>    
                    <input type='text' name='sous_cat_name' value='".$row['sous_cat_name']."' placeholder='Entrer le Nom de la Catégorie Ici'/>
                    <center><button name='modifier_sous_cat'>Modifier Catégorie</button></center>
                </form>";

        if (isset($_POST['modifier_sous_cat'])){
            $cat_name=$_POST['sous_cat_name'];
            $cat_id=$_POST['cat_id'];


                $up=$con->prepare("update sous_cat set sous_cat_name='$cat_name',cat_id='$cat_id' where sous_cat_id='$id'");
                if($up->execute()){
                    echo"<script>alert('Catégorie Modifiée Avec Succès')</script>";
                    echo"<script>window.open('index.php?sous_cat','_self')</script>";
                } else {
                    echo"<script>alert('Catégorie Non Modifiée)</script>";
                    echo"<script>window.open('index.php?sous_cat','_self')</script>";
                }

        }
    }
}

    function view_sous_cat(){
        include("inc/db.php");
        /** @var TYPE_NAME $con */
        $get_cat=$con->prepare("select * from sous_cat");
        $get_cat->setFetchMode(PDO::FETCH_ASSOC);
        $get_cat->execute();
        $i=1;
        while($row=$get_cat->fetch()):
            $id=$row['cat_id'];
            $get_c=$con->prepare("select * from cat where cat_id='$id'");
            $get_c->setFetchMode(PDO::FETCH_ASSOC);
            $get_c->execute();
            $row_cat=$get_c->fetch();

            echo "<tr>
                        <td>".$i++."</td>
                        <td>".$row['sous_cat_name']."</td>
                        <td>".$row_cat['cat_name']."</td>
                        <td>
                            <a href='index.php?sous_cat&modifier_sous_cat=".$row['sous_cat_id']."' title='Modifier'><i class='far fa-edit'></i></a>
                            <a style='color: #f00' href='index.php?sous_cat&supp_sous_cat=".$row['sous_cat_id']."' title='Supprimer'><i class='far fa-trash-alt'></i></a>
                        </td>
                      </tr>";
        endwhile;

        if(isset($_GET['supp_sous_cat'])){
            $id=$_GET['supp_sous_cat'];

            $supp=$con->prepare("delete  from sous_cat where sous_cat_id='$id'");
            if ($supp->execute()){
                echo "<script>alert('Sous-Catégorie Supprimée Avec Succès')</script>";
                echo"<script>window.open('index.php?sous_cat','_self')</script>";
            }else{
                echo "<script>alert('Sous-Catégorie Non Supprimée Avec Succès')</script>";
                echo"<script>window.open('index.php?sous_cat','_self')</script>";
            }
        }
    }

    function select_cat(){
        include("inc/db.php");
        /** @var TYPE_NAME $con */
        $get_cat=$con->prepare("select * from cat");
        $get_cat->setFetchMode(PDO::FETCH_ASSOC);
        $get_cat->execute();
        while($row=$get_cat->fetch()):
            echo "<option value='".$row['cat_id']."'>".$row['cat_name']."</option>";
        endwhile;
    }
?>