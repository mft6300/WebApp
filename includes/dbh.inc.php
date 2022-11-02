<?php
$serverName = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "medical_clinic_2";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}