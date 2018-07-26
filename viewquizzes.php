<?php
// Include config file
require_once 'config.php';

// Initialize the session
session_start();

$quizName = $_SESSION['quiz'] = htmlspecialchars($_GET["quiz"]);
global $i;
global $questionID;
$i = 0;

if ($_SERVER["REQUEST_METHOD"]){
    //$quiz = htmlspecialchars($_SESSION['quiz']);
    $sql = "SELECT DISTINCT questions.questionID, questions.question, answers.answerID, answers.answer
            FROM questions
            INNER JOIN answers
            ON questions.questionID = answers.questionID
            WHERE questions.quiz = ? AND answers.quiz = ?";
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("ss", $param_quiz, $param_quiz);
        // Set parameters
        $param_quiz = $quizName;

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Store result
            $stmt->store_result();

            $stmt->bind_result($q_array['$questionID'], $q_array['$question'], $q_array['$answerID'], $q_array['$answer']);
            $j=$stmt->num_rows;
                for ($i=0;$i<$j;$i++){
                    $stmt->data_seek($i);
                    $stmt->fetch();
                    foreach ($q_array as $key=>$value){

                        $result[$i][$key]=$value;
                    }
                }
            //
            $stmt->free_result();
                echo '<div class="table-responsive table-wrapper-scroll-y">';
                echo '<table class="table">';
                
                foreach ($result as $key => $value) {
                    
                    $questionID = $value['$questionID'];
                    if ($questionID == $value['$questionID'] && $i != $questionID) {
                        echo '<thead class="thead-light">';
                        echo "<tr>";
                            echo '<th id="'.$value['$questionID'].'">'.$value['$questionID'].'</th>';
                            echo '<th>'.$value['$question'].'</th>';
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        $i = $value['$questionID'];
                        foreach ($result as $key => $value) {
                            if ($questionID == $value['$questionID'] && ($_SESSION['permissionlevel'] == 'Edit' OR $_SESSION['permissionlevel'] == 'View')) {
                                echo "<tr>";
                                    echo '<td>'.$value['$answerID'].'</td>';
                                    echo '<td>'.$value['$answer'].'</td>';
                                echo "</tr>";
                            }
                        }
                        echo "</tbody>";
                    }
                    
                }
                
                echo "</table>";
                echo '</div>';
        $stmt->close();
        $mysqli->close();
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }   
}
?>