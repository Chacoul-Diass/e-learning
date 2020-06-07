    <div id="bodyleft">
        <h3>Catégories</h3>
        <ul>
            <li><a href="index.php"><i class='fas fa-home'></i>Tableau De Bord</a></li>
            <li><a href="index.php?cat"><i class='fas fa-th'></i>Voir Categories</a></li>
            <li><a href="index.php?sous_cat">Voir Sous-Categories</a></li>
            <li><a href="index.php?lang">Voir Langages</a></li>
        </ul>
        <h3>COurs</h3>
        <ul> 
            <li><a href="#">Cours activés</a></li>
            <li><a href="#">Cours En Attente</a></li>             
            <li><a href="#">Cours Non Publiés</a></li>
            <li><a href="#">Rechercher Cours</a></li>
        </ul>
        <h3>Utilisateurs</h3>
        <ul>
            <li><a href="#">Etudiants</a></li>
            <li><a href="#">Professeurs</a></li>             
            <li><a href="#">Rechercher Utilisateurs</a></li>
        </ul>
        <h3>Paiement </h3>
        <ul>
            <li><a href="#">Rémunération des Professeurs</a></li>
            <li><a href="#">Paiement Complet</a></li>            
            <li><a href="#">Rechercher Paiement</a></li>
        </ul>
        <h3>Pages</h3>
        <ul>
            <li><a href="index.php?termes">Termes & Condition</a></li>
            <li><a href="index.php?contact">Contactez-nous</a></li>
            <li><a href="index.php?apropos">A Propos</a></li>
            <li><a href="index.php?faqs">FAQs Page</a></li>
            <li><a href="#">Edition</a></li>
        </ul>
    </div>

<?php
    if(isset($_GET['cat'])){
        include("cat.php");
    }
    if(isset($_GET['lang'])){
        include("lang.php");
    }
    if(isset($_GET['sous_cat'])){
        include("sous_cat.php");
    }
    if(isset($_GET['termes'])){
        include("termes.php");
    }
    if(isset($_GET['contact'])){
        include("contact.php");
    }
    if(isset($_GET['faqs'])){
        include("faqs.php");
    }
    if(isset($_GET['apropos'])){
        include("apropos.php");
    }
?>





































