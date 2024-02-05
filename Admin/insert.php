

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

$titreError = $descriptionError = $dateError = $tempsError = $cadreError = $stack_techniqueError = $imageError = $titre = $Description = $Date = $Temps = $Cadre = $Stack_technique = $Image = "";

if(!empty($_POST)) 
{
    $titre              = checkInput($_POST['Titre']);
    $Description        = checkInput($_POST['Description']);
    $Date               = checkInput($_POST['Date']);
    $Temps              = checkInput($_POST['Temps']);
    $Cadre              = checkInput($_POST['Cadre']);
    $Stack_technique    = checkInput($_POST['Stack_technique']);
    $Image              = checkInput($_FILES["Image"]["name"]);
    $imagePath          = '../image/'. basename($Image);
    $imageExtension     = pathinfo($imagePath,PATHINFO_EXTENSION);
    $isSuccess          = true;
    $isUploadSuccess    = false;

    if(empty($titre)) 
    {
        $titreError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if(empty($Description)) 
    {
        $descriptionError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    } 

    if(empty($Date)) 
    {
        $dateError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if(empty($Temps)) 
    {
        $tempsError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if(empty($Cadre)) 
    {
        $cadreError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }

    if(empty($Stack_technique)) 
    {
        $stack_techniqueError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
        
    if(empty($Image)) 
    {
        $imageError = 'Ce champ ne peut pas être vide';
        $isSuccess = false;
    }
    else
    {
        $isUploadSuccess = true;

        if($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg" && $imageExtension != "gif" && $imageExtension != "jpg")
        {
            $imageError = "Les fichiers autorisés sont : .jpg, .jpeg, .png, .gif";
            $isUploadSuccess = false;
        }

        //if(file_exists($imagePath))
        //{
        //    $imageError = "Le fichier existe déjà";
        //    $isUploadSuccess = false;
       // }

        if($_FILES["Image"]["size"] > 1000000) 
        {
            $imageError = "Le fichier ne doit pas dépasser les 1000KB";
            $isUploadSuccess = false;
        }

        if($isUploadSuccess)
        {
            if(!move_uploaded_file($_FILES["Image"]["tmp_name"], $Image))
            {
                $imageError = "Il y a eu une erreur lors de l'upload";
                $isUploadSuccess = false;
            } 
        } 
    }
           
        
    if($isSuccess && $isUploadSuccess) 
    {
        $db = connect();

        $statement = $db->prepare("INSERT INTO projet_portfolio (Titre, Description, Date, Temps, Cadre, Stack_technique, Image) values(?, ?, ?, ?, ?, ?, ?)");
        $statement->execute(array($titre, $Description, $Date, $Temps, $Cadre, $Stack_technique, $Image));

        $db = disconnect();

        header('Location:view.php');
    }
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
        <title>Ajout de projet</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    
    <body>
       
        <div class="container admin">
            <div class="row">
                <h1><strong>Ajouter un projet</strong></h1>
                <br>
                <form class="form" action="insert.php" role="form" method="post" enctype="multipart/form-data">
                    <br>
                    <div>
                        <label class="form-label" for="Titre">Titre:</label>
                        <input type="text" class="form-control" id="Titre" name="Titre" placeholder="Titre" value="<?php echo $titre;?>">
                        <span class="help-inline"><?php echo $titreError;?></span>
                    </div>
                    <br>
                    <div>
                        <label class="form-label" for="Description">Description:</label>
                        <input type="text" class="form-control" id="Description" name="Description" placeholder="Description" value="<?php echo $Description;?>">
                        <span class="help-inline"><?php echo $descriptionError;?></span>
                    </div>
                    <br>
                    <div>
                        <label class="form-label" for="Date">Date:</label>
                        <input type="text" class="form-control" id="Date" name="Date" placeholder="Date" value="<?php echo $Date;?>">
                        <span class="help-inline"><?php echo $dateError;?></span>
                    </div>
                    <br>
                    <div>
                        <label class="form-label" for="Temps">Temps:</label>
                        <input type="text" class="form-control" id="Temps" name="Temps" placeholder="Temps" value="<?php echo $Temps;?>">
                        <span class="help-inline"><?php echo $tempsError;?></span>
                    </div>
                    <br>
                     <div>
                        <label class="form-label" for="Cadre">ajouter un cadre:</label>
                        <input type="text" id="Cadre" name="Cadre" class="form-control" placeholder="Cadre" value="<?php echo $Cadre;?>">
                        <span class="help-inline"><?php echo $cadreError;?></span>
                    </div>
                     <div>
                        <label class="form-label" for="Stack_technique">Technologie utiliser:</label>
                        <input type="text" id="Stack_technique" name="Stack_technique" class="form-control" placeholder="Stack technique" value="<?php echo $Stack_technique;?>"> 
                        <span class="help-inline"><?php echo $stack_techniqueError;?></span>
                    </div>
                     <div>
                         <br>
                        <label class="form-label" for="Image">Sélectionner une image:</label>
                        <input type="file" id="Image" name="Image" value="<?php echo $Image;?>"> 
                        <span class="help-inline"><?php echo $imageError;?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="bi-pencil"></span> Ajouter</button>
                        <a class="btn btn-primary" href="view.php"><span class="bi-arrow-left"></span> Retour</a>
                   </div>
                </form>
            </div>
        </div>   
    </body>
</html>