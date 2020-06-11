<?php
	session_start();
	 
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=e_learning', 'root', '');
	 
	if(isset($_POST['formconnexion'])) {
	   $mailconnect = htmlspecialchars($_POST['mailconnect']);
	   $mdpconnect = sha1($_POST['mdpconnect']);
	   if(!empty($mailconnect) AND !empty($mdpconnect)) {
	      $requser = $bdd->prepare("SELECT * FROM connexion WHERE email = ? AND pwd = ?");
	      $requser->execute(array($mailconnect, $mdpconnect));
	      $userexist = $requser->rowCount();
	      if($userexist == 1) {
	         $userinfo = $requser->fetch();
	         $_SESSION['id'] = $userinfo['id'];
	         $_SESSION['user'] = $userinfo['username'];
	         $_SESSION['email'] = $userinfo['email'];
	         header("Location: ../user/index.php?id=".$_SESSION['id']);
	      } else {
	         $erreur = "Mot de passe ou E-mail incorrect !!!";
	      }
	    } //else {
	//       $erreur = "Tous les champs doivent être complétés !";
	//    }
	}
?>


<?php include('inc/header.php')?>
    <div class="signin">
        <img src="imgs/photo3.jpg" alt="avatar" class="avatar">
        <h1>Connexion</h1>
        <form action="" method="POST">

            <p>E-mail</p>
            <input type="email" placeholder="Entrer votre adresse e-mail" name="mailconnect" required>

            <p>Mot de Passe</p>
            <input type="password" placeholder="Entrer votre mot de passe" name="mdpconnect" required>
            
            <input type="submit" name="formconnexion" value="Se connecter">

            <a href="#">Mot de passe oublié ??</a> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
            <a href="./sign_up/signup.php">S'inscrire ??</a>
        </form>

        <?php
	         if(isset($erreur)) {
	            echo '<br> <font color="red">'.$erreur."</font>";
	         }
	    ?>

    </div> 
<?php include('inc/footer.php')?>