<?php
require 'controllers/functions.php';


$accidents = getAccidents($_GET['search']);

$labelsFaulty = [];
$labelsPlace = [];



foreach (group_by("faulty", $accidents) as $key => $faulties) {

  foreach($faulties as $faulty) {
    $lFaulty[$key] += (int)$faulty['nb_victime'];
  }
}  

arsort($lFaulty);

foreach($lFaulty as $key => $faulty) {
  $labelsFaulty[$key] = $faulty;
}


foreach (group_by("place", $accidents) as $key => $places) {

  foreach($places as $place) {
    $lPlace[$key] += (int)$place['nb_victime'];
  }
}  

arsort($lPlace);

foreach($lPlace as $key => $place) {
  $labelsPlace[$key] = $place;
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
    <style>
        .row {
          padding-bottom: 0.5em;
        }
    </style>
    
  </head>
  <body>
    <div class="container-fluid">
      <h1>TRAFFIC <?php echo $_GET['search'] ? $_GET['search'] : date('Y'); ?></h1>
      <div class="row">
        <a class="btn btn-danger" href="create.php" role="button">Create Accident</a>
      </div>

      <div class="row justify-content-end p-2">
      <!--Current search-->
      <form class="form-inline">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Rechercher une année" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
      </form>
      </div>
      <div class="row">
        <div class="col-8 pr-0">
          <div class="card">
            <div class="card-body" style="position:relative">
              <canvas id="graphVictim"></canvas>
            </div>
          </div>
        </div>
      
        <div class="col-4 my-auto">
          <div class="card">
            <div class="card-body">
              <canvas id="graphPlace"></canvas>
              <hr>
              <canvas id="graphFaulty"></canvas>
            </div>
          </div>
        </div>
          
      </div>

      <div class="row">
        <div id="reactTable"></div>
        <table class="table">
          <thead>
            <tr>
            <th>
            Date
              </th>
              <th>
                Lieu
              </th>
              <th>
                Mise en cause
              </th>
              <th>
                Nbre de Victime
              </th>
              <th>
                
              </th>
            </tr>
          </thead>
          <tbody>
          <?php foreach($accidents as $accident): ?>
            <tr>
            <td>
              <?php echo $accident['date']; ?>
              </td>
              <td>
              <?php echo $accident['place']; ?>
              </td>
              <td>
              <?php echo $accident['faulty']; ?>
              </td>
              <td>
              <?php echo $accident['nb_victime']; ?>
              </td>
              <td>
              
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        
        </table>
      </div>
    </div>
    

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    
      var ctx = document.getElementById('graphVictim');
      var graphVictim = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
              datasets: [{
                  label: 'VICTIMS',
                  data: <?php echo json_encode(array_values(get_year_data($accidents, $_GET['search'] ? $_GET['search'] : NULL ))) ?>,
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)',
                      'rgba(75, 192, 192, 0.2)',
                      'rgba(153, 102, 255, 0.2)',
                      'rgba(255, 159, 64, 0.2)'
                  ],
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)',
                      'rgba(75, 192, 192, 1)',
                      'rgba(153, 102, 255, 1)',
                      'rgba(255, 159, 64, 1)'
                  ],
                  borderWidth: 1
              }]
          },
          options: {
            //maintainAspectRatio: false,
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });

      var ctx = document.getElementById('graphPlace');
      var graphPlace = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: <?php echo json_encode(array_keys(array_slice($labelsPlace, 0, 3))) ?>,
              datasets: [{
                  label: 'VICTIMS',
                  data: <?php echo json_encode(array_values(array_slice($labelsPlace, 0, 3))) ?>,
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)'
                  ],
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)'
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });

      var ctx = document.getElementById('graphFaulty');
      var graphPlace = new Chart(ctx, {
          type: 'bar',
          data: {
              labels: <?php echo json_encode(array_keys(array_slice($labelsFaulty, 0, 3))) ?>,
              datasets: [{
                  label: 'VICTIMS',
                  
                  data: <?php echo json_encode(array_values(array_slice($labelsFaulty, 0, 3))) ?>,
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(54, 162, 235, 0.2)',
                      'rgba(255, 206, 86, 0.2)'
                  ],
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(54, 162, 235, 1)',
                      'rgba(255, 206, 86, 1)'
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              scales: {
                  y: {
                      beginAtZero: true
                  }
              }
          }
      });
    </script>
    
  </body>
</html>