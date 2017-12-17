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
        }
        else {
            echo '<br/>Login Failed!';
            die();
        }


        // if the code didn't die, login was successful, log in and get exam
        $sql = "SELECT exam_name FROM Takes WHERE student_id = :id";
        $stmt = $dbh->prepare($sql, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        $stmt->execute(array(':id' => $user));
        $results = $stmt->fetchAll();
        if (count($results) == 0)
        {
            echo '<br /> User '. $user . ' has no exams.';
            die();
        }
        for ($i = 0; $i < count($results); $i++)
        {
            echo '<br /> Exam: ' . $results[$i]["exam_name"];
        }


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    

?>
