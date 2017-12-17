<?php include("connect.php"); include("show.php");

    $dbh = connect();

    $exam = $_SESSION['exam'];     

    try {
        $sql = "SELECT question_id, correct_choice, points FROM Questions WHERE exam_name = :exam";
        $stmt = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(':exam' => $exam));
        $results = $stmt->fetchAll();

        $grade_sql = "INSERT INTO Answers VALUES (:sid, :exam, :qid, :cid, :score)";
        $grade_stmt = $dbh->prepare($grade_sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));

        $total_score = 0;

        for ($i = 0; $i < count($results); $i++)
        {
            echo 'question id: ' . $results[$i]['question_id'];
            echo ' choice: ' . $_POST[$results[$i]['question_id']];
            if (strcmp($results[$i]['correct_choice'], $_POST[$results[$i]['question_id']]) == 0) {
                echo ' CORRECT! <br />';
                $grade_stmt->execute(array(':sid' => $_SESSION['student_id'], ':exam' => $exam, 
                                            ':qid' => $results[$i]['question_id'],
                                            ':cid' => $_POST[$results[$i]['question_id']],
                                            ':score' => $results[$i]['points']));
                $total_score = $total_score + $results[$i]['points'];
            } else {
                echo ' INCORRECT! :( <br />';
                $grade_stmt->execute(array(':sid' => $_SESSION['student_id'], ':exam' => $exam, 
                                            ':qid' => $results[$i]['question_id'],
                                            ':cid' => $_POST[$results[$i]['question_id']],
                                            ':score' => 0));
            }
        }

        // now save the final exam score
        $update_sql = "UPDATE Takes SET grade=:points WHERE student_id = :sid AND exam_name = :exam";
        $stmt = $dbh->prepare($update_sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(':points' => $total_score, 
                                ':exam' => $exam,
                                ':sid' => $_SESSION['student_id']));

    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }

    show($dbh, $exam);
?>
