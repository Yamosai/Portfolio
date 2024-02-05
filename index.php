<?php
require ('connexion.php');

// declaration des variable

$nom = $prenom = $mail = $objet = $message = "";
$nError = $pError = $mError = $oError = $messError = "";
$isSuccess = false;

//control des champs 

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    $nom = verifyInput($_POST["nom"]);
    $objet = verifyInput($_POST["objet"]);
    $prenom = verifyInput($_POST["prenom"]);
    $mail = verifyInput($_POST["mail"]);
    $message = verifyInput($_POST["message"]);
    $isSuccess = true;
    
    if(empty($nom))
    {
        $nError = "Saisissez un nom correct.";
        $isSuccess = false;
    }

    if(empty($objet))
    {
        $oError = "Saisissez un sujet correct.";
        $isSuccess = false;
    }

    if(empty($prenom))
    {
        $pError = "Saisissez un prénom correct .";
        $isSuccess = false;
    }

    if(!isEmail($mail))
    {
        $mError = "Saisissez un e-mail correct .";
        $isSuccess = false;
    }

    if(empty($message))
    {
        $messError = "Saisissez un message correct .";
        $isSuccess = false;
    }

    if($isSuccess) 
    {
        $db = connect();
        $statement = $db->prepare("INSERT INTO personne_mail (nom,prenom,mail) values(?, ?, ?)");
        $statement->execute(array($nom,$prenom,$mail));
        $statement = $db->prepare("INSERT INTO mail_portfolio (sujet,message) values(?, ?)");
        $statement->execute(array($objet,$message));
        $db = disconnect();
        header("Location: index.php");
    }    
}
//fonction de securité 
function verifyInput($var)
{
    $var = trim($var);
    $var = stripslashes($var);
    $var = htmlspecialchars($var);
    return $var;
}
//fontion email
function isEmail ($var)
{
    return filter_var($var, FILTER_VALIDATE_EMAIL);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Portfolio Moncet Yannis</title>
            <meta charset="utf-8"/>
            <meta name="viewport" content="width=device-width , invalid=scale=1">            
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <!-- Latest compiled and minified CSS -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
            <!-- Latest compiled and minified JavaScript -->
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
            <link href='http://fonts.googleapis.com/css?family=Lato&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="CSS/style.css">
            <script src="js/script.js"></script>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Arvo:wght@700&family=Oswald:wght@200&family=Quicksand:wght@600&display=swap" rel="stylesheet">
    </head>
    
    <body data-spy="scroll" data-target="#myNavbar">
                <!--navbar-->
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
                            <li><a href="#about">Moi</a></li>
                            <li><a href="#projets">Réalisations PERSO/PRO</a></li>
                            <li><a href="#skills">Compétences</a></li>
                            <li><a href="#education">Éducation</a></li>
                            <li><a href="#formulaire">Contact</a></li>
                            <li><a href=login.php>Connexion</a></li>
                         </ul>
                    </div> 
            </div>
        </nav>

        <!--section moi-->
        <section id="about" classe="container-fluide">
            <div class="col-xs-8 col col-md-4 profile-picture">
                <img src="image/moi1.jpg" alt="image de profil" class="img-circle">
            </div>
                <div class="heading">
                    <h2> Moncet Yannis</h2>
                    <h3>Développeur junior </h3>
                    <a href="docs/CV Yannis MONCET.pdf" target="_blank" class="button1">téléchargez CV</a>
                </div>
        </section>
        
        <!--section projet-->
        <section id="projets">
            <div class="container">

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="heading">
                            <h2  style="color: #27534d; text-transform: uppercase;"> Réalisations </h2>
                        </div>
                    </div>
                </div>

                <?php 

                $db = connect();

                $statement = $db -> query("SELECT * FROM projet_portfolio");
                while ($projet = $statement -> fetch()) 
                {
                    echo "<div class='block_pro'>
                        <a class='thumbnail' href='#' data-toggle='modal' data-target='#modal".$projet['Id'] ."'>
                            <img class='img_pro' alt='iamge projet ".$projet['Titre']."' src='image/".$projet['Image']." 'class=''>
                        </a>
                        <div class='modal fade' id='modal".$projet['Id'] ."'> 
                            <div class='modal-dialog'>
                                <div class='modal-content'>
                                    <div class='modal-header'>
                                        <button type='button' class='close' data-dismiss='modal'>x</button>
                                        <h5 class='modal-title'> Titre du Projet : ".$projet['Titre']."</h5>
                                    </div>
                                    <div class='modal-body'>
                                        <p>Voulez vous en savoir plus ?</p>
                                    </div>
                                    <div class='modal-footer'>
                                        <a type='button' href='fiche_projet.php?id=".$projet['Id'] .".' class=''>Continuer</a>
                                        <button type='button' class='' data-dismiss='modal'>Fermer</button>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>";
                }
                disconnect();
                ?>
            </div>
        </section>

        <!-- section competence-->

        <section id="skills">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                <h5>HTML </h5>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                <h5>CSS/SCSS </h5>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                <h5>SQL </h5>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                <h5>C# </h5>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                <h5>PrestasShop</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                <h5>JQUERY </h5>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                <h5>BOOTSTRAP </h5>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                <h5>PHP </h5>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                <h5>Symfony </h5>
                            </div>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width:100%">
                                <h5>Laravel </h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--section education-->

        <section id="education" >
            <div class="container">
                <div class="red-divider"></div>
                <div class="heading">
                <h2 id="education" style="color: #27534d; text-transform: uppercase;"> Éducation </h2>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="education-block">
                            <h5>2017 - 2020</h5>
                            <span class="glyphicon glyphicon-education"></span>
                            <h3>Lycée professionnel Roberval–Breuil-le-vert</h3>
                            <h4>Baccalauréat Professionnel Systèmes Numériques</h4>
                            <a href="https://roberval-breuil-le-vert.ac-amiens.fr/" target="_blank">lien vers le site Web</a>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="education-block">
                            <h5>2021 - Actuellement</h5>
                            <span class="glyphicon glyphicon-education"></span>
                            <h3>Lycée privé Saint Vincent - Senlis</h3>
                            <p><h4>Bts Sio <br> Option Slam </h4></p>
                            <a href="https://www.lycee-stvincent.fr/"target="_blank">lien vers le site Web</a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </section>

        <!--contact-->

        <section id="formulaire">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="overlay4">
                            <div class="formulaire">
                                <div class="contact">
                                    <h2>Contact</h2>
                                        <div class="form-group">
                                            <form id="contact-form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" role="form">
                                                <div class="form-group-nom">
                                                    <label for="nom" class="labelF"></label>
                                                    <input type="text" id="nom" name="nom" placeholder="Votre Nom" value="<?php echo $nom; ?>">
                                                    <p style="color:red; font-style:italic;"><?php echo $nError; ?></p>
                                                </div>
                                                <div class="form-group-prenom">
                                                    <label for="prenom" class="labelF"></label>
                                                    <input type="text" id="prenom" name="prenom" placeholder="Votre Prenom" value="<?php echo $prenom; ?>">
                                                    <p style="color:red; font-style:italic;"><?php echo $pError; ?></p>
                                                </div>
                                                <div class="form-group-mail">
                                                    <label for="mail" class="labelF"></label>
                                                    <input type="text" id="mail" name="mail" placeholder="Votre email" value="<?php echo $mail; ?>">
                                                    <p style="color:red; font-style:italic;"><?php echo $mError; ?></p>
                                                </div>
                                                <div class="form-group-objet">
                                                    <label for="objet" class="labelF"></label>
                                                    <input type="text" id="objet" name="objet" placeholder="Objet" value="<?php echo $objet; ?>">
                                                    <p style="color:red; font-style:italic;"><?php echo $oError; ?></p>
                                                </div>
                                                <div class="form-group-message">
                                                    <label for="message" class="labelFormulaire"></label>
                                                    <textarea id="message" name="message" placeholder="Votre Message" rows="4" value="<?php echo $message; ?>"></textarea>
                                                    <p style="color:red; font-style:italic;"><?php echo $messError; ?></p>
                                                </div>
                                                <button type="submit" class="btn btn-success" value="contact">Envoyer</boutton>
                                            </form>
                                        </div>
                                </div>
                                <div class="mail-to">
                                    <a class="btn-mailto" href="mailto:Moncet.yannis@gmail.com" class="mailtoForm">Contactez moi</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- section footer-->

        <footer class="text-center">
            <div class="col-lg-12  col-md-12 col-sm-12">
                <a href="#about"> 
                    <h5>Portfolio Moncet Yannis</h5>
                    <span class="glyphicon glyphicon-chevron-up"></span>
                </a>
            </div>
        </footer>

    </body>
</html>