<?php
  include_once 'header.php';
?>
<div class='dept-form'>
  <h2>Make a Department</h2>
  <form action='/includes/dept.inc.php' method='post'>
    <div class='form-element'>
      <label for='dpt-name'>Enter a Department Name</label>
      <input type='text' name='dptname' id='dpt-name' placeholder='Name'/>
    </div>
    <div class='submit-btn'>
      <button type='submit' name='submit'>Submit</button>
    </div>
  </form>
</div>
<?php
  require_once 'includes/dbh.inc.php';
  require_once 'includes/functions.inc.php';
  $result = viewDepartments($conn);
?>
<div>
  <h2>Departments</h2>
  <table>
    <tr>
      <th>Number</th>
      <th>Name</th>
    </tr>
    <?php
      while ($row = mysqli_fetch_assoc($result)) {
        $depnum = $row["department_number"];
        $depname = $row["dep_name"];
    ?>
      <tr>
        <td><?php echo $depnum?></td>
        <td><?php echo $depname?></td>
      </tr>
    <?php
      }
    ?>
  </table>
</div>
<?php
  include_once 'footer.php';
?>