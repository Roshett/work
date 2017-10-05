<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Бот расписания</title>
</head>
<body>
	<h1>Расписание пар</h1>
	<form action="index.php" method="post">
		<input type="submit" name="someData">
	</form>
</body>
</html>
<?php 
	require('inc/db_connect.php');
	if (isset($_POST['someData'])){
		echo "Button is working!";
		// $usi = '321';
		// $check = 'SELECT numgroup FROM users WHERE userid = '.$usi;
 	// 	$check = $pdo->query($check);
 	// 	$check = $check->fetch();
 	// 	echo $check['numgroup'];
	}
 ?>