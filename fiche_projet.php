<?php

require 'connexion.php';

if(!empty($_GET['id'])) 
{
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
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="/CSS/style5.css">
    </head>
    
    <body>
        
        <section id="presentationProjet">
            <div class="container">
                <div class="row">
                    
                    <?php
    
                    $Titre = $Description = $Date = $Temps = $Cadre = $Stack_technique = $Image = "";

                    $db = connect();

                    $statement = $db->prepare("SELECT * FROM projet_portfolio WHERE Id = ?");
                    $statement->execute(array($id));
                    $row = $statement->fetch();

                    echo"<div class='col-lg-12 col-md-12 col-sm-12'>
                        <div class='projet-block'>
                            <h3>".$row['Titre']."</h3>
                            <p>Déscription : ".$row['Description']."</p>
                            <h4>Détails :</h4>
                            <div class='col-lg-12 col-md-12 col-sm-12'>
                                <p class=''>Période : ".$row['Date']."</p>
                                <p class=''>Charge de travail : ".$row['Temps']."</p>
                            </div>
                            <div class='col-lg-12 col-md-12 col-sm-12'>
                                <p class=''>Cadre : ".$row['Cadre']."</p>
                                <p class=''>Stack Technique :".$row['Stack_technique']."</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class='col-lg-12 col-md-6 col-sm-12'>
                        <br> <br>
                        <a class='thumbnail'>";?>
                            <img src="<?php echo 'image/'.$row['Image'];?>" class="" alt="<?php echo $row['Titre'];?>"><?php
                        echo"</a>
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