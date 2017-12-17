<?php include("connect.php");
    
    $dbh = connect();

    try {

        $exam = $_POST["exam"];
        if(! isset($_SESSION['exam'])) {
            $_SESSION['exam'] = $exam;
        }

        echo 'Exam: ' . $exam . '<br />';

        $sql = "SELECT question_id, points, text FROM Questions WHERE exam_name = :exam";
        $stmt = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(':exam' => $exam));
        $results = $stmt->fetchAll();
        if (count($results) == 0)
        {
            echo 'ERROR: Exam has no questions';
            die();
        }
        echo '<form action="grade_exam.php" method="post">';
        for ($i = 0; $i < count($results); $i++)
        {
            echo 'Question ' . $results[$i]["question_id"] . ') ';
            echo '&ensp; ' . $results[$i]["text"];
            echo '&ensp; (' . $results[$i]["points"] . ') <br />';

            $sql = "SELECT choice_id, text FROM Choices WHERE exam_name = :exam AND question_id = :id";
            $stmt = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
            $stmt->execute(array(':exam' => $exam, ':id' => $results[$i]["question_id"]));
            $choices = $stmt->fetchAll();
            for ($j = 0; $j < count($choices); $j++) 
            {
                echo '&emsp;' . $choices[$j]["choice_id"] . ') ' . $choices[$j]["text"];
                echo '&emsp; <input type="radio" name="' . $results[$i]["question_id"] . '"';
                echo ' value ="' . $choices[$j]["choice_id"] . '"> <br />';
            }
        }

        echo '<input type="submit" value="Submit Exam"> <br />';
        echo '</form>';

    } catch (PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }


?>
