<?php
// Include config file
require_once 'config.php';

$quizName = htmlspecialchars($_GET["quiz"]);
//$q_array = array();

if ($_SERVER["REQUEST_METHOD"]){
    //$quiz = htmlspecialchars($_SESSION['quiz']);
    $sql = "SELECT questionID, question, answerID FROM questions WHERE quiz = ?";
    if($stmt = $mysqli->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bind_param("s", $param_quiz);
        // Set parameters
        $param_quiz = $quizName;

        // Attempt to execute the prepared statement
        if($stmt->execute()){
            // Store result
            $stmt->store_result();

            $stmt->bind_result($q_array['$questionID'], $q_array['$question'], $q_array['$answerID']);
            $j=$stmt->num_rows;
                for ($i=0;$i<$j;$i++){
                    $stmt->data_seek($i);
                    $stmt->fetch();
                    foreach ($q_array as $key=>$value){
                        $result[$i][$key]=$value;
                    }
                }
                // print_r($result);
                echo '<div class="table-responsive">';
                echo '<table class="table">';
                echo '<thead>';
                foreach ($result as $key => $value) {
                	echo "<tr>";
                        echo '<th>'.$value['$questionID'].'</th>';
                        echo '<th>'.$value['$question'].'</th>';
                    echo "</tr>";
                }
                echo "</thead>";
                echo "</table>";
                echo '</div>';
            // echo '<div class="table-responsive">';
            // while($stmt->fetch()){
            //     echo '<table class="table">';
            //     echo '<thead>';
            //         echo "<tr>";
            //             echo "<th>$questionID</th>";
            //             echo "<th>$question</th>";
            //         echo "</tr>";
            //     //for($i=0; $i<2; $i++){    
            //     //}
            //     echo "</thead>";
            //     echo "</table>";
            // }
            // echo '</div>';
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }   
}

?>