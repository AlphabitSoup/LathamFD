<?php
if (empty($_SESSION['loggedin'])) {
  header('Location: ./login.php');
}
?>

<!DOCTYPE html>
<html>
<?php require('header.php'); ?>
<body>
  <h1>Latham Fire Trucks:</h1>

    <div class="col-md-2">
            <div class="box">
                <h2 class="text-center">Water</h2>
            </div>
    </div>
  <div class="col-md-2">
            <div class="box">
                <h2 class="text-center">Rescue</h2>
            </div>
    </div>
      <div class="col-md-2">
            <div class="box">
                <h2 class="text-center">Brush</h2>
            </div>
    </div>
      <div class="col-md-2">
            <div class="box">
                <h2 class="text-center">Ladder</h2>
            </div>
    </div>
    <div class="col-md-2">
            <div class="box">
                <h2 class="text-center">Utility</h2>
            </div>
    </div>
    <div class="col-md-2">
            <div class="box">
                <h2 class="text-center">Tanker</h2>
            </div>
    </div>
    
  </body>
  <?php require('footer.php'); ?>
</html>

