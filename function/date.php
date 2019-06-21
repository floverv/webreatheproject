<?php
function getMonth($month)
{
    switch($month){
        case 01:
            return "Janvier";
            break;
        case 02:
            return "Fevrier";
            break;
        case 03:
            return "Mars";
            break;
        case 04:
            return "Avril";
            break;
        case 05:
            return "Mai";
            break;
        case 06:
            return "Juin";
            break;
        case 07:
            return "Juillet";
            break;
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