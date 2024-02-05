<?php

require '../connexion.php';

session_start();
if ($_SESSION['username'] !='Yannis')
{
    header('location:../login.php');
} 
else if(!$_SESSION['username'])
{   
    header('Location:view.php');
}

$id = "";

if(!empty($_GET['id'])) 
{
    $id = checkInput($_GET['id']);
}

/* requete delete */

if(!empty($_POST['id'])) 
{
    $id = checkInput($_POST['id']);

    $db = connect();

    $sql = "DELETE FROM projet_portfolio WHERE Id = ?";
    $statement= $db->prepare($sql);
    $statement->execute(array($id));

    disconnect();

    header("Location: view.php"); 
}



function checkInput($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Suppression d'un projet</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>
    <body>

        <section id="delete">
             <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <h1 class="">Supprimer un projet</h1>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <form class="form" action="delete.php" role="form" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?php echo $id;?>"/>
                            <p class="alert alert-danger">Êtes-vous sur de vouloir supprimer le projet ?</p>
                            <div class="form-actions">
                                <button type="submit" class="btn btn-danger">Oui</button>
                                <a class="btn btn-default" href="view.php">Non</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>