<div id="header">
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
                include("inc/cat_menu.php");
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

    <div class="bouton_login">
        <button class="" onclick="document.getElementById('id01').style.display='block'" style="width:auto;" href="#">Login</button>      
    </div>
    <?php include('login.php')?>

    <div class="bouton_signin">
        <button class="" onclick="document.getElementById('id02').style.display='block'" style="width:auto;" href="#">Sign up</button>
    </div>
    <?php include('signup.php')?>
        
        
    
    <!-- -------------------------------------    CHACOUL FIN    -------------------------------------------- -->

</div>
