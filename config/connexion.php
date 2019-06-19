<?php
require 'dbconnect.php';

// récupération des valeurs du champ HTML

$email = $_POST['email'];
$password = $_POST['password'];

//Récupération des information depuis la BDD

$requete = $db->prepare("SELECT * FROM users WHERE email = ?");
$requete->execute([$email]);

$row = $requete->fetch();

// Vérification de l'excistance du comtpe

if ($row == Null) {
	echo "<script type='text/javascript'>window.location.href='../index.php?error_session';</script>";
} 
// Connexion à la session
else if ($password == $row['password']) {
	session_start();

	$_SESSION['id'] = $row['id'];
	$_SESSION['password'] = $row['password'];

	echo "<script type='text/javascript'>window.location.href='../home.php';</script>";
} 
// Mauvaise connexion
else {
	echo "<script type='text/javascript'>window.location.href='../index.php?error_password';</script>";
}

?>