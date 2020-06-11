

<div class="name-user">

<div id="id01" class="modal">    
<form class="modal-content animate" action="#" method="post">

    <div class="imgcontainer">
        <span onclick="document.getElementById('id01').style.display='none'" class="close" title="Close Modal">&times;</span>
        <img src="./imgs/img_avatar.png" alt="Avatar" class="avatar" style="width: 150px; height: 150px;">
    </div>

    <div class="container">
        <h1>CONNEXION</h1>
        <hr>
        <label for="con_username"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="con_username" required>

        <label for="con_password"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="con_password" required>
        
        <button type="submit">Login</button>
        <label>
        <input type="checkbox" checked="checked" name="remember"> Remember me
        </label>
    </div>

    <div class="container" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('id01').style.display='none'" class="cancelbtn" id="cancelbtn">Cancel</button>
        <span class="psw">Forgot <a href="#">password?</a></span>
    </div>

</form>
<?php
    if(isset($_GET['erreur'])){
        $err = $_GET['erreur'];
        if($err==1 || $err==2)
            echo "<p style='color:red'>Utilisateur ou mot de passe incorrect</p>";
    }
?>
</div>
