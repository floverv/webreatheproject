<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="home.php">WeBreathe</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="home.php">Accueil <span class="sr-only">(current)</span></a>
            </li>
            <?php
                if($role_user == "administrateur")
                {
                    echo'<li class="nav-item">
                            <a class="nav-link" href="addEmployee.php">Affecter un salarié</a>
                        </li>';
                    echo'<li class="nav-item">
                        <a class="nav-link" href="listEmployees.php">Modifier un salarié</a>
                    </li>';
                    echo'<li class="nav-item">
                            <a class="nav-link" href="addUser.php">Créer un salarié</a>
                        </li>';
                }
                if($role_user == "gestionnaire")
                {
                    echo'<li class="nav-item">
                            <a class="nav-link" href="addVehicule.php">Gestion des véhicules</a>
                        </li>';
                }
                if($role_user == "technicien")
                {
                    echo'<li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Tableau de bord</span></a>
                    </li>';

                    echo'<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Gestion des opérations de maintenance
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="listMaintenances.php">Liste des opérations de maintenance</a>
                                <a class="dropdown-item" href="addMaintenance.php">Ajouter une opération de maintenance</a>
                                <a class="dropdown-item" href="addNoteMaintenance.php">Noter une opération</a>
                                <a class="dropdown-item" href="addPictureMaintenance.php">Ajouter des photos</a>
                            </div>
                    </li>';

                    echo'<li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Gestion des véhicules
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="nav-link" href="listVehicules.php">Liste des véhicules</span></a>
                                <a class="nav-link" href="addProblemVehicule.php">Signaler un problème véhicule</span></a>
                            </div>
                    </li>';
                }
                ?>
        </ul>
        <?php echo '<a>'.ucfirst($role_user).'</a>';?>
        <a href="config/deconnexion.php" class="btn btn-danger" style="margin-left:15px;">Déconnection</a>
    </div>
</nav>