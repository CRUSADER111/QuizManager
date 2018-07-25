<?php
// Include config file
require_once 'config.php';
 
// Define variables and initialize with empty values
$username = $password = $permissionlevel = "";
$username_err = $password_err = "";
$login_err = "";

// Function to create the dynamic error message
function errorMessage(&$input, $message) {
    $input = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> ' . $message . '
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                         </div>';
}
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        // $username_err = 'Please enter username.';
        errorMessage($username_err, 'Please enter a username.');
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST['password']))){
        // $password_err = 'Please enter your password.';
        errorMessage($password_err, 'Please enter your password.');
    } else{
        $password = trim($_POST['password']);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT username, password, permissionlevel FROM users WHERE username = ?";
        
        if($stmt = $mysqli->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Store result
                $stmt->store_result();
                
                // Check if username exists, if yes then verify password
                if($stmt->num_rows == 1){                    
                    // Bind result variables
                    $stmt->bind_result($username, $hashed_password, $permissionlevel);
                    if($stmt->fetch()){
                        if(password_verify($password, $hashed_password)){
                            /* Password is correct, so start a new session and
                            save the username to the session */
                            session_start();
                            $_SESSION['username'] = $username;
                            $_SESSION['permissionlevel'] = $permissionlevel;     
                            header("location: home.php");
                        } else{
                            // Display an error message if password is not valid
                            //$password_err = 'The password you entered was not valid.';
                            errorMessage($login_err, 'The password and or username entered was not valid.');
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    //$username_err = 'No account found with that username.';
                    errorMessage($login_err, 'The password and or username entered was not valid.');
                }
            } else{
                // echo "Oops! Something went wrong. Please try again later.";
                errorMessage($login_err, 'Oops! Something went wrong. Please try again later.');
            }
        }
        
        // Close statement
        $stmt->close();
    }
    
    // Close connection
    $mysqli->close();
}
?>

<div class="modal fade" id="userAccountModal" tabindex="-1" role="dialog" aria-labelledby="userAccountModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Login Form</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form class="form-login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
              <label for="inputUsername" class="sr-only">Username</label>
              <input type="text" id="inputUsername" name="username" class="form-control" placeholder="Username" value="<?php echo $username; ?>" required autofocus>
              <span class="help-block"><?php echo $username_err; ?></span>
              <label for="inputPassword" class="sr-only">Password</label>
              <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
              <span class="help-block"><?php echo $password_err; ?></span>
              <!-- <div class="checkbox mb-3">
                <label>
                  <input type="checkbox" value="remember-me"> Remember me
                </label>
              </div> -->
              
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
              <span class="help-block"><?php echo $login_err; ?></span>
              <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
              <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
            </form>
          </div>
        </div>
    </div>
</div>