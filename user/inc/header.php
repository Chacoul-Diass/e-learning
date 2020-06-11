<?php
	session_start();
	 
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=e_learning', 'root', '');
	 
	if(isset($_GET['id']) AND $_GET['id'] > 0) {
	   $getid = intval($_GET['id']);
	   $requser = $bdd->prepare('SELECT * FROM connexion WHERE id = ?');
	   $requser->execute(array($getid));
	   $userinfo = $requser->fetch();
?>

<div id="header"> 
    <div id="logo">
        <h2> <a href="../index.php"> SCOLAR </a> </h2>
    </div>
    <div id="title">
        <h2>Bienvenue à SCOLAR <?php echo $userinfo['username']; ?></h2>
        <h2><?php echo $userinfo['email']; ?></h2>
        
    </div>
    <?php
	    if(isset($_SESSION['id']) AND $userinfo['id'] == $_SESSION['id']) {
	?>

    <div class="topnav"> 
        <a href="editionprofil.php">Profil</a>
    </div>

    <div class="topnav2"> 
        <a href="deconnexion.php">Déconnexion</a>
    </div>

    <?php
         }
    ?>
</div>

<?php   
	}
    ?>
<style>
    
.topnav {
    overflow: hidden;
    background-color: #3f5267;
    text-align: center;
    width: 8%;
    height: 60px;
    float: left;
    box-sizing: border-box;
    border-right: 1px solid rgba(0,0,0,0.2);
    border-radius: 2px;
    
  }
  
  .topnav a {
    float: left;
    color: #f2f2f2;
    text-align: center;
    padding: 20px 12px;
    text-decoration: none;
    font-size: 17px;
    margin-right: 70px;
    margin-left: -5px;
  }
  
  .topnav a:hover {
    background-color: #fff;
    color:#3f5267;
  }
  
  
  .topnav2 {
    overflow: hidden;
    background-color: #3f5267;
    text-align: center;
    width: 8%;
    height: 60px;
    float: left;
    box-sizing: border-box;
    border-right: 1px solid rgba(0,0,0,0.2);
    border-radius: 2px;
    
  }
  
  .topnav2 a {
    float: left;
    color: #f2f2f2;
    text-align: center;
    padding: 20px 13px;
    text-decoration: none;
    font-size: 17px;
    margin-right: 60px;
    margin-left: -5px;
  }
  
  .topnav2 a:hover {
    background-color: #fff;
    color:#3f5267;
  }

</style>