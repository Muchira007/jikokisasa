<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>jiko kisasa program</title>
   <link rel="stylesheet" href="style.css">
   
    <style>
      body {
          scroll-behavior: smooth;
          display: flex;
          align-items: center;
          justify-content: center;
          height: 100vh;
          width: 100vw;
          background: rgba(0, 128, 0, 0.3);
          overflow-y: scroll;
      }
      .flex-row {
          display: flex;
      }
      .wrapper {
          border: 1px solid #4b00ff;
          border-right: 0;
      }
      
    
      *{
      box-sizing: border-box;
      }

      input[type=text], select, textarea {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
      }

      label {
        padding: 12px 12px 12px 0;
        display: inline-block;
      }

      input[type=submit] {
        background-color: #04AA6D;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        float: right;
      }
      /* Hide the default checkbox */
      input[type="checkbox"] {
                display: none;
            }

            /* Create a custom checkbox appearance */
            .custom-checkbox {
                display: inline-block;
                width: 18px;
                height: 18px;
                background-color: #eee;
                border-radius: 3px;
                position: relative;
                vertical-align: middle;
                margin-right: 7px;
            }

            /* Create a custom checkmark */
            .custom-checkbox::after {
                content: "";
                position: absolute;
                display: none;
            }

            /* Show the checkmark when the checkbox is checked */
            input[type="checkbox"]:checked + .custom-checkbox::after {
                display: block;
            }

            /* Style the checkmark */
            .custom-checkbox::after {
                left: 6px;
                top: 2px;
                width: 5px;
                height: 10px;
                border: solid #000;
                border-width: 0 2px 2px 0;
                transform: rotate(45deg);
            }

      .container {
        border-radius: 10px;
        background-color: #f2f2f2;
        padding: 60px;
        height: 500px;
        overflow: auto;
      
      }

      .col-25 {
        float: left;
        width: 25%;
        margin-top: 6px;
      }

      .col-75 {
        float: left;
        width: 75%;
        margin-top: 6px;
      }

      /* Clear floats after the columns */
      .row:after {
        content: "";
        display: table;
        clear: both;
      }

      /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
      @media screen and (max-width: 600px) {
        .col-25, .col-75, input[type=submit] {
          width: 100%;
          margin-top: 0;
        }
      }
    </style>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.5/signature_pad.min.js" integrity="sha512-kw/nRM/BMR2XGArXnOoxKOO5VBHLdITAW00aG8qK4zBzcLVZ4nzg7/oYCaoiwc8U9zrnsO9UHqpyljJ8+iqYiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
      const form = document.querySelector('form');
      form.addEventListener('submit', function(event) {
        event.preventDefault();
        const name = document.getElementById('name').value;
        const phone = document.getElementById('phone').value;
        const id = document.getElementById('id').value;
        const jiko = document.getElementById('jiko no').value;
        const household = document.getElementById('household no').value;
        const county = document.getElementById('county');
        const  sub_county = document.getElementById('sub_county');
        const Ward = document.getElementById('Ward');
        const  Village = document.getElementById('Village');
        const  demo = document.getElementById('demo');
        const myCheckbox = document.getElementById('myCheckbox');
        console.log(name, phone, id, jiko, household, county, sub_county, Ward, Village, demo, myCheckbox );

      });

      // get current location
          function getLocation() {
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(showPosition);
              
            } else {
              alert("Geolocation is not supported by this browser.");
            }
          }
          function showPosition(position) {
            let lat = position.coords.latitude;
            let lon = position.coords.longitude;
            document.getElementById('long').placeholder = "Longitude";
            document.getElementById('lati').placeholder = "Latitude";
            
            document.getElementById('long').value = lat;
            document.getElementById('lati').value=lon;
            
          }
        </script>

  </head>
  <body>  

    <?php
      // Connect to the database
      $servername = "localhost";
      $dbname = "jiko_kisasa_db";
      $dbuser = 'root';
      $dbpass = '';

      // Create a connection
      $conn = new mysqli($servername, $dbuser, $dbpass, $dbname);

      // Check if the connection is successful
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      } 
      
      // Check if the connection is successful
      if ($conn->connect_error) {
          die("Connection failed: ". $conn->connect_error);
      }

      if(isset($_POST['Submit'])){
    // Get the data from the form
      $User_Names = $_POST['username'];
      $national_ID = $_POST['NatId'];
      $Phone_Number = $_POST['PhoneNumber'];
      $Jiko_Number = $_POST['JikoNumber'];
      $Household_Number = $_POST['HouseHold'];
      $county = $_POST['county'];
      $sub_county = $_POST['sub_county'];
      $ward = $_POST['ward'];
      $village = $_POST['village'];
      $latitude = $_POST['Latitude'];
      $longitude = $_POST['Longitude'];
      $T_C = $_POST['myCheckbox'];
      
      // Prepare the SQL query
      $query = "INSERT INTO users1(latitude, longitude, User_Names, national_ID, Phone_number, Jiko_Number, Household_Number, county, sub_county, ward, village, T_C) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ddsiiiissssi", $latitude,$longitude,$User_Names, $national_ID, $Phone_Number,$Jiko_Number,$Household_Number,$county,$sub_county,$ward,$village,$T_C);

      // Execute the query
      $stmt->execute();

      // Check if the query was successful
      if ($stmt->affected_rows === 1) {
          echo "
          <script>
          alert('Data inserted successfully');
          window.location.href='index.php';
          </script>
          ";
      } else {
          echo "Error: " . $conn->error;
      }

      // Close the connection
      $stmt->close();
      $conn->close();
      }
    ?>

    <form action="" method="post">
      <div class="container" style="background-color: whitesmoke;margin-top:0px;">
        <h3> Jiko kisasa </h3>
              <!--  button for initiating function get location-->
        <button onclick="getLocation()">Get Location</button>
            <input type="text" id="long" name="Longitude" value=""/>
              <br>
            <input type="text" id="lati" name="Latitude" value=""/>
              <br>  
            <p id="demo" name="Location" required></p><br>

        <label>Name:</label><br>
            <input type="text" id="name" name="username" required><br>
        <label>Phone Number:</label><br>
            <input type="tel" id="phone" name="PhoneNumber"required><br>
        <label>national_ID:</label><br>
            <input type="text" id="id" name="NatId" required><br>
        <label>jiko number:</label><br>
            <input type="text" id="jiko no" name="JikoNumber" required><br>
        <label>household number:</label><br>
            <input type="text" id="household no" name="HouseHold" required><br>
        <label for="county">county</label><br>
            <input type="text" id="county" name="county" list="values">
              <datalist id="values">
                <option value="Value 1">
                <option value="Value 2">
                <option value="Value 3">
                <option value="Value 4">
                <option value="Value 5">
              </datalist><br>
        <label for="sub-county">sub-county</label><br>
            <input type="text" id="sub_county" name="sub_county" list="values">
              <datalist id="values">
                <option value="Value 1">
                <option value="Value 2">
                <option value="Value 3">
                <option value="Value 4">
                <option value="Value 5">
              </datalist><br>
        <label for="Ward">Ward</label><br>
            <input type="text" id="Ward" name="ward" list="values">
              <datalist id="values">
                <option value="Value 1">
                <option value="Value 2">
                <option value="Value 3">
                <option value="Value 4">
                <option value="Value 5">
              </datalist><br>
        <label for="Village">Village</label><br>
            <input type="text" id="Village" name="village" list="values">
              <datalist id="values">
                <option value="Value 1">
                <option value="Value 2">
                <option value="Value 3">
                <option value="Value 4">
                <option value="Value 5">
            </datalist><br><br> 
        <!-- terms and condition checkbox-->      
        <label for="myCheckbox">do you accept the terms and agreements:
          <input type="checkbox" id="myCheckbox" name="myCheckbox" value="checked">
          <span class="custom-checkbox"></span>
        </label>
        <input type="submit" name="Submit" value="save "> 

      </div>   

    </form>
    
  </body>
</html>