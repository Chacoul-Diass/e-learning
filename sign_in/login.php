<<<<<<< HEAD
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
=======

    


<body>
    <?php include('inc/header.php')?>
    <div class="signin">
        <img src="\imgs\1.png" alt="avatar" class="avatar">
        <h1>Connexion</h1>
        <form action="">
            <p>Username</p>
            <input type="text" placeholder="Enter Username" name="username" required>
            <p>Password</p>
            <input type="password" placeholder="Enter Password" required>
            <input type="submit" name="" value="Se connecter">

            <a href="#">Lost your Password ?</a> <br>
            <a href="#">Don't have an account ?</a>

        </form>
    </div> 
    
<?php include('inc/footer.php')?>
        
<!-- tester si l'utilisateur est connecté -->
<?php
    //Connexion à la base de données
    try{
        $pdo = new PDO("mysql:host=localhost;dbname=e_learning", "root","");
    }
    catch(Exception $e){
        die('ERROR : '.$e->getMessage());
    }
        
    //Nous vérifions que l'utilisateur a bien envoyé les informations demandées 
    if(isset($_POST["username"]) && isset($_POST["password"])){
        //Nous allons demander le hash pour cet utilisateur à notre base de données :
        $query = $pdo->prepare('SELECT password FROM connexion WHERE username = :username');
        $query->bindParam(':username', $_POST["username"]);
        $query->execute();
        $result = $query->fetch();
        $hash = $result[0];
        
        //Nous vérifions si le mot de passe utilisé correspond bien à ce hash à l'aide de password_verify :
        $correctPassword = password_verify($_POST["password"], $hash);
        
        if($correctPassword){
            //Si oui nous accueillons l'utilisateur identifié
            include('header.php');
            echo "Bienvenu ".$_POST["username"]; 
            include('footer.php');
        }else{
            //Sinon nous signalons une erreur d'identifiant ou de mot de passe
            echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
        }
    }
?>   








>>>>>>> da4c2d020bd15caf1d2f2e34a25d98dd1214e453
