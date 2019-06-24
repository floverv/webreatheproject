<?php

// CONNEXION A LA BASE DE DONNÉES
try{
    $db = new PDO('mysql:host=localhost; dbname=webreathe','root','');
}
catch (Exception $e)
{
    die('Erreur : ' . $e->getMessage());
}

// CHEMIN POUR HÉBERGER LES FICHIERS EN LOCAL POUR LES OPERATIONS
$host = 'http://localhost/webreatheproject/';
$img_path = 'common/Pictures/Maintenance/';

// INITIALISISER LA DATE POUR TOUTES LES PAGES
date_default_timezone_set('UTC');
$today = date("Y-m-d");



?>