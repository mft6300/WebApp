<?php
  session_start();
?>
<style>
<?php include 'style.css';?>
</style>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Medical Clinic</title>
</head>
<body>
  <div>
    <header>
      <nav>
       <div>
				 <ul class='header'>
					 <p class='cleft'>Cell: 123-456-7891</p>
					 <p class='cright'>Email address</p>
           <p class='container'>
           <form action="">
             <input type="text" placeholder="search anything" name="q">
             <button type="submit"><img src="https://www.freepnglogos.com/uploads/medicine-logo-png-19.png" alt="company logo"></button>
             
           </form>
         </p>
           
           
				 </ul>
          <ul class='navigation'>
						<img src="https://www.freepnglogos.com/uploads/medicine-logo-png-19.png" alt="company logo">
           <li><a href='index.php'>Home</a></li>
           <?php
            if (isset($_SESSION["userID"])) {
              echo "<li><a href='make-appointment.php'>Make an Appointment</a></li>";
              echo "<li><a href='includes/logout.inc.php'>Log Out</a></li>";
            }
            else {
              echo "<li><a href='signup.php'>Sign Up</a></li>";
              echo "<li><a href='login.php'>Log In</a></li>";
            }
           ?>
          </ul>
       </div>
      </nav>
    </header>