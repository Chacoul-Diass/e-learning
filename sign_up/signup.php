<?php
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=e_learning', 'root', '');
	 
	if(isset($_POST['forminscription'])) {
	   $pseudo = htmlspecialchars($_POST['pseudo']);
	   $mail = htmlspecialchars($_POST['mail']);
	   $mail2 = htmlspecialchars($_POST['mail2']);
	   $mdp = sha1($_POST['mdp']);
	   $mdp2 = sha1($_POST['mdp2']);
	   if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mail2']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'])) {
	      $pseudolength = strlen($pseudo);
	      if($pseudolength <= 255) {
	         if($mail == $mail2) {
	            if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
	               $reqmail = $bdd->prepare("SELECT * FROM connexion WHERE email = ?");
	               $reqmail->execute(array($mail));
	               $mailexist = $reqmail->rowCount();
	               if($mailexist == 0) {
	                  if($mdp == $mdp2) {
	                     $insertmbr = $bdd->prepare("INSERT INTO connexion(username, email, pwd) VALUES(?, ?, ?)");
	                     $insertmbr->execute(array($pseudo, $mail, $mdp));
	                     $erreur = "Votre compte a bien été créé ! <a href=\"connexion.php\">Me connecter</a>";
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

<?php include('inc/header.php')?>
    <div class="signin">
		<img src="imgs/photo3.jpg" alt="avatar" class="avatar">
		<br><br><br>
        <h1>Inscription</h1>
        <form action="" method="POST">


            <p>Pseudo</p>
            <input type="text" placeholder="Entrer votre pseudo" name="pseudo" required> <br> <br>

            <p>E-mail</p>
            <input type="email" placeholder="Entrer votre adresse e-mail" name="mail" value="<?php if(isset($pseudo)) { echo $pseudo; } ?>"  required>

            <p>Confirmation de l'adresse e-mail</p>
            <input type="email" placeholder="Veuiller confirmer votre adresse e-mail" name="mail2" value="<?php if(isset($mail2)) { echo $mail2; } ?>" required>

            <p>Mot de Passe</p>
            <input type="password" placeholder="Entrer votre mot de passe" id="mdp" name="mdp" required>

			<br> <br>
            <p>Confirmation du mot de passe</p>
            <input type="password" placeholder="Veuiller confirmer le mot de passe" id="mdp2" name="mdp2" required>
            <br> <br>
			<input type="submit" name="forminscription" value="Je m'inscris">
			
			<label for=""><input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px; margin-left:-265px;margin-right:-260px"> Me souvenir du mot de passe</label>
     		<p>By creating an account you agree to our <a href="inc/regle.php" style="color:dodgerblue">Terms & Privacy</a>.</p>
            <p>Avez vous déjà un compte ? <a href="./sign_in/login.php">Se connecter</a> </p>

			
		</form>
			

        <?php
            if(isset($erreur)) {
                echo '<br> <font color="red">'.$erreur."</font>";
            }
	    ?>

    </div> 
<?php include('inc/footer.php')?>