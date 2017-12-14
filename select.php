<html> 
<body> 
<h1>Learning to use php</h1> 
<?php include("connect.php");
callSelect();
?> 

<p>Try to log in with one of the logins</p>

<form action="login.php" method="post">
    <label for="loginuser">Username:</label>
    <input type="text" name="loginuser"><br>
    <label for="loginpass">Password:</label>
    <input type="password" name="loginpass"><br>
    <input type="submit" value="Login">
</form>

</body> 
</html>

<?php 

function callSelect()
{
    $dbh = connect();
    
    foreach ($dbh->query("SELECT * FROM User") as $row) {
        echo $row[0]." ".$row[1];
        echo "<br />";
    }
}
?>

