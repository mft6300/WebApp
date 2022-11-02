<?php
session_start();
if (isset($_POST["submit"])) {
	$date = $_POST["adate-time"];
  $doctor = $_POST["doctor"];
  $reason = $_POST["reason"];
  $nurse = //TBD;
  $patient = //TBD;
	$location = //TBD;
	$flag = //TBD;

  require_once "dbh.inc.php";
  require_once "functions.inc.php";

  if (emptyInputAppointment($date, $doctor, $reason) !== false) {
    header("location: ../appointment.php?error=emptyinput");
    exit();
  }
  createAppointment($conn, $fname, $mname, $lname, $ssn, $sex, $bdate, $ethnicity, $race, $streetAdd, $aptNum, $city, $state, $zip);
}
else {
  header("location: ../appointment.php");
  exit();
}
