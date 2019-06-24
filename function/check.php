<?php
// VERIFIER SI LA NOTE EXISTE DEJA POUR LA CREER OU LA MODIFIER
function checkNote($id_m,$id_u)
{
    require 'config/dbconnect.php';

    $check = false;

    $sql = "SELECT note FROM notemaintenance WHERE id_maintenance = ? AND id_technicien = ?";
    $requete = $db->prepare($sql);
    $requete->execute([$id_m,$id_u]);

    $result = $requete->fetch();

    if($result!=null)
    {
        $check = true;
    }

    return $check;
}

// VERIFIER SI LA PLAQUE EXISTE
function checkImmat($immat)
{
    require 'config/dbconnect.php';

    $check = false;

    $sql = "SELECT * FROM vehicules WHERE immatriculation = ?";
    $requete = $db->prepare($sql);
    $requete->execute([$immat]);

    $result = $requete->fetch();

    if($result!=null)
    {
        $check = true;
    }

    return $check;
}

// VERIFIER SI LOPERATION DE MAINTENANCE EEXISTE
function checkOperation($id)
{
    require 'config/dbconnect.php';

    $check = false;

    $sql = "SELECT * FROM maintenance WHERE id = ?";
    $requete = $db->prepare($sql);
    $requete->execute([$id]);

    $result = $requete->fetch();

    if($result!=null)
    {
        $check = true;
    }

    return $check;
}


?>