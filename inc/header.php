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
    <div class="bouton">
        <button class="" onclick="document.getElementById('id02').style.display='block'" style="width:auto;" href="./pages/signup.php">Connexion</button>
        <button class="" onclick="document.getElementById('id02').style.display='block'" style="width:auto;" href="./pages/signup.php">Inscription</button>
    </div>
    
    <!-- Connexion -->
    <div class="name-user">

        <div id="id01" class="modal">    
        <form class="modal-content animate" action="#" method="post">

            <div class="imgcontainer">
                <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img src="./imgs/img_avatar.png" alt="Avatar" class="avatar" style="width: 150px; height: 150px;">
            </div>

            <div class="container">
                <label for="uname"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="uname" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>
                
                <button type="submit">Login</button>
                <label>
                <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn">Cancel</button>
                <span class="psw">Forgot <a href="#">password?</a></span>
            </div>

        </form>
    </div>

    <!--  Partie Inscription -->
    <div class="name-user">

        <div id="id02" class="modal">    
        <form class="modal-content animate" action="#" method="post">

            <div class="imgcontainer">
                <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
                <img src="./imgs/img_avatar.png" alt="Avatar" class="avatar" style="width: 150px; height: 150px;">
            </div>

            <div class="container">
                <h1>INSCRIPTION</h1>
                <p>Veuillez remplir ce formulaire pour créer un compte.</p>
                <hr>
                <label for="email"><b>Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>

                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

                <hr>
                <p>By creating an account you agree to our <a href="pages/regle.php">Terms & Privacy</a>.</p>
                
                <button type="submit">S'inscrire</button>
            </div>

            <div class="container" style="background-color:#f1f1f1">
                <button type="button" onclick="document.getElementById('id02').style.display='none'" class="cancelbtn">Cancel</button>
            </div>

        </form>
    </div>
<!-- -------------------------------------    CHACOUL FIN    -------------------------------------------- -->

</div>
