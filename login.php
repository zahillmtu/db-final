<?php include("connect.php");

    $dbh = connect();

    try {
        // get the pass from the db and make sure it matches
        $sql = "SELECT password FROM Student WHERE id = :user";
        $stmt = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $user = $_POST["loginuser"];
        echo 'The user: ' . $user;
        $stmt->execute(array(':user' => $user));
        $userpass = $stmt->fetchAll();
        if (count($userpass) == 0)
        {
            echo '<br/>Login Failed!';
            die();
        }
        echo '<br />';
        // check if password matches
        if (strcmp($userpass[0]["password"], $_POST["loginpass"]) == 0) {
            echo '<br/>Login Successful!';
            $_SESSION['student_id'] = $user;
        }
        else {
            echo '<br/>Login Failed!';
            die();
        }


        // if the code didn't die, login was successful, log in and get exam
        $sql = "SELECT exam_name, grade FROM Takes WHERE student_id = :id";
        $stmt = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(':id' => $user));
        $results = $stmt->fetchAll();
        if (count($results) == 0)
        {
            echo '<br /> User '. $user . ' has no exams.';
            die();
        }
        echo '<form action="take_exam.php" method="post">';
        for ($i = 0; $i < count($results); $i++)
        {
            if (is_null($results[$i]["grade"])) {
                echo '<br /> <input type="radio" name="exam" value= "' . $results[$i]["exam_name"] . '"/>';
                echo ' ' . $results[$i]["exam_name"];
            }
        }
        echo '<br /><input type="submit" value="Take Selected Exam">';
        echo '</form>';

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    

?>
