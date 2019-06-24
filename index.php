<html>

<head>
        <!DOCTYPE html>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>WeBreathe - connexion</title>
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">

        <link rel="stylesheet" href="asset/main.css">
        
        <script src="vendor/js/Chart.js"></script>
</head>

<body class="login">
    <div class="container">
        <strong><h1 class="title">WeBreathe</h1></strong>
        <div class="login_form">
            <form action="config/connexion.php" method="POST">
                <legend>Se connecter</legend>
                <small class="form-text text-muted">Pour obtenir un compte veuillez contacter l'administrateur</small>
                <?php
                    if(isset($_GET['error_session'])){
                        // ERREUR DE SESSION
                        echo'<p style="color:red;">Aucun identifiant correspondant</p>';
                    }
                    if(isset($_GET['error_password'])){
                        // ERREUR DE MOT DE PASSE
                        echo'<p style="color:red;">Mauvais mot de passe ou email</p>';
                    }
                    if(isset($_GET['deconnexion'])){
                        // MESSAGE DE DECONNEXION
                        echo'<p style="color:green;">Vous avez bien été deconnecté</p>';
                    }
                ?>
                <hr>
                <div class="form-group">
                    <label for="email">E-mail </label>
                    <input class="form-control" name="email" type="email" placeholder="Email" required/>      
                </div>
                
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input class="form-control" name="password" type="password" placeholder="Mot de passe" required/>
                </div>
                <div class="form-group text-center gp_btn">
                    <input type="submit" class="btn btn-success" value="Se connecter" />
                </div>
            </form>
        </div>
    
    </div>
</body>

<?php require 'footer.php'; ?>

</html>