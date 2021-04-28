<?php 
 // Init session
 if(!isset($_SESSION)) 
 { 
     session_start(); 
 } 
 ?>
<div class="ui menu inverted blue">
  <a class="item" href="index.php">Accueil</a>
  <?php 
    if(isset($_SESSION['name']) && !empty($_SESSION['name']))
    {
    ?>
  
  <a class="item" href="annonce.php">Créer une annonce</a>
  <?php
    }
    ?>
  <div class="right menu">
   
    <?php 
    if(isset($_SESSION['name']) && !empty($_SESSION['name']))
    {
    ?>
    <a class="item"> Bonjour <?php echo $_SESSION['name']; ?></a>
    <a class="item" href="profil.php">profil</a>
    <a class="item" href="logout.php">Se deconnecter</a>
   
    <?php
    }
    else{
    ?>
     <a class="item" href="login.php">Se connecter</a>
     <a class="item" href="compte.php">Créer un compte</a>
    <?php 
}
    ?>
  </div>
</div>