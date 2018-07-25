<?php
// Include config file
require_once 'config.php';

// Initialize the session
session_start();

$page = $_SESSION['page'] = htmlspecialchars($_GET["page"]);
    
if ($page == '#viewQuizzes' OR $page == '#editQuizzes'){
    $sql = "SELECT DISTINCT quiz FROM questions";
    if($stmt = $mysqli->prepare($sql)){
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Store result
            $stmt->store_result();

            $stmt->bind_result($quiz);
            echo '<div class="dropdown">
              <button class="btn btn-primary dropdown-toggle" type="button" id="quizzesMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Quizzes
                 <i class="fas fa-caret-down"></i>
              </button>
              <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            while($stmt->fetch()){
                echo '<a class="dropdown-item" id="'.$quiz.'">'.$quiz.'</a>';
            }
            echo '</div>
                  </div>';
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
} elseif ($page == '#editQuizzes') { 
    echo '<form class="form-login" action="" method="post">
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
      <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
      <span class="help-block"><?php echo $login_err; ?></span>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>';
}elseif ($page == '#about') {
    echo "<h2>About Us</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>";
} elseif ($page == '#contact') {
    echo "<h2>Contact Us</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>";
} else {
    echo "<h2>WebbiSkools Quiz Manager</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>";
}
?>