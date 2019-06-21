<html>
<?php
require 'config/session.php';
require 'header.php';
if($role_user != "gestionnaire")
{
    echo "<script type='text/javascript'>window.location.href='home.php';</script>";
    die();
}
/* 
Variables:
    $id_user : id de l'utilisateur connecté,
        $role_user : role de l'utilisateur connecté
*/
?>

<body>
    <?php require_once 'navbar.php'; ?>

    <div class="container">
        <?php
            if(isset($_GET['insert'])){
                $pattern_immat = "#[A-HJ-NP-TVX-Z]{2}-[0-9]{3}-[A-HJ-NP-TVX-Z]{2}#";
                $pattern_date = "#[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])#";
                
                $immat = $_POST['immatriculation'];
                $type = $_POST['type'];
                $date_achat = $_POST['date_achat'];

                if($immat=="" || $type=="" || $date_achat == "" || !preg_match($pattern_immat,$immat) || !preg_match($pattern_date,$date_achat) )
                {
                    echo "<script type='text/javascript'>window.location.href='addVehicule.php';</script>";
                    die();
                }
                else{
                    $requete = $db->prepare("INSERT INTO `vehicules`(`immatriculation`, `type`, `dateAchat`) VALUES(?,?,?)");
                    $requete->execute([$immat,$type,$date_achat]);

                    echo '
                        <div class="alert alert-success margintop25" role="alert">
                            Le véhicule a bien été crée.
                        </div>';
                }
            }
        ?>

        <div class="card margintop25">
            <div class="card-header">
                <strong>Ajout d'un véhicule</strong>
            </div>
            <section class="block">
                <form action="addVehicule.php?insert" method="post">
                    <div class="form-group">
                        <label for="selectUser">immatriculation</label>
                        <input type="text" class="form-control" name="immatriculation" pattern="[A-HJ-NP-TVX-Z]{2}-[0-9]{3}-[A-HJ-NP-TVX-Z]{2}" placeholder="Veuillez rentrer l'immatriculation" required>
                        <small class="form-text text-muted">Respecter ce format : XX-XXX-XX</small>
                    </div>
                    <div class="form-group">
                        <label for="selectUser">Type</label>
                        <input type="text" class="form-control" name="type" placeholder="Veuillez rentrer le type du véhicule" required>
                    </div>
                    <div class="form-group">
                        <label for="selectUser">Date d'achat</label>
                        <input type="text" class="form-control" name="date_achat" pattern="[0-9]{4}-(0[1-9]|1[012])-(0[1-9]|1[0-9]|2[0-9]|3[01])" placeholder="Veuillez rentrer la date d'achat du véhicule" required>
                        <small class="form-text text-muted">Respecter ce format : AAAA-MM-DD</small>
                    </div>
                    <input type="submit" class="btn btn-success btn_valider" value="Valider">
                </form>
            </section>
        </div>

        <?php

            if(isset($_GET['immat']))
            {
                $immat = $_GET['immat'];

                $requete = $db->prepare("DELETE FROM vehicules WHERE immatriculation = ?");
                $requete->execute([$immat]);

                echo '
                <div class="alert alert-success margintop25" role="alert">
                    Le véhicule a bien été supprimé.
                </div>';
            }

        ?>

        <div class="card margintop25">
            <div class="card-header">
                <strong>Liste des véhicules</strong>
            </div>
            <div class="table-responsive m-b-40 block">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th class="center">Immatriculation</th>
                            <th class="center">Type</th>
                            <th class="center">Date d'achat</th>
                            <th style="width: 300px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $result = $db->query('SELECT * from vehicules');
                        $i = 0;
                        while ($row = $result->fetch()) {
                            $i++;
                            echo '
                                <form action="addVehicule.php?immat='.$row['immatriculation'].'" method="post" class="form-horizontal">
                                    <tr>
                                        <td class="center">' . $row['immatriculation'] . '</td>
                                        <td class="center">' . $row['type'] . '</td>
                                        <td class="center">' . $row['dateAchat'] . '</td>
                                        <td class="center"><input type="submit" class="btn btn-danger" value="Supprimer"></td>
                                    </tr>
                                </form>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</body>
<?php require 'footer.php'; ?>

</html>