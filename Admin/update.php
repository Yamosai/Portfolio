<?php


require '../connexion.php';

session_start();
if ($_SESSION['username'] != 'Yannis') {
    header('location:../login.php');
} else if (!$_SESSION['username']) {
    header('Location:view.php');
}

$Id = $titreError = $descriptionError = $dateError = $tempsError = $cadreError = $stack_techniqueError = $imageError = $Titre = $Description = $Date = $Temps = $Cadre = $Stack_technique = $Image = "";


if (!empty($_GET['id'])) {

    $Id = checkInput($_GET['id']);
    $db = connect();
    $statement = $db->prepare("SELECT * FROM projet_portfolio WHERE Id =?;");
    $statement->execute(array($Id));
    $row = $statement->fetch();
    $Titre              = $row['Titre'];
    $Description        = $row['Description'];
    $Date               = $row['Date'];
    $Temps              = $row['Temps'];
    $Cadre              = $row['Cadre'];
    $Stack_technique    = $row['Stack_technique'];
    $Image              = $row['Image'];
    $db = disconnect();
}


if (!empty($_POST['Titre'])) {
    $Titre              = checkInput($_POST['Titre']);
    $Description        = checkInput($_POST['Description']);
    $Date               = checkInput($_POST['Date']);
    $Temps              = checkInput($_POST['Temps']);
    $Cadre              = checkInput($_POST['Cadre']);
    $Stack_technique    = checkInput($_POST['Stack_technique']);
    $Image              = checkInput($_FILES["Image"]["name"]);
    $imagePath          = '../image/' . basename($Image);
    $imageExtension     = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess          = true;
    $isUploadSuccess    = true;


    if (empty($Titre)) {
        $titreError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if (empty($Description)) {
        $descriptionError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if (empty($Date)) {
        $dateError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if (empty($Temps)) {
        $tempsError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if (empty($Cadre)) {
        $cadreError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if (empty($Stack_technique)) {
        $stack_techniqueError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if (empty($Image)) {
        $isImageUpdated = false;
    } else {
        $isImageUpdated = true;

        if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif") {
            $imageError = "Les fichiers autorisés sont: .jpg, .jpeg, .png, .gif";
            $isUploadSuccess = false;
        }

        // if(file_exists($imagePath)) 
        // {
        //     $imageError = "Le fichier existe deja";
        //     $isUploadSuccess = false;
        // }

        if ($_FILES["Image"]["size"] > 600000) {
            $imageError = "Le fichier ne doit pas dépasser les 600KB";
            $isUploadSuccess = false;
        }

        if ($isUploadSuccess) {
            if (!move_uploaded_file($_FILES["Image"]["tmp_name"], $Image)) {
                $imageError = "Il y a eu une erreur lors de l'upload";
                $isUploadSuccess = false;
            }
        }
    }

    if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) {
        $db = connect();

        if ($isImageUpdated) {
            $statement = $db->prepare("UPDATE projet_portfolio set Titre =?, Description =?, Date =?, Temps =?, Cadre =?, Stack_technique =?, Image =? WHERE Id =?");
            $statement->execute(array($Titre, $Description, $Date, $Temps, $Cadre, $Stack_technique, $Image, $Id));
        } else {
            $statement = $db->prepare("UPDATE projet_portfolio set Titre =?, Description =?, Date =?, Temps =?, Cadre =?, Stack_technique =? WHERE Id =?");
            $statement->execute(array($Titre, $Description, $Date, $Temps, $Cadre, $Stack_technique, $Id));
        }

        $db = disconnect();
        header("Location: view.php");
    } else if ($isImageUpdated && !$isUploadSuccess) {
        $db = connect();
        $statement = $db->prepare("SELECT Image FROM projet_portfolio WHERE Id =?;");
        $statement->execute(array($Id));
        $row = $statement->fetch();
        $Image = $row['Image'];
        $db = disconnect();
    }
}



function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Update</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/styleB.css">
</head>

<body>

    <section id="update">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h1 class="">Modifier un projet</h1>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12">

                    <form class="form" role="form" action="<?php echo 'update.php?id=' . $Id; ?>" method="post" enctype="multipart/form-data">

                        <label for="titre" class="">Titre :</label>
                        <input type="text" class="form-control" id="Titre" class="form-control" name="Titre" placeholder="Titre du projet :" value="<?php echo $Titre; ?>">
                        <span class="help-inline"><?php echo $titreError; ?></span>

                        <div class="form-group">
                            <label for="Description" class="">Déscription :</label>
                            <input type="text" class="form-control" id="Description" class="form-control" name="Description" placeholder="Description du projet :" value="<?php echo $Description; ?>">
                            <span class="help-inline"><?php echo $descriptionError; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="Date" class="">Date :</label>
                            <input type="text" class="form-control" id="Date" class="form-control" name="Date" placeholder="Date du projet :" value="<?php echo $Date; ?>">
                            <span class="help-inline"><?php echo $dateError; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="Temps" class="">Temps :</label>
                            <input type="text" class="form-control" id="Temps" class="form-control" name="Temps" placeholder="Temps de réalisation du projet :" value="<?php echo $Temps; ?>">
                            <span class="help-inline"><?php echo $tempsError; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="Cadre" class="">Cadre :</label>
                            <input type="text" class="form-control" id="Cadre" class="form-control" name="Cadre" placeholder="Cadre du projet :" value="<?php echo $Cadre; ?>">
                            <span class="help-inline"><?php echo $cadreError; ?></span>
                        </div>

                        <div class="form-group">
                            <label for="stack_tecnhique" class="">Stack tecnhique :</label>
                            <input type="text" class="form-control" id="Stack_technique" class="form-control" name="Stack_technique" placeholder="Stack technique du projet :" value="<?php echo $Stack_technique; ?>">
                            <span class="help-inline"><?php echo $stack_techniqueError; ?></span>
                        </div>

                        <div class="form-group">
                            <label class="">Image:</label>
                            <p class=""><?php echo $Image; ?></p>
                            <label for="Image" class="">Sélectionner une image:</label>
                            <input type="file" id="Image" name="Image" class="">
                            <span class="help-inline"><?php echo $imageError; ?></span>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-actions">
                                <button type="submit" class="">Modifier</button>
                                <a id="btnretour" href="view.php" class="btn btn-primary">Retour</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>

</body>

</html>