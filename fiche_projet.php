<?php

require 'connexion.php';

if (!empty($_GET['id'])) {
    $id = verifyInput($_GET['id']);
}

function verifyInput($var)
{
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Fiche projet</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="CSS/styleB.css">
</head>

<body>
    <nav class="navbar navbar-default navbar-fixed-top">
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
                    <li><a href="index.php">Page d'accueil</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="presentationProjet">
        <div class="container">
            <div class="row">

                <?php

                $Titre = $Description = $Date = $Temps = $Cadre = $Stack_technique = $Image = "";

                $db = connect();

                $statement = $db->prepare("SELECT * FROM projet_portfolio WHERE Id = ?");
                $statement->execute(array($id));
                $row = $statement->fetch();

                echo "<div class='col-lg-12 col-md-12 col-sm-12'>
                            <div class='projet-block'>
                                <h3 class='titreFiche'>" . $row['Titre'] . "</h3>
                                <h4 class='detailFiche'>Détails :</h4>
                                <div class='col-lg-12 col-md-12 col-sm-12'>
                                    <p class='descriptionFiche'>Description : " . $row['Description'] . "</p>
                                    <p class='periodeFiche'>Période : " . $row['Date'] . "</p>
                                    <p class='chargeFiche'>Charge de travail : " . $row['Temps'] . "</p>
                                </div>
                                <div class='col-lg-12 col-md-12 col-sm-12'>
                                    <p class='cadreFiche'>Cadre : " . $row['Cadre'] . "</p>
                                    <p class='stackFiche'>Stack Technique : " . $row['Stack_technique'] . "</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class='col-lg-12 col-md-6 col-sm-12'>
                            <br> <br>
                            <a class='thumbnail'>"; ?>
                <img class="imgFiche" src="<?php echo 'image/' . $row['Image']; ?>" class="" alt="<?php echo $row['Titre']; ?>"><?php
                                                                                                                                echo "</a>
                        </div>";


        disconnect();

        ?>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-6">
                    <div class="heading">
                        <a id="btnretour" href="index.php" class="btn btn-primary">Retour</a>
                    </div>
                </div>
            </div>

        </div>
    </section>

</body>

</html>