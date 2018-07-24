<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

// Function to create the dynamic error message
function errorMessage($input, $message) {
    if ($input == 'username') {
        global $username_err;
        $username_err = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> ' . $message . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                         </div>';
    } elseif ($input == 'password') {
        global $password_err;
        $password_err = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> ' . $message . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                         </div>';
    } else {
        global $confirm_password_err;
        $confirm_password_err = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error:</strong> ' . $message . '
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>';
    }
}
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        //$username_err = "Please enter a username.";
        errorMessage('username', 'Please enter a username.');
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // store result
                $stmt->store_result();
                
                if($stmt->num_rows == 1){
                    //$username_err = "This username is already taken.";
                    errorMessage('username', 'This username is already taken.');
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Validate password
    if(empty(trim($_POST['password']))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST['password'])) < 6){
        //$password_err = "Password must have atleast 6 characters.";
        errorMessage("password", "This username is already taken.");
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        //$confirm_password_err = 'Please confirm password.';
        errorMessage("confirm", "Please confirm password.");     
    } else{
        $confirm_password = trim($_POST['confirm_password']);
        if($password != $confirm_password){
            //$confirm_password_err = 'Password did not match.';
            errorMessage("confirm", "Password did not match."); 
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">

    <!-- Custom styles for this page -->
    <link href="css/register.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="SQicon.ico">

    <title>Register - SQ</title>
  </head>
  <body class="text-center">
    <form class="form-register" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <img class="mb-4" src="SQicon.ico" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Sign up</h1>
        <div class="<?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
          <label for="inputUsername" class="sr-only">Username</label>
          <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>" required autofocus>
          <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="<?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" value="<?php echo $password; ?>" required>
          <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="<?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
          <label for="inputConfirm" class="sr-only"> Confirm Password</label>
          <input type="password" id="inputConfirm" name="confirm_password" class="form-control" placeholder="Re-enter Password" value="<?php echo $confirm_password; ?>" required>
          <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
      <button class="btn btn-lg btn-primary" type="submit" value="Submit">Submit</button>
      <button class="btn btn-lg btn-secondary" type="reset" value="Reset">Reset</button>
      <p>Already have an account? <a href="login.php">Login here</a>.</p>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>    
  </body>
</html>