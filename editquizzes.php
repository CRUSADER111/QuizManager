<?php
// Include config file
require_once 'config.php';

// Initialize the session
session_start();

// Get AJAX data
$quizName = htmlspecialchars($_GET["quiz"]);

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
            echo "string";
        }
    }
}
?>