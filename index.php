<html>

<?php require 'header.php'; ?>

<body class="login">
    <div class="container">
        <strong><h1 class="title">WeBreathe</h1></strong>
        <div class="login_form">
            <form action="config/connexion.php" method="POST">
                <legend>Se connecter</legend>
                <?php
                    if(isset($_GET['error_session'])){
                        echo'<p style="color:red;">Aucun identifiant correspondant</p>';
                    }
                    if(isset($_GET['error_password'])){
                        echo'<p style="color:red;">Mauvais mot de passe ou email</p>';
                    }
                    if(isset($_GET['deconnexion'])){
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
                    <a href="#" class="btn btn-primary btn_register">S'enregistrer</a>
                    <input type="submit" class="btn btn-success" value="Se connecter" />
                </div>
            </form>
        </div>
    
    </div>
</body>

<?php require 'footer.php'; ?>

</html>