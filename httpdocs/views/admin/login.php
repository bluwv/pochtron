<?php

if ( ! empty( $_SESSION ) && $_SESSION['timeout'] ) {
	header('Location: /admin/wines/list');
	exit();
}

if ( ! empty( $_POST ) ) {
	// $_SESSION["login"] = $_POST['login'];

	$username = htmlentities(trim($_POST['username']), ENT_QUOTES, 'UTF-8');
	$password = htmlentities(trim($_POST['password']), ENT_QUOTES, 'UTF-8');

	$sql = "SELECT id, login, password
		FROM users
		WHERE login = :login OR email = :email";

	$stmt = $db->prepare($sql);

	$value = array(':login' => $username, ':email' => $username);

	$stmt->execute( $value );
	$user = $stmt->fetch();

	if (password_verify($password, $user->password)) {
		$_SESSION['user_id'] = $user->id;
		$_SESSION['login'] = $user->login;
		$_SESSION['timeout'] = time() + 60 * 60 * 24 * 2;

		header('Location: /admin/wines/list');
		exit();
	} else {
		// Wrong password message
	}
}

?>

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
			<input id="password" type="password" name="password" placeholder="******" required>
		</div>

		<!-- <input type="submit" value="Login"> -->
		<button type="submit">Login</button>
	</form>

	<a class="link-reset-password" href="#">I lost password</a>
</section>

<script>
	document.querySelectorAll('[type="password"]').forEach((input) => {
		var toggleButton = document.createElement('button');
		toggleButton.type = 'button';
		toggleButton.textContent = "Afficher/Masquer";

		input.parentNode.insertBefore(toggleButton,input.nextSibling);

		toggleButton.addEventListener("click", function () {
			input.type = input.type === "password" ? "text" : "password";
		});
	});
</script>
