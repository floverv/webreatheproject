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
                    echo'<li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Gestion des salariés
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="newUser.php">Ajouter un salarié</a>
                        <a class="dropdown-item" href="showUser.php">Modifier un salarié</a>
                    </div>
                </li>';
                }
                if($role_user == "gestionnaire")
                {
                    echo'<li class="nav-item">
                            <a class="nav-link" href="vehicule.php">Gestion des véhicules</a>
                        </li>';
                }
                if($role_user == "technicien")
                {
                    echo'<li class="nav-item">
                    <a class="nav-link" href="#">Opérations de maintenance </span></a>
                </li>';
                }
                ?>
        </ul>
        <?php echo '<a>'.ucfirst($role_user).'</a>';?>
        <a href="config/deconnexion.php" class="btn btn-danger" style="margin-left:15px;">Déconnection</a>
    </div>
</nav>