<?php include("connect.php");

    $dbh = connect();

    try {
        // get the pass from the db and make sure it matches
        $sql = "SELECT password FROM User WHERE username = :user";
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
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
        
    


?>
