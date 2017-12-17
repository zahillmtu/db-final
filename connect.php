<?php
function connect()
{
    session_start();

    if(! isset($_SESSION['username'])) {
        $_SESSION['username'] = $_POST['username'];
    }
    if(! isset($_SESSION['password'])) {
        $_SESSION['password'] = $_POST['password'];
    }

    try {

    $servername = "classdb.it.mtu.edu";
    $username = $_SESSION['username'];
    $password = $_SESSION['password'];
    $dbh = new PDO('mysql:host=classdb.it.mtu.edu;dbname=zahill', $username, $password);

    return $dbh;     

    } catch (PDOException $e) {
        print "Error! " . $e->getMessage()."<br />";
        die();
    }
}

?>
