<?php
    include 'dbconnect.php';
  
    session_start();
  
    if(isset($_SESSION['id']) && isset($_SESSION['password']))
    {
      $req = $db->prepare("SELECT id FROM users WHERE id = ? AND password = ?");
      $req->execute([$_SESSION['id'],$_SESSION['password']]);
    }
    else{
      echo "<script type='text/javascript'>window.location.href='../index.php';</script>";
    }
    session_destroy();
    echo "<script type='text/javascript'>window.location.href='../index.php?deconnexion';</script>";
?>