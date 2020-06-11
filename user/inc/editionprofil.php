<?php
	session_start();
	 
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=e_learning', 'root', '');
	 
	if(isset($_SESSION['id'])) {
	   $requser = $bdd->prepare("SELECT * FROM connexion WHERE id = ?");
	   $requser->execute(array($_SESSION['id']));
	   $user = $requser->fetch();
	   if(isset($_POST['newpseudo']) AND !empty($_POST['newpseudo']) AND $_POST['newpseudo'] != $user['username']) {
	      $newpseudo = htmlspecialchars($_POST['newpseudo']);
	      $insertpseudo = $bdd->prepare("UPDATE connexion SET username = ? WHERE id = ?");
	      $insertpseudo->execute(array($newpseudo, $_SESSION['id']));
	      header('Location: profil.php?id='.$_SESSION['id']);
	   }
	   if(isset($_POST['newmail']) AND !empty($_POST['newmail']) AND $_POST['newmail'] != $user['email']) {
	      $newmail = htmlspecialchars($_POST['newmail']);
	      $insertmail = $bdd->prepare("UPDATE connexion SET email = ? WHERE id = ?");
	      $insertmail->execute(array($newmail, $_SESSION['id']));
	      header('Location: profil.php?id='.$_SESSION['id']);
	   }
	   if(isset($_POST['newmdp1']) AND !empty($_POST['newmdp1']) AND isset($_POST['newmdp2']) AND !empty($_POST['newmdp2'])) {
	      $mdp1 = sha1($_POST['newmdp1']);
	      $mdp2 = sha1($_POST['newmdp2']);
	      if($mdp1 == $mdp2) {
	         $insertmdp = $bdd->prepare("UPDATE connexion SET pwd = ? WHERE id = ?");
	         $insertmdp->execute(array($mdp1, $_SESSION['id']));
	         header('Location: profil.php?id='.$_SESSION['id']);
	      } else {
	         $msg = "Vos deux mdp ne correspondent pas !";
	      }
	   }
?>

<?php include('inc/header.php')?>
    <div class="signin">
		<img src="imgs/photo3.jpg" alt="avatar" class="avatar">
		<br><br><br>
        <h1>Edition de mon profil</h1>
        <form action="" method="POST" enctype="multipart/form-data">


            <p>Pseudo</p>
            <input type="text" placeholder="Entrer votre nouveau pseudo" name="newpseudo" value="<?php echo $user['username']; ?>" required> <br> <br>

            <p>E-mail</p>
            <input type="email" placeholder="Entrer votre nouvelle adresse e-mail" name="newmail" value="<?php echo $user['email']; ?>"  required>

            <p>Mot de Passe</p>
            <input type="password" placeholder="Entrer votre nouveau mot de passe" name="newmdp" required>

			<br> <br>
            <p>Confirmation du mot de passe</p>
            <input type="password" placeholder="Confirmer le mot de passe" name="newmdp2" required>

            <br> <br>
			<input type="submit"  value="Mettre à jour mon profil !">
			<input type="reset" value="Vider">
				
		</form>
		<?php if(isset($msg)) { echo $msg; } ?>

    </div> 

    <?php   
	}
	else {
	   header("Location: ../sign_in/login.php");
	}
	?>

<?php include('inc/footer.php')?>