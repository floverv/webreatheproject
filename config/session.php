<?php
  include 'dbconnect.php';
  require 'function/roles.php';

  session_start();
  $id_user = null;
  $role_user=null;

  if(isset($_SESSION['id']) && isset($_SESSION['password']))
  {
    $req = $db->prepare("SELECT id FROM users WHERE id = ? AND password = ?");
    $req->execute([$_SESSION['id'],$_SESSION['password']]);
    $id_user=$_SESSION['id'];
    $role_user = getRole($id_user);
  }
  else{
    echo "<script type='text/javascript'>window.location.href='index.php';</script>";
    die();
  }
?>