<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
// initialiser la session
if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
/*** mysql hostname ***/
$db_hostname = 'localhost';

/*** mysql database name ***/
$db_dbname   = 'exchange_db';

/*** mysql username ***/
$db_username = 'root';

/*** mysql password ***/
$db_password = '';

/*** mysql database charset ***/
$db_charset = 'utf8';


try {
    $pdo = new PDO("mysql:host=$db_hostname;dbname=$db_dbname", $db_username, $db_password);
    //echo 'Connected to database! </br>';

    }
catch(PDOException $e)
    {
    echo " Erreur de la connexion avec la base de données";
    die();
    }
 ?>