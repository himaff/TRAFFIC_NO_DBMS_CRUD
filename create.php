<?php

require './controllers/functions.php';

$errors = 0;
$accident = [
    "id" => null,
    "date" => "",
    "place" => "",
    "nb_victime" => "",
    "faulty" => ""
];
$accidents = getAccidents();

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $accident['date'] = $_POST['date'] ? $_POST['date'] : $errors = 1;
    $accident['place'] = $_POST['place'] ? $_POST['place'] : $errors = 1;
    $accident['nb_victime'] = $_POST['nb_victime'] ? $_POST['nb_victime'] : $errors = 1;
    $accident['faulty'] = $_POST['faulty'] ? $_POST['faulty'] : $errors = 1;

    
    if (!$errors) {
        
        createAccident($accident);
        header('Location: ./index.php' , true, 301);

    }

}



?>
<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/65485006a0.js" crossorigin="anonymous"></script>
    <title>TRAFFIC</title>
  </head>
  <body>
    <div class="container">
        <nav class="nav navbar"> <a href="index.php"><button type="button" class="btn btn-light"><i class="fas fa-angle-left"></i></button>TRAFFIC</a></nav>
        <form method="POST" action="" enctype="multipart/form-data">
            <h1>ENREGISTRER UN ACCIDENT</h1>
            <div class="form-group row">
                <label for="nb_victime" class="col-sm-2 col-form-label">NOMBRE DE VICTIME</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="nb_victime" name="nb_victime" value="<?php echo $accident['nb_victime'] ?>">
                </div>
                
            </div>

            <div class="form-group row">
                <label for="place" class="col-sm-2 col-form-label">LIEU</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="place" name="place" value="<?php echo $accident['place'] ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="date" class="col-sm-2 col-form-label">DATE</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="date" name="date" value="<?php echo $accident['date'] ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="faulty" class="col-sm-2 col-form-label">MISE EN CAUSE</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="faulty" name="faulty" value="<?php echo $accident['faulty'] ?>">
                </div>
            </div>

            <div class="form-group row ">
            <div class="col"></div>
                <button type="submit" class="btn btn-danger btn-block col-sm-10 ">ENREGISTRER</button>
            </div>
        </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
  </body>
</html>