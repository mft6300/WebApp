  <?php
  include_once 'header.php';
?>
<div class='info-form'>
  <h2>Enter some personal information.</h2>
  <form action='/includes/info.inc.php' method='post'>
      <div class='form-element'>
        <label for='fname'>Enter your First Name</label>
        <input type='text' name='fname' id='fname' placeholder='First Name' required/>
      </div>
      <div class='form-element'>
        <label for='mname'>Enter your Middle Name (Not Required)</label>
        <input type='text' name='mname' id='mname' placeholder='Middle Name'/>
      </div>
      <div class='form-element'>
        <label for='lname'>Enter your Last Name</label>
        <input type='text' name='lname' id='lname' placeholder='Last Name' required/>
      </div>
      <div class='form-element'>
        <label for='ssn'>Enter your SSN</label>
        <input type='text' name='ssn' id='ssn' placeholder='SSN' required/>
      </div>
      <div class='form-element'>
        <label for='sex'>Choose your Gender</label>
        <select name='sex' id='cars' required>
          <option value='male'>Male</option>
          <option value='female'>Female</option>
        </select>
      </div>
      <div class='form-element'>
        <label for='bdate'>Enter your Birth Date</label>
        <input type='date' id='bdate' name='bdate' value='2022-01-01' min='1920-01-01' required/>
      </div>
      <div class='form-element'>
        <label for='ethnicity'>Select your Ethnicity</label>
        <select name='ethnicity' id='ethnicity' required>
          <option value='hl'>Hispanic or Latino</option>
          <option value='nhl'>Not Hispanic or Latino</option>
        </select>
      </div>
      <div class='form-element'>
        <label for='race'>Select your Race</label>
        <select name='race' id='race' required>
          <option value='aian'>American Indian or Alaska Native</option>
          <option value='a'>Asian</option>
          <option value='baf'>Black or African American</option>
          <option value='nhopi'>Native Hawaiian or Other Pacific Islander</option>
          <option value='w'>White</option>
        </select>
      </div>
      <div class='form-element'>
        <label for='street-add'>Enter your Street Address</label>
        <input type='text' name='street-add' id='street-add' placeholder='100 Main St' required/>
      </div>
      <div class='form-element'>
        <label for='apt-num'>Enter your Apt Num</label>
        <input type='text' name='apt-num' id='apt-num' placeholder='123'/>
      </div>
      <div class='form-element'>
        <label for='city'>Enter your City</label>
        <input type='text' name='city' id='city' placeholder='Houston'/>
      </div>
      <div class='form-element'>
        <label for='state'>Select a State</label>
        <select name='state' id='state' required>
          <option value="AL">Alabama</option>
          <option value="AK">Alaska</option>
          <option value="AZ">Arizona</option>
          <option value="AR">Arkansas</option>
          <option value="CA">California</option>
          <option value="CO">Colorado</option>
          <option value="CT">Connecticut</option>
          <option value="DE">Delaware</option>
          <option value="DC">District Of Columbia</option>
          <option value="FL">Florida</option>
          <option value="GA">Georgia</option>
          <option value="HI">Hawaii</option>
          <option value="ID">Idaho</option>
          <option value="IL">Illinois</option>
          <option value="IN">Indiana</option>
          <option value="IA">Iowa</option>
          <option value="KS">Kansas</option>
          <option value="KY">Kentucky</option>
          <option value="LA">Louisiana</option>
          <option value="ME">Maine</option>
          <option value="MD">Maryland</option>
          <option value="MA">Massachusetts</option>
          <option value="MI">Michigan</option>
          <option value="MN">Minnesota</option>
          <option value="MS">Mississippi</option>
          <option value="MO">Missouri</option>
          <option value="MT">Montana</option>
          <option value="NE">Nebraska</option>
          <option value="NV">Nevada</option>
          <option value="NH">New Hampshire</option>
          <option value="NJ">New Jersey</option>
          <option value="NM">New Mexico</option>
          <option value="NY">New York</option>
          <option value="NC">North Carolina</option>
          <option value="ND">North Dakota</option>
          <option value="OH">Ohio</option>
          <option value="OK">Oklahoma</option>
          <option value="OR">Oregon</option>
          <option value="PA">Pennsylvania</option>
          <option value="RI">Rhode Island</option>
          <option value="SC">South Carolina</option>
          <option value="SD">South Dakota</option>
          <option value="TN">Tennessee</option>
          <option value="TX">Texas</option>
          <option value="UT">Utah</option>
          <option value="VT">Vermont</option>
          <option value="VA">Virginia</option>
          <option value="WA">Washington</option>
          <option value="WV">West Virginia</option>
          <option value="WI">Wisconsin</option>
          <option value="WY">Wyoming</option>
        </select>
      </div>
      <div class='form-element'>
        <label for='zip'>Enter your Zip Code</label>
        <input type='text' name='zip' id='zip' placeholder='12345' required/>
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
        if ($_GET["error"] === "invalidssn") {
          echo "<p>Enter a proper SSN.</p>";
        }
        if ($_GET["error"] === "invalidzip") {
          echo "<p>Enter a proper zip code.</p>";
        }
      }
    ?>
</div> 
<?php
  include_once 'footer.php';
?>