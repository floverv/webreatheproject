<html>
    <title>Tableau de bord</title>
<?php
require 'config/session.php';
require 'function/date.php';
require 'header.php';
/* 
        Variables:
            $id_user : id de l'utilisateur connecté,
            $role_user : role de l'utilisateur connecté
        */
?>

<body>
    <?php
    require_once 'navbar.php';
    ?>

    <div class="container">
        <?php
            // INITIALISATION DES PARAMETRES DU GRAPHIQUE CHART JS DU MOIS ACTUEL
            $month = date("m"); // NUMERO DU MOIS
            $startMonth = date('Y').'-'.$month.'-01'; // DEBUT DU MOIS LE 01
            $endMonth = date('Y').'-'.$month.'-30'; // FIN DU MOIS LE 30

            // RETOURNE LE COMTPE DE TOUTES LES MAINTENANCES ENTRE LE DEBUT ET LA FIN DU MOIS
            $sql="SELECT count(id) FROM maintenance WHERE dateFin BETWEEN '".$startMonth."' AND '".$endMonth."' ";
            $requete = $db->query($sql);
            $result = $requete->fetch();

            // INITIALISATION DES TABLEAUX

            $nbMaintenance[] = $result['count(id)']; // COLLECTION DES COMPTE DES OPERATIONS POUR CHAQUE MOIS

            $month_graph[] = getMonth($month); // COLLECTION DES MOIS DE LANNEE SELECTIONNER

            // SUR UN INTERVAL DE 4 MOIS
            for($i = 1;$i<4;$i++){
                // INITIALISATION DES MOIS PRECEDENTS
                $monthless = date("m", strtotime("$today -".$i." month")); // MOIS PRECEDENT
                $startMonth = date('Y').'-'.$monthless.'-01'; // DEBUT DU MOIS PRECEDENT
                $endMonth = date('Y').'-'.$monthless.'-30'; // FIN DU MOIS PRECEDENT

                // RETOURNE LE COMTPE DE TOUTES LES MAINTENANCES ENTRE LE DEBUT ET LA FIN DU MOIS DU MOIS PRECEDENT
                $sql="SELECT count(id) FROM maintenance WHERE dateFin BETWEEN '".$startMonth."' AND '".$endMonth."' ";
                $requete = $db->query($sql);
                $result = $requete->fetch();

                array_push($nbMaintenance,$result['count(id)']); // AJOUTE A LA COLLECTION LE COMPTE
                array_push($month_graph,getMonth($monthless)); // AJOUTE A LA COLLECTION LE MOIS ASSOCIES
            }
            
            // RETOURNE LE NOMBRE DE TOUTES LES OPERATIONS DE MAINTENANCE TERMINEES 
            $sql="SELECT count(id) FROM maintenance WHERE etatAvancement='termine' ";
            $requete = $db->query($sql);
            $result = $requete->fetch();
            $nbTotalMaintenance = $result['count(id)'];


        ?>
        <div class="card-deck margintop25">
            <!-- Card -->
            <div class="card mb-4">

                <!--AFFICHAGE DU GRAPHIQUE-->
                <div class="view overlay margintop25">
                    <center><canvas id="chartData" width="auto"></canvas></center>
                </div>

                <!--Card content-->
                <div class="card-body">
                    <h4 class="card-title">Nombres totales d'opérations effectuées par mois</h4>

                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste at adipisci placeat, itaque quos quaerat voluptatum magni recusandae velit odit perspiciatis incidunt necessitatibus, dolores nemo, distinctio perferendis saepe pariatur assumenda?</p>

                </div>

            </div>

            <div class="card mb-4">

                <!--Card image-->


                <!--Card content-->
                <div class="card-body">

                    <!--Title-->
                    <h4 class="card-title display-4"> Opération de maintenance terminé</h4>
                    <!-- AFFICHAGE LE NOMBRE TOTAL DE MAINTENANCE TERMINEES-->
                    <p class="card-text display-2"><?php echo $nbTotalMaintenance;?></p>

                </div>

            </div>
            <!-- Card -->
        </div>

        <div class="card margintop25">
            <div class="card-header">
                <?php 
                // FETCH DE TOUTES LES OPERATIONS EN COURS
                $result = $db->query('SELECT * FROM maintenance WHERE etatAvancement="en cours"'); 
                $count = $result->rowCount(); // RESULTAT DU NOMBRE DOPERATIONS EN COURS
                ?>

                <strong><?php echo $count;?> opérations de maintenances en cours</strong>
            </div>
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th class="center">ID</th>
                            <th class="center">Date de début</th>
                            <th class="center">Date de fin</th>
                            <th class="center">Sujet</th>
                            <th class="center">Description</th>
                            <th class="center">État d'avancement</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // AFFICHAGE DES OPERATIONS EN COURS
                        while ($row = $result->fetch()) {
                            echo '<tr>
                                <td class="center">' . $row['id'] . '</td>
                                <td class="center">' . $row['dateDebut'] . '</td>
                                <td class="center">' . $row['dateFin'] . '</td>
                                <td class="center">' . $row['sujet'] . '</td>
                                <td class="center">' . $row['description'] . '</td>
                                <td class="center">' . $row['etatAvancement'] . '</td>
                                <td class="center"><a href="showMaintenance.php?id=' . $row['id'] . '" class="btn btn-primary">Voir plus</a></td>
                            </tr>';
                            // bouton voir plus pour retourner sur la page de la maintenance associées
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card margintop25">
            <div class="card-header">
                <?php 
                // FETCH DE TOUTES LES OPERATIONS EN ATTENTE
                $result = $db->query('SELECT * FROM maintenance WHERE etatAvancement="en attente"'); 
                $count = $result->rowCount();// RESULTAT DU NOMBRE DOPERATIONS EN ATTENTE
                ?>

                <strong><?php echo $count;?> opérations de maintenances en attente</strong>
            </div>
            <div class="table-responsive m-b-40">
                <table class="table table-borderless table-data3">
                    <thead>
                        <tr>
                            <th class="center">ID</th>
                            <th class="center">Date de début</th>
                            <th class="center">Date de fin</th>
                            <th class="center">Sujet</th>
                            <th class="center">Description</th>
                            <th class="center">État d'avancement</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = $result->fetch()) {
                            // AFFICHAGE DES OPERATIONS EN ATTENTE
                            echo '<tr>
                                <td class="center">' . $row['id'] . '</td>
                                <td class="center">' . $row['dateDebut'] . '</td>
                                <td class="center">' . $row['dateFin'] . '</td>
                                <td class="center">' . $row['sujet'] . '</td>
                                <td class="center">' . $row['description'] . '</td>
                                <td class="center">' . $row['etatAvancement'] . '</td>
                                <td class="center"><a href="showMaintenance.php?id=' . $row['id'] . '" class="btn btn-primary">Voir plus</a></td>
                            </tr>';
                            // bouton voir plus pour retourner sur la page de la maintenance associées
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>

<?php require 'footer.php'; ?>

<script>
    // SCRIPT DU GRAPHIQUE AVEC LES COLLECTIONS ASSOCIEES
    var monthsData = {
        <?php echo'labels: ["'.$month_graph[3].'", "'.$month_graph[2].'", "'.$month_graph[1].'", "'.$month_graph[0].'"]';?>,
        datasets: [{
            fillColor: "rgba(172,194,132,0.4)",
            strokeColor: "#ACC26D",
            pointColor: "#fff",
            pointStrokeColor: "#9DB86D",
            <?php echo'data: ['.$nbMaintenance[3].', '.$nbMaintenance[2].', '.$nbMaintenance[1].', '.$nbMaintenance[0].']';?>
        }]
    };
    var months = document.getElementById("chartData").getContext("2d");
    new Chart(months).Line(monthsData);
</script>

</html>