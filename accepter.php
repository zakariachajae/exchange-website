<?php
  require_once "lib/db.php";
  // Validate login
  if(!isset($_SESSION['name']) || empty($_SESSION['name'])){
    header('location: login.php');
    exit;
  }

  // recuperer les informations du produit

  //prepaer la requte sql
  $offre_id=$_GET['id'];
  $annonce_id=$_GET['annonce'];
// mise à jour de l'offre
  $sql = 'UPDATE  offres SET accepter=1 WHERE id=:offre_id ';
  if($stmt = $pdo->prepare($sql)){
    $stmt->bindParam(':offre_id', $offre_id, PDO::PARAM_INT);
    if($stmt->execute()){
      
        // mise à jour de l'annonce
        $sql = 'UPDATE  annonces  SET statut=1 WHERE id=:annonce_id';
        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(':annonce_id', $annonce_id, PDO::PARAM_INT);
            if($stmt->execute()){
                header('location: index.php');
            }
            }
 
}
}