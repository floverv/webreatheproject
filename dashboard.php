<html>
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
            $month = date("m");
            $startMonth = date('Y').'-'.$month.'-01';
            $endMonth = date('Y').'-'.$month.'-30';

            $sql="SELECT count(id) FROM maintenance WHERE dateFin BETWEEN '".$startMonth."' AND '".$endMonth."' ";
            $requete = $db->query($sql);
            $result = $requete->fetch();

            $nbMaintenance[] = $result['count(id)'];
            $month_graph[] = getMonth($month);

            for($i = 1;$i<4;$i++){
                $monthless = date("m", strtotime("$today -".$i." month"));
                $startMonth = date('Y').'-'.$monthless.'-01';
                $endMonth = date('Y').'-'.$monthless.'-30';

                $sql="SELECT count(id) FROM maintenance WHERE dateFin BETWEEN '".$startMonth."' AND '".$endMonth."' ";
                $requete = $db->query($sql);
                $result = $requete->fetch();

                array_push($nbMaintenance,$result['count(id)']);
                array_push($month_graph,getMonth($monthless));
            }
            

            $sql="SELECT count(id) FROM maintenance WHERE etatAvancement='termine' ";
            $requete = $db->query($sql);
            $result = $requete->fetch();
            $nbTotalMaintenance = $result['count(id)'];


        ?>
        <div class="card-deck margintop25">
            <!-- Card -->
            <div class="card mb-4">

                <!--Card image-->
                <div class="view overlay margintop25">
                    <center><canvas id="chartData" width="auto"></canvas></center>
                </div>

                <!--Card content-->
                <div class="card-body">

                    <!--Title-->
                    <h4 class="card-title">Nombres totales d'opérations effectuées par mois</h4>
                    <!--Text-->
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste at adipisci placeat, itaque quos quaerat voluptatum magni recusandae velit odit perspiciatis incidunt necessitatibus, dolores nemo, distinctio perferendis saepe pariatur assumenda?</p>
                    <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->

                </div>

            </div>

            <div class="card mb-4">

                <!--Card image-->


                <!--Card content-->
                <div class="card-body">

                    <!--Title-->
                    <h4 class="card-title display-4"> Opération de maintenance terminé</h4>
                    <!--Text-->
                    <p class="card-text display-2"><?php echo $nbTotalMaintenance;?></p>

                </div>

            </div>
            <!-- Card -->
        </div>

        <div class="card margintop25">
            <div class="card-header">
                <?php 
                $result = $db->query('SELECT * FROM maintenance WHERE etatAvancement="en cours"'); 
                $count = $result->rowCount();
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
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card margintop25">
            <div class="card-header">
                <?php 
                $result = $db->query('SELECT * FROM maintenance WHERE etatAvancement="en attente"'); 
                $count = $result->rowCount();
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
                            echo '<tr>
                                <td class="center">' . $row['id'] . '</td>
                                <td class="center">' . $row['dateDebut'] . '</td>
                                <td class="center">' . $row['dateFin'] . '</td>
                                <td class="center">' . $row['sujet'] . '</td>
                                <td class="center">' . $row['description'] . '</td>
                                <td class="center">' . $row['etatAvancement'] . '</td>
                                <td class="center"><a href="showMaintenance.php?id=' . $row['id'] . '" class="btn btn-primary">Voir plus</a></td>
                            </tr>';
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