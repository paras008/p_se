<?php require 'init.php'; ?>
<?php if (isset($_SESSION['username'])): ?>
	<?php header('Location:index.php'); ?>
<?php endif ?>
<div class="container">
	<?php if ($_SESSION['user_error']): ?>
		<div class="text-center" style="width: 50%; color: #2196f3; font-size: 25px; background-color: #404040; font-weight: 600; margin: 10px auto 20px auto; padding: 10px 0px;">
			<?=$_SESSION['user_error'];?>
			<?php unset($_SESSION['user_error']); ?>
		</div>
	<?php endif ?>
	<?php if ($_SESSION['blank_error']): ?>
		<div class="text-center" style="width: 50%; color: #2196f3; font-size: 25px; background-color: #404040; font-weight: 600; margin: 10px auto 20px auto; padding: 10px 0px;">
			<?=$_SESSION['blank_error'];?>
			<?php unset($_SESSION['blank_error']); ?>
		</div>
	<?php endif ?>
	<form action="create_user.php" method="POST">
		<div class="container" style="width: 40%;">
			<div class="form-group">
				<label for="uname"><b>Username/Name</b></label> (no space or special characters)
				<input class="form-control" type="text" placeholder="Enter Username" name="uname">
			</div>
			<div class="form-group">
				<label for="psw"><b>Password</b></label>
				<input class="form-control" type="password" placeholder="Enter Password" name="psw" required>
			</div>
			<div class="form-group">
				<label for="email"><b>Email</b></label>
				<input class="form-control" type="text" placeholder="Enter Email" name="email" required>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary form-control">Register</button>
			</div>
		</div>
	</form>

</div>