<?php
	session_start();
	require 'connection.php';

	$username = $_POST['uname'];
	$password = $_POST['psw'];

	if (empty($username) || empty($password)) {
		$_SESSION['blank_error'] = 'ભાઈસાહેબ બાપા કરુ, માહેરબાની કરીને વિગત ભર.';
		header('Location:login.php');
		return false;
	}

	$query = "SELECT * FROM `se_users` WHERE (`name`= '".$username."' )";
	$result = mysqli_query($conn, $query);
	$no_of_rows = mysqli_num_rows($result);
	if ($no_of_rows == 1) {
		$row = mysqli_fetch_array($result);
		if ($row['password'] == $password) {
			$_SESSION['username'] = $row['id'];
			header('Location:index.php');
		} else {
			$_SESSION['user_error'] = 'ભુરા પાસવર્ડ ખોટો લાગે છે, હાલ સાચો નાખ.';
			header('Location:login.php');
		}
	} else {
		$_SESSION['user_error'] = 'ભુરા કાંઈક ખોટૂ છે, હાલ સાચું નાખ.';
		header('Location:login.php');
	}
?>
<!-- ભાઈસાહેબ બાપા કરુ, માહેરબાની કરીને વિગત ભર. -->
<!-- ભાઈસાહેબ બાપા કરુ, માહેરબાની કરીને <span style="background-color: #f55; color: #000;">સાચીં</span> વિગત ભર. -->
<!-- તારા જેવો છે કોક, બીજુ કાઈક નાખ. -->