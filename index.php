<?php 
  include_once 'header.php';
?>

<div class='welcome'>
  <h1>Welcome to the Medical Clinic</h1>
  <?php
  if (isset($_SESSION["fname"])) {
      echo '<p>Hello there, '.$_SESSION["fname"].'</p>';
  }
  ?>
</div>
<?php
  include_once 'footer.php';
?>