<html>
<?php
require 'config/session.php';
require 'header.php';
/* 
        Variables:
            $id_user : id de l'utilisateur connecté,
            $role_user : role de l'utilisateur connecté
        */
?>

<body style="background-color: #5041602b;">
    <?php
    require_once 'navbar.php';
    ?>

    <!-- Jumbotron -->
    <div class="card card-image" style="background-image: url(https://www.heet.org.uk/wp-content/uploads/2016/06/gradient-background-26046-26731-hd-wallpapers.jpg.png);background-repeat: round;">
        <div class="text-white text-center rgba-stylish-strong py-5 px-4">
            <div class="py-5">
                <!-- Content -->
                <h5 class="display-3">Centre d'opérations de maintenance automobile</h5>
                <h2 class="card-title h2 my-4 py-2">Espace pour les <?php echo $role_user;?>s</h2>
            </div>
        </div>
    </div>
    <div class="container">
    <div class="container margintop25">
        <!-- Card deck -->
        <div class="card-deck">

            <!-- Card -->
            <div class="card mb-4">

                <!--Card image-->
                <div class="view overlay">
                    <img class="card-img-top" src="Common/Private/mecanic.jpg"/>                    
                <a href="#!">
                        <div class="mask rgba-white-slight"></div>
                    </a>
                </div>

                <!--Card content-->
                <div class="card-body">

                    <!--Title-->
                    <h4 class="card-title">Changement de pièces</h4>
                    <!--Text-->
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iste at adipisci placeat, itaque quos quaerat voluptatum magni recusandae velit odit perspiciatis incidunt necessitatibus, dolores nemo, distinctio perferendis saepe pariatur assumenda?</p>
                    <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                    <button type="button" class="btn btn-light-blue btn-md">Read more</button>

                </div>

            </div>
            <!-- Card -->

            <!-- Card -->
            <div class="card mb-4">

                <!--Card image-->
                <div class="view overlay">
                    <img class="card-img-top" src="Common/Private/maintenance.jpg"/>
                </div>

                <!--Card content-->
                <div class="card-body">

                    <!--Title-->
                    <h4 class="card-title">Maintenance efficace</h4>
                    <!--Text-->
                    <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit dolores vero architecto voluptas! Dolorum culpa quidem excepturi exercitationem ad sed quaerat fuga quasi dolor dolore ut, ipsum repudiandae omnis impedit!</p>
                    <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                    <button type="button" class="btn btn-light-blue btn-md">Read more</button>

                </div>

            </div>
            <!-- Card -->

            <!-- Card -->
            <div class="card mb-4">

                <!--Card image-->
                <div class="view overlay">
                    <img class="card-img-top" src="Common/Private/car.jpg" height="95%" alt="Card image cap">
                </div>

                <!--Card content-->
                <div class="card-body" style="margin-top:-15px;">

                    <!--Title-->
                    <h4 class="card-title">Accessible pour toutes les voiture</h4>
                    <!--Text-->
                    <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Veritatis aliquid enim unde inventore, ab, corrupti dignissimos deleniti voluptatem animi debitis amet facilis praesentium provident saepe aperiam dolor quo dolores optio</p>
                    <!-- Provides extra visual weight and identifies the primary action in a set of buttons -->
                    <button type="button" class="btn btn-light-blue btn-md">Read more</button>

                </div>

            </div>
            <!-- Card -->

        </div>
    </div>
    </div>
    <!-- Jumbotron -->
</body>
<?php require 'footer.php'; ?>

</html>