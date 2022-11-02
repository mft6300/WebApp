<?php
session_start();
/*****************SIGNUP*****************/
function emptyInputSignup($email, $phonenum, $username, $password, $passwordRepeat) {
  $result = false;
  if (empty($email) || empty($phonenum) || empty($username) || empty($password) || empty($passwordRepeat)) {
    $result = true;
  }
  return $result;
}

function invalidEmail($email) {
  $result = false;
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $result = true;
  }
  return $result;
}

function invalidPhoneNum($phonenum) {
  $result = false;
  if (!preg_match("/^[0-9]*$/", $phonenum)) {
    $result = true;
  }
  return $result;
}

function invalidUsername($username) {
  $result = false;
  if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    $result = true;
  }
  return $result;
}

function passwordMatch($password, $passwordRepeat) {
  $result = false;
  if ($password !== $passwordRepeat) {
    $result = true;
  }
  return $result;
}
/*****************FUNCT USED FOR SIGNUP AND LOGIN*****************/
function usernameOrEmailExists($conn, $username, $email) {
  $sql = "SELECT * FROM User_Account WHERE (username = ? OR user_email_address = ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../signup.php?error=stmtfailed");
    exit();
  } 

  mysqli_stmt_bind_param($stmt, "ss", $username, $email);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);

  if ($row = mysqli_fetch_assoc($resultData)) {
    return $row;
  }
  else {
    $result = false;
    return $result;
  }
  mysqli_stmt_close($stmt);
}

function createUser($conn, $email, $phonenum, $username, $password) {
  $sql = "INSERT INTO User_Account (username, user_pass, user_phone_num, user_email_address) VALUES (?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../memp.php?error=stmtfailed");
    exit();
  } 
  
  $hashedPass = password_hash($password, PASSWORD_DEFAULT);
  mysqli_stmt_bind_param($stmt, "ssss", $username, $hashedPass, $phonenum, $email);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_close($stmt);
  $userExists = usernameOrEmailExists($conn, $username, $email);
  // session_start();
  $_SESSION["userID"] = $userExists["user_ID"];
  $_SESSION["userRole"] = $userExists["user_role"];
  $_SESSION["userName"] = $userExists["username"];
  header("location: ../info.php");
  exit();
}
/*****************LOGIN*****************/
function emptyInputLogin($username, $password) {
  $result = false;
  if (empty($username) || empty($password)) {
    $result = true;
  }
  return $result;
}

function getPatient($conn, $userID) {
  $sql = "SELECT f_name FROM Patient WHERE pat_user = ?";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../login.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "i", $userID);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($result);
  return $row["f_name"];
}

function loginUser($conn, $username, $password) {
  $userExists = usernameOrEmailExists($conn, $username, $username);
  if (!$userExists) {
    header("location: ../login.php?error=wronglogin");
    exit();
  }
  $hashedPass = $userExists["user_pass"];
  $checkPassword = password_verify($password, $hashedPass);
  if (!$checkPassword) {
    header("location: ../login.php?error=wronglogin");
    exit();
  }
  else {
    // session_start();
    $_SESSION["userID"] = $userExists["user_ID"];
    $_SESSION["userRole"] = $userExists["user_role"];
    $_SESSION["fname"] = getPatient($conn, $userExists["user_ID"]);
    header("location: ../index.php");
    exit();
  }
}
/*****************APPOINTMENT*****************/
function emptyInputAppointment($date, $doctor, $reason) {
  $result = false;
  if (empty($date) || empty($doctor) || empty($reason)) {
    $result = true;
  }
  return $result;
}

/*****************INFO*****************/
function emptyInputInfo($fname, $lname, $ssn, $sex, $bdate, $ethnicity, $race, $streetAdd, $city, $state, $zip) {
  $result = false;
  if (empty($fname) || empty($lname) || empty($ssn) ||empty($sex) ||empty($bdate) ||empty($ethnicity) ||empty($race) ||empty($streetAdd) ||empty($city) ||empty($state) ||empty($zip)) {
    $result = true;
  }
  return $result;
}

function invalidSSN($ssn) {
  $result = false;
  if (!preg_match("/^[0-9]*$/", $ssn)) {
    $result = true;
  }
  return $result;
}

function invalidZip($zip) {
  $result = false;
  if (!preg_match("/^[0-9]*$/", $zip)) {
    $result = true;
  }
  return $result;
}

function addressExists($conn, $streetAdd, $aptNum, $city, $state, $zip) {
  $sql = "SELECT address_ID FROM Address WHERE street_address = ? AND apt_num = ? AND city = ? AND state = ? AND zip_code = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../info.php?error=findaddstmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ssssi", $streetAdd, $aptNum, $city, $state, $zip);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  if ($row = mysqli_fetch_assoc($result)) {
    return $row;
  }
  else {
    $exists = false;
    return $exists;
  }
}

