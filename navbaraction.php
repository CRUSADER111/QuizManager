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
            // Bind result to variable
            $stmt->bind_result($quiz);
            echo '<h3>Please select a quiz</h3>';
            echo '<div class="dropdown">';
            echo '<button class="btn btn-primary dropdown-toggle" type="button" id="quizzesMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Quizzes
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">';
            while($stmt->fetch()){
                echo '<a class="dropdown-item" id="'.$quiz.'">'.$quiz.'</a>';
            }
            echo '</div>';
            echo '</div>';
            if ($_SESSION['permissionlevel'] == "Edit" && $page == '#editQuizzes') {
                echo '<button class="btn btn-danger" type="button" id="deleteQuiz" data-toggle="modal" data-target="#confirmAction">Delete Quiz
                        <i class="fas fa-trash-alt"></i>
                        </button>';
            }
            $stmt->free_result();
        $stmt->close();
    $mysqli->close();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
} elseif ($page == '#about') {
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