<?php
  // Include db config
  require_once 'lib/db.php';
  // Init vars
  $name = $email = $password = $confirm_password = '';
  $name_err = $email_err = $password_err = $confirm_password_err = '';

  // Si le formulaire est posté
  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    // Récuperer les données
    $name =  trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Valider email
    if(empty($email)){
      $email_err = 'Merci de sasir votre email ';
    } else {
      // Preparer la requete SQL
      $sql = 'SELECT id FROM users WHERE email = :email';

      if($stmt = $pdo->prepare($sql)){
        // Bind variables
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        // execute
        if($stmt->execute()){
          // Check if email exists
          if($stmt->rowCount() === 1){
            $email_err = 'Email exist déjà';
          }
        } else {
          die('Erreur !');
        }
      }
   
      unset($stmt);
    }
    // Valider le nom 
    if(empty($name)){
      $name_err = 'Merci de saisir le nom';
    }

    // Valider le mot de passe
    if(empty($password)){
      $password_err = 'Merci de saisir le mot de passe';
    } elseif(strlen($password) < 6){
      $password_err = 'Le mot de passe doit être supérieur à 6 caractères ';
    }

    //  Confirmer password
    if(empty($confirm_password)){
      $confirm_password_err = 'Merci de confirmer votre mot de passe';
    } else {
      if($password !== $confirm_password){
        $confirm_password_err = 'Les mots de passe ne correspondent pas';
      }
    }

    // Vérifier si pas d'erreur dans le formualaire
    if(empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
     
      // 
      $sql = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';

      if($stmt = $pdo->prepare($sql)){
        // Bind les parametres
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);

        // Essai 
        if($stmt->execute()){
          // Redirect to login
          header('location: login.php');
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
        Créer un nouveau compte
      </div>
    </h2>
    <form class="ui large form" method="POST" >
      <div class="ui stacked segment">
        <div class="field">
          <div class="ui left icon input">
            <i class="user icon"></i>
            <input type="text" name="name" placeholder="Nom" value="<?php echo $name; ?>">
          </div>
          <?php if (!empty($name_err)) { ?>
              <div class="ui red message"><?php echo $name_err; ?></div>
            <?php } ?>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="mail icon"></i>
            <input type="text" name="email" placeholder="E-mail" value="<?php echo $email; ?>">
          </div>
          <?php if (!empty($email_err)) { ?>
              <div class="ui red message"><?php echo $email_err; ?></div>
            <?php } ?>
        </div>
        
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="password" placeholder="Mot de passe">
          </div>
          <?php if (!empty($password_err)) { ?>
              <div class="ui red message"><?php echo $password_err; ?></div>
            <?php } ?>
        </div>
        <div class="field">
          <div class="ui left icon input">
            <i class="lock icon"></i>
            <input type="password" name="confirm_password" placeholder="Confirmer le mot de passe">
          </div>
          <?php if (!empty($confirm_password_err)) { ?>
              <div class="ui red message"><?php echo $confirm_password_err; ?></div>
            <?php } ?>
            
        </div>
        <input type="submit" value="Créer" class="ui fluid large teal submit button">
      </div>
      

      <div class="ui error message"></div>

    </form>

    <div class="ui message">
      Vous avez un compte? <a href="login.php">Se connecter</a>
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