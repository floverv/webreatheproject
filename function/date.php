<?php

// RETOURNE LE MOIS ASSOCIER A SON NUMERO
function getMonth($month)
{
    if($month == '01')
    {
        return "Janvier";
    }
    if($month == '02')
    {
        return "Février";
    }
    if($month == '03')
    {
        return "Mars";
    }
    if($month == '04')
    {
        return "Avril";
    }
    if($month == '05')
    {
        return "Mai";
    }
    if($month == '06')
    {
        return "Juin";
    }
    if($month == '07')
    {
        return "Juillet";
    }
    if($month == '08')
    {
        return "Août";
    }
    if($month == '09')
    {
        return "Septembre";
    }
    if($month == 10)
    {
        return "Octobre";
    }
    if($month == 11)
    {
        return "Novembre";
    }
    if($month == 12)
    {
        return "Décembre";
    }
}

?>