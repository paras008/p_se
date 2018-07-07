<?php
	@session_start();
	require 'connection.php';

	$username = $_POST['uname'];
	$password = $_POST['psw'];
	$email = $_POST['email'];

	if (empty($username) || empty($password) || empty($email)) {
		$_SESSION['blank_error'] = 'ભાઈસાહેબ બાપા કરુ, માહેરબાની કરીને વિગત ભર.';
		header('Location:register.php');
		return false;
	}

	$query = "SELECT `name` FROM `se_users` WHERE (`name`= '".$username."' )";
	$result = mysqli_query($conn, $query);
	$no_of_rows = mysqli_num_rows($result);

	if ($no_of_rows == 0) {
		$date = date('Y-m-d H:i:s');
		$sql = "INSERT INTO se_users (name, email, password, updated_at, created_at) VALUES ('$username', '$email', '$password', '$date', '$date')";
		if ($conn->query($sql) === TRUE) {
			$_SESSION['data_inserted'] = 'true';
			header('Location:login.php');
		} else {
			echo "Error: " . $sql . "<br>" . $conn->error;
			header('Location:login.php');
		}
	}
	if ($no_of_rows > 0) {
		// unset($_SESSION['username']);
		$_SESSION['user_error'] = 'તારા જેવો છે કોક બીજો, બીજુ કાંઈક નાખ.';
		header('Location:register.php');
	}
?>