<?php  
	@session_start();
	require 'connection.php';
	
	$user_id = $_SESSION['username'];
	$query = "SELECT `data` FROM `se_users` WHERE (`id`= '".$user_id."' )";
	$result = mysqli_query($conn, $query);
	$no_of_rows = mysqli_num_rows($result);
	if ($no_of_rows == 1) {
		$data = mysqli_fetch_row($result);
		$decrypt_data = json_decode($data[0], true);
	}

	foreach ($_POST['scripts'] as $key => $value) {
		unset($decrypt_data['watchlist'][$value]);
	}
	$encrypt_data = json_encode($decrypt_data);
	
	$query = "UPDATE `se_users` SET `data` = '".$encrypt_data."'WHERE (`id`= '".$user_id."' )";
	$result = mysqli_query($conn, $query);
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	header('Location:watchlist.php');

?>