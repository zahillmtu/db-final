<?php include("connect.php"); include("show.php");
    $dbh = connect();
    show($dbh, $_POST["exam"]);
?>
