<?php

session_start();

// checking that the necessary values are set
if(!(isset($_SESSION['username']) && isset($_SESSION['password']) && isset($_POST['id']) && isset($_POST['table']))) {
	echo json_encode(array('status'=>'user not logged in or query missing information'));
	exit();
}
//connecting to the database and picking the table to read from
require_once('connect.php');
// preparing the mysql statement
$stmt = mysqli_prepare($conn, "DELETE FROM agenda.$_POST[table] WHERE id=? AND username=?;");
// binding the values in the statement
mysqli_stmt_bind_param($stmt, 'is', $_POST['id'], $_SESSION['username']);
// executing the statement and storing the result
$result = mysqli_stmt_execute($stmt);
// adding a status key to $array to pass information to the output
if($result) {
	$response = 'success';
} else {
	$response = 'delete operation failed';
}
// closing the statement and the connection
mysqli_stmt_close($stmt);
mysqli_close($conn);
// sending back a JSON encoded string
echo $response;

?>