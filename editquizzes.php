<?php
// Include config file
require_once 'config.php';

// Initialize the session
session_start();

// Get AJAX data
$quizName = htmlspecialchars($_GET["quiz"]);

if ($_SERVER["REQUEST_METHOD"] == "GET"){
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
            $stmt->close();
		    $mysqli->close();
            echo '<div class="table-responsive table-wrapper-scroll-y">'.
		            '<table class="table">';
		            echo '<thead class="thead-light">'.
	                    	'<tr>'.
		                    	'<th><p>Question/Answer ID</p></th>'.
		                    	'<th><p>Question/Answer</p></th>'.
		                    	'<th><p>Actions</p></th>'.
	                    	'</tr>';
            
            foreach ($result as $key => $value) {
                
                $questionID = $value['$questionID'];
                if ($questionID == $value['$questionID'] && $i != $questionID) {
                    echo '<thead class="thead-light">';
                    echo "<tr>";
                    echo '<form method="POST">';
                    	echo '<td hidden>
                    			<input type="number" name="originalID" value="'.$value['$questionID'].'">
                    		  </td>';
                        echo '<th>
                        		<input type="number" class="form-control" min="1" id="question'.$value['$questionID'].'" name="questionID" placeholder="Question ID" value="'.$value['$questionID'].'" required autofocus>
                        	  </th>';
                        echo '<th>
                        		<input type="text" class="form-control" id="question'.$value['$questionID'].'" name="question" placeholder="Question" value="'.$value['$question'].'" required>
                        	  </th>';
                        echo '<th>
                        		<div class="input-group mb-3">
	                        		<div class="input-group-prepend">
	                        			<div class="input-group-text">
									      <label>Delete?
									      <input type="checkbox" class="form-control" id="question'.$value['$questionID'].'" name="Delete" value="Delete">
									      </label>
								      	</div>
									</div>
									<button class="btn btn-lg btn-primary" type="submit">Update</button>
								</div>
							  </th>';
                        // <label>Delete?<input type="checkbox" class="form-control" id="question'.$value['$questionID'].'" value="Delete"></label><button class="btn btn-lg btn-primary" type="submit">Update</button>
                        
                    echo '</form>';
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";
                    $i = $value['$questionID'];
                    foreach ($result as $key => $value) {
                        if ($questionID == $value['$questionID'] && ($_SESSION['permissionlevel'] == 'Edit' OR $_SESSION['permissionlevel'] == 'View')) {
                            echo "<tr>";
                            	echo '<form id="editAnswers" method="POST">';
                            	echo '<td hidden>
                            			<input type="text" name="originalID" value="'.$value['$answerID'].'">
                            		  </td>';
                                echo '<td>
                            			<select class="form-control" name="answerID" form="editAnswers">
                                			<option value="'.$value['$answerID'].'" selected>'.$value['$answerID'].'</option>
										    <option value="A">A</option>
										    <option value="B">B</option>
										    <option value="C">C</option>
										    <option value="D">D</option>
										    <option value="E">E</option>
										</select></td>';
                                echo '<td>
                                		<input type="text" class="form-control" id="answer'.$value['$answerID'].'" name="answer" placeholder="Answer" value="'.$value['$answer'].'" required>
                                	  </td>';
                                echo '<td>
		                                <div class="input-group mb-3">
			                        		<div class="input-group-prepend">
			                        			<div class="input-group-text">
											      <label>Delete?
											      <input type="checkbox" class="form-control" id="answer'.$value['$answerID'].'" name="Delete" value="Delete">
											      </label>
										      	</div>
											</div>
											<button class="btn btn-lg btn-primary" type="submit">Update</button>
										</div>
									  </td>';
                                echo '</form>';
                            echo "</tr>";
                        }
                    }
                    echo "</tbody>";
                }
                
            }
            echo '</table>'.
	             '</div>';
		    
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>