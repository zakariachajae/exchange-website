<?php
  require_once "lib/db.php";
  // Validate login
  if(!isset($_SESSION['name']) || empty($_SESSION['name'])){
    header('location: login.php');
    exit;
  }

  // recuperer les informations du produit

  //prepaer la requte sql
  $id_annonce=$_GET['id'];
  $user_id=$_SESSION['user_id'];

  $sql = 'SELECT * FROM annonces WHERE id=:id AND user_id=:user_id';
  if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id_annonce, PDO::PARAM_INT);
    if($stmt->execute()){
      //verifier si une annonce existe avec cet id
      if($stmt->rowCount() === 1){
        if($row = $stmt->fetch()){
          $produit=$row['produit'];
          $description=$row['description'];
          $produit_cible=$row['produit_cible'];
          $date_ajout=$row['date_ajout'];
           // pour extraire le nom de l'annonceur
           $user = $pdo->prepare("SELECT * FROM users WHERE id =:id LIMIT 1");
           $user->bindParam(':id', $row['user_id'], PDO::PARAM_STR);
           $user->execute();
           $r_user = $user->fetch();
           $annonceur=$r_user['name'];
        }
    }
    else{
      header('location: index.php');
    }
   
  }
 
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
<div class="ui middle aligned center aligned grid segment">
  <div class="column">
    <h2 class="ui teal image header">  Consultation de l'annonce N° <?php echo $_GET['id']; ?> </h2>
      <div class="content">
      <table class="ui celled striped table">
         <tr> <td>Produit</td>
         <td><?php echo $produit ;?></td>
         </tr>
         <tr> <td>Description</td>
         <td><?php echo $description ;?></td>
         </tr>
         <tr> <td>Produit cible</td>
         <td><?php echo $produit_cible ;?></td>
         </tr>
         <tr> <td>Annoncée par </td>
         <td><?php echo $annonceur ;?></td>
         </tr>
         <tr> <td>Publié le  </td>
         <td><?php echo $date_ajout ;?></td>
         </tr>
        </table>
      </div>
    
  <div class="ui segment blue">
  Liste des Offres
  <table class="ui celled striped table">
  <tr> 
  <th>Produit</th>
  <th>Description</th>
  <th>Par</th>
  <th>Date</th>
  <th></th>
  </tr>
  <?php 
  //prepaer la requte sql
  $sql = 'SELECT * FROM offres WHERE annonce_id=:annonce_id';
  if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(':annonce_id', $id_annonce, PDO::PARAM_INT);
    if($stmt->execute()){
       // verifie si il ya des donnees
       if($stmt->rowCount() === 0){
        ?>
              <div class="ui warning message center">
              <i class="close icon"></i>
              <div class="header">
              Aucune offre trouvée !
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
    <!-- offre -->
         <tr> 
         <td><?php echo $row['produit']; ?></td>
         <td><?php echo $row['description']; ?></td>
         <td><?php echo $r_user['name']; ?></td>
         <td><?php echo $row['date_ajout']; ?></td>
         <td> <a  class="ui button green" href="accepter.php?id=<?php echo $row['id']; ?>&annonce=<?php echo $id_annonce; ?>">Accepter</a></td>
         </tr>
    <!-- fin offre --> 

    <?php 

        }
      }
    }
  }
        ?>
        </table>
      </div>
  </div>
  </div>
</div> 
<?php
include_once("footer.php"); 
?>
</div> 
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js" integrity="sha512-dqw6X88iGgZlTsONxZK9ePmJEFrmHwpuMrsUChjAw1mRUhUITE5QU9pkcSox+ynfLhL15Sv2al5A0LVyDCmtUw==" crossorigin="anonymous"></script>
</html>