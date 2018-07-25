<?php
require_once "config.php";

            $sql = "SELECT DISTINCT questions.questionID, questions.question, answers.answerID, answers.answer
                    FROM questions
                    inner Join answers
                    ON questions.questionID = answers.questionID
                                where questions.quiz = ?";
            if($stmt = $mysqli->prepare($sql)){
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("s", $param_quiz);
                // Set parameters
                $param_quiz = "RPA";

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
                    global $i;
                    $i = 0;
                    $stmt->free_result();
                        echo '<div class="table-responsive table-wrapper-scroll-y">';
                        echo '<table class="table">';
                        echo '<thead>';
                        foreach ($result as $key => $value) {
                            global $questionID;
                            $questionID = $value['$questionID'];
                            if ($questionID == $value['$questionID'] && $i != $questionID) {
                                echo "<tr>";
                                    echo '<th>'.$value['$questionID'].'</th>';
                                    echo '<th>'.$value['$question'].'</th>';
                                echo "</tr>";
                                $i = $value['$questionID'];
                                foreach ($result as $key => $value) {
                                    if ($questionID == $value['$questionID']) {
                                        echo "<tr>";
                                            echo '<td>'.$value['$answerID'].'</td>';
                                            echo '<td>'.$value['$answer'].'</td>';
                                        echo "</tr>";
                                    }
                                }
                            }
                        }
                        echo "</thead>";
                        echo "</table>";
                        echo '</div>';
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
            }
?>