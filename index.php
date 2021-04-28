<?php
  require_once "lib/db.php";
  // Validate login
  if(!isset($_SESSION['name']) || empty($_SESSION['name'])){
    header('location: login.php');
    exit;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" integrity="sha512-8bHTC73gkZ7rZ7vpqUQThUDhqcNFyYi2xgDgPDHc+GXVGHXq+xPjynxIopALmOPqzo9JZj0k6OqqewdGO3EsrQ==" crossorigin="anonymous" />
    <link rel="stylesheet" href="css/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exchange</title>
</head>
<body>
<div class="ui container padtop">
<?php
include_once("header.php"); 
?>
<!-- produits -->
<div class="ui segment blue">
<div class="ui info message">
  <i class="close icon"></i>
  <div class="header">
  this website is a marketplace where instead of buying and selling good, we are offering and experience for people who dont have money to exchange goods between them without having to pay for them
  </div>
</div>
<div class="ui cards">
  <?php 
  //prepaer la requte sql
  // statut=0 --> annonce ouverte   statut =1 ---> annonce fermée
  $sql = 'SELECT * FROM annonces WHERE statut=0';
  if($stmt = $pdo->prepare($sql)){
    if($stmt->execute()){
       // verifie si il ya des donnees
       if($stmt->rowCount() === 0){
        ?>
              <div class="ui warning message center">
              <i class="close icon"></i>
              <div class="header">
              Aucune annonce trouvé !
              </div>
              </div>
        <?php
       }
       else{
        while ($row = $stmt->fetch()) {
          // pour extraire le nom de l'annonceur
          $user = $pdo->prepare("SELECT * FROM users WHERE id =:id LIMIT 1");
          $user->bindParam(':id', $row['user_id'], PDO::PARAM_STR);
          $user->execute();
          $r_user = $user->fetch();

    ?>
  <!-- produit -->
  <div class="card">
    <div class="content">
      <div class="header"><?php echo $row['produit']; ?></div>
      <a class="ui image label">
  <img src="img/avi1.png"> <?php echo $r_user['name']?>

</a>
      <br>
      <a class="ui orange ribbon label"> le : <?php echo $row['date_ajout']; ?></a>
      <div class="description">
        <b>Description</b> : <?php echo $row['description']; ?> <br>
        <b>Produit cible </b>: <?php echo $row['produit_cible']; ?>
      </div>
      
    </div>
    <?php
    if($row['user_id']!=$_SESSION['user_id']){
    ?>
    <div class="ui bottom attached button teal">
      <i class="add icon"></i>
     <a href="offre.php?id=<?php echo $row['id'];?>"> Proposer une offre</a>
    </div>
  <?php
    }
  else{
    ?>
    <div class="ui bottom attached button green">
      <i class="pencil icon white"></i>
      <a href="consultation.php?id=<?php echo $row['id'];?>"> Consulter</a>
    </div>
    <?php
  }
    ?>
  </div>

  <!-- //produit -->
  <?php 
  }
}
}
}
  ?>

  
</div>

</div>
<!-- // produits -->
<?php
include_once("footer.php"); 
?>
</div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js" integrity="sha512-dqw6X88iGgZlTsONxZK9ePmJEFrmHwpuMrsUChjAw1mRUhUITE5QU9pkcSox+ynfLhL15Sv2al5A0LVyDCmtUw==" crossorigin="anonymous"></script>
</html>