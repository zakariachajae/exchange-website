<?php
  // Include db config
  require_once 'lib/db.php';

  // Init vars
  $produit = $description = $produit_cible  = '';
  $produit_err = $description_err = $produit_cible_err  = '';

  // Si le formulaire est posté
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Récuperer les données
    $produit =  trim($_POST['produit']);
    $description = trim($_POST['description']);
    $produit_cible = trim($_POST['produit_cible']);
    $date_ajout = date('Now');
    $user_id = $_SESSION['user_id'];
    $statut = 0;

    // Valider produit
    if(empty($produit)){
      $produit_err = 'Merci de sasir produit ';
    } 
    // Valider description
    if(empty($description)){
      $description_err = 'Merci de sasir la description ';
    } 
    // Valider produit_cible
    if(empty($produit_cible)){
      $produit_cible_err = 'Merci de sasir le produit cible ';
    } 

    // Vérifier si pas d'erreur dans le formualaire
    if(empty($produit_err) && empty($description_err) && empty($produit_cible_err)){
     
      // preparer la requete SQL
      $sql = 'INSERT INTO annonces (produit, description, produit_cible, date_ajout, user_id, statut ) VALUES (:produit, :description, :produit_cible, :date_ajout, :user_id, :statut )';

      if($stmt = $pdo->prepare($sql)){
        // Bind les parametres
        $stmt->bindParam(':produit', $produit, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':produit_cible', $produit_cible, PDO::PARAM_STR);
        $stmt->bindParam(':date_ajout', $date_ajout, PDO::PARAM_STR);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_STR);
        $stmt->bindParam(':statut', $statut, PDO::PARAM_STR);

        // Essai 
        if($stmt->execute()){
          // Redirect to index
          header('location: index.php');
        } else {
          die('Erreur !');
        }
      }
      unset($stmt);
    }

    // Fermer la connexion
    unset($pdo);
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
    <h2 class="ui teal image header">
      <div class="content">
        Créer un nouvelle annonce
      </div>
    </h2>
    <form class="ui large form" method="POST" >
      <div class="ui stacked segment">
        <div class="field">
        Produit
          <div class="ui left icon input">
            <i class=" icon"></i>
            <input type="text" name="produit" placeholder="Produit" value="<?php echo $produit; ?>">
          </div>
          <?php if (!empty($produit_err)) { ?>
              <div class="ui red message"><?php echo $produit_err; ?></div>
            <?php } ?>
        </div>
        <div class="field">
        Description
          <div class="ui left icon input">
            <i class=" icon"></i>
            <textarea name="description"  value="<?php echo $description; ?>"></textarea>
          </div>
          <?php if (!empty($description_err)) { ?>
              <div class="ui red message"><?php echo $description_err; ?></div>
            <?php } ?>
        </div>
        <div class="field">
        Produit cible
          <div class="ui left icon input">
            <i class=" icon"></i>
            <textarea name="produit_cible"  value="<?php echo $produit_cible; ?>"></textarea>
          </div>
          <?php if (!empty($produit_cible_err)) { ?>
              <div class="ui red message"><?php echo $produit_cible_err; ?></div>
            <?php } ?>
        </div>

        <input type="submit" value="Créer" class="ui fluid large teal submit button">
      </div>

      <div class="ui error message"></div>

    </form>

   
  </div>
</div> 
<?php
include_once("footer.php"); 
?>
</div> 
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js" integrity="sha512-dqw6X88iGgZlTsONxZK9ePmJEFrmHwpuMrsUChjAw1mRUhUITE5QU9pkcSox+ynfLhL15Sv2al5A0LVyDCmtUw==" crossorigin="anonymous"></script>
</html>