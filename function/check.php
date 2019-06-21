<?php
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