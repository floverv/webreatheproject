<?php
  include 'dbconnect.php';
  require 'function/roles.php';

  // INITIALISATION DE LA SESSION AU LOGIN AVEC SES VARIABLES GLOBALES
  session_start();
  $id_user = null;
  $role_user=null;

  if(isset($_SESSION['id']) && isset($_SESSION['password']))
  {
    // VERIFICATIONS DES INFORMATIONS
    $req = $db->prepare("SELECT id FROM users WHERE id = ? AND password = ?");
    $req->execute([$_SESSION['id'],$_SESSION['password']]);
    // ATTRIBUTIONS DES VARIABLES
    $id_user=$_SESSION['id'];
    $role_user = getRole($id_user);
  }
  else{
    // SI LA CONNEXION EST REFUSE
    echo "<script type='text/javascript'>window.location.href='index.php';</script>";
    die();
  }
?>