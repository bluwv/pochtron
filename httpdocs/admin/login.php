<?php

session_start();

if ( ! empty( $_SESSION ) && $_SESSION['token'] ) {
	header('Location: list.php');
}

require_once '../../app/database.php';

if ( ! empty( $_POST ) ) {
	// $_SESSION["login"] = $_POST['login'];
	$sql = "SELECT id, login, password
		FROM users
		WHERE login = :login OR email = :email";

	$stmt = $db->prepare($sql);

	$value = array(':login' => $_POST['username'], ':email' => $_POST['username']);

	$stmt->execute( $value );
	$user = $stmt->fetch();

	if (password_verify($_POST['password'], $user->password)) {
		$_SESSION['user_id'] = $user->id;
		$_SESSION['login'] = $user->login;
		$_SESSION['token'] = time() + 60 * 60 * 24 * 2;

		header('Location: list.php');
	}
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pochtron</title>
	<link rel="stylesheet" href="assets/css/app.css">
</head>

<body class="login">

	<div id="app">
		<main class="site-main">
			<section class="login-box">
				<h1>Welcome Back</h1>
				<p>Don’t have an account yet? <a href="#">Sign up</a></p>

				<form method="POST" action="" novalidate>
					<div class="form-row">
						<label for="username">email address</label>
						<input id="username" type="email" name="username" placeholder="name@gmail.com" required>
					</div>

					<div class="form-row">
						<label for="password">password</label>
						<input  id="password" type="password" name="password" placeholder="******" required>
					</div>

					<!-- <input type="submit" value="Login"> -->
					<button type="submit">Login</button>
				</form>

				<a class="link-reset-password" href="#">I lost password</a>
			</section>
		</main>
	</div>

	<script src="assets/js/app.js"></script>
</body>
</html>
