<?php
session_start();

include("connection.php");
include("functions.php");


if ($_SERVER['REQUEST_METHOD'] == "POST") {
	//something was posted
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirm_password'];
	$contact = $_POST['contact'];

	if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($password) && !empty($contact) && !is_numeric($first_name) && $password == $confirm_password) {

		//save to database
		$user_id = random_num(20);
		$query = "insert into users (user_id,first_name,last_name,email,password,contact) values ('$user_id','$first_name','$last_name','$email','$password','$contact')";

		mysqli_query($con, $query);

		header("Location: login.php");
		die;
	} else {
		if (empty($first_name)) {
			echo '<script>alert("Please Enter valid first name")</script>';
		}
		elseif (empty($last_name)) {
			echo '<script>alert("Please Enter valid last name")</script>';
		}
		elseif (empty($email)) {
			echo '<script>alert("Please Enter valid email")</script>';
		}
		elseif (empty($password)) {
			echo '<script>alert("Please Enter valid password")</script>';
		}
		elseif (empty($contact)) {
			echo '<script>alert("Please Enter valid contact")</script>';
		}
		elseif ($password != $confirm_password) {
			echo '<script>alert("Password not matching")</script>';
		}
	}
}
?>


<!DOCTYPE html>
<html>

<head>
	<title>Signup</title>
</head>

<body>

	<style type="text/css">
		#text {

			height: 25px;
			border-radius: 5px;
			padding: 4px;
			border: solid thin #aaa;
			width: 100%;
		}

		#button {

			padding: 10px;
			width: 100px;
			color: white;
			background-color: lightblue;
			border: none;
		}

		#box {

			background-color: grey;
			margin: auto;
			width: 300px;
			padding: 20px;
		}
	</style>

	<div id="box">

		<form method="post">
			<div style="font-size: 20px;margin: 10px;color: white;">Signup</div>

			<input id="text" type="text" name="first_name" placeholder="First Name *"><br><br>
			<input id="text" type="text" name="last_name" placeholder="Last Name *"><br><br>
			<input id="text" type="email" name="email" placeholder="email * e.g. abc@gmail.com"><br><br>
			<input id="text" type="password" name="password" placeholder="enter password *"><br><br>
			<input id="text" type="password" name="confirm_password" placeholder="confirm password *"><br><br>
			<input id="text" type="text" name="contact" pattern="[0-9]{10}" placeholder="mobile_no (It should be 10 digit) *"><br><br>

			<input id="button" type="submit" value="Signup"><br><br>

			<a href="login.php">Click to Login</a><br><br>
		</form>
	</div>
</body>

</html>