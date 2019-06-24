<html>
    <title>Liste des véhicules</title>
<?php
require 'config/session.php';
require 'function/check.php';
require 'header.php';
/*if($role_user != "technicien")
{
    echo "<script type='text/javascript'>window.location.href='home.php';</script>";
    die();
}
 
        Variables:
            $id_user : id de l'utilisateur connecté,
            $role_user : role de l'utilisateur connecté
        */
?>

<body>
    <?php require_once 'navbar.php'; ?>

    <div class="container">
        <!-- DIV CACHÉE POUR LA RECHERCHE DUN VEHICULE -->
        <div id="hidden_block"class="jumbotron margintop25" style="display:none;">
            <form action="showVehicule.php" method="GET">
                <div class="form-group">
                <h1 class="display-4">Rechercher un véhicule</h1>
                    <hr>
                    <input type="text" class="form-control" name="immat" pattern="[A-HJ-NP-TVX-Z]{2}-[0-9]{3}-[A-HJ-NP-TVX-Z]{2}" placeholder="Veuillez rentrer l'immatriculation" required>
                    <small class="form-text text-muted">Respecter ce format : XX-XXX-XX</small>
                </div>
                <input type="submit" class="btn btn-primary" value="Rechercher">
            </form>
        </div>
        <!-- FIN DE LA DIV -->
        
        <div class="card margintop25">
            <div class="card-header">
                <strong>Liste des véhicules</strong>
                <a class="btn btn-outline-primary search-btn">Rechercher</a>
            </div>
            <section class="block">
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                            <tr>
                                <th class="center">Immatriculation</th>
                                <th class="center">Type</th>
                                <th class="center">Date d'achat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $db->query('SELECT * FROM vehicules');
                            while ($row = $result->fetch()) {
                                // RETOURNE TOUS LES VEHICULES DE LA BDD
                                echo '
                                <tr>
                                    <td class="center">' . $row['immatriculation'] . '</td>
                                    <td class="center">'.$row['type'].'</td>
                                    <td class="center">'.$row['dateAchat'].'</td>
                                    <td class="center"><a href="showVehicule.php?immat='.$row['immatriculation'].'" class="btn btn-primary">Voir plus</a></td>
                                </tr>';
                                // BOUTTON VOIR PLUS REDIRECTION VERS LA PAGE DE LA VOITURE ASSOCIÉE
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</body>
<?php require 'footer.php'; ?>

</html>