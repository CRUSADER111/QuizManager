<?php
// Include config file
require_once 'config.php';

// Initialize the session
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $questionID = $_SESSION['questionID'] = htmlspecialchars($_POST["questionID"]);
    $question = $_SESSION['question'] = htmlspecialchars($_POST["question"]);
    $answerID = $_SESSION['answerID'] = htmlspecialchars($_POST["answerID"]);
    $answer = $_SESSION['answer'] = htmlspecialchars($_POST["answer"]);
    $deleteCheck = $_SESSION['deleteCheck'] = htmlspecialchars($_POST["deleteCheck"]);
    echo $question;
    echo 'The check is: '.$deleteCheck;
}

if ($_SERVER["REQUEST_METHOD"] == "GET"){
    // Get AJAX data
    // $quiz = htmlspecialchars($_SESSION['quiz']);
    // if (!empty($_SESSION['deleteCheck']) OR !empty($_SESSION['question'])) {
    //     echo 'The check is: '.$_SESSION['deleteCheck'];
    //     echo  $_SESSION['question'];
    // }
    
    $quizName = $_SESSION['quiz'] = htmlspecialchars($_GET["quiz"]);
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
            
            $stmt->free_result();
            $stmt->close();
            $mysqli->close();
            echo '<div class="container">';
            
            foreach ($result as $key => $value) {
                $questionID = $value['$questionID'];
                if ($questionID == $value['$questionID'] && $i != $questionID) {
                    echo '<form id="editQuestions'.$value['$questionID'].'" method="POST">
                            <input type="number" class="form-control" name="originalID" value="'.$value['$questionID'].'" hidden>
                            <input type="number" class="form-control" min="1" id="question'.$value['$questionID'].'" name="questionID" placeholder="Question ID" value="'.$value['$questionID'].'" required autofocus>
                            <input type="text" class="form-control" id="question'.$value['$questionID'].'" name="question" placeholder="Question" value="'.$value['$question'].'" required>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                          <label>Delete?
                                          <input type="checkbox" class="form-control" id="question'.$value['$questionID'].'" name="deleteCheck" value="Delete">
                                          </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-lg btn-primary" id="update">Update</button>
                                </div>
                                </form>';

                    $i = $value['$questionID'];
                    foreach ($result as $key => $value) {
                        if ($questionID == $value['$questionID'] && ($_SESSION['permissionlevel'] == 'Edit' OR $_SESSION['permissionlevel'] == 'View')) {
                            echo '<form id="editAnswers'.$value['$answerID'].'" method="POST">
                                <input type="text" name="originalID" value="'.$value['$answerID'].'" hidden>
                                <select class="form-control" name="answerID" form="editAnswers">
                                        <option value="'.$value['$answerID'].'" selected>'.$value['$answerID'].'</option>
                                        <option value="A">A</option>
                                        <option value="B">B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                        <option value="E">E</option>
                                    </select>
                                <input type="text" class="form-control" id="answer'.$value['$answerID'].'" name="answer" placeholder="Answer" value="'.$value['$answer'].'" required>
                                <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                              <label>Delete?
                                              <input type="checkbox" class="form-control" id="answer'.$value['$answerID'].'" name="deleteCheck" value="Delete">
                                              </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-lg btn-primary" id="update">Update</button>
                                    </div>
                                </form>';
                        }
                    }
                } 
            }echo '</div>';
            
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}
?>