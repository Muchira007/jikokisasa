<!DOCTYPE html>
<html>
  <head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
    
    <style>
 {
      padding: 10;
      margin: 0;
      font-family: 'Poppins', sans-serif;
  }
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
.container {
  border-radius: 5px;
  background-color: #f2f2f2;
  padding: 20px;
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
<script>
		function validateForm() {
			var User_Name = document.getElementById("username").value;
			var Password = document.getElementById("password").value;
			if ( User_Name == "myusername" && Password == "mypassword") {
				//window.location.href = "home.html";
			} else {
				alert("Incorrect username or password. Please try again.");
			}
		}
	</script>
  </head>
  <body>
    <?php
session_start();

// set database connection variables
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jiko_kisasa_db";

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // get form data
    $User_Name = $_POST["username"];
    $Password = $_POST["password"];

    // prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM admin1 WHERE (User_Name = ?"));
    $stmt->bind_param("si", $User_Name, $Password);
    $stmt->execute();
    $result = $stmt->get_result();

    // check if username exists in database
    if ($result->num_rows == 1) {
        // get user data from database
        $row = $result->fetch_assoc();
        $hashed_password = $row["password"];

        // check if password is correct
        if (password_verify($Password, $hashed_password)) {
            // set session variables
            $_SESSION["user_id"] = $row["user_id"];
            $_SESSION["username"] = $row["username"];

            // redirect to index.php
            //header("Location: index.php");
            exit();
        } else {
            // password is incorrect
            $error = "Invalid password.";
        }
    } else {
        // username does not exist in database
        $error = "Invalid username.";
    }
    // Check if the query was successful
    if ($stmt->affected_rows === 1) {
      echo "
      <script>
      alert('Data inserted successfully');
      window.location.href='adminlogin.php';
      </script>
      ";
  } else {
      echo "Error: " . $conn->error;
  }

    // close statement
    $stmt->close();
}

// close connection
$conn->close();
?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/signature_pad/1.3.5/signature_pad.min.js" integrity="sha512-kw/nRM/BMR2XGArXnOoxKOO5VBHLdITAW00aG8qK4zBzcLVZ4nzg7/oYCaoiwc8U9zrnsO9UHqpyljJ8+iqYiQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <form action="login.php" method="post">
    <div class="container" style="background-color: whitesmoke;margin-top:150px;">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username"><br>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password"><br>

      <input type="submit" value="Login">
    </form>
  </body>
</html>
