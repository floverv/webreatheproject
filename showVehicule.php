<html>
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
        <?php
            if(isset($_GET['immat']))
            {
                $immat = $_GET['immat'];
                if(!checkImmat($immat))
                {
                    echo '<div class="alert alert-danger margintop25" role="alert">Le véhicule est introuvable.</div>';
                }
            }
            else{
                die();
                echo "<script type='text/javascript'>window.location.href='listVehicules.php';</script>";
            }
        ?>

        <div class="card margintop25">
            <div class="card-header">
                <strong>Le véhicule</strong>
            </div>
            <section class="block">
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                            <tr>
                                <th class="center">Immatriculation</th>
                                <th class="center">Type</th>
                                <th class="center">Date d'achat</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $db->query('SELECT * FROM vehicules WHERE immatriculation = "'.$immat.'"');
                            while ($row = $result->fetch()) {
                                echo '
                                <tr>
                                    <td class="center">' . $row['immatriculation'] . '</td>
                                    <td class="center">'.$row['type'].'</td>
                                    <td class="center">'.$row['dateAchat'].'</td>
                                </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <div class="card margintop25">
            <div class="card-header">
                <strong>Liste des opérations effectuées</strong>
            </div>
            <section class="block">
                <div class="table-responsive m-b-40">
                    <table class="table table-borderless table-data3">
                        <thead>
                            <tr>
                                <th class="center">ID</th>
                                <th class="center">Date de debut</th>
                                <th class="center">Date de fin</th>
                                <th class="center">Sujet</th>
                                <th class="center">Statut</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $result = $db->prepare('SELECT m.id,m.dateDebut,m.dateFin,m.sujet,m.etatAvancement
                            FROM maintenance m,problemevehicule p
                            WHERE m.id_probleme=p.id
                            AND	p.immatriculation = ?');
                            $result->execute([$immat]);

                            while ($row = $result->fetch()) {
                                echo '
                                <tr>
                                    <td class="center">' . $row['id'] . '</td>
                                    <td class="center">'.$row['dateDebut'].'</td>
                                    <td class="center">'.$row['dateFin'].'</td>
                                    <td class="center">'.$row['sujet'].'</td>
                                    <td class="center">'.$row['etatAvancement'].'</td>
                                    <td class="center"><a href="showMaintenance.php?id='.$row['id'].'" class="btn btn-primary">Voir plus</a></td>
                                </tr>';
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