<?php
  include_once 'header.php';
?>
<div class='appointment-form'>
  <h2>Enter appointment information.</h2>
  <form action='/includes/appointment.inc.php' method='post'>
      <div class='form-element'>
        <label for='doctor'>Select Doctor</label>
        <input type='text' name='doctor' id='reason' required/>
      </div>
      <div class='form-element'>
        <label for='reason'>Enter appointment reason</label>
        <input type='text' name='reason' id='reason' placeholder='Appointment Reason' required/>
      </div>
      <div class='form-element'>
        <label for='adate-time'>Enter appointment date</label>
        <input type='datetime-local' id='adate-time' name='adate-time' value='2022-12-01T00:00' min='2022-11-01T00:00' max='2023-01-01T00:00' required/>
      </div>
      <div class='submit-btn'>
        <button type='submit' name='submit'>Sign Up</button>
      </div>
    </form>
    <?php
      if (isset($_GET["error"])) {
        if ($_GET["error"] === "emptyinput") {
          echo "<p>Fill in all fields.</p>";
        }
      }
    ?>
</div> 
<?php
  include_once 'footer.php';
?>