<?php include("connect.php");
    
    $dbh = connect();

    try {

        $exam = $_POST["exam"];
        $_SESSION['exam'] = $exam;

        echo 'Exam: ' . $exam . '<br />';

        $sql = "SELECT question_id, points, text, correct_choice FROM Questions WHERE exam_name = :exam";
        $stmt = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(':exam' => $exam));
        $results = $stmt->fetchAll();


        $choice_sql = "SELECT text FROM Choices WHERE choice_id = :cid AND question_id = :qid
                                                        AND exam_name = :exam"; 
        $choice_stmt = $dbh->prepare($choice_sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        if (count($results) == 0)
        {
            echo 'ERROR: Exam has no questions';
            die();
        }
        for ($i = 0; $i < count($results); $i++)
        {
            echo 'Question ' . $results[$i]["question_id"] . ') ';
            echo '&ensp; ' . $results[$i]["text"];
            echo '&ensp; (' . $results[$i]["points"] . ' points) <br />';
            
            $answers_sql = "SELECT student_choice, score FROM Answers WHERE student_id = :sid AND
                                exam_name = :exam AND question_id = :qid";
            $answers_stmt = $dbh->prepare($answers_sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $answers_stmt->execute(array(':sid' => $_SESSION['student_id'],
                                        ':exam' => $exam, ':qid' => $results[$i]["question_id"]));
            $answers = $answers_stmt->fetchAll();

            // get the text for the user choice
            $choice_stmt->execute(array(':cid' => $answers[0]["student_choice"],
                                        ':qid' => $results[$i]["question_id"],
                                        ':exam' => $exam));
            $user_choice = $choice_stmt->fetchAll();

            // get the text for the right answer
            $choice_stmt->execute(array(':cid' => $results[$i]["correct_choice"],
                                        ':qid' => $results[$i]["question_id"],
                                        ':exam' => $exam));
            $correct_choice = $choice_stmt->fetchAll();

            echo 'Your Choice: (' . $answers[0]["student_choice"] . ') '. $user_choice[0]["text"] . '<br />';
            echo 'Correct Choice: (' . $results[$i]["correct_choice"] . ') ' . $correct_choice[0]["text"] . '<br />';
            echo 'Points earned: ' . $answers[0]["score"] . '<br />';
            echo '<br />';
        }

        echo '<hr>';

        $grade_sql = "SELECT grade FROM Takes WHERE student_id = :sid AND exam_name = :exam";
        $grade_stmt = $dbh->prepare($grade_sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $grade_stmt->execute(array(':sid' => $_SESSION['student_id'],
                                    ':exam' => $exam));
        $grades = $grade_stmt->fetchAll();
        $grade = $grades[0]["grade"];

        $points_sql = "SELECT total_points FROM Exam WHERE name = :exam";
        $points_stmt = $dbh->prepare($points_sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $points_stmt->execute(array(':exam' => $exam));
        $points = $points_stmt->fetchAll();
        $total_points = $points[0]["total_points"];

        echo 'You scored ' . $grade . ' out of ' . $total_points . ' points.';


    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
?>