function createPatient($conn, $fname, $mname, $lname, $ssn, $sex, $bdate, $ethnicity, $race, $streetAdd, $aptNum, $city, $state, $zip) {
  $row = addressExists($conn, $streetAdd, $aptNum, $city, $state, $zip);
  if (!$row) {
    //Insert address into DB
    $sql = "INSERT INTO Address (street_address, apt_num, city, state, zip_code) VALUES (?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
      header("location: ../info.php?error=stmtfailed");
      exit();
    }
    mysqli_stmt_bind_param($stmt, "sssss", $streetAdd, $aptNum, $city, $state, $zip);
    mysqli_stmt_execute($stmt);

    //Get address ID of address just inserted
    $sql2 = "SELECT address_ID FROM Address WHERE street_address = ? AND zip_code = ?;";
    $stmt2 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt2, $sql2)) {
      header("location: ../info.php?error=stmtfailed");
      exit();
    }
    mysqli_stmt_bind_param($stmt2, "si", $streetAdd, $zip);
    mysqli_stmt_execute($stmt2);
    $result = mysqli_stmt_get_result($stmt2);
    $row = mysqli_fetch_assoc($result);
  }
  //Insert new patient into DB
  if ($sex === 'male') {
    $sex = 'M';
  }
  else {
    $sex = 'F'; 
  }
  $sql3 = "INSERT INTO Patient (ssn, f_name, m_name, l_name, sex, pat_user, b_date, ethnicity, race, address_ID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
  debug_to_console($sql3);
  $stmt3 = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt3, $sql3)) {
    header("location: ../info.php?error=stmtfailed");
    exit();
  } 
  mysqli_stmt_bind_param($stmt3, "issssisssi", $ssn, $fname, $mname, $lname, $sex, $_SESSION["userID"], $bdate, $ethnicity, $race, $row["address_ID"]);
  mysqli_stmt_execute($stmt3);
  $_SESSION["fname"] = $fname;
  header("location: ../index.php");
  exit();
}

/*****************DEPARTMENT NAME*****************/
function emptyInputDeptName($dptname) {
  $result = false;
  if (empty($dptname)) {
    $result = true;
  }
  return $result;
}

function deptNameExists($conn, $dptname) {
  $sql = "SELECT department_number FROM Department WHERE dep_name = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../dept.php?error=namestmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "s", $dptname);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  if ($row = mysqli_fetch_assoc($result)) {
    return $row;
  }
  else {
    $exists = false;
    return $exists;
  }
}

function createDepartment($conn, $dptname) {
  $sql = "INSERT INTO Department (dep_name) VALUES (?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../dept.php?error=createstmtfailed");
    exit();
  } 
  mysqli_stmt_bind_param($stmt, "s", $dptname);
  mysqli_stmt_execute($stmt);
  header("location: ../dept.php");
  exit();
}

function viewDepartments($conn) {
  $sql = "SELECT * FROM Department;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../dept.php?error=viewstmtfailed");
    exit();
  }
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return $result;
}

/*****************CLINIC ADDRESSES*****************/
function emptyInputClinicAdd($streetAdd, $city, $state, $zip) {
  $result = false;
  if (empty($streetAdd) ||empty($city) ||empty($state) ||empty($zip)) {
    $result = true;
  }
  return $result;
}

function createClinicAdd($conn, $streetAdd, $city, $state, $zip) {
  $officeAdd = 1;
  $sql = "INSERT INTO Address (street_address, city, state, zip_code, office_add) VALUES (?, ?, ?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../info.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "ssssi", $streetAdd, $city, $state, $zip, $officeAdd);
  mysqli_stmt_execute($stmt);
  header("location: ../clinicadd.php");
  exit();
}

function viewClinicLocations($conn) {
  $officeAdd = 1;
  $sql = "SELECT * FROM Address WHERE office_add = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../dept.php?error=viewstmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "i", $officeAdd);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return $result;
}

/*****************OFFICES*****************/
function emptyInputOffice($depnum, $address, $offnum) {
  $result = false;
  if (empty($depnum) ||empty($address) ||empty($offnum)) {
    $result = true;
  }
  return $result;
}

function createOffice($conn, $depnum, $address, $offnum) {
  $officeAdd = 1;
  $sql = "INSERT INTO Office (dep_number, address_ID, phone_number) VALUES (?, ?, ?);";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../info.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "iis", $depnum, $address, $offnum);
  mysqli_stmt_execute($stmt);
  header("location: ../office.php");
  exit();
}

function viewOffices($conn) {
  $sql = "SELECT * FROM Office";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../dept.php?error=viewstmtfailed");
    exit();
  }
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return $result;
}

function getDepartmentName($conn, $depNum) {
  $sql = "SELECT dep_name FROM Department WHERE department_number = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../dept.php?error=viewstmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "i", $depNum);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return $result;
}

function getAddress($conn, $addID) {
  $sql = "SELECT * FROM Address WHERE address_ID = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    header("location: ../info.php?error=stmtfailed");
    exit();
  }
  mysqli_stmt_bind_param($stmt, "i", $addID);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return $result;
}

/*****************DEBUGGING HELPER*****************/
function debug_to_console($data) {
      $output = $data;
      if (is_array($output))
          $output = implode(',', $output);
  
      echo "<script>console.log('Debug Objects: " . $output . "');</script>";
}
  