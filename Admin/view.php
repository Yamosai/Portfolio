<?php

session_start();
if ($_SESSION['username'] != 'Yannis') {
    header('location:../login.php');
} else if (!$_SESSION['username']) {
    header('Location:view.php');
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>View</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../CSS/styleB.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
</head>

<body>
    <nav class="navbar  navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav">
                    <li><a href="../logout.php">Page d'accueil</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="view">
        <h1 class="titreViewPro">Projets</h1>
        <div class="container">
            <div class="row">

                <?php

                require '../connexion.php';

                $db = connect();

                $statement = $db->query("SELECT * FROM projet_portfolio");

                while ($row = $statement->fetch()) {

                ?>

                    <div class="allPro">
                        <div class="thumbnail">


                            <img id="imgViewPro" src="<?php echo '../image/' . $row['Image']; ?>" alt="projets<?php echo $row['Titre']; ?>">
                            <h4 class="DescViewPro">Titre : <?php echo $row['Titre']; ?></h4>
                            <p class="DescViewPro">Description : <?php echo $row['Description']; ?></p>
                            <p class="DescViewPro">Date : <?php echo $row['Date']; ?></p>
                            <p class="DescViewPro">Charge de travaille : <?php echo $row['Temps']; ?></p>
                            <p class="DescViewPro">Cadre : <?php echo $row['Cadre']; ?></p>
                            <p class="DescViewPro">Stack technique : <?php echo $row['Stack_technique']; ?></p>

                            <a class="btnUpdate" href="update.php?id=<?php echo $row['Id'] ?>" role="button">Modifier</a>
                            <a class="btnDelete" href="delete.php?id=<?php echo $row['Id'] ?>" role="button">Supprimer</a>

                        </div>
                    </div>

                <?php

                }

                disconnect()

                ?>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-actions">
                        <a class="btn btn-primary" href="insert.php">Ajouter un projet</a>
                    </div>
                </div>

                <section id="footerBO">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <a class="btnDeco" href="../logout.php">
                            <span class="btn btn-primary btnDeco">Déconnection</span>
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </section>
</body>

</html>