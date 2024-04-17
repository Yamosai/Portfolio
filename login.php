<?php

require('connexion.php');

$username = $password = "";

session_start();

$co = connect();

if (isset($_POST['submit'])) {
    $username = $_POST['username'];

    /* hash mot de passe sh256*/

    $password = hash('sha256', $_POST['password']);

    /* requête */

    $query = $co->prepare('SELECT * FROM connexion_portfolio WHERE Login=:username and Password=:password');
    $query->bindParam(':username', $username);
    $query->bindParam(':password', $password);
    $query->execute();

    $result = $query->fetchall();

    $rows = $query->rowCount();

    /* verification existance username dans la base de donnée */

    if ($rows == 1) {
        $_SESSION['username'] = $username;
        header("Location: Admin/view.php");
    } else {
        /* message d'erreur */

        $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
        $password = "";
    }
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>Connexion</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>

<body style="background-color:#27534d;">

    <!-- section formulaire login mdp -->

    <section id="login">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="thumbnail">

                <form class="form" method="post" name="login">
                    <h1>Connexion</h1>



                    <!-- username -->
                    <div id="formLogin" class="col-lg-12 col-md-12 col-sm-12">
                        <div class="form-login">
                            <label for="name" class="">Nom d'utilisateur :</label>
                            <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" class="form-control" value="<?php echo $username; ?>">
                        </div>

                        <!-- password -->

                        <div class="form-login">
                            <label for="password" class="">Mot de passe :</label>
                            <input type="password" id="passsword" name="password" placeholder="Mot de passe :" class="form-control" value="<?php echo $password; ?>">
                        </div>
                    </div>

                    <!-- bouton connexion -->

                    <div class="form-actions">
                        <input type="submit" value="Connexion " name="submit" class="">
                        <a id="btnretour" href="index.php" class="btn btn-primary">Retour</a>
                    </div>



                    <!-- message d'erreur -->

                    <?php

                    if (!empty($message)) {

                    ?>

                        <p class="errorMessage"><?php echo $message; ?></p>

                    <?php

                    }

                    ?>

                </form>

            </div>
        </div>

    </section>


</body>

</html>