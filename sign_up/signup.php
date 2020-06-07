<?php

    try{
        $bdd = new PDO("mysql:host=localhost;dbname=e_learning", "root","");
    }
    catch(Exception $e){
        die('ERROR : '.$e->getMessage());
    }
    
    if(isset($_POST['forminscription'])) {
        $mail = htmlspecialchars($_POST['insc_email']);
        $mail2 = htmlspecialchars($_POST['insc_email2']);
        $pseudo = htmlspecialchars($_POST['insc_username']);
        $mdp = sha1($_POST['insc_password']);
        $mdp2 = sha1($_POST['insc_password2']);
    if(!empty($_POST['insc_username']) AND !empty($_POST['insc_email']) AND !empty($_POST['insc_email2']) AND !empty($_POST['insc_password']) AND !empty($_POST['insc_password2'])) {
        $pseudolength = strlen($pseudo);
        if($pseudolength <= 255) {
            if($mail == $mail2) {
                if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $reqmail = $bdd->prepare("SELECT * FROM connexion WHERE email = ?");
                $reqmail->execute(array($mail));
                $mailexist = $reqmail->rowCount();
                if($mailexist == 0) {
                    if($mdp == $mdp2) {
                        $insertmbr = $bdd->prepare("INSERT INTO connexion(email, username, pwd) VALUES(?, ?, ?)");
                        $insertmbr->execute(array($mail, $pseudo, $mdp));
                        $erreur = "Votre compte a bien été créé ! <a href=\"login.php\">Me connecter</a>";
                    } else {
                        $erreur = "Vos mots de passes ne correspondent pas !";
                    }
                } else {
                    $erreur = "Adresse mail déjà utilisée !";
                }
                } else {
                $erreur = "Votre adresse mail n'est pas valide !";
                }
            } else {
                $erreur = "Vos adresses mail ne correspondent pas !";
            }
        } else {
            $erreur = "Votre pseudo ne doit pas dépasser 255 caractères !";
        }
    } else {
        $erreur = "Tous les champs doivent être complétés !";
    }
    }
?>


<div class="name-user">

    <div id="id02" class="modal">    
    <form class="modal-content animate" action="" method="post">

        <div class="imgcontainer">
            <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
            <img src="./imgs/img_avatar.png" alt="Avatar" class="avatar" style="width: 150px; height: 150px;">
        </div>

        <div class="container">
            <h1>INSCRIPTION</h1> <br>
            <?php
                if(isset($erreur)) {
                    echo '<font color="red">'.$erreur."</font>";
                }
            ?>
            <hr>
            <label for="insc_email"><b>Email</b></label>
            <input type="text" placeholder="Enter Email" name="insc_email" required>

            <label for="insc_email2"><b>Veillez répéter l'Email svp</b></label>
            <input type="text" placeholder="Entrer l'Email" name="insc_email2" value="<?php if(isset($mail2)) { echo $mail2; } ?>">

            <label for="insc_username"><b>Username</b></label>
            <input type="text" placeholder="Entrer l'Email" name="insc_username" required>

            <label for="insc_password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="insc_password" required>

            <label for="insc_password_repeat"><b>Repeat Password</b></label>
            <input type="password" placeholder="Repeat Password" name="insc_password2" required>

            <hr>
            <p>By creating an account you agree to our <a href="#">Terms & Privacy</a>.</p>
            
            <button type="submit" name="forminscription">S'inscrire</button>
        </div>

        <div class="container" style="background-color:#f1f1f1">
            <button type="button"  class="cancelbtn" href="./index.php">Cancel</button>
        </div>

    </form>
    
</div>

