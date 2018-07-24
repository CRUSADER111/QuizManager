<?php
// Include config file
require_once 'config.php';

$page = $_SESSION['page'] = htmlspecialchars($_GET["page"]);
    
if ($page == '#viewQuizzes'){
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
                echo '<a class="dropdown-item" id="'.$quiz.'" href="#">'.$quiz.'</a>';
            }
            echo '</div>
                  </div>';
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
} elseif ($page == '#about') {
    echo "<h2>About clicked</h2>";
} elseif ($page == '#contact') {
    echo "<h2>Contact clicked</h2>";
} else {
    echo '<h2>WebbiSkools Quiz Manager</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>';
}
?>