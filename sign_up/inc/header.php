
<!DOCTYPE html>
<html>
    <head>
        <meta charset "utf-8" />
        <title>E Learning | Home</title>
        <link rel="stylesheet" href="./css/styles.css" />
        <script src="https://kit.fontawesome.com/f481d2cc97.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" type="text/css" href="css/styles_signin_and_signup.css">
        <script type="text/javascript" src="javascript/js_signin_and_signup.js"></script>
    </head>

    <body><div id="header">
    <div id="up_head">
        
        <div id="date">
            <p>
                <?php
                    echo date('l, d F Y');
                ?>
            </p>
        </div>
        <div id="slog">
            <p>
                Numero 1 des Sites de E learning Ivoirien
            </p>
        </div>
    </div>
    <div id="titre">
        <h2><a href="index.php">E Learning</a></h2>
    </div>
    <div id="menu">
        <h2>
            <i class="fas fa-bars"></i>
            <?php
                include("cat_menu.php");
            ?>
        </h2>
    </div>
    <div id="head_recherche">
        <form method="post" enctype="multipart/form-data">
            <input type="recherche" name="requete" placeholder="Rechercher Cours Ici">
            <button name="recherche"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div id="head_panier">
        <a href="panier.php"><i class="fas fa-shopping-cart"></i> <span>0</span></a>
    </div>

    <!-- -------------------------------------    CHACOUL DEBUT    -------------------------------------------- -->

    <div class="topnav">
        <a class="fas fa-user" href="./user/login.php">Connexion</a>  
    </div>  

    <div class="topnav2">
        <a class="fas fa-user-plus" href="./user/signup.php">S'inscrire</a>  
    </div> 

    <!-- -------------------------------------    CHACOUL FIN    -------------------------------------------- -->

</div>
