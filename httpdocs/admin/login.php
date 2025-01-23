<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Pochtron</title>
	<link rel="stylesheet" href="assets/css/app.css">
</head>

<body class="admin login">

	<div id="app">
		<main class="site-main">
			<section class="login-box">
				<h1>Welcome Back</h1>
				<p>Don’t have an account yet? <a href="#">Sign up</a></p>

				<form method="POST" action="list.php" novalidate>
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

</body>
</html>
